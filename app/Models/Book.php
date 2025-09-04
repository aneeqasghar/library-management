<?php

namespace App\Models;

use App\Enums\Book as BookStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

     protected $guarded = [];

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
