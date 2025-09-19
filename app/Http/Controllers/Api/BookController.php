<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Enums\Book as BookStatus;
use App\Models\BookUser;
use App\Enums\BookUser as BookUserStatus;
use App\Http\Requests\Api\ReturnBookRequest;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;

class BookController extends Controller
{
    use ApiResponses;
    public function index()
    {
        $books = Book::select('id', 'title')->get();

        return $this->success($books, 'All books retrieved');
    }

    public function show(Book $book)
    {
        return $this->success($book, $book->title.' retrieved');
    }

    public function borrow(Request $request, Book $book)
    {
        $user = $request->user();

        //Check for fines
        $hasFines = BookUser::where('user_id', $user->id)
            ->whereIn('status', [BookUserStatus::BORROWED, BookUserStatus::OVERDUE])
            ->get()
            ->contains(fn ($bookUser) => $bookUser->getFineAttribute() > 0);

        if ($hasFines) {
            return $this->error('You have an outstanding fine. Return overdue books and pay fines before borrowing again.', 403);
        }

        //Check book availability
        if($book->status === BookStatus::UNAVAILABLE)
        {
            return $this->error('Book is not available', 409);
        }

        //Check active borrows count
        $activeBorrows = BookUser::where('user_id', $user->id)
            ->whereIn('status', ['borrowed', 'overdued'])
            ->count();

        if ($activeBorrows >= 3) {
            return $this->error('You cannot borrow more than 3 books at a time.', 403);
        }

        //borrow
        $bookUser = BookUser::create([
            'user_id'   => $user->id,
            'book_id'   => $book->id,
            'borrow_at' => now(),
            'due_at'    => now()->addDays(7),
            'status'    => 'borrowed',
        ]);

        return $this->success($bookUser, $book->title.' has been borrowed by '.$user->name);
    }

    public function return(ReturnBookRequest $request, Book $book) {
        $user = $request->user();

        //fetch borrowed book
        $bookUser = BookUser::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->whereIn('status', [BookUserStatus::BORROWED, BookUserStatus::OVERDUE])
            ->first();

        if (!$bookUser) {
            return $this->error('You have not borrowed this book', 404);
        }

        //Check fine
        $fine = $bookUser->getFineAttribute();

        if($fine > 0 && !$request->boolean('fine_paid')) {
            return $this->error('You must acknowledge and pay the fine (PKR '.$fine.') before returning this book.', 403);
        }

        //Return
        $bookUser->update([
        'status'    => BookUserStatus::RETURNED,
        ]);

        return $this->success($bookUser, $book->title.' returned by '.$user->name);
    }
}