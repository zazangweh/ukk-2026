@extends('layouts.app')

@section('title', config('app.name') . ' -- Kerangka PHP Ringan')

@section('content')

    {{-- Hero --}}
    <section class="text-center py-4 py-lg-5">
        <span class="badge rounded-pill badge-brand px-3 py-2 mb-3">Pengaduan sarpras v1.0.0</span>

        <h1 class="display-5 fw-bold mb-3">
            Pengaduan Sarana,<br class="d-none d-md-inline">
            <span class="text-brand">Prasarana</span>
        </h1>

       

        <div class="d-flex flex-wrap gap-2 justify-content-center">
            <a class="btn btn-brand btn-lg px-4" href="{{ route('kategori.index') }}">Kategori</a>
            <a class="btn btn-outline-brand btn-lg px-4" href="{{ route('kategori.index') }}" >????</a>
        </div>

       
    </section>

    
    @endsection
