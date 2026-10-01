@extends('layouts.app')

@section('title', 'Edit Kategori -- ' . config('app.name'))

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            
            {{-- Breadcrumb & Header --}}
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('kategori.index') }}" class="text-decoration-none">Daftar Kategori</a></li>
                    <li class="breadcrumb-item active text-body-secondary" aria-current="page">Edit Kategori</li>
                </ol>
            </nav>
            
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 fw-bold text-body mb-0">Edit Kategori</h1>
            </div>

            {{-- Card Form --}}
            <div class="card border border-secondary-subtle shadow-sm rounded-4 bg-body-tertiary">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('kategori.update', ['kategori' => $kategori->id_kategori]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Input Nama Kategori --}}
                        <div class="mb-4">
                            <label for="nama_kategori" class="form-label fw-semibold text-body">Nama / Keterangan Kategori</label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-secondary border-secondary-subtle text-body-secondary">
                                    <i class="bi bi-tag"></i>
                                </span>
                                <input type="text" 
                                       class="form-control bg-body border-secondary-subtle text-body @error('nama_kategori') is-invalid @enderror" 
                                       id="nama_kategori" 
                                       name="nama_kategori"
                                       value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
                                       placeholder="Masukkan nama kategori"
                                       required>
                                @error('nama_kategori')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex align-items-center justify-content-end gap-2 pt-3 border-top border-secondary-subtle">
                            <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
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