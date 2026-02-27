 <x-guest-layout>
    @section('title', 'Daftar - Pustalora')

    <h4 class="text-center mb-4">Buat Akun Baru</h4>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-person"></i>
                </span>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap">
            </div>
            @error('name')
                <div class="text-danger mt-1 small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-envelope"></i>
                </span>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@email.com">
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
                <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                    <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
                </button>
            </div>
            @error('password')
                <div class="text-danger mt-1 small">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-lock-fill"></i>
                </span>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password">
                <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirmation">
                    <i class="bi bi-eye-slash" id="togglePasswordConfirmationIcon"></i>
                </button>
            </div>
            @error('password_confirmation')
                <div class="text-danger mt-1 small">{{ $message }}</div>
            @enderror
        </div>

    <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-100">
            <i class="bi bi-person-plus me-2"></i>Daftar
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

    <!-- Login Link -->
    <div class="text-center mt-4">
        <p class="mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none text-purple fw-bold">Masuk sekarang</a></p>
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

        document.getElementById('togglePasswordConfirmation').addEventListener('click', function() {
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const icon = document.getElementById('togglePasswordConfirmationIcon');
            
            if (passwordConfirmationInput.type === 'password') {
                passwordConfirmationInput.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                passwordConfirmationInput.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
    </script>
</x-guest-layout>
