@extends('layouts.pustalora')

@section('title', 'Pustalora - Beranda')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Temukan Dunia<br><span class="text-white-50">Lewat Buku</span></h1>
                <p class="lead mb-4 text-white-50">
                    Pustalora adalah sistem peminjaman buku modern yang memudahkan Anda menemukan, meminjam, dan menikmati berbagai koleksi buku dengan cara yang elegan dan praktis.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('books.index') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-search me-2"></i>Jelajahi Katalog
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                        </a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block">
                <div class="card bg-white/10 border-0 text-white">
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-6">
                                <div class="card bg-white/10 border-0 text-center">
                                    <div class="card-body">
                                        <h3 class="display-6 fw-bold">1000+</h3>
                                        <p class="mb-0">Koleksi Buku</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card bg-white/10 border-0 text-center">
                                    <div class="card-body">
                                        <h3 class="display-6 fw-bold">500+</h3>
                                        <p class="mb-0">Anggota Aktif</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card bg-white/10 border-0 text-center">
                                    <div class="card-body">
                                        <h3 class="display-6 fw-bold">50+</h3>
                                        <p class="mb-0">Kategori</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card bg-white/10 border-0 text-center">
                                    <div class="card-body">
                                        <h3 class="display-6 fw-bold">24/7</h3>
                                        <p class="mb-0">Akses Online</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Mengapa Pustalora?</h2>
            <p class="section-subtitle">Platform peminjaman buku dengan pengalaman terbaik</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="bg-purple-gradient rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 64px; height: 64px;">
                            <i class="bi bi-search text-white fs-4"></i>
                        </div>
                        <h4 class="card-title">Pencarian Mudah</h4>
                        <p class="card-text">Temukan buku favorit Anda dengan cepat melalui fitur pencarian dan filter kategori yang canggih.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="bg-purple-gradient rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 64px; height: 64px;">
                            <i class="bi bi-clock text-white fs-4"></i>
                        </div>
                        <h4 class="card-title">Peminjaman Cepat</h4>
                        <p class="card-text">Proses peminjaman buku yang cepat dan mudah dengan sistem manajemen yang terintegrasi.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <div class="bg-purple-gradient rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 64px; height: 64px;">
                            <i class="bi bi-shield-check text-white fs-4"></i>
                        </div>
                        <h4 class="card-title">Aman & Terpercaya</h4>
                        <p class="card-text">Sistem keamanan yang terjamin dan pengelolaan peminjaman yang transparan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Books Section -->
@if($featuredBooks->count() > 0)
<section class="section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Buku Pilihan</h2>
            <p class="section-subtitle">Koleksi buku terbaik yang direkomendasikan untuk Anda</p>
        </div>
        <div class="row g-4">
            @foreach($featuredBooks as $book)
            <div class="col-md-6 col-lg-4">
                <div class="card book-card h-100">
                    <div class="position-relative">
                        @if($book->cover_image)
                            @if(str_starts_with($book->cover_image, 'http'))
                                <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="card-img-top">
                            @else
                                <img src="{{ asset($book->cover_image) }}" alt="{{ $book->title }}" class="card-img-top">
                            @endif
                        @else
                            <div class="bg-purple-gradient d-flex align-items-center justify-content-center" style="height: 300px;">
                                <i class="bi bi-book text-white" style="font-size: 5rem;"></i>
                            </div>
                        @endif
                        @if($book->is_featured)
                            <span class="badge badge-warning position-absolute top-3 start-3">
                                <i class="bi bi-star-fill me-1"></i>Pilihan
                            </span>
                        @endif
                        @if($book->isAvailable())
                            <span class="status-available position-absolute {{ $book->is_featured ? 'top-6' : 'top-3' }} end-3">
                                <i class="bi bi-check-circle me-1"></i>Tersedia
                            </span>
                        @else
                            <span class="status-borrowed position-absolute {{ $book->is_featured ? 'top-6' : 'top-3' }} end-3">
                                <i class="bi bi-x-circle me-1"></i>Tidak Tersedia
                            </span>
                        @endif
                    </div>
                    <div class="card-body">
                        @if($book->category)
                            <span class="badge badge-primary mb-2">{{ $book->category->name }}</span>
                        @endif
                        <h5 class="book-title">{{ $book->title }}</h5>
                        <p class="book-author" style="color: var(--text-secondary) !important;">{{ $book->author }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="book-rating" style="color: var(--warning-color) !important;">
                                <i class="bi bi-star-fill"></i>
                                <span style="color: var(--text-primary) !important;">{{ $book->rating }}</span>
                            </div>
                            <a href="{{ route('books.show', $book) }}" class="btn btn-sm btn-outline-primary">
                                Lihat Detail <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('books.index') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-grid me-2"></i>Lihat Semua Buku
            </a>
        </div>
    </div>
</section>
@endif

<!-- Categories Section -->
@if($categories->count() > 0)
<section class="section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Kategori Buku</h2>
            <p class="section-subtitle">Jelajahi berbagai kategori buku yang tersedia</p>
        </div>
        <div class="row g-3">
            @foreach($categories as $category)
            <div class="col-6 col-md-4 col-lg-2">
                <a href="{{ route('books.index', ['category' => $category->id]) }}" class="card text-center text-decoration-none h-100">
                    <div class="card-body">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px; background: {{ $category->color }}20;">
                            <i class="bi bi-collection" style="color: {{ $category->color }}; font-size: 1.5rem;"></i>
                        </div>
                        <h6 class="card-title mb-0">{{ $category->name }}</h6>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="section">
    <div class="container">
        <div class="card bg-purple-gradient border-0 text-white">
            <div class="card-body text-center py-5">
                <h2 class="display-5 fw-bold mb-3">Siap Memulai Petualangan Membaca?</h2>
                <p class="lead mb-4 text-white-50">
                    Bergabunglah dengan Pustalora sekarang dan nikmati akses ke ribuan koleksi buku yang menarik.
                </p>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-person-plus me-2"></i>Daftar Gratis
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                @else
                    <a href="{{ route('books.index') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-book me-2"></i>Jelajahi Buku
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                @endguest
            </div>
        </div>
    </div>
</section>
@endsection
