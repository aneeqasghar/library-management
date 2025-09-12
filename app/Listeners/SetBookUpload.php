<?php

namespace App\Listeners;

use App\Events\BookCreating;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetBookUpload
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
    public function handle(BookCreating $event): void
    {
        $event->book->uploaded_at = now();
    }
}
