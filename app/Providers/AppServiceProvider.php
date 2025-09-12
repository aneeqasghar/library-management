<?php

namespace App\Providers;

use App\Events\BookCreated;
use App\Events\BookCreating;
use App\Events\UserRestored;
use App\Events\UserSoftDeleted;
use App\Listeners\RestoreUserActiveStatus;
use App\Listeners\SendBookEmail;
use App\Listeners\SetBookStatus;
use App\Listeners\SetBookUpload;
use App\Listeners\SetUserSuspendedStatus;
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
        Event::listen(UserSoftDeleted::class, SetUserSuspendedStatus::class);
        Event::listen(UserRestored::class, RestoreUserActiveStatus::class);
    }
}
