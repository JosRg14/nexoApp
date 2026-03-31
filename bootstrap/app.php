<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\InjectApiToken;
use App\Http\Middleware\CheckBusinessSuscripcion; // 1. Importamos el nuevo middleware

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'inject.api.token' => InjectApiToken::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'guest.session' => RedirectIfAuthenticated::class,
            'check.business' => CheckBusinessSuscripcion::class, // 2. Registramos el alias aquí
        ]);

        $middleware->web(append: [
            InjectApiToken::class,
            // Aquí NO pongas 'check.business' globalmente porque causaría un bucle infinito en el Login
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();