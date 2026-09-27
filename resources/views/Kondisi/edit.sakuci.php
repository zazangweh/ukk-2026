@extends('layouts.app')

@section('content')
<form action="{{ route('admin.kondisi.update', ['id_kondisi' => $kondisi->id_kondisi]) }}" method="post" class="d-flex flex-column form-horizontal">
    @csrf
    @method('POST')

    <label>Nama Kondisi</label>    
    <input type="text" name="nama_kondisi" value="{{ $kondisi->nama_kondisi }}" class="form-control mb-3" required>

    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
@endsection