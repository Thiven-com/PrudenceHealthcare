@extends('admin.layout.mainlayout')

@section('content')

<div class="page-wrapper">
    <div class="content">

        <div class="page-header d-flex justify-content-between align-items-center">
            <div>
                <h4>Hospital Documents</h4>
                <h6>{{ $hospital->hospital_name }}</h6>
            </div>

            <a href="{{ route('admin.hospitals.show', $hospital->id) }}"
               class="btn btn-secondary">
                Back to Hospital
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Upload document --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Upload Hospital Document</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.hospitals.documents.store', $hospital->id) }}"
                      method="POST"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Document Name *</label>
                            <input type="text"
                                   name="document_name"
                                   class="form-control"
                                   value="{{ old('document_name') }}"
                                   required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Document Type</label>
                            <input type="text"
                                   name="document_type"
                                   class="form-control"
                                   value="{{ old('document_type') }}"
                                   placeholder="Registration, License, etc.">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Document Number</label>
                            <input type="text"
                                   name="document_number"
                                   class="form-control"
                                   value="{{ old('document_number') }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Document File *</label>
                            <input type="file"
                                   name="document"
                                   class="form-control"
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   required>
                            <small class="text-muted">PDF, JPG or PNG. Maximum 5 MB.</small>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Issued Date</label>
                            <input type="date"
                                   name="issued_date"
                                   class="form-control"
                                   value="{{ old('issued_date') }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Expiry Date</label>
                            <input type="date"
                                   name="expiry_date"
                                   class="form-control"
                                   value="{{ old('expiry_date') }}">
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">
                        Upload Document
                    </button>
                </form>
            </div>
        </div>

        {{-- Document list --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Uploaded Documents</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Document</th>
                                <th>Type</th>
                                <th>Number</th>
                                <th>Expiry Date</th>
                                <th>Status</th>
                                <th>File</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($documents as $document)
                                <tr>
                                    <td>{{ $documents->firstItem() + $loop->index }}</td>

                                    <td>{{ $document->document_name }}</td>

                                    <td>{{ $document->document_type ?? '-' }}</td>

                                    <td>{{ $document->document_number ?? '-' }}</td>

                                    <td>
                                        {{ $document->expiry_date
                                            ? \Carbon\Carbon::parse($document->expiry_date)->format('d M Y')
                                            : '-' }}
                                    </td>

                                    <td>
                                        @if($document->verification_status === 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($document->verification_status === 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif

                                        @if($document->rejection_reason)
                                            <div class="small text-danger mt-1">
                                                {{ $document->rejection_reason }}
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ asset($document->file_path) }}"
                                           target="_blank"
                                           class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>
                                    </td>

                                    <td>
                                        @if($document->verification_status !== 'approved')
                                            <form action="{{ route('admin.hospitals.documents.verify', [$hospital->id, $document->id]) }}"
                                                  method="POST"
                                                  class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-success"
                                                        onclick="return confirm('Approve this document?')">
                                                    Approve
                                                </button>
                                            </form>
                                        @endif

                                        @if($document->verification_status !== 'rejected')
                                            <button type="button"
                                                    class="btn btn-sm btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#rejectModal{{ $document->id }}">
                                                Reject
                                            </button>
                                        @endif

                                        <form action="{{ route('admin.hospitals.documents.destroy', [$hospital->id, $document->id]) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Delete this document?')">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-sm btn-outline-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                {{-- Reject modal --}}
                                <div class="modal fade"
                                     id="rejectModal{{ $document->id }}"
                                     tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <form action="{{ route('admin.hospitals.documents.reject', [$hospital->id, $document->id]) }}"
                                                  method="POST">
                                                @csrf

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Reject Document</h5>
                                                    <button type="button"
                                                            class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <label class="form-label">Rejection Reason *</label>
                                                    <textarea name="rejection_reason"
                                                              class="form-control"
                                                              rows="4"
                                                              required></textarea>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button"
                                                            class="btn btn-secondary"
                                                            data-bs-dismiss="modal">
                                                        Cancel
                                                    </button>

                                                    <button type="submit" class="btn btn-danger">
                                                        Reject Document
                                                    </button>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        No documents uploaded yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $documents->links() }}
            </div>
        </div>

    </div>
</div>

@endsection