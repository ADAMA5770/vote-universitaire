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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin'       => \App\Http\Middleware\AdminMiddleware::class,
            'maintenance' => \App\Http\Middleware\MaintenanceMiddleware::class,
        ]);
    })
    ->withSchedule(function (\Illuminate\Console\Scheduling\Schedule $schedule): void {
        // Met à jour automatiquement les statuts des élections toutes les heures
        $schedule->command('elections:update-statut')->hourly();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
