<?php

namespace App\Http\Controllers\StaffApp;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use App\Models\Lead;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class StaffController extends Controller
{
    private function staff()
    {
        return Auth::guard('staff')->user();
    }

    /**
     * Designations this logged-in staff member is allowed to create.
     */
    private function allowedDesignationSlugs($staff): array
    {
        $designation = Designation::where('hospital_id', $staff->hospital_id)
            ->find($staff->designation_id);

        if (!$designation) {
            return [];
        }

        return match ($designation->slug) {
            'trade-marketing' => ['internal-marketing'],
            'corporate-marketing' => ['freelancers-marketing'],
            default => [],
        };
    }

    /**
     * List staff members added by the logged-in staff member.
     */
    public function index()
    {
        try {
            $loggedInStaff = $this->staff();

            if (!$loggedInStaff || !$loggedInStaff->hospital_id) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Staff authentication required.',
                ], 401);
            }

            $staffMembers = Staff::with([
                'department:id,name',
                'designation:id,name,slug',
            ])
                ->where('hospital_id', $loggedInStaff->hospital_id)
                ->where('added_by', $loggedInStaff->id)
                ->where('added_by_type', 'staff')
                ->latest()
                ->get();

            $leadCounts = Lead::selectRaw('assigned_to, COUNT(*) as total')
                ->where('hospital_id', $loggedInStaff->hospital_id)
                ->where('assigned_to_type', 'staff')
                ->whereIn('assigned_to', $staffMembers->pluck('id'))
                ->groupBy('assigned_to')
                ->pluck('total', 'assigned_to');

            $staffMembers->transform(function ($member) use ($leadCounts) {
                $member->assigned_leads_count = (int) ($leadCounts[$member->id] ?? 0);

                return $member;
            });

            return response()->json([
                'success' => 1,
                'message' => 'Staff list fetched successfully.',
                'data' => [
                    'total_staff' => $staffMembers->count(),
                    'total_assigned_leads' => $leadCounts->sum(),
                    'staff' => $staffMembers,
                ],
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'success' => 0,
                'message' => 'Unable to fetch staff.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get only the designations allowed for the logged-in staff member.
     */
    public function designations()
    {
        try {
            $loggedInStaff = $this->staff();

            if (!$loggedInStaff || !$loggedInStaff->hospital_id) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Staff authentication required.',
                ], 401);
            }

            $allowedSlugs = $this->allowedDesignationSlugs($loggedInStaff);

            if (empty($allowedSlugs)) {
                return response()->json([
                    'success' => 0,
                    'message' => 'You are not authorized to add staff.',
                    'data' => [],
                ], 403);
            }

            $designations = Designation::where('hospital_id', $loggedInStaff->hospital_id)
                ->whereIn('slug', $allowedSlugs)
                ->where('is_active', 1)
                ->select('id', 'department_id', 'name', 'slug')
                ->orderBy('name')
                ->get();

            return response()->json([
                'success' => 1,
                'message' => 'Available designations fetched successfully.',
                'data' => $designations,
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'success' => 0,
                'message' => 'Unable to fetch designations.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Add staff member based on logged-in staff designation.
     */
    public function store(Request $request)
    {
        try {
            $loggedInStaff = $this->staff();

            if (!$loggedInStaff || !$loggedInStaff->hospital_id) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Staff authentication required.',
                ], 401);
            }

            $allowedSlugs = $this->allowedDesignationSlugs($loggedInStaff);

            if (empty($allowedSlugs)) {
                return response()->json([
                    'success' => 0,
                    'message' => 'You are not authorized to add staff.',
                ], 403);
            }

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],

                'mobile' => [
                    'required',
                    'string',
                    'max:20',
                    Rule::unique('staff', 'mobile'),
                ],

                'email' => [
                    'nullable',
                    'email',
                    'max:255',
                    Rule::unique('staff', 'email'),
                ],

                'designation_id' => [
                    'required',
                    'integer',
                    Rule::exists('designations', 'id')->where(function ($query) use ($loggedInStaff, $allowedSlugs) {
                        $query->where('hospital_id', $loggedInStaff->hospital_id)
                            ->whereIn('slug', $allowedSlugs)
                            ->where('is_active', 1);
                    }),
                ],

                'gender' => ['nullable', 'in:male,female,other'],
                'date_of_birth' => ['nullable', 'date'],
                'address' => ['nullable', 'string'],
                'joining_date' => ['nullable', 'date'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $validated = $validator->validated();

            $designation = Designation::where('hospital_id', $loggedInStaff->hospital_id)
                ->whereIn('slug', $allowedSlugs)
                ->where('is_active', 1)
                ->findOrFail($validated['designation_id']);

            $newStaff = Staff::create([
                'hospital_id' => $loggedInStaff->hospital_id,
                'department_id' => $designation->department_id,
                'designation_id' => $designation->id,

                'name' => $validated['name'],
                'mobile' => $validated['mobile'],
                'email' => $validated['email'] ?? null,

                'gender' => $validated['gender'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'address' => $validated['address'] ?? null,
                'joining_date' => $validated['joining_date'] ?? null,

                'added_by' => $loggedInStaff->id,
                'added_by_type' => 'staff',

                'status' => 'active',
            ]);

            $newStaff->load([
                'department:id,name',
                'designation:id,name,slug',
            ]);

            return response()->json([
                'success' => 1,
                'message' => 'Staff added successfully.',
                'data' => $newStaff,
            ], 201);

        } catch (Throwable $e) {
            return response()->json([
                'success' => 0,
                'message' => 'Unable to add staff.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * View staff member and their assigned leads.
     */
    public function show($id)
    {
        try {
            $loggedInStaff = $this->staff();

            if (!$loggedInStaff || !$loggedInStaff->hospital_id) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Staff authentication required.',
                ], 401);
            }

            $member = Staff::with([
                'department:id,name',
                'designation:id,name,slug',
            ])
                ->where('hospital_id', $loggedInStaff->hospital_id)
                ->where('added_by', $loggedInStaff->id)
                ->where('added_by_type', 'staff')
                ->findOrFail($id);

            $leads = Lead::with([
                'leadModule',
                'followUps',
                'activities',
            ])
                ->where('hospital_id', $loggedInStaff->hospital_id)
                ->where('assigned_to_type', 'staff')
                ->where('assigned_to', $member->id)
                ->latest()
                ->get();

            $leadSummary = [
                'total' => $leads->count(),
                'new' => $leads->where('status', 'new')->count(),
                'contacted' => $leads->where('status', 'contacted')->count(),
                'interested' => $leads->where('status', 'interested')->count(),
                'follow_up' => $leads->where('status', 'follow_up')->count(),
                'converted' => $leads->where('status', 'converted')->count(),
                'closed' => $leads->where('status', 'closed')->count(),
                'not_interested' => $leads->where('status', 'not_interested')->count(),
            ];

            return response()->json([
                'success' => 1,
                'message' => 'Staff details fetched successfully.',
                'data' => [
                    'staff' => $member,
                    'lead_summary' => $leadSummary,
                    'leads' => $leads,
                ],
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => 0,
                'message' => 'Staff member not found or you do not have permission to view this staff member.',
            ], 404);

        } catch (Throwable $e) {
            return response()->json([
                'success' => 0,
                'message' => 'Unable to fetch staff details.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
