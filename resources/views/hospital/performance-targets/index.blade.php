<?php $page = 'performance-targets'; ?>
@extends('hospital.layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">

        {{-- Page Header --}}
        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Performance Targets</h4>
                    <h6>Manage designation-wise targets for your hospital</h6>
                </div>
            </div>

            <ul class="table-top-head">
                <li class="me-2">
                    <a href="{{ route('hospital.performance-targets.index') }}" data-bs-toggle="tooltip" title="Refresh">
                        <i class="ti ti-refresh"></i>
                    </a>
                </li>
                <li>
                    <a data-bs-toggle="tooltip" title="Collapse" id="collapse-header">
                        <i class="ti ti-chevron-up"></i>
                    </a>
                </li>
            </ul>
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

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Statistics --}}
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-purple border-0">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-white">Total Targets</p>
                            <h4 class="text-white">{{ $targets->total() }}</h4>
                        </div>
                        <span class="avatar avatar-lg bg-purple-900">
                            <i class="ti ti-target"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-teal border-0">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-white">Active Targets</p>
                            <h4 class="text-white">
                                {{ $targets->getCollection()->where('status', 'active')->count() }}
                            </h4>
                        </div>
                        <span class="avatar avatar-lg bg-teal-900">
                            <i class="ti ti-check"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-secondary border-0">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-white">Inactive Targets</p>
                            <h4 class="text-white">
                                {{ $targets->getCollection()->where('status', 'inactive')->count() }}
                            </h4>
                        </div>
                        <span class="avatar avatar-lg bg-secondary-900">
                            <i class="ti ti-ban"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-info border-0">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-white">Designations</p>
                            <h4 class="text-white">{{ $designations->count() }}</h4>
                        </div>
                        <span class="avatar avatar-lg bg-info-900">
                            <i class="ti ti-id-badge"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Create Target --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Add Performance Target</h5>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('hospital.performance-targets.store') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Designation <span class="text-danger">*</span></label>
                            <select name="designation_id" class="form-select" required>
                                <option value="">Select Designation</option>
                                @foreach($designations as $designation)
                                    <option value="{{ $designation->id }}"
                                        {{ old('designation_id') == $designation->id ? 'selected' : '' }}>
                                        {{ $designation->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Target Name <span class="text-danger">*</span></label>
                            <input type="text" name="target_name" class="form-control"
                                   value="{{ old('target_name') }}" placeholder="e.g. Monthly Lead Target" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Target Type <span class="text-danger">*</span></label>
                            <select name="target_type" class="form-select" required>
                                <option value="">Select Target Type</option>
                                @foreach($targetTypes as $type)
                                    <option value="{{ $type }}"
                                        {{ old('target_type') == $type ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $type)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Target Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="target_quantity" class="form-control"
                                   min="1" value="{{ old('target_quantity') }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Target Period <span class="text-danger">*</span></label>
                            <select name="target_period" class="form-select" required>
                                @foreach($periods as $period)
                                    <option value="{{ $period }}"
                                        {{ old('target_period', 'monthly') == $period ? 'selected' : '' }}>
                                        {{ ucfirst($period) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" name="start_date" class="form-control"
                                   value="{{ old('start_date') }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">End Date</label>
                            <input type="date" name="end_date" class="form-control"
                                   value="{{ old('end_date') }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-circle-plus me-1"></i> Save Target
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Target List --}}
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                <h5 class="card-title mb-0">Performance Target List</h5>

                <form method="GET" action="{{ route('hospital.performance-targets.index') }}"
                      class="d-flex align-items-center flex-wrap gap-2">

                    <select name="designation_id" class="form-select" style="width: auto;">
                        <option value="">All Designations</option>
                        @foreach($designations as $designation)
                            <option value="{{ $designation->id }}"
                                {{ request('designation_id') == $designation->id ? 'selected' : '' }}>
                                {{ $designation->name }}
                            </option>
                        @endforeach
                    </select>

                    <select name="target_type" class="form-select" style="width: auto;">
                        <option value="">All Types</option>
                        @foreach($targetTypes as $type)
                            <option value="{{ $type }}"
                                {{ request('target_type') == $type ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $type)) }}
                            </option>
                        @endforeach
                    </select>

                    <select name="status" class="form-select" style="width: auto;">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>

                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-filter me-1"></i> Filter
                    </button>

                    <a href="{{ route('hospital.performance-targets.index') }}" class="btn btn-light">Reset</a>
                </form>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table datatable">
                        <thead class="thead-light">
                            <tr>
                                <th>S.no</th>
                                <th>Designation</th>
                                <th>Target Name</th>
                                <th>Type</th>
                                <th>Period</th>
                                <th>Quantity</th>
                                <th>Duration</th>
                                <th>Status</th>
                                <th class="no-sort">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($targets as $target)
                                <tr>
                                    <td>{{ $targets->firstItem() + $loop->index }}</td>
                                    <td>{{ $target->designation->name ?? '-' }}</td>
                                    <td>{{ $target->target_name }}</td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ ucfirst(str_replace('_', ' ', $target->target_type)) }}
                                        </span>
                                    </td>
                                    <td>{{ ucfirst($target->target_period) }}</td>
                                    <td>{{ $target->target_quantity }}</td>
                                    <td>
                                        {{ $target->start_date?->format('d M Y') ?? '-' }}
                                        <span class="text-muted">to</span>
                                        {{ $target->end_date?->format('d M Y') ?? '-' }}
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $target->status == 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($target->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($target->status == 'active')
                                            <form action="{{ route('hospital.performance-targets.destroy', $target->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Deactivate this target?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn p-2 border rounded" title="Deactivate">
                                                    <i data-feather="slash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">No performance targets found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if(method_exists($targets, 'links'))
                <div class="card-footer">
                    {{ $targets->withQueryString()->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection