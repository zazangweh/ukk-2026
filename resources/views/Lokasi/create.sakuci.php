@extends ('layouts.app')
@section ('content')

<div class="container">
    <h1>Tambah Lokasi</h1>
    <form action="{{ route('admin.lokasi.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="nama_lokasi">Nama Lokasi</label>
            <input type="text" class="form-control" id="nama_lokasi" name="nama_lokasi" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection