<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

// Ensure APP_KEY environment variable is never empty at runtime on Wasmer or cloud deployments
if (empty($_ENV['APP_KEY'] ?? null) && empty($_SERVER['APP_KEY'] ?? null) && empty(getenv('APP_KEY'))) {
    putenv('APP_KEY=base64:bW1X54LPQUCzjftKBU6HwZjlWWaFa91WRuwRhRouLQg=');
    $_ENV['APP_KEY'] = 'base64:bW1X54LPQUCzjftKBU6HwZjlWWaFa91WRuwRhRouLQg=';
    $_SERVER['APP_KEY'] = 'base64:bW1X54LPQUCzjftKBU6HwZjlWWaFa91WRuwRhRouLQg=';
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
