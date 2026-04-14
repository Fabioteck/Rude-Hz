@extends('layouts.frontend')

@section('content')
<div class="py-32 bg-[#0a0a0a] min-h-screen">
    {{-- Container con padding proporzionale (px-8 su mobile, px-24 su desktop) --}}
    <div class="max-w-[1600px] mx-auto px-8 md:px-24">
        
        {{-- Header: Spazi calcolati in multipli di 4 --}}
        <header class="mb-32">
            <div class="flex items-center gap-6 mb-6">
                <div class="w-16 h-[1px] bg-[#d9ff00]"></div>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-white italic uppercase tracking-tighter leading-none">
                News <span class="text-[#d9ff00]">&</span> Factory
            </h1>
        </header>

        {{-- Griglia: Gap proporzionale (gap-12 = 3rem) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 lg:gap-20">
            @forelse($news as $article)
                <article class="group flex flex-col h-full bg-transparent">
                    
                    {{-- Image Wrapper: Altezza fissa tramite Aspect Ratio --}}
                    <div class="relative aspect-[16/10] w-full overflow-hidden rounded-sm mb-8 border border-white/10">
                        {{-- Overlay di profondità --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent z-10 opacity-60"></div>
                        
                        @if($article->image_path)
                            <img src="{{ asset('storage/' . $article->image_path) }}" 
                                 alt="{{ $article->title }}" 
                                 class="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-1000 ease-out">
                        @else
                            <div class="w-full h-full bg-neutral-900 flex items-center justify-center">
                                <span class="text-white/5 font-black text-3xl italic tracking-tighter">RUDE-HZ</span>
                            </div>
                        @endif

                        {{-- Data posizionata in modo millimetrico --}}
                        <div class="absolute top-0 right-0 z-20">
                            <span class="bg-[#d9ff00] text-black text-[9px] font-mono font-bold px-3 py-1 uppercase">
                                {{ $article->created_at->format('d.m.y') }}
                            </span>
                        </div>
                    </div>

                    {{-- Text Content: Allineamento e distanze fisse --}}
                    <div class="flex flex-col flex-grow">
                        <h2 class="text-xl font-bold text-white mb-6 leading-tight group-hover:text-[#d9ff00] transition-colors uppercase tracking-tight min-h-[3.5rem] line-clamp-2">
                            {{ $article->title }}
                        </h2>
                        
                        <p class="text-gray-500 text-sm leading-relaxed mb-8 line-clamp-3 font-medium">
                            {{ Str::limit(strip_tags($article->content), 140) }}
                        </p>

                        <div class="mt-auto pt-6 border-t border-white/5">
                            <a href="{{ route('news.show', $article->slug) }}" 
                               class="inline-flex items-center text-[#d9ff00] text-[10px] font-black uppercase tracking-[0.2em] group-hover:pl-4 transition-all duration-300">
                                <span class="mr-3">Dettagli</span> 
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-40 text-center border border-dashed border-white/10">
                    <p class="text-gray-600 font-mono text-xs uppercase tracking-widest">// Archivio News Non Rilevato //</p>
                </div>
            @endforelse
        </div>

        {{-- Paginazione Pulita --}}
        <div class="mt-40 pt-16 border-t border-white/5">
            {{ $news->links() }}
        </div>

    </div>
</div>
@endsection
