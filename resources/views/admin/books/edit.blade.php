@extends('layouts.pustalora')

@section('title', 'Edit Buku - Admin Pustalora')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.books.index') }}" class="text-decoration-none">Kelola Buku</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Buku</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header bg-purple-gradient text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-pencil me-2"></i>Edit Buku</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <h6 class="mb-3">Informasi Dasar</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="title" class="form-label">Judul Buku <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $book->title) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="author" class="form-label">Penulis <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="author" name="author" value="{{ old('author', $book->author) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="isbn" class="form-label">ISBN</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn) }}" placeholder="Contoh: 978-3-16-148410-0">
                                    <button type="button" class="btn btn-outline-primary" onclick="generateISBN()">
                                        <i class="bi bi-shuffle"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="published_year" class="form-label">Tahun Terbit <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="published_year" name="published_year" min="1000" max="{{ date('Y') }}" value="{{ old('published_year', $book->published_year) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="rating" class="form-label">Rating</label>
                                <input type="number" class="form-control" id="rating" name="rating" min="0" max="5" step="0.1" value="{{ old('rating', $book->rating) }}">
                            </div>
                        </div>

                        <!-- Cover Image -->
                        <h6 class="mb-3">Gambar Cover</h6>
                        <div class="mb-4">
                            <!-- Current Cover -->
                            @if($book->cover_image)
                                <div class="mb-3">
                                    <label class="form-label">Cover Saat Ini:</label>
                                    <div>
                                        @if(str_starts_with($book->cover_image, 'http'))
                                            <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="rounded" style="max-height: 200px;">
                                        @else
                                            <img src="{{ asset($book->cover_image) }}" alt="{{ $book->title }}" class="rounded" style="max-height: 200px;">
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="cover_image_type" id="cover_type_file" value="file" {{ old('cover_image_type', 'file') === 'file' ? 'checked' : '' }}>
                                <label class="form-check-label" for="cover_type_file">
                                    Upload File
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="cover_image_type" id="cover_type_url" value="url" {{ old('cover_image_type') === 'url' ? 'checked' : '' }}>
                                <label class="form-check-label" for="cover_type_url">
                                    Gunakan URL
                                </label>
                            </div>

                            <div id="cover_file_input" class="mb-3" {{ old('cover_image_type', 'file') === 'file' ? '' : 'style="display: none;"' }}>
                                <label for="cover_image_file" class="form-label">Upload Gambar</label>
                                <input type="file" class="form-control" id="cover_image_file" name="cover_image_file" accept="image/*">
                                <div class="form-text">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah.</div>
                            </div>

                            <div id="cover_url_input" class="mb-3" {{ old('cover_image_type') === 'url' ? '' : 'style="display: none;"' }}>
                                <label for="cover_image_url" class="form-label">URL Gambar</label>
                                <input type="url" class="form-control" id="cover_image_url" name="cover_image_url" value="{{ old('cover_image_url') }}" placeholder="https://example.com/image.jpg">
                                <div class="form-text">Masukkan URL gambar yang valid.</div>
                            </div>
                        </div>

                        <!-- Description -->
                        <h6 class="mb-3">Deskripsi</h6>
                        <div class="mb-4">
                            <label for="description" class="form-label">Sinopsis Buku</label>
                            <textarea class="form-control" id="description" name="description" rows="5" placeholder="Tulis sinopsis buku di sini...">{{ old('description', $book->description) }}</textarea>
                        </div>

                        <!-- Featured -->
                        <h6 class="mb-3">Pengaturan</h6>
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" {{ old('is_featured', $book->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Jadikan Buku Pilihan
                                </label>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle cover image input type
    document.getElementById('cover_type_file').addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('cover_file_input').style.display = 'block';
            document.getElementById('cover_url_input').style.display = 'none';
        }
    });

    document.getElementById('cover_type_url').addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('cover_file_input').style.display = 'none';
            document.getElementById('cover_url_input').style.display = 'block';
        }
    });

    // Generate random ISBN
    function generateISBN() {
        // Generate ISBN-13 format: 978-X-XX-XXXXXX-X
        const prefix = '978';
        const group = Math.floor(Math.random() * 10);
        const publisher = Math.floor(Math.random() * 100).toString().padStart(2, '0');
        const title = Math.floor(Math.random() * 1000000).toString().padStart(6, '0');
        const checkDigit = Math.floor(Math.random() * 10);

        const isbn = `${prefix}-${group}-${publisher}-${title}-${checkDigit}`;
        document.getElementById('isbn').value = isbn;
    }
</script>
@endsection
