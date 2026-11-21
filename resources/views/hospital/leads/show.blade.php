
<?php $page = 'leads-view'; ?>
@extends('hospital.layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Lead Details</h4>
                <h6>{{ $lead->leadcode }} - {{ $lead->name }}</h6>
            </div>

            <div class="page-btn d-flex gap-2">
                <a href="{{ route('hospital.leads.edit', $lead->id) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i> Edit Lead
                </a>

                <a href="{{ route('hospital.leads.index') }}" class="btn btn-light">
                    Back
                </a>
            </div>
        </div>

        <div class="row">

            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach([
                                'Name' => $lead->name,
                                'Lead Code' => $lead->leadcode,
                                'Mobile' => $lead->mobile,
                                'Alternate Mobile' => $lead->alternate_mobile,
                                'Email' => $lead->email,
                                'Module' => $lead->leadModule->name ?? '-',
                                'City' => $lead->city,
                                'State' => $lead->state,
                                'Pincode' => $lead->pincode,
                                'Source' => $lead->source,
                                'Assigned Staff' => $lead->assignedStaff->name ?? 'Unassigned',
                                'Status' => ucfirst(str_replace('_', ' ', $lead->status)),
                            ] as $label => $value)
                                <div class="col-md-6 mb-3">
                                    <small class="text-muted">{{ $label }}</small>
                                    <h6 class="mb-0">{{ $value ?: '-' }}</h6>
                                </div>
                            @endforeach

                            <div class="col-md-12 mb-3">
                                <small class="text-muted">Address</small>
                                <p class="mb-0">{{ $lead->address ?: '-' }}</p>
                            </div>

                            <div class="col-md-12">
                                <small class="text-muted">Remarks</small>
                                <p class="mb-0">{{ $lead->remarks ?: '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($detail)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                {{ $lead->leadModule->name ?? 'Module' }} Details
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($detail->getAttributes() as $key => $value)
                                    @if(!in_array($key, [
                                        'id', 'hospital_id', 'lead_id',
                                        'created_at', 'updated_at', 'deleted_at'
                                    ]) && !is_null($value) && $value !== '')
                                        <div class="col-md-6 mb-3">
                                            <small class="text-muted">
                                                {{ ucwords(str_replace('_', ' ', $key)) }}
                                            </small>
                                            <h6 class="mb-0">
                                                @if(is_array($value))
                                                    {{ implode(', ', $value) }}
                                                @else
                                                    {{ $value }}
                                                @endif
                                            </h6>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-xl-4">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Lead Status</h5>
                    </div>
                    <div class="card-body">
                        <h4>{{ ucfirst(str_replace('_', ' ', $lead->status)) }}</h4>
                        <p class="text-muted mb-0">
                            Created {{ $lead->created_at?->format('d M Y') }}
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Follow-ups</h5>
                    </div>
                    <div class="card-body">
                        @forelse($lead->followUps as $followUp)
                            <div class="border-bottom pb-3 mb-3">
                                <h6>{{ ucfirst(str_replace('_', ' ', $followUp->follow_up_type ?? 'Follow-up')) }}</h6>
                                <small class="text-muted">
                                    {{ $followUp->follow_up_date ?? '-' }}
                                </small>
                                <p class="mb-0 mt-2">
                                    {{ $followUp->discussion ?? $followUp->remarks ?? '-' }}
                                </p>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No follow-ups found.</p>
                        @endforelse
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Activity History</h5>
                    </div>
                    <div class="card-body">
                        @forelse($lead->activities as $activity)
                            <div class="border-bottom pb-3 mb-3">
                                <h6>{{ $activity->title ?? ucfirst($activity->activity_type) }}</h6>
                                <p class="mb-1">{{ $activity->description }}</p>
                                <small class="text-muted">
                                    {{ $activity->performed_at ?? $activity->created_at }}
                                </small>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No activities found.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
