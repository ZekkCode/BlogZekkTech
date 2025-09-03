@extends('layouts.app')

@section('title', 'Daftar Akun Pengunjung')

@section('content')
    <div class="max-w-md mx-auto">
        <div class="card rounded-xl p-8">
            <div class="text-center mb-8">
                <img src="{{ asset('images/zekktech-logo-fixed.svg') }}" alt="ZekkTech Logo" class="h-16 mx-auto mb-4">
                <h1 class="text-2xl font-semibold" style="color: var(--text-primary);">Daftar Akun</h1>
                <p class="mt-2" style="color: var(--text-secondary);">Bergabung dengan komunitas ZekkTech</p>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 rounded-lg" style="background-color: #d1fae5; border: 1px solid #10b981; color: #065f46;">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('user.register.submit') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Nama
                        Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autocomplete="name"
                        autofocus
                        class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        style="background-color: var(--bg-primary); border-color: var(--border-color); color: var(--text-primary);"
                        placeholder="Masukkan nama lengkap Anda">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium mb-2"
                        style="color: var(--text-primary);">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                        class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        style="background-color: var(--bg-primary); border-color: var(--border-color); color: var(--text-primary);"
                        placeholder="Masukkan email Anda">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium mb-2"
                        style="color: var(--text-primary);">Password</label>
                    <input type="password" id="password" name="password" required autocomplete="new-password"
                        class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        style="background-color: var(--bg-primary); border-color: var(--border-color); color: var(--text-primary);"
                        placeholder="Minimal 8 karakter">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium mb-2"
                        style="color: var(--text-primary);">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        autocomplete="new-password"
                        class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        style="background-color: var(--bg-primary); border-color: var(--border-color); color: var(--text-primary);"
                        placeholder="Ulangi password Anda">
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="text-sm" style="color: var(--text-secondary);">
                    <p>Dengan mendaftar, Anda menyetujui untuk:</p>
                    <ul class="mt-2 ml-4 list-disc space-y-1">
                        <li>Berkomentar dengan sopan dan konstruktif</li>
                        <li>Tidak melakukan spam atau konten tidak pantas</li>
                        <li>Menghormati sesama anggota komunitas</li>
                    </ul>
                </div>

                <button type="submit" class="w-full btn-primary py-3 font-semibold">
                    Daftar Akun
                </button>
            </form>

            <div class="mt-6 text-center space-y-4">
                <p style="color: var(--text-secondary);">
                    Sudah punya akun?
                    <a href="{{ route('user.login') }}" class="font-medium hover:underline"
                        style="color: var(--accent-color);">
                        Login disini
                    </a>
                </p>

                <div class="pt-4 border-t" style="border-color: var(--border-color);">
                    <a href="{{ route('login') }}" class="text-sm hover:underline" style="color: var(--text-secondary);">
                        ← Pilih jenis login lain
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection