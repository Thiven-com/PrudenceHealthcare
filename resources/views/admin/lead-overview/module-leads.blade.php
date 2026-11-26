<?php $page = 'lead-overview'; ?>

@extends('admin.layout.mainlayout')

@section('content')
    <div class="page-wrapper">
        <div class="content">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2>{{ $module->name }} Leads</h2>
                    <p class="text-muted mb-0">
                        Total Leads: {{ $leads->total() }}
                    </p>
                </div>

                <a href="{{ route('admin.lead-modules.index') }}" class="btn btn-light">
                    <i class="ti ti-arrow-left me-1"></i> Back
                </a>
            </div>

            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Lead Code</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Hospital</th>
                                    <th>Assigned Staff</th>
                                    <th>Status</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($leads as $lead)
                                    <tr>
                                        <td>{{ $leads->firstItem() + $loop->index }}</td>
                                        <td>{{ $lead->leadcode }}</td>
                                        <td>{{ $lead->name }}</td>
                                        <td>{{ $lead->mobile }}</td>
                                        <td>{{ $lead->hospital?->hospital_name ?? '-' }}</td>
                                        <td>{{ $lead->assignedStaff?->name ?? 'Unassigned' }}</td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                                            </span>
                                        </td>
                                        <td>{{ $lead->created_at?->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.lead-overview.lead.show', $lead->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="ti ti-eye me-1"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">
                                            No leads found for this module.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $leads->links() }}
                    </div>

                </div>
            </div>

        </div>

        @include('admin.layout.partials.footer')
    </div>
@endsection