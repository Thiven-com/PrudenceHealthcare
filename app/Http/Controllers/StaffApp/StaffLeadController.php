<?php

namespace App\Http\Controllers\StaffApp;

use App\Http\Controllers\Controller;
use App\Models\CommunityMember;
use App\Models\CompanyInsuranceEmployee;
use App\Models\Lead;
use App\Models\LeadModule;
use App\Models\LeadActivity;
use App\Models\HospitalModule;
use App\Models\Staff;
use App\Models\StaffPermission;
use App\Models\DoctorLeadDetail;
use App\Models\CommunityLeadDetail;
use App\Models\CompanyHealthInsuranceDetail;
use App\Models\PersonalHealthInsuranceDetail;
use App\Models\CashTreatmentDetail;
use App\Models\CreditTreatmentDetail;
use App\Models\HealthAdvisorDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class StaffLeadController extends Controller
{
    /**
     * Get authenticated active staff.
     */
    private function getStaff()
    {
        $staff = Auth::guard('staff')->user();

        if (!$staff || $staff->status !== 'active') {
            return null;
        }

        return $staff;
    }

    /**
     * Check staff module permission.
     */
    private function hasModulePermission($staff, $moduleId, $permission)
    {
        return StaffPermission::where('hospital_id', $staff->hospital_id)
            ->where('staff_id', $staff->id)
            ->where('lead_module_id', $moduleId)
            ->where($permission, 1)
            ->whereHas('leadModule', function ($query) {
                $query->where('is_active', 1);
            })
            ->whereHas('leadModule.hospitalModules', function ($query) use ($staff) {
                $query->where('hospital_id', $staff->hospital_id)
                    ->where('is_enabled', 1);
            })
            ->exists();
    }

    /**
     * Get modules available to this staff member.
     */
    public function createLeadOptions()
    {
        $staff = $this->getStaff();

        if (!$staff) {
            return response()->json([
                'success' => 0,
                'message' => 'Staff account is unavailable.',
            ], 403);
        }

        $modules = StaffPermission::with('leadModule')
            ->where('hospital_id', $staff->hospital_id)
            ->where('staff_id', $staff->id)
            ->where('can_create', 1)
            ->whereHas('leadModule', function ($query) {
                $query->where('is_active', 1);
            })
            ->whereHas('leadModule.hospitalModules', function ($query) use ($staff) {
                $query->where('hospital_id', $staff->hospital_id)
                    ->where('is_enabled', 1);
            })
            ->get()
            ->map(function ($permission) {
                return [
                    'id' => $permission->leadModule->id,
                    'name' => $permission->leadModule->name,
                    'slug' => $permission->leadModule->slug,
                ];
            })
            ->values();

        return response()->json([
            'success' => 1,
            'message' => 'Assigned lead modules fetched successfully.',
            'data' => $modules,
        ]);
    }

    /**
     * Staff Leads Listing.
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'string'],
            'module' => ['nullable', 'string'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $staff = $this->getStaff();

        if (!$staff) {
            return response()->json([
                'success' => 0,
                'message' => 'Staff account is unavailable.',
            ], 403);
        }

        // Get modules staff is allowed to view.
        $allowedModuleIds = StaffPermission::where(
            'hospital_id',
            $staff->hospital_id
        )
            ->where('staff_id', $staff->id)
            ->where('can_view', 1)
            ->whereHas('leadModule', function ($query) {
                $query->where('is_active', 1);
            })
            ->whereHas('leadModule.hospitalModules', function ($query) use ($staff) {
                $query->where('hospital_id', $staff->hospital_id)
                    ->where('is_enabled', 1);
            })
            ->pluck('lead_module_id');

        $query = Lead::with('leadModule')
            ->where('hospital_id', $staff->hospital_id)
            ->where('assigned_to', $staff->id)
            ->where('assigned_to_type', 'staff')
            ->whereIn('lead_module_id', $allowedModuleIds);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('mobile', 'LIKE', "%{$search}%")
                    ->orWhere('leadcode', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('module')) {
            $query->whereHas('leadModule', function ($q) use ($request) {
                $q->where('slug', $request->module);
            });
        }

        $leads = $query
            ->latest('id')
            ->paginate($request->input('per_page', 15));

        $data = $leads->getCollection()->map(function ($lead) {
            return [
                'id' => $lead->id,
                'leadcode' => $lead->leadcode,
                'name' => $lead->name,
                'mobile' => $lead->mobile,
                'alternate_mobile' => $lead->alternate_mobile,
                'email' => $lead->email,
                'city' => $lead->city,
                'state' => $lead->state,
                'module' => [
                    'id' => $lead->leadModule?->id,
                    'name' => $lead->leadModule?->name,
                    'slug' => $lead->leadModule?->slug,
                ],
                'status' => $lead->status,
                'source' => $lead->source,
                'next_follow_up_at' => $lead->next_follow_up_at,
                'created_at' => $lead->created_at,
            ];
        });

        return response()->json([
            'success' => 1,
            'message' => 'Leads fetched successfully.',
            'data' => $data,
            'pagination' => [
                'current_page' => $leads->currentPage(),
                'last_page' => $leads->lastPage(),
                'per_page' => $leads->perPage(),
                'total' => $leads->total(),
                'from' => $leads->firstItem(),
                'to' => $leads->lastItem(),
            ],
        ], 200);
    }

    /**
     * Lead Details.
     */
    public function show($id)
    {
        $staff = $this->getStaff();

        if (!$staff) {
            return response()->json([
                'success' => 0,
                'message' => 'Staff account is unavailable.',
            ], 403);
        }

        $lead = Lead::with([
            'leadModule',
            'followUps',
            'statusHistories',
            'activities',
        ])
            ->where('hospital_id', $staff->hospital_id)
            ->where('assigned_to', $staff->id)
            ->where('assigned_to_type', 'staff')
            ->find($id);

        if (!$lead) {
            return response()->json([
                'success' => 0,
                'message' => 'Lead not found.',
            ], 404);
        }

        if (
            !$this->hasModulePermission(
                $staff,
                $lead->lead_module_id,
                'can_view'
            )
        ) {
            return response()->json([
                'success' => 0,
                'message' => 'You do not have permission to view this lead.',
            ], 403);
        }
        $moduleDetails = $this->getModuleDetails(
            $lead->leadModule?->slug ?? '',
            $lead->id,
            $staff->hospital_id
        );

        $lead->setAttribute('module_details', $moduleDetails);

        return response()->json([
            'success' => 1,
            'message' => 'Lead details fetched successfully.',
            'data' => $lead,
        ], 200);
    }

    /**
     * Add New Lead.
     */
    public function store(Request $request)
    {
        $staff = $this->getStaff();

        if (!$staff) {
            return response()->json([
                'success' => 0,
                'message' => 'Staff account is unavailable.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'lead_module_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:20'],
            'alternate_mobile' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'pincode' => ['nullable', 'string', 'max:20'],
            'source' => ['nullable', 'string', 'max:100'],
            'remarks' => ['nullable', 'string'],
            'details' => ['required', 'array'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $module = LeadModule::where('id', $request->lead_module_id)
            ->where('is_active', 1)
            ->first();

        if (!$module) {
            return response()->json([
                'success' => 0,
                'message' => 'Invalid lead module.',
            ], 422);
        }

        if (
            !$this->hasModulePermission(
                $staff,
                $module->id,
                'can_create'
            )
        ) {
            return response()->json([
                'success' => 0,
                'message' => 'You do not have permission to create leads in this module.',
            ], 403);
        }

        $detailRules = $this->getModuleDetailRules($module->slug);

        if ($detailRules === null) {
            return response()->json([
                'success' => 0,
                'message' => 'Unsupported lead module.',
            ], 422);
        }

        $detailValidator = Validator::make(
            $request->input('details', []),
            $detailRules
        );

        if ($detailValidator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => 'Module details validation failed.',
                'errors' => $detailValidator->errors(),
            ], 422);
        }

        try {
            $lead = DB::transaction(function () use ($request, $staff, $module, $detailValidator) {
                $lead = Lead::create([
                    'hospital_id' => $staff->hospital_id,
                    'lead_module_id' => $module->id,
                    'leadcode' => 'LD' . now()->format('ymdHis') . strtoupper(Str::random(4)),
                    'name' => $request->name,
                    'mobile' => $request->mobile,
                    'alternate_mobile' => $request->alternate_mobile,
                    'email' => $request->email,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'pincode' => $request->pincode,
                    'status' => 'new',
                    'source' => $request->source,
                    'remarks' => $request->remarks,
                    'created_by' => $staff->id,
                    'created_by_type' => 'staff',
                    'assigned_to' => $staff->id,
                    'assigned_to_type' => 'staff',
                    'assigned_at' => now(),
                    'is_active' => 1,
                ]);

                $detailData = $detailValidator->validated();

                // Extract child records before saving module details.
                $members = $detailData['members'] ?? [];
                $employees = $detailData['employees'] ?? [];

                unset(
                    $detailData['members'],
                    $detailData['employees']
                );

                // Add hospital and lead IDs.
                $detailData['hospital_id'] = $staff->hospital_id;
                $detailData['lead_id'] = $lead->id;

                // Create main module detail.
                $detail = $this->createModuleDetail(
                    $module->slug,
                    $detailData
                );

                // Save community members.
                if ($module->slug === 'community' && !empty($members)) {

                    $this->syncCommunityMembers(
                        $detail,
                        $lead,
                        $staff,
                        $members
                    );
                }

                // Save company insurance employees.
                if ($module->slug === 'company-health-insurance' && !empty($employees)) {

                    $this->syncCompanyEmployees(
                        $detail,
                        $lead,
                        $staff,
                        $employees
                    );
                }

                LeadActivity::create([
                    'hospital_id' => $staff->hospital_id,
                    'lead_id' => $lead->id,
                    'performed_by' => $staff->id,
                    'performed_by_type' => 'staff',
                    'activity_type' => 'lead_created',
                    'title' => 'Lead created',
                    'description' => 'Lead created by staff.',
                    'activity_data' => [
                        'module' => $module->slug,
                    ],
                    'performed_at' => now(),
                ]);

                return $lead;
            });

            $createdLead = Lead::with('leadModule')
                ->where('hospital_id', $staff->hospital_id)
                ->find($lead->id);

            $moduleDetails = $this->getModuleDetails(
                $module->slug,
                $lead->id,
                $staff->hospital_id
            );

            $createdLead->setAttribute('module_details', $moduleDetails);

            return response()->json([
                'success' => 1,
                'message' => 'Lead created successfully.',
                'data' => $createdLead,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => 0,
                'message' => 'Child record validation failed.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => 0,
                'message' => 'Unable to create lead. Please try again.',
            ], 500);
        }
    }

    /**
     * Update Lead.
     */
    public function update(Request $request, $id)
    {
        $staff = $this->getStaff();

        if (!$staff) {
            return response()->json([
                'success' => 0,
                'message' => 'Staff account is unavailable.',
            ], 403);
        }

        $lead = Lead::where('hospital_id', $staff->hospital_id)
            ->where('assigned_to', $staff->id)
            ->where('assigned_to_type', 'staff')
            ->find($id);

        if (!$lead) {
            return response()->json([
                'success' => 0,
                'message' => 'Lead not found.',
            ], 404);
        }

        if (
            !$this->hasModulePermission(
                $staff,
                $lead->lead_module_id,
                'can_edit'
            )
        ) {
            return response()->json([
                'success' => 0,
                'message' => 'You do not have permission to edit this lead.',
            ], 403);
        }

        $module = LeadModule::where('id', $lead->lead_module_id)
            ->where('is_active', 1)
            ->first();

        if (!$module) {
            return response()->json([
                'success' => 0,
                'message' => 'Invalid lead module.',
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'mobile' => ['sometimes', 'required', 'string', 'max:20'],
            'alternate_mobile' => ['sometimes', 'nullable', 'string', 'max:20'],
            'email' => ['sometimes', 'nullable', 'email', 'max:255'],
            'address' => ['sometimes', 'nullable', 'string'],
            'city' => ['sometimes', 'nullable', 'string', 'max:100'],
            'state' => ['sometimes', 'nullable', 'string', 'max:100'],
            'pincode' => ['sometimes', 'nullable', 'string', 'max:20'],
            'source' => ['sometimes', 'nullable', 'string', 'max:100'],
            'remarks' => ['sometimes', 'nullable', 'string'],
            'details' => ['sometimes', 'required', 'array'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $detailData = null;

        if (array_key_exists('details', $validated)) {
            $detailRules = $this->getModuleDetailRules($module->slug);

            if ($detailRules === null) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Unsupported lead module.',
                ], 422);
            }

            $detailValidator = Validator::make(
                $validated['details'],
                $detailRules
            );

            if ($detailValidator->fails()) {
                return response()->json([
                    'success' => 0,
                    'message' => 'Module details validation failed.',
                    'errors' => $detailValidator->errors(),
                ], 422);
            }

            $detailData = $detailValidator->validated();
        }

        try {
            DB::transaction(function () use ($lead, $staff, $module, $validated, $detailData) {
                $commonFields = [
                    'name',
                    'mobile',
                    'alternate_mobile',
                    'email',
                    'address',
                    'city',
                    'state',
                    'pincode',
                    'source',
                    'remarks',
                ];

                $leadData = [];

                foreach ($commonFields as $field) {
                    if (array_key_exists($field, $validated)) {
                        $leadData[$field] = $validated[$field];
                    }
                }

                if (!empty($leadData)) {
                    $lead->update($leadData);
                }

                if ($detailData !== null) {

                    // Extract child data.
                    $members = $detailData['members'] ?? null;
                    $employees = $detailData['employees'] ?? null;

                    unset(
                        $detailData['members'],
                        $detailData['employees']
                    );

                    // Update main module detail.
                    $detail = $this->updateModuleDetail(
                        $module->slug,
                        $lead,
                        $staff,
                        $detailData
                    );

                    // Synchronize community members only when supplied.
                    if (
                        $module->slug === 'community' &&
                        $members !== null
                    ) {
                        $this->syncCommunityMembers(
                            $detail,
                            $lead,
                            $staff,
                            $members
                        );
                    }

                    // Synchronize company employees only when supplied.
                    if (
                        $module->slug === 'company-health-insurance' &&
                        $employees !== null
                    ) {
                        $this->syncCompanyEmployees(
                            $detail,
                            $lead,
                            $staff,
                            $employees
                        );
                    }
                }

                LeadActivity::create([
                    'hospital_id' => $staff->hospital_id,
                    'lead_id' => $lead->id,
                    'performed_by' => $staff->id,
                    'performed_by_type' => 'staff',
                    'activity_type' => 'lead_updated',
                    'title' => 'Lead updated',
                    'description' => 'Lead information updated by staff.',
                    'activity_data' => [
                        'module' => $module->slug,
                        'updated_fields' => array_keys($validated),
                    ],
                    'performed_at' => now(),
                ]);
            });

            $updatedLead = Lead::with([
                'leadModule',
                'followUps',
                'statusHistories',
                'activities',
            ])
                ->where('hospital_id', $staff->hospital_id)
                ->find($lead->id);

            $moduleDetails = $this->getModuleDetails(
                $module->slug,
                $lead->id,
                $staff->hospital_id
            );

            $updatedLead->setAttribute('module_details', $moduleDetails);

            return response()->json([
                'success' => 1,
                'message' => 'Lead updated successfully.',
                'data' => $updatedLead,
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => 0,
                'message' => 'Child record validation failed.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => 0,
                'message' => 'Unable to update lead. Please try again.',
            ], 500);
        }
    }

    /**
     * Module-specific validation rules.
     */
    private function getModuleDetailRules(string $slug): ?array
    {
        $rules = [

            'doctor' => [
                'doctor_name' => ['nullable', 'string', 'max:255'],
                'gender' => ['nullable', 'string', 'max:30'],
                'date_of_birth' => ['nullable', 'date'],
                'qualification' => ['nullable', 'string', 'max:255'],
                'specialization' => ['nullable', 'string', 'max:255'],
                'medical_registration_number' => ['nullable', 'string', 'max:100'],
                'experience_years' => ['nullable', 'integer', 'min:0'],
                'consultation_type' => ['nullable', 'in:online,offline,both'],
                'hospital_clinic_name' => ['nullable', 'string', 'max:255'],
                'clinic_address' => ['nullable', 'string'],
                'clinic_city' => ['nullable', 'string', 'max:100'],
                'clinic_state' => ['nullable', 'string', 'max:100'],
                'clinic_pincode' => ['nullable', 'string', 'max:20'],
                'reference_source' => ['nullable', 'string'],
                'interested_services' => ['nullable', 'string'],
                'remarks' => ['nullable', 'string'],
            ],

            'community' => [
                'community_name' => ['required', 'string', 'max:255'],
                'community_type' => ['nullable', 'in:residential,social,religious,other'],
                'description' => ['nullable', 'string'],
                'total_members' => ['nullable', 'integer', 'min:0'],
                'president_head' => ['nullable', 'string', 'max:255'],
                'contact_person' => ['nullable', 'string', 'max:255'],
                'contact_designation' => ['nullable', 'string', 'max:255'],
                'community_address' => ['nullable', 'string'],
                'city' => ['nullable', 'string', 'max:100'],
                'state' => ['nullable', 'string', 'max:100'],
                'pincode' => ['nullable', 'string', 'max:20'],
                'remarks' => ['nullable', 'string'],
                'members' => ['nullable', 'array'],
                'members.*.id' => ['nullable', 'integer', 'min:1'],
                'members.*.member_name' => ['required', 'string', 'max:255'],
                'members.*.mobile' => ['nullable', 'string', 'max:20'],
                'members.*.email' => ['nullable', 'email', 'max:255'],
                'members.*.designation' => ['nullable', 'string', 'max:255'],
                'members.*.notes' => ['nullable', 'string'],
            ],

            'company-health-insurance' => [
                'company_name' => ['required', 'string', 'max:255'],
                'industry' => ['nullable', 'string', 'max:255'],
                'company_address' => ['nullable', 'string'],
                'city' => ['nullable', 'string', 'max:100'],
                'state' => ['nullable', 'string', 'max:100'],
                'pincode' => ['nullable', 'string', 'max:20'],
                'website' => ['nullable', 'url', 'max:255'],
                'employee_count' => ['nullable', 'integer', 'min:0'],
                'hr_name' => ['nullable', 'string', 'max:255'],
                'hr_mobile' => ['nullable', 'string', 'max:20'],
                'hr_email' => ['nullable', 'email'],
                'insurance_provider' => ['nullable', 'string', 'max:255'],
                'policy_type' => ['nullable', 'string', 'max:100'],
                'policy_number' => ['nullable', 'string', 'max:100'],
                'sum_insured' => ['nullable', 'numeric', 'min:0'],
                'premium' => ['nullable', 'numeric', 'min:0'],
                'policy_start_date' => ['nullable', 'date'],
                'renewal_date' => ['nullable', 'date'],
                'covered_employee_count' => ['nullable', 'integer', 'min:0'],
                'current_insurance_details' => ['nullable', 'string'],
                'remarks' => ['nullable', 'string'],
                'employees' => ['nullable', 'array'],
                'employees.*.id' => ['nullable', 'integer', 'min:1'],
                'employees.*.employee_id' => ['nullable', 'string', 'max:100'],
                'employees.*.employee_name' => ['required', 'string', 'max:255'],
                'employees.*.mobile' => ['nullable', 'string', 'max:20'],
                'employees.*.email' => ['nullable', 'email', 'max:255'],
                'employees.*.date_of_birth' => ['nullable', 'date'],
                'employees.*.gender' => ['nullable', 'in:male,female,other'],
                'employees.*.designation' => ['nullable', 'string', 'max:255'],
                'employees.*.dependent_count' => ['nullable', 'integer', 'min:0'],
                'employees.*.dependent_details' => ['nullable', 'array'],
                'employees.*.dependent_details.*.name' => ['required', 'string', 'max:255'],
                'employees.*.dependent_details.*.relationship' => ['required', 'string', 'max:100'],
                'employees.*.dependent_details.*.date_of_birth' => ['nullable', 'date'],
            ],

            'personal-health-insurance' => [
                'customer_name' => ['nullable', 'string', 'max:255'],
                'alternate_mobile' => ['nullable', 'string', 'max:20'],
                'date_of_birth' => ['nullable', 'date'],
                'gender' => ['nullable', 'string', 'max:30'],
                'occupation' => ['nullable', 'string', 'max:255'],
                'customer_address' => ['nullable', 'string'],
                'city' => ['nullable', 'string', 'max:100'],
                'state' => ['nullable', 'string', 'max:100'],
                'pincode' => ['nullable', 'string', 'max:20'],
                'insurance_provider' => ['nullable', 'string', 'max:255'],
                'policy_type' => ['nullable', 'string', 'max:100'],
                'policy_number' => ['nullable', 'string', 'max:100'],
                'sum_insured' => ['nullable', 'numeric', 'min:0'],
                'existing_premium' => ['nullable', 'numeric', 'min:0'],
                'policy_start_date' => ['nullable', 'date'],
                'renewal_date' => ['nullable', 'date'],
                'insurance_requirement' => ['nullable', 'in:new,renewal,portability'],
                'interested_plan' => ['nullable', 'string', 'max:255'],
                'budget' => ['nullable', 'numeric', 'min:0'],
                'current_insurance_details' => ['nullable', 'string'],
                'remarks' => ['nullable', 'string'],
            ],

            'cash-treatment' => [
                'patient_name' => ['nullable', 'string', 'max:255'],
                'alternate_mobile' => ['nullable', 'string', 'max:20'],
                'patient_email' => ['nullable', 'email'],
                'age' => ['nullable', 'integer', 'min:0'],
                'gender' => ['nullable', 'string', 'max:30'],
                'treatment_type' => ['nullable', 'string', 'max:255'],
                'specialization' => ['nullable', 'string', 'max:255'],
                'disease' => ['nullable', 'string', 'max:255'],
                'treatment_description' => ['nullable', 'string'],
                'doctor_name' => ['nullable', 'string', 'max:255'],
                'hospital_name' => ['nullable', 'string', 'max:255'],
                'appointment_date' => ['nullable', 'date'],
                'appointment_time' => ['nullable', 'date_format:H:i'],
                'appointment_status' => ['nullable', 'string', 'max:50'],
                'estimated_amount' => ['nullable', 'numeric', 'min:0'],
                'final_amount' => ['nullable', 'numeric', 'min:0'],
                'advance_amount' => ['nullable', 'numeric', 'min:0'],
                'balance_amount' => ['nullable', 'numeric', 'min:0'],
                'payment_status' => ['nullable', 'in:pending,partial,paid'],
                'reference_source' => ['nullable', 'string'],
                'remarks' => ['nullable', 'string'],
            ],

            'credit-treatment' => [
                'patient_name' => ['nullable', 'string', 'max:255'],
                'alternate_mobile' => ['nullable', 'string', 'max:20'],
                'patient_email' => ['nullable', 'email'],
                'age' => ['nullable', 'integer', 'min:0'],
                'gender' => ['nullable', 'string', 'max:30'],
                'treatment_type' => ['nullable', 'string', 'max:255'],
                'specialization' => ['nullable', 'string', 'max:255'],
                'hospital_name' => ['nullable', 'string', 'max:255'],
                'doctor_name' => ['nullable', 'string', 'max:255'],
                'treatment_description' => ['nullable', 'string'],
                'estimated_amount' => ['nullable', 'numeric', 'min:0'],
                'credit_provider' => ['nullable', 'string', 'max:255'],
                'credit_amount_required' => ['nullable', 'numeric', 'min:0'],
                'credit_type' => ['nullable', 'string', 'max:100'],
                'application_reference' => ['nullable', 'string', 'max:100'],
                'application_date' => ['nullable', 'date'],
                'approval_status' => [
                    'nullable',
                    'in:not_submitted,documents_pending,application_submitted,approval_pending,approved,rejected'
                ],
                'approved_amount' => ['nullable', 'numeric', 'min:0'],
                'rejection_reason' => ['nullable', 'string'],
                'treatment_status' => [
                    'nullable',
                    'in:not_started,in_progress,completed,cancelled'
                ],
                'remarks' => ['nullable', 'string'],
            ],

            'health-advisor' => [
                'advisor_name' => ['nullable', 'string', 'max:255'],
                'advisor_code' => ['nullable', 'string', 'max:100'],
                'advisor_type' => ['nullable', 'string', 'max:100'],
                'qualification' => ['nullable', 'string', 'max:255'],
                'experience' => ['nullable', 'integer', 'min:0'],
                'description' => ['nullable', 'string'],
                'address' => ['nullable', 'string'],
                'city' => ['nullable', 'string', 'max:100'],
                'state' => ['nullable', 'string', 'max:100'],
                'pincode' => ['nullable', 'string', 'max:20'],
                'joining_date' => ['nullable', 'date'],
                'reference_source' => ['nullable', 'string'],
                'remarks' => ['nullable', 'string'],
            ],
        ];

        return $rules[$slug] ?? null;
    }

    /**
     * Fetch module-specific detail and its child records.
     */
    private function getModuleDetails(string $slug, int $leadId, int $hospitalId)
    {
        $models = [
            'doctor' => DoctorLeadDetail::class,
            'community' => CommunityLeadDetail::class,
            'company-health-insurance' => CompanyHealthInsuranceDetail::class,
            'personal-health-insurance' => PersonalHealthInsuranceDetail::class,
            'cash-treatment' => CashTreatmentDetail::class,
            'credit-treatment' => CreditTreatmentDetail::class,
            'health-advisor' => HealthAdvisorDetail::class,
        ];

        $model = $models[$slug] ?? null;

        if (!$model) {
            return null;
        }

        $query = $model::query();

        if ($slug === 'community') {
            $query->with('members');
        } elseif ($slug === 'company-health-insurance') {
            $query->with('employees');
        }

        return $query
            ->where('hospital_id', $hospitalId)
            ->where('lead_id', $leadId)
            ->first();
    }

    /**
     * Create Module Detail Record.
     */
    private function createModuleDetail(string $slug, array $data)
    {
        $models = [
            'doctor' => DoctorLeadDetail::class,
            'community' => CommunityLeadDetail::class,
            'company-health-insurance' => CompanyHealthInsuranceDetail::class,
            'personal-health-insurance' => PersonalHealthInsuranceDetail::class,
            'cash-treatment' => CashTreatmentDetail::class,
            'credit-treatment' => CreditTreatmentDetail::class,
            'health-advisor' => HealthAdvisorDetail::class,
        ];

        $model = $models[$slug] ?? null;

        if (!$model) {
            throw new \InvalidArgumentException('Unsupported lead module.');
        }

        // Return the created detail so child records can use its ID.
        return $model::create($data);
    }

    /**
     * Update Module Detail Record.
     */
    private function updateModuleDetail(
        string $slug,
        Lead $lead,
        $staff,
        array $details
    ) {
        $models = [
            'doctor' => DoctorLeadDetail::class,
            'community' => CommunityLeadDetail::class,
            'company-health-insurance' => CompanyHealthInsuranceDetail::class,
            'personal-health-insurance' => PersonalHealthInsuranceDetail::class,
            'cash-treatment' => CashTreatmentDetail::class,
            'credit-treatment' => CreditTreatmentDetail::class,
            'health-advisor' => HealthAdvisorDetail::class,
        ];

        $model = $models[$slug] ?? null;

        if (!$model) {
            throw new \InvalidArgumentException('Unsupported lead module.');
        }

        return $model::updateOrCreate(
            [
                'hospital_id' => $staff->hospital_id,
                'lead_id' => $lead->id,
            ],
            $details
        );
    }

    /**
     * Get Staff Members Available for Lead Assignment
     */
    public function assignmentOptions()
    {
        $staff = $this->getStaff();

        if (!$staff) {
            return response()->json([
                'success' => 0,
                'message' => 'Staff account is unavailable.',
            ], 403);
        }

        $staffIds = StaffPermission::where('hospital_id', $staff->hospital_id)
            ->where('staff_id', $staff->id)
            ->where('can_assign', 1)
            ->pluck('lead_module_id');

        if ($staffIds->isEmpty()) {
            return response()->json([
                'success' => 0,
                'message' => 'You do not have permission to assign leads.',
            ], 403);
        }

        $staffMembers = Staff::where('hospital_id', $staff->hospital_id)
            ->where('status', 'active')
            ->where('id', '!=', $staff->id)
            ->orderBy('name')
            ->get(['id', 'name', 'employee_code', 'mobile']);

        return response()->json([
            'success' => 1,
            'message' => 'Staff members fetched successfully.',
            'data' => $staffMembers,
        ]);
    }

    /**
     * Assign Lead to Another Staff Member
     */
    public function assignLead(Request $request, $id)
    {
        $staff = $this->getStaff();

        if (!$staff) {
            return response()->json([
                'success' => 0,
                'message' => 'Staff account is unavailable.',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'assigned_to' => ['required', 'integer'],
            'remarks' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $lead = Lead::where('hospital_id', $staff->hospital_id)
            ->where('assigned_to', $staff->id)
            ->where('assigned_to_type', 'staff')
            ->find($id);

        if (!$lead) {
            return response()->json([
                'success' => 0,
                'message' => 'Lead not found.',
            ], 404);
        }

        // Check assign permission for this particular lead module.
        if (
            !$this->hasModulePermission(
                $staff,
                $lead->lead_module_id,
                'can_assign'
            )
        ) {
            return response()->json([
                'success' => 0,
                'message' => 'You do not have permission to assign leads in this module.',
            ], 403);
        }

        // Verify target staff belongs to the same hospital.
        $assignedStaff = Staff::where('hospital_id', $staff->hospital_id)
            ->where('status', 'active')
            ->find($request->assigned_to);

        if (!$assignedStaff) {
            return response()->json([
                'success' => 0,
                'message' => 'Selected staff member is unavailable.',
            ], 422);
        }

        // Verify target staff has access to this lead module.
        if (
            !$this->hasModulePermission(
                $assignedStaff,
                $lead->lead_module_id,
                'can_view'
            )
        ) {
            return response()->json([
                'success' => 0,
                'message' => 'Selected staff member does not have access to this lead module.',
            ], 422);
        }

        try {
            DB::transaction(function () use ($lead, $staff, $assignedStaff, $request) {
                $previousStaffId = $lead->assigned_to;

                $lead->update([
                    'assigned_to' => $assignedStaff->id,
                    'assigned_to_type' => 'staff',
                    'assigned_at' => now(),
                ]);

                LeadActivity::create([
                    'hospital_id' => $staff->hospital_id,
                    'lead_id' => $lead->id,
                    'performed_by' => $staff->id,
                    'performed_by_type' => 'staff',
                    'activity_type' => 'lead_assigned',
                    'title' => 'Lead reassigned',
                    'description' => 'Lead assigned to ' . $assignedStaff->name,
                    'activity_data' => [
                        'previous_staff_id' => $previousStaffId,
                        'assigned_staff_id' => $assignedStaff->id,
                        'remarks' => $request->remarks,
                    ],
                    'performed_at' => now(),
                ]);
            });

            return response()->json([
                'success' => 1,
                'message' => 'Lead assigned successfully.',
                'data' => [
                    'lead_id' => $lead->id,
                    'assigned_to' => $assignedStaff->id,
                    'assigned_staff_name' => $assignedStaff->name,
                    'assigned_at' => now(),
                ],
            ], 200);

        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => 0,
                'message' => 'Unable to assign lead. Please try again.',
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $staff = Auth::guard('staff')->user();

        if (!$staff || $staff->status !== 'active') {
            return response()->json([
                'success' => 0,
                'message' => 'Unauthorized access.',
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:new,contacted,interested,follow_up,converted,not_interested,closed',
            'remarks' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $lead = Lead::where('id', $id)
            ->where('hospital_id', $staff->hospital_id)
            ->where('assigned_to', $staff->id)
            ->first();

        if (!$lead) {
            return response()->json([
                'success' => 0,
                'message' => 'Lead not found.',
            ], 404);
        }

        if (
            !$this->hasModulePermission(
                $staff,
                $lead->lead_module_id,
                'can_edit'
            )
        ) {
            return response()->json([
                'success' => 0,
                'message' => 'You do not have permission to update this lead.',
            ], 403);
        }

        $oldStatus = $lead->status;
        $newStatus = $request->status;

        if ($oldStatus === $newStatus) {
            return response()->json([
                'success' => 1,
                'message' => 'Lead already has this status.',
                'data' => $lead,
            ]);
        }

        $lead->status = $newStatus;

        if ($newStatus === 'converted') {
            $lead->converted_at = now();
        } elseif ($oldStatus === 'converted') {
            $lead->converted_at = null;
        }

        $lead->save();

        LeadActivity::create([
            'hospital_id' => $staff->hospital_id,
            'lead_id' => $lead->id,
            'staff_id' => $staff->id,
            'activity_type' => 'status_changed',
            'description' => 'Lead status changed from ' . $oldStatus . ' to ' . $newStatus,
            'old_value' => $oldStatus,
            'new_value' => $newStatus,
            'remarks' => $request->remarks,
        ]);

        return response()->json([
            'success' => 1,
            'message' => 'Lead status updated successfully.',
            'data' => $lead->fresh(),
        ]);
    }
    private function syncCommunityMembers(
        $detail,
        $lead,
        $staff,
        array $members
    ): void {

        $keepIds = [];

        foreach ($members as $member) {

            $id = $member['id'] ?? null;
            unset($member['id']);

            $record = null;

            if ($id) {
                $record = CommunityMember::where('hospital_id', $staff->hospital_id)
                    ->where('lead_id', $lead->id)
                    ->where('community_lead_detail_id', $detail->id)
                    ->find($id);

                if (!$record) {
                    throw ValidationException::withMessages([
                        'details.members' => "Invalid community member ID: {$id}.",
                    ]);
                }
            }

            if ($record) {
                $record->update($member);
            } else {
                $record = CommunityMember::create(array_merge($member, [
                    'hospital_id' => $staff->hospital_id,
                    'lead_id' => $lead->id,
                    'community_lead_detail_id' => $detail->id,
                ]));
            }

            $keepIds[] = $record->id;
        }

        CommunityMember::where('hospital_id', $staff->hospital_id)
            ->where('lead_id', $lead->id)
            ->where('community_lead_detail_id', $detail->id)
            ->whereNotIn('id', $keepIds)
            ->delete();
    }

    private function syncCompanyEmployees(
        $detail,
        $lead,
        $staff,
        array $employees
    ): void {

        $keepIds = [];

        foreach ($employees as $employee) {

            $id = $employee['id'] ?? null;
            unset($employee['id']);

            $record = null;

            if ($id) {
                $record = CompanyInsuranceEmployee::where('hospital_id', $staff->hospital_id)
                    ->where('lead_id', $lead->id)
                    ->where('company_health_insurance_detail_id', $detail->id)
                    ->find($id);

                if (!$record) {
                    throw ValidationException::withMessages([
                        'details.employees' => "Invalid employee ID: {$id}.",
                    ]);
                }
            }

            if ($record) {
                $record->update($employee);
            } else {
                $record = CompanyInsuranceEmployee::create(array_merge($employee, [
                    'hospital_id' => $staff->hospital_id,
                    'lead_id' => $lead->id,
                    'company_health_insurance_detail_id' => $detail->id,
                ]));
            }

            $keepIds[] = $record->id;
        }

        CompanyInsuranceEmployee::where('hospital_id', $staff->hospital_id)
            ->where('lead_id', $lead->id)
            ->where('company_health_insurance_detail_id', $detail->id)
            ->whereNotIn('id', $keepIds)
            ->delete();
    }
}
