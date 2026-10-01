@extends('layouts.app')

@section('content')
@php
    $currentUser = \App\Models\User::current();
    
    // Tentukan route update & cancel berdasarkan role user yang sedang login
    $isAdmin = $currentUser && isset($currentUser->role) && $currentUser->role === 'admin';
    $updateRoute = $isAdmin ? route('admin.aspirasi.update', ['id_aspirasi' => $aspirasi->id_aspirasi]) : route('aspirasi.update', ['id_aspirasi' => $aspirasi->id_aspirasi]);
    $cancelRoute = $isAdmin ? route('admin.aspirasi.index') : route('aspirasi.index');
@endphp

<div class="container py-3">
    <h1 class="mb-4 fs-3 fw-bold">Edit Aspirasi</h1>

    <form action="{{ $updateRoute }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- 1. Kategori -->
        <div class="form-group mb-3">
            <label for="id_kategori" class="form-label fw-semibold">Kategori</label>
            <select name="id_kategori" id="id_kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategori as $kat)
                    <option value="{{ $kat->id_kategori }}" {{ $aspirasi->id_kategori == $kat->id_kategori ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- 2. Judul -->
        <div class="form-group mb-3">
            <label for="judul" class="form-label fw-semibold">Judul Aspirasi</label>
            <input type="text" class="form-control" id="judul" name="judul" value="{{ $aspirasi->judul }}" required>
        </div>

        <!-- 3. Deskripsi -->
        <div class="form-group mb-3">
            <label for="deskripsi" class="form-label fw-semibold">Deskripsi Detail</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required>{{ $aspirasi->deskripsi }}</textarea>
        </div>

        <!-- 4. Pratinjau & Ubah Foto -->
        <div class="form-group mb-3">
            <label for="foto" class="form-label fw-semibold">Foto Bukti</label>
            @if($aspirasi->foto)
                <div class="mb-2">
                    <img src="{{ asset('uploads/aspirasi/' . $aspirasi->foto) }}" alt="Foto Bukti" width="120" class="rounded border shadow-sm">
                </div>
            @endif
            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4 fw-semibold">Update</button>
            <a href="{{ $cancelRoute }}" class="btn btn-secondary px-4">Batal</a>
        </div>
        @if($isAdmin)
             <div class="form-group mb-3">
                <label for="status" class="form-label fw-semibold">Status Aspirasi</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="Pending" {{ $aspirasi->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Proses" {{ $aspirasi->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                  <option value="Selesai" {{ $aspirasi->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                 </select>
           </div>
         @endif
    </form>
</div>
@endsection