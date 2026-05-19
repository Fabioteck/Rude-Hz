<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl font-black text-black uppercase tracking-tighter italic">Amministrazione</h2>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Dashboard Generale</p>
            </div>
            <div class="text-[10px] font-black text-green-500 uppercase tracking-[0.2em] border border-green-100 px-4 py-2 rounded-lg bg-green-50/30 flex items-center">
                <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span> Stato Sistema: Operativo
            </div>
        </div>

        <!-- Cards Statistiche -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            @php 
                $stats = [
                    ['label' => 'Da Moderare', 'value' => \App\Models\Track::where('is_approved', 0)->count(), 'link' => route('admin.radio.archive'), 'color' => 'orange'],
                    ['label' => 'Artisti Iscritti', 'value' => \App\Models\Artist::count(), 'link' => route('admin.artists.index'), 'color' => 'black'],
                    ['label' => 'Contest Attivi', 'value' => \App\Models\Contest::count(), 'link' => route('admin.contests.index'), 'color' => 'black']
                ];
            @endphp

            @foreach($stats as $stat)
            <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm hover:shadow-md transition group">
                <p class="text-[11px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">{{ $stat['label'] }}</p>
                <div class="flex justify-between items-end">
                    <h3 class="text-5xl font-black text-black leading-none">{{ $stat['value'] }}</h3>
                    <a href="{{ $stat['link'] }}" class="text-[10px] font-black uppercase tracking-widest text-gray-300 group-hover:text-{{ $stat['color'] }}-500 transition">Dettagli →</a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Ultime Tracce -->
        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30 flex justify-between items-center">
                <h3 class="text-sm font-black text-black uppercase tracking-widest">Ultime Tracce in Revisione</h3>
                <a href="{{ route('admin.radio.archive') }}" class="text-[10px] font-black text-orange-500 uppercase underline decoration-2 underline-offset-4">Gestisci Archivio</a>
            </div>
            
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-black text-gray-300 uppercase tracking-[0.2em] border-b border-gray-50">
                        <th class="px-8 py-5">Titolo / Artista</th>
                        <th class="px-8 py-5 text-center">Stato</th>
                        <th class="px-8 py-5 text-right">Azioni</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach(\App\Models\Track::with('artist')->latest()->take(5)->get() as $track)
                    <tr class="group hover:bg-gray-50/50 transition">
                        <td class="px-8 py-6">
                            <div class="text-base font-black text-black uppercase leading-tight">{{ $track->title }}</div>
                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter mt-1">{{ $track->artist->name ?? 'Indipendente' }}</div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-tighter bg-orange-100 text-orange-600">Pending</span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <a href="{{ route('admin.radio.archive') }}" class="text-[11px] font-black text-black uppercase border-b-2 border-transparent hover:border-black transition pb-1">Modifica</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
