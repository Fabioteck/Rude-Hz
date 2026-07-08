<x-studio-layout>
<div class="py-12 bg-[#0a0a0a] min-h-screen">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        
        <h1 class="text-5xl md:text-7xl font-black text-white mb-8 italic uppercase tracking-tighter text-center md:text-left">
            LIBERATORIA <span class="text-[#d9ff00]">LEGALE</span>
        </h1>

        <div class="p-8 md:p-12 border border-gray-800 bg-[#111] rounded-xl shadow-2xl">
            @if(session('success'))
                <div class="mb-6 p-4 bg-[#d9ff00] text-black text-xs font-black uppercase rounded-lg shadow-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(auth()->user()->real_name && auth()->user()->tax_code && auth()->user()->accepted_terms)
                <div class="p-6 bg-[#d9ff00]/10 border border-[#d9ff00] rounded-2xl text-center">
                    <p class="text-[#d9ff00] font-black uppercase tracking-widest text-sm">
                        LIBERATORIA GIÀ FIRMATA E ACCETTATA IN DATA {{ auth()->user()->updated_at->format('d/m/Y') }}
                    </p>
                </div>
            @else
                <p class="text-gray-400 mb-10 text-lg leading-relaxed text-center">
                    Per poter partecipare ai contest e pubblicare le tue tracce su <span class="text-white font-bold">Rude-Hz</span>, è necessario completare i dati della liberatoria per la gestione dei diritti.
                </p>

                <form action="{{ route('profile.liberatoria.update') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Nome Reale --}}
                        <div>
                            <label class="block text-gray-500 text-[10px] uppercase tracking-[0.2em] font-black mb-3 ml-2">Nome Completo</label>
                            <input type="text" name="real_name" value="{{ old('real_name', auth()->user()->artist->real_name ?? '') }}" required
                                   class="w-full bg-black border border-gray-800 text-white p-4 rounded-xl focus:border-[#d9ff00] focus:ring-0 transition-all font-bold {{ $errors->has('real_name') ? 'border-red-500' : '' }}">
                            <x-input-error :messages="$errors->get('real_name')" class="mt-2" />
                        </div>

                        {{-- Codice Fiscale --}}
                        <div>
                            <label class="block text-gray-500 text-[10px] uppercase tracking-[0.2em] font-black mb-3 ml-2">Codice Fiscale</label>
                            <input type="text" name="tax_code" value="{{ old('tax_code', auth()->user()->artist->tax_code ?? '') }}" required
                                   class="w-full bg-black border border-gray-800 text-white p-4 rounded-xl focus:border-[#d9ff00] focus:ring-0 transition-all font-bold {{ $errors->has('tax_code') ? 'border-red-500' : '' }}">
                            <x-input-error :messages="$errors->get('tax_code')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Testo Liberatoria --}}
                    <div class="p-6 bg-black/50 border border-gray-800 rounded-xl text-xs text-gray-500 leading-relaxed max-h-40 overflow-y-auto">
                        <h4 class="text-white font-bold mb-2 uppercase">Termini e Condizioni</h4>
                        L'artista dichiara di essere l'unico autore e titolare dei diritti delle tracce caricate...
                    </div>

                    {{-- Check di Accettazione --}}
                    <div class="flex flex-col group cursor-pointer items-center">
                        <div class="flex items-center">
                            <input id="accept" name="accepted_terms" type="checkbox" required 
                                   class="w-6 h-6 rounded-lg accent-[#d9ff00] bg-black border-gray-700 focus:ring-0">
                            <label for="accept" class="ml-4 text-sm text-gray-300 font-medium group-hover:text-[#d9ff00] transition-colors">
                                Accetto i termini della liberatoria sopra indicati.
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('accepted_terms')" class="mt-2" />
                    </div>

                    <div class="pt-4 flex justify-center">
                        <button type="submit" class="bg-[#d9ff00] text-black font-black py-5 px-14 rounded-xl hover:bg-white transition-all uppercase text-xs tracking-widest shadow-xl">
                            Salva e Conferma
                        </button>
                    </div>
                </form>
            @endif
        </div>

    </div>
</div>
</x-studio-layout>
