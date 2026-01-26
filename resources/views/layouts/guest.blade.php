<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Pustalora') }}</title>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <style>
            .auth-bg {
                background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
                min-height: 100vh;
            }
            .auth-card {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(20px);
                border: 1px solid rgba(6, 182, 212, 0.2);
                border-radius: 20px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            }
            .brand-logo {
                font-size: 2.5rem;
                font-weight: bold;
                text-shadow: 0 0 20px rgba(6, 182, 212, 0.5);
            }
            .form-control:focus {
                border-color: #06b6d4;
                box-shadow: 0 0 0 0.2rem rgba(6, 182, 212, 0.25);
            }
            .btn-auth {
                background: linear-gradient(45deg, #06b6d4, #0891b2);
                border: none;
                color: white;
                border-radius: 10px;
                padding: 12px 30px;
                font-weight: 600;
                transition: all 0.3s ease;
            }
            .btn-auth:hover {
                background: linear-gradient(45deg, #0891b2, #0ea5e9);
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(6, 182, 212, 0.3);
            }
            .auth-link {
                color: #06b6d4;
                text-decoration: none;
                font-weight: 500;
            }
            .auth-link:hover {
                color: #0891b2;
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div class="auth-bg d-flex flex-column justify-content-center align-items-center py-5">
            <div class="text-center mb-4">
                <a href="/" class="brand-logo text-decoration-none">
                    <span style="color: #a855f7;">Pusta</span><span style="color: #06b6d4;">lora</span>
                </a>
                <p class="text-white-50 mt-2 mb-0">Aplikasi Pinjaman Buku</p>
            </div>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-5">
                        <div class="auth-card p-4 p-md-5">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
