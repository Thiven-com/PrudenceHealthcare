<?php $page = 'signin-3'; ?>

@extends('admin.layout.mainlayout')

@section('content')

<div class="account-content">
    <div class="login-wrapper login-new">
        <div class="row w-100">
            <div class="col-lg-5 mx-auto">

                <div class="login-content user-login">

                    <div class="login-logo">
                        <img src="{{ URL::asset('build/img/logo.png') }}" alt="Prudence | Healthcare Growth Consultancy">

                        <a href="{{ route('admin.login') }}" class="login-logo logo-white">
                            <img src="{{ URL::asset('build/img/logo-white.svg') }}" alt="Prudence | Healthcare Growth Consultancy">
                        </a>
                    </div>

                    <form action="{{ route('admin.login.submit') }}" method="POST">
                        @csrf

                        <div class="card">
                            <div class="card-body p-5">

                                <div class="login-userheading">
                                    <h3>Admin Sign In</h3>
                                    <h4>Access your Prudence Healthcare Growth Consultancy administration panel.</h4>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        {{ $errors->first() }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label class="form-label">
                                        Email <span class="text-danger">*</span>
                                    </label>

                                    <div class="input-group">
                                        <input
                                            type="email"
                                            name="email"
                                            value="{{ old('email') }}"
                                            class="form-control border-end-0 @error('email') is-invalid @enderror"
                                            placeholder="Enter your email"
                                            autocomplete="username"
                                            required
                                            autofocus
                                        >

                                        <span class="input-group-text border-start-0">
                                            <i class="ti ti-mail"></i>
                                        </span>
                                    </div>

                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Password <span class="text-danger">*</span>
                                    </label>

                                    <div class="pass-group">
                                        <input
                                            type="password"
                                            name="password"
                                            class="pass-input form-control @error('password') is-invalid @enderror"
                                            placeholder="Enter your password"
                                            autocomplete="current-password"
                                            required
                                        >

                                        <span class="ti toggle-password ti-eye-off text-gray-9"></span>
                                    </div>

                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-login authentication-check">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="custom-control custom-checkbox">

                                                <label class="checkboxs ps-4 mb-0 pb-0 line-height-1 fs-16 text-gray-6">
                                                    <input
                                                        type="checkbox"
                                                        name="remember"
                                                        value="1"
                                                        class="form-control"
                                                        {{ old('remember') ? 'checked' : '' }}
                                                    >
                                                    <span class="checkmarks"></span>
                                                    Remember me
                                                </label>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-login">
                                    <button type="submit" class="btn btn-primary w-100">
                                        Sign In
                                    </button>
                                </div>

                            </div>
                        </div>
                    </form>

                </div>

                <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                    <p>Copyright &copy; {{ date('Y') }} Prudence | Healthcare Growth Consultancy. All rights reserved.</p>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection