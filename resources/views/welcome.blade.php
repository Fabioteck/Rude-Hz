@extends('layouts.frontend')

@section('content')

    <!-- HERO SECTION -->
    <section class="h-[70vh] flex items-center justify-center text-center px-4">
        <div>
            <h1 class="text-6xl md:text-8xl font-black uppercase tracking-tighter mb-4 leading-none">
                The Harder <br> <span class="text-[#d9ff00]">Side of Sound</span>
            </h1>
            <p class="text-gray-400 text-lg mb-8">La community tekno nata dai social.</p>

        </div>
    </section>

    @php 
        $latestTrack = $tracks->first(); 
    @endphp

    <!-- SEZIONE NEWS -->
    <section id="news" class="py-24 bg-white border-t border-black/[0.03]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
                @if($latestNews)
                <div class="lg:col-span-10 lg:col-start-2">
                    <a href="{{ route('news.show', $latestNews->slug) }}" class="group block relative">
                        <div class="mt-8">
                            <div class="flex items-center gap-4 mb-3 text-gray-900">
                                <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">{{ $latestNews->created_at->format('d . m . Y') }}</span>
                                <div class="h-[1px] w-12 bg-indigo-200"></div>
                            </div>
                            <h3 class="text-4xl font-black text-gray-900 tracking-tighter leading-[0.9] group-hover:text-indigo-600 transition-colors mb-6">
                                {{ strtoupper($latestNews->title) }}
                            </h3>
                            
                            <div class="rounded-2xl overflow-hidden shadow-2xl">
                                <img src="{{ asset('storage/' . $latestNews->image_path) }}" 
                                    class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700 group-hover:scale-105">
                            </div>

                            <div class="mt-8 inline-flex items-center text-[10px] font-black uppercase tracking-widest text-gray-900 group-hover:gap-4 transition-all">
                                Read More <span class="ml-2">→</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </section>

    
    <!-- PLAYER AUDIO NASCOSTO -->
    <audio id="main-audio-player" src="{{ $latestTrack ? Storage::url($latestTrack->file_path) : '' }}" preload="auto"></audio>

    
    <!-- SEZIONE ARTISTI -->
    <section id="artisti" class="py-20 max-w-7xl mx-auto px-4">
        <div class="mb-12">
            <h2 class="text-4xl font-black uppercase italic tracking-tighter text-white">Top Artists</h2>
            <p class="text-[#d9ff00] uppercase tracking-widest text-xs mt-2 font-bold font-mono italic">I talenti della community</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @foreach($artists as $artist)
            <div class="group cursor-pointer">
                <div class="aspect-square bg-[#171717] rounded-2xl mb-4 overflow-hidden border border-white/5 group-hover:border-[#d9ff00]/50 transition-all duration-500">
                    {{-- FIX QUI: Parentesi e concatenazione sistemata --}}
                    <img src="{{ $artist->profile_image ? Storage::url($artist->profile_image) : 'https://picsum.photos' . $artist->id . '/500' }}" 
                        class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition duration-700" 
                        alt="{{ $artist->name }}">
                </div>
                <h4 class="font-bold text-xl uppercase tracking-tighter italic text-white">{{ $artist->name }}</h4>
                <p class="text-sm text-gray-500 font-mono italic uppercase">{{ $artist->style ?? 'Techno' }}</p>
            </div>
            @endforeach
        </div>
    </section>


   <!-- SEZIONE TRACCE -->
    <section id="tracks" class="py-20 border-t border-white/5">
        <div class="max-w-5xl mx-auto px-4">
            <h2 class="text-2xl font-black uppercase mb-10 italic tracking-tight">Latest Drops</h2>
            
            <div class="space-y-2">
                @forelse($tracks as $track)
                {{-- Aggiunto il link alla pagina show --}}
                <a href="{{ route('track.public.show', $track->slug) }}" class="flex items-center justify-between p-4 bg-[#111111] hover:bg-[#171717] rounded-xl border border-white/5 transition group">
                    <div class="flex items-center gap-4">
                        {{-- Il pulsante play mantiene la sua funzione JS --}}
                        <button onclick="event.preventDefault(); playTrack('{{ Storage::url($track->file_path) }}', '{{ $track->title }}', '{{ $track->artist->name }}')" 
                                class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center group-hover:bg-[#d9ff00] group-hover:text-black transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                        </button>
                        <div>
                            <h4 class="font-bold uppercase tracking-tight text-sm text-white">{{ $track->title }}</h4>
                            <p class="text-[10px] text-gray-500 uppercase italic font-medium">{{ $track->artist->name ?? 'Unknown' }}</p>
                        </div>
                    </div>
                    <div class="text-right flex items-center gap-4">
                        <span class="text-xs font-mono text-zinc-600 uppercase">{{ $track->genre }}</span>
                        {{-- Icona freccia per indicare il link --}}
                        <svg class="w-4 h-4 text-zinc-800 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </a>
                @empty
                <p class="text-zinc-700 italic text-center py-10">No tracks available yet.</p>
                @endforelse
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    function playTrack(url, title, artist) {
        const audio = document.getElementById('main-audio-player');
        audio.src = url;
        audio.play();
        // Qui potresti aggiungere una logica per un mini-player fisso in basso
        console.log('Playing:', title, 'by', artist);
    }
</script>
@endpush
