@extends('layouts.app')

@section('title', 'Admin Dashboard -- ' . config('app.name'))

@section('content')
<div class="container py-4">
    
    {{-- Hero Card Khusus Admin --}}
    <div class="card border-0 shadow-sm rounded-4 bg-gradient overflow-hidden mb-4" style="background: linear-gradient(135deg, rgba(220,53,69,0.08) 0%, rgba(13,110,253,0.02) 100%);">
        <div class="card-body p-4 p-lg-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger px-3 py-2 mb-3 fw-semibold">
                        <i class="bi bi-shield-lock-fill me-1"></i> Area Administrator Utama
                    </span>
                    <h1 class="display-6 fw-bold text-dark mb-2">Halo, {{ $user->username }}! ⚡</h1>
                    <p class="text-muted lead fs-6 mb-0">
                        Anda berada di pusat kendali sistem. Halaman ini diamankan secara ketat menggunakan middleware khusus <code class="bg-light px-2 py-1 rounded text-danger fw-semibold">admin</code>.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <div class="bg-white p-3 rounded-4 shadow-sm d-inline-block text-start border">
                        <small class="text-muted d-block mb-1">Akses Sistem</small>
                        <span class="d-flex align-items-center gap-2 fw-semibold text-danger">
                            <i class="bi bi-circle-fill fs-8"></i> Hak Akses Penuh (Full Control)
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Grid Menu Manajemen Admin --}}
    <div class="row g-4">
        
        {{-- Kelola Role --}}
        <div class="col-md-4">
            <a href="{{ route('admin.roles.index') }}" class="card border-0 shadow-sm rounded-4 text-decoration-none h-100 bg-white hover-shadow transition">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-inline-flex align-items-center justify-content-center p-3 mb-3 fs-4">
                            <i class="bi bi-shield-shaded"></i>
                        </div>
                        <h2 class="h5 fw-bold text-dark mb-2">Manage Role</h2>
                        <p class="text-muted small mb-4">Tambah dan sesuaikan role baru untuk dipakai saat membuat user di dalam sistem.</p>
                    </div>
                    <div class="text-primary fw-semibold small d-flex align-items-center gap-1">
                        Kelola Role <i class="bi bi-arrow-right"></i>
                    </div>
                </div>
            </a>
        </div>

        {{-- Kelola User --}}
        <div class="col-md-4">
            <a href="{{ route('admin.users.index') }}" class="card border-0 shadow-sm rounded-4 text-decoration-none h-100 bg-white hover-shadow transition">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="bg-success bg-opacity-10 text-success rounded-3 d-inline-flex align-items-center justify-content-center p-3 mb-3 fs-4">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h2 class="h5 fw-bold text-dark mb-2">Manage User</h2>
                        <p class="text-muted small mb-4">Tambah user baru, periksa daftar pengguna, dan tentukan hak akses atau role-nya.</p>
                    </div>
                    <div class="text-success fw-semibold small d-flex align-items-center gap-1">
                        Kelola User <i class="bi bi-arrow-right"></i>
                    </div>
                </div>
            </a>
        </div>

        {{-- Download Database --}}
        <div class="col-md-4">
            <a href="{{ route('admin.database.export') }}" class="card border-0 shadow-sm rounded-4 text-decoration-none h-100 bg-white hover-shadow transition">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="bg-warning bg-opacity-10 text-warning rounded-3 d-inline-flex align-items-center justify-content-center p-3 mb-3 fs-4">
                            <i class="bi bi-database-down"></i>
                        </div>
                        <h2 class="h5 fw-bold text-dark mb-2">Download Database</h2>
                        <p class="text-muted small mb-4">Unduh seluruh isi database menjadi satu berkas .sql, siap untuk dicadangkan atau diimpor di server.</p>
                    </div>
                    <div class="text-warning text-dark fw-semibold small d-flex align-items-center gap-1">
                        Unduh Berkas <i class="bi bi-arrow-right"></i>
                    </div>
                </div>
            </a>
        </div>

    </div>

</div>
@endsection