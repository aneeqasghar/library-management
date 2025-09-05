<?php

namespace App\Models;

use App\Enums\BookUser as BookUserStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookUser extends Model
{
    /** @use HasFactory<\Database\Factories\BookUserFactory> */
    use HasFactory;

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

}
