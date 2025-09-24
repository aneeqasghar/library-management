<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return response()->json([
        'message' => 'Go to Postman',
        "info" => [
            "name" => "Library API Collection",
            "_postman_id" => "https://app.getpostman.com/join-team?invite_code=3bb1bcef3827c8492056ca97681bc4b8d4417147e871f0ecc015c1af4a2150c5&target_code=fc345a96dfe06d2347896c5a8455e0ae",
            "description" => "Postman collection for Auth, User, Books, and Book-Users APIs",
    ],
        'resources' => [
            'Auth' => [
                '/api/v1/auth/register' => 'Register User',
                '/api/v1/auth/login'    => 'Login User',
                '/api/v1/auth/logout'   => 'Logout User',
            ],
            'User' => [
                '/api/v1/user'          => 'Get User Profile',
                '/api/v1/user (POST)'   => 'Update User Profile',
                '/api/v1/user (DELETE)' => 'Delete User Account',
            ],
            'Books' => [
                '/api/v1/books'                => 'List All Books',
                '/api/v1/books/{book}'         => 'Show Book Details',
                '/api/v1/books/{book}/borrow'  => 'Borrow Book',
                '/api/v1/books/{book}/return'  => 'Return Book',
            ],
            'Book-User' => [
            '/api/v1/book-users'              => 'List All Borrow Records',
            '/api/v1/book-users/{bookUser}'   => 'Show Borrow Record Details',
            ]
        ]

    ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
});

Route::prefix('v1')->group(base_path('routes/api.v1.php'));