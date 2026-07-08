<x-studio-layout>
    <div class="py-12 bg-[#0a0a0a] min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8" x-data="{ activeAccordion: 1 }">
            
            <a href="{{ route('user.tracks.index') }}" class="text-[10px] text-gray-500 font-bold uppercase tracking-[0.2em] hover:text-[#d9ff00] mb-8 inline-block transition-colors">
                &larr; Torna al Catalogo
            </a>

            <h1 class="text-white font-black text-2xl uppercase tracking-tighter mb-8 italic">EDIT TRACCIA</h1>

            <form action="{{ route('user.track.update', $track->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- 1. METADATI -->
                <div class="bg-[#111] border border-gray-800 rounded-xl mb-4 overflow-hidden">
                    <button type="button" @click="activeAccordion = (activeAccordion === 1 ? 0 : 1)" class="w-full p-6 flex justify-between items-center text-[10px] font-black uppercase tracking-[0.3em] text-[#d9ff00]">
                        1. Metadati Traccia
                        <span x-text="activeAccordion === 1 ? '[-]' : '[+]'"></span>
                    </button>
                    <div x-show="activeAccordion === 1" x-collapse class="p-6 border-t border-gray-800 space-y-4">
                        <div>
                            <label class="text-[9px] uppercase text-gray-500 font-bold">Titolo</label>
                            <input name="title" value="{{ $track->title }}" class="w-full mt-1 bg-black border border-gray-800 rounded-lg text-sm text-white p-3 focus:border-[#d9ff00] focus:ring-0">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[9px] uppercase text-gray-500 font-bold">Genere</label>
                                <input name="genre" value="{{ $track->genre }}" class="w-full mt-1 bg-black border border-gray-800 rounded-lg text-sm text-white p-3 focus:border-[#d9ff00] focus:ring-0">
                            </div>
                            <div>
                                <label class="text-[9px] uppercase text-gray-500 font-bold">BPM</label>
                                <input name="bpm" value="{{ $track->bpm }}" class="w-full mt-1 bg-black border border-gray-800 rounded-lg text-sm text-white p-3 focus:border-[#d9ff00] focus:ring-0 text-center">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. COVER ARTWORK -->
                <div class="bg-[#111] border border-gray-800 rounded-xl mb-4 overflow-hidden">
                    <button type="button" @click="activeAccordion = (activeAccordion === 2 ? 0 : 2)" class="w-full p-6 flex justify-between items-center text-[10px] font-black uppercase tracking-[0.3em] text-[#d9ff00]">
                        2. Cover Artwork
                        <span x-text="activeAccordion === 2 ? '[-]' : '[+]'"></span>
                    </button>
                    <div x-show="activeAccordion === 2" x-collapse class="p-6 border-t border-gray-800">
                        <div class="flex items-center gap-6">
                            @if($track->cover_path)
                                <img src="{{ asset('storage/' . $track->cover_path) }}" class="h-20 w-20 rounded-lg border border-gray-800 object-cover">
                            @endif
                            <input type="file" name="cover_image" class="block w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-[#d9ff00] file:text-black hover:file:bg-white cursor-pointer">
                        </div>
                    </div>
                </div>

                <!-- 3. PROMOZIONE -->
                <div class="bg-[#111] border border-gray-800 rounded-xl overflow-hidden">
                    <button type="button" @click="activeAccordion = (activeAccordion === 3 ? 0 : 3)" class="w-full p-6 flex justify-between items-center text-[10px] font-black uppercase tracking-[0.3em] text-[#d9ff00]">
                        3. Dati Promozione
                        <span x-text="activeAccordion === 3 ? '[-]' : '[+]'"></span>
                    </button>
                    <div x-show="activeAccordion === 3" x-collapse class="p-6 border-t border-gray-800 text-center" x-data="{ copied: false }">
                        <img src="{{ asset('storage/' . $track->qr_code_path) }}" class="h-32 w-32 mx-auto mb-4 border-2 border-[#d9ff00] p-1 bg-white">
                        <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-6">QR CODE TRACCIA</p>

                        <!-- LINK COPIABILE -->
                        <div class="relative flex items-center mb-6" x-data="{ link: '{{ url('/track/' . $track->slug) }}' }">
                            <input type="text" readonly :value="link" class="w-full bg-black border border-gray-800 rounded-lg text-xs text-gray-400 p-3 pr-20 font-mono">
                            <button @click="navigator.clipboard.writeText(link); copied = true; setTimeout(() => copied = false, 2000)" 
                                    class="absolute right-2 px-3 py-1 bg-[#d9ff00] hover:bg-white text-black text-[9px] font-black uppercase rounded-md transition-colors">
                                <span x-text="copied ? 'Copiato!' : 'Copia'"></span>
                            </button>
                        </div>

                        <!-- CONDIVISIONE SOCIAL -->
                        <div class="grid grid-cols-4 gap-2">
                            @php $shareText = urlencode('Ascolta la mia nuova traccia su RUDE-HZ: ' . url('/track/' . $track->slug)); @endphp
                            <a href="https://wa.me/?text={{ $shareText }}" target="_blank" class="p-3 bg-[#111] hover:bg-[#1a1a1a] border border-gray-800 rounded-lg text-gray-400 hover:text-[#d9ff00] transition-colors" title="WhatsApp">WA</a>
                            <a href="https://t.me/share/url?url={{ url('/track/' . $track->slug) }}&text=Ascolta la mia nuova traccia su RUDE-HZ!" target="_blank" class="p-3 bg-[#111] hover:bg-[#1a1a1a] border border-gray-800 rounded-lg text-gray-400 hover:text-[#d9ff00] transition-colors" title="Telegram">TG</a>
                            <a href="https://www.instagram.com/" target="_blank" class="p-3 bg-[#111] hover:bg-[#1a1a1a] border border-gray-800 rounded-lg text-gray-400 hover:text-[#d9ff00] transition-colors" title="Instagram">IG</a>
                            <a href="#" class="p-3 bg-[#111] hover:bg-[#1a1a1a] border border-gray-800 rounded-lg text-gray-400 hover:text-[#d9ff00] transition-colors" title="SoundCloud">SC</a>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full mt-6 bg-[#d9ff00] hover:bg-white text-black text-[11px] font-black tracking-[0.4em] uppercase py-5 rounded-xl shadow-xl transition-all">
                    Salva Modifiche
                </button>
            </form>
        </div>
    </div>
</x-studio-layout>