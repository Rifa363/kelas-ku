@php
    $title = 'Notifikasi';
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Notifikasi') }}
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
                    <h3 class="text-lg font-semibold text-gray-800">Pemberitahuan</h3>
                    <p class="text-sm text-gray-500">Notifikasi dan pengumuman terbaru</p>
                </div>
                <form action="{{ route('notifications.readAll') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white border border-emerald-200 rounded-lg text-sm font-medium text-emerald-600 hover:bg-emerald-50 hover:border-emerald-300 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Tandai semua dibaca
                    </button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="divide-y divide-gray-100">
                    @forelse ($notifications as $notif)
                        @php
                            $notifUrl = $notif->post_id
                                ? route('notifications.redirect', $notif)
                                : null;
                        @endphp
                        <a href="{{ $notifUrl ?? '#' }}"
                           class="p-5 {{ !$notifUrl ? 'cursor-default' : '' }} {{ $notif->status === 'unread' ? 'bg-emerald-50/50 border-l-4 border-emerald-500' : '' }} transition-colors hover:bg-gray-50 flex items-start justify-between gap-4"
                           @if ($notifUrl) onclick="event.stopPropagation()" @endif>
                            <div class="flex items-start gap-3 min-w-0">
                                @if ($notif->status === 'unread')
                                    <div class="mt-1.5 w-2 h-2 rounded-full bg-emerald-500 shrink-0"></div>
                                @else
                                    <div class="mt-1.5 w-2 h-2 rounded-full bg-gray-300 shrink-0"></div>
                                @endif
                                <div>
                                    <p class="font-medium text-gray-900 {{ $notif->status === 'unread' ? 'font-semibold' : '' }}">{{ $notif->judul }}</p>
                                    <p class="text-sm text-gray-600 mt-0.5">{{ $notif->pesan }}</p>
                                    <p class="text-xs text-gray-400 mt-1.5">{{ $notif->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            @if ($notif->status === 'unread')
                                <form action="{{ route('notifications.read', $notif) }}" method="POST" class="shrink-0" onclick="event.stopPropagation()">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1.5 text-xs font-medium text-emerald-700 bg-emerald-50 rounded-lg hover:bg-emerald-100 transition-colors">Tandai dibaca</button>
                                </form>
                            @endif
                        </a>
                    @empty
                        <div class="p-12 text-center">
                            <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <p class="text-lg font-medium text-gray-500">Tidak ada notifikasi</p>
                            <p class="text-sm text-gray-400 mt-1">Semua pemberitahuan akan muncul di sini</p>
                        </div>
                    @endforelse
                </div>

                <div class="px-5 py-4 border-t border-gray-100">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
