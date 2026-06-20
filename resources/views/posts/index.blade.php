@php
    $title = 'Feed Informasi';
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Feed Informasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Informasi Terbaru</h3>
                    <p class="text-sm text-gray-500">Berbagi informasi dan diskusi bersama</p>
                </div>
                <a href="{{ route('posts.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-600 border border-transparent rounded-lg font-semibold text-sm text-white shadow-md hover:shadow-lg hover:from-emerald-700 hover:to-teal-700 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Buat Postingan
                </a>
            </div>

            @forelse ($posts as $post)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-3">
                                @php $foto = $post->user->fotoUrl(); @endphp
                                @if ($foto)
                                    <img src="{{ $foto }}" alt="{{ $post->user->nama }}" class="w-10 h-10 rounded-full object-cover ring-2 ring-emerald-100">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold ring-2 ring-emerald-50">
                                        {{ substr($post->user->nama, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $post->user->nama }}</p>
                                    <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700">{{ $post->kategori }}</span>
                        </div>

                        <h3 class="text-lg font-semibold mb-2">
                            <a href="{{ route('posts.show', $post) }}" class="text-gray-900 hover:text-emerald-600 transition-colors">{{ $post->judul }}</a>
                        </h3>

                        <p class="text-gray-600 mb-4 leading-relaxed">{{ Str::limit($post->isi, 200) }}</p>

                        @if ($post->lampiran)
                            <div class="mb-4 inline-flex items-center gap-1.5 px-3 py-2 bg-gray-50 rounded-lg text-sm text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <a href="{{ Storage::url($post->lampiran) }}" target="_blank" class="font-medium">Download Lampiran</a>
                            </div>
                        @endif

                        <div class="flex items-center gap-4 text-sm text-gray-500 border-t border-gray-100 pt-4">
                            <form action="{{ route('posts.reaction', $post) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="reaction" value="like">
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                    Suka ({{ $post->reactions->where('reaction', 'like')->count() }})
                                </button>
                            </form>

                            <form action="{{ route('posts.reaction', $post) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="reaction" value="dislike">
                                <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg hover:bg-red-50 hover:text-red-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                    Tidak Suka ({{ $post->reactions->where('reaction', 'dislike')->count() }})
                                </button>
                            </form>

                            <a href="{{ route('posts.show', $post) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg hover:bg-gray-100 hover:text-gray-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                Komentar ({{ $post->comments->count() }})
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        <p class="text-lg font-medium text-gray-500">Belum ada postingan</p>
                        <p class="text-sm text-gray-400 mt-1">Jadilah yang pertama berbagi informasi!</p>
                    </div>
                </div>
            @endforelse

            <div class="mt-4">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
