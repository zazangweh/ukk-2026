@extends('layouts.app')

@section('title', config('app.name') . ' — Layanan Pengaduan Sarana & Prasarana Sekolah')

@push('styles')
<style>
    /* Styling khusus agar responsif & rapi di Dark/Light Mode */
    .hero-card {
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.08) 0%, rgba(13, 110, 253, 0.02) 100%);
        border: 1px solid rgba(0, 0, 0, 0.08);
    }

    [data-bs-theme="dark"] .hero-card {
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.18) 0%, rgba(255, 255, 255, 0.03) 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .timeline-badge {
        width: 36px;
        height: 36px;
        min-width: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-hover-bounce {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-hover-bounce:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<div class="container py-3 py-lg-4">
    
    {{-- Hero Section (Cek Status Laporan Sudah Dihapus & Dibuat Center Focus) --}}
    <section class="hero-card position-relative overflow-hidden py-5 px-3 px-sm-4 px-lg-5 rounded-4 shadow-sm mb-4 mb-lg-5 text-center">
        <div class="row justify-content-center py-2 py-lg-3">
            <div class="col-lg-9 col-xl-8">
                <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 mb-3 fw-semibold">
                    <i class="bi bi-tools me-1"></i> Portal Resmi Sarana & Prasarana v1.0.0
                </span>
                
                <h1 class="display-5 display-md-4 fw-bold mb-3 text-body">
                    Laporkan Kerusakan Fasilitas Sekolah <span class="text-primary d-inline-block">Lebih Cepat & Mudah</span>
                </h1>
                
                <p class="lead text-body-secondary mb-4 fs-6 fs-md-5 px-md-4">
                    Punya kendala dengan fasilitas kelas, laboratorium, atau area sekolah lainnya? Sampaikan pengaduan Anda di sini dan pantau langsung proses perbaikannya secara transparan.
                </p>

                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a class="btn btn-primary btn-lg px-4 shadow-sm rounded-pill d-inline-flex align-items-center justify-content-center gap-2 btn-hover-bounce fw-semibold" href="{{ route('login') }}">
                        <i class="bi bi-box-arrow-in-right fs-5"></i> Masuk & Buat Laporan
                    </a>
                    <a class="btn btn-outline-secondary btn-lg px-4 rounded-pill d-inline-flex align-items-center justify-content-center gap-2 btn-hover-bounce fw-semibold" href="#alur-pengaduan">
                        <i class="bi bi-info-circle fs-5"></i> Pelajari Alur
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Keunggulan / Fitur Singkat --}}
    <div class="row g-3 g-md-4 mb-4 mb-lg-5 text-center">
        <div class="col-12 col-md-4">
            <div class="card border border-body-tertiary shadow-sm rounded-4 p-4 h-100 bg-body-tertiary">
                <div class="text-primary mb-3 fs-1"><i class="bi bi-lightning-charge-fill"></i></div>
                <h4 class="h5 fw-bold text-body">Respon Cepat</h4>
                <p class="text-body-secondary small mb-0">Laporan yang masuk langsung diteruskan ke tim sarpras untuk segera ditinjau.</p>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border border-body-tertiary shadow-sm rounded-4 p-4 h-100 bg-body-tertiary">
                <div class="text-success mb-3 fs-1"><i class="bi bi-shield-check-fill"></i></div>
                <h4 class="h5 fw-bold text-body">Transparan & Terpantau</h4>
                <p class="text-body-secondary small mb-0">Siswa dapat melihat status laporan mulai dari pending, diproses, hingga selesai.</p>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border border-body-tertiary shadow-sm rounded-4 p-4 h-100 bg-body-tertiary">
                <div class="text-warning mb-3 fs-1"><i class="bi bi-sliders"></i></div>
                <h4 class="h5 fw-bold text-body">Terorganisir</h4>
                <p class="text-body-secondary small mb-0">Pengelompokan kategori fasilitas membuat perbaikan lebih terarah dan efisien.</p>
            </div>
        </div>
    </div>

    {{-- Informasi & Alur Pengaduan Section --}}
    <div class="pt-2" id="alur-pengaduan">
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
                    <p class="text-body-secondary lh-relaxed mb-0">
                        Melalui sistem ini, admin dan petugas sekolah dapat mengelola, memproses, serta memperbarui status perbaikan fasilitas secara transparan demi kenyamanan bersama.
                    </p>
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
                                <h6 class="fw-bold mb-1 text-body">Diproses</h6>
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

</div>
@endsection