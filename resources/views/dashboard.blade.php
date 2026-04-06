@vite(['resources/css/app.css', 'resources/js/app.js'])


<div class="py-12 bg-gray-100 dark:bg-[#0a0a0a]">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        
        <!-- MESSAGGI DI STATO -->
        @if(session('success'))
            <div class="p-4 bg-[#d9ff00]/10 border border-[#d9ff00] text-[#d9ff00] rounded-xl font-bold text-center uppercase tracking-widest text-xs">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- COLONNA SINISTRA: FORM UPLOAD -->
            <div class="lg:col-span-2 bg-white dark:bg-[#111111] p-8 rounded-[2rem] border border-white/5 shadow-2xl">
                <header class="mb-8 border-b border-white/5 pb-4">
                    <h3 class="text-2xl font-black uppercase italic text-[#d9ff00] tracking-tighter">Upload Master</h3>
                </header>
<form action="{{ route('track.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    <input type="hidden" name="artist_id" value="{{ auth()->user()->artist->id }}">

                    <div class="bg-black/40 p-6 rounded-2xl border-2 border-dashed border-white/10 hover:border-[#d9ff00]/50 transition">
                        <label class="block text-xs font-black uppercase text-gray-500 mb-4">Master Audio (MP3/WAV)</label>
                        <input type="file" name="audio_file" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-xs file:font-black file:bg-[#d9ff00] file:text-black hover:file:bg-white transition cursor-pointer" required />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="title" placeholder="Titolo Traccia" class="bg-black border-white/10 rounded-xl p-4 text-white focus:border-[#d9ff00] focus:ring-0" required>
                        <input type="text" name="version" placeholder="Versione (es. Original Mix)" class="bg-black border-white/10 rounded-xl p-4 text-white focus:border-[#d9ff00] focus:ring-0">
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <input type="number" name="bpm" placeholder="BPM" class="bg-black border-white/10 rounded-xl p-4 text-white focus:border-[#d9ff00] focus:ring-0">
                        <select name="genre" class="bg-black border-white/10 rounded-xl p-4 text-white focus:border-[#d9ff00] focus:ring-0">
                            <option value="Hard Techno">Hard Techno</option>
                            <option value="Acid">Acid</option>
                            <option value="Industrial">Industrial</option>
                        </select>
                        <input type="number" name="release_year" value="2026" class="bg-black border-white/10 rounded-xl p-4 text-white focus:border-[#d9ff00] focus:ring-0">
                    </div>

                    <button type="submit" class="w-full bg-[#d9ff00] hover:bg-white text-black font-black uppercase py-5 rounded-2xl tracking-[0.3em] transition-all shadow-lg shadow-[#d9ff00]/10">
                        Invia alla Moderazione
                    </button>
                </form>
            </div>

            <!-- COLONNA DESTRA: LISTA TRACCE CARICATE -->
            <div class="bg-white dark:bg-[#111111] p-8 rounded-[2rem] border border-white/5">
                <h4 class="text-lg font-black uppercase mb-6 italic border-b border-white/5 pb-2 text-white">Le tue tracce</h4>
                <div class="space-y-4">
                    @forelse(auth()->user()->artist->tracks as $track)
                        <div class="p-4 bg-black/40 rounded-xl border border-white/5 flex justify-between items-center">
                            <div>
                                <p class="font-bold text-sm text-white">{{ $track->title }}</p>
                                <span class="text-[10px] uppercase font-mono {{ $track->is_approved ? 'text-green-500' : 'text-orange-500' }}">
                                    {{ $track->is_approved ? '● Approvata' : '● In attesa' }}
                                </span>
                            </div>
                            @if($track->qr_code_path)
                                <img src="{{ Storage::url($track->qr_code_path) }}" class="w-10 h-10 bg-white p-1 rounded-md">
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-600 text-xs italic">Nessuna traccia caricata ancora.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
