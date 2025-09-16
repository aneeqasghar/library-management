<?php

namespace App\Listeners;

use App\Events\UserSoftDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Enums\User as UserStatus;

class SetUserSuspendedStatus
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
    public function handle(UserSoftDeleted $event): void
    {
        $event->user->status = UserStatus::SUSPENDED;
        $event->user->saveQuietly();
    }
}
