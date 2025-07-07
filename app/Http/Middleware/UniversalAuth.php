<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UniversalAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado
        if (Auth::check() && $request->is('login')) {
            $user = Auth::user();

            // Verificar si tiene role de superadmin
            if ($user->hasRole('superadmin')) {
                return redirect()->route('filament.superadmin.pages.dashboard');
            }

            // De lo contrario, redirigir al dashboard de Jetstream
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
