<?php

namespace App\Providers;

use App\Events\BookCreated;
use App\Events\BookCreating;
use App\Listeners\SendBookEmail;
use App\Listeners\SetBookStatus;
use App\Listeners\SetBookUpload;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(BookCreated::class, SendBookEmail::class);
        Event::listen(BookCreating::class, SetBookUpload::class);
        Event::listen(BookCreating::class, SetBookStatus::class);
    }
}
