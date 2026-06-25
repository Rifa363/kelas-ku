<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TPLE006 — Sistem Informasi Kelas</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @php
        $manifestPath = public_path('build/manifest.json');
        $manifest = file_exists($manifestPath) ? json_decode(file_get_contents($manifestPath), true) : [];
    @endphp
    <link rel="stylesheet" href="{{ asset('build/' . ($manifest['resources/css/app.css']['file'] ?? 'assets/app.css')) }}">
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Nav -->
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">TC</span>
                        </div>
                        <span class="font-bold text-gray-800">TPLE006</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700">Daftar</a>
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero -->
        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                <div class="text-center">
                    <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">
                        Sistem Informasi Kelas <span class="text-emerald-600">TPLE006</span>
                    </h1>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto mb-8">
                        Platform informasi terpusat untuk mahasiswa Teknik Informatika — Universitas Pamulang
                    </p>
                    <div class="flex items-center justify-center space-x-4">
                        <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-emerald-600 border border-transparent rounded-lg font-semibold text-white hover:bg-emerald-700 transition">Masuk ke Platform</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 transition">Daftar Akun</a>
                        @endif
                    </div>
                </div>

                <!-- Feature Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-20">
                    <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                        <div class="w-14 h-14 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Feed Informasi</h3>
                        <p class="text-gray-500">Bagikan dan dapatkan informasi perkuliahan, tugas, jadwal, dan pengumuman dalam satu platform.</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                        <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Data Mahasiswa</h3>
                        <p class="text-gray-500">Data mahasiswa terorganisir dengan informasi NIM, angkatan, kontak, dan lainnya.</p>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-8 text-center">
                        <div class="w-14 h-14 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Notifikasi</h3>
                        <p class="text-gray-500">Dapatkan notifikasi otomatis untuk setiap informasi baru, komentar, dan pengumuman penting.</p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-500 text-sm">
                <p>&copy; {{ date('Y') }} TPLE006 — Teknik Informatika Universitas Pamulang</p>
            </div>
        </footer>
    </div>
</body>
</html>
