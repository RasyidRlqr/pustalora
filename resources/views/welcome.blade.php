<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Pustalora - Aplikasi Pinjaman Buku</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); min-height: 100vh;">
        <style>
            .bg-gradient-purple {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            .bg-gradient-dark {
                background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            }
            .text-glow {
                text-shadow: 0 0 20px rgba(0, 255, 255, 0.5);
            }
            .btn-glow {
                box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
                transition: all 0.3s ease;
            }
            .btn-glow:hover {
                box-shadow: 0 0 30px rgba(0, 255, 255, 0.6);
                transform: translateY(-2px);
            }
            .btn-cyan {
                background: linear-gradient(45deg, #00bcd4, #0097a7);
                border: none;
                color: white;
            }
            .btn-cyan:hover {
                background: linear-gradient(45deg, #00acc1, #00838f);
                color: white;
            }
            .hover-glow:hover {
                text-shadow: 0 0 10px rgba(0, 255, 255, 0.5);
            }
            .feature-card {
                transition: all 0.3s ease;
                border: 1px solid rgba(0, 255, 255, 0.2);
            }
            .feature-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 30px rgba(0, 255, 255, 0.2);
                border-color: rgba(0, 255, 255, 0.5);
            }
            .floating-book {
                animation: float 3s ease-in-out infinite;
            }
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }
            .min-vh-75 {
                min-height: 75vh;
            }
        </style>

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-transparent position-fixed w-100" style="z-index: 1000; backdrop-filter: blur(10px);">
            <div class="container">
                <a class="navbar-brand fw-bold" href="/" style="font-size: 1.5rem;">
                    <span style="color: #a855f7;">Pusta</span><span style="color: #06b6d4;">lora</span>
                </a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#features" style="color: rgba(255,255,255,0.8);">Fitur</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about" style="color: rgba(255,255,255,0.8);">Tentang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contact" style="color: rgba(255,255,255,0.8);">Kontak</a>
                        </li>
                        @if (Route::has('login'))
                            <li class="nav-item ms-3">
                                <a href="{{ route('login') }}" class="btn btn-outline-light me-2" style="border-color: rgba(255,255,255,0.3); color: white;">Masuk</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="btn text-white" style="background: linear-gradient(45deg, #06b6d4, #0891b2);">Daftar</a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="py-5" style="padding-top: 100px;">
            <div class="container">
                <div class="row align-items-center" style="min-height: 75vh;">
                    <div class="col-lg-6" style="color: white;">
                        <h1 class="display-4 fw-bold mb-4" style="text-shadow: 0 0 20px rgba(6, 182, 212, 0.5);">
                            Selamat Datang di <span style="color: #06b6d4;">Pustalora</span>
                        </h1>
                        <p class="lead mb-4" style="color: rgba(255,255,255,0.8);">
                            Platform pinjaman buku digital terpercaya. Temukan ribuan koleksi buku berkualitas dengan sistem peminjaman yang mudah dan cepat.
                        </p>
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="{{ route('register') }}" class="btn btn-lg px-4 py-3" style="background: linear-gradient(45deg, #06b6d4, #0891b2); border: none; color: white; box-shadow: 0 0 20px rgba(6, 182, 212, 0.3);">
                                <i class="fas fa-rocket me-2"></i>Mulai Sekarang
                            </a>
                            <a href="#features" class="btn btn-lg btn-outline-light px-4 py-3" style="border-color: rgba(255,255,255,0.3); color: white;">
                                <i class="fas fa-info-circle me-2"></i>Pelajari Lebih Lanjut
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center mt-5 mt-lg-0">
                        <div style="animation: float 3s ease-in-out infinite;">
                            <i class="fas fa-book-open" style="font-size: 8rem; color: #06b6d4; filter: drop-shadow(0 0 20px rgba(6, 182, 212, 0.5));"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-5" style="background: rgba(0,0,0,0.3);">
            <div class="container">
                <div class="row text-center mb-5">
                    <div class="col-12">
                        <h2 class="mb-3" style="color: white;">Mengapa Memilih Pustalora?</h2>
                        <p class="lead" style="color: rgba(255,255,255,0.7);">Nikmati pengalaman peminjaman buku yang modern dan efisien</p>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 border-0" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1)); border: 1px solid rgba(6, 182, 212, 0.2); transition: all 0.3s ease;">
                            <div class="card-body text-center text-white p-4">
                                <i class="fas fa-infinity mb-3" style="font-size: 3rem; color: #06b6d4;"></i>
                                <h5 class="card-title">Koleksi Lengkap</h5>
                                <p class="card-text" style="color: rgba(255,255,255,0.8);">Ribuan buku dari berbagai genre dan kategori tersedia untuk Anda</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1)); border: 1px solid rgba(6, 182, 212, 0.2); transition: all 0.3s ease;">
                            <div class="card-body text-center text-white p-4">
                                <i class="fas fa-bolt mb-3" style="font-size: 3rem; color: #06b6d4;"></i>
                                <h5 class="card-title">Proses Cepat</h5>
                                <p class="card-text" style="color: rgba(255,255,255,0.8);">Peminjaman buku dalam hitungan detik tanpa antrian panjang</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-0" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1)); border: 1px solid rgba(6, 182, 212, 0.2); transition: all 0.3s ease;">
                            <div class="card-body text-center text-white p-4">
                                <i class="fas fa-shield-alt mb-3" style="font-size: 3rem; color: #06b6d4;"></i>
                                <h5 class="card-title">Aman & Terpercaya</h5>
                                <p class="card-text" style="color: rgba(255,255,255,0.8);">Sistem keamanan tinggi dengan tracking peminjaman real-time</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-5" style="background: linear-gradient(135deg, rgba(6, 182, 212, 0.1), rgba(139, 92, 246, 0.1));">
            <div class="container text-center">
                <h2 class="mb-4" style="color: white;">Siap Memulai Petualangan Membaca?</h2>
                <p class="mb-4 lead" style="color: rgba(255,255,255,0.8);">Bergabunglah dengan ribuan pengguna yang telah mempercayai Pustalora</p>
                <a href="{{ route('register') }}" class="btn btn-lg px-5 py-3" style="background: linear-gradient(45deg, #06b6d4, #0891b2); border: none; color: white; box-shadow: 0 0 20px rgba(6, 182, 212, 0.3);">
                    <i class="fas fa-user-plus me-2"></i>Daftar Sekarang - Gratis!
                </a>
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-4 text-center" style="color: rgba(255,255,255,0.6);">
            <div class="container">
                <p class="mb-0">&copy; 2024 Pustalora. All rights reserved.</p>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
