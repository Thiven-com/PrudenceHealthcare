<?php $page = 'lead-modules'; ?>

@extends('admin.layout.mainlayout')

@section('content')
    <div class="page-wrapper">
        <div class="content">

            <div class="d-flex align-items-center justify-content-between flex-wrap mb-4">
                <div>
                    <h2 class="mb-1">Lead Modules</h2>
                    <p class="text-muted mb-0">Manage platform lead modules</p>
                </div>

                <a href="{{ route('admin.lead-modules.create') }}" class="btn btn-primary">
                    <i class="ti ti-plus me-1"></i> Add Module
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Module Name</th>
                                    <th>Slug</th>
                                    <th>Leads</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($leadModules as $module)
                                    <tr>
                                        <td>{{ $leadModules->firstItem() + $loop->index }}</td>
                                        <td class="fw-medium">{{ $module->name }}</td>
                                        <td><code>{{ $module->slug }}</code></td>
                                        <td>{{ number_format($module->leads_count) }}</td>
                                        <td>
                                            @if($module->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $module->created_at?->format('d M Y') ?? '-' }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.lead-modules.edit', $module->id) }}"
                                                class="btn btn-sm btn-light">
                                                <i class="ti ti-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.lead-modules.destroy', $module->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this module?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light text-danger">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            No lead modules found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $leadModules->links() }}
                    </div>
                </div>
            </div>

        </div>

        @include('admin.layout.partials.footer')
    </div>
@endsection