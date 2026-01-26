<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold" style="color: #1a1a2e;">
            <i class="fas fa-user-edit me-2" style="color: #06b6d4;"></i>Edit Profil
        </h2>
    </x-slot>

    <div class="py-12" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert" style="border-left: 4px solid #06b6d4;">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0" style="border-radius: 15px; background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);">
                        <div class="card-header border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0;">
                            <h5 class="mb-0">
                                <i class="fas fa-id-card me-2"></i>Informasi Profil Lengkap
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <p class="text-muted mb-4">
                                <i class="fas fa-info-circle me-1"></i>
                                Lengkapi profil Anda untuk dapat meminjam buku. Semua field wajib diisi.
                            </p>

                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-lg border-0 mb-4" style="border-radius: 15px; background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);">
                        <div class="card-header border-0" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white; border-radius: 15px 15px 0 0;">
                            <h6 class="mb-0">
                                <i class="fas fa-key me-2"></i>Ubah Kata Sandi
                            </h6>
                        </div>
                        <div class="card-body p-3">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <div class="card shadow-lg border-0" style="border-radius: 15px; background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);">
                        <div class="card-header border-0 bg-danger text-white" style="border-radius: 15px 15px 0 0;">
                            <h6 class="mb-0">
                                <i class="fas fa-exclamation-triangle me-2"></i>Zone Bahaya
                            </h6>
                        </div>
                        <div class="card-body p-3">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
