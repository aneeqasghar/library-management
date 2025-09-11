<?php

namespace App\Jobs;

use App\Events\BookCreated;
use App\Events\BookCreating;
use App\Mail\BookUploaded;
use App\Models\Book;
use App\Models\User;
use App\Notifications\BookUploadedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Mail;

class ProcessBooks implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public string $file;
    public User $user;

    public function __construct(string $file, int $userId)
    {
        $this->file = $file;
        $this->user = User::find($userId);
    }

    public function handle()
    {
        $book = Model::withoutEvents(function () {
            return Book::create([
                'title' => 'N/A',
                'author' => 'N/A',
                'genre' => 'N/A',
                'pdf_file' => $this->file,
                'status' => 'available',
                'uploaded_at' => now(),
            ]);
        });
        event(new BookCreating($book));
        event(new BookCreated($book, $this->user));
    }
}
