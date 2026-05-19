<x-admin-layout>
    <div class="p-8">
        <header class="mb-10 border-b border-lime-900/30 pb-6">
            <h1 class="text-4xl font-black text-lime-400 tracking-tighter uppercase italic">Console di Comando</h1>
            <p class="text-gray-500 font-mono text-xs mt-2">SYSTEM_LOG: Monitoring active on Raspberry Pi 4</p>
        </header>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-gray-950 border border-lime-900/20 p-6">
                <span class="text-gray-500 uppercase text-[10px] tracking-widest font-bold">Tracce in Coda</span>
                <div class="text-3xl font-bold text-white mt-1">{{ \App\Models\Track::where('is_approved', false)->count() }}</div>
            </div>
            <div class="bg-gray-950 border border-lime-900/20 p-6">
                <span class="text-gray-500 uppercase text-[10px] tracking-widest font-bold">Artisti Totali</span>
                <div class="text-3xl font-bold text-white mt-1">{{ \App\Models\Artist::count() }}</div>
            </div>
            <div class="bg-gray-950 border border-lime-900/20 p-6 border-l-4 border-l-lime-500">
                <span class="text-gray-500 uppercase text-[10px] tracking-widest font-bold">News Pubblicate</span>
                <div class="text-3xl font-bold text-white mt-1">{{ \App\Models\News::count() }}</div>
            </div>
        </div>

        <!-- Azioni Rapide -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-gray-950 border border-lime-900/10 p-6 rounded-sm">
                <h3 class="text-lime-400 font-bold uppercase text-sm mb-4 italic underline decoration-lime-900">Ultimi Upload da Moderare</h3>
                <p class="text-gray-600 text-xs italic">Nessuna traccia in coda al momento.</p>
                <a href="{{ route('admin.radio.archive') }}" class="inline-block mt-6 text-[10px] uppercase font-bold text-lime-500 hover:tracking-widest transition-all">Accedi alla Moderazione &rarr;</a>
            </div>
        </div>
    </div>
</x-admin-layout>
