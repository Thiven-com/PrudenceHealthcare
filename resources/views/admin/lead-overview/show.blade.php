
<?php $page = 'lead-overview'; ?>

@extends('admin.layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="mb-1">Lead Details</h2>
                <p class="text-muted mb-0">{{ $lead->leadcode }}</p>
            </div>

            <a href="{{ route('admin.lead-overview.index') }}" class="btn btn-light">
                <i class="ti ti-arrow-left me-1"></i> Back
            </a>
        </div>

        <div class="row">

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Lead Information</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Lead Code</th>
                                <td>{{ $lead->leadcode }}</td>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{ $lead->name }}</td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <td>{{ $lead->mobile }}</td>
                            </tr>
                            <tr>
                                <th>Alternate Mobile</th>
                                <td>{{ $lead->alternate_mobile ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $lead->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $lead->address ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>{{ $lead->city ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ ucfirst(str_replace('_', ' ', $lead->status)) }}</td>
                            </tr>
                            <tr>
                                <th>Source</th>
                                <td>{{ $lead->source ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Remarks</th>
                                <td>{{ $lead->remarks ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Hospital & Module</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <th>Hospital</th>
                                <td>{{ $lead->hospital?->hospital_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Lead Module</th>
                                <td>{{ $lead->leadModule?->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Assigned To</th>
                                <td>{{ $lead->assigned_to ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Created Date</th>
                                <td>{{ $lead->created_at?->format('d M Y h:i A') ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Next Follow Up</th>
                                <td>{{ $lead->next_follow_up_at ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Follow-up History</h5>
                    </div>
                    <div class="card-body">
                        @forelse($lead->followUps as $followUp)
                            <div class="border-bottom pb-3 mb-3">
                                <h6>
                                    {{ $followUp->follow_up_type ?? 'Follow-up' }}
                                </h6>
                                <p class="mb-1">
                                    {{ $followUp->discussion ?? '-' }}
                                </p>
                                <small class="text-muted">
                                    {{ $followUp->follow_up_date ?? '-' }}
                                </small>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No follow-up records.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Activity History</h5>
                    </div>
                    <div class="card-body">
                        @forelse($lead->activities as $activity)
                            <div class="border-bottom pb-3 mb-3">
                                <h6>{{ $activity->title ?? $activity->activity_type }}</h6>
                                <p class="mb-1">{{ $activity->description ?? '-' }}</p>
                                <small class="text-muted">
                                    {{ $activity->performed_at ?? $activity->created_at }}
                                </small>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No activity records.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

    </div>

    @include('admin.layout.partials.footer')
</div>
@endsection
