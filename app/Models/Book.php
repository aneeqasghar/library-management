<?php

namespace App\Models;

use App\Enums\Book as BookStatus;
use App\Events\BookCreated;
use App\Events\BookCreating;
use App\Mail\BookUploaded;
use App\Observers\BookObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;

class Book extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($book) {
            event(new BookCreating($book));
        });

        static::created(function ($book) {
            event(new BookCreated($book, Auth::user()));
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
