@extends ('layouts.app')
@section ('title', config('app.name') . ' -- Kerangka PHP Ringan')
@section('content')
<div class="container">
    <h1>Daftar Lokasi</h1>
    <a href="{{ route('admin.lokasi.create') }}" class="btn btn-primary mb-3 btn-sm">Tambah Kategori</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lokasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            @endphp
            @foreach ($lokasi as $x)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $x->nama_lokasi }}</td>
                <td>
                  <a href="{{ route('admin.lokasi.edit', ['id_lokasi' => $x->id_lokasi]) }}" class="btn btn-sm btn-success">Edit</a>
                  <form action="{{ route('admin.lokasi.delete', ['id' => $x->id_lokasi]) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus lokasi ini?')">Hapus</button>
                  </form>
                    </td>
</tr>
@endforeach
        </tbody>
    </table>
</div>
    {!! $lokasi->links() !!}
@endsection