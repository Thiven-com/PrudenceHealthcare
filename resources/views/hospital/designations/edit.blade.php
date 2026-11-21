
@extends('hospital.layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Edit Designation</h4>
                <h6>Update designation information</h6>
            </div>
        </div>

        <form action="{{ route('hospital.designations.update', $designation->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('hospital.designations._form')
        </form>
    </div>
</div>
@endsection
