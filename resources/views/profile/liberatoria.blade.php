@extends('layouts.frontend')

@section('content')
<div class="py-24 bg-[#0a0a0a] min-h-screen">
    <div class="max-w-4xl mx-auto px-6 md:px-12">
        
        <h1 class="text-5xl md:text-7xl font-black text-white mb-8 italic uppercase tracking-tighter">
            Liberatoria <span class="text-[#d9ff00]">Legale</span>
        </h1>

        <div class="p-8 md:p-12 border border-white/10 bg-[#111] rounded-[40px] shadow-2xl">
            <p class="text-gray-400 mb-10 text-lg leading-relaxed">
                Per poter partecipare ai contest e pubblicare le tue tracce su <span class="text-white font-bold">Rude-Hz</span>, è necessario completare i dati della liberatoria per la gestione dei diritti.
            </p>

            <form action="{{ route('profile.liberatoria.update') }}" method="POST" class="space-y-8">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Nome Reale --}}
                    <div>
                        <label class="block text-gray-500 text-[10px] uppercase tracking-[0.2em] font-black mb-3 ml-2">Nome Completo</label>
                        <input type="text" name="real_name" value="{{ auth()->user()->real_name }}" 
                               class="w-full bg-black border border-white/10 text-white p-4 rounded-2xl focus:border-[#d9ff00] focus:ring-1 focus:ring-[#d9ff00] transition-all font-bold">
                    </div>

                    {{-- Codice Fiscale --}}
                    <div>
                        <label class="block text-gray-500 text-[10px] uppercase tracking-[0.2em] font-black mb-3 ml-2">Codice Fiscale</label>
                        <input type="text" name="tax_code" value="{{ auth()->user()->tax_code }}" 
                               class="w-full bg-black border border-white/10 text-white p-4 rounded-2xl focus:border-[#d9ff00] focus:ring-1 focus:ring-[#d9ff00] transition-all font-bold">
                    </div>
                </div>

                {{-- Testo Liberatoria --}}
                <div class="p-6 bg-black/50 border border-white/5 rounded-2xl text-xs text-gray-500 leading-relaxed max-h-40 overflow-y-auto">
                    <h4 class="text-white font-bold mb-2 uppercase">Termini e Condizioni</h4>
                    L'artista dichiara di essere l'unico autore e titolare dei diritti delle tracce caricate... 
                    [Inserisci qui il testo legale della tua liberatoria]
                </div>

                {{-- Check di Accettazione --}}
                <div class="flex items-center group cursor-pointer">
                    <input id="accept" name="accepted_terms" type="checkbox" required 
                           class="w-6 h-6 rounded-lg accent-[#d9ff00] bg-black border-white/10 focus:ring-0" 
                           {{ auth()->user()->accepted_terms ? 'checked' : '' }}>
                    <label for="accept" class="ml-4 text-sm text-gray-300 font-medium group-hover:text-[#d9ff00] transition-colors">
                        Accetto i termini della liberatoria sopra indicati.
                    </label>
                </div>

                <div class="pt-4">
                    <button type="submit" class="bg-[#d9ff00] text-black font-black py-5 px-14 rounded-full hover:scale-105 active:scale-95 transition-all uppercase text-xs tracking-widest shadow-[0_15px_30px_-10px_rgba(217,255,0,0.3)]">
                        Salva e Conferma
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
