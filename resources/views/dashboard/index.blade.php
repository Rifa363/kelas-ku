@php
    $title = 'Dashboard';
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome -->
            <div class="bg-gradient-to-r from-emerald-600 to-teal-600 overflow-hidden shadow-lg sm:rounded-lg mb-8 relative">
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 400 200" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="50" cy="40" r="30" fill="white" opacity="0.3"/>
                        <circle cx="150" cy="80" r="20" fill="white" opacity="0.2"/>
                        <circle cx="300" cy="30" r="40" fill="white" opacity="0.15"/>
                        <circle cx="370" cy="120" r="15" fill="white" opacity="0.25"/>
                        <circle cx="200" cy="160" r="25" fill="white" opacity="0.1"/>
                    </svg>
                </div>
                <div class="p-8 text-white flex items-center space-x-6 relative">
                    @php $foto = auth()->user()->fotoUrl(); @endphp
                    @if ($foto)
                        <img src="{{ $foto }}" alt="{{ auth()->user()->nama }}" class="w-16 h-16 rounded-full object-cover ring-4 ring-white/30 shadow-lg">
                    @else
                        <div class="w-16 h-16 rounded-full bg-emerald-800/30 flex items-center justify-center text-2xl font-bold ring-4 ring-white/30 shadow-lg">{{ substr(auth()->user()->nama, 0, 1) }}</div>
                    @endif
                    <div>
                        <h1 class="text-3xl font-bold mb-1">Selamat datang, {{ auth()->user()->nama }}!</h1>
                        <p class="text-emerald-100 text-lg">Di Kelas TPLE006 Teknik Informatika Universitas Pamulang</p>
                        @if (auth()->user()->isAdmin())
                            <span class="inline-block mt-3 px-3 py-1 bg-white/20 rounded-full text-sm font-medium backdrop-blur-sm">{{ ucfirst(auth()->user()->role) }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <a href="{{ auth()->user()->isAdmin() ? route('admin.mahasiswa.index') : route('mahasiswa.index') }}" class="block bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-emerald-500 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Mahasiswa</p>
                            <p class="text-4xl font-bold text-gray-800 mt-1">{{ $totalMahasiswa }}</p>
                        </div>
                        <div class="w-14 h-14 bg-emerald-100 rounded-full flex items-center justify-center">
                            <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                    </div>
                </a>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-teal-500 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Postingan</p>
                            <p class="text-4xl font-bold text-gray-800 mt-1">{{ $totalPosts }}</p>
                        </div>
                        <div class="w-14 h-14 bg-teal-100 rounded-full flex items-center justify-center">
                            <svg class="w-7 h-7 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-amber-500 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Komentar</p>
                            <p class="text-4xl font-bold text-gray-800 mt-1">{{ $totalComments }}</p>
                        </div>
                        <div class="w-14 h-14 bg-amber-100 rounded-full flex items-center justify-center">
                            <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-800">Mahasiswa Aktif per Hari (14 Hari)</h3>
                    </div>
                    <div class="p-6">
                        <canvas id="activeUsersChart" height="200"></canvas>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="font-semibold text-gray-800">Status Keaktifan Mahasiswa</h3>
                    </div>
                    <div class="p-6">
                        <canvas id="activityRatioChart" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Chart Data -->
            <script id="chart-data" type="application/json">{!! json_encode([
                'dates' => $activityDates,
                'counts' => $activityCounts,
                'activeToday' => $activeToday,
                'activeWeek' => $activeWeek,
                'activeMonth' => $activeMonth,
                'inactive' => $inactive,
            ]) !!}</script>
        </div>
    </div>
</x-app-layout>
