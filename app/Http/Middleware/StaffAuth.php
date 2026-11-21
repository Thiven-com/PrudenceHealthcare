<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StaffAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('staff')->check()) {
            return redirect()->route('staff.login');
        }

        $staff = Auth::guard('staff')->user();

        if ($staff->status !== 'active') {
            Auth::guard('staff')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('staff.login')
                ->withErrors([
                    'mobile' => 'Your staff account is inactive.'
                ]);
        }

        return $next($request);
    }
}