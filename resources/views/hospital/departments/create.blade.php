
@extends('hospital.layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Add Department</h4>
                <h6>Create a new hospital department</h6>
            </div>
        </div>

        <form action="{{ route('hospital.departments.store') }}" method="POST">
            @csrf
            @include('hospital.departments._form')
        </form>
    </div>
</div>
@endsection
