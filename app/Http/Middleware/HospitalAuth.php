<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HospitalAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('hospital')->check()) {
            return redirect()->route('hospital.login');
        }

        $hospital = Auth::guard('hospital')->user();

        if (
            !$hospital->is_active ||
            $hospital->approval_status !== 'approved'
        ) {
            Auth::guard('hospital')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('hospital.login')
                ->withErrors([
                    'mobile' => 'Your hospital account is not approved or active.'
                ]);
        }

        return $next($request);
    }
}