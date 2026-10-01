@extends('layouts.app')

@section('title', 'Daftar Alat -- ' . config('app.name'))

@section('content')
@php
    $currentUser = \App\Models\User::current();
    $isStaffOrAdmin = $currentUser && isset($currentUser->role) && $currentUser->role !== 'siswa';
@endphp

<div class="container py-4">
    {{-- Header Halaman & Tombol Tambah --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active text-body-secondary" aria-current="page">Daftar Alat</li>
                </ol>
            </nav>
            <h1 class="h3 fw-bold text-body mb-0">Daftar Alat & Sarana</h1>
        </div>

        {{-- Tombol Tambah Alat hanya muncul jika bukan siswa (admin/petugas) --}}
        @if($isStaffOrAdmin)
            <a href="{{ route('alat.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm rounded-pill px-3">
                <i class="bi bi-plus-lg"></i> Tambah Alat
            </a>
        @endif
    </div>

    {{-- Tabel dalam Card Modern --}}
    <div class="card border border-secondary-subtle shadow-sm rounded-4 overflow-hidden bg-body-tertiary">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-body-secondary text-body-secondary text-uppercase fs-7">
                        <tr>
                            <th class="py-3 px-4" style="width: 5%;">No</th>
                            <th class="py-3">Kategori</th>
                            <th class="py-3">Nama Alat</th>
                            <th class="py-3">Kode Alat</th>
                            <th class="py-3">Kondisi</th>
                            <th class="py-3">Jumlah</th>
                            <th class="py-3">Lokasi</th>
                            @if($isStaffOrAdmin)
                                <th class="py-3 text-end px-4" style="width: 15%;">Aksi</th>
                            @endif
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
                                <span class="badge bg-body-secondary text-body-emphasis border border-secondary-subtle px-2 py-1">
                                    {{ $d->kategori->nama_kategori ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-semibold text-body">{{ $d->nama_alat }}</span>
                            </td>
                            <td>
                                <span class="badge bg-body-secondary text-body-emphasis font-monospace border border-secondary-subtle px-2 py-1">
                                    {{ $d->kode_alat }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $kondisiLower = strtolower($d->kondisi);
                                    $badgeClass = str_contains($kondisiLower, 'baik') ? 'bg-success-subtle text-success-emphasis' : 'bg-warning-subtle text-warning-emphasis';
                                @endphp
                                <span class="badge {{ $badgeClass }} px-2 py-1">
                                    {{ $d->kondisi }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold text-body">{{ $d->jumlah }}</span>
                            </td>
                            <td>
                                <span class="text-body-secondary"><i class="bi bi-geo-alt me-1"></i>{{ $d->lokasi }}</span>
                            </td>
                            
                            {{-- Tombol Edit & Hapus hanya dipasang untuk Admin/Petugas --}}
                            @if($isStaffOrAdmin)
                            <td class="text-end px-4">
                                <div class="d-flex justify-content-end gap-1">
                                    <a href="{{ route('alat.edit', ['alat' => $d->id_alat]) }}" class="btn btn-warning btn-sm d-inline-flex align-items-center gap-1" title="Edit">
                                        <i class="bi bi-pencil-square"></i> <span class="d-none d-lg-inline">Edit</span>
                                    </a>

                                    <form action="{{ route('alat.destroy', ['alat' => $d->id_alat]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm d-inline-flex align-items-center gap-1" onclick="return confirm('Yakin mau hapus?')" title="Hapus">
                                            <i class="bi bi-trash3"></i> <span class="d-none d-lg-inline">Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ $isStaffOrAdmin ? 8 : 7 }}" class="text-center py-5 text-body-secondary">
                                <div class="py-3">
                                    <i class="bi bi-tools display-4 text-body-tertiary opacity-50 mb-3 d-block"></i>
                                    <p class="mb-1 fw-semibold text-body">Belum ada data alat.</p>
                                    <small class="text-body-secondary">Data sarana dan peralatan akan muncul di sini.</small>
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