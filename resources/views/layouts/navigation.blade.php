<div x-data="{ open: false }" class="relative">

    @if(auth()->check() && auth()->user()->is_admin)
        <!-- NAV ADMIN BREEZE STYLE -->
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Griglia a 3 colonne per centraggio assoluto -->
                <div class="grid grid-cols-3 h-16 items-center">
                    
                    <!-- 1. Logo (Sinistra) -->
                    <div class="flex justify-start">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center font-bold text-gray-900 tracking-tighter text-lg leading-none">
                            Rude-Hz <span class="text-[9px] bg-gray-100 px-2 py-0.5 rounded ml-2 text-gray-500 uppercase tracking-widest font-medium border border-gray-200">  </span>
                        </a>
                    </div>

                    <!-- 2. Menu Desktop (Centro) -->
                    <div class="hidden sm:flex justify-center items-center">
                        <div class="flex space-x-8 md:space-x-10">
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="text-[12px] font-bold uppercase tracking-tight">Dashboard</x-nav-link>
                            <x-nav-link href="/admin/artists" :active="request()->is('admin/artists*')" class="text-[12px] font-bold uppercase tracking-tight">Artisti</x-nav-link>
                            
                            <!-- NUOVA VOCE ARCHIVIO (EX MODERAZIONE) -->
                            <x-nav-link :href="route('admin.radio.archive')" :active="request()->routeIs('admin.radio.archive')" class="text-[12px] font-bold uppercase tracking-tight text-orange-600">Tracce</x-nav-link>
                            
                            <!-- NUOVA VOCE PLAYLIST -->
                            <x-nav-link :href="route('admin.radio.playlist')" :active="request()->routeIs('admin.radio.playlist')" class="text-[12px] font-bold uppercase tracking-tight">Playlist</x-nav-link>
                            
                            <x-nav-link href="/admin/contests" :active="request()->is('admin/contests*')" class="text-[12px] font-bold uppercase tracking-tight">Contest</x-nav-link>
                            <x-nav-link href="/admin/news" :active="request()->is('admin/news*')" class="text-[12px] font-bold uppercase tracking-tight">News</x-nav-link>
                        </div>
                    </div>

                    <!-- 3. User & Hamburger (Destra) -->
                    <div class="flex justify-end items-center">
                        <div class="hidden sm:flex items-center space-x-6">
                            <span class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">{{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}"> @csrf
                                <button type="submit" class="text-[11px] font-black text-red-600 hover:text-red-800 transition uppercase tracking-widest">Esci</button>
                            </form>
                        </div>
                        
                        <!-- Hamburger Mobile Admin -->
                        <div class="flex items-center sm:hidden">
                            <button @click="open = ! open" class="text-gray-500 hover:text-gray-600 p-2">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TENDINA MOBILE ADMIN -->
            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="sm:hidden absolute w-full bg-white z-50 shadow-xl border-b border-gray-200">
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">Dashboard</x-responsive-nav-link>
                    <x-responsive-nav-link href="/admin/artists" :active="request()->is('admin/artists*')">Artisti</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.radio.archive')" :active="request()->routeIs('admin.radio.archive')">Tracce & Moderazione</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.radio.playlist')" :active="request()->routeIs('admin.radio.playlist')">Playlist Player</x-responsive-nav-link>
                    <x-responsive-nav-link href="/admin/contests" :active="request()->is('admin/contests*')">Contest</x-responsive-nav-link>
                    <x-responsive-nav-link href="/admin/news" :active="request()->is('admin/news*')">News</x-responsive-nav-link>
                </div>
                <div class="pt-4 pb-4 border-t border-gray-100 px-4">
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">{{ Auth::user()->name }}</div>
                    <form method="POST" action="{{ route('logout') }}"> @csrf
                        <button type="submit" class="text-sm font-bold text-red-600">Disconnetti</button>
                    </form>
                </div>
            </div>
        </nav>
    @else
        <!-- NAV FRONTEND (DESIGN NERO) -->
        <nav class="bg-black py-6 px-4 sm:px-8 border-b border-white/5 relative z-50">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-black tracking-tighter text-[#d9ff00]">Rude-Hz.it</a>
                </div>

                <!-- NAV FRONTEND 
                @auth           
                <div class="hidden md:flex items-center space-x-10">
                        <a href="{{ Auth::user()->is_admin ? route('admin.dashboard') : route('user.studio') }}" class="text-[11px] font-black uppercase text-[#d9ff00]">
                            {{ Auth::user()->is_admin ? 'Panel Admin' : 'Profilo' }}
                        </a>
                        <a href="{{ Auth::user()->is_admin ? route('admin.dashboard') : route('user.tracks.index') }}" class="text-xl font-black uppercase text-[#d9ff00]">
                                {{ Auth::user()->is_admin ? 'Panel Admin' : 'Tracce' }}
                        </a>
                </div>
                @endauth
                 -->


                <div class="md:hidden flex items-center">
                    <button @click="open = ! open" class="text-[#d9ff00] focus:outline-none p-2">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                            <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- TENDINA MOBILE FRONTEND -->
            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-10" x-transition:enter-end="opacity-100 translate-y-0" class="md:hidden absolute top-full left-0 w-full bg-black border-b border-[#d9ff00]/20 z-40 shadow-2xl">
                <div class="flex flex-col p-8 space-y-6">
                    @auth
                        <div class="pt-6 border-t border-white/10">
                            <a href="{{ Auth::user()->is_admin ? route('admin.dashboard') : route('user.studio') }}" class="text-xl font-black uppercase text-[#d9ff00]">
                                {{ Auth::user()->is_admin ? 'Panel Admin' : 'Profilo' }}
                            </a>
                        </div> 
                        <div class="pt-6 border-t border-white/10">                       
                            <a href="{{ Auth::user()->is_admin ? route('admin.dashboard') : route('user.tracks.index') }}" class="text-xl font-black uppercase text-[#d9ff00]">
                                {{ Auth::user()->is_admin ? 'Panel Admin' : 'Tracce' }}
                            </a>
                        </div>
                        <div class="pt-6 border-t border-white/10">                       
                            <a href="{{ Auth::user()->is_admin ? route('admin.dashboard') : route('profile.liberatoria') }}" class="text-xl font-black uppercase text-[#d9ff00]">
                                {{ Auth::user()->is_admin ? 'Panel Admin' : 'Contest' }}
                            </a>
                        </div>
                        <div class="pt-6 border-t border-white/10">                       
                            <a href="{{ Auth::user()->is_admin ? route('admin.dashboard') : route('profile.liberatoria') }}" class="text-xl font-black uppercase text-[#d9ff00]">
                                {{ Auth::user()->is_admin ? 'Panel Admin' : 'Liberatoria' }}
                            </a>
                        </div>
                        <div class="pt-6 border-t border-white/10">
                            <a href="{{ route('logout') }}" class="text-xl font-black uppercase text-[#d9ff00]">
                                <form method="POST" action="{{ route('logout') }}"> @csrf
                                    <button type="submit">Esci</button>
                                </form>
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>
    @endif
</div>
