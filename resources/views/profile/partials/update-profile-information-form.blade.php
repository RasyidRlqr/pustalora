<div>
    <form method="post" action="{{ route('profile.update') }}">
        @csrf

        <div class="row g-3">
            <!-- Name -->
            <div class="col-md-6">
                <label for="name" class="form-label fw-semibold" style="color: #1a1a2e;">
                    <i class="fas fa-user me-2" style="color: #06b6d4;"></i>Nama Lengkap
                </label>
                <input id="name" name="name" type="text" class="form-control border-0" style="border-radius: 10px; background: #f8fafc;" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name')
                    <div class="text-danger mt-2">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Email -->
            <div class="col-md-6">
                <label for="email" class="form-label fw-semibold" style="color: #1a1a2e;">
                    <i class="fas fa-envelope me-2" style="color: #06b6d4;"></i>Email
                </label>
                <input id="email" name="email" type="email" class="form-control border-0" style="border-radius: 10px; background: #f8fafc;" value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email')
                    <div class="text-danger mt-2">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <!-- NIK -->
            <div class="col-md-6">
                <label for="nik" class="form-label fw-semibold" style="color: #1a1a2e;">
                    <i class="fas fa-id-card me-2" style="color: #06b6d4;"></i>NIK (Nomor Induk Kependudukan)
                </label>
                <input id="nik" name="nik" type="text" class="form-control border-0" style="border-radius: 10px; background: #f8fafc;" value="{{ old('nik', $user->nik) }}" maxlength="16" pattern="[0-9]{16}" placeholder="16 digit NIK" required>
                @error('nik')
                    <div class="text-danger mt-2">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Phone -->
            <div class="col-md-6">
                <label for="phone" class="form-label fw-semibold" style="color: #1a1a2e;">
                    <i class="fas fa-phone me-2" style="color: #06b6d4;"></i>Nomor Telepon
                </label>
                <input id="phone" name="phone" type="tel" class="form-control border-0" style="border-radius: 10px; background: #f8fafc;" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890" required>
                @error('phone')
                    <div class="text-danger mt-2">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Address -->
            <div class="col-12">
                <label for="address" class="form-label fw-semibold" style="color: #1a1a2e;">
                    <i class="fas fa-map-marker-alt me-2" style="color: #06b6d4;"></i>Alamat Lengkap
                </label>
                <textarea id="address" name="address" class="form-control border-0" style="border-radius: 10px; background: #f8fafc; min-height: 80px;" placeholder="Masukkan alamat lengkap Anda" required>{{ old('address', $user->address) }}</textarea>
                @error('address')
                    <div class="text-danger mt-2">
                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <!-- Profile Completion Status -->
        <div class="mt-4 p-3 rounded" style="background: rgba(6, 182, 212, 0.1); border: 1px solid rgba(6, 182, 212, 0.2);">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle me-2" style="color: #06b6d4;"></i>
                <div>
                    <strong style="color: #1a1a2e;">Status Profil:</strong>
                    @if($user->isProfileComplete())
                        <span class="badge" style="background: linear-gradient(45deg, #10b981, #059669);">
                            <i class="fas fa-check me-1"></i>Lengkap - Siap Meminjam Buku
                        </span>
                    @else
                        <span class="badge" style="background: linear-gradient(45deg, #f59e0b, #d97706);">
                            <i class="fas fa-exclamation-triangle me-1"></i>Belum Lengkap
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn" style="background: linear-gradient(45deg, #06b6d4, #0891b2); border: none; color: white; border-radius: 10px; padding: 12px 30px;">
                <i class="fas fa-save me-2"></i>Simpan Perubahan
            </button>
            @if($errors->any())
                <div class="mt-3">
                    <div class="alert alert-danger">
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </form>
</div>
