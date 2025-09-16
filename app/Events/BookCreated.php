<?php

namespace App\Events;

use App\Models\Admin;
use App\Models\Book;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookCreated
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public Book $book;
    public ?Admin $user;

    public function __construct(Book $book, ?Admin $user = null)
    {
        $this->book = $book;
        $this->user = $user;
    }
}
