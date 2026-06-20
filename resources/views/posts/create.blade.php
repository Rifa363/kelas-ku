@php
    $title = 'Buat Postingan';
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Postingan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="judul" :value="__('Judul')" />
                            <x-text-input id="judul" class="block mt-1 w-full" type="text" name="judul" :value="old('judul')" required />
                            <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="kategori" :value="__('Kategori')" />
                            <select id="kategori" name="kategori" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="">Pilih Kategori</option>
                                <option value="Akademik" {{ old('kategori') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                <option value="Tugas" {{ old('kategori') == 'Tugas' ? 'selected' : '' }}>Tugas</option>
                                <option value="Jadwal" {{ old('kategori') == 'Jadwal' ? 'selected' : '' }}>Jadwal</option>
                                <option value="Pengumuman" {{ old('kategori') == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                <option value="Seminar" {{ old('kategori') == 'Seminar' ? 'selected' : '' }}>Seminar</option>
                                <option value="Organisasi" {{ old('kategori') == 'Organisasi' ? 'selected' : '' }}>Organisasi</option>
                            </select>
                            <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="isi" :value="__('Isi')" />
                            <textarea id="isi" name="isi" rows="6" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>{{ old('isi') }}</textarea>
                            <x-input-error :messages="$errors->get('isi')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="lampiran" :value="__('Lampiran (PDF, DOCX, PPTX, XLSX, ZIP - maks 20MB)')" />
                            <input id="lampiran" class="block mt-1 w-full" type="file" name="lampiran" />
                            <x-input-error :messages="$errors->get('lampiran')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-gray-900">Batal</a>
                            <x-primary-button>{{ __('Posting') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
