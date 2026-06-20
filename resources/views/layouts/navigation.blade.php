<nav x-data="{ open: false }" class="bg-gradient-to-r from-emerald-600 to-teal-600 shadow-lg sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <span class="text-white font-bold text-lg hidden sm:block">{{ config('app.name', 'TPLE006') }}</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-8 sm:flex sm:items-center">
                    <a href="{{ route('dashboard') }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150
                        {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                        {{ __('Dashboard') }}
                    </a>
                    <a href="{{ route('struktur-kelas.index') }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150
                        {{ request()->routeIs('struktur-kelas.*') ? 'bg-white/20 text-white' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                        {{ __('Struktur Kelas') }}
                    </a>
                    <a href="{{ route('feed') }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150
                        {{ request()->routeIs('feed') || request()->routeIs('posts.*') ? 'bg-white/20 text-white' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                        {{ __('Feed') }}
                    </a>
                    <a href="{{ route('notifications.index') }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150 inline-flex items-center
                        {{ request()->routeIs('notifications.*') ? 'bg-white/20 text-white' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                        {{ __('Notifikasi') }}
                        @php $unreadCount = Auth::user()->notifications()->where('status', 'unread')->count(); @endphp
                        @if ($unreadCount > 0)
                            <span class="ml-1.5 px-1.5 py-0.5 text-xs font-bold bg-white text-emerald-700 rounded-full">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
                        @endif
                    </a>
                    @if (Auth::user()->isAdmin())
                        <a href="{{ route('admin.mahasiswa.index') }}"
                            class="px-3 py-2 rounded-lg text-sm font-medium transition-all duration-150
                            {{ request()->routeIs('admin.*') ? 'bg-white/20 text-white' : 'text-emerald-50 hover:bg-white/10 hover:text-white' }}">
                            {{ __('Admin') }}
                        </a>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 rounded-lg text-sm leading-4 font-medium text-white/90 hover:text-white hover:bg-white/10 focus:outline-none transition ease-in-out duration-150">
                            @php $foto = Auth::user()->fotoUrl(); @endphp
                            @if ($foto)
                                <img src="{{ $foto }}" alt="{{ Auth::user()->nama }}" class="w-8 h-8 rounded-full object-cover mr-2 ring-2 ring-white/30">
                            @else
                                <div class="w-8 h-8 rounded-full bg-emerald-800/40 flex items-center justify-center text-white font-bold text-sm mr-2 ring-2 ring-white/30">{{ substr(Auth::user()->nama, 0, 1) }}</div>
                            @endif
                            <div class="hidden lg:block">{{ Auth::user()->nama }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ __('Profile') }}
                            </div>
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    {{ __('Log Out') }}
                                </div>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-emerald-50 hover:text-white hover:bg-white/10 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-white/10">
        <div class="pt-2 pb-3 space-y-1 px-2 bg-white">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('struktur-kelas.index')" :active="request()->routeIs('struktur-kelas.*')">
                {{ __('Struktur Kelas') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('feed')" :active="request()->routeIs('feed') || request()->routeIs('posts.*')">
                {{ __('Feed') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')">
                {{ __('Notifikasi') }}
                @php $unreadCount = Auth::user()->notifications()->where('status', 'unread')->count(); @endphp
                @if ($unreadCount > 0)
                    <span class="ml-1.5 px-2 py-0.5 text-xs font-bold bg-emerald-500 text-white rounded-full">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
                @endif
            </x-responsive-nav-link>
            @if (Auth::user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.mahasiswa.index')" :active="request()->routeIs('admin.*')">
                    {{ __('Admin') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pb-2 px-2 bg-white border-t border-gray-100">
            <div class="px-4 py-3 flex items-center space-x-3">
                @php $foto = Auth::user()->fotoUrl(); @endphp
                @if ($foto)
                    <img src="{{ $foto }}" alt="{{ Auth::user()->nama }}" class="w-10 h-10 rounded-full object-cover">
                @else
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 font-bold">{{ substr(Auth::user()->nama, 0, 1) }}</div>
                @endif
                <div class="min-w-0">
                    <div class="font-medium text-base text-gray-800 truncate">{{ Auth::user()->nama }}</div>
                    <div class="font-medium text-sm text-gray-500 truncate">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
