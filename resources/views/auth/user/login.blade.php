@extends('layouts.app')

@section('title', 'Login Pengunjung')

@section('content')
    <div class="max-w-md mx-auto">
        <div class="card rounded-xl p-8">
            <div class="text-center mb-8">
                <img src="{{ asset(config('app.logo')) }}" alt="{{ config('app.name', 'ZekkTech') }} Logo"
                    class="h-16 mx-auto mb-4">
                <h1 class="text-2xl font-semibold" style="color: var(--text-primary);">Login Pengunjung</h1>
                <p class="mt-2" style="color: var(--text-secondary);">Masuk untuk berkomentar dan berinteraksi</p>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 rounded-lg" style="background-color: #d1fae5; border: 1px solid #10b981; color: #065f46;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-lg" style="background-color: #fed7d7; border: 1px solid #fc8181; color: #742a2a;">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('user.login.submit') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium mb-2"
                        style="color: var(--text-primary);">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                        autofocus
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
                    <input type="password" id="password" name="password" required autocomplete="current-password"
                        class="w-full px-4 py-3 rounded-lg border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                        style="background-color: var(--bg-primary); border-color: var(--border-color); color: var(--text-primary);"
                        placeholder="Masukkan password Anda">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm" style="color: var(--text-secondary);">Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full btn-primary py-3 font-semibold">
                    Masuk
                </button>
            </form>

            <div class="mt-6 text-center space-y-4">
                <p style="color: var(--text-secondary);">
                    Belum punya akun?
                    <a href="{{ route('user.register') }}" class="font-medium hover:underline"
                        style="color: var(--accent-color);">
                        Daftar disini
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