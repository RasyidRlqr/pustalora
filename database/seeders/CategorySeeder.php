<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fiksi',
                'slug' => 'fiksi',
                'description' => 'Koleksi buku fiksi dan novel',
                'color' => '#9333ea',
            ],
            [
                'name' => 'Sains',
                'slug' => 'sains',
                'description' => 'Buku sains dan teknologi',
                'color' => '#3b82f6',
            ],
            [
                'name' => 'Sejarah',
                'slug' => 'sejarah',
                'description' => 'Buku sejarah dan biografi',
                'color' => '#f59e0b',
            ],
            [
                'name' => 'Bisnis',
                'slug' => 'bisnis',
                'description' => 'Buku bisnis dan ekonomi',
                'color' => '#10b981',
            ],
            [
                'name' => 'Pendidikan',
                'slug' => 'pendidikan',
                'description' => 'Buku pendidikan dan pengembangan diri',
                'color' => '#ec4899',
            ],
            [
                'name' => 'Agama',
                'slug' => 'agama',
                'description' => 'Buku agama dan spiritualitas',
                'color' => '#8b5cf6',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
