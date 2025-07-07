<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectToDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */    public function handle(Request $request, Closure $next): Response
    {
        // Hanya jalankan untuk user yang sudah login
        if (Auth::check()) {
            $user = Auth::user();

            // Hanya superadmin, admin desa, dan operator yang bisa mengakses dashboard
            if ($user->hasRole(['superadmin', 'admin_desa', 'operator_desa'])) {
                // Redirect ke Filament dashboard
                if ($request->is('dashboard') || $request->is('/')) {
                    return redirect('/admin');
                }
            } else {
                // User tidak memiliki role yang diizinkan, logout
                Auth::logout();
                return redirect()->route('login')->withErrors(['email' => 'Akun Anda tidak memiliki izin mengakses sistem.']);
            }
        }

        return $next($request);
    }
}
