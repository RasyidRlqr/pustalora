<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User routes
    Route::post('/books/{book}/borrow', [UserController::class, 'borrow'])->name('books.borrow');
    Route::post('/loans/{loan}/return', [UserController::class, 'returnBook'])->name('loans.return');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/books', [AdminController::class, 'store'])->name('admin.books.store');
    Route::patch('/books/{book}', [AdminController::class, 'update'])->name('admin.books.update');
    Route::delete('/books/{book}', [AdminController::class, 'destroy'])->name('admin.books.destroy');
});

require __DIR__.'/auth.php';
