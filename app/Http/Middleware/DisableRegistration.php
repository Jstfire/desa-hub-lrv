<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DisableRegistration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Sistem ini khusus untuk admin, tidak ada registrasi user biasa
        // Redirect ke login dengan pesan error
        return redirect()->route('login')->withErrors([
            'email' => 'Registrasi tidak diizinkan. Sistem ini khusus untuk admin yang sudah ditentukan.'
        ]);
    }
}
