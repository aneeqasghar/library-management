<?php

namespace App\Jobs;

use App\Mail\BookUploaded;
use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class ProcessBooks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $file;
    public ?string $recipientEmail;

    public function __construct(string $file, ?string $recipientEmail = null)
    {
        $this->file = $file;
        $this->recipientEmail = $recipientEmail;
    }

    public function handle()
    {
        // Create book record directly
        $book = Book::create([
            'title' => 'N/A',
            'author' => 'N/A',
            'genre' => 'N/A',
            'pdf_file' => $this->file,
            'status' => 'available',
            'uploaded_at' => now(),
        ]);
        if ($this->recipientEmail) {
            // Queue the mailable on the same queue as this job to ensure the running worker picks it up
            Mail::to($this->recipientEmail)->queue((new BookUploaded($book)));
        }
    }
}
