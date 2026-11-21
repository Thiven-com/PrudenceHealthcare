<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Staff;
use App\Models\LeadModule;
use App\Models\HospitalModule;
use App\Models\StaffPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    private function hospitalId()
    {
        return Auth::guard('hospital')->id();
    }

    /**
     * Get modules enabled for this hospital.
     */
    private function getHospitalLeadModules()
    {
        $enabledModuleIds = HospitalModule::where('hospital_id', $this->hospitalId())
            ->where('is_enabled', 1)
            ->pluck('lead_module_id');

        return LeadModule::whereIn('id', $enabledModuleIds)
            ->where('is_active', 1)
            ->orderBy('name')
            ->get();
    }

    public function index()
    {
        $staff = Staff::with(['department', 'designation'])
            ->where('hospital_id', $this->hospitalId())
            ->latest()
            ->get();

        return view('hospital.staff.index', compact('staff'));
    }

    public function create()
    {
        $departments = Department::where('hospital_id', $this->hospitalId())
            ->where('is_active', 1)
            ->orderBy('name')
            ->get();

        $designations = Designation::where('hospital_id', $this->hospitalId())
            ->where('is_active', 1)
            ->orderBy('name')
            ->get();

        $managers = Staff::where('hospital_id', $this->hospitalId())
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $leadModules = $this->getHospitalLeadModules();

        $selectedModules = [];

        return view('hospital.staff.create', compact(
            'departments',
            'designations',
            'managers',
            'leadModules',
            'selectedModules'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'department_id' => ['nullable', 'integer'],
            'designation_id' => ['nullable', 'integer'],
            'reporting_manager_id' => ['nullable', 'integer'],
            'employee_code' => ['nullable', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:255'],
            'mobile' => [
                'required',
                'string',
                'max:20',
                Rule::unique('staff', 'mobile'),
            ],
            'email' => ['nullable', 'email', 'max:255'],
            'gender' => ['nullable', 'string', 'max:30'],
            'date_of_birth' => ['nullable', 'date'],
            'address' => ['nullable', 'string'],
            'profile_image' => ['nullable', 'image', 'max:2048'],
            'staff_type' => ['nullable', 'string', 'max:100'],
            'joining_date' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['active', 'inactive', 'suspended'])],

            'lead_module_ids' => ['nullable', 'array'],
            'lead_module_ids.*' => ['required', 'integer'],
        ]);

        $this->validateHospitalRelations($validated);
        $moduleIds = $this->validateHospitalModules($validated['lead_module_ids'] ?? []);

        $profileImage = null;

        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image')
                ->store('hospitals/staff', 'public');
        }

        DB::transaction(function () use ($validated, $profileImage, $moduleIds) {

            $staff = Staff::create([
                'hospital_id' => $this->hospitalId(),
                'department_id' => $validated['department_id'] ?? null,
                'designation_id' => $validated['designation_id'] ?? null,
                'reporting_manager_id' => $validated['reporting_manager_id'] ?? null,
                'employee_code' => $validated['employee_code'] ?? null,
                'name' => $validated['name'],
                'mobile' => $validated['mobile'],
                'email' => $validated['email'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'address' => $validated['address'] ?? null,
                'profile_image' => $profileImage,
                'staff_type' => $validated['staff_type'] ?? null,
                'joining_date' => $validated['joining_date'] ?? null,
                'status' => $validated['status'],
            ]);

            $this->syncStaffModules($staff, $moduleIds);
        });

        return redirect()
            ->route('hospital.staff.index')
            ->with('success', 'Staff created successfully.');
    }

    public function show($id)
    {
        $staffMember = Staff::with(['department', 'designation'])
            ->where('hospital_id', $this->hospitalId())
            ->findOrFail($id);

        $assignedModules = StaffPermission::with('leadModule')
            ->where('hospital_id', $this->hospitalId())
            ->where('staff_id', $staffMember->id)
            ->get();

        return view('hospital.staff.show', compact(
            'staffMember',
            'assignedModules'
        ));
    }

    public function edit($id)
    {
        $staffMember = Staff::where('hospital_id', $this->hospitalId())
            ->findOrFail($id);

        $departments = Department::where('hospital_id', $this->hospitalId())
            ->where('is_active', 1)
            ->orderBy('name')
            ->get();

        $designations = Designation::where('hospital_id', $this->hospitalId())
            ->where('is_active', 1)
            ->orderBy('name')
            ->get();

        $managers = Staff::where('hospital_id', $this->hospitalId())
            ->where('status', 'active')
            ->where('id', '!=', $staffMember->id)
            ->orderBy('name')
            ->get();

        $leadModules = $this->getHospitalLeadModules();

        $selectedModules = StaffPermission::where('hospital_id', $this->hospitalId())
            ->where('staff_id', $staffMember->id)
            ->pluck('lead_module_id')
            ->toArray();

        return view('hospital.staff.edit', compact(
            'staffMember',
            'departments',
            'designations',
            'managers',
            'leadModules',
            'selectedModules'
        ));
    }

    public function update(Request $request, $id)
    {
        $staffMember = Staff::where('hospital_id', $this->hospitalId())
            ->findOrFail($id);
        $validated = $request->validate([
            'department_id' => ['nullable', 'integer'],
            'designation_id' => ['nullable', 'integer'],
            'reporting_manager_id' => ['nullable', 'integer'],
            'employee_code' => ['nullable', 'string', 'max:100'],
            'name' => ['required', 'string', 'max:255'],
            'mobile' => [
                'required',
                'string',
                'max:20',
                function ($attribute, $value, $fail) use ($staffMember) {
                    $exists = Staff::where('mobile', $value)
                        ->where('id', '!=', $staffMember->id)
                        ->exists();

                    if ($exists) {
                        $fail('The mobile number has already been taken.');
                    }
                },
            ],
            'email' => ['nullable', 'email', 'max:255'],
            'gender' => ['nullable', 'string', 'max:30'],
            'date_of_birth' => ['nullable', 'date'],
            'address' => ['nullable', 'string'],
            'profile_image' => ['nullable', 'image', 'max:2048'],
            'staff_type' => ['nullable', 'string', 'max:100'],
            'joining_date' => ['nullable', 'date'],
            'leaving_date' => ['nullable', 'date', 'after_or_equal:joining_date'],
            'status' => ['required', Rule::in(['active', 'inactive', 'suspended'])],

            'lead_module_ids' => ['nullable', 'array'],
            'lead_module_ids.*' => ['required', 'integer'],
        ]);

        $this->validateHospitalRelations($validated);
        $moduleIds = $this->validateHospitalModules($validated['lead_module_ids'] ?? []);

        $profileImage = $staffMember->profile_image;

        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image')
                ->store('hospitals/staff', 'public');
        }

        DB::transaction(function () use ($staffMember, $validated, $profileImage, $moduleIds) {
            $staffMember->update([
                'department_id' => $validated['department_id'] ?? null,
                'designation_id' => $validated['designation_id'] ?? null,
                'reporting_manager_id' => $validated['reporting_manager_id'] ?? null,
                'employee_code' => $validated['employee_code'] ?? null,
                'name' => $validated['name'],
                'mobile' => $validated['mobile'],
                'email' => $validated['email'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'address' => $validated['address'] ?? null,
                'profile_image' => $profileImage,
                'staff_type' => $validated['staff_type'] ?? null,
                'joining_date' => $validated['joining_date'] ?? null,
                'leaving_date' => $validated['leaving_date'] ?? null,
                'status' => $validated['status'],
            ]);

            $this->syncStaffModules($staffMember, $moduleIds);
        });

        return redirect()
            ->route('hospital.staff.index')
            ->with('success', 'Staff updated successfully.');
    }

    public function destroy($id)
    {
        $staffMember = Staff::where('hospital_id', $this->hospitalId())
            ->findOrFail($id);

        $staffMember->delete();

        return redirect()
            ->route('hospital.staff.index')
            ->with('success', 'Staff deleted successfully.');
    }

    /**
     * Validate that selected modules are enabled for this hospital.
     */
    private function validateHospitalModules(array $moduleIds): array
    {
        $moduleIds = array_values(array_unique(array_map('intval', $moduleIds)));

        if (empty($moduleIds)) {
            return [];
        }

        $validIds = HospitalModule::where('hospital_id', $this->hospitalId())
            ->where('is_enabled', 1)
            ->whereIn('lead_module_id', $moduleIds)
            ->whereHas('leadModule', function ($query) {
                $query->where('is_active', 1);
            })
            ->pluck('lead_module_id')
            ->map(fn($id) => (int) $id)
            ->toArray();

        if (count($validIds) !== count($moduleIds)) {
            abort(422, 'One or more selected lead modules are invalid or disabled.');
        }

        return $validIds;
    }

    /**
     * Save assigned modules for staff.
     */
    private function syncStaffModules(Staff $staff, array $moduleIds): void
    {
        StaffPermission::where('hospital_id', $this->hospitalId())
            ->where('staff_id', $staff->id)
            ->delete();

        foreach ($moduleIds as $moduleId) {
            StaffPermission::create([
                'hospital_id' => $this->hospitalId(),
                'staff_id' => $staff->id,
                'lead_module_id' => $moduleId,

                'can_view' => 1,
                'can_create' => 1,
                'can_edit' => 1,
                'can_delete' => 0,
                'can_assign' => 0,
                'can_export' => 0,

                'assigned_by' => $this->hospitalId(),
                'assigned_at' => now(),
            ]);
        }
    }

    private function validateHospitalRelations(array $data): void
    {
        $hospitalId = $this->hospitalId();

        if (!empty($data['department_id'])) {
            Department::where('hospital_id', $hospitalId)
                ->findOrFail($data['department_id']);
        }

        if (!empty($data['designation_id'])) {
            $designation = Designation::where('hospital_id', $hospitalId)
                ->findOrFail($data['designation_id']);

            if (
                !empty($data['department_id']) &&
                (int) $designation->department_id !== (int) $data['department_id']
            ) {
                abort(422, 'The selected designation does not belong to the selected department.');
            }
        }

        if (!empty($data['reporting_manager_id'])) {
            Staff::where('hospital_id', $hospitalId)
                ->where('status', 'active')
                ->findOrFail($data['reporting_manager_id']);
        }
    }
}
