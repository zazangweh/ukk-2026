@extends('layouts.app')

@section('title', config('app.name') . ' -- Kerangka PHP Ringan')

@section('content')

    {{-- Hero --}}
    <section class="text-center py-4 py-lg-5">
        <span class="badge rounded-pill badge-brand px-3 py-2 mb-3">Pengaduan sarpras v1.0.0</span>

        <h1 class="display-5 fw-bold mb-3">
            Pengaduan Sarana,<br class="d-none d-md-inline">
            <span class="text-brand">Prasarana</span>
        </h1>

       

        <div class="d-flex flex-wrap gap-2 justify-content-center">
            <a class="btn btn-brand btn-lg px-4" href="{{ route('login') }}">login</a>
        </div>

       
    </section>
<div class="card d-flex">
  <div class="p-2 flex-fill">ℹ️ Tentang Aplikasi
<p>Pengaduan Sarana & Prasarana Sekolah merupakan aplikasi yang digunakan untuk memudahkan siswa dalam melaporkan kerusakan atau permasalahan pada fasilitas sekolah. Melalui aplikasi ini, siswa dapat menyampaikan pengaduan dengan informasi yang jelas, sementara admin dapat mengelola, memproses, dan memperbarui status pengaduan hingga selesai.

Aplikasi ini bertujuan untuk membuat proses pelaporan sarana dan prasarana menjadi lebih mudah, terorganisir, dan transparan, sehingga permasalahan fasilitas sekolah dapat ditangani dengan lebih baik.</div>
 </p>
</div>

<div class="card d-flex">
  <div class="p-2 flex-fill">🔁 Cara Pengaduan
  <ol>
  <li>Login</li>
   <li>Buat Pengaduan</li>
    <li>Diproses</li>
     <li>Selesai</li>
  </ol>
</div>
 </p>
</div>
    
    @endsection
