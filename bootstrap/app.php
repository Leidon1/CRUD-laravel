<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'moderatorAuth' => \App\Http\Middleware\ModeratorAuth::class,
            'adminAuth' => \App\Http\Middleware\AdminAuth::class,
            // Add more middleware aliases here if needed
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
