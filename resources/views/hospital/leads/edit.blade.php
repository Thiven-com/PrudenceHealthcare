
<?php $page = 'leads-edit'; ?>
@extends('hospital.layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Edit Lead</h4>
                <h6>Update lead information - {{ $lead->leadcode }}</h6>
            </div>

            <div class="page-btn">
                <a href="{{ route('hospital.leads.index') }}" class="btn btn-light">
                    <i class="ti ti-arrow-left me-1"></i> Back to Leads
                </a>
            </div>
        </div>

        <form action="{{ route('hospital.leads.update', $lead->id) }}" method="POST">
            @csrf
            @method('PUT')

            @include('hospital.leads._form', [
                'lead' => $lead,
                'detail' => $detail
            ])

            <div class="card mt-3">
                <div class="card-body d-flex justify-content-end gap-2">
                    <a href="{{ route('hospital.leads.index') }}" class="btn btn-light">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy me-1"></i> Update Lead
                    </button>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection
