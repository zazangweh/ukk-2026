@extends ('layouts.app')
@section ('title', config('app.name') . ' -- Kerangka PHP Ringan')
@section('content')
<div class="container">
    <h1>Daftar Kondisi</h1>
    <a href="{{ route('admin.kondisi.create') }}" class="btn btn-primary mb-3 btn-sm">Tambah Kondisi</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kondisi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 1;
            @endphp
            @foreach ($kondisi as $x)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $x->nama_kondisi }}</td>
                <td>
                  <a href="{{ route('admin.kondisi.edit', ['id_kondisi' => $x->id_kondisi]) }}" class="btn btn-sm btn-success">Edit</a>
                  <form action="{{ route('admin.kondisi.delete', ['id' => $x->id_kondisi]) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus Kondisi ini?')">Hapus</button>
                  </form>
                </td>
</tr>
@endforeach
        </tbody>
    </table>
</div>
    {!! $kondisi->links() !!}
@endsection