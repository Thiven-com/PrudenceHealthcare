
@extends('hospital.layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Department Details</h4>
                <h6>View department information</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('hospital.departments.edit', $department->id) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i> Edit Department
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Department Name</label>
                        <h6>{{ $department->name }}</h6>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Department Code</label>
                        <h6>{{ $department->code ?? '-' }}</h6>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Status</label>
                        <h6>
                            @if($department->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </h6>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="text-muted">Description</label>
                        <p>{{ $department->description ?? '-' }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="text-muted">Created At</label>
                        <h6>{{ $department->created_at?->format('d M Y, h:i A') ?? '-' }}</h6>
                    </div>
                </div>

                <a href="{{ route('hospital.departments.index') }}" class="btn btn-secondary">
                    Back to Departments
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
