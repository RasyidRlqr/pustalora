<x-guest-layout>
    <div class="text-center mb-4">
        <h2 class="fw-bold mb-2" style="color: #1a1a2e;">
            <i class="fas fa-sign-in-alt me-2" style="color: #06b6d4;"></i>Masuk ke Akun Anda
        </h2>
        <p class="text-muted">Selamat datang kembali! Masukkan kredensial Anda untuk melanjutkan.</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold" style="color: #1a1a2e;">
                <i class="fas fa-envelope me-2" style="color: #06b6d4;"></i>Email
            </label>
            <input id="email" class="form-control form-control-lg" style="border-radius: 10px; border: 2px solid #e2e8f0;" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Masukkan email Anda">
            @error('email')
                <div class="text-danger mt-2">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold" style="color: #1a1a2e;">
                <i class="fas fa-lock me-2" style="color: #06b6d4;"></i>Kata Sandi
            </label>
            <input id="password" class="form-control form-control-lg" style="border-radius: 10px; border: 2px solid #e2e8f0;" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi Anda">
            @error('password')
                <div class="text-danger mt-2">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-4">
            <div class="form-check">
                <input id="remember_me" type="checkbox" class="form-check-input" name="remember" style="border-color: #06b6d4;">
                <label for="remember_me" class="form-check-label" style="color: #64748b;">
                    Ingat saya
                </label>
            </div>
        </div>

        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-auth btn-lg">
                <i class="fas fa-sign-in-alt me-2"></i>Masuk
            </button>
        </div>

        <div class="text-center">
            @if (Route::has('password.request'))
                <p class="mb-2">
                    <a href="{{ route('password.request') }}" class="auth-link">
                        <i class="fas fa-key me-1"></i>Lupa kata sandi?
                    </a>
                </p>
            @endif
            <p class="mb-0" style="color: #64748b;">
                Belum punya akun?
                <a href="{{ route('register') }}" class="auth-link fw-bold">
                    <i class="fas fa-user-plus me-1"></i>Daftar sekarang
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
