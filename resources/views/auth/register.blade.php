<x-guest-layout>
    <div class="text-center mb-4">
        <h2 class="fw-bold mb-2" style="color: #1a1a2e;">
            <i class="fas fa-user-plus me-2" style="color: #06b6d4;"></i>Buat Akun Baru
        </h2>
        <p class="text-muted">Bergabunglah dengan Pustalora dan mulai menjelajahi dunia buku!</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold" style="color: #1a1a2e;">
                <i class="fas fa-user me-2" style="color: #06b6d4;"></i>Nama Lengkap
            </label>
            <input id="name" class="form-control form-control-lg" style="border-radius: 10px; border: 2px solid #e2e8f0;" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap Anda">
            @error('name')
                <div class="text-danger mt-2">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold" style="color: #1a1a2e;">
                <i class="fas fa-envelope me-2" style="color: #06b6d4;"></i>Email
            </label>
            <input id="email" class="form-control form-control-lg" style="border-radius: 10px; border: 2px solid #e2e8f0;" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Masukkan alamat email Anda">
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
            <input id="password" class="form-control form-control-lg" style="border-radius: 10px; border: 2px solid #e2e8f0;" type="password" name="password" required autocomplete="new-password" placeholder="Buat kata sandi yang kuat">
            @error('password')
                <div class="text-danger mt-2">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-semibold" style="color: #1a1a2e;">
                <i class="fas fa-lock me-2" style="color: #06b6d4;"></i>Konfirmasi Kata Sandi
            </label>
            <input id="password_confirmation" class="form-control form-control-lg" style="border-radius: 10px; border: 2px solid #e2e8f0;" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Konfirmasi kata sandi Anda">
            @error('password_confirmation')
                <div class="text-danger mt-2">
                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                </div>
            @enderror
        </div>

        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-auth btn-lg">
                <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
            </button>
        </div>

        <div class="text-center">
            <p class="mb-0" style="color: #64748b;">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="auth-link fw-bold">
                    <i class="fas fa-sign-in-alt me-1"></i>Masuk di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
