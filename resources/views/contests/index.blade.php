@extends('layouts.frontend')

@section('content')
<div class="py-12 bg-[#0a0a0a] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-black text-[#d9ff00] mb-12 uppercase italic tracking-tighter">
            Contest Attivi
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($contests as $contest)
                <div class="bg-[#111] border border-white/10 rounded-2xl overflow-hidden hover:border-[#d9ff00]/50 transition duration-300">
                    @if($contest->image_path)
                        <img src="{{ asset('storage/' . $contest->image_path) }}" class="w-full h-56 object-cover opacity-80 hover:opacity-100 transition">
                    @endif

                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-white mb-3">{{ $contest->title }}</h2>
                        <div class="text-gray-400 text-sm mb-6 line-clamp-3">
                            {{ strip_tags($contest->description) }}
                        </div>

                        <div class="flex justify-between items-center border-t border-white/5 pt-4">
                            <span class="text-[10px] font-bold text-[#d9ff00] uppercase tracking-widest">Entry Open</span>
                            <a href="{{ route('contests.show', $contest->slug) }}" class="text-white text-xs font-bold uppercase tracking-widest bg-white/10 px-4 py-2 rounded-full hover:bg-[#d9ff00] hover:text-black transition">
                                Leggi Tutto
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 italic">Nessun contest attivo al momento.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
