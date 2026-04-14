<x-app-layout>
    <div class="py-12 bg-white text-gray-900">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <!-- HEADER PROFILO -->
            <div class="flex flex-col md:flex-row items-center gap-8 mb-16 border-b pb-12">
                <img src="{{ $artist->profile_image ? asset('storage/'.$artist->profile_image) : 'https://picsum.photos' }}" 
                     class="w-48 h-48 rounded-full object-cover shadow-2xl border-4 border-indigo-600">
                
                <div class="text-center md:text-left">
                    <h1 class="text-6xl font-black uppercase italic tracking-tighter">{{ $artist->name }}</h1>
                    <div class="mt-4 flex flex-wrap justify-center md:justify-start gap-4">
                        @if($artist->soundcloud_url)<a href="{{ $artist->soundcloud_url }}" target="_blank" class="text-orange-500 font-bold uppercase text-xs">SoundCloud</a>@endif
                        @if($artist->spotify_url)<a href="{{ $artist->spotify_url }}" target="_blank" class="text-green-500 font-bold uppercase text-xs">Spotify</a>@endif
                        @if($artist->instagram_url)<a href="{{ $artist->instagram_url }}" target="_blank" class="text-pink-500 font-bold uppercase text-xs">Instagram</a>@endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- COLONNA SINISTRA: BIO E NOSTR -->
                <div class="md:col-span-2 space-y-8">
                    <h2 class="text-2xl font-black uppercase italic">Bio</h2>
                    <p class="text-lg leading-relaxed text-gray-600">{{ $artist->bio }}</p>

                    @if($artist->nostr_npub)
                        <div class="p-4 bg-purple-50 rounded-xl border border-purple-100">
                            <p class="text-[10px] uppercase font-bold text-purple-400 mb-1">Nostr Discovery</p>
                            <code class="text-xs break-all font-mono text-purple-700">{{ $artist->nostr_npub }}</code>
                        </div>
                    @endif
                </div>

                <!-- COLONNA DESTRA: SATOSHI & TIPS -->
                <div class="space-y-6">
                    <div class="bg-gray-900 p-8 rounded-[2rem] text-white shadow-2xl relative overflow-hidden">
                        <div class="relative z-10">
                            <h3 class="text-orange-400 font-black uppercase tracking-widest text-xs mb-2">Lightning Support ⚡</h3>
                            <p class="text-2xl font-bold mb-6 italic">Supporta {{ $artist->name }} con i Satoshi</p>
                            
                            @if($artist->ln_address)
                                <div class="bg-white/10 p-4 rounded-lg mb-4">
                                    <p class="text-[10px] text-gray-400 uppercase mb-1">LN Address</p>
                                    <p class="font-mono text-sm break-all">{{ $artist->ln_address }}</p>
                                </div>
                                <!-- Qui potremo aggiungere il tasto "ZAP" di Alby o un generatore di Invoice -->
                                <button class="w-full bg-orange-500 hover:bg-orange-600 text-white font-black py-4 rounded-full uppercase tracking-widest transition shadow-lg shadow-orange-500/20">
                                    Invia Mancia ⚡
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
<!-- SEZIONE SATOSHI & TIPS (Supporto Generale Artista) -->
<div class="mt-16 bg-gray-900 p-10 rounded-[3rem] text-white shadow-2xl border border-white/5 overflow-hidden relative">
    <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
        <div class="flex-1">
            <h3 class="text-orange-400 font-black uppercase tracking-[0.3em] text-[10px] mb-2">Lightning Network Support ⚡</h3>
            <p class="text-3xl font-black italic uppercase tracking-tighter mb-4">Supporta {{ $artist->name }} con i Satoshi</p>
            <p class="text-gray-400 text-sm mb-6 font-mono uppercase tracking-widest">Invia mance istantanee senza intermediari.</p>
            
            <button onclick="sendZap('{{ $artist->ln_address }}')" 
                    class="bg-orange-500 hover:bg-white text-white hover:text-orange-600 font-black py-4 px-10 rounded-full uppercase tracking-widest transition-all duration-300 shadow-lg shadow-orange-500/20 text-xs">
                Invia Mancia Istantanea ⚡
            </button>
        </div>

        <div class="bg-white p-3 rounded-2xl shadow-inner group">
            <img src="https://qrserver.com:{{ $artist->ln_address }}" 
                 alt="QR Code Lightning" class="w-32 h-32 grayscale group-hover:grayscale-0 transition duration-500">
            <p class="text-[8px] text-black font-black uppercase text-center mt-2 tracking-tighter italic">Scan to Zap ⚡</p>
        </div>
    </div>
</div>

<!-- LISTA TRACCE UFFICIALI (Minimal & Functional) -->
<div class="mt-20">
    <h2 class="text-3xl font-black uppercase italic mb-8 border-b-2 border-indigo-600 pb-2 inline-block">Official Tracks</h2>
    
    <div class="grid grid-cols-1 gap-4">
        @forelse($tracks as $track)
            <div class="flex flex-col md:flex-row items-center justify-between p-6 bg-white rounded-3xl hover:bg-gray-50 transition border border-gray-100 group shadow-sm hover:shadow-md">
                
                <div class="flex items-center gap-6 mb-4 md:mb-0 w-full md:w-auto">
                    <!-- TASTO PLAY -->
                    <audio id="player-{{ $track->id }}" src="{{ Storage::url($track->file_path) }}"></audio>
                    <button onclick="document.getElementById('player-{{ $track->id }}').paused ? document.getElementById('player-{{ $track->id }}').play() : document.getElementById('player-{{ $track->id }}').pause()" 
                            class="w-14 h-14 bg-indigo-600 text-white rounded-full flex items-center justify-center hover:bg-black transition shadow-lg group-hover:scale-105 transform">
                        <svg class="w-6 h-6 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                    </button>

                    <div>
                        <p class="font-black uppercase text-xl text-gray-900 group-hover:text-indigo-600 transition tracking-tighter leading-none">{{ $track->title }}</p>
                        <p class="text-[10px] text-gray-400 font-mono italic uppercase tracking-widest mt-1">
                            {{ $track->genre }} <span class="mx-2 text-indigo-200">|</span> {{ $track->bpm }} BPM <span class="mx-2 text-indigo-200">|</span> {{ $track->version }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 w-full md:w-auto justify-end">
                    <!-- DOWNLOAD -->
                    <a href="{{ Storage::url($track->file_path) }}" download="{{ $track->title }}" 
                       class="flex-1 md:flex-none text-center bg-gray-100 text-gray-800 px-6 py-3 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition duration-300">
                        Download MP3
                    </a>
                </div>

            </div>
        @empty
            <div class="p-20 text-center border-2 border-dashed border-gray-100 rounded-[3rem]">
                <p class="text-gray-400 uppercase font-mono tracking-[0.3em] text-xs italic font-bold">Nessun master approvato per questo artista.</p>
            </div>
        @endforelse
    </div>
</div>

    </div>
    <script>
    async function sendZap(address) {
        if (typeof window.webln !== 'undefined') {
            await window.webln.enable();
            // Qui invochiamo il pagamento verso l'indirizzo dell'artista
            // Per ora mostriamo un alert, ma siamo pronti per l'invoice
            alert("Connessione a Lightning Network per: " + address);
        } else {
            alert("Installa un wallet Lightning (es. Alby) per inviare Satoshi istantaneamente!");
        }
    }
</script>

</x-app-layout>
