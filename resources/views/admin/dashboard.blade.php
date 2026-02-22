@extends('layouts.pustalora')

@section('title', 'Dashboard Admin - Pustalora')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard Admin</li>
                </ol>
            </nav>
            <h1 class="page-title">Dashboard Admin</h1>
            <p class="text-muted">Selamat datang, {{ auth()->user()->name }}!</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-purple-gradient rounded-circle d-inline-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                            <i class="bi bi-book text-white"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Total Buku</h6>
                            <h3 class="card-title mb-0">{{ $stats['total_books'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                            <i class="bi bi-bookmark-check text-white"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Total Eksemplar</h6>
                            <h3 class="card-title mb-0">{{ $stats['total_copies'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-info rounded-circle d-inline-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                            <i class="bi bi-bookmark-check text-white"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Peminjaman Aktif</h6>
                            <h3 class="card-title mb-0">{{ $stats['active_loans'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                            <i class="bi bi-people text-white"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Total Pengguna</h6>
                            <h3 class="card-title mb-0">{{ $stats['total_users'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Loans -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-purple-gradient text-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><i class="bi bi-clock-history me-2"></i>Peminjaman Terbaru</h5>
                    <a href="{{ route('admin.loans.index') }}" class="btn btn-light btn-sm">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if($recentLoans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Buku</th>
                                        <th>Peminjam</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentLoans as $loan)
                                    <tr>
                                        <td>
                                            <strong>{{ $loan->book->title }}</strong>
                                            <br><small class="text-muted">{{ $loan->bookCopy->copy_code }}</small>
                                        </td>
                                        <td>{{ $loan->user->name }}</td>
                                        <td>{{ $loan->loan_date->format('d/m/Y') }}</td>
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
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">Belum ada peminjaman</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-purple-gradient text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-lightning me-2"></i>Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Buku Baru
                        </a>
                        <a href="{{ route('admin.books.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-book me-2"></i>Kelola Buku
                        </a>
                        <a href="{{ route('admin.loans.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-bookmark-check me-2"></i>Kelola Peminjaman
                        </a>
                        <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-eye me-2"></i>Lihat Katalog Publik
                        </a>
                    </div>
                </div>
            </div>

            <!-- Overdue Loans Alert -->
            @if($overdueLoans->count() > 0)
            <div class="card mt-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Peminjaman Terlambat</h5>
                </div>
                <div class="card-body">
                    <p class="mb-3">Ada <strong>{{ $overdueLoans->count() }}</strong> peminjaman yang terlambat dikembalikan.</p>
                    <a href="{{ route('admin.loans.index', ['status' => 'overdue']) }}" class="btn btn-danger w-100">
                        <i class="bi bi-exclamation-circle me-2"></i>Lihat Detail
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
