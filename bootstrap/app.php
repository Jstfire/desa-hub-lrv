<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        then: function () {
            require __DIR__ . '/../routes/auth.php';
            require __DIR__ . '/../routes/filament.php';
        },
        health: '/up',
    )
    ->withProviders([
        // Registrar nuestros providers
        \App\Providers\FilamentServiceProvider::class,
    ])
    ->withMiddleware(function (Middleware $middleware): void {
        // Add CORS middleware
        $middleware->web(append: [
            \Illuminate\Http\Middleware\HandleCors::class,
        ]);
        
        // Registrar nuestro middleware de roles
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckUserRole::class,
            'filament.access' => \App\Http\Middleware\EnsureUserHasFilamentAccess::class,
            'disable.registration' => \App\Http\Middleware\DisableRegistration::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
