<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="{{
        Auth::check()
            ? (Auth::user()->theme_preference === 'light' ? '' : (Auth::user()->theme_preference === 'warm' ? 'warm' : 'dark'))
            : (session('theme') === 'light' ? '' : (session('theme') === 'warm' ? 'warm' : 'dark'))
    }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BlogZekkTech') }} - @yield('title', 'Home')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Light theme (default) */
        :root {
            --bg-primary: #f8fafc;
            --bg-secondary: #ffffff;
            --bg-secondary-translucent: rgba(255, 255, 255, 0.8);
            --text-primary: #2d3748;
            --text-secondary: #718096;
            --border-color: #e2e8f0;
            --accent-color: #667eea;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* Dark theme */
        .dark {
            --bg-primary: #1a202c;
            --bg-secondary: #2d3748;
            --bg-secondary-translucent: rgba(26, 32, 44, 0.8);
            --text-primary: #f7fafc;
            --text-secondary: #a0aec0;
            --border-color: #4a5568;
            --accent-color: #3182ce;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* Warm theme */
        .warm {
            --bg-primary: #fdf6e3;
            --bg-secondary: #fbf1c7;
            --bg-secondary-translucent: rgba(251, 241, 199, 0.8);
            --text-primary: #3c3836;
            --text-secondary: #7c6f64;
            --border-color: #d5c4a1;
            --accent-color: #d65d0e;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            transition: background-color 0.3s ease, color 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        /* Allow selection for specific elements */
        .prose,
        .post-content,
        input,
        textarea,
        [contenteditable="true"] {
            user-select: text;
        }

        /* ===== HEADER STYLES ===== */
        .header-container {
            padding: 1rem 1.5rem;
        }

        /* Mobile Header */
        .header-nav-mobile {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 0.75rem 1rem;
            background-color: var(--bg-secondary-translucent);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            border-radius: 1.5rem;
            /* Fully rounded corners */
            box-shadow: var(--shadow-lg);
        }

        /* Desktop Header */
        .header-nav-desktop {
            display: none;
            /* Hidden by default */
        }

        @media (min-width: 1024px) {
            .header-container {
                padding: 1.5rem 1.5rem;
            }

            .header-nav-mobile {
                display: none;
                /* Hide mobile header on desktop */
            }

            .header-nav-desktop {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
                max-width: 60rem;
                /* Adjust as needed */
                margin: 0 auto;
                padding: 0.5rem 1rem;
                background-color: var(--bg-secondary-translucent);
                backdrop-filter: blur(12px);
                border: 1px solid var(--border-color);
                border-radius: 9999px;
                /* Pill shape */
                box-shadow: var(--shadow-lg);
            }
        }

        .logo-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: opacity 0.2s ease;
        }

        .logo-link:hover {
            opacity: 0.8;
        }

        .logo-img {
            height: 2rem;
            width: 2rem;
        }

        .logo-text {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--text-primary);
        }

        .nav-links-desktop {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .nav-link {
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--text-secondary);
            transition: color 0.2s ease;
            text-decoration: none;
        }

        .nav-link:hover {
            color: var(--text-primary);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .search-container {
            position: relative;
        }

        .search-input {
            background-color: var(--bg-primary) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: 9999px !important;
            padding: 0.5rem 1rem 0.5rem 2.5rem !important;
            font-size: 0.875rem !important;
            color: var(--text-primary) !important;
            transition: all 0.3s ease;
            width: 12rem !important;
        }

        .search-input:focus {
            outline: none !important;
            border-color: var(--accent-color) !important;
            box-shadow: 0 0 0 2px var(--accent-color);
            width: 16rem !important;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            border: none;
            background: transparent;
            color: var(--text-secondary);
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .action-btn:hover {
            background-color: var(--bg-primary);
            color: var(--text-primary);
        }

        /* Mobile Menu */
        .mobile-menu {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 10000;
            background-color: rgba(0, 0, 0, 0.4);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .mobile-menu.show {
            opacity: 1;
            visibility: visible;
        }

        .mobile-menu-panel {
            position: absolute;
            top: 6rem;
            /* Position below the header */
            right: 1.5rem;
            width: 18rem;
            background-color: var(--bg-secondary);
            border-radius: 1rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            transform: translateY(-10px) scale(0.95);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .mobile-menu.show .mobile-menu-panel {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        .mobile-nav-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1rem;
            font-weight: 500;
            color: var(--text-secondary) !important;
            padding: 0.75rem 1.25rem !important;
            transition: all 0.2s ease;
            border-bottom: 1px solid var(--border-color);
        }

        .mobile-nav-link:last-child {
            border-bottom: none;
        }

        .mobile-nav-link:hover {
            background-color: var(--bg-primary) !important;
            color: var(--text-primary) !important;
        }

        .mobile-nav-link-arrow {
            color: var(--border-color);
        }

        /* Footer Social Links Spacing */
        .social-links {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1.5rem;
            padding-top: 1rem;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            transition: opacity 0.2s ease;
        }

        .social-links a:hover {
            opacity: 0.7;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="header-container sticky top-0 z-[999]">
            <!-- Desktop Header -->
            <nav class="header-nav-desktop">
                <a href="{{ route('home') }}" class="logo-link">
                    <img src="{{ asset('images/zekktech-logo-fixed.svg') }}" alt="ZekkTech Logo" class="logo-img">
                    <span class="logo-text">ZekkTech</span>
                </a>
                <div class="nav-links-desktop">
                    <a href="{{ route('home') }}" class="nav-link">Home</a>
                    @if(Auth::check() && Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">Admin</a>
                    @else
                    <a href="{{ route('admin.login') }}" class="nav-link">Login</a>
                    @endif
                    <a href="#footer" class="nav-link" onclick="document.querySelector('footer').scrollIntoView({behavior: 'smooth'})">About</a>
                    <a href="https://github.com/zekkcode" target="_blank" class="nav-link flex items-center gap-1">
                        GitHub
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                            <polyline points="15 3 21 3 21 9"></polyline>
                            <line x1="10" y1="14" x2="21" y2="3"></line>
                        </svg>
                    </a>
                </div>
                <div class="header-actions">
                    <div class="search-container">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4" style="color: var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" id="searchInput" placeholder="Search..." class="search-input">
                        <div id="searchResults" class="absolute top-full left-0 right-0 mt-2 rounded-lg shadow-xl hidden max-h-96 overflow-y-auto z-50" style="background-color: var(--bg-secondary); border: 1px solid var(--border-color);"></div>
                    </div>
                    <button id="themeToggle" type="button" class="action-btn" onclick="toggleTheme()">
                        <span id="themeIconDesktop"></span>
                    </button>
                </div>
            </nav>

            <!-- Mobile Header -->
            <nav class="header-nav-mobile">
                <a href="{{ route('home') }}" class="logo-link">
                    <img src="{{ asset('images/zekktech-logo-fixed.svg') }}" alt="ZekkTech Logo" class="logo-img">
                    <span class="logo-text">ZekkTech</span>
                </a>
                <div class="header-actions">
                    <button id="themeToggleMobile" type="button" class="action-btn" onclick="toggleTheme()">
                        <span id="themeIconMobile"></span>
                    </button>
                    <button type="button" class="action-btn mobile-menu-toggle" onclick="toggleMobileMenu()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </nav>
        </header>

        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobileMenu">
            <div class="mobile-menu-panel">
                <a href="{{ route('home') }}" class="mobile-nav-link">
                    <span>Home</span>
                    <span class="mobile-nav-link-arrow">&gt;</span>
                </a>
                @if(Auth::check() && Auth::user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" class="mobile-nav-link">
                    <span>Admin</span>
                    <span class="mobile-nav-link-arrow">&gt;</span>
                </a>
                <form method="POST" action="{{ route('admin.logout') }}" class="block">
                    @csrf
                    <button type="submit" class="mobile-nav-link w-full text-left">
                        <span>Logout</span>
                        <span class="mobile-nav-link-arrow">&gt;</span>
                    </button>
                </form>
                @else
                <a href="{{ route('admin.login') }}" class="mobile-nav-link">
                    <span>Login</span>
                    <span class="mobile-nav-link-arrow">&gt;</span>
                </a>
                @endif
                <a href="#about" class="mobile-nav-link">
                    <span>About</span>
                    <span class="mobile-nav-link-arrow">&gt;</span>
                </a>
                <a href="https://github.com/zekkcode" target="_blank" class="mobile-nav-link">
                    <span>GitHub</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                        <polyline points="15 3 21 3 21 9"></polyline>
                        <line x1="10" y1="14" x2="21" y2="3"></line>
                    </svg>
                </a>
            </div>
        </div>

        @hasSection('admin_nav')
        @yield('admin_nav')
        @endif

        <main class="flex-grow">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </div>
        </main>

        <footer style="background-color: var(--bg-secondary); border-top: 1px solid var(--border-color);" class="mt-16">
            <div class="max-w-6xl mx-auto px-6 py-12">
                <div class="flex flex-col items-center text-center space-y-4">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('images/zekktech-logo-fixed.svg') }}" alt="ZekkTech Logo" class="h-8 w-8 object-contain">
                        <span class="text-lg font-semibold" style="color: var(--text-primary);">{{ config('app.name', 'ZekkTech') }}</span>
                    </div>
                    <p class="text-sm max-w-md" style="color: var(--text-secondary);">
                        ZekkTech adalah platform artikel gratis yang menyediakan informasi teknologi terkini, tutorial, dan insight mendalam untuk membantu Anda belajar dan berkembang di dunia digital. Berbagi ilmu, membangun masa depan teknologi bersama.
                    </p>
                    <!-- Social Links Section -->
                    <div class="social-links">
                        <!-- GitHub -->
                        <a href="https://github.com/zekkcode" target="_blank" aria-label="GitHub" style="color: var(--text-secondary);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                            </svg>
                        </a>
                        <!-- Email -->
                        <a href="mailto:zakariamujur6@gmail.com" aria-label="Email" style="color: var(--text-secondary);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </a>
                        <!-- Instagram -->
                        <a href="https://instagram.com/zekksparow" target="_blank" aria-label="Instagram" style="color: var(--text-secondary);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                        </a>
                        <!-- TikTok -->
                        <a href="https://tiktok.com/@zekksparow" target="_blank" aria-label="TikTok" style="color: var(--text-secondary);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path>
                            </svg>
                        </a>
                        <!-- WhatsApp -->
                        <a href="https://wa.me/62881081772005" target="_blank" aria-label="WhatsApp" style="color: var(--text-secondary);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="pt-6 border-t w-full" style="border-color: var(--border-color);">
                        <div class="flex flex-col sm:flex-row justify-between items-center text-xs space-y-2 sm:space-y-0" style="color: var(--text-secondary);">
                            <div class="flex items-center space-x-1">
                                <span>&copy; {{ date('Y') }} {{ config('app.name', 'ZekkTech') }}. All Rights Reserved.</span>
                            </div>
                            <div class="flex items-center space-x-1">
                                <span>Powered by</span>
                                <a href="https://laravel.com" target="_blank" class="hover:opacity-70 transition-opacity">PHP&Laravel12</a>
                                <span>&</span>
                                <span class="hover:opacity-70 transition-opacity">ZakariaMP</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themes = [{
                name: 'light',
                icon: '☀️'
            }, {
                name: 'dark',
                icon: '🌙'
            }, {
                name: 'warm',
                icon: '🔥'
            }];
            let currentThemeName = document.documentElement.classList.contains('dark') ? 'dark' : document.documentElement.classList.contains('warm') ? 'warm' : 'light';

            const themeIconDesktop = document.getElementById('themeIconDesktop');
            const themeIconMobile = document.getElementById('themeIconMobile');

            function updateThemeButton() {
                const theme = themes.find(t => t.name === currentThemeName);
                if (theme) {
                    if (themeIconDesktop) themeIconDesktop.textContent = theme.icon;
                    if (themeIconMobile) themeIconMobile.textContent = theme.icon;
                }
            }

            window.toggleTheme = function() {
                const currentIndex = themes.findIndex(t => t.name === currentThemeName);
                const nextTheme = themes[(currentIndex + 1) % themes.length];
                changeTheme(nextTheme.name);
            };

            function changeTheme(theme) {
                fetch('{{ route("theme.set") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            theme: theme
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            // Mobile Menu
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');

            window.toggleMobileMenu = function() {
                const isShown = mobileMenu.classList.toggle('show');
                document.body.style.overflow = isShown ? 'hidden' : '';
            }

            // Close menu when clicking on the overlay
            mobileMenu.addEventListener('click', function(event) {
                if (event.target === mobileMenu) {
                    toggleMobileMenu();
                }
            });

            // Close menu when clicking a link inside
            mobileMenu.querySelectorAll('a, button').forEach(link => {
                link.addEventListener('click', () => {
                    if (mobileMenu.classList.contains('show')) {
                        toggleMobileMenu();
                    }
                });
            });


            // Search Functionality
            const searchInput = document.getElementById('searchInput');
            const searchResults = document.getElementById('searchResults');
            let searchTimeout;

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    const query = this.value.trim();
                    if (query.length >= 2) {
                        searchTimeout = setTimeout(() => performSearch(query, searchResults), 300);
                    } else {
                        searchResults.classList.add('hidden');
                    }
                });

                searchInput.addEventListener('keydown', function(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        const query = this.value.trim();
                        if (query) {
                            window.location.href = '{{ route("search") }}?q=' + encodeURIComponent(query);
                        }
                    }
                });
            }

            function performSearch(query, container) {
                fetch('{{ route("search.api") }}?q=' + encodeURIComponent(query))
                    .then(response => response.json())
                    .then(data => displaySearchResults(data, container, query))
                    .catch(error => console.error('Search error:', error));
            }

            function displaySearchResults(results, container, query) {
                if (!container) return;
                container.innerHTML = ''; // Clear previous results
                if (results.length === 0) {
                    container.innerHTML = `<div class="p-4 text-center" style="color: var(--text-secondary);">No results found</div>`;
                } else {
                    results.slice(0, 5).forEach(result => { // Show max 5 results
                        const item = document.createElement('a');
                        item.href = result.url;
                        item.className = 'block p-4 hover:bg-gray-100 dark:hover:bg-gray-700';
                        item.innerHTML = `<div class="font-semibold" style="color: var(--text-primary);">${result.title}</div>`;
                        container.appendChild(item);
                    });
                    if (results.length > 0) {
                        const viewAll = document.createElement('a');
                        viewAll.href = `{{ route('search') }}?q=${encodeURIComponent(query)}`;
                        viewAll.className = 'block p-4 text-center font-semibold';
                        viewAll.style.color = 'var(--accent-color)';
                        viewAll.textContent = 'View all results';
                        container.appendChild(viewAll);
                    }
                }
                container.classList.remove('hidden');
            }

            // Close search on outside click
            document.addEventListener('click', function(event) {
                if (!searchInput.contains(event.target)) {
                    searchResults.classList.add('hidden');
                }
            });


            // Initial setup
            updateThemeButton();
        });
    </script>
</body>

</html>