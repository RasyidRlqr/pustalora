<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@pustalora.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]); 

        // Create regular user
        User::create([
            'name' => 'User',
            'email' => 'user@pustalora.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create sample books with quantities
        Book::create([
            'title' => 'Harry Potter and the Sorcerer\'s Stone',
            'author' => 'J.K. Rowling',
            'isbn' => '9780439708180',
            'quantity' => 5,
            'available_quantity' => 5,
        ]);

        Book::create([
            'title' => 'To Kill a Mockingbird',
            'author' => 'Harper Lee',
            'isbn' => '9780061120084',
            'quantity' => 3,
            'available_quantity' => 3,
        ]);

        Book::create([
            'title' => '1984',
            'author' => 'George Orwell',
            'isbn' => '9780451524935',
            'quantity' => 4,
            'available_quantity' => 4,
        ]);

        Book::create([
            'title' => 'The Great Gatsby',
            'author' => 'F. Scott Fitzgerald',
            'isbn' => '9780743273565',
            'quantity' => 6,
            'available_quantity' => 6,
        ]);

        Book::create([
            'title' => 'Pride and Prejudice',
            'author' => 'Jane Austen',
            'isbn' => '9780141439518',
            'quantity' => 4,
            'available_quantity' => 4,
        ]);

        Book::create([
            'title' => 'The Catcher in the Rye',
            'author' => 'J.D. Salinger',
            'isbn' => '9780316769488',
            'quantity' => 3,
            'available_quantity' => 3,
        ]);

        Book::create([
            'title' => 'Lord of the Flies',
            'author' => 'William Golding',
            'isbn' => '9780399501487',
            'quantity' => 5,
            'available_quantity' => 5,
        ]);

        Book::create([
            'title' => 'Animal Farm',
            'author' => 'George Orwell',
            'isbn' => '9780451526342',
            'quantity' => 4,
            'available_quantity' => 4,
        ]);

        Book::create([
            'title' => 'Brave New World',
            'author' => 'Aldous Huxley',
            'isbn' => '9780060850524',
            'quantity' => 3,
            'available_quantity' => 3,
        ]);

        Book::create([
            'title' => 'The Hobbit',
            'author' => 'J.R.R. Tolkien',
            'isbn' => '9780547928227',
            'quantity' => 5,
            'available_quantity' => 5,
        ]);
    }
}
