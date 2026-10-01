@extends('layouts.app')

@section('title', 'Tambah Aspirasi -- ' . config('app.name'))

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            {{-- Breadcrumb & Header --}}
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('aspirasi.index') }}" class="text-decoration-none">Daftar Aspirasi</a></li>
                    <li class="breadcrumb-item active text-body-secondary" aria-current="page">Tambah Aspirasi</li>
                </ol>
            </nav>
            
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 fw-bold text-body mb-0">Sampaikan Aspirasi Baru</h1>
            </div>

            {{-- Card Form --}}
            <div class="card border border-secondary-subtle shadow-sm rounded-4 bg-body-tertiary">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('aspirasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Dropdown Kategori --}}
                        <div class="mb-3">
                            <label for="id_kategori" class="form-label fw-semibold text-body">Kategori Aspirasi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-secondary border-secondary-subtle text-body-secondary">
                                    <i class="bi bi-tags"></i>
                                </span>
                                <select name="id_kategori" 
                                        id="id_kategori" 
                                        class="form-select bg-body border-secondary-subtle text-body @error('id_kategori') is-invalid @enderror" 
                                        required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategori as $kat)
                                        <option value="{{ $kat->id_kategori }}" {{ old('id_kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                            {{ $kat->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Input Judul --}}
                        <div class="mb-3">
                            <label for="judul" class="form-label fw-semibold text-body">Judul Aspirasi</label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-secondary border-secondary-subtle text-body-secondary">
                                    <i class="bi bi-type-h1"></i>
                                </span>
                                <input type="text" 
                                       class="form-control bg-body border-secondary-subtle text-body @error('judul') is-invalid @enderror" 
                                       id="judul" 
                                       name="judul" 
                                       value="{{ old('judul') }}"
                                       placeholder="Masukkan judul aspirasi" 
                                       required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Input Deskripsi --}}
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-semibold text-body">Deskripsi Detail</label>
                            <textarea class="form-control bg-body border-secondary-subtle text-body @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="4" 
                                      placeholder="Jelaskan detail pengaduan atau aspirasi Anda..." 
                                      required>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Upload Foto Bukti --}}
                        <div class="mb-4">
                            <label for="foto" class="form-label fw-semibold text-body">Foto Bukti (Opsional)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-secondary border-secondary-subtle text-body-secondary">
                                    <i class="bi bi-image"></i>
                                </span>
                                <input type="file" 
                                       class="form-control bg-body border-secondary-subtle text-body @error('foto') is-invalid @enderror" 
                                       id="foto" 
                                       name="foto" 
                                       accept="image/*">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text text-body-secondary fs-7 mt-1">
                                <i class="bi bi-info-circle me-1"></i> Unggah foto berformat JPG, PNG, atau WEBP jika ada lokasi/kondisi yang perlu diperlihatkan.
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex align-items-center justify-content-end gap-2 pt-3 border-top border-secondary-subtle">
                            <a href="{{ route('aspirasi.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 d-inline-flex align-items-center gap-2 shadow-sm">
                                <i class="bi bi-send-fill"></i> Kirim Aspirasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection