@extends('layouts.app')

@section('title', 'Edit Aspirasi -- ' . config('app.name'))

@section('content')
@php
    $currentUser = \App\Models\User::current();
    $isAdmin = $currentUser && isset($currentUser->role) && $currentUser->role === 'admin';
    $updateRoute = $isAdmin ? route('admin.aspirasi.update', ['id_aspirasi' => $aspirasi->id_aspirasi]) : route('aspirasi.update', ['id_aspirasi' => $aspirasi->id_aspirasi]);
    $cancelRoute = $isAdmin ? route('admin.aspirasi.index') : route('aspirasi.index');
@endphp

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            {{-- Breadcrumb & Header --}}
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ $cancelRoute }}" class="text-decoration-none">Daftar Aspirasi</a></li>
                    <li class="breadcrumb-item active text-body-secondary" aria-current="page">Edit Aspirasi</li>
                </ol>
            </nav>
            
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 fw-bold text-body mb-0">Edit Data Aspirasi</h1>
            </div>

            {{-- Card Form --}}
            <div class="card border border-secondary-subtle shadow-sm rounded-4 bg-body-tertiary">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ $updateRoute }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Kategori --}}
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
                                        <option value="{{ $kat->id_kategori }}" 
                                            {{ old('id_kategori', $aspirasi->id_kategori) == $kat->id_kategori ? 'selected' : '' }}>
                                            {{ $kat->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Judul --}}
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
                                       value="{{ old('judul', $aspirasi->judul) }}" 
                                       placeholder="Tuliskan judul aspirasi"
                                       required>
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-semibold text-body">Deskripsi Detail</label>
                            <textarea class="form-control bg-body border-secondary-subtle text-body @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="4" 
                                      placeholder="Jelaskan detail aspirasi atau keluhan Anda..."
                                      required>{{ old('deskripsi', $aspirasi->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Foto Bukti --}}
                        <div class="mb-3">
                            <label for="foto" class="form-label fw-semibold text-body">Foto Bukti</label>
                            
                            @if($aspirasi->foto)
                                <div class="mb-3 p-2 border border-secondary-subtle rounded-3 bg-body d-inline-block">
                                    <div class="text-body-secondary fs-7 mb-1"><i class="bi bi-image me-1"></i> Foto Saat Ini:</div>
                                    <img src="{{ asset('uploads/aspirasi/' . $aspirasi->foto) }}" alt="Foto Bukti" class="rounded-2 object-fit-cover" style="max-height: 140px; width: auto;">
                                </div>
                            @endif

                            <div class="input-group">
                                <span class="input-group-text bg-body-secondary border-secondary-subtle text-body-secondary">
                                    <i class="bi bi-paperclip"></i>
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
                                <i class="bi bi-info-circle me-1"></i> Biarkan kosong jika tidak ingin mengubah foto bukti.
                            </div>
                        </div>

                        {{-- Status Aspirasi (Khusus Admin) --}}
                        @if($isAdmin)
                            <div class="mb-4">
                                <label for="status" class="form-label fw-semibold text-body">Status Aspirasi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-secondary border-secondary-subtle text-body-secondary">
                                        <i class="bi bi-flag"></i>
                                    </span>
                                    <select name="status" 
                                            id="status" 
                                            class="form-select bg-body border-secondary-subtle text-body @error('status') is-invalid @enderror" 
                                            required>
                                        <option value="Pending" {{ old('status', $aspirasi->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Proses" {{ old('status', $aspirasi->status) == 'Proses' ? 'selected' : '' }}>Proses</option>
                                        <option value="Selesai" {{ old('status', $aspirasi->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        {{-- Tombol Aksi --}}
                        <div class="d-flex align-items-center justify-content-end gap-2 pt-3 border-top border-secondary-subtle">
                            <a href="{{ $cancelRoute }}" class="btn btn-outline-secondary rounded-pill px-4">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 d-inline-flex align-items-center gap-2 shadow-sm">
                                <i class="bi bi-check-circle"></i> Perbarui
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection