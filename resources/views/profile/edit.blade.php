@extends('layouts.pustalora')

@section('title', 'Profil Saya - Pustalora')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profil Saya</li>
                </ol>
            </nav>
            <h1 class="page-title">Profil Saya</h1>
            <p class="text-muted">Kelola informasi akun dan keamanan Anda</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Profile Information -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-purple-gradient text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-person me-2"></i>Informasi Profil</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}" class="row g-3">
                        @csrf
                        @method('PATCH')

                        <div class="col-md-6">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required autofocus autocomplete="name">
                            @error('name')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required autocomplete="username">
                            @error('email')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                Email Anda saat ini: <strong>{{ auth()->user()->email }}</strong>
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Update Password -->
            <div class="card mt-4">
                <div class="card-header bg-purple-gradient text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-shield-lock me-2"></i>Ubah Password</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}" class="row g-3">
                        @csrf
                        @method('PUT')

                        <div class="col-12">
                            <label for="current_password" class="form-label">Password Saat Ini</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required autocomplete="current-password">
                            @error('current_password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password">
                            @error('password')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-shield-check me-2"></i>Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- User Info & Delete Account -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="bg-purple-gradient rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                        <i class="bi bi-person-fill text-white" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title">{{ auth()->user()->name }}</h5>
                    <p class="card-text text-muted">{{ auth()->user()->email }}</p>
                    <span class="badge badge-primary">
                        <i class="bi bi-shield-check me-1"></i>{{ ucfirst(auth()->user()->role) }}
                    </span>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Hapus Akun</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Setelah akun Anda dihapus, semua data dan sumber daya akan dihapus secara permanen.</p>
                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="bi bi-trash me-2"></i>Hapus Akun
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus Akun</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('profile.destroy') }}" class="modal-body">
                @csrf
                @method('DELETE')

                <p class="mb-3">Apakah Anda yakin ingin menghapus akun Anda? Setelah dihapus, semua data akan hilang secara permanen.</p>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
                    @error('password')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Hapus Akun
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
