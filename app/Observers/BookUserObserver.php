<?php

namespace App\Observers;

use App\Models\BookUser;
use App\Enums\Book as BookStatus;
use App\Enums\BookUser as BookUserStatus;

class BookUserObserver
{
    public function creating(BookUser $bookUser)
    {
        $bookUser->status = BookUserStatus::BORROWED;
        $bookUser->book->update(['status' => BookStatus::UNAVAILABLE]);
    }
    /**
     * Handle the BookUser "created" event.
     */
    public function created(BookUser $bookUser): void
    {
        //
    }

    /**
     * Handle the BookUser "updated" event.
     */
    public function updated(BookUser $bookUser): void
    {
        //
    }

    public function updating(BookUser $bookUser): void
    {
        if ($bookUser->isDirty('status')) {
            if ($bookUser->status === BookUserStatus::RETURNED) {
                $bookUser->return_at = now();
                $bookUser->book->update(['status' => BookStatus::AVAILABLE]);
            } elseif ($bookUser->status === BookUserStatus::BORROWED) {
                $bookUser->book->update(['status' => BookStatus::UNAVAILABLE]);
            }
        }
    }

    /**
     * Handle the BookUser "deleted" event.
     */
    public function deleted(BookUser $bookUser): void
    {
        //
    }

    /**
     * Handle the BookUser "restored" event.
     */
    public function restored(BookUser $bookUser): void
    {
        //
    }

    /**
     * Handle the BookUser "force deleted" event.
     */
    public function forceDeleted(BookUser $bookUser): void
    {
        //
    }
}
