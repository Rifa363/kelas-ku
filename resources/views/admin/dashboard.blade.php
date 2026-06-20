@php
    $title = 'Admin Dashboard';
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700">Total Mahasiswa</h3>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $totalMahasiswa }}</p>
                    <a href="{{ route('admin.mahasiswa.index') }}" class="mt-3 inline-block text-sm text-emerald-600 hover:text-emerald-800">
                        Kelola Mahasiswa →
                    </a>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700">Total Postingan</h3>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $totalPosts }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700">Total Notifikasi</h3>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $totalNotifications }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-700">Struktur Kelas</h3>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $totalStruktur }}</p>
                    <a href="{{ route('struktur-kelas.index') }}" class="mt-3 inline-block text-sm text-emerald-600 hover:text-emerald-800">
                        Kelola Struktur →
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Notifikasi Terbaru</h3>
                    @if ($recentNotifications->count())
                        <ul class="divide-y divide-gray-200">
                            @foreach ($recentNotifications as $notif)
                                <li class="py-3">
                                    <p class="font-medium">{{ $notif->judul }}</p>
                                    <p class="text-sm text-gray-600">{{ $notif->pesan }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">Belum ada notifikasi.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
