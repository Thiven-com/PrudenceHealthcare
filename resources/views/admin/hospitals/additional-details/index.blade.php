<?php $page = 'hospital-details'; ?>

@extends('admin.layout.mainlayout')

@section('content')

    <div class="page-wrapper">
        <div class="content">

            <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <a href="{{ route('admin.hospitals.show', $hospital->id) }}">
                        <i class="ti ti-chevron-left me-1"></i>
                        Back to Hospital Details
                    </a>

                    <h4 class="mt-2 mb-1">{{ $title }}</h4>
                    <p class="text-muted mb-0">{{ $hospital->hospital_name }}</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="mb-0">{{ $title }}</h5>
                    <span class="badge bg-primary">
                        {{ $records->total() }} Records
                    </span>
                </div>

                <div class="card-body">

                    <form method="GET" class="row g-2 mb-4">

                        <div class="col-md-5">
                            <input type="text" name="search" class="form-control"
                                placeholder="Search {{ strtolower($title) }}..." value="{{ request('search') }}">
                        </div>

                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                        </div>

                        <div class="col-md-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-search me-1"></i>Search
                            </button>

                            <a href="{{ request()->url() }}" class="btn btn-light">
                                Reset
                            </a>
                        </div>

                    </form>

                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead>
                                <tr>
                                    <th>#</th>

                                    @if($type === 'facilities')
                                        <th>Image</th>
                                        <th>Facility Name</th>
                                        <th>Category</th>
                                        <th>Availability</th>
                                        <th>Operating Hours</th>
                                        <th>Contact</th>

                                    @elseif($type === 'tieups')
                                        <th>Image</th>
                                        <th>Organization</th>
                                        <th>Tie-up Type</th>
                                        <th>Contact Person</th>
                                        <th>Mobile</th>
                                        <th>Email</th>

                                    @else
                                        <th>Contact Name</th>
                                        <th>Designation</th>
                                        <th>Mobile</th>
                                        <th>Alternate Mobile</th>
                                        <th>Email</th>
                                        <th>Availability</th>
                                    @endif

                                    <th>Status</th>
                                    <th>Added On</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($records as $record)

                                    <tr>
                                        <td>{{ $records->firstItem() + $loop->index }}</td>

                                        @if($type === 'facilities')

                                            <td>
                                                @if($record->image)
                                                    <img src="{{ asset($record->image) }}" width="55" height="55"
                                                        class="rounded" style="object-fit:cover">
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <td>
                                                <strong>{{ $record->facility_name }}</strong>
                                                <div class="text-muted fs-13">
                                                    {{ $record->description }}
                                                </div>
                                            </td>

                                            <td>{{ $record->facility_category ?: '-' }}</td>

                                            <td>
                                                <span class="badge {{ $record->is_available ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $record->is_available ? 'Available' : 'Unavailable' }}
                                                </span>
                                            </td>

                                            <td>{{ $record->operating_hours ?: '-' }}</td>
                                            <td>{{ $record->contact_number ?: '-' }}</td>

                                        @elseif($type === 'tieups')

                                            <td>
                                                @if($record->image)
                                                    <img src="{{ asset($record->image) }}" width="55" height="55"
                                                        class="rounded" style="object-fit:cover">
                                                @else
                                                    -
                                                @endif
                                            </td>

                                            <td>
                                                <strong>{{ $record->organization_name }}</strong>
                                                <div class="text-muted fs-13">
                                                    {{ $record->address }}
                                                </div>
                                            </td>

                                            <td>{{ $record->tieup_type ?: '-' }}</td>
                                            <td>{{ $record->contact_person ?: '-' }}</td>
                                            <td>{{ $record->mobile ?: '-' }}</td>
                                            <td>{{ $record->email ?: '-' }}</td>

                                        @else

                                            <td>{{ $record->contact_name }}</td>
                                            <td>{{ $record->emergency_type ?: '-' }}</td>
                                            <td>{{ $record->mobile }}</td>
                                            <td>{{ $record->alternate_mobile ?: '-' }}</td>
                                            <td>{{ $record->email ?: '-' }}</td>
                                            <td>{{ $record->availability ?: '-' }}</td>

                                        @endif

                                        <td>
                                            <span
                                                class="badge {{ $record->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                                                {{ ucfirst($record->status) }}
                                            </span>
                                        </td>

                                        <td>{{ $record->created_at?->format('d M Y') ?? '-' }}</td>
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="12" class="text-center py-5">
                                            <i class="ti ti-database-off fs-1 text-muted"></i>
                                            <h6 class="mt-2">No Records Found</h6>
                                            <p class="text-muted mb-0">
                                                No {{ strtolower($title) }} are available for this hospital.
                                            </p>
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    <div class="mt-3">
                        {{ $records->links('pagination::bootstrap-5') }}
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection

@include('admin.layout.partials.footer')