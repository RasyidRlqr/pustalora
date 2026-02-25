@extends('layouts.pustalora')

@section('title', 'Dashboard - Pustalora')

@section('content')
<div class="container py-4">
    <!-- Profile Incomplete Warning -->
    @if(!Auth::user()->isProfileComplete())
    <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <div>
            <strong>Profil Anda belum lengkap!</strong> Silakan lengkapi alamat dan nomor HP di <a href="{{ route('profile.edit') }}" class="alert-link">halaman profil</a> untuk dapat meminjam buku.
        </div>
    </div>
    @endif

    <!-- Welcome Message with Member Code -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h2 class="fw-bold mb-1">Selamat datang, {{ Auth::user()->name }}!</h2>
                            <p class="text-secondary mb-0">Ini adalah dashboard perpustakaan Anda.</p>
                        </div>
                        <div class="text-md-end mt-3 mt-md-0">
                            <div class="badge bg-primary fs-6 mb-2">
                                <i class="bi bi-card-text me-1"></i>Kode Anggota: <strong>{{ Auth::user()->member_code }}</strong>
                            </div>
                            @if(Auth::user()->address)
                                <div class="text-secondary small">
                                    <i class="bi bi-geo-alt me-1"></i>{{ Auth::user()->address }}
                                </div>
                            @endif
                            @if(Auth::user()->phone)
                                <div class="text-secondary small">
                                    <i class="bi bi-phone me-1"></i>{{ Auth::user()->phone }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <a href="{{ route('books.index') }}" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="bg-primary bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                            <i class="bi bi-book text-white fs-4"></i>
                        </div>
                        <h5 class="card-title text-dark">Jelajahi Buku</h5>
                        <p class="card-text text-secondary small">Temukan buku yang Anda cari</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('loans.index') }}" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="bg-success bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                            <i class="bi bi-bookmark text-white fs-4"></i>
                        </div>
                        <h5 class="card-title text-dark">Peminjaman Saya</h5>
                        <p class="card-text text-secondary small">Lihat semua peminjaman</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('profile.edit') }}" class="text-decoration-none">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="bg-purple bg-gradient rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                            <i class="bi bi-person text-white fs-4"></i>
                        </div>
                        <h5 class="card-title text-dark">Profil</h5>
                        <p class="card-text text-secondary small">Kelola informasi akun</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Active Loans -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0 fw-semibold"><i class="bi bi-bookmark-check me-2"></i>Peminjaman Aktif</h4>
                </div>
                <div class="card-body">
                    @if($activeLoans->isEmpty())
                        <div class="text-center py-4">
                            <i class="bi bi-inbox text-secondary" style="font-size: 3rem;"></i>
                            <p class="text-secondary mt-2">Anda tidak memiliki peminjaman aktif.</p>
                            <a href="{{ route('books.index') }}" class="btn btn-primary">Jelajahi buku sekarang</a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-0">Buku</th>
                                        <th class="border-0">Tanggal Pinjam</th>
                                        <th class="border-0">Jatuh Tempo</th>
                                        <th class="border-0">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activeLoans as $loan)
                                        <tr>
                                            <td>
                                                <div class="fw-medium">{{ $loan->book->title }}</div>
                                                <div class="text-secondary small">{{ $loan->book->author }}</div>
                                            </td>
                                            <td class="align-middle">{{ $loan->loan_date->format('d/m/Y') }}</td>
                                            <td class="align-middle">
                                                {{ $loan->due_date->format('d/m/Y') }}
                                                @if($loan->isOverdue())
                                                    <span class="badge bg-danger ms-2">Terlambat</span>
                                                @endif
                                            </td>
                                            <td class="align-middle">
                                                <span class="badge bg-success">Aktif</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Loan History -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0 fw-semibold"><i class="bi bi-clock-history me-2"></i>Riwayat Peminjaman Terbaru</h4>
                </div>
                <div class="card-body">
                    @if($recentLoans->isEmpty())
                        <div class="text-center py-4">
                            <i class="bi bi-inbox text-secondary" style="font-size: 3rem;"></i>
                            <p class="text-secondary mt-2">Belum ada riwayat peminjaman.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th class="border-0">Buku</th>
                                        <th class="border-0">Tanggal Pinjam</th>
                                        <th class="border-0">Tanggal Kembali</th>
                                        <th class="border-0">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentLoans as $loan)
                                        <tr>
                                            <td>
                                                <div class="fw-medium">{{ $loan->book->title }}</div>
                                                <div class="text-secondary small">{{ $loan->book->author }}</div>
                                            </td>
                                            <td class="align-middle">{{ $loan->loan_date->format('d/m/Y') }}</td>
                                            <td class="align-middle">{{ $loan->return_date->format('d/m/Y') }}</td>
                                            <td class="align-middle">
                                                <span class="badge bg-secondary">Dikembalikan</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('loans.index') }}" class="text-primary text-decoration-none">Lihat semua riwayat →</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
