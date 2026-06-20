@php
    $title = 'Edit Anggota Struktur';
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Anggota Struktur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.struktur.update', $struktur) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <x-input-label for="jabatan" :value="__('Jabatan')" />
                                <x-text-input id="jabatan" class="block mt-1 w-full" type="text" name="jabatan" :value="old('jabatan', $struktur->jabatan)" placeholder="Ketua, Wakil Ketua, Sie. Acara, Anggota, ..." required />
                                <x-input-error :messages="$errors->get('jabatan')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="user_id" :value="__('Mahasiswa')" />
                                <select id="user_id" name="user_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                                    <option value="">-- Pilih Mahasiswa --</option>
                                    @foreach ($mahasiswa as $m)
                                        <option value="{{ $m->id }}" {{ old('user_id', $struktur->user_id) == $m->id ? 'selected' : '' }}>
                                            {{ $m->nama }} ({{ $m->nim }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="urutan" :value="__('Urutan')" />
                                <x-text-input id="urutan" class="block mt-1 w-full" type="number" name="urutan" :value="old('urutan', $struktur->urutan)" min="0" required />
                                <x-input-error :messages="$errors->get('urutan')" class="mt-2" />
                                <p class="text-xs text-gray-400 mt-1">Semakin kecil semakin atas.</p>
                            </div>

                            <div>
                                <x-input-label for="parent_id" :value="__('Induk Jabatan (Opsional)')" />
                                <select id="parent_id" name="parent_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                    <option value="">-- Jabatan Utama --</option>
                                    @foreach ($jabatan as $j)
                                        <option value="{{ $j->id }}" {{ old('parent_id', $struktur->parent_id) == $j->id ? 'selected' : '' }}>
                                            {{ $j->jabatan }} — {{ $j->user->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('parent_id')" class="mt-2" />
                                <p class="text-xs text-gray-400 mt-1">Kosongkan jika ini jabatan utama (Ketua, Sie, dll).</p>
                            </div>

                            <div>
                                <x-input-label for="foto" :value="__('Foto (Opsional)')" />
                                <input id="foto" class="block mt-1 w-full" type="file" name="foto" accept="image/*" />
                                <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                                @if ($struktur->foto)
                                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak diganti.</p>
                                @else
                                    <p class="text-xs text-gray-400 mt-1">Kosongkan untuk pakai foto profil mahasiswa.</p>
                                @endif
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="deskripsi" :value="__('Deskripsi (Opsional)')" />
                                <textarea id="deskripsi" name="deskripsi" rows="3" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Tugas dan tanggung jawab...">{{ old('deskripsi', $struktur->deskripsi) }}</textarea>
                                <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 space-x-3">
                            <a href="{{ route('admin.struktur.index') }}" class="text-gray-600 hover:text-gray-900">Batal</a>
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
