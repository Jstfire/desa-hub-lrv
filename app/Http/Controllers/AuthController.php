<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    /**
     * Mostrar vista de login unificada.
     * Esta reemplazará tanto la vista de login de Jetstream como la de Filament
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Manejar redirección después del login basado en el rol del usuario
     */
    public function redirectBasedOnRole()
    {
        $user = Auth::user();

        // Hanya izinkan user dengan role yang diotorisasi
        if ($user->hasRole(['superadmin', 'admin_desa', 'operator_desa'])) {
            return redirect()->route('filament.superadmin.pages.dashboard');
        }

        // User tanpa role yang diizinkan, logout
        Auth::logout();
        return redirect()->route('login')->withErrors(['email' => 'Akun Anda tidak memiliki izin mengakses sistem.']);
    }
}
