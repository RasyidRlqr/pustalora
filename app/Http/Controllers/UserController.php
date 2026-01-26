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

        // Find the next available copy number
        $loanedCopies = Loan::where('book_id', $book->id)
                           ->whereNull('returned_at')
                           ->pluck('copy_number')
                           ->toArray();

        $copyNumber = 1;
        while (in_array($copyNumber, $loanedCopies)) {
            $copyNumber++;
        }

        // Create loan record
        $loan = Loan::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'copy_number' => $copyNumber,
            'borrowed_at' => now(),
        ]);

        // Debug: Check if loan was created
        // dd('Loan created:', $loan);

        // Decrement available quantity
        $book->decrement('available_quantity');

        // Verify the loan was created
        if ($loan) {
            return redirect()->back()->with('success', "Buku berhasil dipinjam (Copy #{$copyNumber})");
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