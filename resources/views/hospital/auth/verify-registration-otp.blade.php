@extends('hospital.layout.mainlayout')

@section('content')

    <div class="account-content">
        <div class="login-wrapper">
            <div class="login-content">
                <form action="{{ route('hospital.register.verify.submit') }}" method="POST">
                    @csrf

                    <div class="login-userset">

                        <div class="login-userheading">
                            <h3>Verify Mobile Number</h3>
                            <h4>Enter the six-digit OTP sent to {{ $mobile }}.</h4>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <input type="hidden" name="mobile" value="{{ $mobile }}">

                        <div class="form-login">
                            <label>Enter OTP</label>
                            <div class="form-addons">
                                <input type="text" name="otp" class="form-control" maxlength="4" inputmode="numeric"
                                    pattern="[0-9]{4}" placeholder="Enter 4-digit OTP" required>
                            </div>
                        </div>

                        <div class="form-login">
                            <button type="submit" class="btn btn-login">
                                Verify OTP
                            </button>
                        </div>

                        <div class="signinform text-center">
                            <a href="{{ route('hospital.register') }}">
                                Back to Registration
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection