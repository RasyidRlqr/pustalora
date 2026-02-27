<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::where('user_id', Auth::id())
            ->with('book', 'bookCopy')
            ->latest()
            ->paginate(10);

        return view('loans.index', compact('loans'));
    }

    public function create(Book $book)
    {
        // Check if user profile is complete
        if (!Auth::user()->isProfileComplete()) {
            return redirect()->route('profile.edit')->with('warning', 'Silakan lengkapi profil Anda (alamat dan nomor HP) terlebih dahulu untuk meminjam buku.');
        }

        $availableCopies = $book->bookCopies()->where('status', 'available')->get();

        if ($availableCopies->isEmpty()) {
            return redirect()->back()->with('error', 'Buku ini tidak tersedia untuk dipinjam.');
        }

        return view('loans.create', compact('book', 'availableCopies'));
    }

    public function store(Request $request, Book $book)
    {
        // Check if user profile is complete
        if (!Auth::user()->isProfileComplete()) {
            return redirect()->route('profile.edit')->with('warning', 'Silakan lengkapi profil Anda (alamat dan nomor HP) terlebih dahulu untuk meminjam buku.');
        }

        $request->validate([
            'book_copy_id' => 'required|exists:book_copies,id',
            'loan_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string|max:500',
        ]);

        $bookCopy = BookCopy::find($request->book_copy_id);

        if (!$bookCopy) {
            return redirect()->back()->with('error', 'Eksemplar buku tidak ditemukan.');
        }
        
        if ($bookCopy->book_id != $book->id) {
            return redirect()->back()->with('error', 'Eksemplar tidak cocok dengan buku yang dipilih.');
        }
        
        if (!$bookCopy->isAvailable()) {
            return redirect()->back()->with('error', 'Eksemplar buku sudah dipinjam.');
        }

        $loanDate = \Carbon\Carbon::parse($request->loan_date);
        $dueDate = $loanDate->copy()->addDays(14);

        $loan = Loan::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'book_copy_id' => $bookCopy->id,
            'loan_date' => $loanDate,
            'due_date' => $dueDate,
            'status' => 'active',
            'notes' => $request->notes,
        ]);

        // Update book copy status
        $bookCopy->update(['status' => 'borrowed']);

        // Update book available copies
        $book->decrement('available_copies');

        return redirect()->route('loans.index')->with('success', 'Peminjaman berhasil dibuat!');
    }

    public function return(Loan $loan)
    {
        if ((int) $loan->user_id !== (int) Auth::id()) {
        abort(403);
    }

        if ($loan->status !== 'active') {
            return redirect()->back()->with('error', 'Peminjaman ini sudah dikembalikan.');
        }

        $returnDate = now();
        $dueDate = \Carbon\Carbon::parse($loan->due_date);
        
        // Calculate days overdue correctly
        $daysOverdue = 0;
        if ($returnDate->gt($dueDate)) {
            $daysOverdue = $returnDate->diffInDays($dueDate);
        }

        // Calculate fine if overdue (Rp 1,000 per 3 days)
        $fineAmount = 0;
        if ($daysOverdue > 0) {
            $fineAmount = ceil($daysOverdue / 3) * 1000;
        }

        $loan->update([
            'return_date' => $returnDate,
            'status' => 'returned',
            'fine_amount' => $fineAmount,
            'fine_paid' => false,
        ]);

        // Update book copy status
        if ($loan->bookCopy) {
            $loan->bookCopy->update(['status' => 'available']);
        }

        // Update book available copies
        $loan->book->increment('available_copies');

        // Build success message
        if ($fineAmount > 0) {
            return redirect()->route('loans.index')->with('warning', 'Buku berhasil dikembalikan! Denda keterlambatan: Rp ' . number_format($fineAmount, 0, ',', '.') . ' (' . $daysOverdue . ' hari keterlambatan). Silakan hubungi admin untuk membayar denda.');
        }

        return redirect()->route('loans.index')->with('success', 'Buku berhasil dikembalikan!');
    }
}
