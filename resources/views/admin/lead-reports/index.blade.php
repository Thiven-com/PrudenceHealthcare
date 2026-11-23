<?php $page = 'lead-reports'; ?>

@extends('admin.layout.mainlayout')

@section('content')

    <div class="page-wrapper">
        <div class="content">

            <div class="mb-4">
                <h2 class="mb-1">Lead Reports</h2>
                <p class="text-muted mb-0">
                    Lead performance across staff, departments, designations and hospitals
                </p>
            </div>

            {{-- Filters --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Report Filters</h5>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('admin.lead-reports.index') }}">

                        <div class="row align-items-end">

                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="form-label">Hospital</label>
                                <select name="hospital_id" class="form-select">
                                    <option value="">All Hospitals</option>
                                    @foreach($hospitals as $hospital)
                                        <option value="{{ $hospital->id }}" {{ request('hospital_id') == $hospital->id ? 'selected' : '' }}>
                                            {{ $hospital->hospital_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="form-label">Department</label>
                                <select name="department_id" class="form-select">
                                    <option value="">All Departments</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="form-label">Designation</label>
                                <select name="designation_id" class="form-select">
                                    <option value="">All Designations</option>
                                    @foreach($designations as $designation)
                                        <option value="{{ $designation->id }}" {{ request('designation_id') == $designation->id ? 'selected' : '' }}>
                                            {{ $designation->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="form-label">Staff</label>
                                <select name="staff_id" class="form-select">
                                    <option value="">All Staff</option>
                                    @foreach($staffMembers as $staff)
                                        <option value="{{ $staff->id }}" {{ request('staff_id') == $staff->id ? 'selected' : '' }}>
                                            {{ $staff->name }} ({{ $staff->employee_code ?? $staff->id }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="form-label">Lead Module</label>
                                <select name="lead_module_id" class="form-select">
                                    <option value="">All Modules</option>
                                    @foreach($leadModules as $module)
                                        <option value="{{ $module->id }}" {{ request('lead_module_id') == $module->id ? 'selected' : '' }}>
                                            {{ $module->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="form-label">Lead Status</label>
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    @foreach([
                                            'new',
                                            'contacted',
                                            'interested',
                                            'follow_up',
                                            'converted',
                                            'not_interested',
                                            'closed'
                                        ] as $status)
                                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="form-label">From Date</label>
                                <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="form-label">To Date</label>
                                <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-search me-1"></i> Apply Filters
                                </button>

                                <a href="{{ route('admin.lead-reports.index') }}" class="btn btn-light">
                                    <i class="ti ti-refresh me-1"></i> Reset
                                </a>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

            {{-- Reusable report table --}}
            @php
                $reportSections = [
                    [
                        'title' => 'Staff-wise Lead Report',
                        'data' => $staffReport,
                        'columns' => [
                            'Staff' => 'staff_name',
                            'Employee Code' => 'employee_code',
                            'Hospital' => 'hospital_name',
                            'Department' => 'department_name',
                            'Designation' => 'designation_name',
                        ],
                    ],
                    [
                        'title' => 'Department-wise Lead Report',
                        'data' => $departmentReport,
                        'columns' => [
                            'Hospital' => 'hospital_name',
                            'Department' => 'department_name',
                        ],
                    ],
                    [
                        'title' => 'Designation-wise Lead Report',
                        'data' => $designationReport,
                        'columns' => [
                            'Hospital' => 'hospital_name',
                            'Designation' => 'designation_name',
                        ],
                    ],
                    [
                        'title' => 'Hospital-wise Lead Report',
                        'data' => $hospitalReport,
                        'columns' => [
                            'Hospital' => 'hospital_name',
                        ],
                    ],
                ];

                $totalColumns = [
                    'Total Leads' => 'total_leads',
                    'New' => 'new_leads',
                    'Contacted' => 'contacted_leads',
                    'Interested' => 'interested_leads',
                    'Follow-ups' => 'follow_up_leads',
                    'Converted' => 'converted_leads',
                    'Not Interested' => 'not_interested_leads',
                    'Closed' => 'closed_leads',
                ];
            @endphp

            @foreach($reportSections as $section)

                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">{{ $section['title'] }}</h5>
                        <span class="badge bg-primary">
                            {{ $section['data']->total() }} Records
                        </span>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>

                                        @foreach($section['columns'] as $label => $field)
                                            <th>{{ $label }}</th>
                                        @endforeach

                                        @foreach($totalColumns as $label => $field)
                                            <th>{{ $label }}</th>
                                        @endforeach
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($section['data'] as $report)
                                        <tr>
                                            <td>{{ $section['data']->firstItem() + $loop->index }}</td>

                                            @foreach($section['columns'] as $field)
                                                <td>{{ $report->{$field} ?? 'Unassigned' }}</td>
                                            @endforeach

                                            @foreach($totalColumns as $field)
                                                <td class="{{ $field === 'total_leads' ? 'fw-bold' : '' }}">
                                                    {{ number_format($report->{$field} ?? 0) }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ 1 + count($section['columns']) + count($totalColumns) }}"
                                                class="text-center text-muted py-4">
                                                No report data available.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
{{ $section['data']->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>
                    </div>
                </div>

            @endforeach

        </div>

        @include('admin.layout.partials.footer')
    </div>

@endsection