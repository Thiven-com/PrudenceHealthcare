<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadModule;
use App\Models\Staff;
use App\Models\LeadActivity;
use App\Models\DoctorLeadDetail;
use App\Models\CommunityLeadDetail;
use App\Models\CompanyHealthInsuranceDetail;
use App\Models\PersonalHealthInsuranceDetail;
use App\Models\CashTreatmentDetail;
use App\Models\CreditTreatmentDetail;
use App\Models\HealthAdvisorDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LeadController extends Controller
{
    /**
     * Get authenticated hospital ID.
     */
    private function hospitalId()
    {
        return Auth::guard('hospital')->id();
    }

    /**
     * Get enabled modules for the authenticated hospital.
     */
    private function enabledModules()
    {
        return LeadModule::query()
            ->join(
                'hospital_modules',
                'hospital_modules.lead_module_id',
                '=',
                'lead_modules.id'
            )
            ->where('hospital_modules.hospital_id', $this->hospitalId())
            ->where('hospital_modules.is_enabled', 1)
            ->where('lead_modules.is_active', 1)
            ->select(
                'lead_modules.id',
                'lead_modules.name',
                'lead_modules.slug'
            )
            ->orderBy('lead_modules.name')
            ->get();
    }

    /**
     * Get active staff of this hospital.
     */
    private function staffMembers()
    {
        return Staff::where('hospital_id', $this->hospitalId())
            ->where('status', 'active')
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'employee_code',
                'mobile',
            ]);
    }

    /**
     * Base lead query.
     */
    private function leadQuery()
    {
        return Lead::where('hospital_id', $this->hospitalId());
    }

    /**
     * Detail models mapping.
     */
    private function detailModels(): array
    {
        return [
            'doctor' => DoctorLeadDetail::class,
            'community' => CommunityLeadDetail::class,
            'company-health-insurance' => CompanyHealthInsuranceDetail::class,
            'personal-health-insurance' => PersonalHealthInsuranceDetail::class,
            'cash-treatment' => CashTreatmentDetail::class,
            'credit-treatment' => CreditTreatmentDetail::class,
            'health-advisor' => HealthAdvisorDetail::class,
        ];
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
     * Generate dynamic module fields for Blade.
     */
    private function buildModuleFields($leadModules): array
    {
        $moduleFields = [];

        foreach ($leadModules as $module) {
            $rules = $this->getModuleDetailRules($module->slug);

            $moduleFields[$module->id] = collect($rules ?? [])
                ->map(function ($fieldRules, $field) {
                    return [
                        'name' => $field,
                        'label' => ucwords(str_replace('_', ' ', $field)),
                        'required' => in_array('required', $fieldRules),
                        'type' => $this->getFieldType($field, $fieldRules),
                    ];
                })
                ->values()
                ->toArray();
        }

        return $moduleFields;
    }

    /**
     * Determine dynamic input type.
     */
    private function getFieldType(string $field, array $rules): string
    {
        if (in_array('date', $rules)) {
            return 'date';
        }

        if (in_array('date_format:H:i', $rules)) {
            return 'time';
        }

        if (in_array('email', $rules)) {
            return 'email';
        }

        if (in_array('url', $rules)) {
            return 'url';
        }

        if (
            in_array('integer', $rules) ||
            in_array('numeric', $rules)
        ) {
            return 'number';
        }

        $textareaFields = [
            'description',
            'remarks',
            'address',
            'clinic_address',
            'community_address',
            'company_address',
            'customer_address',
            'treatment_description',
            'current_insurance_details',
            'interested_services',
            'rejection_reason',
        ];

        if (in_array($field, $textareaFields)) {
            return 'textarea';
        }

        return 'text';
    }

    /**
     * Save module detail record.
     */
    private function saveModuleDetails(Lead $lead, array $details): void
    {
        $models = $this->detailModels();

        $slug = $lead->leadModule->slug ?? null;
        $model = $models[$slug] ?? null;

        if (!$model) {
            throw new \InvalidArgumentException('Unsupported lead module.');
        }

        $model::updateOrCreate(
            [
                'hospital_id' => $this->hospitalId(),
                'lead_id' => $lead->id,
            ],
            $details
        );
    }

    /**
     * Get module detail record.
     */
    private function getModuleDetail(Lead $lead)
    {
        $models = $this->detailModels();

        $slug = $lead->leadModule->slug ?? null;
        $model = $models[$slug] ?? null;

        if (!$model) {
            return null;
        }

        return $model::where('hospital_id', $this->hospitalId())
            ->where('lead_id', $lead->id)
            ->first();
    }

    /**
     * Create activity record.
     */
    private function createActivity(
        Lead $lead,
        string $type,
        string $title,
        string $description,
        array $data = [],
        $oldValue = null,
        $newValue = null
    ): void {
        LeadActivity::create([
            'hospital_id' => $this->hospitalId(),
            'lead_id' => $lead->id,
            'performed_by' => $this->hospitalId(),
            'performed_by_type' => 'hospital',
            'activity_type' => $type,
            'title' => $title,
            'description' => $description,
            'old_value' => $oldValue,
            'new_value' => $newValue,
            'activity_data' => $data,
            'performed_at' => now(),
        ]);
    }

    /**
     * Validate staff assignment.
     */
    private function validateAssignedStaff($staffId)
    {
        if (!$staffId) {
            return null;
        }

        return Staff::where('hospital_id', $this->hospitalId())
            ->where('status', 'active')
            ->find($staffId);
    }

    /**
     * Lead listing.
     */
    public function index(Request $request)
    {
        $leadModules = $this->enabledModules();
        $moduleIds = $leadModules->pluck('id');

        $query = $this->leadQuery()
            ->with('leadModule')
            ->whereIn('lead_module_id', $moduleIds);

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('leadcode', 'like', "%{$search}%");
            });
        }

        if ($request->filled('module_id')) {
            $query->where('lead_module_id', $request->module_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to)
                ->where('assigned_to_type', 'staff');
        }

        $leads = $query->latest('id')
            ->paginate(15)
            ->withQueryString();

        $staffMembers = $this->staffMembers();

        $statuses = $this->leadQuery()
            ->whereIn('lead_module_id', $moduleIds)
            ->whereNotNull('status')
            ->distinct()
            ->orderBy('status')
            ->pluck('status');

        $baseQuery = $this->leadQuery()
            ->whereIn('lead_module_id', $moduleIds);

        $totalLeads = (clone $baseQuery)->count();

        $newLeads = (clone $baseQuery)
            ->where('status', 'new')
            ->count();

        $convertedLeads = (clone $baseQuery)
            ->where('status', 'converted')
            ->count();

        $unassignedLeads = (clone $baseQuery)
            ->where(function ($q) {
                $q->whereNull('assigned_to')
                    ->orWhere('assigned_to_type', '!=', 'staff');
            })
            ->count();

        return view('hospital.leads.index', compact(
            'leads',
            'leadModules',
            'staffMembers',
            'statuses',
            'totalLeads',
            'newLeads',
            'convertedLeads',
            'unassignedLeads'
        ));
    }

    /**
     * Create form.
     */
    public function create()
    {
        $leadModules = $this->enabledModules();
        $staffMembers = $this->staffMembers();
        $moduleFields = $this->buildModuleFields($leadModules);

        return view('hospital.leads.create', compact(
            'leadModules',
            'staffMembers',
            'moduleFields'
        ));
    }

    /**
     * Store lead.
     */
    public function store(Request $request)
    {
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
            'status' => [
                'required',
                'in:new,contacted,interested,follow_up,converted,not_interested,closed'
            ],
            'remarks' => ['nullable', 'string'],
            'assigned_to' => ['nullable', 'integer'],
            'details' => ['required', 'array'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $module = $this->enabledModules()
            ->firstWhere('id', $request->lead_module_id);

        if (!$module) {
            return back()->withErrors([
                'lead_module_id' => 'Selected module is not enabled for this hospital.',
            ])->withInput();
        }

        $detailRules = $this->getModuleDetailRules($module->slug);

        if ($detailRules === null) {
            return back()->withErrors([
                'lead_module_id' => 'Unsupported lead module.',
            ])->withInput();
        }

        $detailValidator = Validator::make(
            $request->input('details', []),
            $detailRules
        );

        if ($detailValidator->fails()) {
            return back()
                ->withErrors($detailValidator)
                ->withInput();
        }

        $assignedStaff = $this->validateAssignedStaff($request->assigned_to);

        if ($request->filled('assigned_to') && !$assignedStaff) {
            return back()->withErrors([
                'assigned_to' => 'Selected staff member is invalid.',
            ])->withInput();
        }

        try {
            DB::transaction(function () use ($request, $module, $detailValidator, $assignedStaff) {
                $lead = Lead::create([
                    'hospital_id' => $this->hospitalId(),
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
                    'status' => $request->status,
                    'source' => $request->source,
                    'remarks' => $request->remarks,
                    'created_by' => $this->hospitalId(),
                    'created_by_type' => 'hospital',
                    'assigned_to' => $assignedStaff?->id,
                    'assigned_to_type' => $assignedStaff ? 'staff' : null,
                    'assigned_at' => $assignedStaff ? now() : null,
                    'converted_at' => $request->status === 'converted' ? now() : null,
                    'is_active' => 1,
                ]);

                $lead->setRelation('leadModule', $module);

                $this->saveModuleDetails(
                    $lead,
                    $detailValidator->validated()
                );

                $this->createActivity(
                    $lead,
                    'lead_created',
                    'Lead created',
                    'Lead created by hospital admin.',
                    [
                        'module' => $module->slug,
                        'assigned_to' => $assignedStaff?->id,
                    ]
                );
            });

            return redirect()
                ->route('hospital.leads.index')
                ->with('success', 'Lead created successfully.');

        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Unable to create lead. Please try again.');
        }
    }

    /**
     * View lead.
     */
    public function show($id)
    {
        $lead = $this->leadQuery()
            ->with([
                'leadModule',
                'followUps',
                'activities',
            ])
            ->findOrFail($id);

        $detail = $this->getModuleDetail($lead);

        $assignedStaff = null;

        if ($lead->assigned_to && $lead->assigned_to_type === 'staff') {
            $assignedStaff = Staff::where('hospital_id', $this->hospitalId())
                ->find($lead->assigned_to);
        }

        return view('hospital.leads.show', compact(
            'lead',
            'detail',
            'assignedStaff'
        ));
    }

    /**
     * Edit form.
     */
    public function edit($id)
    {
        $lead = $this->leadQuery()
            ->with('leadModule')
            ->findOrFail($id);

        $leadModules = $this->enabledModules();

        // Existing lead's module should remain editable even if disabled later.
        if (!$leadModules->contains('id', $lead->lead_module_id)) {
            $leadModules->push($lead->leadModule);
        }

        $staffMembers = $this->staffMembers();
        $moduleFields = $this->buildModuleFields($leadModules);
        $detail = $this->getModuleDetail($lead);

        return view('hospital.leads.edit', compact(
            'lead',
            'leadModules',
            'staffMembers',
            'moduleFields',
            'detail'
        ));
    }

    /**
     * Update lead.
     */
    public function update(Request $request, $id)
    {
        $lead = $this->leadQuery()
            ->with('leadModule')
            ->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:20'],
            'alternate_mobile' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'pincode' => ['nullable', 'string', 'max:20'],
            'source' => ['nullable', 'string', 'max:100'],
            'status' => [
                'required',
                'in:new,contacted,interested,follow_up,converted,not_interested,closed'
            ],
            'remarks' => ['nullable', 'string'],
            'assigned_to' => ['nullable', 'integer'],
            'details' => ['required', 'array'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $module = $lead->leadModule;

        if (!$module) {
            return back()->with('error', 'Lead module not found.');
        }

        $detailRules = $this->getModuleDetailRules($module->slug);

        if ($detailRules === null) {
            return back()->with('error', 'Unsupported lead module.');
        }

        $detailValidator = Validator::make(
            $request->input('details', []),
            $detailRules
        );

        if ($detailValidator->fails()) {
            return back()
                ->withErrors($detailValidator)
                ->withInput();
        }

        $assignedStaff = $this->validateAssignedStaff($request->assigned_to);

        if ($request->filled('assigned_to') && !$assignedStaff) {
            return back()->withErrors([
                'assigned_to' => 'Selected staff member is invalid.',
            ])->withInput();
        }

        try {
            DB::transaction(function () use ($request, $lead, $detailValidator, $assignedStaff) {
                $oldStatus = $lead->status;
                $oldAssignedTo = $lead->assigned_to;

                $lead->update([
                    'name' => $request->name,
                    'mobile' => $request->mobile,
                    'alternate_mobile' => $request->alternate_mobile,
                    'email' => $request->email,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'pincode' => $request->pincode,
                    'source' => $request->source,
                    'status' => $request->status,
                    'remarks' => $request->remarks,
                    'assigned_to' => $assignedStaff?->id,
                    'assigned_to_type' => $assignedStaff ? 'staff' : null,
                    'assigned_at' => $assignedStaff ? now() : null,
                    'converted_at' => $request->status === 'converted'
                        ? ($lead->converted_at ?? now())
                        : null,
                ]);

                $this->saveModuleDetails(
                    $lead,
                    $detailValidator->validated()
                );

                $this->createActivity(
                    $lead,
                    'lead_updated',
                    'Lead updated',
                    'Lead details updated by hospital admin.',
                    [
                        'old_assigned_to' => $oldAssignedTo,
                        'new_assigned_to' => $assignedStaff?->id,
                    ],
                    $oldStatus,
                    $request->status
                );

                if ($oldAssignedTo != $assignedStaff?->id) {
                    $this->createActivity(
                        $lead,
                        'lead_assigned',
                        'Lead assignment changed',
                        $assignedStaff
                        ? 'Lead assigned to ' . $assignedStaff->name
                        : 'Lead assignment removed.',
                        [
                            'previous_staff_id' => $oldAssignedTo,
                            'assigned_staff_id' => $assignedStaff?->id,
                        ]
                    );
                }
            });

            return redirect()
                ->route('hospital.leads.index')
                ->with('success', 'Lead updated successfully.');

        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Unable to update lead. Please try again.');
        }
    }

    /**
     * Delete lead.
     */
    public function destroy($id)
    {
        $lead = $this->leadQuery()->findOrFail($id);

        try {
            DB::transaction(function () use ($lead) {
                $this->createActivity(
                    $lead,
                    'lead_deleted',
                    'Lead deleted',
                    'Lead deleted by hospital admin.'
                );

                $lead->delete();
            });

            return redirect()
                ->route('hospital.leads.index')
                ->with('success', 'Lead deleted successfully.');

        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'Unable to delete lead.');
        }
    }
}
