
<?php $page = 'edit-hospital'; ?>

@extends('admin.layout.mainlayout')

@section('content')

<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Edit Hospital</h4>
                    <h6>Update Hospital Information</h6>
                </div>
            </div>

            <ul class="table-top-head">
                <li class="me-2">
                    <a data-bs-toggle="tooltip" title="Refresh">
                        <i class="ti ti-refresh"></i>
                    </a>
                </li>
                <li>
                    <a data-bs-toggle="tooltip" title="Collapse" id="collapse-header">
                        <i class="ti ti-chevron-up"></i>
                    </a>
                </li>
            </ul>

            <div class="page-btn">
                <a href="{{ route('admin.hospitals.index') }}" class="btn btn-secondary">
                    <i data-feather="arrow-left" class="me-2"></i>Back to List
                </a>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                Please correct the highlighted fields.
            </div>
        @endif

        <form action="{{ route('admin.hospitals.update', $hospital->id) }}"
            method="POST" enctype="multipart/form-data">

            @include('admin.hospitals._form')

        </form>

    </div>
</div>

@endsection

@include('admin.layout.partials.footer')
