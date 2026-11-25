<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\Designation;
use App\Models\PerformanceTarget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PerformanceTargetController extends Controller
{
    public function index(Request $request)
    {
        $query = PerformanceTarget::with(['designation', 'hospital']);

        if ($request->filled('hospital_id')) {
            $query->where('hospital_id', $request->hospital_id);
        }

        if ($request->filled('designation_id')) {
            $query->where('designation_id', $request->designation_id);
        }

        if ($request->filled('target_type')) {
            $query->where('target_type', $request->target_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $targets = $query->latest()->paginate(20)->withQueryString();

        $hospitals = Hospital::select('id', 'hospital_name')
            ->orderBy('hospital_name')
            ->get();

        $designations = collect();

        if ($request->filled('hospital_id')) {
            $designations = Designation::where('hospital_id', $request->hospital_id)
                ->orderBy('name')
                ->get();
        }
        $targetTypes = [
            'lead_generation',
            'customer_calls',
            'follow_ups',
            'hospital_visits',
            'meetings',
            'conversions',
        ];

        $periods = ['daily', 'weekly', 'monthly'];

        return view('admin.performance-targets.index', compact(
            'targets',
            'hospitals',
            'designations',
            'targetTypes',
            'periods'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hospital_id' => ['required', 'integer', 'exists:hospitals,id'],
            'designation_id' => ['required', 'integer'],
            'target_name' => ['required', 'string', 'max:150'],
            'target_type' => [
                'required',
                'in:lead_generation,customer_calls,follow_ups,hospital_visits,meetings,conversions',
            ],
            'target_quantity' => ['required', 'integer', 'min:1'],
            'target_period' => ['required', 'in:daily,weekly,monthly'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['nullable', 'in:active,inactive'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        $designation = Designation::where('id', $data['designation_id'])
            ->where('hospital_id', $data['hospital_id'])
            ->first();

        if (!$designation) {
            return back()->withErrors([
                'designation_id' => 'Select a designation belonging to the selected hospital.',
            ])->withInput();
        }

        PerformanceTarget::create([
            'hospital_id' => $data['hospital_id'],
            'designation_id' => $designation->id,
            'target_name' => $data['target_name'],
            'target_type' => $data['target_type'],
            'target_quantity' => $data['target_quantity'],
            'target_period' => $data['target_period'],
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'created_by' => Auth::guard('admin')->id(),
            'created_by_type' => 'admin',
            'status' => $data['status'] ?? 'active',
        ]);

        return redirect()
            ->route('admin.performance-targets.index')
            ->with('success', 'Performance target created successfully.');
    }

    public function update(Request $request, $id)
    {
        $target = PerformanceTarget::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'hospital_id' => ['required', 'integer', 'exists:hospitals,id'],
            'designation_id' => ['required', 'integer'],
            'target_name' => ['required', 'string', 'max:150'],
            'target_type' => [
                'required',
                'in:lead_generation,customer_calls,follow_ups,hospital_visits,meetings,conversions',
            ],
            'target_quantity' => ['required', 'integer', 'min:1'],
            'target_period' => ['required', 'in:daily,weekly,monthly'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        $designation = Designation::where('id', $data['designation_id'])
            ->where('hospital_id', $data['hospital_id'])
            ->first();

        if (!$designation) {
            return back()->withErrors([
                'designation_id' => 'Select a designation belonging to the selected hospital.',
            ])->withInput();
        }

        $target->update([
            'hospital_id' => $data['hospital_id'],
            'designation_id' => $designation->id,
            'target_name' => $data['target_name'],
            'target_type' => $data['target_type'],
            'target_quantity' => $data['target_quantity'],
            'target_period' => $data['target_period'],
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'status' => $data['status'],
        ]);

        return redirect()
            ->route('admin.performance-targets.index')
            ->with('success', 'Performance target updated successfully.');
    }

    public function destroy($id)
    {
        $target = PerformanceTarget::findOrFail($id);

        $target->update([
            'status' => 'inactive',
        ]);

        return redirect()
            ->route('admin.performance-targets.index')
            ->with('success', 'Performance target deactivated successfully.');
    }
}