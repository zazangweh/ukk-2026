@extends('layouts.app')

@section('title', 'Manajemen Kategori -- ' . config('app.name'))

@section('content')
<div class="container py-4">
    {{-- Header Halaman & Tombol Tambah --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kategori</li>
                </ol>
            </nav>
            <h1 class="h3 fw-bold text-dark mb-0">Manajemen Kategori Sarpras</h1>
        </div>
        <a href="{{ route('kategori.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm">
            <i class="bi bi-plus-circle-fill"></i> Tambah Kategori
        </a>
    </div>

    {{-- Tabel dalam Card Modern --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase fs-7">
                        <tr>
                            <th class="py-3 px-4" style="width: 10%;">No</th>
                            <th class="py-3">Keterangan Kategori</th>
                            <th class="py-3 text-end px-4" style="width: 25%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            // Menangani penomoran pagination agar tetap berlanjut di halaman berikutnya
                            $no = (method_exists($kategori, 'currentPage') && method_exists($kategori, 'perPage')) 
                                  ? ($kategori->currentPage() - 1) * $kategori->perPage() + 1 
                                  : 1; 
                        @endphp

                        @forelse ($kategori as $kategoris)
                        <tr>
                            <td class="px-4 text-muted fw-semibold">{{ $no++ }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                        <i class="bi bi-tag-fill small"></i>
                                    </div>
                                    <span class="fw-semibold text-dark">{{ $kategoris->keterangan }}</span>
                                </div>
                            </td>
                            <td class="text-end px-4">
                                <div class="d-flex justify-content-end gap-1">
                                    {{-- Route edit menggunakan id_kategori (sesuai kode asal) --}}
                                    <a href="{{ route('kategori.edit', ['id_kategori' => $kategoris->id_kategori]) }}" class="btn btn-warning btn-sm d-inline-flex align-items-center gap-1" title="Edit">
                                        <i class="bi bi-pencil-square"></i> <span class="d-none d-lg-inline">Edit</span>
                                    </a>

                                    {{-- Route destroy menggunakan id_kategori (sesuai kode asal) --}}
                                    <form action="{{ route('kategori.destroy', ['id_kategori' => $kategoris->id_kategori]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm d-inline-flex align-items-center gap-1" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')" title="Hapus">
                                            <i class="bi bi-trash3"></i> <span class="d-none d-lg-inline">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">
                                <div class="py-3">
                                    <i class="bi bi-tags display-4 text-secondary opacity-50 mb-3 d-block"></i>
                                    <p class="mb-1 fw-semibold">Belum ada data kategori.</p>
                                    <small>Silakan klik tombol "Tambah Kategori" di atas untuk membuat kategori baru.</small>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- Footer / Pagination --}}
        @if(method_exists($kategori, 'links') && $kategori->hasPages())
            <div class="card-footer bg-white py-3 px-4 border-top">
                <div class="d-flex justify-content-center justify-content-md-end">
                    {!! $kategori->links() !!}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection