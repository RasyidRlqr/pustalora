<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $books = Book::where('available', true)->get();
        $userLoans = Loan::where('user_id', Auth::id())->with('book')->get();
        return view('dashboard', compact('books', 'userLoans'));
    }

    public function borrow(Book $book)
    {
        if (!$book->available) {
            return redirect()->back()->with('error', 'Buku tidak tersedia');
        }

        Loan::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'borrowed_at' => now(),
        ]);

        $book->update(['available' => false]);

        return redirect()->back()->with('success', 'Buku berhasil dipinjam');
    }

    public function returnBook(Loan $loan)
    {
        if ($loan->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Akses ditolak');
        }

        $loan->update(['returned_at' => now()]);
        $loan->book->update(['available' => true]);

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan');
    }
}