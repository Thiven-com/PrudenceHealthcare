

@extends('admin.layout.mainlayout')

@section('content')

    <div class="page-wrapper">
        <div class="content">

            {{-- Page Heading --}}
            <div class="d-flex align-items-center justify-content-between flex-wrap mb-4">
                <div>
                    <h2 class="mb-1">Staff Details</h2>
                    <p class="text-muted mb-0">
                        Complete staff member information
                    </p>
                </div>

                <a href="{{ route('admin.staff-overview.index') }}" class="btn btn-light">
                    <i class="ti ti-arrow-left me-1"></i> Back
                </a>
            </div>

            {{-- Employee Profile --}}
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">

                        <span class="avatar avatar-xxl bg-primary me-3">
                            <i class="ti ti-user fs-36"></i>
                        </span>

                        <div>
                            <h3 class="mb-1">{{ $staff->name ?? '-' }}</h3>

                            <p class="text-muted mb-2">
                                {{ $staff->designation_name ?? '-' }}
                            </p>

                            @if($staff->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @elseif($staff->status == 'inactive')
                                <span class="badge bg-warning text-dark">Inactive</span>
                            @elseif($staff->status == 'suspended')
                                <span class="badge bg-danger">Suspended</span>
                            @else
                                <span class="badge bg-secondary">
                                    {{ ucfirst($staff->status ?? 'Unknown') }}
                                </span>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            {{-- Personal Information --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ti ti-user me-2"></i>
                        Personal Information
                    </h5>
                </div>

                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Full Name</label>
                            <h6>{{ $staff->name ?? '-' }}</h6>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Email Address</label>
                            <h6>{{ $staff->email ?? '-' }}</h6>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Mobile Number</label>
                            <h6>{{ $staff->mobile ?? '-' }}</h6>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Gender</label>
                            <h6>{{ $staff->gender ?? '-' }}</h6>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Date of Birth</label>
                            <h6>
                                {{ $staff->date_of_birth
        ? \Carbon\Carbon::parse($staff->date_of_birth)->format('d M Y')
        : '-' }}
                            </h6>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Address</label>
                            <h6>{{ $staff->address ?? '-' }}</h6>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Hospital Information --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ti ti-building-hospital me-2"></i>
                        Hospital Information
                    </h5>
                </div>

                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Hospital Name</label>
                            <h6>{{ $staff->hospital_name ?? '-' }}</h6>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Department</label>
                            <h6>{{ $staff->department_name ?? '-' }}</h6>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Designation</label>
                            <h6>{{ $staff->designation_name ?? '-' }}</h6>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Employment Information --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ti ti-briefcase me-2"></i>
                        Employment Information
                    </h5>
                </div>

                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Employee ID</label>
                            <h6>{{ $staff->id }}</h6>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Employee Code</label>
                            <h6>{{ $staff->employee_code ?? '-' }}</h6>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Joining Date</label>
                            <h6>
                                {{ $staff->created_at?->format('d M Y') ?? '-' }}
                            </h6>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Employment Status</label>
                            <h6>{{ ucfirst($staff->status ?? '-') }}</h6>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Account Information --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="ti ti-settings me-2"></i>
                        Account Information
                    </h5>
                </div>

                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Staff ID</label>
                            <h6>{{ $staff->id }}</h6>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Created At</label>
                            <h6>
                                {{ $staff->created_at?->format('d M Y, h:i A') ?? '-' }}
                            </h6>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="text-muted">Last Updated</label>
                            <h6>
                                {{ $staff->updated_at?->format('d M Y, h:i A') ?? '-' }}
                            </h6>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        @include('admin.layout.partials.footer')
    </div>

@endsection