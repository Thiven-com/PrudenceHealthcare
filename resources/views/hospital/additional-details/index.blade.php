@extends('hospital.layout.mainlayout')

@section('content')

    <div class="page-wrapper">
        <div class="content">

            <div class="page-header mb-4">
                <div>
                    <h3>Hospital Additional Details</h3>
                    <p class="text-muted mb-0">
                        Manage hospital tie-ups, facilities and emergency contacts
                    </p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- HOSPITAL TIEUPS --}}
            <div class="card mb-4">

                <div class="card-header">
                    <h5 class="mb-0">Hospital Tie-ups</h5>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('hospital.additional-details.store', 'tieup') }}"
                        enctype="multipart/form-data">

                        @csrf

                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Organization Name *</label>
                                <input type="text" name="organization_name" class="form-control" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tie-up Type</label>
                                <select name="tieup_type" class="form-select">
                                    <option value="">Select Type</option>
                                    <option value="Insurance">Insurance</option>
                                    <option value="Corporate">Corporate</option>
                                    <option value="Diagnostic">Diagnostic</option>
                                    <option value="Pharmacy">Pharmacy</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Contact Person</label>
                                <input type="text" name="contact_person" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Mobile</label>
                                <input type="text" name="mobile" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Image / Logo</label>
                                <input type="file" name="image" class="form-control"
                                    accept="image/jpeg,image/png,image/webp">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-plus me-1"></i> Add Tie-up
                        </button>

                    </form>

                    <hr>

                    <h6 class="mb-3">Added Tie-ups</h6>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Logo</th>
                                    <th>Organization</th>
                                    <th>Type</th>
                                    <th>Contact</th>
                                    <th>Mobile</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($tieups as $tieup)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>
                                            @if($tieup->image)
                                                <img src="{{ asset($tieup->image) }}" width="55" height="45"
                                                    style="object-fit:contain">
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td>{{ $tieup->organization_name }}</td>
                                        <td>{{ $tieup->tieup_type }}</td>
                                        <td>{{ $tieup->contact_person }}</td>
                                        <td>{{ $tieup->mobile }}</td>

                                        <td>
                                            <span
                                                class="badge {{ $tieup->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ ucfirst($tieup->status) }}
                                            </span>
                                        </td>

                                        <td>
                                            <a href="{{ route('hospital.additional-details.edit', ['type' => 'tieup', 'id' => $tieup->id]) }}"
                                                class="btn btn-sm btn-warning">
                                                Edit
                                            </a>

                                            <form method="POST"
                                                action="{{ route('hospital.additional-details.destroy', ['type' => 'tieup', 'id' => $tieup->id]) }}"
                                                class="d-inline" onsubmit="return confirm('Delete this tie-up?')">
                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">
                                            No tie-ups added yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            {{-- HOSPITAL FACILITIES --}}
            <div class="card mb-4">

                <div class="card-header">
                    <h5 class="mb-0">Hospital Facilities</h5>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('hospital.additional-details.store', 'facility') }}"
                        enctype="multipart/form-data">

                        @csrf

                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Facility Name *</label>
                                <input type="text" name="facility_name" class="form-control" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Category</label>
                                <select name="facility_category" class="form-select">
                                    <option value="">Select Category</option>
                                    <option value="Critical Care">Critical Care</option>
                                    <option value="Emergency">Emergency</option>
                                    <option value="Diagnostic">Diagnostic</option>
                                    <option value="Treatment">Treatment</option>
                                    <option value="General">General</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Operating Hours</label>
                                <input type="text" name="operating_hours" class="form-control"
                                    placeholder="24 Hours / 9 AM - 6 PM">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Contact Number</label>
                                <input type="text" name="contact_number" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Facility Image</label>
                                <input type="file" name="image" class="form-control"
                                    accept="image/jpeg,image/png,image/webp">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Available?</label>
                                <select name="is_available" class="form-select">
                                    <option value="1">Available</option>
                                    <option value="0">Not Available</option>
                                </select>
                            </div>

                            <div class="col-md-8 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-plus me-1"></i> Add Facility
                        </button>

                    </form>

                    <hr>

                    <h6 class="mb-3">Added Facilities</h6>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Facility</th>
                                    <th>Category</th>
                                    <th>Hours</th>
                                    <th>Availability</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($facilities as $facility)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>
                                            @if($facility->image)
                                                <img src="{{ asset($facility->image) }}" width="60" height="45"
                                                    style="object-fit:cover">
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td>{{ $facility->facility_name }}</td>
                                        <td>{{ $facility->facility_category }}</td>
                                        <td>{{ $facility->operating_hours }}</td>

                                        <td>
                                            {{ $facility->is_available ? 'Available' : 'Not Available' }}
                                        </td>

                                        <td>
                                            <span
                                                class="badge {{ $facility->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ ucfirst($facility->status) }}
                                            </span>
                                        </td>

                                        <td>
                                            <a href="{{ route('hospital.additional-details.edit', ['type' => 'facility', 'id' => $facility->id]) }}"
                                                class="btn btn-sm btn-warning">
                                                Edit
                                            </a>

                                            <form method="POST"
                                                action="{{ route('hospital.additional-details.destroy', ['type' => 'facility', 'id' => $facility->id]) }}"
                                                class="d-inline" onsubmit="return confirm('Delete this facility?')">
                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">
                                            No facilities added yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            {{-- EMERGENCY CONNECT --}}
            <div class="card mb-4">

                <div class="card-header">
                    <h5 class="mb-0">Emergency Connect</h5>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('hospital.additional-details.store', 'emergency') }}">

                        @csrf

                        <div class="row">

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Contact Name *</label>
                                <input type="text" name="contact_name" class="form-control" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Contact Designation *</label>
                                <select name="emergency_type" class="form-select" required>
                                    <option value="">Select Designation</option>
                                    <option value="Receptionist">Receptionist</option>
                                    <option value="Front Office Executive">Front Office Executive</option>
                                    <option value="Ward Incharge">Ward Incharge</option>
                                    <option value="Nursing Superintendent">Nursing Superintendent</option>
                                    <option value="Duty Doctor">Duty Doctor</option>
                                    <option value="Emergency Doctor">Emergency Doctor</option>
                                    <option value="Casualty Medical Officer">Casualty Medical Officer</option>
                                    <option value="Ambulance Coordinator">Ambulance Coordinator</option>
                                    <option value="Security Incharge">Security Incharge</option>
                                    <option value="ICU Incharge">ICU Incharge</option>
                                    <option value="OT Incharge">OT Incharge</option>
                                    <option value="Pharmacy Incharge">Pharmacy Incharge</option>
                                    <option value="Blood Bank Incharge">Blood Bank Incharge</option>
                                    <option value="Lab Incharge">Lab Incharge</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Mobile *</label>
                                <input type="text" name="mobile" class="form-control" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Alternate Mobile</label>
                                <input type="text" name="alternate_mobile" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Availability</label>
                                <select name="availability" class="form-select">
                                    <option value="24/7">24/7</option>
                                    <option value="Working Hours">Working Hours</option>
                                    <option value="On Call">On Call</option>
                                </select>
                            </div>

                            <div class="col-md-8 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-plus me-1"></i> Add Emergency Contact
                        </button>

                    </form>

                    <hr>

                    <h6 class="mb-3">Emergency Contacts</h6>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Contact Name</th>
                                    <th>Type</th>
                                    <th>Mobile</th>
                                    <th>Alternate Mobile</th>
                                    <th>Availability</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($emergencyContacts as $contact)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $contact->contact_name }}</td>
                                        <td>{{ $contact->emergency_type }}</td>
                                        <td>{{ $contact->mobile }}</td>
                                        <td>{{ $contact->alternate_mobile }}</td>
                                        <td>{{ $contact->availability }}</td>

                                        <td>
                                            <span
                                                class="badge {{ $contact->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ ucfirst($contact->status) }}
                                            </span>
                                        </td>

                                        <td>
                                            <a href="{{ route('hospital.additional-details.edit', ['type' => 'emergency', 'id' => $contact->id]) }}"
                                                class="btn btn-sm btn-warning">
                                                Edit
                                            </a>

                                            <form method="POST"
                                                action="{{ route('hospital.additional-details.destroy', ['type' => 'emergency', 'id' => $contact->id]) }}"
                                                class="d-inline" onsubmit="return confirm('Delete this emergency contact?')">
                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">
                                            No emergency contacts added yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>

        @include('hospital.layout.partials.footer')
    </div>

@endsection