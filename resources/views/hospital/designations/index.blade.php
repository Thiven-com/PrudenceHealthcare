
@extends('hospital.layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Designations</h4>
                <h6>Manage hospital staff designations</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('hospital.designations.create') }}" class="btn btn-primary">
                    <i class="ti ti-circle-plus me-1"></i> Add Designation
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Designation List</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Designation</th>
                                <th>Code</th>
                                <th>Department</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($designations as $designation)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ $designation->name }}</strong></td>
                                    <td>{{ $designation->code ?? '-' }}</td>
                                    <td>{{ $designation->department->name ?? '-' }}</td>
                                    <td>{{ $designation->description ?? '-' }}</td>
                                    <td>
                                        @if($designation->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('hospital.designations.show', $designation->id) }}"
                                               class="btn btn-sm btn-outline-info">
                                                <i class="ti ti-eye"></i>
                                            </a>

                                            <a href="{{ route('hospital.designations.edit', $designation->id) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="ti ti-edit"></i>
                                            </a>

                                            <form action="{{ route('hospital.designations.destroy', $designation->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this designation?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        No designations found.
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
@endsection
