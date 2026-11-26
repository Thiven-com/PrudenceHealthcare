
@extends('admin.layout.mainlayout')

@section('content')

<style>
.detail-card {
    background: #fff;
    border: 1px solid #eee;
    border-radius: 12px;
    padding: 22px;
    margin-bottom: 20px;
}

.detail-card h5 {
    font-weight: 700;
    margin-bottom: 18px;
}

.info-label {
    color: #888;
    font-size: 13px;
    margin-bottom: 5px;
}

.info-value {
    font-weight: 600;
    margin-bottom: 18px;
}

.activity-item {
    border-left: 3px solid #dc3545;
    padding: 5px 0 15px 18px;
    margin-bottom: 15px;
}

.activity-item:last-child {
    margin-bottom: 0;
}

.activity-type {
    background: #fff0f0;
    color: #dc3545;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

</style>

<div class="page-wrapper">
    <div class="content">

        <div class="page-header d-flex justify-content-between align-items-center">

            <div>
                <h4>Daily Report Details</h4>
                <h6>View staff report and activities</h6>
            </div>

            <a href="{{ route('admin.staff-daily-reports.index') }}"
               class="btn btn-light">
                <i class="ti ti-arrow-left"></i> Back
            </a>

        </div>

        {{-- Staff Information --}}
        <div class="detail-card">

            <h5>Staff Information</h5>

            <div class="row">

                <div class="col-md-3">
                    <div class="info-label">Staff Name</div>
                    <div class="info-value">
                        {{ $report->staff->name ?? 'N/A' }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info-label">Report Date</div>
                    <div class="info-value">
                        {{ $report->report_date?->format('d M Y') ?? 'N/A' }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info-label">Working Status</div>
                    <div class="info-value">
                        {{ ucfirst(str_replace('_', ' ', $report->working_status ?? 'N/A')) }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info-label">Report Status</div>
                    <div class="info-value">
                        {{ ucfirst(str_replace('_', ' ', $report->status ?? 'N/A')) }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info-label">Start Time</div>
                    <div class="info-value">
                        {{ $report->start_time ? \Carbon\Carbon::parse($report->start_time)->format('h:i A') : '--' }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info-label">End Time</div>
                    <div class="info-value">
                        {{ $report->end_time ? \Carbon\Carbon::parse($report->end_time)->format('h:i A') : '--' }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info-label">Submitted At</div>
                    <div class="info-value">
                        {{ $report->submitted_at?->format('d M Y h:i A') ?? '--' }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info-label">Approved At</div>
                    <div class="info-value">
                        {{ $report->approved_at?->format('d M Y h:i A') ?? '--' }}
                    </div>
                </div>

            </div>

        </div>

        {{-- Daily Work Details --}}
        <div class="detail-card">

            <h5>Daily Work Summary</h5>

            <div class="mb-4">
                <div class="info-label">Work Summary</div>
                <p>{{ $report->work_summary ?: 'No summary provided.' }}</p>
            </div>

            <div class="mb-4">
                <div class="info-label">Achievements</div>
                <p>{{ $report->achievements ?: 'No achievements provided.' }}</p>
            </div>

            <div class="mb-4">
                <div class="info-label">Challenges</div>
                <p>{{ $report->challenges ?: 'No challenges provided.' }}</p>
            </div>

            <div class="mb-4">
                <div class="info-label">Pending Work</div>
                <p>{{ $report->pending_work ?: 'No pending work.' }}</p>
            </div>

            <div>
                <div class="info-label">Tomorrow's Plan</div>
                <p>{{ $report->tomorrow_plan ?: 'No plan provided.' }}</p>
            </div>

        </div>

        {{-- Activities --}}
        <div class="detail-card">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Daily Activities</h5>

                <span class="badge bg-primary">
                    {{ $report->activities->count() }} Activities
                </span>
            </div>

            @forelse($report->activities as $activity)

                <div class="activity-item">

                    <div class="d-flex justify-content-between flex-wrap mb-2">

                        <div>
                            <span class="activity-type">
                                {{ ucfirst(str_replace('_', ' ', $activity->activity_type ?? 'Other')) }}
                            </span>

                            <strong class="ms-2">
                                {{ $activity->organization_name ?? 'N/A' }}
                            </strong>
                        </div>

                        <small class="text-muted">
                            {{ $activity->activity_at?->format('d M Y h:i A') ?? '--' }}
                        </small>

                    </div>

                    <div class="row mt-3">

                        <div class="col-md-4">
                            <div class="info-label">Organization</div>
                            <div class="info-value">
                                {{ $activity->organization_name ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="info-label">Contact Person</div>
                            <div class="info-value">
                                {{ $activity->contact_person ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="info-label">Mobile</div>
                            <div class="info-value">
                                {{ $activity->mobile ?? 'N/A' }}
                            </div>
                        </div>

                    </div>

                    <div class="mb-3">
                        <div class="info-label">Description</div>
                        <p>{{ $activity->description ?: 'N/A' }}</p>
                    </div>

                    <div class="mb-3">
                        <div class="info-label">Outcome</div>
                        <p>{{ $activity->outcome ?: 'N/A' }}</p>
                    </div>

                    <div>
                        <div class="info-label">Next Follow Up</div>
                        <strong>
                            {{ $activity->next_follow_up_at?->format('d M Y h:i A') ?? 'Not scheduled' }}
                        </strong>
                    </div>

                </div>

            @empty

                <div class="text-center py-4">
                    <p class="text-muted">No activities added to this report.</p>
                </div>

            @endforelse

        </div>

    </div>
</div>

@endsection
