
@extends('hospital.layout.mainlayout')

@section('content')

<style>
    .report-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 22px;
        margin-bottom: 20px;
    }

    .report-heading {
        font-size: 17px;
        font-weight: 700;
        margin-bottom: 18px;
    }

    .detail-label {
        color: #777;
        font-size: 13px;
        margin-bottom: 5px;
    }

    .detail-value {
        font-weight: 600;
        color: #333;
        margin-bottom: 18px;
        overflow-wrap: anywhere;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .status-draft {
        background: #f1f1f1;
        color: #555;
    }

    .status-submitted {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-approved {
        background: #dcfce7;
        color: #15803d;
    }

    .status-revision_requested {
        background: #ffedd5;
        color: #c2410c;
    }

    .activity-item {
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 18px;
        margin-bottom: 15px;
    }

    .activity-type {
        display: inline-block;
        background: #e0f2fe;
        color: #0369a1;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }
</style>

<div class="page-wrapper">
    <div class="content">

        {{-- Page Header --}}
        <div class="page-header d-flex justify-content-between align-items-center">

            <div>
                <h4>Staff Daily Report Details</h4>
                <h6>View complete staff report and activities</h6>
            </div>

            <a href="{{ route('hospital.staff-daily-reports.index') }}"
               class="btn btn-light">
                <i class="ti ti-arrow-left"></i> Back
            </a>

        </div>

        {{-- Report Information --}}
        <div class="report-card">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="report-heading mb-0">Report Information</h5>

                <span class="status-badge status-{{ $report->status }}">
                    {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                </span>
            </div>

            <div class="row">

                <div class="col-md-4">
                    <div class="detail-label">Staff Name</div>
                    <div class="detail-value">
                        {{ $report->staff->name ?? 'N/A' }}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="detail-label">Report Date</div>
                    <div class="detail-value">
                        {{ $report->report_date?->format('d M Y') ?? 'N/A' }}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="detail-label">Working Status</div>
                    <div class="detail-value">
                        {{ ucfirst(str_replace('_', ' ', $report->working_status ?? 'N/A')) }}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="detail-label">Start Time</div>
                    <div class="detail-value">
                        {{ $report->start_time ? \Carbon\Carbon::parse($report->start_time)->format('h:i A') : '--' }}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="detail-label">End Time</div>
                    <div class="detail-value">
                        {{ $report->end_time ? \Carbon\Carbon::parse($report->end_time)->format('h:i A') : '--' }}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="detail-label">Submitted At</div>
                    <div class="detail-value">
                        {{ $report->submitted_at?->format('d M Y h:i A') ?? '--' }}
                    </div>
                </div>

            </div>

        </div>

        {{-- Work Summary --}}
        <div class="report-card">

            <h5 class="report-heading">Daily Work Summary</h5>

            <div class="detail-label">Work Summary</div>
            <div class="detail-value">
                {!! nl2br(e($report->work_summary ?? 'Not provided')) !!}
            </div>

            <div class="detail-label">Achievements</div>
            <div class="detail-value">
                {!! nl2br(e($report->achievements ?? 'Not provided')) !!}
            </div>

            <div class="detail-label">Challenges</div>
            <div class="detail-value">
                {!! nl2br(e($report->challenges ?? 'Not provided')) !!}
            </div>

            <div class="detail-label">Pending Work</div>
            <div class="detail-value">
                {!! nl2br(e($report->pending_work ?? 'Not provided')) !!}
            </div>

            <div class="detail-label">Tomorrow's Plan</div>
            <div class="detail-value">
                {!! nl2br(e($report->tomorrow_plan ?? 'Not provided')) !!}
            </div>

        </div>

        {{-- Staff Activities --}}
        <div class="report-card">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="report-heading mb-0">Staff Activities</h5>

                <span class="badge bg-info">
                    {{ $report->activities->count() }} Activities
                </span>
            </div>

            @forelse($report->activities as $activity)

                <div class="activity-item">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <span class="activity-type">
                            {{ ucfirst(str_replace('_', ' ', $activity->activity_type ?? 'Other')) }}
                        </span>

                        <small class="text-muted">
                            {{ $activity->activity_at ? \Carbon\Carbon::parse($activity->activity_at)->format('d M Y h:i A') : '--' }}
                        </small>

                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="detail-label">Organization</div>
                            <div class="detail-value">
                                {{ $activity->organization_name ?? '--' }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="detail-label">Contact Person</div>
                            <div class="detail-value">
                                {{ $activity->contact_person ?? '--' }}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="detail-label">Mobile</div>
                            <div class="detail-value">
                                {{ $activity->mobile ?? '--' }}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="detail-label">Description</div>
                            <div class="detail-value">
                                {!! nl2br(e($activity->description ?? '--')) !!}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="detail-label">Outcome</div>
                            <div class="detail-value">
                                {!! nl2br(e($activity->outcome ?? '--')) !!}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="detail-label">Next Follow-up</div>
                            <div class="detail-value">
                                {{ $activity->next_follow_up_at ? \Carbon\Carbon::parse($activity->next_follow_up_at)->format('d M Y h:i A') : '--' }}
                            </div>
                        </div>

                    </div>

                </div>

            @empty

                <div class="text-center py-4">
                    <p class="text-muted mb-0">
                        No activities found for this report.
                    </p>
                </div>

            @endforelse

        </div>

    </div>
</div>

@endsection
