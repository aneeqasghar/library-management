<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;
use App\Enums\Role as RoleName;
use Illuminate\Auth\Access\Response;

class BookPolicy
{
    public function borrow(User $user, Book $book)
    {
        return $user->roles()->where('name', RoleName::MEMBER)->exists();
    }

    public function return(User $user, Book $book)
    {
        return $user->roles()->where('name', RoleName::MEMBER)->exists();
    }
}
