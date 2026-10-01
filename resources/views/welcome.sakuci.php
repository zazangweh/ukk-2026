@php
    $currentUser = \App\Models\User::current();

    $totalAlat = \App\Models\Alat::count();
    $totalAspirasi = \App\Models\Aspirasi::count();
    $totalKategori = \App\Models\Kategori::count();

    // Hitung statistik status pengaduan/aspirasi
    $aspirasiSelesai = \App\Models\Aspirasi::where('status', 'selesai')->count();
    $aspirasiProses = \App\Models\Aspirasi::where('status', 'proses')->count();
    $aspirasiPending = \App\Models\Aspirasi::where('status', 'pending')->count();

    $semuaKategori = \App\Models\Kategori::all();
    $kategoriChart = [];

    foreach ($semuaKategori as $d) {
        $jumlah = \App\Models\Aspirasi::where('id_kategori', '=', $d->id_kategori)->count();
        $kategoriChart[] = ['nama' => $d->nama_kategori, 'jumlah' => $jumlah];
    }

    usort($kategoriChart, fn($a, $b) => $b['jumlah'] <=> $a['jumlah']);
    $maxjumlah = $kategoriChart ? max(array_column($kategoriChart, 'jumlah')) : 1;
@endphp

@extends('layouts.app')

@section('title', config('app.name') . ' — Layanan Pengaduan Sarana & Prasarana Sekolah')

@push('styles')
<style>
    /* Gradient Background & Pattern Effect Hero */
    .hero-card {
        background: radial-gradient(circle at 10% 20%, rgba(13, 110, 253, 0.08) 0%, rgba(13, 110, 253, 0.02) 90%),
                    radial-gradient(circle at 90% 80%, rgba(25, 135, 84, 0.06) 0%, rgba(255, 255, 255, 0) 50%);
        border: 1px solid rgba(0, 0, 0, 0.08);
    }

    [data-bs-theme="dark"] .hero-card {
        background: radial-gradient(circle at 10% 20%, rgba(13, 110, 253, 0.2) 0%, rgba(13, 110, 253, 0.03) 90%),
                    radial-gradient(circle at 90% 80%, rgba(25, 135, 84, 0.12) 0%, rgba(0, 0, 0, 0) 50%);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Elemen Melayang Background (Watermark Icon & Partikel) */
    .hero-bg-icon {
        position: absolute;
        color: var(--bs-primary);
        opacity: 0.08;
        z-index: 0;
        pointer-events: none;
        user-select: none;
        animation: floatAnimation 7s ease-in-out infinite alternate;
    }

    [data-bs-theme="dark"] .hero-bg-icon {
        opacity: 0.14;
    }

    .hero-bg-dot {
        position: absolute;
        border-radius: 50%;
        background-color: var(--bs-primary);
        opacity: 0.15;
        z-index: 0;
        pointer-events: none;
        animation: pulseAnimation 4s ease-in-out infinite alternate;
    }

    /* Animasi Pergerakan */
    @keyframes floatAnimation {
        0% { transform: translateY(0) rotate(0deg) scale(1); }
        50% { transform: translateY(-14px) rotate(8deg) scale(1.05); }
        100% { transform: translateY(4px) rotate(-6deg) scale(0.98); }
    }

    @keyframes pulseAnimation {
        0% { transform: scale(1); opacity: 0.1; }
        100% { transform: scale(1.6); opacity: 0.3; }
    }

    /* Posisi Ikon Utama */
    .hero-bg-icon-1 { top: 6%; left: 3%; font-size: 5.5rem; animation-delay: 0s; }
    .hero-bg-icon-2 { bottom: 8%; left: 3%; font-size: 4.5rem; animation-delay: 2s; }
    .hero-bg-icon-3 { top: 8%; right: 3%; font-size: 5.5rem; animation-delay: 1s; }
    .hero-bg-icon-4 { bottom: 6%; right: 4%; font-size: 4.8rem; animation-delay: 3s; }
    
    /* Posisi Ikon Tambahan */
    .hero-bg-icon-5 { top: 40%; left: 10%; font-size: 3.2rem; animation-delay: 1.5s; opacity: 0.05; }
    .hero-bg-icon-6 { top: 38%; right: 10%; font-size: 3.5rem; animation-delay: 2.5s; opacity: 0.05; }
    .hero-bg-icon-7 { top: 5%; left: 38%; font-size: 2.8rem; animation-delay: 3.5s; opacity: 0.05; }
    .hero-bg-icon-8 { bottom: 5%; right: 38%; font-size: 3rem; animation-delay: 0.5s; opacity: 0.05; }
    .hero-bg-icon-9 { top: 65%; left: 22%; font-size: 2.5rem; animation-delay: 4s; opacity: 0.04; }
    .hero-bg-icon-10 { top: 62%; right: 22%; font-size: 2.7rem; animation-delay: 1.8s; opacity: 0.04; }

    /* Partikel Titik Bulat Dekoratif */
    .dot-1 { top: 20%; left: 18%; width: 12px; height: 12px; animation-delay: 0.2s; }
    .dot-2 { top: 75%; left: 8%; width: 18px; height: 18px; animation-delay: 1.2s; background-color: var(--bs-warning); }
    .dot-3 { top: 15%; right: 20%; width: 14px; height: 14px; animation-delay: 2.1s; background-color: var(--bs-success); }
    .dot-4 { bottom: 20%; right: 15%; width: 10px; height: 10px; animation-delay: 0.8s; }

    .timeline-badge {
        width: 40px;
        height: 40px;
        min-width: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .btn-hover-bounce {
        transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.2s ease;
    }

    .btn-hover-bounce:hover {
        transform: translateY(-3px) scale(1.02);
    }

    .card-feature {
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    .card-feature:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }

    /* Fix CTA Banner: Selalu kontras baik di Light & Dark Mode */
    .cta-banner {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%) !important;
        color: #ffffff !important;
    }

    .cta-banner h3,
    .cta-banner p,
    .cta-banner i:not(.btn i) {
        color: #ffffff !important;
    }

    .cta-banner p {
        opacity: 0.88;
    }

    .cta-banner .cta-bg-icon {
        color: #ffffff !important;
        opacity: 0.15 !important;
    }

    .pulse-badge {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: var(--bs-success);
        box-shadow: 0 0 0 0 rgba(25, 135, 84, 0.7);
        animation: pulseRing 1.8s infinite;
    }

    @keyframes pulseRing {
        0% { box-shadow: 0 0 0 0 rgba(25, 135, 84, 0.7); }
        70% { box-shadow: 0 0 0 6px rgba(25, 135, 84, 0); }
        100% { box-shadow: 0 0 0 0 rgba(25, 135, 84, 0); }
    }
</style>
@endpush

@section('content')
<div class="container py-3 py-lg-4">
    
    {{-- Hero Section dengan Rangkaian Elemen & Watermark --}}
    <section class="hero-card position-relative overflow-hidden py-5 px-3 px-sm-4 px-lg-5 rounded-4 shadow-sm mb-4 mb-lg-5 text-center">
        
        {{-- Watermark Ikon Alat-Alat & Fasilitas --}}
        <i class="bi bi-tools hero-bg-icon hero-bg-icon-1" title="Kunci & Obeng"></i>
        <i class="bi bi-wrench-adjustable hero-bg-icon hero-bg-icon-2" title="Kunci Inggris"></i>
        <i class="bi bi-cpu-fill hero-bg-icon hero-bg-icon-3" title="Elektronik/Komputer"></i>
        <i class="bi bi-hammer hero-bg-icon hero-bg-icon-4" title="Palu"></i>
        <i class="bi bi-screwdriver hero-bg-icon hero-bg-icon-5" title="Obeng"></i>
        <i class="bi bi-paint-bucket hero-bg-icon hero-bg-icon-6" title="Kuas & Cat"></i>
        <i class="bi bi-plug-fill hero-bg-icon hero-bg-icon-7" title="Kelistrikan"></i>
        <i class="bi bi-laptop hero-bg-icon hero-bg-icon-8" title="IT & Komputer"></i>
        <i class="bi bi-gear-wide-connected hero-bg-icon hero-bg-icon-9" title="Mekanis"></i>
        <i class="bi bi-lightbulb-fill hero-bg-icon hero-bg-icon-10" title="Penerangan"></i>

        {{-- Partikel Bulat Dekoratif --}}
        <div class="hero-bg-dot dot-1"></div>
        <div class="hero-bg-dot dot-2"></div>
        <div class="hero-bg-dot dot-3"></div>
        <div class="hero-bg-dot dot-4"></div>

        <div class="row justify-content-center py-2 py-lg-3 position-relative" style="z-index: 1;">
            <div class="col-lg-9 col-xl-8">
                
                {{-- Badges Header --}}
                <div class="d-inline-flex align-items-center gap-2 bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill mb-3 shadow-xs">
                    <span class="pulse-badge"></span>
                    <i class="bi bi-tools"></i>
                    <span class="fw-semibold small">Portal Resmi Sarana & Prasarana v1.0.0</span>
                </div>
                
                <h1 class="display-5 display-md-4 fw-bold mb-3 text-body">
                    Laporkan Kerusakan Fasilitas Sekolah <span class="text-primary d-inline-block">Lebih Cepat & Mudah</span>
                </h1>
                
                <p class="lead text-body-secondary mb-4 fs-6 fs-md-5 px-md-4">
                    Punya kendala dengan fasilitas kelas, laboratorium, atau area sekolah lainnya? Sampaikan pengaduan Anda di sini dan pantau langsung proses perbaikannya secara transparan.
                </p>

                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center align-items-center">
                    @if ($currentUser)
                        <a class="btn btn-primary btn-lg px-4 shadow rounded-pill d-inline-flex align-items-center justify-content-center gap-2 btn-hover-bounce fw-semibold" href="{{ route('aspirasi.index') }}">
                            <i class="bi bi-chat-left-text-fill fs-5"></i> Buat Laporan Pengaduan
                        </a>
                    @else
                        <a class="btn btn-primary btn-lg px-4 shadow rounded-pill d-inline-flex align-items-center justify-content-center gap-2 btn-hover-bounce fw-semibold" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right fs-5"></i> Masuk & Buat Laporan
                        </a>
                    @endif
                    <a class="btn btn-outline-secondary btn-lg px-4 rounded-pill d-inline-flex align-items-center justify-content-center gap-2 btn-hover-bounce fw-semibold" href="#alur-pengaduan">
                        <i class="bi bi-compass fs-5"></i> Pelajari Alur
                    </a>
                </div>

                {{-- Mini Badge Fitur Cepat --}}
                <div class="d-flex flex-wrap justify-content-center gap-3 mt-4 pt-2 text-body-secondary small">
                    <span class="d-inline-flex align-items-center gap-1 bg-body-tertiary px-3 py-1.5 rounded-pill border border-body-tertiary">
                        <i class="bi bi-clock-history text-primary"></i> Respon 1x24 Jam
                    </span>
                    <span class="d-inline-flex align-items-center gap-1 bg-body-tertiary px-3 py-1.5 rounded-pill border border-body-tertiary">
                        <i class="bi bi-shield-check text-success"></i> Transparan & Terlacak
                    </span>
                    <span class="d-inline-flex align-items-center gap-1 bg-body-tertiary px-3 py-1.5 rounded-pill border border-body-tertiary">
                        <i class="bi bi-phone text-info"></i> Akses Seluler Mudah
                    </span>
                </div>
            </div>
        </div>
    </section>

    {{-- Ringkasan Statistik Sistem --}}
    <div class="row g-3 g-md-4 mb-4 mb-lg-5 text-center">
        <div class="col-6 col-md-3">
            <div class="card card-feature border border-body-tertiary shadow-sm rounded-4 p-3 p-md-4 h-100 bg-body-tertiary position-relative overflow-hidden">
                <i class="bi bi-chat-left-dots position-absolute bottom-0 end-0 me-n2 mb-n2 display-4 opacity-10 text-primary"></i>
                <div class="fs-1 text-primary mb-2"><i class="bi bi-chat-left-dots-fill"></i></div>
                <h3 class="fw-bold mb-1 text-body">{{ $totalAspirasi }}</h3>
                <p class="text-body-secondary small mb-0 fw-medium">Total Laporan</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-feature border border-body-tertiary shadow-sm rounded-4 p-3 p-md-4 h-100 bg-body-tertiary position-relative overflow-hidden">
                <i class="bi bi-check-circle position-absolute bottom-0 end-0 me-n2 mb-n2 display-4 opacity-10 text-success"></i>
                <div class="fs-1 text-success mb-2"><i class="bi bi-check-circle-fill"></i></div>
                <h3 class="fw-bold mb-1 text-body">{{ $aspirasiSelesai }}</h3>
                <p class="text-body-secondary small mb-0 fw-medium">Selesai Diperbaiki</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-feature border border-body-tertiary shadow-sm rounded-4 p-3 p-md-4 h-100 bg-body-tertiary position-relative overflow-hidden">
                <i class="bi bi-hourglass-split position-absolute bottom-0 end-0 me-n2 mb-n2 display-4 opacity-10 text-warning"></i>
                <div class="fs-1 text-warning mb-2"><i class="bi bi-hourglass-split"></i></div>
                <h3 class="fw-bold mb-1 text-body">{{ $aspirasiProses + $aspirasiPending }}</h3>
                <p class="text-body-secondary small mb-0 fw-medium">Dalam Penanganan</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-feature border border-body-tertiary shadow-sm rounded-4 p-3 p-md-4 h-100 bg-body-tertiary position-relative overflow-hidden">
                <i class="bi bi-tools position-absolute bottom-0 end-0 me-n2 mb-n2 display-4 opacity-10 text-info"></i>
                <div class="fs-1 text-info mb-2"><i class="bi bi-tools"></i></div>
                <h3 class="fw-bold mb-1 text-body">{{ $totalAlat }}</h3>
                <p class="text-body-secondary small mb-0 fw-medium">Fasilitas & Alat</p>
            </div>
        </div>
    </div>

    {{-- Keunggulan / Fitur Utama --}}
    <div class="mb-4 mb-lg-5">
        <div class="text-center mb-4">
            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-3 py-1.5 rounded-pill mb-2 fw-semibold small">
                <i class="bi bi-star-fill text-warning me-1"></i> Keunggulan Layanan
            </span>
            <h2 class="fw-bold text-body">Mengapa Menggunakan Portal Ini?</h2>
            <p class="text-body-secondary">Kemudahan dan kepastian pelayanan perbaikan sarana prasarana sekolah.</p>
        </div>
        <div class="row g-3 g-md-4 text-center">
            <div class="col-12 col-md-4">
                <div class="card card-feature border border-body-tertiary shadow-sm rounded-4 p-4 h-100 bg-body-tertiary">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center p-3 mb-3" style="width: 64px; height: 64px;">
                        <i class="bi bi-lightning-charge-fill fs-2"></i>
                    </div>
                    <h4 class="h5 fw-bold text-body">Respon Cepat</h4>
                    <p class="text-body-secondary small mb-0">Laporan yang masuk langsung diteruskan ke tim sarpras untuk segera ditinjau dan ditindaklanjuti.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card card-feature border border-body-tertiary shadow-sm rounded-4 p-4 h-100 bg-body-tertiary">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center p-3 mb-3" style="width: 64px; height: 64px;">
                        <i class="bi bi-shield-check-fill fs-2"></i>
                    </div>
                    <h4 class="h5 fw-bold text-body">Transparan & Terpantau</h4>
                    <p class="text-body-secondary small mb-0">Siswa dapat melihat perkembangan status laporan mulai dari pending, diproses, hingga selesai.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card card-feature border border-body-tertiary shadow-sm rounded-4 p-4 h-100 bg-body-tertiary">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center p-3 mb-3" style="width: 64px; height: 64px;">
                        <i class="bi bi-sliders fs-2"></i>
                    </div>
                    <h4 class="h5 fw-bold text-body">Terorganisir</h4>
                    <p class="text-body-secondary small mb-0">Pengelompokan kategori fasilitas membuat alur tindak lanjut perbaikan lebih terarah.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Kategori Fasilitas yang Paling Sering Dilaporkan --}}
    @if (!empty($kategoriChart))
    <div class="mb-4 mb-lg-5">
        <div class="card border border-body-tertiary shadow-sm rounded-4 p-4 p-lg-5 bg-body-tertiary">
            <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3 fs-4 d-flex align-items-center justify-content-center">
                        <i class="bi bi-bar-chart-line-fill"></i>
                    </div>
                    <div>
                        <h3 class="h4 fw-bold mb-1 text-body">Statistik Kategori Pengaduan</h3>
                        <p class="text-body-secondary small mb-0">Ringkasan jumlah laporan berdasarkan kategori sarana & prasarana.</p>
                    </div>
                </div>
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill small fw-semibold">
                    <i class="bi bi-pie-chart-fill me-1"></i> Top Kategori
                </span>
            </div>

            <div class="row g-3">
                @foreach (array_slice($kategoriChart, 0, 5) as $item)
                    @php
                        $persen = $maxjumlah > 0 ? round(($item['jumlah'] / $maxjumlah) * 100) : 0;
                    @endphp
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-semibold text-body small d-inline-flex align-items-center gap-1.5">
                                <i class="bi bi-tag-fill text-primary opacity-75 fs-7"></i> {{ $item['nama'] }}
                            </span>
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill small">{{ $item['jumlah'] }} Laporan</span>
                        </div>
                        <div class="progress rounded-pill" style="height: 10px;">
                            <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated rounded-pill" role="progressbar" style="width: {{ $persen }}%" aria-valuenow="{{ $persen }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Informasi Tentang & Alur Pengaduan Section --}}
    <div class="pt-2 mb-4 mb-lg-5" id="alur-pengaduan">
        <div class="row g-4">
            {{-- Tentang Aplikasi --}}
            <div class="col-12 col-lg-6">
                <div class="card border border-body-tertiary shadow-sm rounded-4 p-4 p-lg-5 bg-body-tertiary h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3 fs-4 d-flex align-items-center justify-content-center">
                            <i class="bi bi-info-circle-fill"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-0 text-body">Tentang Aplikasi</h3>
                    </div>
                    <p class="text-body-secondary lh-relaxed mb-3">
                        <strong>Pengaduan Sarana & Prasarana Sekolah</strong> merupakan platform digital yang dirancang khusus untuk memudahkan siswa dalam melaporkan kerusakan atau kendala pada fasilitas sekolah secara <em>real-time</em>.
                    </p>
                    <p class="text-body-secondary lh-relaxed mb-4">
                        Melalui sistem ini, admin dan petugas sekolah dapat mengelola, memproses, serta memperbarui status perbaikan fasilitas secara transparan demi kenyamanan bersama.
                    </p>
                    
                    {{-- Mini checklist/poin penting --}}
                    <div class="p-3 bg-body rounded-3 border border-body-tertiary small">
                        <div class="row g-2">
                            <div class="col-6 d-flex align-items-center gap-2 text-body">
                                <i class="bi bi-check-circle-fill text-success"></i> Transparansi Status
                            </div>
                            <div class="col-6 d-flex align-items-center gap-2 text-body">
                                <i class="bi bi-check-circle-fill text-success"></i> Notifikasi Progres
                            </div>
                            <div class="col-6 d-flex align-items-center gap-2 text-body">
                                <i class="bi bi-check-circle-fill text-success"></i> Pengelompokan Kategori
                            </div>
                            <div class="col-6 d-flex align-items-center gap-2 text-body">
                                <i class="bi bi-check-circle-fill text-success"></i> Penanganan Cepat
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cara Pengaduan / Alur --}}
            <div class="col-12 col-lg-6">
                <div class="card border border-body-tertiary shadow-sm rounded-4 p-4 p-lg-5 bg-body-tertiary h-100">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 me-3 fs-4 d-flex align-items-center justify-content-center">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-0 text-body">Alur Pengaduan</h3>
                    </div>
                    
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-start">
                            <div class="timeline-badge bg-primary text-white rounded-circle me-3 fw-bold shadow-sm">1</div>
                            <div>
                                <h6 class="fw-bold mb-1 text-body">Login Akun</h6>
                                <p class="text-body-secondary small mb-0">Masuk menggunakan akun siswa yang telah terdaftar.</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start">
                            <div class="timeline-badge bg-primary text-white rounded-circle me-3 fw-bold shadow-sm">2</div>
                            <div>
                                <h6 class="fw-bold mb-1 text-body">Buat Pengaduan</h6>
                                <p class="text-body-secondary small mb-0">Isi detail kerusakan fasilitas dan pilih kategori yang sesuai.</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start">
                            <div class="timeline-badge bg-warning text-dark rounded-circle me-3 fw-bold shadow-sm">3</div>
                            <div>
                                <h6 class="fw-bold mb-1 text-body">Dipproses</h6>
                                <p class="text-body-secondary small mb-0">Admin meninjau laporan dan melakukan perbaikan sarpras.</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start">
                            <div class="timeline-badge bg-success text-white rounded-circle me-3 fw-bold shadow-sm">4</div>
                            <div>
                                <h6 class="fw-bold mb-1 text-body">Selesai</h6>
                                <p class="text-body-secondary small mb-0">Fasilitas sekolah telah diperbaiki dan dapat digunakan kembali.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Pertanyaan Umum (FAQ) --}}
    <div class="mb-4 mb-lg-5">
        <div class="text-center mb-4">
            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-3 py-1.5 rounded-pill mb-2 fw-semibold small">
                <i class="bi bi-question-circle-fill me-1"></i> Bantuan
            </span>
            <h2 class="fw-bold text-body">Pertanyaan Umum (FAQ)</h2>
            <p class="text-body-secondary">Jawaban atas pertanyaan yang sering diajukan mengenai sistem pengaduan.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border border-body-tertiary rounded-3 mb-2 overflow-hidden shadow-xs">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <i class="bi bi-person-badge text-primary me-2 fs-5"></i> Siapa saja yang bisa mengajukan pengaduan fasilitas?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-body-secondary small">
                                Seluruh siswa, guru, dan staf sekolah yang telah memiliki akun terdaftar dapat mengajukan pengaduan kerusakan fasilitas melalui portal ini.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border border-body-tertiary rounded-3 mb-2 overflow-hidden shadow-xs">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <i class="bi bi-hourglass-bottom text-warning me-2 fs-5"></i> Berapa lama laporan pengaduan diproses?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-body-secondary small">
                                Waktu penanganan bervariasi tergantung pada tingkat kerusakan dan ketersediaan suku cadang. Laporan biasanya ditinjau oleh tim sarpras dalam 1x24 jam kerja.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border border-body-tertiary rounded-3 mb-2 overflow-hidden shadow-xs">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <i class="bi bi-graph-up-arrow text-success me-2 fs-5"></i> Bagaimana cara mengetahui progres perbaikan?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-body-secondary small">
                                Anda dapat memantau status laporan secara langsung di halaman menu <strong>Aspirasi</strong> setelah melakukan login. Status akan diperbarui secara real-time.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Banner Call to Action (CTA) yang Terkunci Warna dan Kontrasnya --}}
    <div class="cta-banner position-relative overflow-hidden rounded-4 p-4 p-lg-5 text-center shadow mb-3">
        {{-- Ikon Melayang Background Banner --}}
        <i class="bi bi-tools position-absolute top-0 start-0 display-1 cta-bg-icon ms-3 mt-2"></i>
        <i class="bi bi-wrench position-absolute bottom-0 end-0 display-1 cta-bg-icon me-3 mb-2"></i>

        <div class="position-relative" style="z-index: 1;">
            <h3 class="fw-bold mb-2">Ada Fasilitas Sekolah yang Rusak?</h3>
            <p class="mb-4 col-md-8 mx-auto">Jangan biarkan kenyamanan belajar terganggu. Laporkan sekarang agar segera diperbaiki oleh tim sarana dan prasarana!</p>
            @if ($currentUser)
                <a href="{{ route('aspirasi.index') }}" class="btn btn-light btn-lg rounded-pill px-4 fw-bold text-primary btn-hover-bounce shadow-sm">
                    <i class="bi bi-send-fill me-1 text-primary"></i> Buat Laporan Sekarang
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-light btn-lg rounded-pill px-4 fw-bold text-primary btn-hover-bounce shadow-sm">
                    <i class="bi bi-box-arrow-in-right me-1 text-primary"></i> Masuk & Laporkan
                </a>
            @endif
        </div>
    </div>

</div>
@endsection