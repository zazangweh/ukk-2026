@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>edit Kategori</h1>
        <form action="{{ route('kategori.update', ['kategori' => $kategori->id_kategori]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <input type="text" class="form-control" id="keterangan" name="keterangan" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection