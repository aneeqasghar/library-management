<?php

use App\Actions\BanUsers;
use App\Actions\MarkOverdueBooks;
use App\Actions\SuspendUsers;
use App\Http\Middleware\UpgradeToHttpsUnderNgrok;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Kernel;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(UpgradeToHttpsUnderNgrok::class);
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('users:ban')->everySecond();
        $schedule->command('books:overdue')->everySecond();
        $schedule->command('users:suspend')->everySecond();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
