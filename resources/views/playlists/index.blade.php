@extends('layouts.frontend')

@section('content')
<section class="py-24 bg-[#0a0a0a] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <!-- INTESTAZIONE COORDINATA -->
        <div class="mb-16">
            <h1 class="text-5xl md:text-6xl font-black uppercase italic tracking-tighter text-white">Playlists</h1>
            <p class="text-[#d9ff00] uppercase tracking-widest text-sm mt-4 font-bold font-mono italic">Le selezioni ufficiali di rude-hz</p>
        </div>

        <!-- ELENCO PLAYLIST -->
        @if($playlists->isEmpty())
            <!-- Box di cortesia minimale underground se il db è vuoto -->
            <div class="bg-[#171717] rounded-2xl p-12 text-center border border-white/5">
                <h3 class="font-bold text-xl uppercase tracking-tighter italic text-white mb-2">Rude-Hz Selection</h3>
                <p class="text-sm text-gray-500 font-mono italic uppercase mb-6">Nessuna playlist ancora pubblicata</p>
                <span class="inline-block bg-[#171717] text-[#d9ff00] border border-[#d9ff00]/30 text-xs font-bold uppercase font-mono tracking-widest px-6 py-2 rounded-full">Coming Soon</span>
            </div>
        @else
            <!-- Griglia allineata allo stile della community -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($playlists as $playlist)
                <div class="group bg-[#171717] rounded-2xl p-6 border border-white/5 hover:border-[#d9ff00]/50 transition-all duration-500 flex flex-col justify-between h-64">
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-[10px] text-[#d9ff00] font-mono uppercase font-bold border border-[#d9ff00]/30 px-2.5 py-0.5 rounded-full">
                                Playlist
                            </span>
                            <span class="text-xs text-gray-500 font-mono italic uppercase">
                                {{ $playlist->created_at->diffForHumans() }}
                            </span>
                        </div>
                        
                        <h4 class="font-bold text-2xl uppercase tracking-tighter italic text-white group-hover:text-[#d9ff00] transition duration-300">
                            {{ $playlist->title ?? $playlist->name }}
                        </h4>
                        <p class="text-sm text-gray-400 font-mono italic mt-2 line-clamp-2">
                            {{ $playlist->description ?? 'Nessuna descrizione.' }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-white/5 flex items-center justify-between">
                        <span class="text-xs font-mono uppercase font-bold text-gray-500">
                            {{ $playlist->tracks_count ?? 0 }} Tracks
                        </span>
                        <a href="{{ route('playlists.show', $playlist->slug ?? '') }}" 
                           class="text-sm font-black text-white uppercase tracking-wider group-hover:text-[#d9ff00] transition flex items-center gap-1 font-mono italic">
                            Listen <span class="transition-transform group-hover:translate-x-1">→</span>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif

    </div>
</section>
@endsection
