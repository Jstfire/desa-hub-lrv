<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Redirige a la página adecuada según el rol del usuario
     */
    public function index()
    {
        if (!Auth::check()) {
            // Show welcome page with available villages
            $desas = Desa::where('is_active', true)
                ->orderBy('nama')
                ->get();

            return view('welcome', compact('desas'));
        }

        $user = Auth::user();

        // Sistem hanya untuk superadmin, admin desa, dan operator desa
        if ($user->hasRole(['superadmin', 'admin_desa', 'operator_desa'])) {
            return redirect()->route('filament.superadmin.pages.dashboard');
        }

        // Jika user tidak memiliki role yang diizinkan, logout dan redirect
        Auth::logout();
        return redirect()->route('login')->withErrors(['email' => 'Akun Anda tidak memiliki izin mengakses sistem.']);
    }
}
