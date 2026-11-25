<?php $page = 'employees-list'; ?>
@extends('hospital.layout.mainlayout')

@section('content')
    <div class="page-wrapper">
        <div class="content">

            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Hospital Staff</h4>
                        <h6>Manage your hospital employees</h6>
                    </div>
                </div>

                <ul class="table-top-head">
                    <li class="me-2">
                        <a href="{{ route('hospital.staff.index') }}" data-bs-toggle="tooltip" title="Refresh">
                            <i class="ti ti-refresh"></i>
                        </a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" title="Collapse" id="collapse-header">
                            <i class="ti ti-chevron-up"></i>
                        </a>
                    </li>
                </ul>

                <div class="page-btn">
                    <a href="{{ route('hospital.staff.create') }}" class="btn btn-primary">
                        <i class="ti ti-circle-plus me-1"></i> Add Staff
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-purple border-0">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-1 text-white">Total Staff</p>
                                <h4 class="text-white">{{ $staff->count() }}</h4>
                            </div>
                            <span class="avatar avatar-lg bg-purple-900">
                                <i class="ti ti-users-group"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-teal border-0">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-1 text-white">Active</p>
                                <h4 class="text-white">{{ $staff->where('status', 'active')->count() }}</h4>
                            </div>
                            <span class="avatar avatar-lg bg-teal-900">
                                <i class="ti ti-user-check"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-secondary border-0">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-1 text-white">Inactive</p>
                                <h4 class="text-white">{{ $staff->where('status', 'inactive')->count() }}</h4>
                            </div>
                            <span class="avatar avatar-lg bg-secondary-900">
                                <i class="ti ti-user-exclamation"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-info border-0">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div>
                                <p class="mb-1 text-white">Suspended</p>
                                <h4 class="text-white">{{ $staff->where('status', 'suspended')->count() }}</h4>
                            </div>
                            <span class="avatar avatar-lg bg-info-900">
                                <i class="ti ti-user-x"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <h5 class="card-title mb-0">Staff List</h5>

                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <select class="form-select" id="departmentFilter" style="width: auto;">
                            <option value="">All Departments</option>
                            @foreach($staff->pluck('department.name')->filter()->unique() as $department)
                                <option value="{{ $department }}">{{ $department }}</option>
                            @endforeach
                        </select>

                        <select class="form-select" id="statusFilter" style="width: auto;">
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table datatable" id="staffTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>S.no</th>
                                    <th>Employee ID</th>
                                    <th>Employee</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Staff Type</th>
                                    <th>Status</th>
                                    <th class="no-sort">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($staff as $member)
                                    <tr>
                                        <td>{{  $loop->iteration }}</td>
                                        <td>
                                            {{ $member->employee_code ?? ('EMP-' . $member->id) }}
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('hospital.staff.show', $member->id) }}"
                                                    class="avatar avatar-md">
                                                    @if($member->profile_image)
                                                        <img src="{{ asset($member->profile_image) }}"
                                                            class="img-fluid" alt="Staff">
                                                    @else
                                                        <span class="avatar-title">
                                                            {{ strtoupper(substr($member->name, 0, 1)) }}
                                                        </span>
                                                    @endif
                                                </a>

                                                <div class="ms-2">
                                                    <p class="text-dark mb-0">
                                                        <a href="{{ route('hospital.staff.show', $member->id) }}">
                                                            {{ $member->name }}
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                        </td>

                                        <td>{{ $member->department->name ?? '-' }}</td>
                                        <td>{{ $member->designation->name ?? '-' }}</td>
                                        <td>{{ $member->email ?? '-' }}</td>
                                        <td>{{ $member->mobile }}</td>
                                        <td>{{ $member->staff_type ?? '-' }}</td>

                                        <td>
                                            @if($member->status === 'active')
                                                <span class="badge badge-success d-inline-flex align-items-center badge-xs">
                                                    <i class="ti ti-point-filled me-1"></i>Active
                                                </span>
                                            @elseif($member->status === 'inactive')
                                                <span class="badge badge-danger d-inline-flex align-items-center badge-xs">
                                                    <i class="ti ti-point-filled me-1"></i>Inactive
                                                </span>
                                            @else
                                                <span class="badge badge-warning d-inline-flex align-items-center badge-xs">
                                                    <i class="ti ti-point-filled me-1"></i>Suspended
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="edit-delete-action d-flex align-items-center">
                                                <a class="me-2 d-flex align-items-center border rounded p-2"
                                                    href="{{ route('hospital.staff.show', $member->id) }}" title="View">
                                                    <i data-feather="eye"></i>
                                                </a>

                                                <a class="me-2 p-2 d-flex align-items-center border rounded"
                                                    href="{{ route('hospital.staff.edit', $member->id) }}" title="Edit">
                                                    <i data-feather="edit"></i>
                                                </a>

                                                <form action="{{ route('hospital.staff.destroy', $member->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this staff member?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn p-2 d-flex align-items-center border rounded" title="Delete">
                                                        <i data-feather="trash-2"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            No staff members found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const departmentFilter = document.getElementById('departmentFilter');
            const statusFilter = document.getElementById('statusFilter');
            const table = document.getElementById('staffTable');

            function filterStaff() {
                const department = departmentFilter.value.toLowerCase();
                const status = statusFilter.value.toLowerCase();

                table.querySelectorAll('tbody tr').forEach(row => {
                    const departmentText = row.cells[2]?.textContent.trim().toLowerCase() || '';
                    const statusText = row.cells[7]?.textContent.trim().toLowerCase() || '';

                    row.style.display =
                        (!department || departmentText === department) &&
                            (!status || statusText.includes(status))
                            ? ''
                            : 'none';
                });
            }

            departmentFilter.addEventListener('change', filterStaff);
            statusFilter.addEventListener('change', filterStaff);
        });
    </script>
@endsection