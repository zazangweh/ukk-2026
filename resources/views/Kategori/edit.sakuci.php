@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>edit Kategori</h1>
        <form action="{{ route('kategori.update', ['id_kategori' => $kategori->id_kategori]) }}" method="POST" class="form-horizontal">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ $kategori->keterangan }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection