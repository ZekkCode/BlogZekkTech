@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
    <div class="max-w-md mx-auto">
        <div class="card rounded-xl p-8">
            <div class="text-center mb-8">
                <img src="{{ asset('images/zekktech-logo-fixed.svg') }}" alt="ZekkTech Logo" class="h-16 mx-auto mb-4">
                <h1 class="text-2xl font-semibold" style="color: var(--text-primary);">Login Admin</h1>
                <p class="mt-2" style="color: var(--text-secondary);">Masuk untuk mengakses panel admin</p>
            </div>

            @if(session('error'))
                <div class="mb-6 p-4 rounded-lg" style="background-color: #fed7d7; border: 1px solid #fc8181; color: #742a2a;">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Email
                        Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:outline-none focus:ring-2"
                        style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);"
                        onfocus="this.style.borderColor='var(--accent-color)'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)'"
                        onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none'">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium mb-2"
                        style="color: var(--text-primary);">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:outline-none focus:ring-2"
                        style="background-color: var(--bg-primary); color: var(--text-primary); border-color: var(--border-color);"
                        onfocus="this.style.borderColor='var(--accent-color)'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)'"
                        onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none'">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember"
                        class="h-4 w-4 rounded border-gray-300 focus:ring-2" style="accent-color: var(--accent-color);">
                    <label for="remember" class="ml-2 block text-sm" style="color: var(--text-secondary);">Remember
                        me</label>
                </div>

                <div>
                    <button type="submit"
                        class="w-full btn-primary py-3 font-medium transition-all duration-200 transform hover:scale-105">
                        Sign In
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-sm transition-colors" style="color: var(--text-secondary);"
                    onmouseover="this.style.color='var(--accent-color)'"
                    onmouseout="this.style.color='var(--text-secondary)'">
                    ← Back to Website
                </a>
            </div>
        </div>
    </div>
@endsection