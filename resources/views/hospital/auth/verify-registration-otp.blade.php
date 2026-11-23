
<?php $page = 'signin-3'; ?>

@extends('hospital.layout.mainlayout')

@section('content')

<div class="account-content">
    <div class="login-wrapper login-new">
        <div class="row w-100">
            <div class="col-lg-5 mx-auto">

                <div class="login-content user-login">

                    {{-- Logo --}}
                    <div class="login-logo">
                        <img src="{{ URL::asset('build/img/logo.png') }}" alt="Prudence Healthcare Growth Consultancy">

                        <a href="{{ route('hospital.login') }}" class="login-logo logo-white">
                            <img src="{{ URL::asset('build/img/logo-white.svg') }}" alt="Prudence Healthcare Growth Consultancy">
                        </a>
                    </div>

                    <div class="card">
                        <div class="card-body p-5">

                            {{-- Heading --}}
                            <div class="login-userheading">
                                <h3>Verify Mobile Number</h3>
                                <h4>Enter the four-digit OTP sent to {{ $mobile }}.</h4>
                            </div>

                            {{-- Success Message --}}
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            {{-- Error Message --}}
                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show">
                                    {{ $errors->first() }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            {{-- OTP Verification Form --}}
                            <form action="{{ route('hospital.register.verify.submit') }}" method="POST">
                                @csrf

                                <input type="hidden" name="mobile" value="{{ $mobile }}">

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
                                            maxlength="4"
                                            inputmode="numeric"
                                            pattern="[0-9]{4}"
                                            placeholder="Enter 4-digit OTP"
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
                                </div>

                                <div class="form-login">
                                    <button type="submit" class="btn btn-primary w-100">
                                        Verify OTP
                                    </button>
                                </div>
                            </form>

                            {{-- Back to Registration --}}
                            <div class="text-center mt-3">
                                <a href="{{ route('hospital.register') }}">
                                    Back to Registration
                                </a>
                            </div>

                        </div>
                    </div>

                </div>

                {{-- Copyright --}}
                <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                    <p>Copyright &copy; {{ date('Y') }} Prudence | Healthcare Growth Consultancy. All rights reserved.</p>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection