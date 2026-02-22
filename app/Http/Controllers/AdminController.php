<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Category;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    // Dashboard
    public function dashboard()
    {
        $stats = [
            'total_books' => Book::count(),
            'total_copies' => BookCopy::count(),
            'active_loans' => Loan::where('status', 'active')->count(),
            'total_users' => \App\Models\User::count(),
        ];

        $recentLoans = Loan::with(['user', 'book', 'bookCopy'])->latest()->take(10)->get();
        $overdueLoans = Loan::where('status', 'active')->where('due_date', '<', now())->get();

        return view('admin.dashboard', compact('stats', 'recentLoans', 'overdueLoans'));
    }

    // Books Management
    public function booksIndex()
    {
        $categories = Category::all();
        $query = Book::with('category', 'bookCopies');

        // Search
        if (request('search')) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . request('search') . '%')
                  ->orWhere('author', 'like', '%' . request('search') . '%')
                  ->orWhere('unique_code', 'like', '%' . request('search') . '%');
            });
        }

        // Filter by category
        if (request('category')) {
            $query->where('category_id', request('category'));
        }

        // Filter by status
        if (request('status') === 'available') {
            $query->whereHas('bookCopies', function($q) {
                $q->where('status', 'available');
            });
        } elseif (request('status') === 'borrowed') {
            $query->whereHas('bookCopies', function($q) {
                $q->where('status', 'borrowed');
            });
        }

        $books = $query->latest()->paginate(10);
        return view('admin.books.index', compact('books', 'categories'));
    }

    public function booksCreate()
    {
        $categories = Category::all();
        return view('admin.books.create', compact('categories'));
    }

    public function booksStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'isbn' => 'nullable|string|max:20',
            'publisher' => 'nullable|string|max:255',
            'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'pages' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'total_copies' => 'required|integer|min:1',
            'rating' => 'nullable|numeric|min:0|max:5',
            'is_featured' => 'nullable|boolean',
            'cover_image_type' => 'required|in:file,url',
            'cover_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image_url' => 'nullable|url|max:500',
        ]);

        // Handle cover image
        $coverImagePath = null;
        if ($request->cover_image_type === 'file' && $request->hasFile('cover_image_file')) {
            $coverImagePath = $request->file('cover_image_file')->store('book-covers', 'public');
        } elseif ($request->cover_image_type === 'url' && $request->filled('cover_image_url')) {
            $coverImagePath = $request->cover_image_url;
        }

        // Generate unique code (e.g., ABC-255)
        $uniqueCode = strtoupper(Str::random(3) . '-' . rand(100, 999));

        $book = Book::create([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'unique_code' => $uniqueCode,
            'author' => $validated['author'],
            'isbn' => $validated['isbn'] ?? null,
            'publisher' => $validated['publisher'] ?? null,
            'published_year' => $validated['published_year'] ?? null,
            'pages' => $validated['pages'] ?? null,
            'description' => $validated['description'] ?? null,
            'cover_image' => $coverImagePath,
            'total_copies' => $validated['total_copies'],
            'available_copies' => $validated['total_copies'],
            'rating' => $validated['rating'] ?? 0.0,
            'is_featured' => $validated['is_featured'] ?? false,
        ]);

        // Create book copies
        for ($i = 1; $i <= $validated['total_copies']; $i++) {
            BookCopy::create([
                'book_id' => $book->id,
                'copy_code' => $uniqueCode . '-' . $i,
                'status' => 'available',
            ]);
        }

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function booksEdit(Book $book)
    {
        $categories = Category::all();
        $book->load('bookCopies');
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function booksUpdate(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'isbn' => 'nullable|string|max:20',
            'publisher' => 'nullable|string|max:255',
            'published_year' => 'nullable|integer|min:1000|max:' . date('Y'),
            'pages' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'is_featured' => 'nullable|boolean',
            'cover_image_type' => 'nullable|in:file,url,none',
            'cover_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image_url' => 'nullable|url|max:500',
        ]);

        // Handle cover image update
        $coverImagePath = $book->cover_image;
        if ($request->filled('cover_image_type')) {
            if ($request->cover_image_type === 'file' && $request->hasFile('cover_image_file')) {
                // Delete old image if it's a stored file
                if ($book->cover_image && !str_starts_with($book->cover_image, 'http')) {
                    $oldPath = storage_path('app/public/' . $book->cover_image);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $coverImagePath = $request->file('cover_image_file')->store('book-covers', 'public');
            } elseif ($request->cover_image_type === 'url' && $request->filled('cover_image_url')) {
                $coverImagePath = $request->cover_image_url;
            } elseif ($request->cover_image_type === 'none') {
                // Delete old image if it's a stored file
                if ($book->cover_image && !str_starts_with($book->cover_image, 'http')) {
                    $oldPath = storage_path('app/public/' . $book->cover_image);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $coverImagePath = null;
            }
        }

        $book->update([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']),
            'author' => $validated['author'],
            'isbn' => $validated['isbn'] ?? null,
            'publisher' => $validated['publisher'] ?? null,
            'published_year' => $validated['published_year'] ?? null,
            'pages' => $validated['pages'] ?? null,
            'description' => $validated['description'] ?? null,
            'cover_image' => $coverImagePath,
            'rating' => $validated['rating'] ?? 0.0,
            'is_featured' => $validated['is_featured'] ?? false,
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui!');
    }

    public function booksDestroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus!');
    }

    // Add more copies to existing book
    public function booksAddCopies(Request $request, Book $book)
    {
        $request->validate([
            'copies' => 'required|integer|min:1|max:100',
        ]);

        $currentCopiesCount = $book->bookCopies()->count();
        $newCopiesCount = $request->copies;

        for ($i = 1; $i <= $newCopiesCount; $i++) {
            $copyNumber = $currentCopiesCount + $i;
            BookCopy::create([
                'book_id' => $book->id,
                'copy_code' => $book->unique_code . '-' . $copyNumber,
                'status' => 'available',
            ]);
        }

        $book->update([
            'total_copies' => $book->total_copies + $newCopiesCount,
            'available_copies' => $book->available_copies + $newCopiesCount,
        ]);

        return redirect()->route('admin.books.edit', $book)->with('success', 'Stok buku berhasil ditambahkan!');
    }

    // Loans History
    public function loansHistory()
    {
        $stats = [
            'total' => Loan::count(),
            'active' => Loan::where('status', 'active')->count(),
            'returned' => Loan::where('status', 'returned')->count(),
            'overdue' => Loan::where('status', 'active')->where('due_date', '<', now())->count(),
        ];

        $query = Loan::with(['user', 'book', 'bookCopy']);

        // Search
        if (request('search')) {
            $query->where(function($q) {
                $q->whereHas('book', function($bookQ) {
                    $bookQ->where('title', 'like', '%' . request('search') . '%');
                })->orWhereHas('user', function($userQ) {
                    $userQ->where('name', 'like', '%' . request('search') . '%');
                });
            });
        }

        // Filter by status
        if (request('status') === 'active') {
            $query->where('status', 'active');
        } elseif (request('status') === 'returned') {
            $query->where('status', 'returned');
        } elseif (request('status') === 'overdue') {
            $query->where('status', 'active')->where('due_date', '<', now());
        }

        // Sort
        if (request('sort') === 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        $loans = $query->paginate(20);
        return view('admin.loans.index', compact('loans', 'stats'));
    }

    // Return book (admin)
    public function loansReturn(Loan $loan)
    {
        $loan->update([
            'status' => 'returned',
            'return_date' => now(),
        ]);

        // Update book copy status
        $loan->bookCopy->update([
            'status' => 'available',
        ]);

        // Update book available copies
        $loan->book->increment('available_copies');

        return redirect()->route('admin.loans.index')->with('success', 'Buku berhasil ditandai sebagai dikembalikan!');
    }
}
