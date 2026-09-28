@extends('layouts.app')

@section('content')
<form action="{{ route('admin.lokasi.update', ['id_lokasi' => $lokasi->id_lokasi]) }}" method="post" class="d-flex flex-column form-horizontal">
    @csrf
    @method('POST')

    <label>Nama Lokasi</label>    
    <input type="text" name="nama_lokasi" value="{{ $lokasi->nama_lokasi }}" class="form-control mb-3" required>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection