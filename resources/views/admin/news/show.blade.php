<x-app-layout>
    <div class="py-20 bg-white min-h-screen">
        <article class="max-w-3xl mx-auto px-4">
            <header class="text-center mb-12">
                <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">News & Culture</span>
                <h1 class="text-4xl font-black text-gray-900 mt-4 mb-6 leading-tight">{{ $news->title }}</h1>
                <div class="text-[10px] text-gray-400 uppercase font-bold">{{ $news->created_at->format('d F Y') }} — Rude-Hz Staff</div>
            </header>

            @if($news->image)
            <div class="aspect-video rounded-xl overflow-hidden border border-gray-200 mb-12 shadow-2xl">
                <img src="{{ asset('storage/' . $news->image) }}" class="w-full h-full object-cover">
            </div>
            @endif

            <div class="prose prose-indigo max-w-none text-gray-700 leading-loose text-lg font-serif">
                {!! nl2br(e($news->content)) !!}
            </div>

            <footer class="mt-16 pt-8 border-t border-gray-100 flex justify-between items-center">
                <a href="{{ url('/') }}" class="text-[10px] font-black uppercase tracking-widest text-gray-400 hover:text-black">← Back to Home</a>
                <div class="flex gap-4">
                    <!-- Share Buttons opzionali -->
                </div>
            </footer>
        </article>
    </div>
</x-app-layout>
