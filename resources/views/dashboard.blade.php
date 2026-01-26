<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold" style="color: #1a1a2e;">
            <i class="fas fa-tachometer-alt me-2" style="color: #06b6d4;"></i>Dashboard Pengguna
        </h2>
    </x-slot>

    <div class="py-12" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
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
                    <div class="card shadow-lg border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px;">
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

            <div class="card shadow-lg border-0 mb-5" style="border-radius: 15px; background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);">
                <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0" style="color: #1a1a2e;">
                        <i class="fas fa-book me-2" style="color: #06b6d4;"></i>Buku Tersedia
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if($books->count() > 0)
                        <div class="row g-4">
                            @foreach($books as $book)
                            <div class="col-lg-4 col-md-6">
                                <div class="card h-100 border-0 shadow-sm" style="border-radius: 12px; transition: all 0.3s ease; background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);">
                                    <div class="card-body d-flex flex-column p-4">
                                        <div class="text-center mb-3">
                                            <i class="fas fa-book-open" style="font-size: 3rem; color: #06b6d4; opacity: 0.7;"></i>
                                        </div>
                                        <h6 class="card-title fw-bold mb-2" style="color: #1a1a2e;">{{ $book->title }}</h6>
                                        <p class="card-text small mb-2" style="color: #64748b;">
                                            <i class="fas fa-user me-1"></i>{{ $book->author }}
                                        </p>
                                        <p class="card-text small mb-3" style="color: #64748b;">
                                            <i class="fas fa-hashtag me-1"></i>{{ $book->isbn ?: 'N/A' }}
                                        </p>
                                        <div class="mt-auto">
                                            <form action="{{ route('books.borrow', $book) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn w-100" style="background: linear-gradient(45deg, #06b6d4, #0891b2); border: none; color: white; border-radius: 8px;">
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
                            <i class="fas fa-book-open" style="font-size: 4rem; color: #cbd5e1;"></i>
                            <h5 class="mt-3" style="color: #64748b;">Tidak ada buku tersedia saat ini</h5>
                            <p class="text-muted">Silakan kembali lagi nanti untuk melihat koleksi terbaru kami.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card shadow-lg border-0" style="border-radius: 15px; background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);">
                <div class="card-header bg-white border-0" style="border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0" style="color: #1a1a2e;">
                        <i class="fas fa-history me-2" style="color: #06b6d4;"></i>Riwayat Peminjaman
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if($userLoans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                    <tr>
                                        <th><i class="fas fa-book me-1"></i>Judul Buku</th>
                                        <th><i class="fas fa-calendar me-1"></i>Tanggal Pinjam</th>
                                        <th><i class="fas fa-info-circle me-1"></i>Status</th>
                                        <th><i class="fas fa-cogs me-1"></i>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($userLoans as $loan)
                                    <tr>
                                        <td class="fw-semibold">{{ $loan->book->title }}</td>
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
                                                    <button type="submit" class="btn btn-sm" style="background: linear-gradient(45deg, #06b6d4, #0891b2); border: none; color: white;" onclick="return confirm('Yakin kembalikan buku ini?')">
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
                            <i class="fas fa-history" style="font-size: 4rem; color: #cbd5e1;"></i>
                            <h5 class="mt-3" style="color: #64748b;">Belum ada riwayat peminjaman</h5>
                            <p class="text-muted">Mulai pinjam buku pertama Anda dari koleksi kami.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
