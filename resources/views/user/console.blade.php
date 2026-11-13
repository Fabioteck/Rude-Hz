@extends('layouts.frontend')

@section('content')
<!-- SFONDO NEURONALE ESTESO A TUTTA LA PAGINA -->
<canvas id="network-canvas" class="fixed inset-0 w-full h-full z-0 opacity-30 pointer-events-none"></canvas>

<div class="relative z-10 w-full bg-zinc-950 min-h-screen text-white pt-16 pb-36 font-mono">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <!-- HEADER BENTO CONSOLE -->
        <div class="mb-12 bg-zinc-900/40 border border-white/5 rounded-md p-8 backdrop-blur-md flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="ds-badge px-2.5 py-0.5 text-[9px]">User Console</span>
                    <span class="text-xs text-zinc-500 uppercase italic">Session ID: #{{ $user->id }}</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-black uppercase italic tracking-tighter text-white">
                    Bentornato, {{ $user->name }}
                </h1>
                <p class="text-xs text-zinc-400 mt-2 uppercase tracking-widest italic">
                    Area riservata e gestione studio personale Rude-Hz
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('profile.edit') }}" class="px-5 py-3 ds-btn text-xs tracking-widest">
                    Profilo
                </a>
                <a href="{{ route('logout.get') }}" class="px-5 py-3 bg-zinc-900 border border-white/10 hover:border-red-500/50 text-zinc-300 hover:text-red-400 font-bold uppercase text-xs tracking-widest rounded-md transition">
                    Esci
                </a>
            </div>
        </div>

        <!-- GRIGLIA PRINCIPALE CONSOLE -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- COLONNA SINISTRA: I MIEI CONTENUTI -->
            <div class="lg:col-span-2 space-y-6">
                <div class="ds-card p-6 md:p-8 backdrop-blur-md">
                    <div class="flex items-center justify-between pb-4 border-b border-white/10 mb-6">
                        <div>
                            <h2 class="text-xl font-black uppercase italic tracking-tighter text-white">I miei contenuti</h2>
                            <p class="text-[10px] text-[#d9ff00] uppercase tracking-widest mt-1">Tracce e produzioni caricate</p>
                        </div>
                        <a href="{{ route('user.tracks.index') }}" class="text-xs font-bold text-zinc-400 hover:text-[#d9ff00] transition uppercase tracking-widest">
                            Gestisci Studio →
                        </a>
                    </div>

                    @if(isset($tracks) && $tracks->isNotEmpty())
                        <div class="space-y-3">
                            @foreach($tracks as $track)
                            <div class="p-4 bg-zinc-900/60 border border-white/5 rounded-md flex items-center justify-between gap-4">
                                <div class="truncate">
                                    <h4 class="font-bold text-sm uppercase text-white truncate">{{ $track->title }}</h4>
                                    <p class="text-[10px] text-zinc-500 uppercase font-mono mt-0.5">Genere: {{ $track->genre }} • Status: {{ $track->is_approved ? 'Approvata' : 'In attesa' }}</p>
                                </div>
                                <span class="ds-badge px-2 py-1 text-[9px]">{{ $track->is_approved ? 'LIVE' : 'PENDING' }}</span>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <!-- STATO VUOTO CURATO -->
                        <div class="p-12 text-center bg-zinc-900/30 border border-white/5 rounded-md">
                            <div class="w-14 h-14 mx-auto mb-4 rounded-md bg-[#d9ff00]/10 border border-[#d9ff00]/30 flex items-center justify-center text-[#d9ff00] font-black text-lg">
                                00
                            </div>
                            <h3 class="text-lg font-black uppercase tracking-tight text-white mb-2">Nessun contenuto personale</h3>
                            <p class="text-xs text-zinc-400 italic uppercase mb-6 max-w-md mx-auto">
                                Non hai ancora caricato tracce o configurato il tuo catalogo personale.
                            </p>
                            <a href="{{ route('user.tracks.index') }}" class="inline-block px-6 py-3 ds-btn text-xs tracking-widest shadow-lg">
                                Carica la tua prima traccia
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- COLONNA DESTRA: MANUALI & ASSISTANT -->
            <div class="space-y-6">
                
                <!-- MANUALI -->
                <div class="ds-card p-6 backdrop-blur-md relative overflow-hidden">
                    <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-[#d9ff00]/5 rounded-full blur-xl pointer-events-none"></div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="ds-badge px-2 py-0.5 text-[9px]">Documentazione</span>
                        <span class="text-[10px] font-bold text-[#d9ff00] uppercase tracking-widest bg-[#d9ff00]/10 border border-[#d9ff00]/30 px-2 py-0.5 rounded-sm">Attivo</span>
                    </div>
                    <h3 class="text-lg font-black uppercase italic tracking-tighter text-white mb-2">Manuali & Guide</h3>
                    <p class="text-xs text-zinc-400 leading-relaxed italic mb-6">
                        Guide tecniche, specifiche di mastering, standard liberatorie e documentazione per artisti Rude-Hz.
                    </p>
                    <a href="{{ route('user.manuals.index') }}" class="block w-full py-3 ds-btn text-xs tracking-widest text-center">
                        Accedi ai Manuali →
                    </a>
                </div>

                <!-- ASSISTANT -->
                <div class="ds-card p-6 backdrop-blur-md relative overflow-hidden">
                    <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-[#d9ff00]/5 rounded-full blur-xl pointer-events-none"></div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="ds-badge px-2 py-0.5 text-[9px]">AI Neural</span>
                        <span class="text-[10px] font-bold text-[#d9ff00] uppercase tracking-widest bg-[#d9ff00]/10 border border-[#d9ff00]/30 px-2 py-0.5 rounded-sm">Attivo</span>
                    </div>
                    <h3 class="text-lg font-black uppercase italic tracking-tighter text-white mb-2">Rude-Hz Assistant</h3>
                    <p class="text-xs text-zinc-400 leading-relaxed italic mb-6">
                        Assistente virtuale interattivo per supporto tecnico, consigli di produzione e navigazione nel network.
                    </p>
                    <a href="{{ route('user.assistant') }}" class="block w-full py-3 ds-btn text-xs tracking-widest text-center">
                        Avvia Chat Assistant →
                    </a>
                </div>

            </div>

        </div>

    </div>
</div>
@endsection
