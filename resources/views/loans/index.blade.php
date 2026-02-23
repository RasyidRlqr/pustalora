@extends('layouts.pustalora')

@section('title', 'Peminjaman Saya - Pustalora')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Peminjaman Saya</li>
                </ol>
            </nav>
            <h1 class="page-title">Peminjaman Saya</h1>
            <p class="text-secondary">Kelola buku yang Anda pinjam</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-purple-gradient rounded-circle d-inline-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                            <i class="bi bi-book text-white"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Total Peminjaman</h6>
                            <h3 class="card-title mb-0">{{ $loans->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                            <i class="bi bi-bookmark-check text-white"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Sedang Dipinjam</h6>
                            <h3 class="card-title mb-0">{{ $loans->where('status', 'active')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-info rounded-circle d-inline-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                            <i class="bi bi-check-circle text-white"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Sudah Dikembalikan</h6>
                            <h3 class="card-title mb-0">{{ $loans->where('status', 'returned')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loans List -->
    <div class="card">
        <div class="card-header bg-purple-gradient text-white d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0"><i class="bi bi-list-ul me-2"></i>Daftar Peminjaman</h5>
            <a href="{{ route('books.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-plus me-1"></i>Pinjam Buku Baru
            </a>
        </div>
        <div class="card-body">
            @if($loans->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Buku</th>
                                <th>Kode Eksemplar</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loans as $loan)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($loan->book->cover_image)
                                            @if(str_starts_with($loan->book->cover_image, 'http'))
                                                <img src="{{ $loan->book->cover_image }}" alt="{{ $loan->book->title }}" class="rounded me-3" style="width: 50px; height: 70px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset($loan->book->cover_image) }}" alt="{{ $loan->book->title }}" class="rounded me-3" style="width: 50px; height: 70px; object-fit: cover;">
                                            @endif
                                        @else
                                            <div class="bg-purple-gradient rounded d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 70px;">
                                                <i class="bi bi-book text-white"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-0">{{ $loan->book->title }}</h6>
                                            <small class="text-secondary">{{ $loan->book->author }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><code>{{ $loan->bookCopy->copy_code }}</code></td>
                                <td>{{ $loan->loan_date->format('d/m/Y') }}</td>
                                <td>
                                    @if($loan->return_date)
                                        {{ $loan->return_date->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($loan->status === 'active')
                                        @if($loan->isOverdue())
                                            <span class="status-overdue">
                                                <i class="bi bi-exclamation-triangle me-1"></i>Terlambat
                                            </span>
                                        @else
                                            <span class="status-borrowed">
                                                <i class="bi bi-book me-1"></i>Dipinjam
                                            </span>
                                        @endif
                                    @else
                                        <span class="status-returned">
                                            <i class="bi bi-check-circle me-1"></i>Dikembalikan
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($loan->status === 'active')
                                        <a href="{{ route('loans.return', $loan) }}" class="btn btn-success btn-sm" onclick="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?');">
                                            <i class="bi bi-arrow-return-left me-1"></i>Kembalikan
                                        </a>
                                    @else
                                        <span class="text-muted">
                                            <i class="bi bi-check2"></i> Selesai
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-book text-muted" style="font-size: 5rem;"></i>
                    <h4 class="mt-3">Belum ada peminjaman</h4>
                    <p class="text-muted">Anda belum meminjam buku apapun</p>
                    <a href="{{ route('books.index') }}" class="btn btn-primary">
                        <i class="bi bi-book me-2"></i>Jelajahi Katalog Buku
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
