<x-admin-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Intestazione -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-black text-black uppercase tracking-tight italic">Gestione Redazione</h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            
            <!-- Colonna Sinistra: Tabella News (3/4) -->
            <div class="lg:col-span-3">
                <div class="flex justify-end mb-4">
                    <a href="{{ route('admin.news.create') }}" class="bg-black text-[#d9ff00] px-6 py-2 rounded-full text-[10px] font-black uppercase tracking-widest">+ Crea Nuova News</a>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-50 uppercase text-[9px] font-black text-gray-300 tracking-[0.2em]">
                                <th class="px-8 py-5">News</th>
                                <th class="px-8 py-5">Categoria</th>
                                <th class="px-8 py-5 text-right">Console</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($news as $article)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-8 py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden">
                                            <img src="{{ $article->image_path ? asset('storage/'.$article->image_path) : asset('images/default-news.jpg') }}" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <div class="text-sm font-black text-black uppercase">{{ $article->title }}</div>
                                            <div class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ $article->created_at->format('d/m/y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-4">
                                    <span class="text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-tighter bg-gray-100 text-gray-600">
                                        {{ $article->category->name ?? 'Senza Categoria' }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-right">
                                    <div class="flex justify-end items-center space-x-2">
                                        <a href="{{ route('admin.news.edit', $article) }}" class="flex items-center text-[10px] font-black uppercase bg-orange-100 text-orange-600 px-3 py-1.5 rounded hover:bg-orange-200 transition-colors">
                                            Edit ✍️
                                        </a>
                                        <form action="{{ route('admin.news.destroy', $article) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex items-center text-[10px] font-black uppercase bg-red-100 text-red-600 px-3 py-1.5 rounded hover:bg-red-200 transition-colors">
                                                Del 🗑️
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Colonna Destra: Categorie (1/4) -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-black text-black uppercase tracking-widest mb-4">Categorie</h3>
                    
                    <form action="{{ route('admin.news-categories.store') }}" method="POST" class="mb-6">
                        @csrf
                        <div class="flex gap-2">
                            <input type="text" name="name" placeholder="Nuova..." class="flex-1 text-[10px] uppercase font-bold border-gray-100 rounded bg-gray-50 p-2">
                            <button type="submit" class="bg-black text-[#d9ff00] px-4 py-2 rounded text-[10px] font-black uppercase">+</button>
                        </div>
                    </form>

                    <div class="space-y-2">
                        @foreach($categories as $category)
                            <div class="flex justify-between items-center bg-gray-50 p-2 rounded text-[10px] font-bold uppercase text-gray-500">
                                {{ $category->name }}
                                <form action="{{ route('admin.news-categories.destroy', $category) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 font-black">🗑️</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
