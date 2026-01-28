<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard(Request $request)
    {
        $search = $request->get('search');
        $query = Book::where('available_quantity', '>', 0);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('author', 'like', '%' . $search . '%')
                  ->orWhere('isbn', 'like', '%' . $search . '%');
            });
        }

        $books = $query->get();
        $userLoans = Loan::where('user_id', Auth::id())->with('book')->orderBy('created_at', 'desc')->get();

        // Debug: Check if loans exist
        // dd($userLoans);

        return view('dashboard', compact('books', 'userLoans', 'search'));
    }

    public function borrow(Book $book)
    {
        // Check if profile is complete
        if (!Auth::user()->isProfileComplete()) {
            return redirect()->route('profile.edit')->with('error', 'Lengkapi profil Anda (NIK, Telepon, Alamat) sebelum meminjam buku');
        }

        if (!$book->isAvailable()) {
            return redirect()->back()->with('error', 'Buku tidak tersedia');
        }

        // Check if user already has an active loan for this book
        $existingLoan = Loan::where('user_id', Auth::id())
                            ->where('book_id', $book->id)
                            ->whereNull('returned_at')
                            ->first();
        if ($existingLoan) {
            return redirect()->back()->with('error', 'Anda sudah meminjam buku ini dan belum mengembalikannya');
        }

        // Generate unique random loan code
        do {
            $loanCode = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
        } while (Loan::where('loan_code', $loanCode)->exists());

        // Create loan record
        $loan = Loan::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'loan_code' => $loanCode,
            'borrowed_at' => now(),
        ]);

        // Decrement available quantity
        $book->decrement('available_quantity');

        // Verify the loan was created
        if ($loan) {
            return redirect()->back()->with('success', "Buku berhasil dipinjam (Kode Pinjam: {$loanCode})");
        } else {
            return redirect()->back()->with('error', 'Gagal meminjam buku');
        }
    }

    public function returnBook(Loan $loan)
    {
        if ($loan->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Akses ditolak');
        }

        $loan->update(['returned_at' => now()]);
        $loan->book->increment('available_quantity');

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan');
    }
}