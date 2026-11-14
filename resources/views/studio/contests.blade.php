<x-studio-layout>
    <div class="space-y-12 text-white pb-24">
        <div class="border-b border-white/10 pb-6 flex justify-between items-end">
            <div>
                <h1 class="text-3xl md:text-4xl font-black uppercase italic tracking-tighter">Studio Contest</h1>
                <p class="text-xs font-mono text-[#E6FF00] uppercase tracking-widest mt-1">Partecipa ai contest ufficiali con le tue tracce</p>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-[#E6FF00] text-black text-xs font-black uppercase rounded-lg shadow-lg font-mono">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-red-500 text-white text-xs font-black uppercase rounded-lg shadow-lg font-mono">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 gap-12">
            @forelse($contests as $contest)
                <div class="bg-[#111] border border-gray-800 rounded-2xl overflow-hidden p-8 space-y-6 shadow-xl">
                    <div class="flex flex-col md:flex-row gap-8 items-start">
                        @if($contest->image_path)
                            <div class="w-full md:w-1/3 aspect-video rounded-xl overflow-hidden border border-white/10 shrink-0">
                                <img src="{{ asset('storage/' . $contest->image_path) }}" alt="{{ $contest->title }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                        <div class="space-y-4 flex-1">
                            <div class="inline-block px-3 py-1 bg-[#E6FF00]/10 border border-[#E6FF00]/30 rounded text-[10px] font-mono font-bold text-[#E6FF00] uppercase">
                                Contest Attivo
                            </div>
                            <h2 class="text-2xl md:text-3xl font-black uppercase italic tracking-tight">{{ $contest->title }}</h2>
                            <p class="text-zinc-400 text-sm font-mono leading-relaxed">{!! nl2br(e($contest->description)) !!}</p>
                        </div>
                    </div>

                    <!-- BOX PARTECIPAZIONE -->
                    <div class="border-t border-gray-800 pt-6 mt-6">
                        <h3 class="text-xs font-mono font-black uppercase text-[#E6FF00] tracking-widest mb-4">Invia la tua traccia a questo Contest</h3>
                        
                        <form action="{{ route('contests.join', $contest->id) }}" method="POST" class="space-y-6">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-mono text-zinc-400 uppercase tracking-widest mb-2">Seleziona traccia dal tuo Studio</label>
                                <select name="track_id" required class="w-full bg-black border border-gray-800 text-white p-4 rounded-xl text-xs font-mono focus:border-[#E6FF00] focus:ring-0">
                                    @forelse($userTracks as $track)
                                        <option value="{{ $track->id }}">{{ $track->title }} ({{ $track->genre ?? 'TEKNO' }})</option>
                                    @empty
                                        <option disabled>Nessuna traccia disponibile. Carica prima una traccia nello Studio.</option>
                                    @endforelse
                                </select>
                            </div>

                            <!-- LIBERATORIA LEGALE COMMUNITY -->
                            <div class="flex items-start gap-3 p-4 bg-black/50 border border-white/10 rounded-xl">
                                <input type="checkbox" id="legal_consent_{{ $contest->id }}" name="legal_consent" required class="mt-1 w-5 h-5 accent-[#E6FF00] bg-black border-gray-700 rounded cursor-pointer">
                                <label for="legal_consent_{{ $contest->id }}" class="text-xs font-mono text-zinc-300 cursor-pointer leading-relaxed">
                                    Accetto la <span class="text-[#E6FF00] font-bold">Liberatoria Legale Community</span> e confermo che la traccia inviata è opera originale, libera da diritti di terzi e conforme al regolamento ufficiale del contest.
                                    @if($contest->rules_pdf)
                                        <a href="{{ asset('storage/' . $contest->rules_pdf) }}" target="_blank" class="text-[#E6FF00] underline ml-1 hover:text-white">Leggi Regolamento PDF</a>
                                    @endif
                                </label>
                            </div>

                            @if($userTracks->count() > 0)
                                <button type="submit" class="px-8 py-4 bg-[#E6FF00] text-black font-black font-mono uppercase italic tracking-wider text-xs rounded-xl hover:bg-white transition-all shadow-[0_0_20px_rgba(230,255,0,0.3)]">
                                    ⚡ Invia Candidatura al Contest
                                </button>
                            @else
                                <a href="{{ route('user.tracks.index') }}" class="inline-block px-6 py-3 bg-zinc-900 border border-[#E6FF00]/40 text-[#E6FF00] font-mono font-bold uppercase text-xs rounded-xl hover:bg-[#E6FF00] hover:text-black transition-all">
                                    Carica una traccia in "Le Mie Tracce" →
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-16 text-center bg-[#111] border border-gray-800 rounded-2xl">
                    <p class="text-zinc-500 font-mono uppercase text-xs italic">Nessun contest attivo al momento.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-studio-layout>
