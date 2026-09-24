@extends('layouts.app')

@section('title', config('app.name') . ' -- Layanan Pengaduan Sarana & Prasarana Sekolah')

@section('content')

    {{-- Hero Section --}}
    <section class="position-relative overflow-hidden py-5 my-3 bg-gradient rounded-4 shadow-sm border px-4 px-lg-5" style="background: linear-gradient(135deg, rgba(13,110,253,0.05) 0%, rgba(13,110,253,0.01) 100%);">
        <div class="row align-items-center g-5 py-4">
            <div class="col-lg-7 text-center text-lg-start">
                <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary px-3 py-2 mb-3 fw-semibold">
                    <i class="bi bi-tools me-1"></i> Portal Resmi Sarana & Prasarana v1.0.0
                </span>
                
                <h1 class="display-4 fw-bold mb-3 text-dark lh-tight">
                    Laporkan Kerusakan Fasilitas Sekolah <span class="text-primary">Lebih Cepat & Mudah</span>
                </h1>
                
                <p class="lead text-muted mb-4">
                    Punya kendala dengan fasilitas kelas, laboratorium, atau area sekolah lainnya? Sampaikan pengaduan Anda di sini dan pantau langsung proses perbaikannya secara transparan.
                </p>

                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                    <a class="btn btn-primary btn-lg px-4 shadow-sm rounded-pill d-inline-flex align-items-center gap-2" href="{{ route('login') }}">
                        <i class="bi bi-box-arrow-in-right"></i> Masuk & Buat Laporan
                    </a>
                    <a class="btn btn-outline-secondary btn-lg px-4 rounded-pill d-inline-flex align-items-center gap-2" href="#alur-pengaduan">
                        <i class="bi bi-info-circle"></i> Pelajari Alur
                    </a>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card border-0 shadow-lg rounded-4 p-4 bg-white">
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center p-3 mb-2" style="width: 70px; height: 70px;">
                            <i class="bi bi-clipboard-check display-6"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-1">Cek Status Laporan</h3>
                        <p class="text-muted small mb-0">Masukkan kode tiket untuk melihat progres perbaikan.</p>
                    </div>

                    <form action="#" method="GET">
                        <div class="mb-3">
                            <input type="text" class="form-control form-control-lg bg-light" placeholder="Contoh: TIKET-98213" required>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 py-2 fw-semibold rounded-3 shadow-sm">
                            <i class="bi bi-search me-1"></i> Lacak Pengaduan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- Statistik Singkat / Keunggulan --}}
    <div class="row g-4 my-4 text-center">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                <div class="text-primary mb-3 fs-2"><i class="bi bi-lightning-charge-fill"></i></div>
                <h4 class="h5 fw-bold">Respon Cepat</h4>
                <p class="text-muted small mb-0">Laporan yang masuk langsung diteruskan ke tim sarpras untuk segera ditinjau.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                <div class="text-success mb-3 fs-2"><i class="bi bi-shield-check-fill"></i></div>
                <h4 class="h5 fw-bold">Transparan & Terpantau</h4>
                <p class="text-muted small mb-0">Siswa dapat melihat status laporan mulai dari pending, diproses, hingga selesai.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
                <div class="text-warning mb-3 fs-2"><i class="bi bi-sliders"></i></div>
                <h4 class="h5 fw-bold">Terorganisir</h4>
                <p class="text-muted small mb-0">Pengelompokan kategori fasilitas membuat perbaikan lebih terarah dan efisien.</p>
            </div>
        </div>
    </div>

    {{-- Informasi & Alur Pengaduan Section --}}
    <div class="container py-4" id="alur-pengaduan">
        <div class="row g-4">
            
            {{-- Tentang Aplikasi --}}
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 p-lg-5 bg-white">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3 fs-4">
                            <i class="bi bi-info-circle-fill"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-0 text-dark">Tentang Aplikasi</h3>
                    </div>
                    <p class="text-muted lh-base mb-3">
                        <strong>Pengaduan Sarana & Prasarana Sekolah</strong> merupakan platform digital yang dirancang khusus untuk memudahkan siswa dalam melaporkan kerusakan atau kendala pada fasilitas sekolah secara real-time.
                    </p>
                    <p class="text-muted lh-base mb-0">
                        Melalui sistem ini, admin dan petugas sekolah dapat mengelola, memproses, serta memperbarui status perbaikan fasilitas secara transparan demi kenyamanan bersama.
                    </p>
                </div>
            </div>

            {{-- Cara Pengaduan / Alur --}}
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4 p-lg-5 bg-white">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-success bg-opacity-10 text-success p-3 rounded-3 me-3 fs-4">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-0 text-dark">Alur Pengaduan</h3>
                    </div>
                    
                    <div class="timeline-steps">
                        <div class="d-flex mb-3 align-items-start">
                            <div class="badge bg-primary rounded-circle p-2 me-3 mt-1 shadow-sm">1</div>
                            <div>
                                <h6 class="fw-bold mb-1">Login Akun</h6>
                                <p class="text-muted small mb-0">Masuk menggunakan akun siswa yang terdaftar.</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3 align-items-start">
                            <div class="badge bg-primary rounded-circle p-2 me-3 mt-1 shadow-sm">2</div>
                            <div>
                                <h6 class="fw-bold mb-1">Buat Pengaduan</h6>
                                <p class="text-muted small mb-0">Isi detail kerusakan fasilitas dan pilih kategori yang sesuai.</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3 align-items-start">
                            <div class="badge bg-warning text-dark rounded-circle p-2 me-3 mt-1 shadow-sm">3</div>
                            <div>
                                <h6 class="fw-bold mb-1">Diproses</h6>
                                <p class="text-muted small mb-0">Admin meninjau laporan dan melakukan perbaikan sarpras.</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start">
                            <div class="badge bg-success rounded-circle p-2 me-3 mt-1 shadow-sm">4</div>
                            <div>
                                <h6 class="fw-bold mb-1">Selesai</h6>
                                <p class="text-muted small mb-0">Fasilitas sekolah telah diperbaiki dan dapat digunakan kembali.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection