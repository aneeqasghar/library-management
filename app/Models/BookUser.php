<?php

namespace App\Models;

use App\Enums\Book as BookStatus;
use App\Models\Book;
use App\Enums\BookUser as BookUserStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class BookUser extends Model
{
    /** @use HasFactory<\Database\Factories\BookUserFactory> */
    use HasFactory;


    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'book_id',
        'borrow_at',
        'due_at',
        'return_at',
        'status',
    ];

    protected $casts = [
        'status' => BookUserStatus::class,
        'borrow_at' => 'datetime',
        'due_at' => 'datetime',
        'return_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    protected static function booted()
    {
        static::creating(function ($bookUser) {
            $bookUser->status = BookUserStatus::BORROWED;
            $bookUser->book->update(['status' => BookStatus::UNAVAILABLE]);
        });

        static::updating(function ($bookUser) {
            // Use isDirty() to check if the 'status' attribute is actually being changed
            if ($bookUser->isDirty('status')) {
                // Check the *new* value of the status
                if ($bookUser->status === BookUserStatus::RETURNED) {
                    $bookUser->return_at = now();
                    $bookUser->book->update(['status' => BookStatus::AVAILABLE]);
                } 
                // elseif ($bookUser->status === BookUserStatus::BORROWED) {
                //     $bookUser->book->update(['status' => BookStatus::UNAVAILABLE]);
                // }
            }
        });
    }

    public function getFineAttribute()
        {
            $today = Carbon::today();
            $returnDate = Carbon::parse($this->due_at);

            if ($today <= $returnDate) {
                return 0;
            }

            if($this->status !== BookUserStatus::OVERDUE) {$this->update(['status' => BookUserStatus::OVERDUE]);}

            $overdueDays = $returnDate->diffInDays($today);

            $pricing = Pricing::all();

            $row = $pricing->first(function ($p) use ($overdueDays) {
                if($overdueDays >= $p->min_day && $overdueDays <= $p->max_day)
                    return true;

            });

            if (!$row) {
                $row = $pricing->last();
                $this->user->update(['status' => 'banned']);
            }

            return $row ? $row->amount : 0;
        }
}
