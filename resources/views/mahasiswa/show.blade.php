@php
    $title = 'Detail Mahasiswa';
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nama</p>
                            <p class="font-medium">{{ $mahasiswa->nama }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">NIM</p>
                            <p class="font-medium">{{ $mahasiswa->nim }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-medium">{{ $mahasiswa->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">No. HP</p>
                            <p class="font-medium">{{ $mahasiswa->no_hp ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Angkatan</p>
                            <p class="font-medium">{{ $mahasiswa->angkatan ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Role</p>
                             <p class="font-medium">{{ ucfirst($mahasiswa->role) }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('mahasiswa.index') }}" class="text-gray-600 hover:text-gray-900">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
