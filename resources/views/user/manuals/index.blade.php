@extends('layouts.frontend')

@section('content')
<!-- SFONDO NEURONALE -->
<canvas id="network-canvas" class="fixed inset-0 w-full h-full z-0 opacity-30 pointer-events-none"></canvas>

<div class="relative z-10 w-full bg-zinc-950 min-h-screen text-white pt-16 pb-36 font-mono">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <!-- HEADER -->
        <div class="mb-12 border-b border-white/10 pb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('user.console') }}" class="text-xs text-zinc-500 hover:text-[#d9ff00] uppercase tracking-widest transition">← Console</a>
                    <span class="text-zinc-700">/</span>
                    <span class="ds-badge px-2 py-0.5 text-[9px]">Documentazione</span>
                </div>
                <h1 class="text-4xl md:text-6xl font-black uppercase italic tracking-tighter text-white">
                    Manuali & Guide
                </h1>
                <p class="text-xs text-[#d9ff00] uppercase tracking-widest mt-2 font-bold italic">
                    [KB-01] Knowledge base tecnica per produttori e artisti
                </p>
            </div>
            <div class="text-xs font-mono text-zinc-500 uppercase">
                MANUALI DISPONIBILI: <span class="text-[#d9ff00] font-bold">{{ $manuals->count() }}</span>
            </div>
        </div>

        <!-- FILTRI DI RICERCA / CATEGORIA E LIVELLO -->
        <div class="mb-10 bg-zinc-900/40 border border-white/5 rounded-md p-6 backdrop-blur-md">
            <form method="GET" action="{{ route('user.manuals.index') }}" class="flex flex-col md:flex-row items-center gap-4">
                <div class="w-full md:w-1/3">
                    <label class="block text-[10px] font-black text-zinc-400 uppercase tracking-widest mb-1.5">Categoria</label>
                    <select name="category" class="w-full bg-[#0a0a0a] border border-white/10 rounded-md text-xs text-white p-3 font-mono focus:border-[#d9ff00] focus:ring-[#d9ff00]">
                        <option value="">Tutte le categorie</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full md:w-1/3">
                    <label class="block text-[10px] font-black text-zinc-400 uppercase tracking-widest mb-1.5">Livello</label>
                    <select name="level" class="w-full bg-[#0a0a0a] border border-white/10 rounded-md text-xs text-white p-3 font-mono focus:border-[#d9ff00] focus:ring-[#d9ff00]">
                        <option value="">Tutti i livelli</option>
                        @foreach($levels as $lvl)
                            <option value="{{ $lvl }}" {{ request('level') == $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full md:w-1/3 flex items-end gap-2 pt-5">
                    <button type="submit" class="w-full py-3 ds-btn text-xs tracking-widest">
                        Filtra
                    </button>
                    @if(request('category') || request('level'))
                        <a href="{{ route('user.manuals.index') }}" class="px-4 py-3 bg-zinc-900 border border-white/10 text-zinc-400 hover:text-white rounded-md text-xs uppercase font-bold text-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- GRIGLIA MANUALI -->
        @if($manuals->isEmpty())
            <div class="ds-card p-16 text-center backdrop-blur-md max-w-lg mx-auto">
                <div class="w-14 h-14 mx-auto mb-4 rounded-md bg-[#d9ff00]/10 border border-[#d9ff00]/30 flex items-center justify-center text-[#d9ff00] font-black text-lg">
                    00
                </div>
                <h3 class="text-xl font-black uppercase tracking-tighter text-white mb-2">Nessun manuale trovato</h3>
                <p class="text-xs text-zinc-400 font-mono italic uppercase mb-6">Nessun documento corrisponde ai filtri selezionati.</p>
                <a href="{{ route('user.manuals.index') }}" class="inline-block px-6 py-3 ds-btn text-xs tracking-widest">
                    Mostra tutti
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($manuals as $manual)
                <div class="ds-card p-6 backdrop-blur-md flex flex-col justify-between group hover:border-[#d9ff00]/50 transition-all">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="ds-badge px-2.5 py-0.5 text-[9px]">{{ $manual->category }}</span>
                            <span class="text-[10px] text-zinc-500 uppercase tracking-widest font-bold">{{ $manual->level }}</span>
                        </div>
                        <h3 class="text-xl font-black uppercase italic tracking-tight text-white group-hover:text-[#d9ff00] transition mb-3">
                            {{ $manual->title }}
                        </h3>
                        <p class="text-xs text-zinc-400 leading-relaxed italic line-clamp-3 mb-6">
                            {{ $manual->summary }}
                        </p>
                    </div>
                    <div class="pt-4 border-t border-white/5 flex items-center justify-between">
                        <span class="text-[10px] text-zinc-500 uppercase">Aggiornato {{ $manual->updated_at->format('d/m/Y') }}</span>
                        <a href="{{ route('user.manuals.show', $manual->slug) }}" class="px-4 py-2 ds-btn text-[10px] tracking-widest">
                            Leggi →
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection
