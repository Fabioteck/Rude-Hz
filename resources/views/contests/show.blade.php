@extends('layouts.frontend')

@section('content')
<div class="py-24 bg-[#0a0a0a] min-h-screen">
    <div class="max-w-4xl mx-auto px-6 md:px-12">
        
        {{-- Navigazione Back --}}
        <a href="{{ route('contests.index') }}" class="text-[#d9ff00] text-xs font-black uppercase tracking-[0.3em] mb-12 inline-block hover:opacity-50 transition-all">
            &larr; Indietro ai Contest
        </a>

        <article>
    {{-- Titolo Contest --}}
    <h1 class="text-5xl md:text-7xl font-black text-white mb-8 leading-none italic uppercase tracking-tighter">
        {{ $contest->title }}
    </h1>

    {{-- Immagine Cover --}}
    @if($contest->image_path)
        <div class="relative mb-16 rounded-3xl overflow-hidden border border-white/10 shadow-2xl aspect-video md:aspect-[21/9]">
            <img src="{{ asset('storage/' . $contest->image_path) }}" 
                class="w-full h-full object-cover object-center" 
                alt="{{ $contest->title }}">
            
            {{-- Overlay leggero per profondità --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
        </div>
    @endif

    {{-- Descrizione --}}
    <div class="text-gray-300 text-xl leading-relaxed space-y-6 mb-20 font-medium">
        {!! nl2br(e($contest->description)) !!}
    </div>

    {{-- AREA PARTECIPAZIONE --}}
    @auth
        @if(!auth()->user()->is_admin)
            {{-- Contenitore Arrotondato con Glow --}}
            <div class="p-8 md:p-12 border border-white/10 bg-[#111] rounded-[40px] shadow-[0_0_50px_-20px_rgba(217,255,0,0.15)] mb-20">
                <h3 class="text-[#d9ff00] text-3xl font-black mb-10 uppercase italic tracking-tighter">
                    Invia la tua traccia
                </h3>
                
                <form action="{{ route('contests.join', $contest->id) }}" method="POST">
                    @csrf
                    <div class="mb-10">
                        <label class="block text-gray-500 text-[10px] uppercase tracking-[0.2em] font-black mb-4 ml-2">Seleziona dal tuo studio</label>
                        
                        {{-- Select Arrotondata --}}
                        <div class="relative">
                            <select name="track_id" class="w-full bg-black border border-white/10 text-white p-5 rounded-2xl focus:border-[#d9ff00] focus:ring-1 focus:ring-[#d9ff00] transition-all text-sm font-bold appearance-none">
                                @forelse($userTracks as $track)
                                    <option value="{{ $track->id }}">{{ $track->title }}</option>
                                @empty
                                    <option disabled>Nessuna traccia caricata nello studio</option>
                                @endforelse
                            </select>
                            {{-- Icona freccia custom per la select --}}
                            <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-white/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Checkbox stilizzata --}}
                    <div class="flex items-center mb-12 group cursor-pointer">
                        <input id="consent" name="legal_consent" type="checkbox" required class="w-6 h-6 rounded-lg accent-[#d9ff00] bg-black border-white/10 focus:ring-0">
                        <label for="consent" class="ml-4 text-xs text-gray-400 leading-normal font-medium group-hover:text-gray-200 transition-colors">
                            Dichiaro di aver letto il <a href="{{ asset('storage/'.$contest->rules_pdf) }}" target="_blank" class="text-[#d9ff00] font-black hover:underline px-1">Regolamento Ufficiale</a> e di accettare il disclaimer legale.
                        </label>
                    </div>

                    @if($userTracks->count() > 0)
                        <button type="submit" class="w-full md:w-auto bg-[#d9ff00] text-black font-black py-5 px-14 rounded-full hover:scale-105 active:scale-95 transition-all uppercase text-xs tracking-[0.2em] shadow-[0_15px_30px_-10px_rgba(217,255,0,0.3)]">
                            Invia Candidatura
                        </button>
                    @else
                        <a href="{{ route('user.studio') }}" class="inline-block text-[#d9ff00] border-2 border-[#d9ff00] py-4 px-10 rounded-full font-black uppercase text-[10px] tracking-widest hover:bg-[#d9ff00] hover:text-black transition-all">
                            Vai allo studio per caricare musica
                        </a>
                    @endif
                </form>
            </div>
        @endif
    @else
        {{-- Box Invito Login Arrotondato --}}
        <div class="p-10 bg-[#d9ff00] rounded-[40px] flex flex-col md:flex-row items-center justify-between gap-8 shadow-2xl">
            <div class="text-black text-center md:text-left">
                <h4 class="text-3xl font-black uppercase italic tracking-tighter leading-none mb-2">Vuoi partecipare?</h4>
                <p class="font-bold opacity-70">Accedi per caricare le tue tracce e sfidare gli altri.</p>
            </div>
            <a href="{{ route('login') }}" class="bg-black text-white px-12 py-5 rounded-full font-black uppercase text-xs tracking-widest hover:scale-105 transition-all">
                Login / Register
            </a>
        </div>
    @endauth
</article>

    </div>
</div>
@endsection
