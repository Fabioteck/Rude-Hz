@extends('components.admin-layout')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8 font-mono">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black uppercase italic tracking-tighter text-black">Upload PDF Manuali (RAG)</h1>
            <p class="text-xs text-gray-500 uppercase tracking-widest mt-1">Caricamento documenti PDF, conversione in bozza e parsing automatico</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold uppercase rounded-md transition">
            ← Dashboard Admin
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 text-xs font-bold rounded-md">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 text-xs font-bold rounded-md">
            <ul class="list-disc pl-4 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white border border-gray-200 rounded-lg p-8 shadow-sm">
        <form action="{{ route('admin.manuals.upload.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-xs font-black text-gray-700 uppercase tracking-widest mb-2">File PDF (Max 25 MB)</label>
                <input type="file" name="pdf_file" accept=".pdf" required
                       class="block w-full text-xs text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-md file:border-0 file:text-xs file:font-black file:uppercase file:bg-black file:text-[#d9ff00] hover:file:bg-gray-800 cursor-pointer border border-gray-200 rounded-md p-2">
                <p class="text-[10px] text-gray-400 mt-1 uppercase">Il file verrà salvato in uno storage protetto e non accessibile pubblicamente.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-black text-gray-700 uppercase tracking-widest mb-2">Titolo (Opzionale)</label>
                    <input type="text" name="title" placeholder="Derivato dal nome file se vuoto"
                           class="w-full bg-gray-50 border border-gray-200 rounded-md text-xs text-black p-3 focus:border-black focus:ring-black">
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-700 uppercase tracking-widest mb-2">Categoria</label>
                    <input type="text" name="category" value="Tecnica" placeholder="es. Sintesi, Mix..."
                           class="w-full bg-gray-50 border border-gray-200 rounded-md text-xs text-black p-3 focus:border-black focus:ring-black">
                </div>
                <div>
                    <label class="block text-xs font-black text-gray-700 uppercase tracking-widest mb-2">Livello</label>
                    <select name="level" class="w-full bg-gray-50 border border-gray-200 rounded-md text-xs text-black p-3 focus:border-black focus:ring-black">
                        <option value="Base">Base</option>
                        <option value="Intermedio" selected>Intermedio</option>
                        <option value="Avanzato">Avanzato</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                <span class="text-[10px] text-gray-400 uppercase italic">Nota: La bozza verrà creata come non pubblicata.</span>
                <button type="submit" class="px-8 py-3 bg-black text-[#d9ff00] font-black uppercase text-xs tracking-widest rounded-md hover:bg-gray-800 transition">
                    Carica PDF ed Estrai Testo ⚡
                </button>
            </div>
        </form>
    </div>

    <!-- LISTA BOZZE MANUALI RECENTI -->
    <div class="mt-12">
        <h3 class="text-lg font-black uppercase tracking-tight text-black mb-4">Ultime Bozze Manuali Create da PDF</h3>
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-gray-500 uppercase tracking-widest">
                        <th class="py-3 px-4">Titolo</th>
                        <th class="py-3 px-4">Categoria</th>
                        <th class="py-3 px-4">Livello</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-right">Data</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse(\App\Models\Manual::latest()->take(5)->get() as $manual)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 font-bold text-black">{{ $manual->title }}</td>
                        <td class="py-3 px-4 uppercase text-gray-600">{{ $manual->category }}</td>
                        <td class="py-3 px-4 uppercase text-gray-600">{{ $manual->level }}</td>
                        <td class="py-3 px-4 text-center">
                            <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase {{ $manual->is_published ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                                {{ $manual->is_published ? 'Pubblicato' : 'Bozza' }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right text-gray-500">{{ $manual->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-400 italic">Nessun manuale presente.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
