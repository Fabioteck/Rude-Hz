@extends('layouts.frontend')

@section('content')
<!-- SFONDO NEURONALE -->
<canvas id="network-canvas" class="fixed inset-0 w-full h-full z-0 opacity-30 pointer-events-none"></canvas>

<div class="relative z-10 w-full bg-zinc-950 min-h-screen text-white pt-16 pb-36 font-mono">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <!-- HEADER -->
        <div class="mb-8 border-b border-white/10 pb-6 flex items-center justify-between">
            <div>
                <a href="{{ route('user.console') }}" class="text-xs text-zinc-500 hover:text-[#d9ff00] uppercase tracking-widest transition mb-2 inline-block">← Console</a>
                <h1 class="text-3xl md:text-5xl font-black uppercase italic tracking-tighter text-white">
                    Rude-Hz Assistant (Lama)
                </h1>
                <p class="text-xs text-[#d9ff00] uppercase tracking-widest mt-1 font-bold italic">
                    [AI-01] Supporto tecnico underground per produzione e sound design
                </p>
            </div>
            <span class="ds-badge px-3 py-1 text-[10px]">Neural Active</span>
        </div>

        <!-- CHAT INTERFACE CONTAINER -->
        <div class="ds-card p-6 md:p-8 backdrop-blur-md space-y-6">
            
            <!-- MESSAGGI CHAT CONTAINER -->
            <div id="chat-messages" class="space-y-4 min-h-[300px] max-h-[500px] overflow-y-auto p-4 bg-zinc-900/60 border border-white/5 rounded-md text-xs">
                
                <!-- WELCOME MESSAGE FROM LAMA -->
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-sm bg-[#d9ff00] text-black font-black flex items-center justify-center shrink-0">
                        AI
                    </div>
                    <div class="p-4 bg-zinc-900 border border-white/10 rounded-md max-w-[85%] text-zinc-200 leading-relaxed">
                        Ciao! Sono <strong>Lama</strong>, il tuo assistente tecnico per la musica elettronica underground. Chiedimi pure di sintesi sottrattiva, campionatori, drum machine, mix o sound design.
                    </div>
                </div>

                @if(session('user_message') && session('reply'))
                    <!-- UTENTE -->
                    <div class="flex items-start gap-3 justify-end">
                        <div class="p-4 bg-zinc-800 border border-white/10 rounded-md max-w-[85%] text-white leading-relaxed">
                            {{ session('user_message') }}
                        </div>
                        <div class="w-8 h-8 rounded-sm bg-zinc-700 text-white font-black flex items-center justify-center shrink-0">
                            TU
                        </div>
                    </div>
                    <!-- LAMA -->
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-sm bg-[#d9ff00] text-black font-black flex items-center justify-center shrink-0">
                            AI
                        </div>
                        <div class="p-4 bg-zinc-900 border border-white/10 rounded-md max-w-[85%] text-zinc-200 leading-relaxed">
                            {!! nl2br(e(session('reply'))) !!}
                        </div>
                    </div>
                @endif
            </div>

            <!-- FORM INVIO MESSAGGIO -->
            <form id="chat-form" action="{{ route('user.assistant.send') }}" method="POST" class="flex gap-3">
                @csrf
                <input type="text" 
                       name="message" 
                       id="message-input"
                       required
                       placeholder="Es. Spiega la sintesi subtractiva..." 
                       class="flex-1 bg-[#0a0a0a] border border-white/10 rounded-md text-xs text-white p-3 font-mono focus:border-[#d9ff00] focus:ring-[#d9ff00]">
                <button type="submit" class="px-6 py-3 ds-btn text-xs tracking-widest shrink-0">
                    Invia ⚡
                </button>
            </form>

        </div>

    </div>
</div>

<script>
document.getElementById('chat-form').addEventListener('submit', function(e) {
    const input = document.getElementById('message-input');
    if (!input.value.trim()) {
        e.preventDefault();
    }
});
</script>
@endsection
