@extends('layouts.frontend')

@section('content')
<div class="py-24 bg-[#0a0a0a] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <div class="mb-16">
            <h1 class="text-5xl md:text-6xl font-black uppercase italic tracking-tighter text-white">Latest News</h1>
            <p class="text-[#d9ff00] uppercase tracking-widest text-sm mt-4 font-bold font-mono italic">Le ultime notizie</p>
        </div>

        <div class="space-y-12">
            @forelse($news as $article)
                <article class="group block grid md:grid-cols-2 gap-8 items-center bg-[#111111] p-6 rounded-3xl hover:bg-[#171717] transition border border-white/5">
                    
                    {{-- Image Wrapper --}}
                    <div class="relative w-full overflow-hidden rounded-2xl">
                        @if($article->image_path)
                            <img src="{{ asset('storage/' . $article->image_path) }}" 
                                 alt="{{ $article->title }}" 
                                 class="w-full aspect-video object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                        @else
                            <div class="w-full aspect-video bg-neutral-900 flex items-center justify-center">
                                <span class="text-white/5 font-black text-3xl italic tracking-tighter">RUDE-HZ</span>
                            </div>
                        @endif
                    </div>

                    {{-- Text Content --}}
                    <div class="flex flex-col">
                        <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">{{ $article->created_at->format('d . m . Y') }}</span>
                        
                        <h2 class="text-2xl font-black text-white uppercase tracking-tighter leading-[0.9] mt-3 mb-4 group-hover:text-[#d9ff00] transition-colors">
                            {{ $article->title }}
                        </h2>
                        
                        <p class="text-gray-400 text-sm leading-relaxed mb-6 line-clamp-3">
                            {{ Str::limit(strip_tags($article->content), 120) }}
                        </p>

                        <a href="{{ route('news.show', $article->slug) }}" 
                           class="inline-flex items-center text-[10px] font-black uppercase tracking-widest text-[#d9ff00] group-hover:gap-4 transition-all">
                            Read More <span class="ml-2">→</span>
                        </a>
                    </div>
                </article>
            @empty
                <p class="text-zinc-700 italic text-center py-20">// Archivio News Non Rilevato //</p>
            @endforelse
        </div>

        {{-- Paginazione --}}
        <div class="mt-16 pt-8 border-t border-white/5">
            {{ $news->links() }}
        </div>

    </div>
</div>
@endsection

