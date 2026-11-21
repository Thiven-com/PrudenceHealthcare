<?php

namespace App\Http\Controllers\StaffApp;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadFollowUp;
use App\Models\LeadActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StaffFollowUpController extends Controller
{
    /**
     * List Follow-ups
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lead_id' => ['nullable', 'integer'],
            'status' => ['nullable', 'in:scheduled,completed,missed,cancelled'],
            'date' => ['nullable', 'date'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $staff = Auth::guard('staff')->user();

        $query = LeadFollowUp::with('lead')
            ->where('hospital_id', $staff->hospital_id)
            ->where('followed_up_by', $staff->id)
            ->where('followed_up_by_type', 'staff')
            ->whereHas('lead', function ($q) use ($staff) {
                $q->where('hospital_id', $staff->hospital_id)
                    ->where('assigned_to', $staff->id)
                    ->where('assigned_to_type', 'staff');
            });

        if ($request->filled('lead_id')) {
            $query->where('lead_id', $request->lead_id);
        }

        if ($request->filled('status')) {
            $query->where('follow_up_status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('follow_up_date', $request->date);
        }

        $followups = $query->latest('follow_up_date')
            ->paginate($request->input('per_page', 15));

        return response()->json([
            'success' => 1,
            'message' => 'Follow-ups fetched successfully.',
            'data' => $followups->items(),
            'pagination' => [
                'current_page' => $followups->currentPage(),
                'last_page' => $followups->lastPage(),
                'per_page' => $followups->perPage(),
                'total' => $followups->total(),
            ],
        ]);
    }

    /**
     * Create Follow-up
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lead_id' => ['required', 'integer'],
            'follow_up_date' => ['required', 'date'],
            'follow_up_type' => ['required', 'string', 'max:100'],
            'discussion' => ['nullable', 'string'],
            'customer_response' => ['nullable', 'string'],
            'remarks' => ['nullable', 'string'],
            'next_follow_up_at' => ['nullable', 'date', 'after:follow_up_date'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $staff = Auth::guard('staff')->user();

        $lead = Lead::where('id', $request->lead_id)
            ->where('hospital_id', $staff->hospital_id)
            ->where('assigned_to', $staff->id)
            ->where('assigned_to_type', 'staff')
            ->first();

        if (!$lead) {
            return response()->json([
                'success' => 0,
                'message' => 'Lead not found or not assigned to you.',
            ], 404);
        }

        $followup = DB::transaction(function () use ($request, $staff, $lead) {

            $followup = LeadFollowUp::create([
                'hospital_id' => $staff->hospital_id,
                'lead_id' => $lead->id,
                'followed_up_by' => $staff->id,
                'followed_up_by_type' => 'staff',
                'follow_up_date' => $request->follow_up_date,
                'follow_up_type' => $request->follow_up_type,
                'follow_up_status' => 'scheduled',
                'discussion' => $request->discussion,
                'customer_response' => $request->customer_response,
                'remarks' => $request->remarks,
                'next_follow_up_at' => $request->next_follow_up_at,
            ]);

            $lead->update([
                'next_follow_up_at' => $request->next_follow_up_at,
            ]);

            LeadActivity::create([
                'hospital_id' => $staff->hospital_id,
                'lead_id' => $lead->id,
                'performed_by' => $staff->id,
                'performed_by_type' => 'staff',
                'activity_type' => 'follow_up_created',
                'title' => 'Follow-up scheduled',
                'description' => $request->remarks,
                'activity_data' => [
                    'follow_up_id' => $followup->id,
                    'follow_up_date' => $request->follow_up_date,
                ],
                'performed_at' => now(),
            ]);

            return $followup;
        });

        return response()->json([
            'success' => 1,
            'message' => 'Follow-up scheduled successfully.',
            'data' => $followup,
        ], 201);
    }

    /**
     * Update Follow-up Status and Discussion
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'follow_up_status' => [
                'required',
                'in:scheduled,completed,missed,cancelled',
            ],
            'discussion' => ['nullable', 'string'],
            'customer_response' => ['nullable', 'string'],
            'remarks' => ['nullable', 'string'],
            'next_follow_up_at' => ['nullable', 'date'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $staff = Auth::guard('staff')->user();

        $followup = LeadFollowUp::where('id', $id)
            ->where('hospital_id', $staff->hospital_id)
            ->where('followed_up_by', $staff->id)
            ->where('followed_up_by_type', 'staff')
            ->whereHas('lead', function ($q) use ($staff) {
                $q->where('assigned_to', $staff->id)
                    ->where('assigned_to_type', 'staff')
                    ->where('hospital_id', $staff->hospital_id);
            })
            ->first();

        if (!$followup) {
            return response()->json([
                'success' => 0,
                'message' => 'Follow-up not found.',
            ], 404);
        }

        DB::transaction(function () use ($request, $staff, $followup) {

            $oldStatus = $followup->follow_up_status;

            $followup->update([
                'follow_up_status' => $request->follow_up_status,
                'discussion' => $request->discussion ?? $followup->discussion,
                'customer_response' => $request->customer_response ?? $followup->customer_response,
                'remarks' => $request->remarks ?? $followup->remarks,
                'next_follow_up_at' => $request->next_follow_up_at,
            ]);

            $followup->lead()->update([
                'next_follow_up_at' => $request->next_follow_up_at,
            ]);

            LeadActivity::create([
                'hospital_id' => $staff->hospital_id,
                'lead_id' => $followup->lead_id,
                'performed_by' => $staff->id,
                'performed_by_type' => 'staff',
                'activity_type' => 'follow_up_updated',
                'title' => 'Follow-up updated',
                'description' => $request->remarks,
                'old_value' => $oldStatus,
                'new_value' => $request->follow_up_status,
                'activity_data' => [
                    'follow_up_id' => $followup->id,
                ],
                'performed_at' => now(),
            ]);
        });

        return response()->json([
            'success' => 1,
            'message' => 'Follow-up updated successfully.',
            'data' => $followup->fresh(),
        ]);
    }

    /**
     * Delete Follow-up
     */
    public function destroy($id)
    {
        $staff = Auth::guard('staff')->user();

        $followup = LeadFollowUp::where('id', $id)
            ->where('hospital_id', $staff->hospital_id)
            ->where('followed_up_by', $staff->id)
            ->where('followed_up_by_type', 'staff')
            ->whereHas('lead', function ($q) use ($staff) {
                $q->where('assigned_to', $staff->id)
                    ->where('assigned_to_type', 'staff')
                    ->where('hospital_id', $staff->hospital_id);
            })
            ->first();

        if (!$followup) {
            return response()->json([
                'success' => 0,
                'message' => 'Follow-up not found.',
            ], 404);
        }

        $followup->delete();

        return response()->json([
            'success' => 1,
            'message' => 'Follow-up deleted successfully.',
        ]);
    }
}
