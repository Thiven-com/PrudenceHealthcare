<?php $page = 'register-3'; ?>
@extends('hospital.layout.mainlayout')

@section('content')

<div class="account-content">
    <div class="login-wrapper login-new">
        <div class="row w-100">
            <div class="col-lg-6 mx-auto">

                <div class="login-content user-login">

                    <div class="login-logo">
                        <img src="{{ URL::asset('build/img/logo.png') }}" alt="Logo">
                        <a href="{{ url('/') }}" class="login-logo logo-white">
                            <img src="{{ URL::asset('build/img/logo-white.svg') }}" alt="Logo">
                        </a>
                    </div>

                    <form action="{{ route('hospital.register.submit') }}" method="POST">
                        @csrf

                        <div class="card">
                            <div class="card-body p-5">

                                <div class="login-userheading">
                                    <h3>Hospital Registration</h3>
                                    <h4>Register your hospital with Prudence | Healthcare Growth Consultancy</h4>
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label class="form-label">
                                        Hospital Name <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="text"
                                               name="hospital_name"
                                               value="{{ old('hospital_name') }}"
                                               class="form-control border-end-0"
                                               placeholder="Enter hospital name"
                                               required>
                                        <span class="input-group-text border-start-0">
                                            <i class="ti ti-building-hospital"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Registration Number</label>
                                    <div class="input-group">
                                        <input type="text"
                                               name="registration_number"
                                               value="{{ old('registration_number') }}"
                                               class="form-control border-end-0"
                                               placeholder="Hospital registration number">
                                        <span class="input-group-text border-start-0">
                                            <i class="ti ti-id"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Contact Person <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="text"
                                               name="contact_person"
                                               value="{{ old('contact_person') }}"
                                               class="form-control border-end-0"
                                               placeholder="Enter contact person name"
                                               required>
                                        <span class="input-group-text border-start-0">
                                            <i class="ti ti-user"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        Mobile Number <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="tel"
                                               name="mobile"
                                               value="{{ old('mobile') }}"
                                               class="form-control border-end-0"
                                               placeholder="Enter mobile number"
                                               maxlength="20"
                                               required>
                                        <span class="input-group-text border-start-0">
                                            <i class="ti ti-phone"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email Address</label>
                                    <div class="input-group">
                                        <input type="email"
                                               name="email"
                                               value="{{ old('email') }}"
                                               class="form-control border-end-0"
                                               placeholder="Enter email address">
                                        <span class="input-group-text border-start-0">
                                            <i class="ti ti-mail"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <div class="input-group">
                                        <input type="text"
                                               name="address"
                                               value="{{ old('address') }}"
                                               class="form-control border-end-0"
                                               placeholder="Enter hospital address">
                                        <span class="input-group-text border-start-0">
                                            <i class="ti ti-map-pin"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">City</label>
                                        <div class="input-group">
                                            <input type="text"
                                                   name="city"
                                                   value="{{ old('city') }}"
                                                   class="form-control border-end-0"
                                                   placeholder="City">
                                            <span class="input-group-text border-start-0">
                                                <i class="ti ti-map"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">State</label>
                                        <div class="input-group">
                                            <input type="text"
                                                   name="state"
                                                   value="{{ old('state') }}"
                                                   class="form-control border-end-0"
                                                   placeholder="State">
                                            <span class="input-group-text border-start-0">
                                                <i class="ti ti-map-2"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Pincode</label>
                                    <div class="input-group">
                                        <input type="text"
                                               name="pincode"
                                               value="{{ old('pincode') }}"
                                               class="form-control border-end-0"
                                               placeholder="Enter pincode"
                                               maxlength="20">
                                        <span class="input-group-text border-start-0">
                                            <i class="ti ti-mailbox"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-login authentication-check">
                                    <label class="checkboxs ps-4 mb-0 pb-0 line-height-1">
                                        <input type="checkbox" name="terms" value="1" required>
                                        <span class="checkmarks"></span>
                                        I agree to the
                                        <a href="#" class="text-primary">Terms & Privacy</a>
                                    </label>
                                </div>

                                <div class="form-login">
                                    <button type="submit" class="btn btn-login">
                                        Register Hospital
                                    </button>
                                </div>

                                <div class="signinform">
                                    <h4>
                                        Already registered?
                                        <a href="{{ route('hospital.login') }}" class="hover-a">
                                            Sign In Instead
                                        </a>
                                    </h4>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                    <p>Copyright &copy; {{ date('Y') }} Prudence | Healthcare Growth Consultancy</p>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection