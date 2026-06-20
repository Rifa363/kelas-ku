@php
    $title = 'Tambah Mahasiswa';
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.mahasiswa.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="nama" :value="__('Nama Lengkap')" />
                                <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" required />
                                <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="nim" :value="__('NIM')" />
                                <x-text-input id="nim" class="block mt-1 w-full" type="text" name="nim" :value="old('nim')" required />
                                <x-input-error :messages="$errors->get('nim')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="no_hp" :value="__('No. HP')" />
                                <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp" :value="old('no_hp')" />
                                <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="angkatan" :value="__('Angkatan')" />
                                <x-text-input id="angkatan" class="block mt-1 w-full" type="number" name="angkatan" :value="old('angkatan')" />
                                <x-input-error :messages="$errors->get('angkatan')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="foto" :value="__('Foto')" />
                                <input id="foto" class="block mt-1 w-full" type="file" name="foto" accept="image/*" />
                                <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="role" :value="__('Role')" />
                                <select id="role" name="role" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                    <option value="anggota" {{ old('role') === 'anggota' ? 'selected' : '' }}>Anggota</option>
                                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }} {{ !auth()->user()->isAdministrator() ? 'disabled' : '' }}>Admin</option>
                                    <option value="administrator" {{ old('role') === 'administrator' ? 'selected' : '' }} {{ !auth()->user()->isAdministrator() ? 'disabled' : '' }}>Administrator</option>
                                </select>
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                @if (!auth()->user()->isAdministrator())
                                    <p class="text-xs text-gray-400 mt-1">Hanya Administrator yang bisa menetapkan role Admin/Administrator.</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <a href="{{ route('admin.mahasiswa.index') }}" class="text-gray-600 hover:text-gray-900">Batal</a>
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
