@extends('hospital.layout.mainlayout')

@section('content')

<div class="page-wrapper">
    <div class="content">

        <div class="page-header mb-4">
            <div>
                <h3>Edit {{ $config['title'] }}</h3>
                <p class="text-muted">Update hospital information</p>
            </div>

            <a href="{{ route('hospital.additional-details.index') }}"
               class="btn btn-light">
                <i class="ti ti-arrow-left me-1"></i> Back
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ $config['title'] }} Information</h5>
            </div>

            <div class="card-body">

                <form method="POST"
                      action="{{ route('hospital.additional-details.update', ['type' => $type, 'id' => $record->id]) }}"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="row">

                        @if($type === 'tieup')

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Organization Name *</label>
                                <input type="text" name="organization_name"
                                       class="form-control" required
                                       value="{{ old('organization_name', $record->organization_name) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tie-up Type</label>
                                <select name="tieup_type" class="form-select">
                                    @foreach(['Insurance', 'Corporate', 'Diagnostic', 'Pharmacy', 'Other'] as $option)
                                        <option value="{{ $option }}"
                                            {{ old('tieup_type', $record->tieup_type) == $option ? 'selected' : '' }}>
                                            {{ $option }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Contact Person</label>
                                <input type="text" name="contact_person"
                                       class="form-control"
                                       value="{{ old('contact_person', $record->contact_person) }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Mobile</label>
                                <input type="text" name="mobile"
                                       class="form-control"
                                       value="{{ old('mobile', $record->mobile) }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email"
                                       class="form-control"
                                       value="{{ old('email', $record->email) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control">{{ old('address', $record->address) }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control">{{ old('description', $record->description) }}</textarea>
                            </div>

                        @elseif($type === 'facility')

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Facility Name *</label>
                                <input type="text" name="facility_name"
                                       class="form-control" required
                                       value="{{ old('facility_name', $record->facility_name) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Facility Category</label>
                                <select name="facility_category" class="form-select">
                                    @foreach(['Critical Care', 'Emergency', 'Diagnostic', 'Treatment', 'General', 'Other'] as $option)
                                        <option value="{{ $option }}"
                                            {{ old('facility_category', $record->facility_category) == $option ? 'selected' : '' }}>
                                            {{ $option }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Operating Hours</label>
                                <input type="text" name="operating_hours"
                                       class="form-control"
                                       value="{{ old('operating_hours', $record->operating_hours) }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Contact Number</label>
                                <input type="text" name="contact_number"
                                       class="form-control"
                                       value="{{ old('contact_number', $record->contact_number) }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Availability</label>
                                <select name="is_available" class="form-select">
                                    <option value="1" {{ old('is_available', $record->is_available) == 1 ? 'selected' : '' }}>
                                        Available
                                    </option>
                                    <option value="0" {{ old('is_available', $record->is_available) == 0 ? 'selected' : '' }}>
                                        Not Available
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control">{{ old('description', $record->description) }}</textarea>
                            </div>

                        @elseif($type === 'emergency')

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Contact Name *</label>
                                <input type="text" name="contact_name"
                                       class="form-control" required
                                       value="{{ old('contact_name', $record->contact_name) }}">
                            </div>

                           <div class="col-md-6 mb-3">
    <label class="form-label">Contact Designation *</label>
    <select name="emergency_type" class="form-select" required>
        <option value="">Select Designation</option>

        @foreach([
            'Receptionist',
            'Front Office Executive',
            'Ward Incharge',
            'Nursing Superintendent',
            'Duty Doctor',
            'Emergency Doctor',
            'Casualty Medical Officer',
            'Ambulance Coordinator',
            'Security Incharge',
            'ICU Incharge',
            'OT Incharge',
            'Pharmacy Incharge',
            'Blood Bank Incharge',
            'Lab Incharge',
            'Other'
        ] as $option)
            <option value="{{ $option }}"
                {{ old('emergency_type', $record->emergency_type) == $option ? 'selected' : '' }}>
                {{ $option }}
            </option>
        @endforeach
    </select>
</div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Mobile *</label>
                                <input type="text" name="mobile"
                                       class="form-control" required
                                       value="{{ old('mobile', $record->mobile) }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Alternate Mobile</label>
                                <input type="text" name="alternate_mobile"
                                       class="form-control"
                                       value="{{ old('alternate_mobile', $record->alternate_mobile) }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email"
                                       class="form-control"
                                       value="{{ old('email', $record->email) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Availability</label>
                                <select name="availability" class="form-select">
                                    @foreach(['24/7', 'Working Hours', 'On Call'] as $option)
                                        <option value="{{ $option }}"
                                            {{ old('availability', $record->availability) == $option ? 'selected' : '' }}>
                                            {{ $option }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control">{{ old('description', $record->description) }}</textarea>
                            </div>

                        @endif

                        {{-- Image for tieup and facility --}}
                        @if(in_array($type, ['tieup', 'facility']))

                            <div class="col-md-6 mb-3">

                                <label class="form-label">Upload Image</label>

                                <input type="file" name="image"
                                       class="form-control"
                                       accept="image/jpeg,image/png,image/webp">

                                <small class="text-muted">
                                    JPG, PNG, WEBP. Maximum 5 MB.
                                </small>

                                @if($record->image)
                                    <div class="mt-3">
                                        <img src="{{ asset($record->image) }}"
                                             width="150"
                                             height="100"
                                             style="object-fit:contain;border:1px solid #ddd;padding:5px;border-radius:6px">
                                    </div>
                                @endif

                            </div>

                        @endif

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>

                            <select name="status" class="form-select">
                                <option value="active"
                                    {{ old('status', $record->status) == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="inactive"
                                    {{ old('status', $record->status) == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>

                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i> Update Details
                        </button>

                        <a href="{{ route('hospital.additional-details.index') }}"
                           class="btn btn-light">
                            Cancel
                        </a>
                    </div>

                </form>

            </div>
        </div>

    </div>

    @include('hospital.layout.partials.footer')
</div>

@endsection