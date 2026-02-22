<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <i class="bi bi-book me-2"></i>Pustalora
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-house-door me-1"></i>Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}" href="{{ route('books.index') }}">
                        <i class="bi bi-book me-1"></i>Katalog Buku
                    </a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('loans.*') ? 'active' : '' }}" href="{{ route('loans.index') }}">
                            <i class="bi bi-bookmark me-1"></i>Peminjaman Saya
                        </a>
                    </li>
                    @if(auth()->user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-gear me-1"></i>Admin
                            </a>
                        </li>
                    @endif
                @endauth
            </ul>
            <div class="d-flex align-items-center">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">
                        <i class="bi bi-box-arrow-in-right me-1"></i>Masuk
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i class="bi bi-person-plus me-1"></i>Daftar
                    </a>
                @else
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="bg-purple-gradient rounded-circle d-flex align-items-center justify-content-center text-white fw-bold me-2" style="width: 40px; height: 40px;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
