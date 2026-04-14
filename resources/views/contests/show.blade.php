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
                <div class="relative mb-16 rounded-3xl overflow-hidden border border-white/10 shadow-2xl">
                    <img src="{{ asset('storage/' . $contest->image_path) }}" class="w-full object-cover max-h-[500px]">
                </div>
            @endif

            {{-- Descrizione --}}
            <div class="text-gray-300 text-xl leading-relaxed space-y-6 mb-20 font-medium">
                {!! nl2br(e($contest->description)) !!}
            </div>

            {{-- AREA PARTECIPAZIONE --}}
            @auth
                @if(!auth()->user()->is_admin)
                    <div class="p-10 border border-[#d9ff00]/30 bg-[#111] rounded-3xl shadow-[0_0_50px_-20px_rgba(217,255,0,0.2)]">
                        <h3 class="text-[#d9ff00] text-2xl font-black mb-8 uppercase italic tracking-tighter">
                            Invia la tua traccia
                        </h3>
                        
                        <form action="{{ route('contests.join', $contest->id) }}" method="POST">
                            @csrf
                            <div class="mb-8">
                                <label class="block text-gray-500 text-[10px] uppercase tracking-[0.2em] font-black mb-3">Seleziona dal tuo studio</label>
                                <select name="track_id" class="w-full bg-black border border-white/10 text-white p-4 rounded-xl focus:border-[#d9ff00] focus:ring-0 transition-all text-sm font-bold">
                                    {{-- QUI RISOLVIAMO L'ERRORE FOREACH CON @FORELSE --}}
                                    @forelse($userTracks as $track)
                                        <option value="{{ $track->id }}">{{ $track->title }}</option>
                                    @empty
                                        <option disabled>Nessuna traccia caricata nello studio</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="flex items-start mb-10">
                                <input id="consent" name="legal_consent" type="checkbox" required class="mt-1 w-5 h-5 accent-[#d9ff00] bg-black border-white/10 rounded">
                                <label for="consent" class="ml-4 text-xs text-gray-400 leading-normal">
                                    Dichiaro di aver letto il <a href="{{ asset('storage/'.$contest->rules_pdf) }}" target="_blank" class="text-[#d9ff00] font-bold hover:underline">Regolamento Ufficiale</a> e di accettare il disclaimer legale.
                                </label>
                            </div>

                            @if($userTracks->count() > 0)
                                <button type="submit" class="bg-[#d9ff00] text-black font-black py-5 px-12 rounded-full hover:scale-105 transition-all uppercase text-xs tracking-widest shadow-[0_15px_30px_-10px_rgba(217,255,0,0.4)]">
                                    Invia Candidatura
                                </button>
                            @else
                                <a href="{{ route('user.studio') }}" class="inline-block text-[#d9ff00] border border-[#d9ff00]/50 py-4 px-8 rounded-full font-black uppercase text-[10px] tracking-widest hover:bg-[#d9ff00] hover:text-black transition-all">
                                    Vai allo studio per caricare musica
                                </a>
                            @endif
                        </form>
                    </div>
                @endif
            @else
                {{-- Box Invito Login --}}
                <div class="p-10 bg-[#d9ff00] rounded-3xl flex flex-col md:flex-row items-center justify-between gap-8 shadow-2xl">
                    <div class="text-black text-center md:text-left">
                        <h4 class="text-3xl font-black uppercase italic tracking-tighter leading-none mb-2">Vuoi partecipare?</h4>
                        <p class="font-bold opacity-60">Accedi per caricare le tue tracce.</p>
                    </div>
                    <a href="{{ route('login') }}" class="bg-black text-white px-10 py-5 rounded-full font-black uppercase text-xs tracking-widest hover:scale-105 transition-all">
                        Login / Register
                    </a>
                </div>
            @endauth
        </article>

    </div>
</div>
@endsection
