<?php

namespace App\Models;

use App\Enums\Book as BookStatus;
use App\Mail\BookUploaded;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Book extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($book) {
            $book->uploaded_at = now();
            $book->status = BookStatus::AVAILABLE;
        });

        static::created(function ($book) {
        $user = Auth::user();
        if ($user) { 
            Mail::to($user->email)->queue(new BookUploaded($book));
        }
        });
    }

    protected function casts(): array
    {
        return [
            'uploaded_at' => 'datetime',
            'status' => BookStatus::class,
        ];
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'book_user')
                    ->withPivot(['borrow_at', 'due_at', 'return_at', 'status']);
    }
}
