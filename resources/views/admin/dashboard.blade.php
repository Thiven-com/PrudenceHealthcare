<?php $page = 'dashboard'; ?>

@extends('admin.layout.mainlayout')

@section('content')

    <div class="page-wrapper">
        <div class="content">

            {{-- Page Heading --}}
            <div class="d-lg-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="mb-1">
                        Welcome, {{ Auth::guard('admin')->user()->name }}
                    </h2>
                    <p class="text-muted mb-0">
                        Prudence | Healthcare Growth Consultancy Administration Dashboard
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
                            Welcome Back, {{ Auth::guard('admin')->user()->name }}
                        </h2>
                        <p class="text-light mb-0">
                            {{ $pendingHospitals }} hospitals are waiting for approval.
                        </p>
                    </div>

                    <div class="d-flex align-items-center flex-wrap mb-1">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-light btn-md mb-2">
                            Dashboard Overview
                        </a>
                    </div>
                </div>

                <div class="welcome-bg">
                    <img src="{{ URL::asset('build/img/bg/welcome-bg-02.svg') }}" alt="" class="welcome-bg-01">

                    <img src="{{ URL::asset('build/img/bg/welcome-bg-01.svg') }}" alt="" class="welcome-bg-03">
                </div>
            </div>

            {{-- Statistics --}}
            <div class="row">

                <div class="col-xl-3 col-sm-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="avatar avatar-md bg-dark mb-3">
                                    <i class="ti ti-building-hospital fs-16"></i>
                                </span>
                                <span class="badge bg-light text-dark mb-3">
                                    Hospitals
                                </span>
                            </div>

                            <h2 class="mb-1">
                                {{ number_format($totalHospitals) }}
                            </h2>
                            <p class="fs-13 mb-0">Total Hospitals</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="avatar avatar-md bg-success mb-3">
                                    <i class="ti ti-circle-check fs-16"></i>
                                </span>
                                <span class="badge bg-success mb-3">
                                    Approved
                                </span>
                            </div>

                            <h2 class="mb-1">
                                {{ number_format($approvedHospitals) }}
                            </h2>
                            <p class="fs-13 mb-0">Approved Hospitals</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="avatar avatar-md bg-info mb-3">
                                    <i class="ti ti-users fs-16"></i>
                                </span>
                                <span class="badge bg-light text-dark mb-3">
                                    Staff
                                </span>
                            </div>

                            <h2 class="mb-1">
                                {{ number_format($totalStaff) }}
                            </h2>
                            <p class="fs-13 mb-0">Total Staff</p>
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
                                <span class="badge bg-light text-dark mb-3">
                                    Leads
                                </span>
                            </div>

                            <h2 class="mb-1">
                                {{ number_format($totalLeads) }}
                            </h2>
                            <p class="fs-13 mb-0">Total Leads</p>
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
                            <h2 class="mb-1">{{ $pendingHospitals }}</h2>
                            <p class="fs-13 mb-0">Pending Approvals</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <span class="avatar avatar-md bg-danger mb-3">
                                <i class="ti ti-circle-x fs-16"></i>
                            </span>
                            <h2 class="mb-1">{{ $rejectedHospitals }}</h2>
                            <p class="fs-13 mb-0">Rejected Hospitals</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Charts --}}
            <div class="row">

                {{-- Hospital Registrations --}}
                <div class="col-lg-8 d-flex">
                    <div class="card flex-fill">
                        <div class="card-header">
                            <h5 class="mb-0">Hospital Registrations</h5>
                            <p class="text-muted fs-13 mb-0">
                                Monthly registrations - {{ now()->year }}
                            </p>
                        </div>

                        <div class="card-body">
                            <div id="hospital-registration-chart"></div>
                        </div>
                    </div>
                </div>

                {{-- Lead Module Distribution --}}
                <div class="col-lg-4 d-flex">
                    <div class="card flex-fill">
                        <div class="card-header">
                            <h5 class="mb-0">Lead Module Distribution</h5>
                        </div>

                        <div class="card-body">
                            <div id="lead-module-chart"></div>

                            @forelse($leadModuleDistribution as $module)
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <p class="fs-13 mb-0">
                                        {{ $module->name }}
                                    </p>

                                    <p class="fs-13 fw-medium mb-0">
                                        {{ number_format($module->leads_count) }}
                                    </p>
                                </div>
                            @empty
                                <p class="text-muted text-center">
                                    No lead data available.
                                </p>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

            {{-- Recent Hospitals and Pending Approvals --}}
            <div class="row">

                {{-- Recently Registered Hospitals --}}
                <div class="col-xl-6 d-flex">
                    <div class="card flex-fill">

                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Recently Registered Hospitals</h5>
                        </div>

                        <div class="card-body">
                            @forelse($recentHospitals as $hospital)

                                <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">

                                    <div class="d-flex align-items-center mb-2">
                                        <span class="avatar bg-light rounded-circle">
                                            <i class="ti ti-building-hospital fs-18"></i>
                                        </span>

                                        <div class="ms-2">
                                            <h6 class="mb-1">
                                                {{ $hospital->hospital_name }}
                                            </h6>

                                            <p class="fs-13 text-muted mb-0">
                                                {{ $hospital->mobile }}
                                                @if($hospital->city)
                                                    · {{ $hospital->city }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <div class="text-sm-end mb-2">
                                        @if($hospital->approval_status === 'approved')
                                            <span class="badge bg-success">
                                                Approved
                                            </span>
                                        @elseif($hospital->approval_status === 'pending')
                                            <span class="badge bg-warning text-dark">
                                                Pending
                                            </span>
                                        @elseif($hospital->approval_status === 'rejected')
                                            <span class="badge bg-danger">
                                                Rejected
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                {{ ucfirst($hospital->approval_status) }}
                                            </span>
                                        @endif

                                        <p class="fs-12 text-muted mb-0 mt-1">
                                            {{ $hospital->created_at->format('d M Y') }}
                                        </p>
                                    </div>

                                </div>

                            @empty
                                <div class="text-center py-4">
                                    <i class="ti ti-building-hospital fs-1 text-muted"></i>
                                    <p class="text-muted mt-2 mb-0">
                                        No hospitals registered yet.
                                    </p>
                                </div>
                            @endforelse
                        </div>

                    </div>
                </div>

                {{-- Pending Hospital Approvals --}}
                <div class="col-xl-6 d-flex">
                    <div class="card flex-fill">

                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Pending Hospital Approvals</h5>
                            <span class="badge bg-warning text-dark">
                                {{ $pendingHospitals }}
                            </span>
                        </div>

                        <div class="card-body">

                            @forelse($pendingHospitalList as $hospital)

                                <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">

                                    <div class="d-flex align-items-center mb-2">
                                        <span class="avatar bg-light rounded-circle">
                                            <i class="ti ti-hospital fs-18"></i>
                                        </span>

                                        <div class="ms-2">
                                            <h6 class="mb-1">
                                                {{ $hospital->hospital_name }}
                                            </h6>

                                            <p class="fs-13 text-muted mb-0">
                                                {{ $hospital->mobile }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="text-sm-end mb-2">
                                        <span class="badge bg-warning text-dark">
                                            Pending
                                        </span>

                                        <p class="fs-12 text-muted mb-0 mt-1">
                                            {{ $hospital->created_at->format('d M Y') }}
                                        </p>
                                    </div>

                                </div>

                            @empty
                                <div class="text-center py-4">
                                    <i class="ti ti-circle-check fs-1 text-success"></i>
                                    <p class="text-muted mt-2 mb-0">
                                        No pending hospital approvals.
                                    </p>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>

            </div>

            {{-- Recent Leads --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">

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
                                            <th>Created Date</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($recentLeads as $lead)
                                            <tr>
                                                <td>{{ $lead->name }}</td>
                                                <td>{{ $lead->mobile }}</td>
                                                <td>
                                                    {{ $lead->leadModule?->name ?? '-' }}
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark">
                                                        {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ $lead->created_at->format('d M Y') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">
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
            </div>

        </div>

        @include('admin.layout.partials.footer')
    </div>

    {{-- Dashboard Charts --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            if (typeof ApexCharts === 'undefined') {
                console.error('ApexCharts library is not loaded.');
                return;
            }

            // Monthly Hospital Registrations
            const hospitalOptions = {
                series: [{
                    name: 'Hospitals',
                    data: @json($hospitalChart)
                }],
                chart: {
                    type: 'bar',
                    height: 300,
                    toolbar: {
                        show: false
                    }
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
                    categories: [
                        'Jan', 'Feb', 'Mar', 'Apr',
                        'May', 'Jun', 'Jul', 'Aug',
                        'Sep', 'Oct', 'Nov', 'Dec'
                    ]
                },
                yaxis: {
                    min: 0,
                    forceNiceScale: true
                },
                noData: {
                    text: 'No registration data available'
                }
            };

            new ApexCharts(
                document.querySelector('#hospital-registration-chart'),
                hospitalOptions
            ).render();


            // Lead Module Distribution
            const moduleNames = @json($leadModuleDistribution->pluck('name')->values());
            const moduleCounts = @json($leadModuleDistribution->pluck('leads_count')->values());

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
                    document.querySelector('#lead-module-chart'),
                    moduleOptions
                ).render();

            } else {
                document.querySelector('#lead-module-chart').innerHTML =
                    '<p class="text-muted text-center py-5">No lead data available.</p>';
            }

        });
    </script>

@endsection