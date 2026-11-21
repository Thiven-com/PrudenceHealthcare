@php
    $currentModuleId = old('lead_module_id', $lead->lead_module_id ?? '');

    $leadValue = function ($field, $default = '') use ($lead) {
        return old($field, $lead->{$field} ?? $default);
    };

    $detailValue = function ($field, $default = '') use ($detail) {
        return old('details.' . $field, $detail->{$field} ?? $default);
    };
@endphp

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <strong>
            <i class="ti ti-alert-circle me-1"></i>
            Please correct the following errors:
        </strong>

        <ul class="mb-0 mt-2 ps-3">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif


{{-- Common Lead Details --}}
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Basic Lead Information</h5>
    </div>

    <div class="card-body">
        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="form-label">Lead Module <span class="text-danger">*</span></label>

                <select name="lead_module_id" id="lead_module_id" class="form-select" required {{ isset($lead)
    ? 'disabled' : '' }}>
                    <option value="">Select Module</option>

                    @foreach($leadModules as $module)
                        <option value="{{ $module->id }}" {{ $currentModuleId == $module->id ? 'selected' : '' }}>
                            {{ $module->name }}
                        </option>
                    @endforeach
                </select>

                @if(isset($lead))
                    <input type="hidden" name="lead_module_id" value="{{ $lead->lead_module_id }}">
                    <small class="text-muted">Lead module cannot be changed after creation.</small>
                @endif

                @error('lead_module_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">
                    Lead Name <span class="text-danger">*</span>
                </label>

                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ $leadValue('name') }}" required>

                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Mobile <span class="text-danger">*</span></label>
                <input type="text" name="mobile" class="form-control" value="{{ $leadValue('mobile') }}" required>
                @error('mobile') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Alternate Mobile</label>
                <input type="text" name="alternate_mobile" class="form-control"
                    value="{{ $leadValue('alternate_mobile') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $leadValue('email') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Source</label>
                <select name="source" class="form-select">
                    <option value="">Select Source</option>
                    @foreach(['website', 'referral', 'social_media', 'walk_in', 'phone', 'other'] as $source)
                        <option value="{{ $source }}" {{ $leadValue('source') == $source ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $source)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">City</label>
                <input type="text" name="city" class="form-control" value="{{ $leadValue('city') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">State</label>
                <input type="text" name="state" class="form-control" value="{{ $leadValue('state') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Pincode</label>
                <input type="text" name="pincode" class="form-control" value="{{ $leadValue('pincode') }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    @foreach(['new', 'contacted', 'interested', 'follow_up', 'converted', 'lost'] as $status)
                        <option value="{{ $status }}" {{ $leadValue('status', 'new') == $status ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Assign Staff</label>
                <select name="assigned_to" class="form-select">
                    <option value="">Unassigned</option>
                    @foreach($staffMembers as $staff)
                        <option value="{{ $staff->id }}" {{ $leadValue('assigned_to') == $staff->id ? 'selected' : '' }}>
                            {{ $staff->name }} ({{ $staff->employee_code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="2">{{ $leadValue('address') }}</textarea>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Remarks</label>
                <textarea name="remarks" class="form-control" rows="3">{{ $leadValue('remarks') }}</textarea>
            </div>

        </div>
    </div>
</div>

{{-- Module Specific Details --}}
<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">Module Specific Information</h5>
    </div>

    <div class="card-body">

        @foreach($moduleFields as $moduleId => $fields)
            <div class="module-fields" id="module-fields-{{ $moduleId }}"
                style="{{ $currentModuleId == $moduleId ? '' : 'display:none;' }}">

                <div class="row">
                    @foreach($fields as $field)
                        @php
                            $fieldName = $field['name'];
                            $fieldLabel = $field['label'] ?? ucwords(str_replace('_', ' ', $fieldName));
                            $fieldType = $field['type'] ?? 'text';
                            $required = $field['required'] ?? false;
                            $value = $detailValue($fieldName);
                            $options = $field['options'] ?? [];

                            $errorKey = 'details.' . $fieldName;
                            $fieldError = $errors->first($errorKey);
                            $invalidClass = $fieldError ? 'is-invalid' : '';
                        @endphp

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                {{ $fieldLabel }}
                                @if($required)
                                    <span class="text-danger">*</span>
                                @endif
                            </label>

                            @if($fieldType === 'textarea')

                                <textarea name="details[{{ $fieldName }}]" class="form-control module-input {{ $invalidClass }}"
                                    rows="3" {{ $required ? 'required' : '' }}>{{ $value }}</textarea>

                            @elseif($fieldType === 'select')

                                    <select name="details[{{ $fieldName }}]" class="form-select module-input {{ $invalidClass }}" {{
                                $required ? 'required' : '' }}>

                                        <option value="">Select {{ $fieldLabel }}</option>

                                        @foreach($options as $optionValue => $optionLabel)
                                            <option value="{{ $optionValue }}" {{ $value == $optionValue ? 'selected' : '' }}>
                                                {{ $optionLabel }}
                                            </option>
                                        @endforeach

                                    </select>

                            @else

                                    <input type="{{ $fieldType }}" name="details[{{ $fieldName }}]"
                                        class="form-control module-input {{ $invalidClass }}" value="{{ $value }}" {{ $required
                                ? 'required' : '' }}>

                            @endif

                            @if($fieldError)
                                <div class="invalid-feedback d-block">
                                    {{ $fieldError }}
                                </div>
                            @endif

                        </div>
                    @endforeach
                </div>

            </div>
        @endforeach

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const moduleSelect = document.getElementById('lead_module_id');

        function toggleModuleFields() {
            const selectedModule = moduleSelect.value;

            document.querySelectorAll('.module-fields').forEach(function (section) {
                const isActive = section.id === 'module-fields-' + selectedModule;

                section.style.display = isActive ? '' : 'none';

                section.querySelectorAll('input, select, textarea').forEach(function (input) {
                    input.disabled = !isActive;
                });
            });
        }

        if (moduleSelect) {
            moduleSelect.addEventListener('change', toggleModuleFields);
            toggleModuleFields();
        }

    });
</script>