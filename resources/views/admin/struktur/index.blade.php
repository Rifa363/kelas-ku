@php
    $title = 'Data Struktur Kelas';
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Struktur Kelas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('admin.struktur.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700">
                    + Tambah Anggota
                </a>
                <a href="{{ route('struktur-kelas.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 ms-2">
                    Lihat Halaman Publik
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jabatan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIM</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Induk</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Urutan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($struktur as $item)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-100">
                                                @if ($item->foto)
                                                    <img src="{{ Storage::url($item->foto) }}" alt="" class="w-full h-full object-cover">
                                                @elseif ($item->user->foto)
                                                    <img src="{{ Storage::url($item->user->foto) }}" alt="" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-sm font-bold text-gray-500">
                                                        {{ strtoupper(substr($item->user->nama, 0, 1)) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-medium">{{ $item->jabatan }}</td>
                                        <td class="px-6 py-4">{{ $item->user->nama }}</td>
                                        <td class="px-6 py-4">{{ $item->user->nim }}</td>
                                        <td class="px-6 py-4">{{ $item->parent?->jabatan ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $item->urutan }}</td>
                                        <td class="px-6 py-4 space-x-2">
                                            <a href="{{ route('admin.struktur.edit', $item) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                            <form action="{{ route('admin.struktur.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                            Belum ada data struktur kelas.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $struktur->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
