@extends('layouts.app')

@section('content')
@php
    $currentUser = \App\Models\User::current();
@endphp

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Daftar Alat</h1>

    {{-- Tombol Tambah Alat hanya muncul jika bukan siswa (admin/petugas) --}}
    @if($currentUser && isset($currentUser->role) && $currentUser->role !== 'siswa')
        <a href="{{ route('alat.create') }}" class="btn btn-primary">Tambah Alat</a>
    @endif
</div>

<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>No</th>
            <th>Kategori</th>
            <th>Nama Alat</th>
            <th>Kode Alat</th>
            <th>Kondisi</th>
            <th>Jumlah</th>
            <th>Lokasi</th>
            {{-- Kolom Aksi hanya dipasang untuk Admin/Petugas --}}
            @if($currentUser && isset($currentUser->role) && $currentUser->role !== 'siswa')
                <th>Aksi</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach ($data as $d)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $d->kategori->nama_kategori ?? '-' }}</td>
            <td>{{ $d->nama_alat }}</td>
            <td>{{ $d->kode_alat }}</td>
            <td>{{ $d->kondisi }}</td>
            <td>{{ $d->jumlah }}</td>
            <td>{{ $d->lokasi }}</td>
            
            {{-- Tombol Edit & Hapus hanya dipasang untuk Admin/Petugas --}}
            @if($currentUser && isset($currentUser->role) && $currentUser->role !== 'siswa')
            <td>
                <a href="{{ route('alat.edit', ['alat' => $d->id_alat]) }}" class="btn btn-warning btn-sm">Edit</a>

                <form action="{{ route('alat.destroy', ['alat' => $d->id_alat]) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus?')">Hapus</button>
                </form>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>

{!! $data->links() !!}
@endsection