<?php $page = 'lead-overview'; ?>

@extends('admin.layout.mainlayout')

@section('content')
    <div class="page-wrapper">
        <div class="content">

            <div class="mb-4">
                <h2 class="mb-1">Lead Overview</h2>
                <p class="text-muted mb-0">
                    Monitor leads across all registered hospitals
                </p>
            </div>

            {{-- Statistics --}}
            <div class="row">

                @php
                    $cards = [
                        ['Total Leads', $totalLeads, 'dark', 'ti-clipboard-list'],
                        ['New', $newLeads, 'info', 'ti-sparkles'],
                        ['Contacted', $contactedLeads, 'primary', 'ti-phone'],
                        ['Interested', $interestedLeads, 'success', 'ti-thumb-up'],
                        ['Follow Up', $followUpLeads, 'warning', 'ti-clock'],
                        ['Converted', $convertedLeads, 'success', 'ti-circle-check'],
                        ['Closed', $closedLeads, 'secondary', 'ti-lock'],
                        ['Not Interested', $notInterestedLeads, 'danger', 'ti-circle-x'],
                    ];
                @endphp

                @foreach($cards as $card)
                    <div class="col-xl-3 col-sm-6 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body">
                                <span class="avatar avatar-md bg-{{ $card[2] }} mb-3">
                                    <i class="ti {{ $card[3] }} fs-18"></i>
                                </span>
                                <h2>{{ number_format($card[1]) }}</h2>
                                <p class="mb-0">{{ $card[0] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            {{-- Filters --}}
            <div class="card">
                <div class="card-body">

                    <form method="GET" action="{{ route('admin.lead-overview.index') }}">
                        <div class="row align-items-end">

                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="form-label">Search</label>
                                <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                                    placeholder="Name, mobile, lead code">
                            </div>

                            <div class="col-lg-2 col-md-6 mb-3">
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

                            <div class="col-lg-2 col-md-6 mb-3">
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

                            <div class="col-lg-2 col-md-6 mb-3">
                                <label class="form-label">Status</label>
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

                            <div class="col-lg-3 col-md-6 mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-search me-1"></i> Filter
                                </button>

                                <a href="{{ route('admin.lead-overview.index') }}" class="btn btn-light">
                                    Reset
                                </a>
                            </div>

                        </div>
                    </form>

                </div>
            </div>

            {{-- Lead Table --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">All Hospital Leads</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Lead Code</th>
                                    <th>Lead Name</th>
                                    <th>Mobile</th>
                                    <th>Hospital</th>
                                    <th>Module</th>
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
                                        <td>{{ $lead->leadModule?->name ?? '-' }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                                            </span>
                                        </td>
                                        <td>{{ $lead->created_at?->format('d M Y') ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('admin.lead-overview.show', $lead->id) }}"
                                                class="btn btn-sm btn-light">
                                                <i class="ti ti-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">
                                            No leads found.
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