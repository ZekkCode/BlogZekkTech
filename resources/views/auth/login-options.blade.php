@extends('layouts.app')

@section('title', 'Pilih Jenis Login')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <div class="flex justify-center items-center mb-6">
                <img src="{{ asset(config('app.logo')) }}" alt="{{ config('app.name', 'ZekkTech') }} Logo"
                    class="h-20 w-20 mr-3">
                <div class="text-left">
                    <h1 class="text-4xl font-bold" style="color: var(--text-primary);">{{ config('app.name', 'ZekkTech') }}
                    </h1>
                    <p class="text-sm font-medium" style="color: var(--accent-color);">Blog Technology & Innovation</p>
                </div>
            </div>
            <h2 class="text-2xl font-semibold mb-3" style="color: var(--text-primary);">Selamat Datang di ZekkTech!</h2>
            <p class="text-lg max-w-md mx-auto" style="color: var(--text-secondary);">
                Pilih cara Anda ingin mengakses platform kami
            </p>
        </div>

        <!-- Login Options Grid -->
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <!-- Admin Login Option -->
            <div
                class="card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
                <div class="relative mb-6">
                    <div class="w-20 h-20 mx-auto rounded-2xl flex items-center justify-center shadow-lg"
                        style="background: linear-gradient(135deg, var(--accent-color), #4f46e5);">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold text-white"
                        style="background-color: #ef4444;">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>
                </div>

                <h3 class="text-2xl font-bold mb-3" style="color: var(--text-primary);">Admin Dashboard</h3>
                <p class="text-base leading-relaxed mb-8" style="color: var(--text-secondary);">
                    Kelola seluruh konten, artikel, kategori, dan pengaturan website. Akses penuh untuk mengelola platform
                    BlogZekkTech.
                </p>

                <div class="space-y-3 mb-8">
                    <div class="flex items-center text-sm" style="color: var(--text-secondary);">
                        <svg class="w-4 h-4 mr-2" style="color: var(--accent-color);" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Kelola artikel & kategori
                    </div>
                    <div class="flex items-center text-sm" style="color: var(--text-secondary);">
                        <svg class="w-4 h-4 mr-2" style="color: var(--accent-color);" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Moderasi komentar
                    </div>
                    <div class="flex items-center text-sm" style="color: var(--text-secondary);">
                        <svg class="w-4 h-4 mr-2" style="color: var(--accent-color);" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Analytics & pengaturan
                    </div>
                </div>

                <a href="{{ route('admin.login') }}"
                    class="btn-primary w-full text-lg font-semibold py-4 group-hover:shadow-lg transition-all duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Masuk sebagai Admin
                </a>
            </div>

            <!-- User Login Option -->
            <div
                class="card rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
                <div class="relative mb-6">
                    <div class="w-20 h-20 mx-auto rounded-2xl flex items-center justify-center shadow-lg"
                        style="background: linear-gradient(135deg, #10b981, #059669);">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <div class="absolute -top-2 -right-2 w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold text-white"
                        style="background-color: #10b981;">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <h3 class="text-2xl font-bold mb-3" style="color: var(--text-primary);">Komunitas Reader</h3>
                <p class="text-base leading-relaxed mb-8" style="color: var(--text-secondary);">
                    Bergabung dalam diskusi teknologi! Login untuk berkomentar, berbagi ide, dan berinteraksi dengan
                    komunitas ZekkTech.
                </p>

                <div class="space-y-3 mb-8">
                    <div class="flex items-center text-sm" style="color: var(--text-secondary);">
                        <svg class="w-4 h-4 mr-2" style="color: #10b981;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Komentar & diskusi
                    </div>
                    <div class="flex items-center text-sm" style="color: var(--text-secondary);">
                        <svg class="w-4 h-4 mr-2" style="color: #10b981;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Like & bookmark artikel
                    </div>
                    <div class="flex items-center text-sm" style="color: var(--text-secondary);">
                        <svg class="w-4 h-4 mr-2" style="color: #10b981;" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Profile personalisasi
                    </div>
                </div>

                <a href="{{ route('user.login') }}"
                    class="btn-secondary w-full text-lg font-semibold py-4 group-hover:shadow-lg transition-all duration-300"
                    style="background-color: #10b981; color: white; border: none;">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2m-2-4h4m-4 0l3-3m-3 3l3 3" />
                    </svg>
                    Masuk sebagai Pengunjung
                </a>
            </div>
        </div>
        </a>
    </div>
    </div>

    <div class="text-center mt-8">
        <p style="color: var(--text-secondary);">
            Belum punya akun?
            <a href="{{ route('user.register') }}" class="font-medium hover:underline" style="color: var(--accent-color);">
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