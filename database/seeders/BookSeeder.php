<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        $books = [
            [
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'isbn' => '978-602-03-0280-9',
                'publisher' => 'Bentang Pustaka',
                'published_year' => 2005,
                'pages' => 534,
                'description' => 'Novel yang menceritakan perjuangan sekelompok anak di Belitong untuk mendapatkan pendidikan yang layak.',
                'rating' => 4.8,
                'is_featured' => true,
                'category_name' => 'Fiksi',
                'unique_code' => 'LP-255',
            ],
            [
                'title' => 'Bumi Manusia',
                'author' => 'Pramoedya Ananta Toer',
                'isbn' => '978-979-22-0274-2',
                'publisher' => 'Hasta Mitra',
                'published_year' => 1980,
                'pages' => 535,
                'description' => 'Novel sejarah yang menggambarkan pergerakan nasional Indonesia pada awal abad ke-20.',
                'rating' => 4.9,
                'is_featured' => true,
                'category_name' => 'Sejarah',
                'unique_code' => 'BM-123',
            ],
            [
                'title' => 'Atomic Habits',
                'author' => 'James Clear',
                'isbn' => '978-0-7352-1129-2',
                'publisher' => 'Avery',
                'published_year' => 2018,
                'pages' => 320,
                'description' => 'Panduan praktis untuk membangun kebiasaan baik dan menghilangkan kebiasaan buruk.',
                'rating' => 4.7,
                'is_featured' => true,
                'category_name' => 'Pendidikan',
                'unique_code' => 'AH-456',
            ],
            [
                'title' => 'Sapiens: Riwayat Singkat Umat Manusia',
                'author' => 'Yuval Noah Harari',
                'isbn' => '978-0-06-231609-7',
                'publisher' => 'Harper',
                'published_year' => 2014,
                'pages' => 443,
                'description' => 'Buku yang mengeksplorasi sejarah umat manusia dari zaman purba hingga era modern.',
                'rating' => 4.6,
                'is_featured' => true,
                'category_name' => 'Sejarah',
                'unique_code' => 'SR-789',
            ],
            [
                'title' => 'Filosofi Teras',
                'author' => 'Henry Manampiring',
                'isbn' => '978-602-06-3299-0',
                'publisher' => 'Gramedia Pustaka Utama',
                'published_year' => 2018,
                'pages' => 256,
                'description' => 'Buku yang menghadirkan filosofi Stoisisme dalam konteks kehidupan modern.',
                'rating' => 4.5,
                'is_featured' => false,
                'category_name' => 'Pendidikan',
                'unique_code' => 'FT-321',
            ],
            [
                'title' => 'Gadis Kretek',
                'author' => 'Ratih Kumala',
                'isbn' => '978-602-03-4476-3',
                'publisher' => 'Gramedia Pustaka Utama',
                'published_year' => 2018,
                'pages' => 416,
                'description' => 'Novel yang mengisahkan perjalanan seorang gadis mencari kekasihnya di dunia industri kretek.',
                'rating' => 4.4,
                'is_featured' => false,
                'category_name' => 'Fiksi',
                'unique_code' => 'GK-654',
            ],
            [
                'title' => 'The Psychology of Money',
                'author' => 'Morgan Housel',
                'isbn' => '978-0-85719-768-9',
                'publisher' => 'Harriman House',
                'published_year' => 2020,
                'pages' => 256,
                'description' => 'Buku tentang psikologi di balik keputusan keuangan dan cara berpikir tentang uang.',
                'rating' => 4.6,
                'is_featured' => true,
                'category_name' => 'Bisnis',
                'unique_code' => 'PM-987',
            ],
            [
                'title' => 'Negeri 5 Menara',
                'author' => 'A. Fuadi',
                'isbn' => '978-979-22-5480-2',
                'publisher' => 'Gramedia Pustaka Utama',
                'published_year' => 2009,
                'pages' => 432,
                'description' => 'Novel tentang perjalanan enam orang santri di pesantren Gontor.',
                'rating' => 4.5,
                'is_featured' => false,
                'category_name' => 'Fiksi',
                'unique_code' => 'NM-147',
            ],
            [
                'title' => 'A Brief History of Time',
                'author' => 'Stephen Hawking',
                'isbn' => '978-0-553-38016-3',
                'publisher' => 'Bantam',
                'published_year' => 1988,
                'pages' => 212,
                'description' => 'Buku sains populer yang menjelaskan konsep-konsep fisika modern dengan cara yang mudah dipahami.',
                'rating' => 4.7,
                'is_featured' => true,
                'category_name' => 'Sains',
                'unique_code' => 'BH-258',
            ],
            [
                'title' => 'Rich Dad Poor Dad',
                'author' => 'Robert Kiyosaki',
                'isbn' => '978-1-61268-019-4',
                'publisher' => 'Plata Publishing',
                'published_year' => 1997,
                'pages' => 336,
                'description' => 'Buku yang mengajarkan tentang literasi keuangan dan cara membangun kekayaan.',
                'rating' => 4.4,
                'is_featured' => false,
                'category_name' => 'Bisnis',
                'unique_code' => 'RD-369',
            ],
            [
                'title' => 'Pulang',
                'author' => 'Leila S. Chudori',
                'isbn' => '978-602-03-0156-6',
                'publisher' => 'Gramedia Pustaka Utama',
                'published_year' => 2012,
                'pages' => 416,
                'description' => 'Novel tentang kisah keluarga eksil Indonesia setelah peristiwa 1965.',
                'rating' => 4.6,
                'is_featured' => false,
                'category_name' => 'Sejarah',
                'unique_code' => 'PL-741',
            ],
            [
                'title' => 'Mindset',
                'author' => 'Carol S. Dweck',
                'isbn' => '978-1-4000-6275-2',
                'publisher' => 'Random House',
                'published_year' => 2006,
                'pages' => 276,
                'description' => 'Buku tentang perbedaan antara mindset tetap dan mindset berkembang.',
                'rating' => 4.5,
                'is_featured' => false,
                'category_name' => 'Pendidikan',
                'unique_code' => 'MS-852',
            ],
        ];

        foreach ($books as $bookData) {
            $category = $categories->where('name', $bookData['category_name'])->first();
            $uniqueCode = $bookData['unique_code'];
            unset($bookData['category_name'], $bookData['unique_code']);

            $slug = strtolower(str_replace(' ', '-', $bookData['title']));
            $totalCopies = rand(2, 5);

            $book = Book::create(array_merge($bookData, [
                'slug' => $slug,
                'unique_code' => $uniqueCode,
                'category_id' => $category ? $category->id : null,
                'total_copies' => $totalCopies,
                'available_copies' => $totalCopies,
            ]));

            // Create book copies
            for ($i = 1; $i <= $totalCopies; $i++) {
                BookCopy::create([
                    'book_id' => $book->id,
                    'copy_code' => $uniqueCode . '-' . $i,
                    'status' => 'available',
                ]);
            }
        }
    }
}
