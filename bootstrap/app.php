<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
    web: __DIR__.'/../routes/web.php',
    api: __DIR__.'/../routes/api.php',
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {
    // Alias middleware
    $middleware->alias([
        'auth.check' => \App\Http\Middleware\CheckAuth::class,
        'role' => \App\Http\Middleware\CheckRole::class,
    ]);

    // Middleware WEB
    $middleware->web(append: [
        \App\Http\Middleware\SettingsMiddleware::class,
    ]);

    // ⬇️ TAMBAHKAN INI (FIX 419)
    $middleware->validateCsrfTokens(except: [
        'api/bins/update-sensor',
    ]);
})

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();