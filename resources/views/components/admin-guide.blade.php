@php
    $currentRoute = request()->route()->getName();
    $guideTitle = "Guida Operativa Admin";
    $guideContent = "Benvenuto nel pannello di controllo Rude-Hz. Utilizza la barra di navigazione superiore per accedere alle sezioni chiave della piattaforma.";

    if (str_contains($currentRoute, 'admin.users')) {
        $guideTitle = "Guida: Gestione Utenti & Team";
        $guideContent = "Da questa sezione i Super Admin possono gestire gli account del team e degli artisti. Puoi creare nuovi utenti, assegnare ruoli specifici (Super Admin, Editor, Curator, Artist), associare categorie editoriali per gli editor, abilitare o disabilitare l'accesso con l'interruttore rapido ON/OFF, o eliminare account non autorizzati.";
    } elseif (str_contains($currentRoute, 'admin.artists')) {
        $guideTitle = "Guida: Gestione Artisti";
        $guideContent = "Gestisci i profili dei producer e dei talenti della community. Puoi revisionare i dati anagrafici, i link social (Spotify, SoundCloud, YouTube, Instagram), le chiavi Nostr e Lightning (LN), e moderare le immagini del profilo con ottimizzazione automatica WebP.";
    } elseif (str_contains($currentRoute, 'admin.radio')) {
        $guideTitle = "Guida: Moderazione Tracce & Radio";
        $guideContent = "Controllo e moderazione dei file audio MP3 caricati dagli artisti. Approva le tracce per inserirle nella rotazione radiofonica ufficiale, gestisci i metadati, ascolta in anteprima e verifica lo stato di conformità dei brani.";
    } elseif (str_contains($currentRoute, 'admin.playlists')) {
        $guideTitle = "Guida: Playlist Ufficiali & Dj Set";
        $guideContent = "Crea e organizza le selezioni musicali e i DJ set in vetrina sul frontend pubblico. Associa le tracce alle playlist ufficiali della community con ordinamento personalizzato e copertine dedicate.";
    } elseif (str_contains($currentRoute, 'admin.contests')) {
        $guideTitle = "Guida: Contest & Remix Challenges";
        $guideContent = "Gestisci le arene creative e i contest di produzione musicale. Configura date di apertura/chiusura, tracce di base, regolamenti e votazioni della community.";
    } elseif (str_contains($currentRoute, 'admin.news')) {
        $guideTitle = "Guida: News & Comunicazioni Ufficiali";
        $guideContent = "Pubblica e modera articoli, comunicati e aggiornamenti per la community underground. Gli editor possono gestire le categorie assegnate e formattare i contenuti con anteprime e immagini.";
    } elseif (str_contains($currentRoute, 'admin.pages')) {
        $guideTitle = "Guida: Pagine Statiche";
        $guideContent = "Gestisci i contenuti delle pagine pubbliche come Progetto (/project) e Supporto (/support). Super Admin ed Editor possono modificare titoli, tagline e testi principali visibili alla community.";
    } elseif (str_contains($currentRoute, 'admin.stats')) {
        $guideTitle = "Guida: Statistiche & Analitica";
        $guideContent = "Monitoraggio in tempo reale del traffico web, delle visite negli ultimi 30 giorni, dei tempi di permanenza (minimo, medio, massimo), della composizione dei visitatori (Artisti vs Anonimi), dei dispositivi e dei top referrer.";
    }
@endphp

<div x-data="{ guideOpen: false }" class="relative inline-block">
    <!-- BOTTONE GUIDA NELLA NAVBAR ADMIN -->
    <button @click="guideOpen = true" type="button" class="w-7 h-7 bg-zinc-900 border border-[#E6FF00]/40 text-[#E6FF00] hover:bg-[#E6FF00] hover:text-black font-mono font-bold uppercase text-xs rounded transition-colors flex items-center justify-center shadow-[0_0_10px_rgba(230,255,0,0.15)]" title="Guida">
        ?
    </button>

    <!-- OVERDROP / BACKDROP -->
    <div x-show="guideOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="guideOpen = false" 
         class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50"></div>

    <!-- DRAWER LATERALE DESTRA (CYBERPUNK THEME) -->
    <div x-show="guideOpen"
         x-cloak
         x-transition:enter="transition transform ease-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition transform ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed inset-y-0 right-0 w-full max-w-md bg-[#121212] border-l border-[#1F1F1F] text-white z-50 shadow-2xl flex flex-col font-mono">
        
        <!-- HEADER DRAWER -->
        <div class="p-6 border-b border-[#1F1F1F] flex items-center justify-between bg-[#0A0A0A]">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#E6FF00] animate-pulse"></span>
                <h3 class="text-sm font-black uppercase tracking-widest text-[#E6FF00]">{{ $guideTitle }}</h3>
            </div>
            <button @click="guideOpen = false" class="text-zinc-400 hover:text-white p-2 text-lg font-bold">✕</button>
        </div>

        <!-- CORPO GUIDA -->
        <div class="p-6 overflow-y-auto flex-1 space-y-6 text-xs text-zinc-300 leading-relaxed">
            <div class="bg-zinc-900 p-4 rounded border border-[#1F1F1F]">
                <h4 class="font-bold text-white uppercase tracking-wider mb-2 text-[#00FF66]">⚡ Istruzioni Operative</h4>
                <p>{{ $guideContent }}</p>
            </div>

            <div class="space-y-3">
                <h4 class="font-bold text-white uppercase tracking-wider text-[11px] text-[#FF007F]">Regole di Sicurezza Raspberry Pi 4</h4>
                <ul class="list-disc list-inside space-y-1.5 text-zinc-400 text-[11px]">
                    <li>Non riavviare mai il server (`reboot`) senza autorizzazione.</li>
                    <li>Mantenere permessi corretti su storage e database SQLite WAL.</li>
                    <li>Operare sempre con cautela nella moderazione dei contenuti.</li>
                </ul>
            </div>
        </div>

        <!-- FOOTER DRAWER CON STAMPA PDF -->
        <div class="p-6 border-t border-[#1F1F1F] bg-[#0A0A0A] flex items-center justify-between">
            <span class="text-[10px] text-zinc-500 uppercase">Rude-Hz Admin v3.2</span>
            <button onclick="window.print()" class="px-4 py-2 bg-zinc-900 border border-[#E6FF00]/40 text-[#E6FF00] hover:bg-[#E6FF00] hover:text-black font-bold uppercase text-[10px] tracking-wider rounded transition flex items-center gap-2">
                <span>[ 🖨️ Stampa / PDF ]</span>
            </button>
        </div>
    </div>
</div>
