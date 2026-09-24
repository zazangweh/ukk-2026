@extends('layouts.app')

@section('title', 'Manajemen Pengguna -- ' . config('app.name'))

@section('content')
<div class="container py-4">
    {{-- Header Halaman & Tombol Tambah --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
                </ol>
            </nav>
            <h1 class="h3 fw-bold text-dark mb-0">Manajemen Pengguna / Siswa</h1>
        </div>
        <a href="{{ route('pengguna.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm">
            <i class="bi bi-person-plus-fill"></i> Tambah Pengguna
        </a>
    </div>

    {{-- Tabel dalam Card Modern --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-uppercase fs-7">
                        <tr>
                            <th class="py-3 px-4" style="width: 5%;">No</th>
                            <th class="py-3">Nama</th>
                            <th class="py-3">NIS</th>
                            <th class="py-3">Kelas</th>
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
                            <td class="px-4 text-muted fw-semibold">{{ $no++ }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 35px; height: 35px; font-size: 0.85rem;">
                                        {{ strtoupper(substr($d->nama, 0, 2)) }}
                                    </div>
                                    <span class="fw-semibold text-dark">{{ $d->nama }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1 font-monospace">{{ $d->nis }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-2 py-1">{{ $d->kelas }}</span>
                            </td>
                            <td class="text-end px-4">
                                <div class="d-flex justify-content-end gap-1">
                                    {{-- Route edit menggunakan id_siswa (sesuai kode asal) --}}
                                    <a href="{{ route('pengguna.edit', ['pengguna' => $d->id_siswa]) }}" class="btn btn-warning btn-sm d-inline-flex align-items-center gap-1" title="Edit">
                                        <i class="bi bi-pencil-square"></i> <span class="d-none d-lg-inline">Edit</span>
                                    </a>

                                    {{-- Route destroy menggunakan id (sesuai kode asal) --}}
                                    <form action="{{ route('pengguna.destroy', ['pengguna' => $d->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm d-inline-flex align-items-center gap-1" onclick="return confirm('yang bener mau di hapus nihh?')" title="Hapus">
                                            <i class="bi bi-trash3"></i> <span class="d-none d-lg-inline">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="py-3">
                                    <i class="bi bi-folder2-open display-4 text-secondary opacity-50 mb-3 d-block"></i>
                                    <p class="mb-1 fw-semibold">Belum ada data pengguna.</p>
                                    <small>Silakan klik tombol "Tambah Pengguna" di atas.</small>
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
            <div class="card-footer bg-white py-3 px-4 border-top">
                <div class="d-flex justify-content-center justify-content-md-end">
                    {!! $data->links() !!}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection