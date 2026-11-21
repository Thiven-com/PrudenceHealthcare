<?php $page = 'edit-employee'; ?>
@extends('hospital.layout.mainlayout')

@section('content')
    <div class="page-wrapper">
        <div class="content">

            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4>Edit Staff</h4>
                        <h6>Update employee information</h6>
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

            <form action="{{ route('hospital.staff.update', $staffMember->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('hospital.staff._form')
            </form>

        </div>
    </div>
@endsection