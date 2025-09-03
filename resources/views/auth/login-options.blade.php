@extends('layouts.app')

@section('title', 'Pilih Jenis Login')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <img src="{{ asset('images/zekktech-logo-fixed.svg') }}" alt="ZekkTech Logo" class="h-16 mx-auto mb-4">
            <h1 class="text-3xl font-bold mb-2" style="color: var(--text-primary);">Selamat Datang!</h1>
            <p class="text-lg" style="color: var(--text-secondary);">Pilih cara Anda ingin mengakses ZekkTech</p>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <!-- Admin Login Option -->
            <div
                class="card rounded-xl p-8 text-center hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center"
                    style="background-color: var(--accent-color);">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold mb-3" style="color: var(--text-primary);">Login sebagai Admin</h2>
                <p class="mb-6" style="color: var(--text-secondary);">
                    Kelola artikel, kategori, dan pengaturan website. Akses dashboard admin untuk mengelola konten.
                </p>
                <a href="{{ route('admin.login') }}" class="btn-primary w-full inline-block">
                    Masuk Admin
                </a>
            </div>

            <!-- User Login Option -->
            <div
                class="card rounded-xl p-8 text-center hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center"
                    style="background-color: #10b981;">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2m-2-4h4m-4 0l3-3m-3 3l3 3" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h8m-8 0l3 3m-3-3l3-3m8-6H3a2 2 0 00-2 2v12a2 2 0 002 2h18a2 2 0 002-2V4a2 2 0 00-2-2z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold mb-3" style="color: var(--text-primary);">Login sebagai Pengunjung</h2>
                <p class="mb-6" style="color: var(--text-secondary);">
                    Bergabung dalam diskusi! Login untuk berkomentar pada artikel dan berinteraksi dengan komunitas.
                </p>
                <a href="{{ route('user.login') }}" class="btn-secondary w-full inline-block">
                    Masuk Pengunjung
                </a>
            </div>
        </div>

        <div class="text-center mt-8">
            <p style="color: var(--text-secondary);">
                Belum punya akun?
                <a href="{{ route('user.register') }}" class="font-medium hover:underline"
                    style="color: var(--accent-color);">
                    Daftar sebagai Pengunjung
                </a>
            </p>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-sm hover:underline" style="color: var(--text-secondary);">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>
@endsection