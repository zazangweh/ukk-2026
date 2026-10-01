@extends('layouts.app')

@section('title', 'Tambah Alat -- ' . config('app.name'))

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            {{-- Breadcrumb & Header --}}
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('alat.index') }}" class="text-decoration-none">Daftar Alat</a></li>
                    <li class="breadcrumb-item active text-body-secondary" aria-current="page">Tambah Alat</li>
                </ol>
            </nav>
            
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 fw-bold text-body mb-0">Tambah Alat Baru</h1>
            </div>

            {{-- Card Form --}}
            <div class="card border border-secondary-subtle shadow-sm rounded-4 bg-body-tertiary">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('alat.store') }}" method="POST">
                        @csrf

                        {{-- Kategori Alat --}}
                        <div class="mb-3">
                            <label for="id_kategori" class="form-label fw-semibold text-body">Kategori Alat</label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-secondary border-secondary-subtle text-body-secondary">
                                    <i class="bi bi-tags"></i>
                                </span>
                                <select name="id_kategori" 
                                        id="id_kategori" 
                                        class="form-select bg-body border-secondary-subtle text-body @error('id_kategori') is-invalid @enderror" 
                                        required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($kategori as $k)
                                        <option value="{{ $k->id_kategori }}" {{ old('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                                            {{ $k->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Nama Alat --}}
                        <div class="mb-3">
                            <label for="nama_alat" class="form-label fw-semibold text-body">Nama Alat</label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-secondary border-secondary-subtle text-body-secondary">
                                    <i class="bi bi-tools"></i>
                                </span>
                                <input type="text" 
                                       class="form-control bg-body border-secondary-subtle text-body @error('nama_alat') is-invalid @enderror" 
                                       id="nama_alat" 
                                       name="nama_alat" 
                                       value="{{ old('nama_alat') }}" 
                                       placeholder="Masukkan nama alat"
                                       required>
                                @error('nama_alat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Kode Alat & Jumlah (Row 2 Kolom) --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="kode_alat" class="form-label fw-semibold text-body">Kode Alat</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-secondary border-secondary-subtle text-body-secondary">
                                        <i class="bi bi-qr-code"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control bg-body border-secondary-subtle text-body font-monospace @error('kode_alat') is-invalid @enderror" 
                                           id="kode_alat" 
                                           name="kode_alat" 
                                           value="{{ old('kode_alat') }}" 
                                           placeholder="Contoh: ALT-001"
                                           required>
                                    @error('kode_alat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="jumlah" class="form-label fw-semibold text-body">Jumlah</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-secondary border-secondary-subtle text-body-secondary">
                                        <i class="bi bi-hash"></i>
                                    </span>
                                    <input type="number" 
                                           class="form-control bg-body border-secondary-subtle text-body @error('jumlah') is-invalid @enderror" 
                                           id="jumlah" 
                                           name="jumlah" 
                                           value="{{ old('jumlah') }}" 
                                           min="0"
                                           placeholder="0"
                                           required>
                                    @error('jumlah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Kondisi & Lokasi (Row 2 Kolom) --}}
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="kondisi" class="form-label fw-semibold text-body">Kondisi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-secondary border-secondary-subtle text-body-secondary">
                                        <i class="bi bi-info-circle"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control bg-body border-secondary-subtle text-body @error('kondisi') is-invalid @enderror" 
                                           id="kondisi" 
                                           name="kondisi" 
                                           value="{{ old('kondisi') }}" 
                                           placeholder="Contoh: Baik / Perlu Perbaikan"
                                           required>
                                    @error('kondisi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="lokasi" class="form-label fw-semibold text-body">Lokasi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-secondary border-secondary-subtle text-body-secondary">
                                        <i class="bi bi-geo-alt"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control bg-body border-secondary-subtle text-body @error('lokasi') is-invalid @enderror" 
                                           id="lokasi" 
                                           name="lokasi" 
                                           value="{{ old('lokasi') }}" 
                                           placeholder="Contoh: Bengkel TKJ / Lab 2"
                                           required>
                                    @error('lokasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex align-items-center justify-content-end gap-2 pt-3 border-top border-secondary-subtle">
                            <a href="{{ route('alat.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 d-inline-flex align-items-center gap-2 shadow-sm">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection