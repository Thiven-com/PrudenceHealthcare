
<?php $page = 'staff-overview'; ?>

@extends('admin.layout.mainlayout')

@section('content')

<div class="page-wrapper">
    <div class="content">

        {{-- Heading --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap mb-4">
            <div>
                <h2 class="mb-1">Staff Overview</h2>
                <p class="text-muted mb-0">
                    View staff members across all registered hospitals
                </p>
            </div>
        </div>

        {{-- Statistics --}}
        <div class="row">

            <div class="col-xl-3 col-sm-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <span class="avatar avatar-md bg-dark mb-3">
                            <i class="ti ti-users fs-18"></i>
                        </span>
                        <h2>{{ number_format($totalStaff) }}</h2>
                        <p class="mb-0">Total Staff</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <span class="avatar avatar-md bg-success mb-3">
                            <i class="ti ti-user-check fs-18"></i>
                        </span>
                        <h2>{{ number_format($activeStaff) }}</h2>
                        <p class="mb-0">Active Staff</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <span class="avatar avatar-md bg-warning mb-3">
                            <i class="ti ti-user-pause fs-18"></i>
                        </span>
                        <h2>{{ number_format($inactiveStaff) }}</h2>
                        <p class="mb-0">Inactive Staff</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <span class="avatar avatar-md bg-danger mb-3">
                            <i class="ti ti-user-x fs-18"></i>
                        </span>
                        <h2>{{ number_format($suspendedStaff) }}</h2>
                        <p class="mb-0">Suspended Staff</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Filters --}}
        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.staff-overview.index') }}"
                      method="GET">

                    <div class="row align-items-end">

                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="form-label">Search Staff</label>
                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   value="{{ request('search') }}"
                                   placeholder="Name, mobile, email or employee code">
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <label class="form-label">Hospital</label>
                            <select name="hospital_id" class="form-select">
                                <option value="">All Hospitals</option>
                                @foreach($hospitals as $hospital)
                                    <option value="{{ $hospital->id }}"
                                        {{ request('hospital_id') == $hospital->id ? 'selected' : '' }}>
                                        {{ $hospital->hospital_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-2 col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                                <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>
                                    Suspended
                                </option>
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-6 mb-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-search me-1"></i> Filter
                            </button>

                            <a href="{{ route('admin.staff-overview.index') }}"
                               class="btn btn-light">
                                Reset
                            </a>
                        </div>

                    </div>
                </form>

            </div>
        </div>

        {{-- Staff Table --}}
        <div class="card">

            <div class="card-header">
                <h5 class="mb-0">All Hospital Staff</h5>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Employee</th>
                                <th>Employee Code</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Hospital</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Status</th>
                                <th>Joined Date</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($staffMembers as $staff)
                                <tr>
                                    <td>{{ $staffMembers->firstItem() + $loop->index }}</td>

                                    <td>
                                        <h6 class="mb-0">
                                            {{ $staff->name }}
                                        </h6>
                                    </td>

                                    <td>{{ $staff->employee_code ?? '-' }}</td>

                                    <td>{{ $staff->mobile ?? '-' }}</td>

                                    <td>{{ $staff->email ?? '-' }}</td>

                                    <td>{{ $staff->hospital_name ?? '-' }}</td>

                                    <td>{{ $staff->department_name ?? '-' }}</td>

                                    <td>{{ $staff->designation_name ?? '-' }}</td>

                                    <td>
                                        @if($staff->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($staff->status === 'inactive')
                                            <span class="badge bg-warning text-dark">Inactive</span>
                                        @elseif($staff->status === 'suspended')
                                            <span class="badge bg-danger">Suspended</span>
                                        @else
                                            <span class="badge bg-secondary">
                                                {{ ucfirst($staff->status ?? 'Unknown') }}
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $staff->created_at?->format('d M Y') ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-4">
                                        No staff members found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $staffMembers->links() }}
                </div>

            </div>
        </div>

    </div>

    @include('admin.layout.partials.footer')
</div>

@endsection
