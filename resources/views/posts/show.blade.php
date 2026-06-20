@php
    $title = $post->judul;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $post->judul }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg flex items-center gap-2">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            @php $foto = $post->user->fotoUrl(); @endphp
                            @if ($foto)
                                <img src="{{ $foto }}" alt="{{ $post->user->nama }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold">
                                    {{ substr($post->user->nama, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-medium">{{ $post->user->nama }}</p>
                                <p class="text-xs text-gray-500">{{ $post->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full bg-emerald-100 text-emerald-600">{{ $post->kategori }}</span>
                    </div>

                    <div class="prose max-w-none mb-4">
                        {{ $post->isi }}
                    </div>

                    @if ($post->lampiran)
                        <div class="mb-4 p-3 bg-gray-50 rounded">
                            <a href="{{ Storage::url($post->lampiran) }}" class="text-emerald-600 hover:text-emerald-900" target="_blank">
                                Download Lampiran
                            </a>
                        </div>
                    @endif

                    <div class="flex items-center space-x-4 text-sm text-gray-500 border-t pt-3">
                        <form action="{{ route('posts.reaction', $post) }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="reaction" value="like">
                            <button type="submit" class="hover:text-emerald-600">
                                Like ({{ $post->reactions->where('reaction', 'like')->count() }})
                            </button>
                        </form>

                        <form action="{{ route('posts.reaction', $post) }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="reaction" value="dislike">
                            <button type="submit" class="hover:text-red-600">
                                Dislike ({{ $post->reactions->where('reaction', 'dislike')->count() }})
                            </button>
                        </form>
                    </div>

                    @if (auth()->id() === $post->user_id || auth()->user()->isAdmin())
                        <div class="mt-4 space-x-2">
                            <a href="{{ route('posts.edit', $post) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Komentar ({{ $post->comments->whereNull('parent_id')->count() }})</h3>

                    <form action="{{ route('posts.comments.store', $post) }}" method="POST" class="mb-6">
                        @csrf
                        <textarea name="komentar" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Tulis komentar..." required></textarea>
                        <x-input-error :messages="$errors->get('komentar')" class="mt-2" />
                        <div class="mt-2 flex justify-end">
                            <x-primary-button>{{ __('Kirim') }}</x-primary-button>
                        </div>
                    </form>

                    <div class="space-y-4">
                        @foreach ($post->comments->whereNull('parent_id') as $comment)
                            <div class="border rounded p-4">
                                <div class="flex items-center space-x-2 mb-2">
                                    @php $foto = $comment->user->fotoUrl(); @endphp
                                    @if ($foto)
                                        <img src="{{ $foto }}" alt="{{ $comment->user->nama }}" class="w-8 h-8 rounded-full object-cover">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 font-bold text-sm">
                                            {{ substr($comment->user->nama, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-sm">{{ $comment->user->nama }}</p>
                                        <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <p class="text-gray-700">{{ $comment->komentar }}</p>

                                <form action="{{ route('posts.comments.store', $post) }}" method="POST" class="mt-2">
                                    @csrf
                                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                    <div class="flex items-center space-x-2">
                                        <input type="text" name="komentar" placeholder="Balas komentar..." class="flex-1 border-gray-300 rounded-md text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                                        <button type="submit" class="text-sm text-emerald-600 hover:text-emerald-900">Balas</button>
                                    </div>
                                </form>

                                @foreach ($comment->replies as $reply)
                                    <div class="ml-6 mt-2 border-l-2 border-gray-100 pl-4">
                                        <div class="flex items-center space-x-2 mb-1">
                                            @php $foto = $reply->user->fotoUrl(); @endphp
                                            @if ($foto)
                                                <img src="{{ $foto }}" alt="{{ $reply->user->nama }}" class="w-6 h-6 rounded-full object-cover">
                                            @else
                                                <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 font-bold text-xs">
                                                    {{ substr($reply->user->nama, 0, 1) }}
                                                </div>
                                            @endif
                                            <p class="font-medium text-sm">{{ $reply->user->nama }}</p>
                                            <p class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</p>
                                        </div>
                                        <p class="text-gray-700 text-sm">{{ $reply->komentar }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
