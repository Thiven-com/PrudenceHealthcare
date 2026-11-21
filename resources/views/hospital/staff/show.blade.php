<?php $page = 'employee-details'; ?>
@extends('hospital.layout.mainlayout')

@section('content')
    <div class="page-wrapper">
        <div class="content">

            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Staff Profile</h4>
                        <h6>Employee details and information</h6>
                    </div>
                </div>

                <div class="page-btn">
                    <a href="{{ route('hospital.staff.index') }}" class="btn btn-secondary me-2">
                        <i data-feather="arrow-left" class="me-1"></i> Back
                    </a>

                    <a href="{{ route('hospital.staff.edit', $staffMember->id) }}" class="btn btn-primary">
                        <i data-feather="edit" class="me-1"></i> Edit Staff
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="profile-pic-upload edit-pic d-flex align-items-center mb-4">
                        <div class="profile-pic me-3">
                            @if($staffMember->profile_image)
                                <img src="{{ asset($staffMember->profile_image) }}" alt="Staff Image"
                                    class="rounded-circle" style="width:90px;height:90px;object-fit:cover;">
                            @else
                                <div class="avatar avatar-xxl bg-primary text-white">
                                    {{ strtoupper(substr($staffMember->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <div>
                            <h4 class="mb-1">{{ $staffMember->name }}</h4>
                            <p class="text-muted mb-1">
                                {{ $staffMember->designation->name ?? 'Designation not assigned' }}
                            </p>
                            <span class="badge bg-light text-dark">
                                {{ $staffMember->employee_code ?? 'EMP-' . $staffMember->id }}
                            </span>

                            @if($staffMember->status === 'active')
                                <span class="badge bg-success">Active</span>
                            @elseif($staffMember->status === 'inactive')
                                <span class="badge bg-danger">Inactive</span>
                            @else
                                <span class="badge bg-warning text-dark">Suspended</span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <h5 class="mb-3">Employee Information</h5>

                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="text-muted">Employee Code</label>
                            <h6>{{ $staffMember->employee_code ?? '-' }}</h6>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="text-muted">Full Name</label>
                            <h6>{{ $staffMember->name }}</h6>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="text-muted">Email</label>
                            <h6>{{ $staffMember->email ?? '-' }}</h6>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="text-muted">Mobile Number</label>
                            <h6>{{ $staffMember->mobile }}</h6>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="text-muted">Date of Birth</label>
                            <h6>{{ $staffMember->date_of_birth ? \Carbon\Carbon::parse($staffMember->date_of_birth)->format('d M Y') : '-' }}
                            </h6>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="text-muted">Gender</label>
                            <h6>{{ $staffMember->gender ?? '-' }}</h6>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="text-muted">Department</label>
                            <h6>{{ $staffMember->department->name ?? '-' }}</h6>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="text-muted">Designation</label>
                            <h6>{{ $staffMember->designation->name ?? '-' }}</h6>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="text-muted">Reporting Manager</label>
                            <h6>{{ $staffMember->reportingManager->name ?? '-' }}</h6>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="text-muted">Staff Type</label>
                            <h6>{{ $staffMember->staff_type ?? '-' }}</h6>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="text-muted">Joining Date</label>
                            <h6>{{ $staffMember->joining_date ? \Carbon\Carbon::parse($staffMember->joining_date)->format('d M Y') : '-' }}
                            </h6>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="text-muted">Leaving Date</label>
                            <h6>{{ $staffMember->leaving_date ? \Carbon\Carbon::parse($staffMember->leaving_date)->format('d M Y') : '-' }}
                            </h6>
                        </div>
                    </div>

                    <hr>

                    <h5 class="mb-3">Address Information</h5>

                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label class="text-muted">Address</label>
                            <p>{{ $staffMember->address ?? '-' }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="text-muted">Created At</label>
                            <h6>{{ $staffMember->created_at?->format('d M Y, h:i A') ?? '-' }}</h6>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="text-muted">Last Login</label>
                            <h6>{{ $staffMember->last_login_at ? \Carbon\Carbon::parse($staffMember->last_login_at)->format('d M Y, h:i A') : 'Not logged in' }}
                            </h6>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection