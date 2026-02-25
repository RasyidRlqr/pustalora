<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestFineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clean up old test loans first
        $testUser = User::where('email', 'test@fine.com')->first();
        if ($testUser) {
            // Get book copies used by test user and reset them
            $loans = Loan::where('user_id', $testUser->id)->get();
            foreach ($loans as $loan) {
                if ($loan->bookCopy) {
                    $loan->bookCopy->update(['status' => 'available']);
                }
                if ($loan->book) {
                    $loan->book->increment('available_copies');
                }
            }
            // Delete old test loans
            Loan::where('user_id', $testUser->id)->delete();
        }

        // Get or create a regular user for testing
        $user = User::firstOrCreate(
            ['email' => 'test@fine.com'],
            [
                'name' => 'Test User Fine',
                'password' => bcrypt('password'),
                'role' => 'user',
                'member_code' => 'PST' . date('Y') . '9999',
                'phone' => '081234567890',
                'address' => 'Jl. Test No. 123, Jakarta',
            ]
        );

        // Get first 3 available books
        $books = Book::take(3)->get();
        
        if ($books->count() < 3) {
            $this->command->info('Need at least 3 books. Please create more books first.');
            return;
        }

        // Get available copies for each book
        $copies = [];
        foreach ($books as $book) {
            $copy = BookCopy::where('book_id', $book->id)->where('status', 'available')->first();
            if ($copy) {
                $copies[] = ['book' => $book, 'copy' => $copy];
            }
        }

        if (count($copies) < 3) {
            $this->command->info('Need at least 3 available book copies.');
            return;
        }

        // Create 3 test loans:
        // 1. Active loan - 7 days overdue (ceil(7/3) = 3 * 1000 = 3000)
        $copy1 = $copies[0];
        $copy1['copy']->update(['status' => 'borrowed']);
        $copy1['book']->decrement('available_copies');
        
        Loan::create([
            'user_id' => $user->id,
            'book_id' => $copy1['book']->id,
            'book_copy_id' => $copy1['copy']->id,
            'loan_date' => now()->subDays(21),      // 21 days ago
            'due_date' => now()->subDays(7),       // 7 days ago (14 days loan period)
            'return_date' => null,
            'status' => 'active',
            'notes' => 'Test: Aktif terlambat 7 hari → Rp 3.000',
            'fine_amount' => 0,
            'fine_paid' => false,
        ]);

        // 2. Returned loan with unpaid fine - 4 days overdue (ceil(4/3) = 2 * 1000 = 2000)
        $copy2 = $copies[1];
        $copy2['copy']->update(['status' => 'available']);
        
        Loan::create([
            'user_id' => $user->id,
            'book_id' => $copy2['book']->id,
            'book_copy_id' => $copy2['copy']->id,
            'loan_date' => now()->subDays(18),
            'due_date' => now()->subDays(4),       // 4 days ago
            'return_date' => now()->subDays(1),    // Returned 1 day ago = 3 days overdue
            'status' => 'returned',
            'notes' => 'Test: Dikembalikan terlambat 3 hari → Rp 1.000 (belum lunas)',
            'fine_amount' => 1000,  // ceil(3/3) * 1000 = 1000
            'fine_paid' => false,
        ]);

        // 3. Returned loan with paid fine - 10 days overdue (ceil(10/3) = 4 * 1000 = 4000)
        $copy3 = $copies[2];
        $copy3['copy']->update(['status' => 'available']);
        
        Loan::create([
            'user_id' => $user->id,
            'book_id' => $copy3['book']->id,
            'book_copy_id' => $copy3['copy']->id,
            'loan_date' => now()->subDays(24),
            'due_date' => now()->subDays(10),      // 10 days ago
            'return_date' => now()->subDays(7),    // Returned 7 days after due = 3 days overdue
            'status' => 'returned',
            'notes' => 'Test: Dikembalikan terlambat 3 hari → Rp 1.000 (sudah lunas)',
            'fine_amount' => 1000,  // ceil(3/3) * 1000 = 1000
            'fine_paid' => true,
        ]);

        $this->command->info('Test fine loans created successfully!');
        $this->command->info('- Test user: test@fine.com / password');
        $this->command->info('- Loan 1: Aktif, 7 hari terlambat → Est. Rp 3.000');
        $this->command->info('- Loan 2: Dikembalikan, 3 hari terlambat → Rp 1.000 (belum lunas)');
        $this->command->info('- Loan 3: Dikembalikan, 3 hari terlambat → Rp 1.000 (sudah lunas)');
    }
}
