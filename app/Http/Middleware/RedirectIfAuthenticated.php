<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                // Hanya izinkan user dengan role yang diotorisasi
                if ($user && $user->hasRole(['superadmin', 'admin_desa', 'operator_desa'])) {
                    return redirect()->route('filament.superadmin.pages.dashboard');
                }

                // User tanpa role yang diizinkan, logout
                Auth::logout();
                return redirect()->route('login')->withErrors(['email' => 'Akun Anda tidak memiliki izin mengakses sistem.']);
            }
        }

        return $next($request);
    }
}
