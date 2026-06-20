@php
    $title = 'Data Mahasiswa';
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Stats summary -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center">
                    <p class="text-2xl font-bold text-emerald-600">{{ $mahasiswa->total() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Total Mahasiswa</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="divide-y divide-gray-100">
                    @forelse ($mahasiswa as $m)
                        <div class="p-4 flex items-center gap-4 hover:bg-gray-50 transition-colors">
                            @php $foto = $m->fotoUrl(); @endphp
                            <div class="shrink-0">
                                @if ($foto)
                                    <img src="{{ $foto }}" alt="{{ $m->nama }}" class="w-12 h-12 rounded-full object-cover ring-2 ring-emerald-100">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold ring-2 ring-emerald-50">
                                        {{ substr($m->nama, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1 grid grid-cols-1 md:grid-cols-4 gap-2 md:gap-4 items-center">
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 truncate">{{ $m->nama }}</p>
                                    <p class="text-sm text-gray-500 md:hidden">{{ $m->nim }}</p>
                                </div>
                                <div class="hidden md:block">
                                    <p class="text-sm text-gray-600">{{ $m->nim }}</p>
                                </div>
                                <div class="hidden md:block">
                                    <p class="text-sm text-gray-600 truncate">{{ $m->email }}</p>
                                </div>
                                <div class="hidden md:block">
                                    <p class="text-sm text-gray-600">{{ $m->angkatan ?? '-' }}</p>
                                </div>
                            </div>
                            <a href="{{ route('mahasiswa.show', $m) }}" class="shrink-0 px-3 py-1.5 text-sm font-medium text-emerald-700 bg-emerald-50 rounded-lg hover:bg-emerald-100 hover:text-emerald-800 transition-colors">
                                Detail
                            </a>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <p class="text-lg font-medium text-gray-500">Belum ada mahasiswa</p>
                        </div>
                    @endforelse
                </div>

                <div class="px-4 py-4 border-t border-gray-100">
                    {{ $mahasiswa->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
