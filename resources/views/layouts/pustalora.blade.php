<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pustalora - Sistem Peminjaman Buku')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <x-pustalora-navigation />

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="container mt-4">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mt-4">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-purple-gradient rounded-3 p-2 me-3">
                            <i class="bi bi-book text-white fs-4"></i>
                        </div>
                        <span class="fs-4 fw-bold text-purple">Pustalora</span>
                    </div>
                    <p class="text-muted">
                        Sistem peminjaman buku modern dan elegan untuk memudahkan Anda dalam mengelola dan meminjam buku favorit Anda.
                    </p>
                    <div class="d-flex gap-2 mt-3">
                        <a href="#" class="btn btn-sm btn-outline-primary rounded-circle">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-primary rounded-circle">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="btn btn-sm btn-outline-primary rounded-circle">
                            <i class="bi bi-linkedin"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Menu</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Beranda</a></li>
                        <li class="mb-2"><a href="{{ route('books.index') }}" class="text-muted text-decoration-none">Katalog Buku</a></li>
                        @auth
                            <li class="mb-2"><a href="{{ route('loans.index') }}" class="text-muted text-decoration-none">Peminjaman Saya</a></li>
                        @endauth
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Bantuan</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Cara Peminjaman</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">FAQ</a></li>
                        <li class="mb-2"><a href="#" class="text-muted text-decoration-none">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h5>Hubungi Kami</h5>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> Jakarta, Indonesia</li>
                        <li class="mb-2"><i class="bi bi-envelope me-2"></i> info@pustalora.com</li>
                        <li class="mb-2"><i class="bi bi-telephone me-2"></i> +62 21 1234 5678</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center text-muted">
                <p class="mb-0">&copy; {{ date('Y') }} Pustalora. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
