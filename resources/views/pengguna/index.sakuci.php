@extends('layouts.app')

@section('title', config('app.name') . ' -- Kerangka PHP Ringan')

@section('content')
<h1>kategori</h1>
<a href="{{ route('kategori.create') }}" class="btn btn-primary mb-3">Tambah Kategori</a>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th >no</th>
            <th>Keterangan</th>
            <th>aksi</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach ($kategori as $kategoris)
        <tr>

            <td>{{ $no++ }}</td>
            <td>{{ $kategoris->keterangan }}</td>
        <td>
           <a href="{{ route('kategori.edit', ['id_kategori' => $kategoris->id_kategori]) }}" class="btn btn-primary">Edit</a>
              <form action="{{ route('kategori.destroy', ['id_kategori' => $kategoris->id_kategori]) }}" method="POST" style="display: inline-block;">
                 @csrf
                 @method('DELETE')
                 <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</button>
                </form>
        </td>
                
        </tr>
        @endforeach
    </tbody>
    </table>
    {!! $kategori->links() !!}
@endsection