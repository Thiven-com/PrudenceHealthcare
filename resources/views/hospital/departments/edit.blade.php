
@extends('hospital.layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Edit Department</h4>
                <h6>Update department information</h6>
            </div>
        </div>

        <form action="{{ route('hospital.departments.update', $department->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('hospital.departments._form')
        </form>
    </div>
</div>
@endsection
