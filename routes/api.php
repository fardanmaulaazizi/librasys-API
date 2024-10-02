<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/login', function () {
    return response()->json([
        'status' => false,
        'message' => 'Access not allowed'
    ]);
})->name('login');


Route::post('/login', [AuthController::class, 'login']);
Route::get('/books', [BookController::class, 'index']);

Route::middleware(['auth:sanctum', 'ability:manage-applications'])->group(function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::get('/users', [UserController::class, 'index']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);

    Route::post('/books', [BookController::class, 'store']);
    Route::put('/books/{book}', [BookController::class, 'update']);
    Route::delete('/books/{book}', [BookController::class, 'destroy']);

    Route::get('/borrowings', [BorrowingController::class, 'index']);
    Route::post('/borrowings', [BorrowingController::class, 'store']);
    Route::delete('/borrowings/{borrowing}', [BorrowingController::class, 'destroy']);
    Route::put('/borrowings/{borrowing}', [BorrowingController::class, 'update']);
    Route::get('/borrowings/user/{user}', [BorrowingController::class, 'user']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    // Menggambil data buku yang dipinjam pribadi
});

Route::resource('/users', UserController::class);
