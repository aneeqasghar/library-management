<?php

namespace App\Listeners;

use App\Events\BookCreated;
use App\Mail\BookUploaded;
use App\Notifications\BookUploadedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class SendBookEmail
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
    public function handle(BookCreated $event): void
    {
        //Mail::to($event->user->email)->send(new BookUploaded($event->book));
        Notification::send($event->user, new BookUploadedNotification($event->book));
    }
}
