<x-app-layout>
    <div class="min-h-screen bg-black py-16 px-6">
        <div class="max-w-5xl mx-auto">
            
            <div class="relative bg-black border border-white/10 rounded-[3rem] p-10 md:p-16 overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
                    
                    <!-- LATO SINISTRO: TITOLI E PLAYER -->
                    <div class="md:col-span-7 space-y-12">
                        <div>
                            <span class="text-[10px] font-black uppercase tracking-[0.5em] text-[#d9ff00] mb-8 block italic">Rude-Hz Drop</span>
                            <h1 class="text-6xl md:text-8xl font-black uppercase tracking-tighter italic leading-[0.85] text-white mb-6">
                                {{ $track->title }}
                            </h1>
                            <p class="text-2xl text-zinc-400 uppercase font-bold tracking-widest">{{ $track->artist->name }}</p>
                        </div>

                        <!-- PLAYER NATIVO -->
                        <div class="bg-zinc-900/30 p-4 rounded-full border border-white/5 shadow-inner max-w-md">
                            <audio controls class="w-full h-8 invert brightness-150 grayscale">
                                <source src="{{ asset('storage/' . $track->file_path) }}" type="audio/mpeg">
                            </audio>
                        </div>

                        <!-- METADATI BASSO -->
                        <div class="grid grid-cols-3 gap-4 pt-10 border-t border-white/5">
                            <div>
                                <span class="block text-[8px] font-black text-zinc-600 uppercase tracking-widest mb-1">Genre</span>
                                <span class="text-[10px] font-bold uppercase text-white">{{ $track->genre }}</span>
                            </div>
                            <div>
                                <span class="block text-[8px] font-black text-zinc-600 uppercase tracking-widest mb-1">BPM</span>
                                <span class="text-[10px] font-bold uppercase text-white">{{ $track->bpm ?? '160' }}</span>
                            </div>
                            <div>
                                <span class="block text-[8px] font-black text-zinc-600 uppercase tracking-widest mb-1">Version</span>
                                <span class="text-[10px] font-bold uppercase text-white">{{ $track->version ?? 'Original' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- LATO DESTRO: QR CODE E SOCIAL -->
                    <div class="md:col-span-5 flex flex-col items-center justify-center space-y-12">
                        <!-- Box QR Verde Acido -->
                        <div class="bg-[#d9ff00] p-4 rounded-[2.5rem] shadow-[0_0_100px_rgba(217,255,0,0.1)]">
                            <img src="{{ asset('storage/' . $track->qr_code_path) }}" class="w-56 h-56 mix-blend-multiply" alt="QR">
                        </div>

                        <div class="w-full max-w-xs space-y-2">
                            <div class="text-right">
                                <a href="https://wa.me{{ urlencode(url()->current()) }}" target="_blank" class="text-[10px] font-black uppercase tracking-widest text-zinc-500 hover:text-white transition-all px-4 py-2 block">WhatsApp</a>
                            </div>
                            
                            <a href="https://facebook.com{{ urlencode(url()->current()) }}" target="_blank" 
                               class="block w-full py-4 border border-white/10 rounded-2xl text-[10px] font-black uppercase tracking-widest text-center hover:bg-white hover:text-black transition-all">
                               Facebook
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <div class="mt-16 text-center">
                <a href="{{ url('/') }}" class="text-[10px] font-black text-zinc-700 hover:text-white uppercase tracking-[0.5em] transition-colors">
                    &larr; Back to Rude-Hz
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
