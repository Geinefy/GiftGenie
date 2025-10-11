<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 dark:text-gray-100 antialiased bg-gray-100 dark:bg-gray-900 transition-colors duration-200">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <!-- Theme Toggle Button -->
            <div class="absolute top-4 right-4">
                <button id="themeToggle" title="Toggle theme" class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 bg-transparent transition ease-in-out duration-150">
                    <span id="themeIcon">☀️</span>
                </button>
            </div>

            <div>
                <a href="/" class="flex items-center gap-2 font-bold text-2xl">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                    </svg>
                    <span style="background-image: linear-gradient(90deg,var(--primary-start),var(--primary-end)); -webkit-background-clip: text; background-clip: text; color: transparent;">
                        GiftGenius
                    </span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const key = 'giftgenie:theme';
                const toggle = document.getElementById('themeToggle');
                const icon = document.getElementById('themeIcon');

                function applyTheme(theme) {
                    if (theme === 'dark') {
                        document.documentElement.classList.add('dark');
                        if (icon) icon.textContent = '🌙';
                    } else {
                        document.documentElement.classList.remove('dark');
                        if (icon) icon.textContent = '☀️';
                    }
                }

                function toggleTheme() {
                    const isDark = document.documentElement.classList.contains('dark');
                    const newTheme = isDark ? 'light' : 'dark';
                    applyTheme(newTheme);
                    try { 
                        localStorage.setItem(key, newTheme); 
                    } catch (e) {
                        // ignore localStorage errors
                    }
                }

                // Initialize theme
                try {
                    const saved = localStorage.getItem(key);
                    if (saved) {
                        applyTheme(saved);
                    } else {
                        const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                        applyTheme(prefersDark ? 'dark' : 'light');
                    }
                } catch (e) {
                    applyTheme('light'); // fallback
                }

                // Add event listener to toggle button
                if (toggle) {
                    toggle.addEventListener('click', toggleTheme);
                }

                // Listen for system theme changes
                if (window.matchMedia) {
                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
                        if (!localStorage.getItem(key)) {
                            applyTheme(e.matches ? 'dark' : 'light');
                        }
                    });
                }
            });
        </script>
    </body>
</html>
