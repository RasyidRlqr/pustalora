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

        // Create sample books
        Book::create([
            'title' => 'Harry Potter and the Sorcerer\'s Stone',
            'author' => 'J.K. Rowling',
            'isbn' => '978-0439708180',
            'available' => true,
        ]);

        Book::create([
            'title' => 'To Kill a Mockingbird',
            'author' => 'Harper Lee',
            'isbn' => '978-0061120084',
            'available' => true,
        ]);

        Book::create([
            'title' => '1984',
            'author' => 'George Orwell',
            'isbn' => '978-0451524935',
            'available' => true,
        ]);
    }
}
