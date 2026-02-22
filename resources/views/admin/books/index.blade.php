@extends('layouts.pustalora')

@section('title', 'Kelola Buku - Admin Pustalora')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kelola Buku</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title">Kelola Buku</h1>
                    <p class="text-muted">Tambah, edit, dan hapus buku di perpustakaan</p>
                </div>
                <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Buku
                </a>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.books.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Cari judul, penulis, atau kode..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="category">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                        <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
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

    <!-- Books Table -->
    <div class="card">
        <div class="card-body">
            @if($books->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Cover</th>
                                <th>Kode</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Kategori</th>
                                <th>Eksemplar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $book)
                            <tr>
                                <td>
                                    @if($book->cover_image)
                                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="rounded" style="width: 50px; height: 70px; object-fit: cover;">
                                    @else
                                        <div class="bg-purple-gradient rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 70px;">
                                            <i class="bi bi-book text-white"></i>
                                        </div>
                                    @endif
                                </td>
                                <td><code>{{ $book->unique_code }}</code></td>
                                <td>
                                    <strong>{{ $book->title }}</strong>
                                    @if($book->is_featured)
                                        <span class="badge badge-warning ms-1">
                                            <i class="bi bi-star-fill"></i>
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $book->author }}</td>
                                <td>
                                    @if($book->category)
                                        <span class="badge badge-primary">{{ $book->category->name }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-success">{{ $book->getAvailableCopiesCount() }}</span>/{{ $book->total_copies }}
                                </td>
                                <td>
                                    @if($book->isAvailable())
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
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#addCopiesModal{{ $book->id }}" title="Tambah Eksemplar">
                                            <i class="bi bi-plus"></i>
                                        </button>
                                        <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            @else
                <div class="text-center py-5">
                    <i class="bi bi-book text-muted" style="font-size: 5rem;"></i>
                    <h4 class="mt-3">Tidak ada buku ditemukan</h4>
                    <p class="text-muted">Mulai dengan menambahkan buku baru</p>
                    <a href="{{ route('admin.books.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Buku
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Copies Modals -->
@foreach($books as $book)
<div class="modal fade" id="addCopiesModal{{ $book->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Eksemplar - {{ $book->title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.books.add-copies', $book) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="copies_{{ $book->id }}" class="form-label">Jumlah Eksemplar</label>
                        <input type="number" class="form-control" id="copies_{{ $book->id }}" name="copies" min="1" value="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
