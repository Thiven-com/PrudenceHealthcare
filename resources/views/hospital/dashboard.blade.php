
<?php $page = 'dashboard'; ?>

@extends('hospital.layout.mainlayout')

@section('content')

<div class="page-wrapper">
    <div class="content">

        {{-- Page Heading --}}
        <div class="d-lg-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="mb-1">
                    Welcome, {{ $hospital->hospital_name }}
                </h2>
                <p class="text-muted mb-0">
                    Prudence | Healthcare Growth Consultancy Hospital Dashboard
                </p>
            </div>

            <div class="mt-3 mt-lg-0">
                <span class="badge bg-light text-dark p-2">
                    <i class="ti ti-calendar me-1"></i>
                    {{ now()->format('d M Y') }}
                </span>
            </div>
        </div>

        {{-- Welcome Banner --}}
        <div class="welcome-wrap mb-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap">
                <div class="mb-3">
                    <h2 class="mb-1 text-white">
                        Welcome Back, {{ $hospital->hospital_name }}
                    </h2>
                    <p class="text-light mb-0">
                        Manage your hospital staff, leads and follow-ups from one place.
                    </p>
                </div>

                <div class="d-flex align-items-center flex-wrap mb-1">
                    <a href="{{ route('hospital.dashboard') }}"
                       class="btn btn-light btn-md mb-2">
                        Dashboard Overview
                    </a>
                </div>
            </div>

            <div class="welcome-bg">
                <img src="{{ URL::asset('build/img/bg/welcome-bg-02.svg') }}"
                     alt="" class="welcome-bg-01">

                <img src="{{ URL::asset('build/img/bg/welcome-bg-01.svg') }}"
                     alt="" class="welcome-bg-03">
            </div>
        </div>

        {{-- Primary Statistics --}}
        <div class="row">

            <div class="col-xl-3 col-sm-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="avatar avatar-md bg-dark mb-3">
                                <i class="ti ti-users fs-16"></i>
                            </span>
                            <span class="badge bg-light text-dark mb-3">Staff</span>
                        </div>

                        <h2 class="mb-1">{{ number_format($totalStaff) }}</h2>
                        <p class="fs-13 mb-0">Total Staff</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="avatar avatar-md bg-success mb-3">
                                <i class="ti ti-user-check fs-16"></i>
                            </span>
                            <span class="badge bg-success mb-3">Active</span>
                        </div>

                        <h2 class="mb-1">{{ number_format($activeStaff) }}</h2>
                        <p class="fs-13 mb-0">Active Staff</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="avatar avatar-md bg-warning mb-3">
                                <i class="ti ti-clipboard-list fs-16"></i>
                            </span>
                            <span class="badge bg-light text-dark mb-3">Leads</span>
                        </div>

                        <h2 class="mb-1">{{ number_format($totalLeads) }}</h2>
                        <p class="fs-13 mb-0">Total Leads</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="avatar avatar-md bg-info mb-3">
                                <i class="ti ti-calendar-event fs-16"></i>
                            </span>
                            <span class="badge bg-light text-dark mb-3">Follow-ups</span>
                        </div>

                        <h2 class="mb-1">{{ number_format($todayFollowUps) }}</h2>
                        <p class="fs-13 mb-0">Today's Follow-ups</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Secondary Statistics --}}
        <div class="row">

            <div class="col-xl-3 col-sm-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <span class="avatar avatar-md bg-warning mb-3">
                            <i class="ti ti-clock fs-16"></i>
                        </span>
                        <h2 class="mb-1">{{ $newLeads }}</h2>
                        <p class="fs-13 mb-0">New Leads</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <span class="avatar avatar-md bg-info mb-3">
                            <i class="ti ti-phone-call fs-16"></i>
                        </span>
                        <h2 class="mb-1">{{ $followUpLeads }}</h2>
                        <p class="fs-13 mb-0">Follow-up Leads</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <span class="avatar avatar-md bg-success mb-3">
                            <i class="ti ti-circle-check fs-16"></i>
                        </span>
                        <h2 class="mb-1">{{ $convertedLeads }}</h2>
                        <p class="fs-13 mb-0">Converted Leads</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <span class="avatar avatar-md bg-danger mb-3">
                            <i class="ti ti-alert-circle fs-16"></i>
                        </span>
                        <h2 class="mb-1">{{ $dueFollowUps }}</h2>
                        <p class="fs-13 mb-0">Due / Overdue Follow-ups</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Charts --}}
        <div class="row">

            <div class="col-lg-8 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h5 class="mb-0">Monthly Lead Registrations</h5>
                        <p class="text-muted fs-13 mb-0">
                            Monthly leads - {{ now()->year }}
                        </p>
                    </div>

                    <div class="card-body">
                        <div id="hospital-monthly-leads-chart"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h5 class="mb-0">Lead Module Distribution</h5>
                    </div>

                    <div class="card-body">
                        <div id="hospital-lead-module-chart"></div>

                        @forelse($leadModules as $module)
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <p class="fs-13 mb-0">{{ $module->name }}</p>
                                <p class="fs-13 fw-medium mb-0">
                                    {{ number_format($module->total_leads) }}
                                </p>
                            </div>
                        @empty
                            <p class="text-muted text-center">No modules available.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

        {{-- Recent Leads and Follow-ups --}}
        <div class="row">

            <div class="col-xl-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h5 class="mb-0">Recently Added Leads</h5>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Lead Name</th>
                                        <th>Mobile</th>
                                        <th>Module</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($recentLeads as $lead)
                                        <tr>
                                            <td>{{ $lead->name }}</td>
                                            <td>{{ $lead->mobile }}</td>
                                            <td>{{ $lead->leadModule?->name ?? '-' }}</td>
                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">
                                                No leads available.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h5 class="mb-0">Upcoming Follow-ups</h5>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Lead Name</th>
                                        <th>Follow-up Date</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($recentFollowUps as $followUp)
                                        <tr>
                                            <td>{{ $followUp->lead?->name ?? '-' }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($followUp->follow_up_date)->format('d M Y') }}
                                            </td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $followUp->follow_up_type ?? '-')) }}</td>
                                            <td>
                                                <span class="badge bg-warning text-dark">
                                                    Scheduled
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">
                                                No scheduled follow-ups.
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

        {{-- Module-wise Lead Summary --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Lead Module Summary</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @forelse($leadModules as $module)
                                <div class="col-xl-3 col-md-4 col-sm-6 mb-3">
                                    <div class="border rounded p-3 h-100">
                                        <h6>{{ $module->name }}</h6>
                                        <h3 class="mb-0">
                                            {{ number_format($module->total_leads) }}
                                        </h3>
                                        <small class="text-muted">Total Leads</small>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted">
                                    No lead modules available.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('hospital.layout.partials.footer')
</div>

{{-- Dashboard Charts --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    if (typeof ApexCharts === 'undefined') {
        console.error('ApexCharts library is not loaded.');
        return;
    }

    // Monthly Lead Registrations
    const monthlyOptions = {
        series: [{
            name: 'Leads',
            data: @json($monthlyLeadChart)
        }],
        chart: {
            type: 'bar',
            height: 300,
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                borderRadius: 5,
                columnWidth: '45%'
            }
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: @json($monthlyLeadLabels)
        },
        yaxis: {
            min: 0,
            forceNiceScale: true
        },
        noData: {
            text: 'No lead data available'
        }
    };

    new ApexCharts(
        document.querySelector('#hospital-monthly-leads-chart'),
        monthlyOptions
    ).render();

    // Lead Module Distribution
    const moduleNames = @json($leadModules->pluck('name')->values());
    const moduleCounts = @json($leadModules->pluck('total_leads')->values());

    if (moduleNames.length > 0) {
        const moduleOptions = {
            series: moduleCounts,
            labels: moduleNames,
            chart: {
                type: 'donut',
                height: 280
            },
            legend: {
                show: false
            },
            dataLabels: {
                enabled: true
            },
            noData: {
                text: 'No lead data available'
            }
        };

        new ApexCharts(
            document.querySelector('#hospital-lead-module-chart'),
            moduleOptions
        ).render();
    } else {
        document.querySelector('#hospital-lead-module-chart').innerHTML =
            '<p class="text-muted text-center py-5">No lead data available.</p>';
    }
});
</script>

@endsection
