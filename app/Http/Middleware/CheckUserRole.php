<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Verifica si el usuario tiene un rol específico y redirige en consecuencia.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Si no está autenticado, redirigir a login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Si el usuario tiene al menos uno de los roles especificados
        if ($user->hasAnyRole($roles)) {
            return $next($request);
        }

        // Si el usuario no tiene ninguno de los roles requeridos
        // Solo permitir roles autorizados en el sistema
        if ($user->hasRole(['superadmin', 'admin_desa', 'operator_desa'])) {
            return redirect()->route('filament.superadmin.pages.dashboard');
        }

        // Usuario sin rol autorizado, logout
        Auth::logout();
        return redirect()->route('login')->withErrors(['email' => 'Akun Anda tidak memiliki izin mengakses sistem.']);
    }
}
