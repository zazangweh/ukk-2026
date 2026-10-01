@extends('layouts.app')

@section('content')
@php
    $currentUser = \App\Models\User::current();
    $isAdmin = $currentUser && isset($currentUser->role) && $currentUser->role === 'admin';
@endphp

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Daftar Aspirasi</h1>
        <a href="{{ route('aspirasi.create') }}" class="btn btn-primary">Tambah Aspirasi</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Tanggapan Admin</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($item->foto)
                                <img src="{{ asset('uploads/aspirasi/' . $item->foto) }}" alt="Foto" width="70" class="rounded">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ $item->deskripsi }}</td>
                        
                        {{-- Kolom Tanggapan Admin --}}
                        <td>
                            @if(!empty($item->tanggapan))
                                <span class="text-success fw-semibold">{{ $item->tanggapan }}</span>
                            @else
                                <span class="text-muted fs-7">Belum ditanggapi</span>
                            @endif
                        </td>

                        {{-- Status Dinamis --}}
                        <td>
                            @if(strtolower($item->status) === 'selesai')
                                <span class="badge bg-success text-white">Selesai</span>
                            @elseif(strtolower($item->status) === 'proses')
                                <span class="badge bg-info text-dark">Proses</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>

                        <td>
                            @if($isAdmin)
                                {{-- Tombol Tanggapi untuk Admin --}}
                                <button type="button" class="btn btn-sm btn-info text-white me-1" data-bs-toggle="modal" data-bs-target="#modalTanggapan{{ $item->id_aspirasi }}">
                                    Tanggapi
                                </button>

                                <a href="{{ route('admin.aspirasi.edit', ['id_aspirasi' => $item->id_aspirasi]) }}" class="btn btn-sm btn-warning">Edit</a>
                            @endif
                            
                            @php
                                $destroyRoute = $isAdmin 
                                    ? route('admin.aspirasi.destroy', ['id_aspirasi' => $item->id_aspirasi]) 
                                    : route('aspirasi.destroy', ['id_aspirasi' => $item->id_aspirasi]);
                            @endphp

                            <form action="{{ $destroyRoute }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>

                            {{-- Modal Pop-up Input Tanggapan Admin --}}
                            @if($isAdmin)
                            <div class="modal fade" id="modalTanggapan{{ $item->id_aspirasi }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Beri Tanggapan Aspirasi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.aspirasi.tanggapi', ['id_aspirasi' => $item->id_aspirasi]) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Judul Aspirasi:</label>
                                                    <p class="text-muted mb-1">{{ $item->judul }}</p>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tanggapan" class="form-label fw-bold">Isi Tanggapan:</label>
                                                    <textarea class="form-control" name="tanggapan" id="tanggapan" rows="4" placeholder="Tuliskan tanggapan atau tindakan yang telah dilakukan..." required>{{ $item->tanggapan }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Kirim & Tandai Selesai</button>
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
                        <td colspan="8" class="text-center">Belum ada data aspirasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection