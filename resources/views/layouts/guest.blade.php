<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pustalora - Login')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <!-- Logo -->
                <div class="text-center mb-4">
                    <a href="{{ route('home') }}" class="text-decoration-none">
                        <div class="bg-purple-gradient rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-book text-white fs-2"></i>
                        </div>
                        <h2 class="text-purple fw-bold">Pustalora</h2>
                    </a>
                </div>

                <!-- Card -->
                <div class="card shadow-lg">
                    <div class="card-body p-4">
                        {{ $slot }}
                    </div>
                </div>

                <!-- Back to Home -->
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="text-decoration-none text-muted">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
