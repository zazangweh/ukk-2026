<!DOCTYPE html>
<html lang="id" data-bs-theme="auto">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Sarana & Prasarana') }}</title>

    {{-- Bootstrap CSS & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Mencegah konten tertutup scroll offset */
        html {
            scroll-padding-top: 75px;
        }

        /* Layout Utama Flexbox */
        .app-container {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        .main-wrapper {
            display: flex;
            flex: 1;
        }

        /* Styling Sidebar Fixed/Static di Desktop (Large screen) */
        @media (min-width: 992px) {
            .sidebar-desktop {
                width: 280px;
                flex-shrink: 0;
                height: calc(100vh - 60px);
                position: sticky;
                top: 60px;
            }
        }

        .hover-bg {
            transition: background-color 0.2s ease-in-out;
        }
        .hover-bg:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }
        [data-bs-theme="dark"] .hover-bg:hover {
            background-color: rgba(255, 255, 255, 0.08);
        }
    </style>
</head>
<body>

    @php
        $currentUser = \App\Models\User::current();
        
        $dbConnected = false;
        try {
            \Sakuci\Database\Connection::pdo();
            $dbConnected = true;
        } catch (\Throwable $e) {
            $dbConnected = false;
        }
    @endphp

    <div class="app-container">
        {{-- Header Atas / Topbar --}}
        <header class="navbar navbar-expand bg-body border-bottom sticky-top shadow-sm py-2 px-3" style="height: 60px; z-index: 1030;">
            <div class="container-fluid">
                <div class="d-flex align-items-center gap-3">
                    {{-- Tombol Hamburger (HANYA MUNCUL DI LAYAR KECIL / HP) --}}
                    <button class="btn btn-outline-secondary border-0 d-lg-none d-flex align-items-center justify-content-center p-2 rounded-3 text-body" 
                            type="button" 
                            data-bs-toggle="offcanvas" 
                            data-bs-target="#sidebarMenu" 
                            aria-controls="sidebarMenu"
                            aria-label="Buka Menu Sidebar">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>

                    {{-- Nama Aplikasi --}}
                    <a class="navbar-brand fw-bold m-0 d-flex flex-column text-body ms-1" href="{{ route('home') }}">
                        <span class="fs-6 d-block lh-1 fw-bold text-body">{{ config('app.name') }}</span>
                        <small class="text-body-secondary fw-normal mt-1" style="font-size: 0.7rem;">Sarana & Prasarana</small>
                    </a>
                </div>

                {{-- Aksi Kanan Topbar --}}
                <div class="ms-auto d-flex align-items-center gap-2.5">
                    <button id="themeToggle" type="button" class="btn btn-sm btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center p-2 text-body" 
                            title="Ganti Tema Terang/Gelap" style="width: 36px; height: 36px;">
                        <i class="bi bi-moon-stars fs-6"></i>
                    </button>

                    @if ($currentUser)
                        <span class="badge bg-body-tertiary text-body border px-3 py-2 d-none d-sm-inline-flex align-items-center gap-2 fw-semibold">
                            <i class="bi bi-person-circle text-primary me-1"></i> {{ $currentUser->username }}
                        </span>
                    @else
                        <a class="btn btn-sm btn-primary rounded-pill px-3.5 d-inline-flex align-items-center gap-2 shadow-sm py-1.5 fw-semibold" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            <span>Masuk</span>
                        </a>
                    @endif
                </div>
            </div>
        </header>

        <div class="main-wrapper">
            {{-- Sidebar Responsif: Berubah jadi Offcanvas di HP, Tampil Nyamping di Laptop/PC --}}
            <div class="offcanvas-lg offcanvas-start bg-body text-body border-end sidebar-desktop" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                
                {{-- Header Sidebar (Hanya Tampil di Layar HP/Kecil) --}}
                <div class="offcanvas-header border-bottom p-3 d-lg-none">
                    <div>
                        <h5 class="offcanvas-title fs-6 fw-bold text-body lh-1" id="sidebarMenuLabel">{{ config('app.name') }}</h5>
                        <small class="text-body-secondary d-block mt-1" style="font-size: 0.72rem;">Sarana & Prasarana Sekolah</small>
                    </div>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Tutup"></button>
                </div>

                {{-- Isi Navigasi Sidebar --}}
                <div class="offcanvas-body d-flex flex-column justify-content-between p-3 h-100 overflow-y-auto">
                    
                    <ul class="nav nav-pills flex-column gap-1.5">
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ is_route('home') ? 'active fw-semibold' : 'text-body hover-bg' }}" href="{{ route('home') }}">
                                <i class="bi bi-house-door fs-5 me-1"></i>
                                <span class="fw-medium">Beranda</span>
                            </a>
                        </li>

                        @if ($currentUser)
                            <li class="nav-header text-uppercase text-body-secondary fw-bold px-3 pt-3 pb-1" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                                Layanan & Pengaduan
                            </li>
                            <li class="nav-item">
                                @php
                                    $aspirasiRoute = (isset($currentUser->role) && $currentUser->role === 'admin') 
                                        ? route('admin.aspirasi.index') 
                                        : route('aspirasi.index');
                                @endphp
                                <a class="nav-link d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ is_route('aspirasi.index', 'admin.aspirasi.index') ? 'active fw-semibold' : 'text-body hover-bg' }}" href="{{ $aspirasiRoute }}">
                                    <i class="bi bi-chat-left-text fs-5 me-1"></i>
                                    <span class="fw-medium">Aspirasi & Laporan</span>
                                </a>
                            </li>

                            <li class="nav-header text-uppercase text-body-secondary fw-bold px-3 pt-3 pb-1" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                                Inventaris & Fasilitas
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ is_route('alat.index') ? 'active fw-semibold' : 'text-body hover-bg' }}" href="{{ route('alat.index') }}">
                                    <i class="bi bi-tools fs-5 me-1"></i>
                                    <span class="fw-medium">Data Alat & Barang</span>
                                </a>
                            </li>

                            @if (isset($currentUser->role) && $currentUser->role === 'admin')
                                <li class="nav-header text-uppercase text-body-secondary fw-bold px-3 pt-3 pb-1" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                                    Manajemen Sistem
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ is_route('kategori.index') ? 'active fw-semibold' : 'text-body hover-bg' }}" href="{{ route('kategori.index') }}">
                                        <i class="bi bi-grid fs-5 me-1"></i>
                                        <span class="fw-medium">Kategori Fasilitas</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ is_route('pengguna.index') ? 'active fw-semibold' : 'text-body hover-bg' }}" href="{{ route('pengguna.index') }}">
                                        <i class="bi bi-people fs-5 me-1"></i>
                                        <span class="fw-medium">Kelola Pengguna</span>
                                    </a>
                                </li>
                            @endif

                            <li class="nav-header text-uppercase text-body-secondary fw-bold px-3 pt-3 pb-1" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                                Area Pengguna
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-3 px-3 py-2.5 rounded-3 {{ is_route('admin.dashboard', 'dashboard', 'siswa.dashboard') ? 'active fw-semibold' : 'text-body hover-bg' }}"
                                   href="{{ isset($currentUser->role) && $currentUser->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}">
                                    <i class="bi bi-speedometer2 fs-5 me-1"></i>
                                    <span class="fw-medium">Dashboard {{ isset($currentUser->role) && $currentUser->role === 'admin' ? 'Admin' : 'Siswa' }}</span>
                                </a>
                            </li>
                        @endif
                    </ul>

                    {{-- Footer Sidebar --}}
                    <div class="border-top pt-3 mt-3">
                        @if ($currentUser)
                            <div class="mb-3 px-2 d-flex align-items-center gap-3">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px;">
                                    <i class="bi bi-person-fill fs-5"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <div class="fw-bold text-truncate text-body" style="font-size: 0.875rem;">{{ $currentUser->username }}</div>
                                    <div class="text-body-secondary small text-capitalize" style="font-size: 0.75rem;">{{ $currentUser->role ?? 'Siswa' }}</div>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('logout') }}" class="w-100">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100 rounded-3 py-2 d-flex align-items-center justify-content-center gap-2 fw-semibold">
                                    <i class="bi bi-box-arrow-right me-1"></i>
                                    <span>Keluar</span>
                                </button>
                            </form>
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

                            <div class="d-flex flex-column gap-2">
                                @if ($canRegister)
                                    <a class="btn btn-outline-secondary text-body w-100 rounded-3 py-2 text-center fw-semibold" href="{{ route('register') }}">
                                        Daftar Akun
                                    </a>
                                @endif
                                
                                <a class="btn btn-primary w-100 rounded-3 py-2 d-flex align-items-center justify-content-center gap-2 shadow-sm fw-semibold" href="{{ route('login') }}">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>
                                    <span>Masuk</span>
                                </a>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

            {{-- Area Konten Utama (Otomatis Menyesuaikan Lebar Sisa) --}}
            <main class="flex-grow-1 p-3 p-md-4 overflow-x-hidden">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>