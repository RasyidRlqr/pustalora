<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin Pustalora',
            'email' => 'admin@pustalora.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Create Regular User
        User::create([
            'name' => 'User Pustalora',
            'email' => 'user@pustalora.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);
    }
}
