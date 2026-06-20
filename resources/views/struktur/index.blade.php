@php
    $title = 'Struktur Organisasi Kelas';
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Struktur Organisasi Kelas') }}
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

            @auth
                @if (Auth::user()->isAdmin())
                    <div class="mb-6 flex items-center justify-between bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                        <div>
                            <p class="text-sm text-gray-600">Panel Admin — Struktur Organisasi Kelas</p>
                        </div>
                        <a href="{{ route('admin.struktur.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 border border-transparent rounded-lg font-semibold text-sm text-white shadow-md hover:shadow-lg hover:from-emerald-700 hover:to-teal-700 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            Tambah Anggota
                        </a>
                    </div>
                @endif
            @endauth

            @if ($struktur->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-600 mb-2">Belum Ada Struktur</h3>
                    <p class="text-gray-400">Admin belum mengatur struktur organisasi kelas.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($struktur as $item)
                        @if ($item->children->isEmpty())
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200 relative group">
                                @auth
                                    @if (Auth::user()->isAdmin())
                                        <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('admin.struktur.edit', $item) }}" class="p-1.5 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200" title="Edit">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                            <form action="{{ route('admin.struktur.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus {{ $item->jabatan }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 bg-red-100 text-red-700 rounded hover:bg-red-200" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                                <div class="p-6 text-center">
                                    <div class="w-20 h-20 mx-auto mb-4 rounded-full overflow-hidden bg-emerald-100 ring-4 ring-emerald-50">
                                        @if ($item->foto)
                                            <img src="{{ Storage::url($item->foto) }}" alt="{{ $item->user->nama }}" class="w-full h-full object-cover">
                                        @elseif ($item->user->foto)
                                            <img src="{{ Storage::url($item->user->foto) }}" alt="{{ $item->user->nama }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-2xl font-bold text-emerald-500">
                                                {{ strtoupper(substr($item->user->nama, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <h3 class="font-semibold text-gray-900 text-lg">{{ $item->user->nama }}</h3>
                                    <p class="text-sm text-gray-500">{{ $item->user->nim }}</p>
                                    <span class="inline-block mt-3 px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full">
                                        {{ $item->jabatan }}
                                    </span>
                                    @if ($item->deskripsi)
                                        <p class="mt-3 text-xs text-gray-400">{{ $item->deskripsi }}</p>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200 lg:col-span-2 xl:col-span-2 relative group">
                                @auth
                                    @if (Auth::user()->isAdmin())
                                        <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                            <a href="{{ route('admin.struktur.edit', $item) }}" class="p-1.5 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200" title="Edit">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                            <form action="{{ route('admin.struktur.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus {{ $item->jabatan }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 bg-red-100 text-red-700 rounded hover:bg-red-200" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.struktur.create', ['parent_id' => $item->id]) }}" class="p-1.5 bg-green-100 text-green-700 rounded hover:bg-green-200" title="Tambah Anggota">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                                            </a>
                                        </div>
                                    @endif
                                @endauth
                                <div class="p-6">
                                    <div class="flex items-center gap-4 mb-4">
                                        <div class="w-16 h-16 rounded-full overflow-hidden bg-emerald-100 ring-4 ring-emerald-50 shrink-0">
                                            @if ($item->foto)
                                                <img src="{{ Storage::url($item->foto) }}" alt="{{ $item->user->nama }}" class="w-full h-full object-cover">
                                            @elseif ($item->user->foto)
                                                <img src="{{ Storage::url($item->user->foto) }}" alt="{{ $item->user->nama }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-xl font-bold text-emerald-500">
                                                    {{ strtoupper(substr($item->user->nama, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 text-lg">{{ $item->user->nama }}</h3>
                                            <p class="text-sm text-gray-500">{{ $item->user->nim }}</p>
                                            <span class="inline-block mt-1 px-3 py-0.5 bg-emerald-100 text-emerald-700 text-xs font-semibold rounded-full">
                                                {{ $item->jabatan }}
                                            </span>
                                        </div>
                                    </div>

                                    @if ($item->deskripsi)
                                        <p class="text-xs text-gray-400 mb-4 ml-0">{{ $item->deskripsi }}</p>
                                    @endif

                                    <div class="border-t border-gray-100 pt-4">
                                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Anggota</p>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            @foreach ($item->children as $child)
                                                <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors relative group/child">
                                                    @auth
                                                        @if (Auth::user()->isAdmin())
                                                            <div class="absolute top-1 right-1 flex gap-0.5 opacity-0 group-hover/child:opacity-100 transition-opacity">
                                                                <a href="{{ route('admin.struktur.edit', $child) }}" class="p-1 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200" title="Edit">
                                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                                </a>
                                                                <form action="{{ route('admin.struktur.destroy', $child) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus {{ $child->jabatan }}?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="p-1 bg-red-100 text-red-700 rounded hover:bg-red-200" title="Hapus">
                                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    @endauth
                                                    <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-100 shrink-0">
                                                        @if ($child->foto)
                                                            <img src="{{ Storage::url($child->foto) }}" alt="{{ $child->user->nama }}" class="w-full h-full object-cover">
                                                        @elseif ($child->user->foto)
                                                            <img src="{{ Storage::url($child->user->foto) }}" alt="{{ $child->user->nama }}" class="w-full h-full object-cover">
                                                        @else
                                                            <div class="w-full h-full flex items-center justify-center text-sm font-bold text-gray-500">
                                                                {{ strtoupper(substr($child->user->nama, 0, 1)) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $child->user->nama }}</p>
                                                        <p class="text-xs text-gray-500">{{ $child->user->nim }}</p>
                                                        <span class="text-xs text-emerald-600 font-medium">{{ $child->jabatan }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
