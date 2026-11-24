
@csrf

@if(isset($hospital))
    @method('PUT')
@endif

<div class="accordions-items-seperate" id="accordionExample">

    {{-- Hospital Information --}}
    <div class="accordion-item border mb-4">
        <h2 class="accordion-header" id="headingOne">
            <div class="accordion-button bg-white" data-bs-toggle="collapse"
                data-bs-target="#collapseOne" aria-controls="collapseOne">
                <div class="d-flex align-items-center justify-content-between flex-fill">
                    <h5 class="d-inline-flex align-items-center">
                        <i class="ti ti-building-hospital text-primary me-2"></i>
                        <span>Hospital Information</span>
                    </h5>
                </div>
            </div>
        </h2>

        <div id="collapseOne" class="accordion-collapse collapse show">
            <div class="accordion-body border-top">

                <div class="new-employee-field">

                    <div class="profile-pic-upload {{ isset($hospital) ? 'edit-pic' : '' }}">
    <div class="profile-pic">

        <img
            id="hospitalLogoPreview"
            src="{{ isset($hospital) && $hospital->logo ? asset($hospital->logo) : '' }}"
            alt="Hospital Logo"
            style="
                width: 100px;
                height: 100px;
                object-fit: contain;
                {{ isset($hospital) && $hospital->logo ? '' : 'display:none;' }}
            "
        >

        <span id="hospitalLogoPlaceholder"
            style="{{ isset($hospital) && $hospital->logo ? 'display:none;' : '' }}">
            <i data-feather="plus-circle" class="plus-down-add"></i>
            Hospital Logo
        </span>

    </div>

    <div class="input-blocks mb-0">
        <div class="image-upload mb-0">
            <input
                type="file"
                name="logo"
                id="hospital_logo"
                accept="image/*"
            >

            <div class="image-uploads">
                <h4>Change Image</h4>
            </div>
        </div>
    </div>
</div>

@error('logo')
    <div class="text-danger mb-3">{{ $message }}</div>
@enderror

                    @error('logo')
                        <div class="text-danger mb-3">{{ $message }}</div>
                    @enderror

                    <div class="row">

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    Hospital Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="hospital_name"
                                    class="form-control @error('hospital_name') is-invalid @enderror"
                                    value="{{ old('hospital_name', $hospital->hospital_name ?? '') }}"
                                    required>
                                @error('hospital_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Registration Number</label>
                                <input type="text" name="registration_number"
                                    class="form-control"
                                    value="{{ old('registration_number', $hospital->registration_number ?? '') }}">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Contact Person</label>
                                <input type="text" name="contact_person"
                                    class="form-control"
                                    value="{{ old('contact_person', $hospital->contact_person ?? '') }}">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    Mobile Number <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="mobile"
                                    class="form-control @error('mobile') is-invalid @enderror"
                                    value="{{ old('mobile', $hospital->mobile ?? '') }}"
                                    required>
                                @error('mobile')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email"
                                    class="form-control"
                                    value="{{ old('email', $hospital->email ?? '') }}">
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Address Information --}}
    <div class="accordion-item border mb-4">
        <div class="accordion-header" id="headingThree">
            <div class="accordion-button bg-white" data-bs-toggle="collapse"
                data-bs-target="#collapseThree" aria-controls="collapseThree">
                <div class="d-flex align-items-center justify-content-between flex-fill">
                    <h5 class="d-inline-flex align-items-center">
                        <i data-feather="map-pin" class="text-primary me-2"></i>
                        <span>Address Information</span>
                    </h5>
                </div>
            </div>
        </div>

        <div id="collapseThree" class="accordion-collapse collapse show">
            <div class="accordion-body border-top">
                <div class="other-info">
                    <div class="row">

                        <div class="col-lg-12 col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" rows="3" class="form-control">{{ old('address', $hospital->address ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control"
                                    value="{{ old('state', $hospital->state ?? '') }}">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control"
                                    value="{{ old('city', $hospital->city ?? '') }}">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Pincode</label>
                                <input type="text" name="pincode" class="form-control"
                                    value="{{ old('pincode', $hospital->pincode ?? '') }}">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Verification and Approval --}}
    <div class="accordion-item border mb-4">
        <div class="accordion-header" id="headingFour">
            <div class="accordion-button bg-white" data-bs-toggle="collapse"
                data-bs-target="#collapseFour" aria-controls="collapseFour">
                <div class="d-flex align-items-center justify-content-between flex-fill">
                    <h5 class="d-inline-flex align-items-center">
                        <i data-feather="shield-check" class="text-primary me-2"></i>
                        <span>Verification & Approval Information</span>
                    </h5>
                </div>
            </div>
        </div>

        <div id="collapseFour" class="accordion-collapse collapse show">
            <div class="accordion-body border-top">
                <div class="row">

                    <div class="col-lg-4 col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Mobile Verification</label>
                           <select name="is_mobile_verified" class="select form-control">
    <option value="0"
        @selected(old('is_mobile_verified', $hospital->is_mobile_verified ?? 1) == 0)>
        Not Verified
    </option>
    <option value="1"
        @selected(old('is_mobile_verified', $hospital->is_mobile_verified ?? 1) == 1)>
        Verified
    </option>
</select>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Approval Status</label>
                            <select name="approval_status" id="approval_status"
                                class="select form-control">
                                @foreach(['pending', 'approved', 'rejected', 'suspended'] as $status)
                                    <option value="{{ $status }}"
                                        @selected(old('approval_status', $hospital->approval_status ?? 'pending') == $status)>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Account Status</label>
                            <select name="is_active" class="select form-control">
                                <option value="1"
                                    @selected(old('is_active', $hospital->is_active ?? 1) == 1)>
                                    Active
                                </option>
                                <option value="0"
                                    @selected(old('is_active', $hospital->is_active ?? 1) == 0)>
                                    Inactive
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-12" id="rejection_reason_field">
                        <div class="mb-3">
                            <label class="form-label">Rejection Reason</label>
                            <textarea name="rejection_reason" rows="3"
                                class="form-control">{{ old('rejection_reason', $hospital->rejection_reason ?? '') }}</textarea>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


{{-- Lead Module Assignment --}}
<div class="accordion-item border mb-4">

    <div class="accordion-header" id="headingLeadModules">
        <div class="accordion-button bg-white"
             data-bs-toggle="collapse"
             data-bs-target="#collapseLeadModules"
             aria-controls="collapseLeadModules">

            <div class="d-flex align-items-center justify-content-between flex-fill">
                <h5 class="d-inline-flex align-items-center">
                    <i data-feather="layers" class="text-primary me-2"></i>
                    <span>Lead Module Assignment</span>
                </h5>
            </div>

        </div>
    </div>

    <div id="collapseLeadModules" class="accordion-collapse collapse show">
        <div class="accordion-body border-top">

            <div class="alert alert-info">
                Select the lead modules this hospital is allowed to use.
            </div>

            <div class="row">

                @forelse($leadModules as $module)

                    <div class="col-lg-4 col-md-6 mb-3">

                        <div class="border rounded p-3 h-100">

                            <div class="form-check">

                                <input
                                    type="checkbox"
                                    class="form-check-input"
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
                        <div class="alert alert-warning">
                            No active lead modules found.
                            Please add lead modules first.
                        </div>
                    </div>

                @endforelse

            </div>

            @error('lead_module_ids')
                <div class="text-danger">{{ $message }}</div>
            @enderror

            @error('lead_module_ids.*')
                <div class="text-danger">{{ $message }}</div>
            @enderror

        </div>
    </div>

</div>


</div>

<div class="text-end mb-3">
    <a href="{{ route('admin.hospitals.index') }}"
        class="btn btn-secondary me-2">Cancel</a>

    <button type="submit" class="btn btn-primary">
        {{ isset($hospital) ? 'Save Changes' : 'Add Hospital' }}
    </button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const status = document.getElementById('approval_status');
    const reason = document.getElementById('rejection_reason_field');

    function toggleReason() {
        reason.style.display = status.value === 'rejected' ? '' : 'none';
    }

    status.addEventListener('change', toggleReason);
    toggleReason();
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const imageInput = document.getElementById('hospital_logo');
    const preview = document.getElementById('hospitalLogoPreview');
    const placeholder = document.getElementById('hospitalLogoPlaceholder');

    imageInput.addEventListener('change', function () {

        const file = this.files[0];

        if (file) {

            if (!file.type.startsWith('image/')) {
                alert('Please select a valid image.');
                this.value = '';
                return;
            }

            const reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                placeholder.style.display = 'none';
            };

            reader.readAsDataURL(file);
        }

    });

});
</script>
