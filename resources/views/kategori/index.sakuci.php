@extends('layouts.app')

@section('title', 'Daftar Kategori -- ' . config('app.name'))

@section('content')
<div class="container py-4">
    {{-- Header Halaman & Tombol Tambah --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active text-body-secondary" aria-current="page">Kategori</li>
                </ol>
            </nav>
            <h1 class="h3 fw-bold text-body mb-0">Daftar Kategori</h1>
        </div>

        <a href="{{ route('kategori.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm rounded-pill px-3">
            <i class="bi bi-plus-lg"></i> Tambah Kategori
        </a>
    </div>

    {{-- Pesan Sukses jika ada --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tabel dalam Card Modern --}}
    <div class="card border border-secondary-subtle shadow-sm rounded-4 overflow-hidden bg-body-tertiary">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-body-secondary text-body-secondary text-uppercase fs-7">
                        <tr>
                            <th class="py-3 px-4" style="width: 8%;">No</th>
                            <th class="py-3">Nama Kategori</th>
                            <th class="py-3 text-end px-4" style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $no = (method_exists($data, 'currentPage') && method_exists($data, 'perPage')) 
                                  ? ($data->currentPage() - 1) * $data->perPage() + 1 
                                  : 1; 
                        @endphp

                        @forelse ($data as $d)
                        <tr>
                            <td class="px-4 text-body-secondary fw-semibold">{{ $no++ }}</td>
                            <td>
                                <span class="fw-semibold text-body">{{ $d->nama_kategori }}</span>
                            </td>
                            <td class="text-end px-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('kategori.edit', ['kategori' => $d->id_kategori]) }}" class="btn btn-warning btn-sm d-inline-flex align-items-center gap-1" title="Edit">
                                        <i class="bi bi-pencil-square"></i> <span class="d-none d-sm-inline">Edit</span>
                                    </a>

                                    <form action="{{ route('kategori.destroy', ['kategori' => $d->id_kategori]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm d-inline-flex align-items-center gap-1" onclick="return confirm('Yakin hapus kategori ini?')" title="Hapus">
                                            <i class="bi bi-trash3"></i> <span class="d-none d-sm-inline">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-5 text-body-secondary">
                                <div class="py-3">
                                    <i class="bi bi-tags display-4 text-body-tertiary opacity-50 mb-3 d-block"></i>
                                    <p class="mb-1 fw-semibold text-body">Belum ada data kategori.</p>
                                    <small class="text-body-secondary">Kategori yang ditambahkan akan muncul di sini.</small>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- Footer / Pagination --}}
        @if(method_exists($data, 'links') && $data->hasPages())
            <div class="card-footer bg-body-tertiary py-3 px-4 border-top border-secondary-subtle">
                <div class="d-flex justify-content-center justify-content-md-end">
                    {!! $data->links() !!}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection