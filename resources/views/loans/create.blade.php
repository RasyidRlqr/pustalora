@extends('layouts.pustalora')

@section('title', 'Pinjam Buku - Pustalora')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('books.index') }}" class="text-decoration-none">Katalog Buku</a></li>
            <li class="breadcrumb-item"><a href="{{ route('books.show', $book) }}" class="text-decoration-none">{{ $book->title }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pinjam Buku</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Book Info -->
        <div class="col-lg-5 mb-4">
            <div class="card">
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
                <div class="card-body">
                    @if($book->category)
                        <span class="badge badge-primary mb-2">{{ $book->category->name }}</span>
                    @endif
                    <h4 class="book-title">{{ $book->title }}</h4>
                    <p class="book-author">{{ $book->author }}</p>
                    <hr>
                    <div class="row g-2">
                        <div class="col-6">
                            <small class="text-muted">Kode Buku</small>
                            <p class="mb-0"><strong>{{ $book->unique_code }}</strong></p>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">Rating</small>
                            <p class="mb-0"><strong>{{ $book->rating }}/5.0</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loan Form -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header bg-purple-gradient text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-bookmark-plus me-2"></i>Formulir Peminjaman</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('loans.store', $book) }}" method="POST">
                        @csrf

                        <!-- Book Selection -->
                        <div class="mb-4">
                            <label for="book_id" class="form-label">Buku</label>
                            <input type="text" class="form-control" value="{{ $book->title }}" readonly>
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                        </div>

                        <!-- Book Copy Selection -->
                        <div class="mb-4">
                            <label for="book_copy_id" class="form-label">Pilih Eksemplar</label>
                            <select class="form-select" id="book_copy_id" name="book_copy_id" required>
                                <option value="">-- Pilih Eksemplar --</option>
                                @foreach($availableCopies as $copy)
                                    <option value="{{ $copy->id }}">
                                        {{ $copy->copy_code }} - Tersedia
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                {{ $availableCopies->count() }} eksemplar tersedia untuk dipinjam
                            </div>
                        </div>

                        <!-- Loan Date -->
                        <div class="mb-4">
                            <label for="loan_date" class="form-label">Tanggal Pinjam</label>
                            <input type="date" class="form-control" id="loan_date" name="loan_date" value="{{ now()->format('Y-m-d') }}" required>
                        </div>

                        <!-- Due Date -->
                        <div class="mb-4">
                            <label for="due_date" class="form-label">Tanggal Harus Kembali</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" value="{{ now()->addDays(14)->format('Y-m-d') }}" required>
                            <div class="form-text">
                                <i class="bi bi-clock me-1"></i>
                                Maksimal peminjaman 14 hari
                            </div>
                        </div>

                        <!-- Fine Policy Info -->
                        <div class="alert alert-warning mb-4">
                            <h6 class="alert-heading"><i class="bi bi-exclamation-triangle me-2"></i>Informasi Peminjaman</h6>
                            <ul class="mb-0 small">
                                <li>Maksimal peminjaman adalah 14 hari</li>
                                <li>Denda keterlambatan: <strong>Rp 1.000 per 3 hari</strong></li>
                                <li>Harus mengembalikan buku dalam kondisi baik</li>
                                <li>Hubungi admin jika ada kerusakan atau kehilangan</li>
                            </ul>
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <label for="notes" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                        </div>

                        <!-- Terms -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    Saya setuju dengan <a href="#" class="text-decoration-none">syarat dan ketentuan</a> peminjaman buku
                                </label>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="bi bi-check-circle me-2"></i>Konfirmasi Peminjaman
                            </button>
                            <a href="{{ route('books.show', $book) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card mt-4">
                <div class="card-body">
                    <h6 class="card-title"><i class="bi bi-info-circle me-2"></i>Informasi Peminjaman</h6>
                    <ul class="mb-0">
                        <li>Maksimal peminjaman adalah 14 hari</li>
                        <li>Denda keterlambatan: Rp 1.000 per 3 hari</li>
                        <li>Harus mengembalikan buku dalam kondisi baik</li>
                        <li>Hubungi admin jika ada kerusakan atau kehilangan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Set minimum date for loan_date to today
    document.getElementById('loan_date').min = new Date().toISOString().split('T')[0];

    // Set minimum date for due_date to loan_date + 1 day
    document.getElementById('loan_date').addEventListener('change', function() {
        const loanDate = new Date(this.value);
        const minDueDate = new Date(loanDate);
        minDueDate.setDate(minDueDate.getDate() + 1);
        document.getElementById('due_date').min = minDueDate.toISOString().split('T')[0];
    });
</script>
@endsection
