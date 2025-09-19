<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\BookUserController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return response()->json([
        'message' => 'Hello World!'
    ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
});

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::delete('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->controller(UserController::class)->group(function () {
    Route::get('/user', 'show');
    Route::post('/user', 'update');
    Route::delete('/user', 'destroy');
});

Route::middleware('auth:sanctum')->controller(BookController::class)->group(function () {
    Route::get('/books', 'index');
    Route::get('/books/{book}', 'show');
    Route::post('/books/{book}/borrow', 'borrow');
    Route::post('/books/{book}/return', 'return');
});

Route::middleware('auth:sanctum')->controller(BookUserController::class)->group(function () {
    Route::get('/book-users', 'index');
    Route::get('/book-users/{bookUser}', 'show');
});
