<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StaffAppAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $staff = Auth::guard('staff')->user();

        if (!$staff) {
            return response()->json([
                'success' => 0,
                'message' => 'Please Login',
            ], 401);
        }

        if ($staff->status !== 'active') {
            $staff->currentAccessToken()?->delete();

            return response()->json([
                'success' => 0,
                'message' => 'Staff account is inactive.',
            ], 403);
        }

        if (
            !$staff->hospital ||
            !$staff->hospital->is_active ||
            $staff->hospital->approval_status !== 'approved'
        ) {
            $staff->currentAccessToken()?->delete();

            return response()->json([
                'success' => 0,
                'message' => 'Hospital account is not active.',
            ], 403);
        }

        return $next($request);
    }
}