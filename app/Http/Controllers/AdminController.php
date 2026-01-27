<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $books = Book::all();
        $loans = Loan::with('user', 'book')->get();
        return view('admin.dashboard', compact('books', 'loans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:255|unique:books',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantity' => 'required|integer|min:1',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('books', 'public');
        }

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'isbn' => $request->isbn,
            'image' => $imagePath,
            'quantity' => $request->quantity,
            'available_quantity' => $request->quantity, // All copies are available initially
        ]);

        return redirect()->back()->with('success', 'Buku berhasil ditambahkan');
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:255|unique:books,isbn,' . $book->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantity' => 'required|integer|min:1',
        ]);

        $currentAvailable = $book->available_quantity;
        $newQuantity = $request->quantity;
        $loanedCopies = $book->quantity - $book->available_quantity;

        // Ensure new quantity is not less than currently loaned copies
        if ($newQuantity < $loanedCopies) {
            return redirect()->back()->with('error', 'Jumlah buku tidak boleh kurang dari buku yang sedang dipinjam (' . $loanedCopies . ' buku)');
        }

        $imagePath = $book->image; // Keep existing image
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($book->image && Storage::disk('public')->exists($book->image)) {
                Storage::disk('public')->delete($book->image);
            }
            $imagePath = $request->file('image')->store('books', 'public');
        }

        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'isbn' => $request->isbn,
            'image' => $imagePath,
            'quantity' => $newQuantity,
            'available_quantity' => $newQuantity - $loanedCopies,
        ]);

        return redirect()->back()->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->back()->with('success', 'Buku berhasil dihapus');
    }
}