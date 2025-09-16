<?php

namespace App\Listeners;

use App\Events\UserRestored;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Enums\User as UserStatus;

class RestoreUserActiveStatus
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRestored $event): void
    {
        $event->user->status = UserStatus::ACTIVE;
        $event->user->saveQuietly();
    }
}
