@extends('layouts.app')

@section('title', 'Daftar Akun -- ' . config('app.name'))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6 col-lg-5 col-xl-4">
            
            {{-- Kartu Registrasi Utama --}}
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                
                {{-- Aksen Header Warna di Atas Kartu --}}
                <div class="bg-primary p-4 text-white text-center position-relative">
                    <div class="bg-white bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center p-3 mb-2 shadow-sm" style="width: 65px; height: 65px;">
                        <i class="bi bi-person-plus-fill display-6"></i>
                    </div>
                    <h1 class="h4 fw-bold mb-1">Buat Akun Baru</h1>
                    <p class="small text-white-50 mb-0">Portal Pengaduan Sarana & Prasarana</p>
                </div>

                <div class="card-body p-4 p-lg-4 bg-white">
                    
                    <form method="POST" action="{{ route('register.attempt') }}">
                        @csrf

                        {{-- Input Username --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary" for="username">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                                <input type="text" id="username" name="username" value="{{ old('username') }}" 
                                       class="form-control bg-light border-start-0 ps-0 {{ errors()->has('username') ? 'is-invalid' : '' }}" 
                                       placeholder="Pilih username unik" autofocus>
                                @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Input Password --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary" for="password">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                                <input type="password" id="password" name="password" 
                                       class="form-control bg-light border-start-0 ps-0 {{ errors()->has('password') ? 'is-invalid' : '' }}" 
                                       placeholder="••••••••">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Input Konfirmasi Password --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold small text-secondary" for="password_confirmation">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" id="password_confirmation" name="password_confirmation" 
                                       class="form-control bg-light border-start-0 ps-0" 
                                       placeholder="••••••••">
                            </div>
                        </div>

                        {{-- Logika Pilihan Role (Asli Anda) --}}
                        @if (count($roles) > 1)
                            <div class="mb-4">
                                <label class="form-label fw-semibold small text-secondary" for="role">Daftar sebagai</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-shield-lock"></i></span>
                                    <select id="role" name="role" class="form-select bg-light border-start-0 ps-0 {{ errors()->has('role') ? 'is-invalid' : '' }}">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="role" value="{{ $roles[0]->name }}">
                        @endif

                        {{-- Tombol Daftar --}}
                        <button class="btn btn-primary w-100 py-3 fw-semibold rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2" type="submit">
                            <i class="bi bi-check-circle"></i> Daftar Akun
                        </button>
                    </form>

                    {{-- Link ke Login --}}
                    <div class="text-center mt-4 pt-3 border-top">
                        <p class="text-secondary small mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">Masuk di sini</a>.</p>
                    </div>

                </div>
            </div>

            {{-- Tautan Kembali ke Beranda --}}
            <div class="text-center mt-3">
                <a href="{{ route('home') }}" class="text-muted small text-decoration-none d-inline-flex align-items-center gap-1">
                    <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>
</div>
@endsection