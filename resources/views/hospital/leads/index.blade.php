
<?php $page = 'leads-list'; ?>
@extends('hospital.layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">

        {{-- Page Header --}}
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Lead Management</h4>
                    <h6>Manage and track your hospital leads</h6>
                </div>
            </div>

            <ul class="table-top-head">
                <li class="me-2">
                    <a href="{{ route('hospital.leads.index') }}" data-bs-toggle="tooltip" title="Refresh">
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
                <a href="{{ route('hospital.leads.create') }}" class="btn btn-primary">
                    <i class="ti ti-circle-plus me-1"></i> Add Lead
                </a>
            </div>
        </div>

        {{-- Flash Messages --}}
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

        {{-- Statistics --}}
        <div class="row">

            <div class="col-xl-3 col-md-6">
                <div class="card bg-purple border-0">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-white">Total Leads</p>
                            <h4 class="text-white">{{ $totalLeads }}</h4>
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
                            <p class="mb-1 text-white">New Leads</p>
                            <h4 class="text-white">{{ $newLeads }}</h4>
                        </div>
                        <span class="avatar avatar-lg bg-teal-900">
                            <i class="ti ti-user-plus"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-secondary border-0">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-white">Converted Leads</p>
                            <h4 class="text-white">{{ $convertedLeads }}</h4>
                        </div>
                        <span class="avatar avatar-lg bg-secondary-900">
                            <i class="ti ti-user-check"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-info border-0">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-white">Unassigned Leads</p>
                            <h4 class="text-white">{{ $unassignedLeads }}</h4>
                        </div>
                        <span class="avatar avatar-lg bg-info-900">
                            <i class="ti ti-user-question"></i>
                        </span>
                    </div>
                </div>
            </div>

        </div>

        {{-- Lead List --}}
        <div class="card">

            <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                <h5 class="card-title mb-0">Lead List</h5>

                <div class="d-flex align-items-center flex-wrap gap-2">

                    <form method="GET" action="{{ route('hospital.leads.index') }}"
                          class="d-flex align-items-center flex-wrap gap-2">

                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Search leads..."
                               value="{{ request('search') }}"
                               style="width: 190px;">

                        <select name="module_id" class="form-select" style="width: auto;">
                            <option value="">All Modules</option>
                            @foreach($leadModules as $module)
                                <option value="{{ $module->id }}"
                                    {{ request('module_id') == $module->id ? 'selected' : '' }}>
                                    {{ $module->name }}
                                </option>
                            @endforeach
                        </select>

                        <select name="status" class="form-select" style="width: auto;">
                            <option value="">All Status</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}"
                                    {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </select>

                        <select name="assigned_to" class="form-select" style="width: auto;">
                            <option value="">All Staff</option>
                            @foreach($staffMembers as $staff)
                                <option value="{{ $staff->id }}"
                                    {{ request('assigned_to') == $staff->id ? 'selected' : '' }}>
                                    {{ $staff->name }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-filter me-1"></i> Filter
                        </button>

                        <a href="{{ route('hospital.leads.index') }}" class="btn btn-light">
                            Reset
                        </a>

                    </form>

                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table datatable" id="leadsTable">
                        <thead class="thead-light">
                            <tr>
                                <th>S.no</th>
                                <th>Lead ID</th>
                                <th>Lead Name</th>
                                <th>Module</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Assigned Staff</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th class="no-sort">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($leads as $lead)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $lead->leadcode ?? ('LD-' . $lead->id) }}
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('hospital.leads.show', $lead->id) }}"
                                               class="avatar avatar-md bg-light">
                                                <span class="avatar-title">
                                                    {{ strtoupper(substr($lead->name ?? 'L', 0, 1)) }}
                                                </span>
                                            </a>

                                            <div class="ms-2">
                                                <p class="text-dark mb-0">
                                                    <a href="{{ route('hospital.leads.show', $lead->id) }}">
                                                        {{ $lead->name }}
                                                    </a>
                                                </p>
                                                <small class="text-muted">
                                                    {{ $lead->city ?? '-' }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="badge badge-info">
                                            {{ $lead->leadModule->name ?? '-' }}
                                        </span>
                                    </td>

                                    <td>{{ $lead->email ?? '-' }}</td>

                                    <td>{{ $lead->mobile ?? '-' }}</td>

                                    <td>
                                        {{ $lead->assignedStaff->name ?? 'Unassigned' }}
                                    </td>

                                    <td>
                                        @php
                                            $statusColors = [
                                                'new' => 'info',
                                                'contacted' => 'primary',
                                                'interested' => 'success',
                                                'follow_up' => 'warning',
                                                'converted' => 'success',
                                                'not_interested' => 'danger',
                                                'closed' => 'secondary',
                                            ];

                                            $statusColor = $statusColors[$lead->status] ?? 'secondary';
                                        @endphp

                                        <span class="badge badge-{{ $statusColor }} d-inline-flex align-items-center badge-xs">
                                            <i class="ti ti-point-filled me-1"></i>
                                            {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $lead->created_at?->format('d M Y') }}
                                    </td>

                                    <td>
                                        <div class="edit-delete-action d-flex align-items-center">

                                            <a class="me-2 d-flex align-items-center border rounded p-2"
                                               href="{{ route('hospital.leads.show', $lead->id) }}"
                                               title="View">
                                                <i data-feather="eye"></i>
                                            </a>

                                            <a class="me-2 p-2 d-flex align-items-center border rounded"
                                               href="{{ route('hospital.leads.edit', $lead->id) }}"
                                               title="Edit">
                                                <i data-feather="edit"></i>
                                            </a>

                                            <form action="{{ route('hospital.leads.destroy', $lead->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this lead?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn p-2 d-flex align-items-center border rounded"
                                                        title="Delete">
                                                    <i data-feather="trash-2"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        No leads found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>

            @if(method_exists($leads, 'links'))
                <div class="card-footer">
                    {{ $leads->withQueryString()->links() }}
                </div>
            @endif

        </div>

    </div>
</div>
@endsection
