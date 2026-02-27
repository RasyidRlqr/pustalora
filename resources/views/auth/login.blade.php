<x-guest-layout>
    @section('title', 'Masuk - Pustalora')

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-info mb-4">
            {{ session('status') }}
        </div>
    @endif

    <h4 class="text-center mb-4">Selamat Datang Kembali</h4>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-envelope"></i>
                </span>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@email.com">
            </div>
            @error('email')
                <div class="text-danger mt-1 small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-lock"></i>
                </span>
                <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password" placeholder="Masukkan password">
                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                    <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                </button>
            </div>
            @error('password')
                <div class="text-danger mt-1 small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                <label class="form-check-label" for="remember">
                    Ingat saya
                </label>
            </div>
        </div>

        <!-- Forgot Password -->
        @if (Route::has('password.request'))
            <div class="mb-4 text-end">
                <a href="{{ route('password.request') }}" class="text-decoration-none text-purple">
                    Lupa password?
                </a>
            </div>
        @endif

    <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
        </button>
    </form>

    <!-- Social Login Buttons -->
    <div class="mt-4">
        <div class="d-flex align-items-center">
            <hr class="flex-grow-1">
            <span class="px-2 text-muted small">atau</span>
            <hr class="flex-grow-1">
        </div>
    </div>

    <div class="d-flex gap-2 mt-3">
        <a href="{{ route('socialite.redirect', 'google') }}" class="btn btn-outline-secondary flex-fill text-decoration-none">
            <i class="bi bi-google me-2"></i>Google
        </a>
        <a href="{{ route('socialite.redirect', 'facebook') }}" class="btn btn-outline-secondary flex-fill text-decoration-none">
            <i class="bi bi-facebook me-2"></i>Facebook
        </a>
    </div>

    <!-- Register Link -->
    <div class="text-center mt-4">
        <p class="mb-0">Belum punya akun? <a href="{{ route('register') }}" class="text-decoration-none text-purple fw-bold">Daftar sekarang</a></p>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
    </script>
</x-guest-layout>
