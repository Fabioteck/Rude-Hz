@extends('layouts.frontend')

@section('title', 'Supporta Rude-Hz - Community & Independence')
@section('meta_description', 'Sostieni il progetto indipendente Rude-Hz. Scopri come contribuire alla crescita della community underground senza pubblicità.')

@section('content')
<!-- SFONDO NEURONALE -->
<canvas id="network-canvas" class="fixed inset-0 w-full h-full z-0 opacity-30 pointer-events-none"></canvas>

<div class="relative z-10 w-full bg-zinc-950 min-h-screen text-white pt-16 pb-36 font-mono">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        
        <!-- INTESTAZIONE -->
        <div class="mb-12 border-b border-white/10 pb-8 text-center">
            <span class="ds-badge px-3 py-1 text-[10px] mb-4 inline-block">Community & Independence</span>
            <h1 class="text-4xl md:text-6xl font-black uppercase italic tracking-tighter text-white">
                {{ $page->title ?? __('messages.support.title') }}
            </h1>
            <p class="text-xs text-[#d9ff00] uppercase tracking-widest mt-3 font-bold italic">
                {{ $page->subtitle ?? '[SUPPORT-01] ' . __('messages.support.subtitle') }}
            </p>
        </div>

        <!-- CONTENUTO PRINCIPALE (BENTO LAYOUT) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            
            <!-- SPIEGAZIONE COMMUNITY -->
            <div class="ds-card p-8 backdrop-blur-md space-y-4">
                <span class="text-[10px] font-mono text-[#d9ff00] uppercase tracking-widest font-bold">La Nostra Missione</span>
                <h2 class="text-2xl font-black uppercase italic tracking-tighter text-white">
                    {{ __('messages.support.mission_title') }}
                </h2>
                <p class="text-xs text-zinc-300 leading-relaxed italic">
                    {{ __('messages.support.mission_text') }}
                </p>
            </div>

            <!-- COME FUNZIONA -->
            <div class="ds-card p-8 backdrop-blur-md space-y-4">
                <span class="text-[10px] font-mono text-[#d9ff00] uppercase tracking-widest font-bold">Trasparenza & Etica</span>
                <h2 class="text-2xl font-black uppercase italic tracking-tighter text-white">
                    {{ __('messages.support.how_title') }}
                </h2>
                <ul class="text-xs text-zinc-300 space-y-2 font-mono">
                    <li class="flex items-center gap-2"><span>⚡</span> {{ __('messages.support.bullet_1') }}</li>
                    <li class="flex items-center gap-2"><span>⚡</span> {{ __('messages.support.bullet_2') }}</li>
                    <li class="flex items-center gap-2"><span>⚡</span> {{ __('messages.support.bullet_3') }}</li>
                </ul>
            </div>

        </div>

        <!-- OBIETTIVI -->
        <div class="ds-card p-8 md:p-12 backdrop-blur-md mb-12 space-y-6">
            <div class="border-b border-white/10 pb-4">
                <span class="text-[10px] font-mono text-[#d9ff00] uppercase tracking-widest font-bold">Allocazione Risorse</span>
                <h2 class="text-2xl font-black uppercase italic tracking-tighter text-white mt-1">
                    {{ __('messages.support.goals_title') }}
                </h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 font-mono text-xs">
                <div class="p-5 bg-zinc-900/60 border border-white/5 rounded-md space-y-2">
                    <div class="text-[#d9ff00] font-bold uppercase">{{ __('messages.support.goal_1_title') }}</div>
                    <p class="text-zinc-400 italic leading-relaxed">{{ __('messages.support.goal_1_text') }}</p>
                </div>
                <div class="p-5 bg-zinc-900/60 border border-white/5 rounded-md space-y-2">
                    <div class="text-[#d9ff00] font-bold uppercase">{{ __('messages.support.goal_2_title') }}</div>
                    <p class="text-zinc-400 italic leading-relaxed">{{ __('messages.support.goal_2_text') }}</p>
                </div>
                <div class="p-5 bg-zinc-900/60 border border-white/5 rounded-md space-y-2">
                    <div class="text-[#d9ff00] font-bold uppercase">{{ __('messages.support.goal_3_title') }}</div>
                    <p class="text-zinc-400 italic leading-relaxed">{{ __('messages.support.goal_3_text') }}</p>
                </div>
            </div>
        </div>

        <!-- SUPPORTER (STATO VUOTO CURATO) -->
        <div class="ds-card p-8 md:p-10 backdrop-blur-md mb-12 text-center space-y-4">
            <span class="text-[10px] font-mono text-[#d9ff00] uppercase tracking-widest font-bold">Hall of Fame</span>
            <h3 class="text-xl font-black uppercase italic tracking-tighter text-white">{{ __('messages.support.supporters_title') }}</h3>
            <div class="p-6 bg-zinc-900/40 border border-white/5 rounded-md max-w-md mx-auto">
                <p class="text-xs text-zinc-400 font-mono italic uppercase tracking-wider">
                    {{ __('messages.empty.no_supporters') }}
                </p>
            </div>
        </div>

        <!-- SEZIONE SUPPORTO & DONAZIONE CON TAGLI RAPIDI PAYPAL -->
        <div class="ds-card p-8 md:p-12 backdrop-blur-md text-center space-y-6">
            <h2 class="text-3xl font-black uppercase italic tracking-tighter text-white">
                {{ __('messages.support.call_title') }}
            </h2>
            <p class="text-xs text-zinc-400 uppercase tracking-widest max-w-xl mx-auto italic">
                {{ __('messages.support.call_text') }}
            </p>

            @php
                $paypalUrl = env('PAYPAL_DONATE_URL', env('SUPPORT_PAYPAL_URL', 'https://paypal.me'));
                $baseUrl = rtrim($paypalUrl, '/');
            @endphp

            @if($paypalUrl)
            <!-- TAGLI RAPIDI PAYPAL -->
            <div class="pt-2 pb-4">
                <span class="text-[10px] font-mono text-[#E6FF00] uppercase tracking-widest block mb-4">Scegli il taglio di supporto rapido</span>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 max-w-lg mx-auto">
                    <a href="{{ $baseUrl }}/5EUR" target="_blank" class="p-4 bg-zinc-900 border border-white/10 hover:border-[#00FF66] hover:text-[#00FF66] rounded-md font-mono text-xs font-black uppercase transition-all shadow-sm">
                        5€ <span class="block text-[9px] text-zinc-500 font-normal mt-1">Caffè Underground</span>
                    </a>
                    <a href="{{ $baseUrl }}/10EUR" target="_blank" class="p-4 bg-zinc-900 border border-white/10 hover:border-[#00FF66] hover:text-[#00FF66] rounded-md font-mono text-xs font-black uppercase transition-all shadow-sm">
                        10€ <span class="block text-[9px] text-zinc-500 font-normal mt-1">Hosting & Server</span>
                    </a>
                    <a href="{{ $baseUrl }}/20EUR" target="_blank" class="p-4 bg-zinc-900 border border-white/10 hover:border-[#00FF66] hover:text-[#00FF66] rounded-md font-mono text-xs font-black uppercase transition-all shadow-sm">
                        20€ <span class="block text-[9px] text-zinc-500 font-normal mt-1">Sound System</span>
                    </a>
                    <a href="{{ $paypalUrl }}" target="_blank" class="p-4 bg-[#E6FF00] text-black hover:bg-white rounded-md font-mono text-xs font-black uppercase transition-all shadow-[0_0_15px_rgba(230,255,0,0.3)] flex flex-col items-center justify-center">
                        Libero <span class="block text-[9px] text-zinc-800 font-bold mt-1">Custom ⚡</span>
                    </a>
                </div>
            </div>
            @endif

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                @if(env('SUPPORT_EMAIL'))
                    <a href="mailto:{{ env('SUPPORT_EMAIL') }}" class="px-8 py-4 bg-zinc-900 border border-white/20 text-white hover:text-[#E6FF00] hover:border-[#E6FF00] font-bold uppercase text-xs tracking-widest rounded-md transition">
                        {{ __('messages.buttons.contact_email') }}
                    </a>
                @endif
            </div>

            @if(env('SUPPORT_IBAN'))
                <div class="mt-8 pt-8 border-t border-white/5 text-left max-w-md mx-auto bg-zinc-900/60 p-6 rounded-md">
                    <span class="text-[10px] text-zinc-500 uppercase font-mono block mb-1">Bonifico Bancario / IBAN</span>
                    <code class="text-xs text-[#E6FF00] font-mono select-all">{{ env('SUPPORT_IBAN') }}</code>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
