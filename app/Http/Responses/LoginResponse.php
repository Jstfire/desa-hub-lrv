<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LoginResponse implements LoginResponseContract
{
    /**
     * Redirige al usuario después del login basado en su rol
     */
    public function toResponse($request): RedirectResponse
    {
        $user = Auth::user();

        // Hanya superadmin, admin desa, dan operator yang bisa login
        if ($user->hasRole(['superadmin', 'admin_desa', 'operator_desa'])) {
            // Redirect langsung ke dashboard yang dihandle oleh Filament
            return redirect('/dashboard');
        }

        // Jika user tidak memiliki role yang diizinkan, logout dan redirect ke login
        Auth::logout();
        return redirect()->route('login')->withErrors(['email' => 'Akun Anda tidak memiliki izin mengakses sistem.']);
    }
}
