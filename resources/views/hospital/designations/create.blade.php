
@extends('hospital.layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Add Designation</h4>
                <h6>Create a designation under a department</h6>
            </div>
        </div>

        <form action="{{ route('hospital.designations.store') }}" method="POST">
            @csrf
            @include('hospital.designations._form')
        </form>
    </div>
</div>
@endsection
