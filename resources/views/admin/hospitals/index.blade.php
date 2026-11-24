
<?php $page = 'hospital-list'; ?>

@extends('admin.layout.mainlayout')

@section('content')

<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Hospitals</h4>
                    <h6>Manage registered hospitals</h6>
                </div>
            </div>

            <ul class="table-top-head">
                <li>
                    <div class="d-flex me-2 pe-2 border-end">
                        <a href="{{ route('admin.hospitals.index') }}"
                            class="btn-list active bg-primary me-2">
                            <i data-feather="list" class="text-white"></i>
                        </a>
                    </div>
                </li>
                <li class="me-2">
                    <a href="{{ route('admin.hospitals.index') }}"
                        data-bs-toggle="tooltip" title="Refresh">
                        <i class="ti ti-refresh"></i>
                    </a>
                </li>
                <li class="me-2">
                    <a data-bs-toggle="tooltip" title="Collapse" id="collapse-header">
                        <i class="ti ti-chevron-up"></i>
                    </a>
                </li>
            </ul>

            <div class="page-btn">
                <a href="{{ route('admin.hospitals.create') }}" class="btn btn-primary">
                    <i class="ti ti-circle-plus me-1"></i>Add Hospital
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Statistics --}}
        <div class="row">

            <div class="col-xl-3 col-md-6">
                <div class="card bg-purple border-0">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-white">Total Hospitals</p>
                            <h4 class="text-white">{{ $totalHospitals }}</h4>
                        </div>
                        <span class="avatar avatar-lg bg-purple-900">
                            <i class="ti ti-building-hospital"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-teal border-0">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-white">Approved</p>
                            <h4 class="text-white">{{ $approvedCount }}</h4>
                        </div>
                        <span class="avatar avatar-lg bg-teal-900">
                            <i class="ti ti-circle-check"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-secondary border-0">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-white">Pending</p>
                            <h4 class="text-white">{{ $pendingCount }}</h4>
                        </div>
                        <span class="avatar avatar-lg bg-secondary-900">
                            <i class="ti ti-clock"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-info border-0">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-white">New This Month</p>
                            <h4 class="text-white">{{ $newJoiners }}</h4>
                        </div>
                        <span class="avatar avatar-lg bg-info-900">
                            <i class="ti ti-building-plus"></i>
                        </span>
                    </div>
                </div>
            </div>

        </div>

        {{-- Hospital Table --}}
        <div class="card">

            <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">

                <form method="GET" action="{{ route('admin.hospitals.index') }}"
                    class="d-flex align-items-center flex-wrap gap-2 w-100">

                    <div class="search-set flex-grow-1">
                        <div class="search-input">
                            <span class="btn-searchset">
                                <i class="ti ti-search fs-14"></i>
                            </span>
                            {{-- <input type="text" name="search"
                                class="form-control"
                                placeholder="Search hospital, registration, mobile..."
                                value="{{ request('search') }}"> --}}
                        </div>
                    </div>

                    <select name="approval_status" class="form-select"
                        style="width:auto;min-width:150px;">
                        <option value="">All Approval Status</option>
                        @foreach(['pending', 'approved', 'rejected', 'suspended'] as $status)
                            <option value="{{ $status }}"
                                @selected(request('approval_status') == $status)>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>

                    <select name="is_active" class="form-select"
                        style="width:auto;min-width:130px;">
                        <option value="">All Accounts</option>
                        <option value="1" @selected(request('is_active') === '1')>
                            Active
                        </option>
                        <option value="0" @selected(request('is_active') === '0')>
                            Inactive
                        </option>
                    </select>

                    <button type="submit" class="btn btn-primary">
                        Filter
                    </button>

                    <a href="{{ route('admin.hospitals.index') }}"
                        class="btn btn-light">
                        Reset
                    </a>

                </form>

            </div>

            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table datatable">
                        <thead class="thead-light">
                            <tr>
                                <th>S.no</th>
                                <th>ID</th>
                                <th>Hospital</th>
                                <th>Registration No</th>
                                <th>Contact Person</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Location</th>
                                <th>Approval</th>
                                <th>Status</th>
                                <th class="no-sort">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($hospitals as $hospital)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.hospitals.show', $hospital->id) }}">
                                            HOS{{ str_pad($hospital->id, 4, '0', STR_PAD_LEFT) }}
                                        </a>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('admin.hospitals.show', $hospital->id) }}"
                                                class="avatar avatar-md">
                                                @if($hospital->logo)
                                                    <img src="{{ asset($hospital->logo) }}"
                                                        class="img-fluid" alt="Hospital">
                                                @else
                                                    <span class="avatar-title bg-light text-primary">
                                                        <i class="ti ti-building-hospital"></i>
                                                    </span>
                                                @endif
                                            </a>

                                            <div class="ms-2">
                                                <p class="text-dark mb-0">
                                                    <a href="{{ route('admin.hospitals.show', $hospital->id) }}">
                                                        {{ $hospital->hospital_name }}
                                                    </a>
                                                </p>
                                                <small class="text-muted">
                                                    {{ $hospital->contact_person ?: 'No contact person' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>{{ $hospital->registration_number ?: '-' }}</td>
                                    <td>{{ $hospital->contact_person ?: '-' }}</td>
                                    <td>{{ $hospital->email ?: '-' }}</td>
                                    <td>{{ $hospital->mobile }}</td>
                                    <td>{{ collect([$hospital->city, $hospital->state])->filter()->implode(', ') ?: '-' }}</td>

                                    <td>
                                        @php
                                            $approvalClass = match($hospital->approval_status) {
                                                'approved' => 'badge-success',
                                                'rejected' => 'badge-danger',
                                                'suspended' => 'badge-secondary',
                                                default => 'badge-warning',
                                            };
                                        @endphp

                                        <span class="badge {{ $approvalClass }} d-inline-flex align-items-center badge-xs">
                                            <i class="ti ti-point-filled me-1"></i>
                                            {{ ucfirst($hospital->approval_status) }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge {{ $hospital->is_active ? 'badge-success' : 'badge-danger' }} d-inline-flex align-items-center badge-xs">
                                            <i class="ti ti-point-filled me-1"></i>
                                            {{ $hospital->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="edit-delete-action d-flex align-items-center">

                                            <a class="me-2 d-flex align-items-center border rounded p-2"
                                                href="{{ route('admin.hospitals.show', $hospital->id) }}"
                                                title="View">
                                                <i data-feather="eye" class="feather-eye"></i>
                                            </a>

                                            <a class="me-2 p-2 d-flex align-items-center border rounded"
                                                href="{{ route('admin.hospitals.edit', $hospital->id) }}"
                                                title="Edit">
                                                <i data-feather="edit" class="feather-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.hospitals.destroy', $hospital->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this hospital?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="p-2 d-flex align-items-center border rounded bg-white"
                                                    title="Delete">
                                                    <i data-feather="trash-2" class="feather-trash-2 text-danger"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-4">
                                        No hospitals found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>

                <div class="d-flex justify-content-end p-3">
                    {{ $hospitals->links() }}
                </div>

            </div>
        </div>

    </div>
</div>

@endsection

@include('admin.layout.partials.footer')
