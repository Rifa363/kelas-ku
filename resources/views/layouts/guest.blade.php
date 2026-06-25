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
        @php
            $manifestPath = public_path('build/manifest.json');
            $manifest = file_exists($manifestPath) ? json_decode(file_get_contents($manifestPath), true) : [];
        @endphp
        <link rel="stylesheet" href="{{ asset('build/' . ($manifest['resources/css/app.css']['file'] ?? 'assets/app.css')) }}">
        <script type="module" src="{{ asset('build/' . ($manifest['resources/js/app.js']['file'] ?? 'assets/app.js')) }}"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-pattern-subtle">
            <!-- Brand -->
            <a href="/" class="group mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl shadow-lg flex items-center justify-center group-hover:shadow-xl transition-shadow">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-lg font-bold text-gray-800">TPLE006-UNPAM</span>
                        <span class="text-xs text-gray-500 -mt-0.5">Sistem Informasi Kelas</span>
                    </div>
                </div>
            </a>

            <div class="w-full sm:max-w-md mt-2 bg-white/90 backdrop-blur-sm shadow-xl rounded-2xl border border-emerald-100/50">
                <!-- Gradient accent bar -->
                <div class="h-1.5 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-t-2xl"></div>

                <div class="px-8 py-8">
                    {{ $slot }}
                </div>
            </div>

            <p class="mt-6 text-xs text-gray-400">&copy; {{ date('Y') }} TPLE006 — Teknik Informatika Universitas Pamulang</p>
        </div>
    </body>
</html>
