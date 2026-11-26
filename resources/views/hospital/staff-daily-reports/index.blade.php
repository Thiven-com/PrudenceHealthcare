
@extends('hospital.layout.mainlayout')

@section('content')

<style>
    .report-card {
        border: 1px solid #eee;
        border-radius: 12px;
        background: #fff;
        padding: 20px;
        margin-bottom: 20px;
    }

    .report-stat {
        border-radius: 12px;
        padding: 20px;
        background: #fff;
        border: 1px solid #eee;
    }

    .report-stat h3 {
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .report-stat p {
        color: #777;
        margin: 0;
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

    .working-badge {
        background: #f3e8ff;
        color: #7e22ce;
        padding: 5px 10px;
        border-radius: 15px;
        font-size: 12px;
        text-transform: capitalize;
    }

    .table td,
    .table th {
        vertical-align: middle;
    }

    .filter-box {
        background: #fff;
        padding: 18px;
        border-radius: 12px;
        border: 1px solid #eee;
    }
</style>

<div class="page-wrapper">
    <div class="content">

        {{-- Page Header --}}
        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h4>Staff Daily Reports</h4>
                <h6>Monitor your hospital staff daily activities</h6>
            </div>
        </div>

        {{-- Statistics --}}
        <div class="row mb-4">

            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="report-stat">
                    <h3>{{ $totalReports }}</h3>
                    <p>Total Reports</p>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="report-stat">
                    <h3 class="text-primary">{{ $submittedReports }}</h3>
                    <p>Submitted Reports</p>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="report-stat">
                    <h3 class="text-success">{{ $approvedReports }}</h3>
                    <p>Approved Reports</p>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="report-stat">
                    <h3 class="text-warning">{{ $draftReports }}</h3>
                    <p>Draft Reports</p>
                </div>
            </div>

        </div>

        {{-- Filters --}}
        <div class="filter-box mb-4">

            <form method="GET"
                  action="{{ route('hospital.staff-daily-reports.index') }}">

                <div class="row align-items-end">

                    <div class="col-md-3 mb-3">
                        <label>Search Staff</label>
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Staff name"
                               value="{{ request('search') }}">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>Staff</label>

                        <select name="staff_id" class="form-control">
                            <option value="">All Staff</option>

                            @foreach($staffList as $staff)
                                <option value="{{ $staff->id }}"
                                    {{ request('staff_id') == $staff->id ? 'selected' : '' }}>
                                    {{ $staff->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>Report Date</label>
                        <input type="date"
                               name="report_date"
                               class="form-control"
                               value="{{ request('report_date') }}">
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>Report Status</label>

                        <select name="status" class="form-control">
                            <option value="">All Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Submitted</option>
                            <option value="revision_requested" {{ request('status') == 'revision_requested' ? 'selected' : '' }}>Revision Requested</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label>Working Status</label>

                        <select name="working_status" class="form-control">
                            <option value="">All</option>
                            <option value="present" {{ request('working_status') == 'present' ? 'selected' : '' }}>Present</option>
                            <option value="half_day" {{ request('working_status') == 'half_day' ? 'selected' : '' }}>Half Day</option>
                            <option value="leave" {{ request('working_status') == 'leave' ? 'selected' : '' }}>Leave</option>
                        </select>
                    </div>

                    <div class="col-md-1 mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-search"></i>
                        </button>
                    </div>

                </div>

                <a href="{{ route('hospital.staff-daily-reports.index') }}"
                   class="btn btn-sm btn-light">
                    Clear Filters
                </a>

            </form>

        </div>

        {{-- Reports Table --}}
        <div class="report-card">

            <div class="d-flex justify-content-between mb-3">
                <h5>Daily Report List</h5>

                <span class="text-muted">
                    {{ $reports->total() }} Reports
                </span>
            </div>

            <div class="table-responsive">

                <table class="table table-hover">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Staff</th>
                            <th>Report Date</th>
                            <th>Working Status</th>
                            <th>Working Hours</th>
                            <th>Activities</th>
                            <th>Report Status</th>
                            <th>Submitted At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($reports as $key => $report)

                            <tr>
                                <td>{{ $reports->firstItem() + $key }}</td>

                                <td>
                                    <strong>
                                        {{ $report->staff->name ?? 'N/A' }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $report->report_date?->format('d M Y') ?? 'N/A' }}
                                </td>

                                <td>
                                    <span class="working-badge">
                                        {{ ucfirst(str_replace('_', ' ', $report->working_status ?? 'N/A')) }}
                                    </span>
                                </td>

                                <td>
                                    {{ $report->start_time ? \Carbon\Carbon::parse($report->start_time)->format('h:i A') : '--' }}
                                    -
                                    {{ $report->end_time ? \Carbon\Carbon::parse($report->end_time)->format('h:i A') : '--' }}
                                </td>

                                <td>
                                    <span class="badge bg-info">
                                        {{ $report->activities_count }}
                                    </span>
                                </td>

                                <td>
                                    <span class="status-badge status-{{ $report->status }}">
                                        {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                    </span>
                                </td>

                                <td>
                                    {{ $report->submitted_at?->format('d M Y h:i A') ?? '--' }}
                                </td>

                                <td>
                                    <a href="{{ route('hospital.staff-daily-reports.show', $report->id) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="ti ti-eye"></i> View
                                    </a>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    No daily reports found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $reports->links() }}
            </div>

        </div>

    </div>
</div>

@endsection
