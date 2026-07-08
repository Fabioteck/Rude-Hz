@extends('layouts.frontend')

@section('content')
<section class="py-24 bg-[#0a0a0a] min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <!-- LINK DI RITORNO UNDERGROUND -->
        <div class="mb-12">
            <a href="/playlists" class="text-xs font-bold text-gray-500 uppercase tracking-widest font-mono italic hover:text-[#d9ff00] transition-colors flex items-center gap-2 group">
                <span class="transition-transform group-hover:-translate-x-1">←</span> Back to playlists
            </a>
        </div>

        <!-- DETTAGLI PLAYLIST SELEZIONATA -->
        <div class="mb-16 flex flex-col md:flex-row md:items-end md:justify-between border-b border-white/5 pb-10 gap-8">
            <div class="max-w-3xl">
                <div class="flex items-center gap-4 mb-4">
                    <span class="bg-[#d9ff00] text-black text-[10px] font-black uppercase font-mono tracking-widest px-3 py-1 rounded-sm">
                        Official Selection
                    </span>
                    <span class="text-gray-500 text-xs font-mono uppercase italic">
                        Added {{ $playlist->created_at->diffForHumans() }}
                    </span>
                </div>
                <h1 class="text-5xl md:text-6xl font-black uppercase italic tracking-tighter text-white">
                    {{ $playlist->title ?? $playlist->name }}
                </h1>
                <p class="text-gray-400 text-sm font-mono italic mt-4 leading-relaxed">
                    {{ $playlist->description ?? 'No description provided for this selection.' }}
                </p>
            </div>

            <!-- Contatore Tracce Stile Pillola Monocromatica -->
            <div class="bg-[#171717] border border-white/5 rounded-2xl px-6 py-4 text-center self-start md:self-end min-w-[120px]">
                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest font-mono block">Total Tracks</span>
                <span class="text-3xl font-black text-[#d9ff00] mt-1 block font-mono">{{ $playlist->tracks->count() }}</span>
            </div>
        </div>

        <!-- SEZIONE LISTA TRACCE -->
        <div class="mb-6">
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-widest font-mono mb-6">Tracklist</h3>
        </div>

        @if($playlist->tracks->isEmpty())
            <div class="bg-[#171717] rounded-2xl p-8 text-center border border-white/5">
                <p class="text-sm text-gray-500 font-mono italic uppercase">This playlist contains no tracks yet.</p>
            </div>
        @else
            <!-- Lista Tracce Stilizzata Rude-Hz -->
            <div class="space-y-4">
                @foreach($playlist->tracks as $index => $track)
                    <div class="bg-[#171717] border border-white/5 rounded-2xl p-5 flex items-center justify-between hover:border-[#d9ff00]/40 transition-all duration-300 group">
                        
                        <!-- Info Brano e Artista -->
                        <div class="flex items-center gap-6 truncate">
                            <span class="text-sm font-bold text-gray-600 font-mono w-6 text-right">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <div class="truncate">
                                <h4 class="font-bold text-lg uppercase tracking-tight text-white group-hover:text-[#d9ff00] transition duration-300 truncate">
                                    {{ $track->title ?? $track->name }}
                                </h4>
                                <p class="text-xs text-gray-500 font-mono italic uppercase mt-1 truncate">
                                    {{ $track->artist->name ?? 'Unknown Artist' }}
                                </p>
                            </div>
                        </div>

                        <!-- Azione Riproduttore (Tasto Play) -->
                        <div class="flex items-center gap-4 shrink-0">
                            <span class="text-[11px] font-mono text-gray-600 uppercase tracking-wider hidden sm:block">
                                {{ $track->duration_label ?? '03:45' }}
                            </span>
                            <button type="button" 
                                    class="w-10 h-10 bg-white text-black rounded-full flex items-center justify-center font-black hover:bg-[#d9ff00] hover:scale-105 transition-all text-xs shadow-sm"
                                    title="Play track">
                                ▶
                            </button>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

    </div>
</section>
@endsection
