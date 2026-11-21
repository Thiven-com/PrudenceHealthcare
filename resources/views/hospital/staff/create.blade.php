<?php $page = 'add-employee'; ?>
@extends('hospital.layout.mainlayout')

@section('content')
    <div class="page-wrapper">
        <div class="content">

            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Add Staff</h4>
                        <h6>Create a new hospital employee</h6>
                    </div>
                </div>

                <div class="page-btn">
                    <a href="{{ route('hospital.staff.index') }}" class="btn btn-secondary">
                        <i data-feather="arrow-left" class="me-2"></i> Back to List
                    </a>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    Please correct the errors in the form.
                </div>
            @endif

            <form action="{{ route('hospital.staff.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @include('hospital.staff._form')
            </form>

        </div>
    </div>
@endsection