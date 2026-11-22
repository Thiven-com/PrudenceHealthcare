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
                                    <td>{{  $lead->assignedStaff->name ?? 'Unassigned' }}</td>
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
                {{-- Module Additional Information --}}
                @if($moduleDetails)

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>
                                    {{ $lead->leadModule?->name ?? 'Additional Information' }}
                                </h5>
                            </div>

                            <div class="card-body">

                                @php
                                    $excludeFields = [
                                        'id',
                                        'hospital_id',
                                        'lead_id',
                                        'created_at',
                                        'updated_at',
                                        'deleted_at'
                                    ];

                                    $details = $moduleDetails->getAttributes();
                                @endphp

                                <div class="row">

                                    @foreach($details as $key => $value)

                                        @if(!in_array($key, $excludeFields) && !is_null($value) && $value !== '')

                                            <div class="col-md-6 col-lg-4 mb-3">

                                                <label class="text-muted mb-1">
                                                    {{ ucwords(str_replace('_', ' ', $key)) }}
                                                </label>

                                                <h6 class="mb-0">
                                                    @if(
                                                            is_numeric($value) && in_array($key, [
                                                                'sum_insured',
                                                                'premium',
                                                                'existing_premium',
                                                                'budget',
                                                                'estimated_amount',
                                                                'final_amount',
                                                                'advance_amount',
                                                                'balance_amount',
                                                                'credit_amount_required'
                                                            ])
                                                        )
                                                        ₹{{ number_format((float) $value, 2) }}
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                </h6>

                                            </div>

                                        @endif

                                    @endforeach

                                </div>

                                {{-- Community Members --}}
                                @if($lead->leadModule?->slug === 'community' && $moduleDetails->relationLoaded('members'))

                                    <hr>

                                    <h5 class="mb-3">Community Members</h5>

                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Mobile</th>
                                                    <th>Email</th>
                                                    <th>Designation</th>
                                                    <th>Notes</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @forelse($moduleDetails->members as $index => $member)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $member->member_name }}</td>
                                                        <td>{{ $member->mobile ?? '-' }}</td>
                                                        <td>{{ $member->email ?? '-' }}</td>
                                                        <td>{{ $member->designation ?? '-' }}</td>
                                                        <td>{{ $member->notes ?? '-' }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center">
                                                            No community members found.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                @endif

                                {{-- Company Employees --}}
                                @if($lead->leadModule?->slug === 'company-health-insurance' && $moduleDetails->relationLoaded('employees'))

                                    <hr>

                                    <h5 class="mb-3">Company Employees</h5>

                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Employee ID</th>
                                                    <th>Name</th>
                                                    <th>Mobile</th>
                                                    <th>Email</th>
                                                    <th>DOB</th>
                                                    <th>Gender</th>
                                                    <th>Designation</th>
                                                    <th>Dependents</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @forelse($moduleDetails->employees as $index => $employee)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $employee->employee_id ?? '-' }}</td>
                                                        <td>{{ $employee->employee_name }}</td>
                                                        <td>{{ $employee->mobile ?? '-' }}</td>
                                                        <td>{{ $employee->email ?? '-' }}</td>
                                                        <td>
                                                            {{ $employee->date_of_birth ? \Carbon\Carbon::parse($employee->date_of_birth)->format('d M Y') : '-' }}
                                                        </td>
                                                        <td>{{ $employee->gender ?? '-' }}</td>
                                                        <td>{{ $employee->designation ?? '-' }}</td>
                                                        <td>{{ $employee->dependent_count ?? 0 }}</td>
                                                    </tr>

                                                    @if(!empty($employee->dependent_details))
                                                        <tr>
                                                            <td colspan="9">
                                                                <strong>Dependent Details:</strong>

                                                                @foreach($employee->dependent_details as $dependent)
                                                                    <span class="badge bg-light text-dark me-2">
                                                                        {{ $dependent['name'] ?? '-' }}
                                                                        ({{ $dependent['relationship'] ?? '-' }})
                                                                    </span>
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                    @endif

                                                @empty
                                                    <tr>
                                                        <td colspan="9" class="text-center">
                                                            No employees found.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                @endif

                            </div>
                        </div>
                    </div>

                @else

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <p class="text-muted mb-0">
                                    No additional module information available.
                                </p>
                            </div>
                        </div>
                    </div>

                @endif

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