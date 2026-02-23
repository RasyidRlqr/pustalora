<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('buku')->name('books.')->group(function () {
    Route::get('/', [BookController::class, 'index'])->name('index');
    Route::get('/{book}', [BookController::class, 'show'])->name('show');
});

Route::middleware('auth')->group(function () {
    Route::prefix('peminjaman')->name('loans.')->group(function () {
        Route::get('/', [LoanController::class, 'index'])->name('index');
        Route::get('/create/{book}', [LoanController::class, 'create'])->name('create');
        Route::post('/{book}', [LoanController::class, 'store'])->name('store');
        Route::post('/{loan}/return', [LoanController::class, 'return'])->name('return');
    });

    Route::get('/profile', action: [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        // Books Management
        Route::prefix('buku')->name('books.')->group(function () {
            Route::get('/', [AdminController::class, 'booksIndex'])->name('index');
            Route::get('/create', [AdminController::class, 'booksCreate'])->name('create');
            Route::post('/', [AdminController::class, 'booksStore'])->name('store');
            Route::get('/{book}/edit', [AdminController::class, 'booksEdit'])->name('edit');
            Route::put('/{book}', [AdminController::class, 'booksUpdate'])->name('update');
            Route::delete('/{book}', [AdminController::class, 'booksDestroy'])->name('destroy');
            Route::post('/{book}/add-copies', [AdminController::class, 'booksAddCopies'])->name('add-copies');
        });

        // Loans Management
        Route::prefix('peminjaman')->name('loans.')->group(function () {
            Route::get('/', [AdminController::class, 'loansHistory'])->name('index');
            Route::post('/{loan}/return', [AdminController::class, 'loansReturn'])->name('return');
        });
    });
});

require __DIR__.'/auth.php';
