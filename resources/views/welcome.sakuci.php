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
    /* Hero Card dengan Efek Latar Belakang Peralatan Dekoratif */
    .hero-card {
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.08) 0%, rgba(13, 110, 253, 0.02) 100%);
        border: 1px solid rgba(0, 0, 0, 0.08);
    }

    [data-bs-theme="dark"] .hero-card {
        background: linear-gradient(135deg, rgba(13, 110, 253, 0.18) 0%, rgba(255, 255, 255, 0.03) 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Dekoration Ikon Peralatan Melayang di Background */
    .hero-bg-icon {
        position: absolute;
        color: var(--bs-primary);
        opacity: 0.08;
        z-index: 0;
        pointer-events: none;
        user-select: none;
        animation: floatAnimation 8s ease-in-out infinite alternate;
    }

    [data-bs-theme="dark"] .hero-bg-icon {
        opacity: 0.12;
    }

    /* Animasi mengapung halus untuk hiasan */
    @keyframes floatAnimation {
        0% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-12px) rotate(5deg); }
        100% { transform: translateY(0) rotate(-3deg); }
    }

    .hero-bg-icon-1 { top: 10%; left: 4%; font-size: 5rem; animation-delay: 0s; }
    .hero-bg-icon-2 { bottom: 12%; left: 8%; font-size: 4rem; animation-delay: 2s; }
    .hero-bg-icon-3 { top: 15%; right: 5%; font-size: 5.5rem; animation-delay: 1s; }
    .hero-bg-icon-4 { bottom: 10%; right: 9%; font-size: 4.5rem; animation-delay: 3s; }

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

    .card-feature {
        transition: all 0.3s ease;
    }

    .card-feature:hover {
        transform: translateY(-4px);
    }

    .cta-banner {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    }
</style>
@endpush

@section('content')
<div class="container py-3 py-lg-4">
    
    {{-- Hero Section dengan Hiasan Background Peralatan --}}
    <section class="hero-card position-relative overflow-hidden py-5 px-3 px-sm-4 px-lg-5 rounded-4 shadow-sm mb-4 mb-lg-5 text-center">
        
        {{-- Ikon Peralatan Dekoratif (Background Watermark) --}}
        <i class="bi bi-tools hero-bg-icon hero-bg-icon-1"></i>
        <i class="bi bi-wrench-adjustable hero-bg-icon hero-bg-icon-2"></i>
        <i class="bi bi-cpu-fill hero-bg-icon hero-bg-icon-3"></i>
        <i class="bi bi-hammer hero-bg-icon hero-bg-icon-4"></i>

        <div class="row justify-content-center py-2 py-lg-3 position-relative" style="z-index: 1;">
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
                    @if ($currentUser)
                        <a class="btn btn-primary btn-lg px-4 shadow-sm rounded-pill d-inline-flex align-items-center justify-content-center gap-2 btn-hover-bounce fw-semibold" href="{{ route('aspirasi.index') }}">
                            <i class="bi bi-chat-left-text fs-5"></i> Buat Laporan Pengaduan
                        </a>
                    @else
                        <a class="btn btn-primary btn-lg px-4 shadow-sm rounded-pill d-inline-flex align-items-center justify-content-center gap-2 btn-hover-bounce fw-semibold" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right fs-5"></i> Masuk & Buat Laporan
                        </a>
                    @endif
                    <a class="btn btn-outline-secondary btn-lg px-4 rounded-pill d-inline-flex align-items-center justify-content-center gap-2 btn-hover-bounce fw-semibold" href="#alur-pengaduan">
                        <i class="bi bi-info-circle fs-5"></i> Pelajari Alur
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Ringkasan Statistik Sistem --}}
    <div class="row g-3 g-md-4 mb-4 mb-lg-5 text-center">
        <div class="col-6 col-md-3">
            <div class="card card-feature border border-body-tertiary shadow-sm rounded-4 p-3 p-md-4 h-100 bg-body-tertiary">
                <div class="fs-1 text-primary mb-2"><i class="bi bi-chat-left-dots-fill"></i></div>
                <h3 class="fw-bold mb-1 text-body">{{ $totalAspirasi }}</h3>
                <p class="text-body-secondary small mb-0 fw-medium">Total Laporan</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-feature border border-body-tertiary shadow-sm rounded-4 p-3 p-md-4 h-100 bg-body-tertiary">
                <div class="fs-1 text-success mb-2"><i class="bi bi-check-circle-fill"></i></div>
                <h3 class="fw-bold mb-1 text-body">{{ $aspirasiSelesai }}</h3>
                <p class="text-body-secondary small mb-0 fw-medium">Selesai Diperbaiki</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-feature border border-body-tertiary shadow-sm rounded-4 p-3 p-md-4 h-100 bg-body-tertiary">
                <div class="fs-1 text-warning mb-2"><i class="bi bi-hourglass-split"></i></div>
                <h3 class="fw-bold mb-1 text-body">{{ $aspirasiProses + $aspirasiPending }}</h3>
                <p class="text-body-secondary small mb-0 fw-medium">Dalam Penanganan</p>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-feature border border-body-tertiary shadow-sm rounded-4 p-3 p-md-4 h-100 bg-body-tertiary">
                <div class="fs-1 text-info mb-2"><i class="bi bi-tools"></i></div>
                <h3 class="fw-bold mb-1 text-body">{{ $totalAlat }}</h3>
                <p class="text-body-secondary small mb-0 fw-medium">Fasilitas & Alat</p>
            </div>
        </div>
    </div>

    {{-- Keunggulan / Fitur Utama --}}
    <div class="mb-4 mb-lg-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-body">Mengapa Menggunakan Portal Ini?</h2>
            <p class="text-body-secondary">Kemudahan dan kepastian pelayanan perbaikan sarana prasarana sekolah.</p>
        </div>
        <div class="row g-3 g-md-4 text-center">
            <div class="col-12 col-md-4">
                <div class="card card-feature border border-body-tertiary shadow-sm rounded-4 p-4 h-100 bg-body-tertiary">
                    <div class="text-primary mb-3 fs-1"><i class="bi bi-lightning-charge-fill"></i></div>
                    <h4 class="h5 fw-bold text-body">Respon Cepat</h4>
                    <p class="text-body-secondary small mb-0">Laporan yang masuk langsung diteruskan ke tim sarpras untuk segera ditinjau dan ditindaklanjuti.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card card-feature border border-body-tertiary shadow-sm rounded-4 p-4 h-100 bg-body-tertiary">
                    <div class="text-success mb-3 fs-1"><i class="bi bi-shield-check-fill"></i></div>
                    <h4 class="h5 fw-bold text-body">Transparan & Terpantau</h4>
                    <p class="text-body-secondary small mb-0">Siswa dapat melihat perkembangan status laporan mulai dari pending, diproses, hingga selesai.</p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card card-feature border border-body-tertiary shadow-sm rounded-4 p-4 h-100 bg-body-tertiary">
                    <div class="text-warning mb-3 fs-1"><i class="bi bi-sliders"></i></div>
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
            <div class="d-flex align-items-center mb-4">
                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3 me-3 fs-4 d-flex align-items-center justify-content-center">
                    <i class="bi bi-bar-chart-line-fill"></i>
                </div>
                <div>
                    <h3 class="h4 fw-bold mb-1 text-body">Statistik Kategori Pengaduan</h3>
                    <p class="text-body-secondary small mb-0">Ringkasan jumlah laporan berdasarkan kategori sarana & prasarana.</p>
                </div>
            </div>

            <div class="row g-3">
                @foreach (array_slice($kategoriChart, 0, 5) as $item)
                    @php
                        $persen = $maxjumlah > 0 ? round(($item['jumlah'] / $maxjumlah) * 100) : 0;
                    @endphp
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-semibold text-body small">{{ $item['nama'] }}</span>
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill small">{{ $item['jumlah'] }} Laporan</span>
                        </div>
                        <div class="progress rounded-pill" style="height: 10px;">
                            <div class="progress-bar bg-primary rounded-pill" role="progressbar" style="width: {{ $persen }}%" aria-valuenow="{{ $persen }}" aria-valuemin="0" aria-valuemax="100"></div>
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

    {{-- Pertanyaan Umum (FAQ) --}}
    <div class="mb-4 mb-lg-5">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-body">Pertanyaan Umum (FAQ)</h2>
            <p class="text-body-secondary">Jawaban atas pertanyaan yang sering diajukan mengenai sistem pengaduan.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border border-body-tertiary rounded-3 mb-2 overflow-hidden">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Siapa saja yang bisa mengajukan pengaduan fasilitas?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-body-secondary small">
                                Seluruh siswa, guru, dan staf sekolah yang telah memiliki akun terdaftar dapat mengajukan pengaduan kerusakan fasilitas melalui portal ini.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border border-body-tertiary rounded-3 mb-2 overflow-hidden">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Berapa lama laporan pengaduan diproses?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-body-secondary small">
                                Waktu penanganan bervariasi tergantung pada tingkat kerusakan dan ketersediaan suku cadang. Laporan biasanya ditinjau oleh tim sarpras dalam 1x24 jam kerja.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border border-body-tertiary rounded-3 mb-2 overflow-hidden">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Bagaimana cara mengetahui progres perbaikan?
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

    {{-- Banner Call to Action (CTA) --}}
    <div class="cta-banner rounded-4 text-white p-4 p-lg-5 text-center shadow-sm mb-3">
        <h3 class="fw-bold mb-2">Ada Fasilitas Sekolah yang Rusak?</h3>
        <p class="mb-4 opacity-75">Jangan biarkan kenyamanan belajar terganggu. Laporkan sekarang agar segera diperbaiki!</p>
        @if ($currentUser)
            <a href="{{ route('aspirasi.index') }}" class="btn btn-light btn-lg rounded-pill px-4 fw-bold text-primary btn-hover-bounce">
                <i class="bi bi-send-fill me-1"></i> Buat Laporan Sekarang
            </a>
        @else
            <a href="{{ route('login') }}" class="btn btn-light btn-lg rounded-pill px-4 fw-bold text-primary btn-hover-bounce">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk & Laporkan
            </a>
        @endif
    </div>

</div>
@endsection