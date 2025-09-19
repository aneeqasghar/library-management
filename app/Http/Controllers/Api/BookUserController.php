<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookUser;
use App\Traits\ApiResponses;

class BookUserController extends Controller
{
    use ApiResponses;

    public function index(Request $request) {
        $user = $request->user();

        $borrowedBooks = BookUser::with('book:id,title')
            ->where('user_id', $user->id)
            ->get()
            ->map(function ($bookUser) {
                return [
                    'id'    => $bookUser->id,
                    'title' => $bookUser->book->title,
                    'status' => $bookUser->status->value
                ];
            });
        
        return $this->success($borrowedBooks, 'These are the books borrwed by '.$user->name);
    }

    public function show(Request $request, BookUser $bookUser) {
        if ($bookUser->user_id !== $request->user()->id) {
            return $this->error('Unauthorized access to this borrow record.', 403);
        }

        $bookUser->load('book:id,title');
        
        return $this->success($bookUser);   
    }
}
