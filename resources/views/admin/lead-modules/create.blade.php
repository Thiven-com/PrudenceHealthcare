<?php $page = 'lead-modules'; ?>

@extends('admin.layout.mainlayout')

@section('content')
    <div class="page-wrapper">
        <div class="content">

            <div class="mb-4">
                <h2 class="mb-1">Add Lead Module</h2>
                <p class="text-muted">Create a new platform lead module</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.lead-modules.store') }}" method="POST">
                @csrf
                @include('admin.lead-modules._form')
            </form>

        </div>
        @include('admin.layout.partials.footer')
    </div>
@endsection