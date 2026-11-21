<?php $page = 'signin-3'; ?>

@extends('hospital.layout.mainlayout')

@section('content')

<div class="account-content">
    <div class="login-wrapper login-new">
        <div class="row w-100">
            <div class="col-lg-5 mx-auto">

                <div class="login-content user-login">

                    <div class="login-logo">
                        <img src="{{ URL::asset('build/img/logo.png') }}" alt="Prudence Healthcare Growth Consultancy">

                        <a href="{{ route('hospital.login') }}" class="login-logo logo-white">
                            <img src="{{ URL::asset('build/img/logo-white.svg') }}" alt="Prudence Healthcare Growth Consultancy">
                        </a>
                    </div>

                    <div class="card">
                        <div class="card-body p-5">

                            <div class="login-userheading">
                                <h3>Hospital Sign In</h3>
                                <h4>Login securely using your registered mobile number.</h4>
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

                            @if (!session('otp_sent'))
                                {{-- Send OTP Form --}}
                                <form action="{{ route('hospital.login.submit') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label">
                                            Registered Mobile Number
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group">
                                            <input
                                                type="tel"
                                                name="mobile"
                                                value="{{ old('mobile') }}"
                                                class="form-control border-end-0"
                                                placeholder="Enter registered mobile number"
                                                maxlength="20"
                                                autocomplete="tel"
                                                required
                                            >

                                            <span class="input-group-text border-start-0">
                                                <i class="ti ti-phone"></i>
                                            </span>
                                        </div>

                                        @error('mobile')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="form-login">
                                        <button type="submit" class="btn btn-primary w-100">
                                            Send OTP
                                        </button>
                                    </div>
                                </form>

                            @else
                                {{-- Verify OTP Form --}}
                                <form action="{{ route('hospital.verify-login-otp') }}" method="POST">
                                    @csrf

                                    <input
                                        type="hidden"
                                        name="mobile"
                                        value="{{ session('login_mobile') }}"
                                    >

                                    <div class="mb-3">
                                        <label class="form-label">
                                            Enter OTP
                                            <span class="text-danger">*</span>
                                        </label>

                                        <div class="input-group">
                                            <input
                                                type="text"
                                                name="otp"
                                                class="form-control border-end-0"
                                                placeholder="Enter 4-digit OTP"
                                                maxlength="4"
                                                inputmode="numeric"
                                                pattern="[0-9]{4}"
                                                autocomplete="one-time-code"
                                                required
                                            >

                                            <span class="input-group-text border-start-0">
                                                <i class="ti ti-lock"></i>
                                            </span>
                                        </div>

                                        @error('otp')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror

                                        <small class="text-muted">
                                            OTP sent to {{ session('login_mobile') }}
                                        </small>
                                    </div>

                                    <div class="form-login">
                                        <button type="submit" class="btn btn-primary w-100">
                                            Verify OTP & Sign In
                                        </button>
                                    </div>
                                </form>

                                <div class="text-center mt-3">
                                    <a href="{{ route('hospital.login') }}">
                                        Change Mobile Number
                                    </a>
                                </div>
                            @endif

                            <div class="signinform mt-4">
                                <h4>
                                    Don't have an account?
                                    <a href="{{ route('hospital.register') }}" class="hover-a">
                                        Register Hospital
                                    </a>
                                </h4>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                    <p>Copyright &copy; {{ date('Y') }} Prudence | Healthcare Growth Consultancy. All rights reserved.</p>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection