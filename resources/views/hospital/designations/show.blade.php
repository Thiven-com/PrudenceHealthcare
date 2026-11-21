
@extends('hospital.layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Designation Details</h4>
                <h6>View designation information</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('hospital.designations.edit', $designation->id) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i> Edit Designation
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Designation Name</label>
                        <h6>{{ $designation->name }}</h6>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Designation Code</label>
                        <h6>{{ $designation->code ?? '-' }}</h6>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Department</label>
                        <h6>{{ $designation->department->name ?? '-' }}</h6>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Status</label>
                        @if($designation->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="text-muted">Description</label>
                        <p>{{ $designation->description ?? '-' }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Created At</label>
                        <h6>{{ $designation->created_at?->format('d M Y, h:i A') ?? '-' }}</h6>
                    </div>
                </div>

                <a href="{{ route('hospital.designations.index') }}" class="btn btn-secondary">
                    Back to Designations
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
