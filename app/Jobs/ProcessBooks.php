<?php

namespace App\Jobs;

use App\Events\BookCreated;
use App\Events\BookCreating;
use App\Mail\BookUploaded;
use App\Models\Book;
use App\Models\Admin;
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
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $file;
    public int $userId;

    public function __construct(string $file, int $userId)
    {
        $this->file = $file;
        $this->userId = $userId;
    }

    public function handle()
    {
        $admin = Admin::find($this->userId);

        $book = Book::create([
            'title' => 'N/A',
            'author' => 'N/A',
            'genre' => 'N/A',
            'pdf_file' => $this->file,
        ]);

        // fire events with admin safely
        // event(new BookCreating($book));
        event(new BookCreated($book, $admin));
    }
}
