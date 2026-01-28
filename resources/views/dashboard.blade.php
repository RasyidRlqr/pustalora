<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold" style="color: white;">
            <i class="fas fa-tachometer-alt me-2" style="color: #06b6d4;"></i>Dashboard Pengguna
        </h2>
    </x-slot>

    <div class="py-12" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); color: white;">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #06b6d4;">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row mb-5">
                <div class="col-12">
                    <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1)); border: 1px solid rgba(6, 182, 212, 0.2); color: white; border-radius: 15px;">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="card-title mb-2">
                                        <i class="fas fa-book-open me-2"></i>Selamat Datang, {{ Auth::user()->name }}!
                                    </h4>
                                    <p class="card-text mb-0 opacity-75">Jelajahi koleksi buku kami dan pinjam buku favorit Anda</p>
                                </div>
                                <div class="col-md-4 text-center">
                                    <i class="fas fa-user-circle" style="font-size: 4rem; color: rgba(255,255,255,0.3);"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="card shadow-lg border-0 mb-4" style="border-radius: 15px; background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1)); border: 1px solid rgba(6, 182, 212, 0.2); color: white;">
                <div class="card-body p-4">
                    <form method="GET" action="{{ route('dashboard') }}" class="row g-3 align-items-end">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-search me-2"></i>Cari Buku
                            </label>
                            <input type="text" name="search" value="{{ $search }}" class="form-control bg-white border-0" placeholder="Cari berdasarkan judul, penulis, atau ISBN..." style="border-radius: 10px;">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn w-100" style="background: linear-gradient(45deg, #06b6d4, #0891b2); border: none; color: white; border-radius: 10px;">
                                <i class="fas fa-search me-2"></i>Cari
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-lg border-0 mb-5" style="border-radius: 15px; background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1)); border: 1px solid rgba(6, 182, 212, 0.2); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="border-radius: 15px 15px 0 0; background: rgba(255,255,255,0.1);">
                    <h5 class="mb-0" style="color: white;">
                        <i class="fas fa-book me-2" style="color: #06b6d4;"></i>Buku Tersedia
                        @if($search)
                            <small style="color: rgba(255,255,255,0.7);">(Hasil pencarian: "{{ $search }}")</small>
                        @endif
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if($books->count() > 0)
                        <div class="row g-4">
                            @foreach($books as $book)
                            <div class="col-lg-4 col-md-6">
                                <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px; transition: all 0.3s ease; background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1)); border: 1px solid rgba(6, 182, 212, 0.2); color: white;">
                                    <div class="card-body d-flex flex-column p-4">
                                        <div class="text-center mb-3">
                                            @if($book->image)
                                                <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="img-fluid rounded" style="max-height: 150px; object-fit: cover; border-radius: 8px;">
                                            @else
                                                <i class="fas fa-book-open" style="font-size: 3rem; color: #06b6d4; opacity: 0.7;"></i>
                                            @endif
                                        </div>
                                        <h6 class="card-title fw-bold mb-2" style="color: white;">{{ $book->title }}</h6>
                                        <p class="card-text small mb-2" style="color: rgba(255,255,255,0.8);">
                                            <i class="fas fa-user me-1"></i>{{ $book->author }}
                                        </p>
                                        <p class="card-text small mb-2" style="color: rgba(255,255,255,0.8);">
                                            <i class="fas fa-hashtag me-1"></i>{{ $book->isbn ?: 'N/A' }}
                                        </p>
                                        <p class="card-text small mb-3" style="color: rgba(255,255,255,0.8);">
                                            <i class="fas fa-boxes me-1"></i>Stok: {{ $book->available_quantity }} dari {{ $book->quantity }}
                                        </p>
                                        <div class="mt-auto">
                                            <form action="{{ route('books.borrow', $book) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn w-100" style="background: linear-gradient(45deg, #06b6d4, #0891b2); border: none; color: white; border-radius: 8px; box-shadow: 0 0 10px rgba(6, 182, 212, 0.3);">
                                                    <i class="fas fa-hand-holding me-1"></i>Pinjam Buku
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-search" style="font-size: 4rem; color: rgba(255,255,255,0.3);"></i>
                            <h5 class="mt-3" style="color: rgba(255,255,255,0.7);">
                                @if($search)
                                    Tidak ada buku ditemukan untuk "{{ $search }}"
                                @else
                                    Tidak ada buku tersedia saat ini
                                @endif
                            </h5>
                            <p style="color: rgba(255,255,255,0.6);">
                                @if($search)
                                    Coba kata kunci yang berbeda atau
                                    <a href="{{ route('dashboard') }}" class="text-decoration-none" style="color: #06b6d4;">tampilkan semua buku</a>
                                @else
                                    Silakan kembali lagi nanti untuk melihat koleksi terbaru kami.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card shadow-lg border-0" style="border-radius: 15px; background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1)); border: 1px solid rgba(6, 182, 212, 0.2); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="border-radius: 15px 15px 0 0; background: rgba(255,255,255,0.1);">
                    <h5 class="mb-0" style="color: white;">
                        <i class="fas fa-history me-2" style="color: #06b6d4;"></i>Riwayat Peminjaman
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if($userLoans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" style="color: white;">
                                <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                    <tr>
                                        <th><i class="fas fa-book me-1"></i>Judul Buku</th>
                                        <th><i class="fas fa-hashtag me-1"></i>Kode Pinjam</th>
                                        <th><i class="fas fa-calendar me-1"></i>Tanggal Pinjam</th>
                                        <th><i class="fas fa-info-circle me-1"></i>Status</th>
                                        <th><i class="fas fa-cogs me-1"></i>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($userLoans as $loan)
                                    <tr>
                                        <td class="fw-semibold">{{ $loan->book->title }}</td>
                                        <td>
                                            <span class="badge" style="background: linear-gradient(45deg, #8b5cf6, #7c3aed);">
                                                <i class="fas fa-hashtag me-1"></i>{{ $loan->loan_code }}
                                            </span>
                                        </td>
                                        <td>{{ $loan->borrowed_at->format('d/m/Y') }}</td>
                                        <td>
                                            @if($loan->returned_at)
                                                <span class="badge" style="background: linear-gradient(45deg, #10b981, #059669);">
                                                    <i class="fas fa-check me-1"></i>Dikembalikan
                                                </span>
                                            @else
                                                <span class="badge" style="background: linear-gradient(45deg, #f59e0b, #d97706);">
                                                    <i class="fas fa-clock me-1"></i>Dipinjam
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$loan->returned_at)
                                                <form action="{{ route('loans.return', $loan) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm" style="background: linear-gradient(45deg, #06b6d4, #0891b2); border: none; color: white; box-shadow: 0 0 10px rgba(6, 182, 212, 0.3);" onclick="return confirm('Yakin kembalikan buku ini?')">
                                                        <i class="fas fa-undo me-1"></i>Kembalikan
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-history" style="font-size: 4rem; color: rgba(255,255,255,0.3);"></i>
                            <h5 class="mt-3" style="color: rgba(255,255,255,0.7);">Belum ada riwayat peminjaman</h5>
                            <p style="color: rgba(255,255,255,0.6);">Mulai pinjam buku pertama Anda dari koleksi kami.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
