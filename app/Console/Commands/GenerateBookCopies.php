<?php

namespace App\Console\Commands;

use App\Models\Book;
use App\Models\BookCopy;
use Illuminate\Console\Command;

class GenerateBookCopies extends Command
{
    protected $signature = 'books:generate-copies {--count=1 : Number of copies per book}';
    protected $description = 'Generate book copies for books that do not have any';

    public function handle()
    {
        $count = (int) $this->option('count');
        
        $books = Book::all();
        $created = 0;
        
        foreach ($books as $book) {
            $existingCopies = $book->bookCopies()->count();
            
            if ($existingCopies == 0) {
                for ($i = 1; $i <= $count; $i++) {
                    BookCopy::create([
                        'book_id' => $book->id,
                        'copy_code' => $book->unique_code . '-' . $i,
                        'status' => 'available',
                    ]);
                    $created++;
                }
                
                $book->update([
                    'total_copies' => $count,
                    'available_copies' => $count,
                ]);
                
                $this->info("Created {$count} copies for: {$book->title}");
            } else {
                $this->line("Skipping {$book->title} (already has {$existingCopies} copies)");
            }
        }
        
        $this->info("Done! Created {$created} book copies total.");
        
        return 0;
    }
}
