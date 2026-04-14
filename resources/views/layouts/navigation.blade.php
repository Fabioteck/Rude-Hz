@if(auth()->check() && auth()->user()->is_admin)
    <!-- NAV ADMIN BREEZE STYLE (BIANCO PULITO) -->
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="font-bold text-gray-900 tracking-tighter text-lg">
                            Rude-Hz  <span class="text-[10px] bg-gray-100 px-2 py-0.5 rounded ml-1 text-gray-500 uppercase tracking-widest font-medium"> Admin </span>
                        </a>
                    </div>

                    <!-- Menu Centrale Admin con Padding a sinistra per centrarlo meglio -->
                    <div class="hidden space-x-10 sm:-my-px sm:ml-20 sm:flex">
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            Dashboard
                        </x-nav-link>

                        <x-nav-link href="/admin/artists" :active="request()->is('admin/artists*')">
                            Artisti
                        </x-nav-link>

                        <!-- MODERAZIONE PUNTA A /MODERATION -->
                        <x-nav-link href="/admin/radio/moderation" :active="request()->is('admin/radio/moderation*')">
                            Moderazione
                        </x-nav-link>

                        <!-- TRACCE PUNTA A /ARCHIVE -->
                        <x-nav-link href="/admin/radio/archive" :active="request()->is('admin/radio/archive*')">
                            Tracce
                        </x-nav-link>

                        <x-nav-link href="/admin/contests" :active="request()->is('admin/contests*')">
                            Contest
                        </x-nav-link>

                        <x-nav-link href="/admin/news" :active="request()->is('admin/news*')">
                            News
                        </x-nav-link>
                    </div>
                </div>

                <!-- User & Logout -->
                <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-6">
                    <span class="text-sm font-medium text-gray-500">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-bold text-red-600 hover:text-red-800 transition">
                            Esci
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
@else
    <!-- NAV FRONTEND (IL TUO DESIGN NERO) -->
    <nav class="bg-black py-6 px-4 sm:px-8 border-b border-white/5">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center">
                <a href="/" class="text-2xl font-black tracking-tighter text-[#d9ff00]">Rude-Hz.it</a>
            </div>
            <div class="hidden md:flex items-center space-x-10">
                <a href="#news" class="text-[11px] font-black uppercase tracking-[0.2em] text-white hover:text-[#d9ff00]">News</a>
                <a href="#artisti" class="text-[11px] font-black uppercase tracking-[0.2em] text-white hover:text-[#d9ff00]">Artisti</a>
                <a href="#tracce" class="text-[11px] font-black uppercase tracking-[0.2em] text-white hover:text-[#d9ff00]">Tracce</a>
            </div>
            <div class="flex items-center space-x-8">
                @auth
                    <a href="{{ Auth::user()->is_admin ? route('admin.dashboard') : route('user.studio') }}" class="text-[11px] font-black uppercase text-white hover:text-[#d9ff00]">
                        {{ Auth::user()->is_admin ? 'Panel Admin' : 'My Studio' }}
                    </a>
                @endauth
            </div>
        </div>
    </nav>
@endif
