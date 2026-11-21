<?php $page = 'hospital-details'; ?>

@extends('admin.layout.mainlayout')

@section('content')

    <div class="page-wrapper">
        <div class="content">

            <div class="page-header">
                <div>
                    <a href="{{ route('admin.hospitals.index') }}" class="d-inline-flex align-items-center">
                        <i class="ti ti-chevron-left me-2"></i>Back to List
                    </a>
                </div>

                <ul class="table-top-head">
                    <li class="me-2">
                        <a data-bs-toggle="tooltip" title="Refresh">
                            <i class="ti ti-refresh"></i>
                        </a>
                    </li>
                    <li class="me-2">
                        <a data-bs-toggle="tooltip" title="Collapse" id="collapse-header">
                            <i class="ti ti-chevron-up"></i>
                        </a>
                    </li>
                </ul>
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
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="row">

                {{-- Left Profile --}}
                <div class="col-xl-4 theiaSticky-xl-Sidebar">

                    <div class="card rounded-0 border-0">

                        <div class="card-header rounded-0 bg-primary d-flex align-items-center">

                            <span class="avatar avatar-xl avatar-rounded flex-shrink-0 border border-white border-3 me-3">
                                @if($hospital->logo)
                                    <img src="{{ asset($hospital->logo) }}" alt="Hospital Logo">
                                @else
                                    <span class="avatar-title bg-white text-primary">
                                        <i class="ti ti-building-hospital fs-1"></i>
                                    </span>
                                @endif
                            </span>

                            <div class="me-3">
                                <h6 class="text-white mb-1">
                                    {{ $hospital->hospital_name }}
                                </h6>

                                <span class="badge bg-white text-primary">
                                    {{ ucfirst($hospital->approval_status) }}
                                </span>
                            </div>

                            <div>
                                <a href="{{ route('admin.hospitals.edit', $hospital->id) }}" class="btn btn-white">
                                    Edit Profile
                                </a>

                            </div>

                        </div>

                        <div class="card-body">

                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-id me-2"></i>Hospital ID
                                </span>
                                <p class="text-dark">
                                    HOS{{ str_pad($hospital->id, 4, '0', STR_PAD_LEFT) }}
                                </p>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-file-text me-2"></i>Registration No
                                </span>
                                <p class="text-dark">
                                    {{ $hospital->registration_number ?: '-' }}
                                </p>
                            </div>

                            <div class="d-flex align-items-center justify-content-between">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-calendar-check me-2"></i>Registered On
                                </span>
                                <p class="text-dark">
                                    {{ $hospital->created_at?->format('d M Y') ?? '-' }}
                                </p>
                            </div>

                        </div>
                    </div>

                    {{-- Approval Status Card --}}
                    <div class="card rounded-0 border-0">
                        <div class="card-header border-0 rounded-0 bg-light">
                            <h6>Account Status</h6>
                        </div>

                        <div class="card-body">

                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span>Approval</span>

                                @php
                                    $approvalClass = match ($hospital->approval_status) {
                                        'approved' => 'badge-success',
                                        'rejected' => 'badge-danger',
                                        'suspended' => 'badge-secondary',
                                        default => 'badge-warning',
                                    };
                                @endphp

                                <span class="badge {{ $approvalClass }}">
                                    {{ ucfirst($hospital->approval_status) }}
                                </span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span>Account</span>
                                <span class="badge {{ $hospital->is_active ? 'badge-success' : 'badge-danger' }}">
                                    {{ $hospital->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>

                            <div class="d-flex align-items-center justify-content-between">
                                <span>Mobile Verification</span>
                                <span class="badge {{ $hospital->is_mobile_verified ? 'badge-success' : 'badge-warning' }}">
                                    {{ $hospital->is_mobile_verified ? 'Verified' : 'Not Verified' }}
                                </span>
                            </div>

                        </div>
                        <div class="card-body">
                            <a href="{{ route('admin.hospitals.documents.index', $hospital->id) }}"
                                class="btn btn-primary mt-3">
                                <i class="ti ti-file-text"></i>
                                Manage Documents
                            </a>
                        </div>
                    </div>

                </div>


                {{-- Right Information --}}
                <div class="col-xl-8">

                    {{-- Basic Information --}}
                    <div class="card rounded-0 border-0">

                        <div class="card-header border-0 rounded-0 bg-light d-flex align-items-center">
                            <h6>Basic Information</h6>
                        </div>

                        <div class="card-body pb-0">
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <p class="fs-13 mb-2">Hospital Name</p>
                                        <span class="text-gray-900 fs-13">
                                            {{ $hospital->hospital_name }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <p class="fs-13 mb-2">Contact Person</p>
                                        <span class="text-gray-900 fs-13">
                                            {{ $hospital->contact_person ?: '-' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <p class="fs-13 mb-2">Registration Number</p>
                                        <span class="text-gray-900 fs-13">
                                            {{ $hospital->registration_number ?: '-' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <p class="fs-13 mb-2">Mobile</p>
                                        <span class="text-gray-900 fs-13">
                                            {{ $hospital->mobile }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <p class="fs-13 mb-2">Email</p>
                                        <span class="text-gray-900 fs-13">
                                            {{ $hospital->email ?: '-' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <p class="fs-13 mb-2">Mobile Verified At</p>
                                        <span class="text-gray-900 fs-13">
                                            {{ $hospital->mobile_verified_at?->format('d M Y, h:i A') ?? '-' }}
                                        </span>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                    {{-- Address Information --}}
                    <div class="card rounded-0 border-0">

                        <div class="card-header border-0 rounded-0 bg-light">
                            <h6>Address Information</h6>
                        </div>

                        <div class="card-body pb-0">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <p class="fs-13 mb-2">Address</p>
                                        <span class="text-gray-900 fs-13">
                                            {{ $hospital->address ?: '-' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <p class="fs-13 mb-2">City</p>
                                        <span class="text-gray-900 fs-13">
                                            {{ $hospital->city ?: '-' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <p class="fs-13 mb-2">State</p>
                                        <span class="text-gray-900 fs-13">
                                            {{ $hospital->state ?: '-' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <p class="fs-13 mb-2">Pincode</p>
                                        <span class="text-gray-900 fs-13">
                                            {{ $hospital->pincode ?: '-' }}
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Approval Information --}}
                    <div class="card rounded-0 border-0">

                        <div class="card-header border-0 rounded-0 bg-light">
                            <h6>Approval Information</h6>
                        </div>

                        <div class="card-body pb-0">
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <p class="fs-13 mb-2">Approval Status</p>
                                        <span class="text-gray-900 fs-13">
                                            {{ ucfirst($hospital->approval_status) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <p class="fs-13 mb-2">Approved By</p>
                                        <span class="text-gray-900 fs-13">
                                            {{ $hospital->approved_by ?: '-' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <p class="fs-13 mb-2">Approved At</p>
                                        <span class="text-gray-900 fs-13">
                                            {{ $hospital->approved_at?->format('d M Y, h:i A') ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                                @if($hospital->approval_status === 'rejected')
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <p class="fs-13 mb-2">Rejection Reason</p>
                                            <span class="text-gray-900 fs-13">
                                                {{ $hospital->rejection_reason ?: '-' }}
                                            </span>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="card rounded-0 border-0">
                        <div class="card-header border-0 rounded-0 bg-light">
                            <h6>Hospital Approval Actions</h6>
                        </div>

                        <div class="card-body">

                            @if($hospital->approval_status === 'pending')

                                <div class="d-flex flex-wrap gap-2">

                                    <form action="{{ route('admin.hospitals.approve', $hospital->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success"
                                            onclick="return confirm('Approve this hospital?')">
                                            <i class="ti ti-check me-1"></i>Approve Hospital
                                        </button>
                                    </form>

                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#rejectHospitalModal">
                                        <i class="ti ti-x me-1"></i>Reject Hospital
                                    </button>

                                </div>

                            @elseif($hospital->approval_status === 'approved')

                                <form action="{{ route('admin.hospitals.suspend', $hospital->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-warning"
                                        onclick="return confirm('Suspend this hospital?')">
                                        <i class="ti ti-ban me-1"></i>Suspend Hospital
                                    </button>
                                </form>

                            @elseif($hospital->approval_status === 'suspended')

                                <form action="{{ route('admin.hospitals.reactivate', $hospital->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success"
                                        onclick="return confirm('Reactivate this hospital?')">
                                        <i class="ti ti-refresh me-1"></i>Reactivate Hospital
                                    </button>
                                </form>

                            @elseif($hospital->approval_status === 'rejected')

                                <p class="text-danger mb-0">
                                    This hospital has been rejected.
                                </p>

                            @endif

                        </div>
                    </div>

                    {{-- Reject Modal --}}
                    <div class="modal fade" id="rejectHospitalModal" tabindex="-1"
                        aria-labelledby="rejectHospitalModalLabel" aria-hidden="true">

                        <div class="modal-dialog modal-dialog-centered">

                            <div class="modal-content">

                                <form action="{{ route('admin.hospitals.reject', $hospital->id) }}" method="POST">

                                    @csrf

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rejectHospitalModalLabel">
                                            Reject Hospital
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">

                                        <p>
                                            You are rejecting
                                            <strong>{{ $hospital->hospital_name }}</strong>.
                                        </p>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                Rejection Reason <span class="text-danger">*</span>
                                            </label>

                                            <textarea name="rejection_reason" class="form-control" rows="4" required
                                                placeholder="Enter reason for rejection">{{ old('rejection_reason') }}</textarea>

                                            @error('rejection_reason')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                            Cancel
                                        </button>

                                        <button type="submit" class="btn btn-danger">
                                            Reject Hospital
                                        </button>
                                    </div>

                                </form>

                            </div>

                        </div>
                    </div>


                    {{-- Login Information --}}
                    <div class="card rounded-0 border-0">

                        <div class="card-header border-0 rounded-0 bg-light">
                            <h6>Login Information</h6>
                        </div>

                        <div class="card-body pb-0">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <p class="fs-13 mb-2">Last Login</p>
                                        <span class="text-gray-900 fs-13">
                                            {{ $hospital->last_login_at?->format('d M Y, h:i A') ?? 'Never logged in' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <p class="fs-13 mb-2">Created At</p>
                                        <span class="text-gray-900 fs-13">
                                            {{ $hospital->created_at?->format('d M Y, h:i A') ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Delete Hospital --}}
                    <div class="card rounded-0 border-0">
                        <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-2">

                            <div>
                                <h6 class="mb-1">Delete Hospital</h6>
                                <p class="text-muted mb-0">
                                    This hospital will be soft deleted.
                                </p>
                            </div>

                            <form action="{{ route('admin.hospitals.destroy', $hospital->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this hospital?');">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger">
                                    <i data-feather="trash-2" class="me-1"></i>
                                    Delete Hospital
                                </button>

                            </form>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection

@include('admin.layout.partials.footer')