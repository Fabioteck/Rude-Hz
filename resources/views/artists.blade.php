@extends('layouts.frontend')

@section('content')
<section class="py-24 bg-[#0a0a0a] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="mb-16">
            <h1 class="text-5xl md:text-6xl font-black uppercase italic tracking-tighter text-white">Artists</h1>
            <p class="text-[#d9ff00] uppercase tracking-widest text-sm mt-4 font-bold font-mono italic">I talenti della community</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @foreach($artists as $artist)
            <div class="group cursor-pointer">
                <a href="{{ route('artists.show', $artist->slug) }}">
                    <div class="aspect-square bg-[#171717] rounded-2xl mb-4 overflow-hidden border border-white/5 group-hover:border-[#d9ff00]/50 transition-all duration-500">
                        <img src="{{ $artist->profile_image ? Storage::url($artist->profile_image) : 'https://picsum.photos/500/500' }}" 
                            class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition duration-700" 
                            alt="{{ $artist->name }}">
                    </div>
                    <h4 class="font-bold text-xl uppercase tracking-tighter italic text-white group-hover:text-[#d9ff00] transition">{{ $artist->name }}</h4>
                    <p class="text-sm text-gray-500 font-mono italic uppercase">{{ $artist->style ?? 'Techno' }}</p>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
