@extends('layouts.pustalora')

@section('title', 'Kelola Peminjaman - Admin Pustalora')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kelola Peminjaman</li>
                </ol>
            </nav>
            <h1 class="page-title">Kelola Peminjaman</h1>
            <p class="text-muted">Pantau dan kelola semua peminjaman buku</p>
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
                            <h6 class="card-subtitle mb-1 text-muted">Total Peminjaman</h6>
                            <h3 class="card-title mb-0">{{ $stats['total'] }}</h3>
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
                            <h6 class="card-subtitle mb-1 text-muted">Sedang Dipinjam</h6>
                            <h3 class="card-title mb-0">{{ $stats['active'] }}</h3>
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
                            <i class="bi bi-check-circle text-white"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Sudah Dikembalikan</h6>
                            <h3 class="card-title mb-0">{{ $stats['returned'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="bg-danger rounded-circle d-inline-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                            <i class="bi bi-exclamation-triangle text-white"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle mb-1 text-muted">Terlambat</h6>
                            <h3 class="card-title mb-0">{{ $stats['overdue'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.loans.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Cari judul buku atau nama peminjam..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Sedang Dipinjam</option>
                        <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Sudah Dikembalikan</option>
                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="sort">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Loans Table -->
    <div class="card">
        <div class="card-body">
            @if($loans->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Buku</th>
                                <th>Kode Eksemplar</th>
                                <th>Peminjam</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tenggat</th>
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
                                                <img src="{{ $loan->book->cover_image }}" alt="{{ $loan->book->title }}" class="rounded me-3" style="width: 40px; height: 56px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset($loan->book->cover_image) }}" alt="{{ $loan->book->title }}" class="rounded me-3" style="width: 40px; height: 56px; object-fit: cover;">
                                            @endif
                                        @else
                                            <div class="bg-purple-gradient rounded d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 56px;">
                                                <i class="bi bi-book text-white"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $loan->book->title }}</strong>
                                            <br><small class="text-muted">{{ $loan->book->author }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><code>{{ $loan->bookCopy->copy_code }}</code></td>
                                <td>{{ $loan->user->name }}</td>
                                <td>{{ $loan->loan_date->format('d/m/Y') }}</td>
                                <td>{{ $loan->due_date->format('d/m/Y') }}</td>
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
                                        <form action="{{ route('admin.loans.return', $loan) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menandai buku ini sebagai dikembalikan?');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Tandai Dikembalikan">
                                                <i class="bi bi-check-circle"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">
                                            <i class="bi bi-check2"></i>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($loans->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $loans->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="bi bi-book text-muted" style="font-size: 5rem;"></i>
                    <h4 class="mt-3">Tidak ada peminjaman ditemukan</h4>
                    <p class="text-muted">Belum ada data peminjaman yang sesuai dengan filter</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
