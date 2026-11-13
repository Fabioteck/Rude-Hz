@extends('layouts.frontend')

@section('content')
<!-- SFONDO NEURONALE -->
<canvas id="network-canvas" class="fixed inset-0 w-full h-full z-0 opacity-30 pointer-events-none"></canvas>

<div class="relative z-10 w-full bg-zinc-950 min-h-screen text-white pt-16 pb-36 font-mono">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <!-- BACK LINK -->
        <div class="mb-8">
            <a href="{{ route('user.manuals.index') }}" class="text-xs font-bold text-zinc-500 uppercase tracking-widest hover:text-[#d9ff00] transition-colors flex items-center gap-2 group">
                <span class="transition-transform group-hover:-translate-x-1">←</span> Torna ai manuali
            </a>
        </div>

        <!-- MANUAL ARTICLE CARD -->
        <div class="ds-card p-8 md:p-12 backdrop-blur-md space-y-8">
            
            <!-- HEADER -->
            <div class="border-b border-white/10 pb-8 space-y-4">
                <div class="flex items-center gap-3">
                    <span class="ds-badge px-3 py-1 text-[10px]">{{ $manual->category }}</span>
                    <span class="text-xs text-[#d9ff00] uppercase font-bold tracking-widest">Livello: {{ $manual->level }}</span>
                    <span class="text-xs text-zinc-500 uppercase ml-auto">Ultimo aggiornamento: {{ $manual->updated_at->format('d/m/Y') }}</span>
                </div>
                
                <h1 class="text-3xl md:text-5xl font-black uppercase italic tracking-tighter text-white">
                    {{ $manual->title }}
                </h1>

                @if($manual->summary)
                <p class="text-sm md:text-base text-zinc-300 font-mono italic leading-relaxed bg-zinc-900/60 border-l-2 border-[#d9ff00] p-4 rounded-r-md">
                    {{ $manual->summary }}
                </p>
                @endif
            </div>

            <!-- CONTENT BODY -->
            <div class="text-zinc-200 text-sm md:text-base leading-relaxed space-y-6 font-mono">
                {!! nl2br(e($manual->content)) !!}
            </div>

            <!-- FOOTER NAVIGATION -->
            <div class="pt-8 border-t border-white/10 flex items-center justify-between">
                <a href="{{ route('user.manuals.index') }}" class="px-6 py-3 bg-zinc-900 border border-white/10 text-zinc-300 hover:text-white uppercase font-bold text-xs tracking-widest rounded-md transition">
                    ← Indice Manuali
                </a>
                <a href="{{ route('user.console') }}" class="px-6 py-3 ds-btn text-xs tracking-widest">
                    Console Utente ⚡
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
