<?php

namespace App\Http\Controllers\StaffApp;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StaffOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StaffAuthController extends Controller
{
    /**
     * Send Login OTP
     */
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => ['required', 'string', 'max:20'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $staff = Staff::with('hospital')
            ->where('mobile', $request->mobile)
            ->where('status', 'active')
            ->first();

        if (!$staff) {
            return response()->json([
                'success' => 0,
                'message' => 'Staff account not found or inactive.',
            ], 404);
        }

        if (
            !$staff->hospital ||
            !$staff->hospital->is_active ||
            $staff->hospital->approval_status !== 'approved'
        ) {
            return response()->json([
                'success' => 0,
                'message' => 'Hospital account is not active.',
            ], 403);
        }

        $otp = 1234;

        DB::transaction(function () use ($staff, $otp) {

            StaffOtp::where('staff_id', $staff->id)
                ->where('purpose', 'login')
                ->whereNull('verified_at')
                ->update([
                    'verified_at' => now(),
                ]);

            StaffOtp::create([
                'staff_id' => $staff->id,
                'mobile' => $staff->mobile,
                'otp_hash' => Hash::make($otp),
                'purpose' => 'login',
                'expires_at' => now()->addMinutes(5),
                'verified_at' => null,
                'attempts' => 0,
                'last_sent_at' => now(),
            ]);
        });

        /*
         * TODO: Integrate SMS provider.
         * Send $otp to $staff->mobile.
         * Never return OTP in production.
         */

        return response()->json([
            'success' => 1,
            'message' => 'OTP sent successfully.',
            'data' => [
                'mobile' => $staff->mobile,
                'otp_expiry_minutes' => 5,
            ],
        ], 200);
    }

    /**
     * Verify Login OTP
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => ['required', 'string', 'max:20'],
            'otp' => ['required', 'digits:4'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 0,
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $result = DB::transaction(function () use ($request) {

            $staff = Staff::with([
                'hospital',
                'department',
                'designation',
            ])
                ->where('mobile', $request->mobile)
                ->where('status', 'active')
                ->first();

            if (!$staff) {
                return [
                    'error' => 'Invalid staff account.',
                    'code' => 404,
                ];
            }

            if (
                !$staff->hospital ||
                !$staff->hospital->is_active ||
                $staff->hospital->approval_status !== 'approved'
            ) {
                return [
                    'error' => 'Hospital account is not active.',
                    'code' => 403,
                ];
            }

            $otpRecord = StaffOtp::where('staff_id', $staff->id)
                ->where('purpose', 'login')
                ->whereNull('verified_at')
                ->where('expires_at', '>', now())
                ->latest('id')
                ->lockForUpdate()
                ->first();

            if (!$otpRecord) {
                return [
                    'error' => 'OTP expired or not found. Please request a new OTP.',
                    'code' => 422,
                ];
            }

            if ($otpRecord->attempts >= 5) {
                return [
                    'error' => 'Maximum OTP attempts exceeded.',
                    'code' => 429,
                ];
            }

            $otpRecord->increment('attempts');

            if (!Hash::check($request->otp, $otpRecord->otp_hash)) {
                return [
                    'error' => 'Invalid OTP.',
                    'code' => 422,
                ];
            }

            $otpRecord->update([
                'verified_at' => now(),
            ]);

            $staff->update([
                'last_login_at' => now(),
            ]);

            return [
                'staff' => $staff,
            ];
        });

        if (isset($result['error'])) {
            return response()->json([
                'success' => 0,
                'message' => $result['error'],
            ], $result['code']);
        }

        $staff = $result['staff'];

        $token = $staff->createToken('staff-app')->plainTextToken;

        return response()->json([
            'success' => 1,
            'message' => 'Login successful.',
            'data' => [
                'token' => $token,
                'token_type' => 'Bearer',
                'staff' => [
                    'id' => $staff->id,
                    'hospital_id' => $staff->hospital_id,
                    'employee_code' => $staff->employee_code,
                    'name' => $staff->name,
                    'mobile' => $staff->mobile,
                    'email' => $staff->email,
                    'profile_image' => $staff->profile_image,
                    'department' => $staff->department?->name,
                    'designation' => $staff->designation?->name,
                    'status' => $staff->status,
                ],
            ],
        ], 200);
    }

    /**
     * Staff Profile
     */
    public function profile(Request $request)
    {
        $staff = Auth::guard('staff')->user();

        if (!$staff || $staff->status !== 'active') {
            return response()->json([
                'success' => 0,
                'message' => 'Staff account is unavailable.',
            ], 403);
        }

        $staff->load([
            'hospital',
            'department',
            'designation',
        ]);

        if (
            !$staff->hospital ||
            !$staff->hospital->is_active ||
            $staff->hospital->approval_status !== 'approved'
        ) {
            return response()->json([
                'success' => 0,
                'message' => 'Hospital account is not active.',
            ], 403);
        }

        return response()->json([
            'success' => 1,
            'message' => 'Staff profile fetched successfully.',
            'data' => [
                'id' => $staff->id,
                'hospital_id' => $staff->hospital_id,
                'hospital_name' => $staff->hospital->hospital_name,
                'employee_code' => $staff->employee_code,
                'name' => $staff->name,
                'mobile' => $staff->mobile,
                'email' => $staff->email,
                'profile_image' => $staff->profile_image,
                'department' => $staff->department?->name,
                'designation' => $staff->designation?->name,
                'designation_slug' => $staff->designation?->slug,
                'joining_date' => $staff->joining_date,
                'status' => $staff->status,
            ],
        ], 200);
    }

    /**
     * Staff Logout
     */
    public function logout(Request $request)
    {
        $staff = Auth::guard('staff')->user();

        if (!$staff) {
            return response()->json([
                'success' => 0,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $staff->currentAccessToken()?->delete();

        return response()->json([
            'success' => 1,
            'message' => 'Logged out successfully.',
        ], 200);
    }
}
