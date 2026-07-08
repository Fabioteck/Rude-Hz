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
        // Tracciamento analitico agganciato globalmente al gruppo web
        $middleware->web(append: [
            \App\Http\Middleware\TrackPageViews::class,
        ]);
        
        // Conservazione completa dei tuoi alias esistenti
        $middleware->alias([
            'liberatoria' => \App\Http\Middleware\CheckLiberatoria::class,
            'is_admin' => \App\Http\Middleware\IsAdmin::class,
        ]);
        
        // Gestione dei reindirizzamenti degli utenti e dei guest
        $middleware->redirectTo(
            guests: '/login',
            users: '/dashboard' // Forza il passaggio dalla rotta bivio in web.php
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
