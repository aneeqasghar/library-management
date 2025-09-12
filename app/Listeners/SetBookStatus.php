<?php

namespace App\Listeners;

use App\Events\BookCreating;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Enums\Book as BookStatus;

class SetBookStatus
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
        $event->book->status = BookStatus::AVAILABLE;
    }
}
