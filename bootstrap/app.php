<?php

use App\Http\Middleware\EnsureTokenValid;
use App\Http\Middleware\EnsureUserHasRole;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Middleware Order (Priority)
        $middleware->priority([
            EnsureUserHasRole::class,
        ]);
        // Lets you use 'setLocale' as a shorthand in route definitions like Route::middleware('setLocale')
        $middleware->alias([
            'setLocale' => SetLocale::class,
        ]);
        // Adds this middleware to every request, globally.
        $middleware->append(EnsureTokenValid::class);  // It runs later, after other middleware

        // $middleware->prepend(EnsureTokenValid::class); -  It runs earlier, before other middleware

        // Middleware Groups
        $middleware->appendToGroup('auth-lookup', [
            SetLocale::class,
            EnsureTokenValid::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
