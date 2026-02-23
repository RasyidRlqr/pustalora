@extends('layouts.pustalora')

@section('title', $book->title . ' - Pustalora')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('books.index') }}" class="text-decoration-none">Katalog Buku</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $book->title }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Book Cover -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                @if($book->cover_image)
                    @if(str_starts_with($book->cover_image, 'http'))
                        <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="card-img-top">
                    @else
                        <img src="{{ asset($book->cover_image) }}" alt="{{ $book->title }}" class="card-img-top">
                    @endif
                @else
                    <div class="bg-purple-gradient d-flex align-items-center justify-content-center" style="height: 400px;">
                        <i class="bi bi-book text-white" style="font-size: 6rem;"></i>
                    </div>
                @endif
                <div class="card-body">
                    @if($book->isAvailable())
                        <div class="alert alert-success mb-0">
                            <i class="bi bi-check-circle me-2"></i>
                            <strong>{{ $book->getAvailableCopiesCount() }}</strong> eksemplar tersedia
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="bi bi-clock me-2"></i>
                            Semua eksemplar sedang dipinjam
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Book Details -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    @if($book->category)
                        <span class="badge badge-primary mb-2">{{ $book->category->name }}</span>
                    @endif
                    @if($book->is_featured)
                        <span class="badge badge-warning mb-2">
                            <i class="bi bi-star-fill me-1"></i>Pilihan
                        </span>
                    @endif
                    <h1 class="page-title mb-3">{{ $book->title }}</h1>
                    <p class="book-author mb-4">{{ $book->author }}</p>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-hash text-secondary me-2"></i>
                                <div>
                                    <small class="text-secondary d-block">Kode Buku</small>
                                    <strong style="color: var(--text-primary) !important;">{{ $book->unique_code }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-calendar text-secondary me-2"></i>
                                <div>
                                    <small class="text-secondary d-block">Tahun Terbit</small>
                                    <strong style="color: var(--text-primary) !important;">{{ $book->published_year }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-book text-secondary me-2"></i>
                                <div>
                                    <small class="text-secondary d-block">Total Eksemplar</small>
                                    <strong style="color: var(--text-primary) !important;">{{ $book->total_copies }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-star text-secondary me-2"></i>
                                <div>
                                    <small class="text-secondary d-block">Rating</small>
                                    <strong style="color: var(--text-primary) !important;">{{ $book->rating }}/5.0</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h5 class="mb-3">Sinopsis</h5>
                    <p style="color: var(--text-primary) !important;">{{ $book->description }}</p>

                    <div class="d-flex gap-3 mt-4">
                        @if($book->isAvailable() && auth()->check())
                            <a href="{{ route('loans.create', ['book' => $book->id]) }}" class="btn btn-primary btn-lg">
                                <i class="bi bi-bookmark-plus me-2"></i>Pinjam Buku
                            </a>
                        @elseif(!auth()->check())
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Login untuk Meminjam
                            </a>
                        @else
                            <button class="btn btn-secondary btn-lg" disabled>
                                <i class="bi bi-x-circle me-2"></i>Tidak Tersedia
                            </button>
                        @endif
                        <a href="{{ route('books.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Book Copies Status -->
            <div class="card">
                <div class="card-header bg-purple-gradient text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-collection me-2"></i>Status Eksemplar</h5>
                </div>
                <div class="card-body">
                    @if($book->bookCopies->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Kode Eksemplar</th>
                                        <th>Status</th>
                                        <th>Peminjam</th>
                                        <th>Tanggal Pinjam</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($book->bookCopies as $copy)
                                    <tr>
                                        <td><code>{{ $copy->copy_code }}</code></td>
                                        <td>
                                            @if($copy->status === 'available')
                                                <span class="status-available">
                                                    <i class="bi bi-check-circle me-1"></i>Tersedia
                                                </span>
                                            @else
                                                <span class="status-borrowed">
                                                    <i class="bi bi-x-circle me-1"></i>Dipinjam
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($copy->activeLoan)
                                                {{ $copy->activeLoan->user->name }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($copy->activeLoan)
                                                {{ $copy->activeLoan->loan_date->format('d/m/Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-secondary mb-0">Tidak ada eksemplar tersedia</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
