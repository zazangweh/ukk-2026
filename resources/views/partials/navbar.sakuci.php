<nav class="navbar navbar-expand-lg bg-body border-bottom sticky-top shadow-sm py-3">
    <div class="container">
        <!-- Brand & Status Database -->
        <div class="d-flex align-items-center gap-3">
            @php
                $dbConnected = false;
                try {
                    \Sakuci\Database\Connection::pdo();
                    $dbConnected = true;
                } catch (\Throwable $e) {
                    $dbConnected = false;
                }
            @endphp
            
            <!-- Tombol Tema & Indikator Database -->
            <button id="themeToggle" type="button" class="logo-toggle btn p-0 border-0 bg-transparent position-relative"
                    aria-label="Ganti tema terang/gelap (status database: {{ $dbConnected ? 'terhubung' : 'tidak terhubung' }})"
                    title="Ganti tema terang/gelap">
                <svg width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" style="display: block;" aria-hidden="true">
                    <circle class="logo-ring" cx="16" cy="16" r="15" stroke="currentColor" stroke-width="1.5" fill="none"/>
                    <circle cx="16" cy="16" r="9" fill="{{ $dbConnected ? '#198754' : '#dc3545' }}"/>
                </svg>
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-{{ $dbConnected ? 'success' : 'danger' }} border border-light rounded-circle" style="font-size: 0.4rem;">
                    <span class="visually-hidden">Status DB</span>
                </span>
            </button>

            <!-- Logo / Nama Aplikasi dengan Ikon Estetik -->
            <a class="navbar-brand fw-bold m-0 d-flex align-items-center gap-2 text-dark" href="{{ route('home') }}">
                <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="bi bi-tools fs-6"></i>
                </div>
                <div>
                    <span class="fs-6 d-block lh-1">{{ config('app.name') }}</span>
                    <small class="text-muted fw-normal" style="font-size: 0.7rem;">Sarana & Prasarana</small>
                </div>
            </a>
        </div>

        <!-- Toggler untuk Mobile -->
        <button class="navbar-toggler border-0 shadow-none" type="button"
                data-bs-toggle="collapse" data-bs-target="#menuUtama"
                aria-controls="menuUtama" aria-expanded="false" aria-label="Buka menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu Utama -->
        <div class="collapse navbar-collapse" id="menuUtama">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2 mt-3 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link px-3 rounded-pill {{ is_route('home') ? 'active fw-semibold text-primary bg-primary bg-opacity-10' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-house-door me-1"></i> Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 rounded-pill {{ is_route('kategori.index') ? 'active fw-semibold text-primary bg-primary bg-opacity-10' : '' }}" href="{{ route('kategori.index') }}">
                        <i class="bi bi-grid me-1"></i> Kategori
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 rounded-pill {{ is_route('pengguna.index') ? 'active fw-semibold text-primary bg-primary bg-opacity-10' : '' }}" href="{{ route('pengguna.index') }}">
                        <i class="bi bi-people me-1"></i> Pengguna
                    </a>
                </li>
                
                @php
                    $currentUser = \App\Models\User::current();
                @endphp
                
                @if ($currentUser)
                    <li class="nav-item">
                        <a class="nav-link px-3 rounded-pill {{ is_route('admin.dashboard', 'dashboard') ? 'active fw-semibold text-primary bg-primary bg-opacity-10' : '' }}"
                           href="{{ $currentUser->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <form method="POST" action="{{ route('logout') }}" class="d-lg-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-outline-danger w-100 rounded-pill px-3 d-flex align-items-center justify-content-center gap-1">
                                <i class="bi bi-box-arrow-right"></i> Keluar ({{ $currentUser->username }})
                            </button>
                        </form>
                    </li>
                @else
                    @php
                        $canRegister = false;
                        if ($dbConnected) {
                            try {
                                $canRegister = \App\Models\Role::where('can_register', 1)->exists();
                            } catch (\Throwable $e) {
                                $canRegister = false;
                            }
                        }
                    @endphp
                    
                    @if ($canRegister)
                        <li class="nav-item">
                            <a class="nav-link px-3 rounded-pill {{ is_route('register') ? 'active fw-semibold text-primary bg-primary bg-opacity-10' : '' }}" href="{{ route('register') }}">
                                Daftar
                            </a>
                        </li>
                    @endif
                    
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-sm btn-primary rounded-pill px-4 d-inline-flex align-items-center gap-2 shadow-sm py-2" href="{{ route('login') }}">
                            <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="8" cy="5" r="3" fill="currentColor" stroke="none"/>
                                <path d="M2.5 14c0-3.6 2.9-5.8 5.5-5.8s5.5 2.2 5.5 5.8"/>
                            </svg>
                            Masuk
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>