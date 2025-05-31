<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Console\Scheduling\Schedule;
use App\Http\Middleware\ApiAuthenticateWithSanctum;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\ThrottleRequests;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'api.auth.sanctum' => ApiAuthenticateWithSanctum::class,
        ]);
        $middleware->group('api', [ThrottleRequests::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        // Disperindag (role_id: 2) — Setiap hari
        $schedule->command('notifikasi:generate 2')->dailyAt('08:00');
        // $schedule->command('notifikasi:generate 2')->everyThirtySeconds();

        // DKPP (role_id: 3) — Setiap Senin
        $schedule->command('notifikasi:generate 3')->weeklyOn(1, '08:00');

        // DTPHP (role_id: 4) — Setiap tanggal 1
        $schedule->command('notifikasi:generate 4')->monthlyOn(1, '08:00');

        // Perikanan (role_id: 5) — Setiap tanggal 1
        $schedule->command('notifikasi:generate 5')->monthlyOn(1, '08:00');
    })
    ->create();
