@extends('layouts.app')

@section('title', 'Edit Pengguna -- ' . config('app.name'))

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            {{-- Breadcrumb & Header --}}
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pengguna.index') }}" class="text-decoration-none">Pengguna</a></li>
                    <li class="breadcrumb-item active text-body-secondary" aria-current="page">Edit Pengguna</li>
                </ol>
            </nav>
            
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 fw-bold text-body mb-0">Edit Data Pengguna</h1>
            </div>

            {{-- Card Form --}}
            <div class="card border border-secondary-subtle shadow-sm rounded-4 bg-body-tertiary">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('pengguna.update', ['pengguna' => $siswa->id_siswa]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Input Nama --}}
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-semibold text-body">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-secondary border-secondary-subtle text-body-secondary">
                                    <i class="bi bi-person"></i>
                                </span>
                                <input type="text" 
                                       class="form-control bg-body border-secondary-subtle text-body @error('nama') is-invalid @enderror" 
                                       id="nama" 
                                       name="nama" 
                                       value="{{ old('nama', $siswa->nama) }}" 
                                       placeholder="Masukkan nama lengkap"
                                       required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Input NIS --}}
                        <div class="mb-3">
                            <label for="nis" class="form-label fw-semibold text-body">NIS (Nomor Induk Siswa)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-secondary border-secondary-subtle text-body-secondary">
                                    <i class="bi bi-card-heading"></i>
                                </span>
                                <input type="text" 
                                       class="form-control bg-body border-secondary-subtle text-body font-monospace @error('nis') is-invalid @enderror" 
                                       id="nis" 
                                       name="nis" 
                                       value="{{ old('nis', $siswa->nis) }}" 
                                       placeholder="Masukkan NIS"
                                       required>
                                @error('nis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Input Kelas --}}
                        <div class="mb-4">
                            <label for="kelas" class="form-label fw-semibold text-body">Kelas</label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-secondary border-secondary-subtle text-body-secondary">
                                    <i class="bi bi-door-closed"></i>
                                </span>
                                <input type="text" 
                                       class="form-control bg-body border-secondary-subtle text-body @error('kelas') is-invalid @enderror" 
                                       id="kelas" 
                                       name="kelas" 
                                       value="{{ old('kelas', $siswa->kelas) }}" 
                                       placeholder="Contoh: XII RPL 1"
                                       required>
                                @error('kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex align-items-center justify-content-end gap-2 pt-2 border-top border-secondary-subtle">
                            <a href="{{ route('pengguna.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
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