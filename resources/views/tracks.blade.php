@extends('layouts.frontend')

@section('content')
<section class="py-24 bg-[#0a0a0a] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="mb-16">
            <h1 class="text-5xl md:text-6xl font-black uppercase italic tracking-tighter text-white">Latest Drops</h1>
            <p class="text-[#d9ff00] uppercase tracking-widest text-sm mt-4 font-bold font-mono italic">Le ultime tracce caricate</p>
        </div>

        <div class="space-y-6">
            @forelse($tracks as $track)
            <div class="flex items-center justify-between p-6 bg-[#111111] hover:bg-[#171717] rounded-xl border border-white/5 transition group">
                <div class="flex items-center gap-6">
                    <button onclick="playTrack('{{ route('tracks.stream', $track->id) }}', '{{ $track->title }}', '{{ $track->artist->name }}')" 
                            class="w-12 h-12 rounded-full bg-white/5 flex items-center justify-center group-hover:bg-[#d9ff00] group-hover:text-black transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                    </button>
                    <div>
                        <h4 class="font-bold uppercase tracking-tight text-lg text-white">{{ $track->title }}</h4>
                        <p class="text-xs text-gray-500 uppercase italic font-medium">{{ $track->artist->name ?? 'Unknown' }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="text-xs font-mono text-zinc-600 uppercase">{{ $track->genre }}</span>
                </div>
            </div>
            @empty
            <p class="text-zinc-700 italic text-center py-20">No tracks available yet.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Player Globale (nascosto inizialmente) -->
<audio id="main-audio-player" preload="auto"></audio>
@endsection

@push('scripts')
@endpush
