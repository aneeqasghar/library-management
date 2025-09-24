<?php

namespace App\Models;

use App\Enums\Book as BookStatus;
use App\Events\BookCreated;
use App\Events\BookCreating;
use App\Mail\BookUploaded;
use App\Observers\BookObserver;
use App\Policies\BookPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Event;

#[UsePolicy(BookPolicy::class)]
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
            $admin = Filament::auth()->user();
            if ($admin) {
                event(new BookCreated($book, $admin));
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
        return $this->belongsToMany(User::class, 'book_users')
                    ->withPivot(['borrow_at', 'due_at', 'return_at', 'status']);
    }
}
