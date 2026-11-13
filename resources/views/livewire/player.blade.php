<div class="fixed bottom-0 left-0 w-full bg-[#0a0a0a]/95 text-white border-t border-white/10 backdrop-blur-md px-6 py-3 z-50 shadow-2xl font-mono">
    <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
        @if($currentTrack)
            <div class="flex items-center gap-4 truncate">
                @if($currentTrack->cover_path)
                    <img src="{{ asset('storage/' . $currentTrack->cover_path) }}" class="w-10 h-10 object-cover rounded-sm border border-white/10 shrink-0" alt="{{ $currentTrack->title }}" onerror="this.src='{{ \App\Services\ImageOptimizerService::placeholderUrl() }}'">
                @else
                    <div class="w-10 h-10 bg-zinc-800 border border-white/10 rounded-sm flex items-center justify-center text-[#d9ff00] font-bold shrink-0">⚡</div>
                @endif
                <div class="truncate">
                    <p class="font-bold text-xs uppercase tracking-tight text-white truncate">{{ $currentTrack->title }}</p>
                    <p class="text-[10px] text-[#d9ff00] uppercase tracking-widest truncate mt-0.5">{{ $currentTrack->artist->name ?? 'Unknown Artist' }}</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <audio controls autoplay class="h-9 accent-[#d9ff00]">
                    <source src="{{ asset('storage/' . $currentTrack->audio_path) }}" type="audio/mpeg">
                    Il tuo browser non supporta l'audio.
                </audio>
            </div>
        @else
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-zinc-800 border border-white/10 rounded-sm flex items-center justify-center text-[#d9ff00] font-bold shrink-0">⚡</div>
                <div>
                    <p class="font-bold text-xs uppercase tracking-tight text-white">Nessun brano in onda</p>
                    <p class="text-[10px] text-[#d9ff00] uppercase tracking-widest mt-0.5">Rude-Hz Master Queue</p>
                </div>
            </div>
            <p class="text-[10px] text-zinc-500 uppercase tracking-widest">Seleziona una traccia</p>
        @endif
    </div>
</div>
