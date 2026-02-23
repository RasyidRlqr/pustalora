@extends('layouts.pustalora')

@section('title', 'Katalog Buku - Pustalora')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Katalog Buku</li>
                </ol>
            </nav>
            <h1 class="page-title">Katalog Buku</h1>
            <p class="text-secondary">Jelajahi koleksi buku yang tersedia di Pustalora</p>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-header bg-purple-gradient text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-funnel me-2"></i>Filter</h5>
                </div>
                <div class="card-body">
                    <!-- Search -->
                    <form action="{{ route('books.index') }}" method="GET" class="mb-4">
                        <div class="mb-3">
                            <label for="search" class="form-label">Cari Buku</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="search" name="search" placeholder="Judul, penulis, atau kode..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Kategori</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                                <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                            </select>
                        </div>

                        <!-- Sort -->
                        <div class="mb-3">
                            <label for="sort" class="form-label">Urutkan</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Judul A-Z</option>
                                <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Judul Z-A</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Terapkan Filter</button>
                        <a href="{{ route('books.index') }}" class="btn btn-outline-secondary w-100 mt-2">Reset</a>
                    </form>
                </div>
            </div>
        </div>

        <!-- Book Grid -->
        <div class="col-lg-9">
            <!-- Results Info -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <p class="mb-0 text-secondary">
                    Menampilkan <strong>{{ $books->count() }}</strong> dari <strong>{{ $books->total() }}</strong> buku
                </p>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary active">
                        <i class="bi bi-grid"></i>
                    </button>
                    <button type="button" class="btn btn-outline-primary">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
            </div>

            @if($books->count() > 0)
                <div class="row g-4">
                    @foreach($books as $book)
                    <div class="col-md-6 col-xl-4">
                        <div class="card book-card h-100">
                            <div class="position-relative">
                                @if($book->cover_image)
                                    @if(str_starts_with($book->cover_image, 'http'))
                                        <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="card-img-top">
                                    @else
                                        <img src="{{ asset($book->cover_image) }}" alt="{{ $book->title }}" class="card-img-top">
                                    @endif
                                @else
                                    <div class="bg-purple-gradient d-flex align-items-center justify-content-center" style="height: 250px;">
                                        <i class="bi bi-book text-white" style="font-size: 4rem;"></i>
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
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="book-rating" style="color: var(--warning-color) !important;">
                                        <i class="bi bi-star-fill"></i>
                                        <span style="color: var(--text-primary) !important;">{{ $book->rating }}</span>
                                    </div>
                                    <small class="text-secondary">
                                        <i class="bi bi-book me-1"></i>{{ $book->total_copies }} eksemplar
                                    </small>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('books.show', $book) }}" class="btn btn-primary flex-grow-1">
                                        <i class="bi bi-eye me-1"></i>Detail
                                    </a>
                                    @if($book->isAvailable() && auth()->check())
                                        <a href="{{ route('loans.create', ['book' => $book->id]) }}" class="btn btn-success">
                                            <i class="bi bi-bookmark-plus"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($books->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $books->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="bi bi-book text-secondary" style="font-size: 5rem;"></i>
                    <h4 class="mt-3">Tidak ada buku ditemukan</h4>
                    <p class="text-secondary">Coba ubah filter atau kata kunci pencarian Anda</p>
                    <a href="{{ route('books.index') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-counterclockwise me-2"></i>Reset Filter
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
