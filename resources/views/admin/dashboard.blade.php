<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold" style="color: #1a1a2e;">
            <i class="fas fa-cog me-2" style="color: #06b6d4;"></i>Dashboard Admin
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

            <!-- Add Book Section -->
            <div class="card shadow-lg border-0 mb-5" style="border-radius: 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="card-header border-0" style="background: rgba(255,255,255,0.1); border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Buku Baru
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-3">
                                <input type="text" name="title" class="form-control bg-white border-0" placeholder="Judul Buku" required style="border-radius: 8px;">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="author" class="form-control bg-white border-0" placeholder="Penulis" required style="border-radius: 8px;">
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <input type="text" name="isbn" id="isbnInput" class="form-control bg-white border-0" placeholder="ISBN" style="border-radius: 8px 0 0 8px;">
                                    <button type="button" class="btn btn-outline-secondary" id="generateIsbn" style="border-radius: 0 8px 8px 0;">
                                        <i class="fas fa-random"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="quantity" class="form-control bg-white border-0" placeholder="Jumlah" min="1" value="1" required style="border-radius: 8px;">
                            </div>
                            <div class="col-md-2">
                                <input type="file" name="image" class="form-control bg-white border-0" accept="image/*" style="border-radius: 8px;">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn w-100" style="background: linear-gradient(45deg, #06b6d4, #0891b2); border: none; color: white; border-radius: 8px;">
                                    <i class="fas fa-plus me-1"></i>Tambah Buku
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Books Management -->
            <div class="card shadow-lg border-0 mb-5" style="border-radius: 15px; background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0">
                        <i class="fas fa-book me-2"></i>Kelola Koleksi Buku
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                <tr>
                                    <th><i class="fas fa-hashtag me-1"></i>ID</th>
                                    <th><i class="fas fa-image me-1"></i>Gambar</th>
                                    <th><i class="fas fa-book me-1"></i>Judul</th>
                                    <th><i class="fas fa-user me-1"></i>Penulis</th>
                                    <th><i class="fas fa-barcode me-1"></i>ISBN</th>
                                    <th><i class="fas fa-boxes me-1"></i>Stok</th>
                                    <th><i class="fas fa-info-circle me-1"></i>Tersedia</th>
                                    <th><i class="fas fa-cogs me-1"></i>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($books as $book)
                                <tr>
                                    <td class="fw-semibold">{{ $book->id }}</td>
                                    <td>
                                        @if($book->image)
                                            <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <i class="fas fa-image text-muted" style="font-size: 2rem;"></i>
                                        @endif
                                    </td>
                                    <td class="fw-semibold">{{ $book->title }}</td>
                                    <td>{{ $book->author }}</td>
                                    <td><code>{{ $book->isbn ?: 'N/A' }}</code></td>
                                    <td>
                                        <span class="badge" style="background: linear-gradient(45deg, #8b5cf6, #7c3aed);">
                                            <i class="fas fa-box me-1"></i>{{ $book->quantity }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($book->isAvailable())
                                            <span class="badge" style="background: linear-gradient(45deg, #10b981, #059669);">
                                                <i class="fas fa-check me-1"></i>{{ $book->available_quantity }} tersedia
                                            </span>
                                        @else
                                            <span class="badge" style="background: linear-gradient(45deg, #ef4444, #dc2626);">
                                                <i class="fas fa-times me-1"></i>Habis
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm me-1 edit-btn" style="background: linear-gradient(45deg, #f59e0b, #d97706); border: none; color: white;" data-id="{{ $book->id }}" data-title="{{ $book->title }}" data-author="{{ $book->author }}" data-isbn="{{ $book->isbn }}" data-quantity="{{ $book->quantity }}" data-image="{{ $book->image }}">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </button>
                                        <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm" style="background: linear-gradient(45deg, #ef4444, #dc2626); border: none; color: white;" onclick="return confirm('Yakin hapus buku ini?')">
                                                <i class="fas fa-trash me-1"></i>Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Loans Management -->
            <div class="card shadow-lg border-0" style="border-radius: 15px; background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>Riwayat Peminjaman
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead style="background: linear-gradient(135deg, #06b6d4, #0891b2); color: white;">
                                <tr>
                                    <th><i class="fas fa-hashtag me-1"></i>ID</th>
                                    <th><i class="fas fa-user me-1"></i>Peminjam</th>
                                    <th><i class="fas fa-book me-1"></i>Buku</th>
                                    <th><i class="fas fa-copy me-1"></i>Copy</th>
                                    <th><i class="fas fa-calendar-plus me-1"></i>Tanggal Pinjam</th>
                                    <th><i class="fas fa-calendar-check me-1"></i>Tanggal Kembali</th>
                                    <th><i class="fas fa-info-circle me-1"></i>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loans as $loan)
                                <tr>
                                    <td class="fw-semibold">{{ $loan->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user-circle me-2" style="color: #06b6d4;"></i>
                                            {{ $loan->user->name }}
                                        </div>
                                    </td>
                                    <td class="fw-semibold">{{ $loan->book->title }}</td>
                                    <td>
                                        <span class="badge" style="background: linear-gradient(45deg, #8b5cf6, #7c3aed);">
                                            <i class="fas fa-hashtag me-1"></i>{{ $loan->copy_number }}
                                        </span>
                                    </td>
                                    <td>{{ $loan->borrowed_at->format('d/m/Y') }}</td>
                                    <td>{{ $loan->returned_at ? $loan->returned_at->format('d/m/Y') : '-' }}</td>
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
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Book Modal -->
    <div class="modal fade" id="editBookModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0" style="border-radius: 15px; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
                <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Edit Buku
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editBookForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color: #1a1a2e;">Judul Buku</label>
                                <input type="text" name="title" class="form-control border-0" id="editTitle" required style="border-radius: 8px; background: #f8fafc;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color: #1a1a2e;">Penulis</label>
                                <input type="text" name="author" class="form-control border-0" id="editAuthor" required style="border-radius: 8px; background: #f8fafc;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color: #1a1a2e;">ISBN</label>
                                <input type="text" name="isbn" class="form-control border-0" id="editIsbn" style="border-radius: 8px; background: #f8fafc;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" style="color: #1a1a2e;">Jumlah Stok</label>
                                <input type="number" name="quantity" class="form-control border-0" id="editQuantity" min="1" required style="border-radius: 8px; background: #f8fafc;">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-semibold" style="color: #1a1a2e;">Gambar Buku (Opsional)</label>
                                <input type="file" name="image" class="form-control border-0" id="editImage" accept="image/*" style="border-radius: 8px; background: #f8fafc;">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn" style="background: linear-gradient(45deg, #06b6d4, #0891b2); border: none; color: white; border-radius: 8px;">
                            <i class="fas fa-save me-1"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // ISBN Generation Function
        function generateISBN() {
            const timestamp = Date.now().toString();
            const random = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
            const isbn = timestamp.slice(-9) + random;
            return isbn;
        }

        document.addEventListener('DOMContentLoaded', function() {
            // ISBN Generator
            document.getElementById('generateIsbn').addEventListener('click', function() {
                document.getElementById('isbnInput').value = generateISBN();
            });
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const title = this.getAttribute('data-title');
                    const author = this.getAttribute('data-author');
                    const isbn = this.getAttribute('data-isbn');
                    const quantity = this.getAttribute('data-quantity');
                    const image = this.getAttribute('data-image');

                    document.getElementById('editBookForm').action = `/admin/books/${id}`;
                    document.getElementById('editTitle').value = title;
                    document.getElementById('editAuthor').value = author;
                    document.getElementById('editIsbn').value = isbn;
                    document.getElementById('editQuantity').value = quantity;
                    // Clear the file input since we can't set a value for security reasons
                    document.getElementById('editImage').value = '';

                    new bootstrap.Modal(document.getElementById('editBookModal')).show();
                });
            });
        });
    </script>
</x-app-layout>