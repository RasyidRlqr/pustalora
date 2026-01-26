<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.95), rgba(118, 75, 162, 0.95)); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(6, 182, 212, 0.3);">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}" style="font-size: 1.3rem;">
            <span style="color: #a855f7; text-shadow: 0 0 10px rgba(168, 85, 247, 0.5);">Pusta</span><span style="color: #06b6d4; text-shadow: 0 0 10px rgba(6, 182, 212, 0.5);">lora</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="border: 1px solid rgba(255,255,255,0.2);">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}" style="color: rgba(255,255,255,0.9); transition: all 0.3s ease;">
                        <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                    </a>
                </li>
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}" style="color: rgba(255,255,255,0.9); transition: all 0.3s ease;">
                            <i class="fas fa-cog me-1"></i>Admin Panel
                        </a>
                    </li>
                @endif
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" style="color: white;">
                        <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px); border: 1px solid rgba(6, 182, 212, 0.2);">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}" style="color: #1a1a2e;">
                            <i class="fas fa-user-edit me-2" style="color: #06b6d4;"></i>Profile
                        </a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item" style="color: #dc2626;">
                                    <i class="fas fa-sign-out-alt me-2"></i>Log Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
