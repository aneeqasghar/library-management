<?php

use App\Actions\BanUsers;
use App\Actions\MarkOverdueBooks;
use App\Actions\SuspendUsers;
use App\Http\Middleware\UpgradeToHttpsUnderNgrok;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

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
        $schedule->call(new MarkOverdueBooks)->everySecond();
        $schedule->call(new BanUsers)->everySecond();
        $schedule->call(new SuspendUsers)->everySecond();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
