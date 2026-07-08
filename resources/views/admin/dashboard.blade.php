<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-6">
            <div>
                <h2 class="text-3xl font-black text-black uppercase tracking-tighter italic">Amministrazione</h2>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">Dashboard Generale</p>
            </div>
            
            <!-- Monitoraggio Sistema -->
            <div class="flex items-center gap-6 bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-gray-800">OS:</span>
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                </div>
                
                <div class="flex items-center gap-2">
                    <div class="relative w-10 h-10">
                        <svg class="w-full h-full" viewBox="0 0 36 36"><path class="text-gray-200" fill="none" stroke-width="3" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/><path id="cpu-temp-circle" class="text-green-500" fill="none" stroke-width="3" stroke-dasharray="0, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/></svg>
                        <span class="absolute inset-0 flex items-center justify-center text-[8px] font-black" id="cpu-temp">--</span>
                    </div>
                    <span class="text-[9px] font-bold text-gray-400 uppercase">Temp</span>
                </div>

                <div class="flex items-center gap-2">
                    <div class="relative w-10 h-10">
                        <svg class="w-full h-full" viewBox="0 0 36 36"><path class="text-gray-200" fill="none" stroke-width="3" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/><path id="cpu-load-circle" class="text-blue-500" fill="none" stroke-width="3" stroke-dasharray="0, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/></svg>
                        <span class="absolute inset-0 flex items-center justify-center text-[8px] font-black" id="cpu-load">--</span>
                    </div>
                    <span class="text-[9px] font-bold text-gray-400 uppercase">Load</span>
                </div>
            </div>
        </div>

        <!-- Cards Statistiche -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-12">
            @php 
                $stats = [
                    ['label' => 'Da Moderare', 'value' => \App\Models\Track::where('is_approved', 0)->count(), 'link' => route('admin.radio.archive'), 'color' => 'orange'],
                    ['label' => 'Artisti', 'value' => \App\Models\Artist::count(), 'link' => route('admin.artists.index'), 'color' => 'black'],
                    ['label' => 'Contest', 'value' => \App\Models\Contest::count(), 'link' => route('admin.contests.index'), 'color' => 'black'],
                    ['label' => 'Tracce Tot.', 'value' => \App\Models\Track::count(), 'link' => route('admin.radio.archive'), 'color' => 'black'],
                    ['label' => 'News', 'value' => \App\Models\News::count(), 'link' => route('admin.news.index'), 'color' => 'black'],
                    ['label' => 'Playlists', 'value' => \App\Models\Playlist::count(), 'link' => '#', 'color' => 'black']
                ];
            @endphp

            @foreach($stats as $stat)
            <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm hover:shadow-md transition">
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">{{ $stat['label'] }}</p>
                <div class="flex justify-between items-end">
                    <h3 class="text-3xl font-black text-black leading-none">{{ $stat['value'] }}</h3>
                    @if($stat['link'] !== '#')
                        <a href="{{ $stat['link'] }}" class="text-[8px] font-black uppercase tracking-widest text-gray-300 hover:text-black">→</a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script>
        function fetchStats() {
            fetch('{{ route("admin.stats") }}')
                .then(response => response.json())
                .then(data => {
                    const temp = parseFloat(data.temp);
                    const load = parseFloat(data.load);
                    
                    document.getElementById('cpu-temp').textContent = data.temp;
                    document.getElementById('cpu-temp-circle').setAttribute('stroke-dasharray', `${temp}, 100`);
                    
                    document.getElementById('cpu-load').textContent = data.load;
                    document.getElementById('cpu-load-circle').setAttribute('stroke-dasharray', `${load}, 100`);
                })
                .catch(err => console.error('Error:', err));
        }
        setInterval(fetchStats, 5000);
        fetchStats();
    </script>
</x-admin-layout>
