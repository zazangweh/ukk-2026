@extends('layouts.app')

@section('title', 'Daftar Aspirasi -- ' . config('app.name'))

@section('content')
@php
    $currentUser = \App\Models\User::current();
    $isAdmin = $currentUser && isset($currentUser->role) && $currentUser->role === 'admin';
@endphp

<div class="container py-4">
    {{-- Header Halaman & Tombol Tambah --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active text-body-secondary" aria-current="page">Daftar Aspirasi</li>
                </ol>
            </nav>
            <h1 class="h3 fw-bold text-body mb-0">Daftar Aspirasi & Pengaduan</h1>
        </div>

        <a href="{{ route('aspirasi.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm rounded-pill px-3">
            <i class="bi bi-plus-lg"></i> Tambah Aspirasi
        </a>
    </div>

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Card Main Table --}}
    <div class="card border border-secondary-subtle shadow-sm rounded-4 overflow-hidden bg-body-tertiary">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-body-secondary text-body-secondary text-uppercase fs-7">
                        <tr>
                            <th class="py-3 px-4" style="width: 5%;">No</th>
                            <th class="py-3" style="width: 8%;">Foto</th>
                            <th class="py-3">Judul</th>
                            <th class="py-3">Kategori</th>
                            <th class="py-3" style="width: 25%;">Deskripsi</th>
                            <th class="py-3" style="width: 20%;">Tanggapan Admin</th>
                            <th class="py-3">Status</th>
                            <th class="py-3 text-end px-4" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $no = (method_exists($data, 'currentPage') && method_exists($data, 'perPage')) 
                                  ? ($data->currentPage() - 1) * $data->perPage() + 1 
                                  : 1; 
                        @endphp

                        @forelse($data as $item)
                            <tr>
                                <td class="px-4 text-body-secondary fw-semibold">{{ $no++ }}</td>
                                
                                {{-- Foto --}}
                                <td>
                                    @if($item->foto)
                                        <img src="{{ asset('uploads/aspirasi/' . $item->foto) }}" alt="Foto Aspirasi" class="rounded-3 object-fit-cover border border-secondary-subtle" width="55" height="55">
                                    @else
                                        <div class="bg-body-secondary text-body-tertiary rounded-3 d-flex align-items-center justify-content-center border border-secondary-subtle" style="width: 55px; height: 55px;">
                                            <i class="bi bi-image fs-4"></i>
                                        </div>
                                    @endif
                                </td>

                                {{-- Judul --}}
                                <td>
                                    <span class="fw-semibold text-body">{{ $item->judul }}</span>
                                </td>

                                {{-- Kategori --}}
                                <td>
                                    <span class="badge bg-body-secondary text-body-emphasis border border-secondary-subtle px-2 py-1">
                                        {{ $item->kategori->nama_kategori ?? '-' }}
                                    </span>
                                </td>

                                {{-- Deskripsi --}}
                                <td>
                                    <p class="text-body-secondary mb-0 text-truncate" style="max-width: 250px;" title="{{ $item->deskripsi }}">
                                        {{ $item->deskripsi }}
                                    </p>
                                </td>

                                {{-- Kolom Tanggapan Admin --}}
                                <td>
                                    @if(!empty($item->tanggapan))
                                        <div class="p-2 rounded-3 bg-success-subtle text-success-emphasis border border-success-subtle fs-7">
                                            <i class="bi bi-chat-left-text-fill me-1"></i> {{ $item->tanggapan }}
                                        </div>
                                    @else
                                        <span class="text-body-tertiary fst-italic fs-7">Belum ditanggapi</span>
                                    @endif
                                </td>

                                {{-- Status Dinamis --}}
                                <td>
                                    @php
                                        $statusLower = strtolower($item->status);
                                    @endphp
                                    @if($statusLower === 'selesai')
                                        <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle px-2 py-1">
                                            <i class="bi bi-check-circle me-1"></i> Selesai
                                        </span>
                                    @elseif($statusLower === 'proses')
                                        <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle px-2 py-1">
                                            <i class="bi bi-arrow-repeat me-1"></i> Proses
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1">
                                            <i class="bi bi-clock me-1"></i> Pending
                                        </span>
                                    @endif
                                </td>

                                {{-- Kolom Aksi --}}
                                <td class="text-end px-4">
                                    <div class="d-flex justify-content-end gap-1">
                                        @if($isAdmin)
                                            {{-- Tombol Tanggapi untuk Admin --}}
                                            <button type="button" class="btn btn-sm btn-info text-white d-inline-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#modalTanggapan{{ $item->id_aspirasi }}" title="Tanggapi">
                                                <i class="bi bi-reply-fill"></i> <span class="d-none d-lg-inline">Tanggapi</span>
                                            </button>

                                            <a href="{{ route('admin.aspirasi.edit', ['id_aspirasi' => $item->id_aspirasi]) }}" class="btn btn-sm btn-warning d-inline-flex align-items-center gap-1" title="Edit">
                                                <i class="bi bi-pencil-square"></i> <span class="d-none d-lg-inline">Edit</span>
                                            </a>
                                        @endif
                                        
                                        @php
                                            $destroyRoute = $isAdmin 
                                                ? route('admin.aspirasi.destroy', ['id_aspirasi' => $item->id_aspirasi]) 
                                                : route('aspirasi.destroy', ['id_aspirasi' => $item->id_aspirasi]);
                                        @endphp

                                        <form action="{{ $destroyRoute }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger d-inline-flex align-items-center gap-1" title="Hapus">
                                                <i class="bi bi-trash3"></i> <span class="d-none d-lg-inline">Hapus</span>
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Modal Pop-up Input Tanggapan Admin --}}
                                    @if($isAdmin)
                                    <div class="modal fade text-start" id="modalTanggapan{{ $item->id_aspirasi }}" tabindex="-1" aria-labelledby="modalLabel{{ $item->id_aspirasi }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content bg-body-tertiary border border-secondary-subtle rounded-4 shadow">
                                                <div class="modal-header border-bottom border-secondary-subtle">
                                                    <h5 class="modal-title fw-bold text-body" id="modalLabel{{ $item->id_aspirasi }}">Beri Tanggapan Aspirasi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.aspirasi.tanggapi', ['id_aspirasi' => $item->id_aspirasi]) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold text-body">Judul Aspirasi:</label>
                                                            <div class="p-2 rounded bg-body-secondary text-body border border-secondary-subtle">
                                                                {{ $item->judul }}
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="tanggapan{{ $item->id_aspirasi }}" class="form-label fw-semibold text-body">Isi Tanggapan:</label>
                                                            <textarea class="form-control bg-body text-body border-secondary-subtle" name="tanggapan" id="tanggapan{{ $item->id_aspirasi }}" rows="4" placeholder="Tuliskan tanggapan atau tindakan yang telah dilakukan..." required>{{ $item->tanggapan }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-top border-secondary-subtle">
                                                        <button type="button" class="btn btn-outline-secondary rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary rounded-pill px-3 d-inline-flex align-items-center gap-1">
                                                            <i class="bi bi-send-fill"></i> Kirim & Tandai Selesai
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-body-secondary">
                                    <div class="py-3">
                                        <i class="bi bi-chat-square-quote display-4 text-body-tertiary opacity-50 mb-3 d-block"></i>
                                        <p class="mb-1 fw-semibold text-body">Belum ada data aspirasi.</p>
                                        <small class="text-body-secondary">Aspirasi dan pengaduan dari pengguna akan muncul di sini.</small>
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