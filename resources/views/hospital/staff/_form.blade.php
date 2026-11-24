
@php
    $editing = isset($staffMember);
@endphp

<div class="accordion-card-one accordion" id="staffAccordion">

    {{-- Employee Information --}}
    <div class="accordion-item">
        <div class="accordion-header p-3">
            <div class="accordion-button" data-bs-toggle="collapse"
                 data-bs-target="#staffInformation">
                <div class="addproduct-icon d-flex align-items-center flex-fill">
                    <h5 class="d-inline-flex align-items-center mb-0">
                        <i data-feather="info" class="text-primary me-2"></i>
                        Employee Information
                    </h5>
                </div>
            </div>
        </div>

        <div id="staffInformation" class="accordion-collapse collapse show">
            <div class="accordion-body">
                <div class="new-employee-field">

                    <div class="profile-pic-upload edit-pic mb-4">
                        <div class="profile-pic">
                            <span>
                                <img id="staffImagePreview"
                                     src="{{ $editing && $staffMember->profile_image
                                        ? asset($staffMember->profile_image)
                                        : asset('build/img/users/user-01.jpg') }}"
                                     alt="Staff Image"
                                     style="width:80px;height:80px;object-fit:cover;">
                            </span>
                        </div>

                        <div class="me-3 mb-0">
                            <div class="image-upload mb-0">
                                <input type="file"
                                       name="profile_image"
                                       id="profile_image"
                                       accept="image/*">
                                <div class="image-uploads">
                                    <h4>Upload / Change Image</h4>
                                </div>
                            </div>
                            @error('profile_image')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Employee Code</label>
                                <input type="text" name="employee_code"
                                       class="form-control"
                                       value="{{ old('employee_code', $staffMember->employee_code ?? '') }}"
                                       placeholder="Enter employee code">
                                @error('employee_code') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control"
                                       value="{{ old('name', $staffMember->name ?? '') }}"
                                       placeholder="Enter full name" required>
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                       value="{{ old('email', $staffMember->email ?? '') }}"
                                       placeholder="Enter email address">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                <input type="text" name="mobile" class="form-control"
                                       value="{{ old('mobile', $staffMember->mobile ?? '') }}"
                                       placeholder="Enter mobile number" required>
                                @error('mobile') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="date_of_birth" class="form-control"
                                       value="{{ old('date_of_birth', isset($staffMember->date_of_birth) ? \Carbon\Carbon::parse($staffMember->date_of_birth)->format('Y-m-d') : '') }}">
                                @error('date_of_birth') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="">Select Gender</option>
                                    @foreach(['Male', 'Female', 'Other'] as $gender)
                                        <option value="{{ $gender }}"
                                            {{ old('gender', $staffMember->gender ?? '') == $gender ? 'selected' : '' }}>
                                            {{ $gender }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Department</label>
                                <select name="department_id" id="department_id" class="form-select" required>
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ old('department_id', $staffMember->department_id ?? '') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Designation</label>
                                <select name="designation_id" id="designation_id" class="form-select" required>
                                    <option value="">Select Designation</option>
                                    @foreach($designations as $designation)
                                        <option value="{{ $designation->id }}"
                                                data-department="{{ $designation->department_id }}"
                                            {{ old('designation_id', $staffMember->designation_id ?? '') == $designation->id ? 'selected' : '' }}>
                                            {{ $designation->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('designation_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Reporting Manager</label>
                                <select name="reporting_manager_id" class="form-select">
                                    <option value="">Select Reporting Manager</option>
                                    @foreach($managers as $manager)
                                        <option value="{{ $manager->id }}"
                                            {{ old('reporting_manager_id', $staffMember->reporting_manager_id ?? '') == $manager->id ? 'selected' : '' }}>
                                            {{ $manager->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('reporting_manager_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Staff Type</label>
                                <select name="staff_type" class="form-select">
                                    <option value="">Select Staff Type</option>
                                    @foreach(['Doctor', 'Nurse', 'Administrative', 'Technician', 'Support', 'Other'] as $type)
                                        <option value="{{ $type }}"
                                            {{ old('staff_type', $staffMember->staff_type ?? '') == $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Joining Date</label>
                                <input type="date" name="joining_date" class="form-control"
                                       value="{{ old('joining_date', isset($staffMember->joining_date) ? \Carbon\Carbon::parse($staffMember->joining_date)->format('Y-m-d') : '') }}">
                                @error('joining_date') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        @if($editing)
                            <div class="col-lg-4 col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Leaving Date</label>
                                    <input type="date" name="leaving_date" class="form-control"
                                           value="{{ old('leaving_date', $staffMember->leaving_date ? \Carbon\Carbon::parse($staffMember->leaving_date)->format('Y-m-d') : '') }}">
                                    @error('leaving_date') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                        @endif

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    @foreach(['active' => 'Active', 'inactive' => 'Inactive', 'suspended' => 'Suspended'] as $value => $label)
                                        <option value="{{ $value }}"
                                            {{ old('status', $staffMember->status ?? 'active') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Address Information --}}
    <div class="accordion-item">
        <div class="accordion-header p-3">
            <div class="accordion-button" data-bs-toggle="collapse"
                 data-bs-target="#staffAddress">
                <div class="addproduct-icon d-flex align-items-center flex-fill">
                    <h5 class="d-inline-flex align-items-center mb-0">
                        <i data-feather="map-pin" class="text-primary me-2"></i>
                        Address Information
                    </h5>
                </div>
            </div>
        </div>

        <div id="staffAddress" class="accordion-collapse collapse show">
            <div class="accordion-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="4"
                                      placeholder="Enter complete address">{{ old('address', $staffMember->address ?? '') }}</textarea>
                            @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{-- Lead Module Assignment --}}
<div class="accordion-item">
    <div class="accordion-header p-3">
        <div class="accordion-button" data-bs-toggle="collapse"
             data-bs-target="#staffLeadModules">
            <div class="addproduct-icon d-flex align-items-center flex-fill">
                <h5 class="d-inline-flex align-items-center mb-0">
                    <i data-feather="layers" class="text-primary me-2"></i>
                    Lead Module Assignment
                </h5>
            </div>
        </div>
    </div>

    <div id="staffLeadModules" class="accordion-collapse collapse show">
        <div class="accordion-body">

            <div class="alert alert-info">
                Select the lead modules this staff member is allowed to access.
            </div>

            <div class="row">

                @forelse($leadModules as $module)
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="border rounded p-3 h-100">

                            <div class="form-check">
                                <input
                                    class="form-check-input lead-module-checkbox"
                                    type="checkbox"
                                    name="lead_module_ids[]"
                                    value="{{ $module->id }}"
                                    id="lead_module_{{ $module->id }}"
                                    {{ in_array(
                                        $module->id,
                                        old('lead_module_ids', $selectedModules ?? [])
                                    ) ? 'checked' : '' }}
                                >

                                <label
                                    class="form-check-label fw-semibold"
                                    for="lead_module_{{ $module->id }}"
                                >
                                    {{ $module->name }}
                                </label>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning mb-0">
                            No lead modules are enabled for this hospital.
                            Please enable modules first.
                        </div>
                    </div>
                @endforelse

            </div>

            @error('lead_module_ids')
                <small class="text-danger">{{ $message }}</small>
            @enderror

            @error('lead_module_ids.*')
                <small class="text-danger">{{ $message }}</small>
            @enderror

        </div>
    </div>
</div>


</div>

<div class="text-end my-3">
    <a href="{{ route('hospital.staff.index') }}" class="btn btn-secondary me-2">
        Cancel
    </a>
    <button type="submit" class="btn btn-primary">
        {{ $editing ? 'Save Changes' : 'Create Staff' }}
    </button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const departmentSelect = document.getElementById('department_id');
    const designationSelect = document.getElementById('designation_id');
    const imageInput = document.getElementById('profile_image');
    const imagePreview = document.getElementById('staffImagePreview');

    function filterDesignations() {
        const departmentId = departmentSelect.value;
        const currentValue = designationSelect.value;

        Array.from(designationSelect.options).forEach(option => {
            if (!option.value) {
                option.hidden = false;
                return;
            }

            option.hidden = departmentId &&
                option.dataset.department !== departmentId;
        });

        const selectedOption = designationSelect.options[designationSelect.selectedIndex];

        if (selectedOption && selectedOption.hidden) {
            designationSelect.value = '';
        }
    }

    departmentSelect.addEventListener('change', filterDesignations);

    imageInput.addEventListener('change', function (event) {
        const file = event.target.files[0];

        if (file) {
            imagePreview.src = URL.createObjectURL(file);
        }
    });

    filterDesignations();
});
</script>
