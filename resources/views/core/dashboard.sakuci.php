@extends('layouts.app')

@section('title', 'Dashboard -- ' . config('app.name'))

@section('content')
<div class="container py-4">
    
    {{-- Hero Welcome Card --}}
    <div class="card border-0 shadow-sm rounded-4 bg-gradient overflow-hidden mb-4" style="background: linear-gradient(135deg, rgba(13,110,253,0.1) 0%, rgba(13,110,253,0.02) 100%);">
        <div class="card-body p-4 p-lg-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3 py-2 mb-3 fw-semibold">
                        <i class="bi bi-shield-check me-1"></i> Role: {{ ucfirst($user->role) }}
                    </span>
                    <h1 class="display-6 fw-bold text-dark mb-2">Halo, {{ $user->username }}! 👋</h1>
                    <p class="text-muted lead fs-6 mb-0">
                        Selamat datang kembali di sistem pengaduan sarana dan prasarana. Kelola laporan fasilitas sekolah Anda dengan mudah dari dasbor ini.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                    <div class="bg-white p-3 rounded-4 shadow-sm d-inline-block text-start border">
                        <small class="text-muted d-block mb-1">Status Sesi Anda</small>
                        <span class="d-flex align-items-center gap-2 fw-semibold text-success">
                            <i class="bi bi-circle-fill fs-8"></i> Aktif & Terautentikasi
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Action Cards / Menu Pintasan --}}
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white hover-shadow transition">
                <div class="card-body">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-inline-flex align-items-center justify-content-center p-3 mb-3 fs-4">
                        <i class="bi bi-journal-text"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Daftar Kategori</h3>
                    <p class="text-muted small mb-3">Lihat dan kelola kategori kerusakan atau jenis fasilitas sekolah.</p>
                    <a href="{{ route('kategori.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                        Kelola Kategori <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white hover-shadow transition">
                <div class="card-body">
                    <div class="bg-success bg-opacity-10 text-success rounded-3 d-inline-flex align-items-center justify-content-center p-3 mb-3 fs-4">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Data Pengguna</h3>
                    <p class="text-muted small mb-3">Periksa daftar data siswa atau pengguna yang terdaftar di sistem.</p>
                    <a href="{{ route('pengguna.index') }}" class="btn btn-outline-success btn-sm rounded-pill px-3">
                        Lihat Pengguna <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 p-3 bg-white hover-shadow transition">
                <div class="card-body">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-3 d-inline-flex align-items-center justify-content-center p-3 mb-3 fs-4">
                        <i class="bi bi-house-door"></i>
                    </div>
                    <h3 class="h5 fw-bold mb-2">Halaman Utama</h3>
                    <p class="text-muted small mb-3">Kembali ke halaman depan portal informasi pengaduan sarpras.</p>
                    <a href="{{ route('home') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                        Ke Beranda <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection