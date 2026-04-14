@extends('layouts.frontend')

@section('content')
<div class="py-20 bg-[#0a0a0a] min-h-screen">
    <div class="max-w-4xl mx-auto px-4">
        
        {{-- Torna alla lista con freccia neon --}}
        <a href="{{ route('news.index') }}" class="group text-[#d9ff00] text-xs font-bold uppercase tracking-widest mb-10 inline-flex items-center hover:opacity-70 transition-all">
            <span class="mr-2 group-hover:-translate-x-1 transition-transform">&larr;</span> Archivio News
        </a>

        <article>
            {{-- Header: Data e Titolo --}}
            <header class="mb-12">
                <div class="text-[#d9ff00] font-mono text-sm mb-4 tracking-tighter">
                    // PUBBLICATO IL {{ $news->created_at->format('d.m.Y') }}
                </div>
                <h1 class="text-5xl md:text-7xl font-black text-white leading-none italic uppercase tracking-tighter shadow-sm">
                    {{ $news->title }}
                </h1>
            </header>

            {{-- Immagine di Copertina con bordo neon soffuso --}}
            @if($news->image_path)
                <div class="relative mb-16 group">
                    <div class="absolute -inset-1 bg-[#d9ff00]/20 rounded-3xl blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                    <img src="{{ asset('storage/' . $news->image_path) }}" 
                         class="relative w-full rounded-3xl border border-white/10 shadow-2xl object-cover max-h-[500px]">
                </div>
            @endif

            {{-- Contenuto della News --}}
            <div class="prose prose-invert prose-p:text-gray-300 prose-p:text-xl prose-p:leading-relaxed max-w-none mb-20">
                {!! nl2br(e($news->content)) !!}
            </div>

            <hr class="border-white/10 mb-20">

            
        </article>

    </div>
</div>
@endsection
