<div class="fixed bottom-0 left-0 w-full bg-red-600 text-black p-4 flex items-center justify-between border-t-4 border-black">
    @if($currentTrack)
        <div class="flex items-center gap-4">
            <img src="{{ asset('storage/' . $currentTrack->cover_path) }}" class="w-12 h-12 bg-black">
            <div>
                <p class="font-bold uppercase leading-none">{{ $currentTrack->title }}</p>
                <p class="text-sm opacity-80">{{ $currentTrack->artist->name }}</p>
            </div>
        </div>

        <audio controls class="h-10 accent-black">
            <source src="{{ asset('storage/' . $currentTrack->audio_path) }}" type="audio/mpeg">
            Il tuo browser non supporta l'audio.
        </audio>
    @else
        <p class="font-mono text-sm uppercase">Nessun brano in onda...</p>
    @endif
</div>
