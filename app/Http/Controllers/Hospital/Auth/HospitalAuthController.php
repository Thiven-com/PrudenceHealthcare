<?php

namespace App\Http\Controllers\Hospital\Auth;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\HospitalOtp;
use App\Services\HospitalDefaultStructureService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class HospitalAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('hospital')->check()) {
            return redirect()->route('hospital.dashboard');
        }

        return view('hospital.auth.login');
    }

    public function sendLoginOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $hospital = Hospital::where('mobile', $request->mobile)->first();

        if (!$hospital) {
            return back()->withErrors([
                'mobile' => 'Hospital account not found.',
            ])->withInput();
        }

        // if (!$hospital->is_mobile_verified) {
        //     return back()->withErrors([
        //         'mobile' => 'Please complete mobile verification first.',
        //     ])->withInput();
        // }

        if ($hospital->approval_status !== 'approved') {
            return back()->withErrors([
                'mobile' => 'Your hospital account is awaiting Admin approval.',
            ])->withInput();
        }

        if (!$hospital->is_active) {
            return back()->withErrors([
                'mobile' => 'Your hospital account is inactive.',
            ])->withInput();
        }

        $otp = (string) 1234;
        // $otp = (string) random_int(100000, 999999);

        HospitalOtp::where('hospital_id', $hospital->id)
            ->where('purpose', 'login')
            ->whereNull('verified_at')
            ->delete();

        HospitalOtp::create([
            'hospital_id' => $hospital->id,
            'mobile' => $hospital->mobile,
            'otp_hash' => Hash::make($otp),
            'purpose' => 'login',
            'expires_at' => now()->addMinutes(5),
            'last_sent_at' => now(),
            'attempts' => 0,
        ]);

        session()->put('login_mobile', $hospital->mobile);

        return redirect()
            ->route('hospital.login')
            ->with('otp_sent', true)
            ->with('success', 'OTP generated successfully. Please verify your mobile number.');
    }

    public function verifyLoginOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|string|max:20',
            'otp' => 'required|digits:4',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $hospital = Hospital::where('mobile', $request->mobile)->first();

        if (
            !$hospital ||
            $hospital->approval_status !== 'approved' ||
            !$hospital->is_active
        ) {
            return back()->withErrors([
                'mobile' => 'Hospital account is not eligible to log in.',
            ])->withInput();
        }

        $otpRecord = HospitalOtp::where('hospital_id', $hospital->id)
            ->where('mobile', $hospital->mobile)
            ->where('purpose', 'login')
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if (!$otpRecord || $otpRecord->expires_at < now()) {
            return back()->withErrors([
                'otp' => 'OTP expired. Please request a new OTP.',
            ])->withInput();
        }

        if ($otpRecord->attempts >= 5) {
            return back()->withErrors([
                'otp' => 'Maximum OTP attempts exceeded. Request a new OTP.',
            ])->withInput();
        }

        if (!Hash::check($request->otp, $otpRecord->otp_hash)) {
            $otpRecord->increment('attempts');

            return back()->withErrors([
                'otp' => 'Invalid OTP.',
            ])->withInput();
        }

        $otpRecord->update([
            'verified_at' => now(),
        ]);

        Auth::guard('hospital')->login($hospital);

        $request->session()->regenerate();
        $request->session()->forget('login_mobile');

        $hospital->update([
            'last_login_at' => now(),
        ]);

        return redirect()
            ->route('hospital.dashboard')
            ->with('success', 'Welcome to Hospital Panel.');
    }

    public function logout(Request $request)
    {
        Auth::guard('hospital')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('hospital.login');
    }

    public function showRegister()
    {
        return view('hospital.auth.register');
    }


    public function register(
        Request $request,
        HospitalDefaultStructureService $defaultStructure
    ) {
        $validated = $request->validate([
            'hospital_name' => 'required|string|max:255',
            'registration_number' => 'nullable|string|max:100',
            'contact_person' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
        ]);

        $existingHospital = Hospital::where('mobile', $validated['mobile'])
            ->first();

        if ($existingHospital && $existingHospital->is_mobile_verified) {
            return back()->withErrors([
                'mobile' => 'This mobile number is already registered.',
            ])->withInput();
        }

        $hospital = DB::transaction(function () use ($validated, $existingHospital, $defaultStructure) {

            if ($existingHospital) {

                // Reuse existing unverified registration
                $hospital = $existingHospital;

                $hospital->update([
                    'hospital_name' => $validated['hospital_name'],
                    'registration_number' => $validated['registration_number'] ?? null,
                    'contact_person' => $validated['contact_person'],
                    'email' => $validated['email'] ?? null,
                    'address' => $validated['address'] ?? null,
                    'city' => $validated['city'] ?? null,
                    'state' => $validated['state'] ?? null,
                    'pincode' => $validated['pincode'] ?? null,
                ]);

            } else {

                $hospital = Hospital::create([
                    'hospital_name' => $validated['hospital_name'],
                    'registration_number' => $validated['registration_number'] ?? null,
                    'contact_person' => $validated['contact_person'],
                    'mobile' => $validated['mobile'],
                    'email' => $validated['email'] ?? null,
                    'address' => $validated['address'] ?? null,
                    'city' => $validated['city'] ?? null,
                    'state' => $validated['state'] ?? null,
                    'pincode' => $validated['pincode'] ?? null,
                    'is_mobile_verified' => 0,
                    'approval_status' => 'pending',
                    'is_active' => 0,
                ]);
            }

            // Ensure default department and designations exist
            $defaultStructure->createFor($hospital);

            return $hospital;
        });

        $otp = 1234;
        // $otp = (string) random_int(100000, 999999);

        HospitalOtp::where('hospital_id', $hospital->id)
            ->where('purpose', 'registration')
            ->whereNull('verified_at')
            ->delete();

        HospitalOtp::create([
            'hospital_id' => $hospital->id,
            'mobile' => $hospital->mobile,
            'otp_hash' => Hash::make($otp),
            'purpose' => 'registration',
            'expires_at' => now()->addMinutes(5),
            'last_sent_at' => now(),
            'attempts' => 0,
        ]);

        /*
         * TODO: Integrate your SMS provider here.
         * Send $otp to $hospital->mobile.
         */

        session()->put('registration_mobile', $hospital->mobile);

        return redirect()
            ->route('hospital.register.verify')
            ->with('success', 'Registration submitted. Please verify your mobile number.');
    }


    public function showRegistrationOtp()
    {
        if (!session()->has('registration_mobile')) {
            return redirect()->route('hospital.register');
        }

        return view('hospital.auth.verify-registration-otp', [
            'mobile' => session('registration_mobile'),
        ]);
    }

    public function verifyRegistrationOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|string|max:20',
            'otp' => 'required|digits:4',
        ]);

        $mobile = session('registration_mobile');

        if (!$mobile || $mobile !== $request->mobile) {
            return redirect()->route('hospital.register')
                ->withErrors(['mobile' => 'Registration session expired. Please register again.']);
        }

        $hospital = Hospital::where('mobile', $mobile)->first();

        if (!$hospital) {
            return redirect()->route('hospital.register')
                ->withErrors(['mobile' => 'Hospital registration not found.']);
        }

        $otpRecord = HospitalOtp::where('hospital_id', $hospital->id)
            ->where('mobile', $mobile)
            ->where('purpose', 'registration')
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if (!$otpRecord || $otpRecord->expires_at < now()) {
            return back()->withErrors([
                'otp' => 'OTP expired. Please register again to request a new OTP.',
            ]);
        }

        if ($otpRecord->attempts >= 5) {
            return back()->withErrors([
                'otp' => 'Maximum OTP attempts exceeded. Please register again.',
            ]);
        }

        if (!Hash::check($request->otp, $otpRecord->otp_hash)) {
            $otpRecord->increment('attempts');

            return back()->withErrors([
                'otp' => 'Invalid OTP.',
            ]);
        }

        $otpRecord->update([
            'verified_at' => now(),
        ]);

        $hospital->update([
            'is_mobile_verified' => 1,
            'mobile_verified_at' => now(),
        ]);

        session()->forget('registration_mobile');

        return redirect()
            ->route('hospital.login')
            ->with('success', 'Mobile verified successfully. Your registration is awaiting Admin approval.');
    }
}