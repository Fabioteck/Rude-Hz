# RUDE-HZ — Manuale Operativo & Guida alla Piattaforma
**Versione:** 1.0 (Produzione) | **Dominio:** https://rude-hz.it  
**Target:** Community Tekno, Acid, Industrial & Cultura Underground

---

## 1. Il Progetto Rude-Hz: Visione e Obiettivi
**Rude-Hz** (*The Harder Side of Sound*) nasce come spazio digitale indipendente dedicato alla musica elettronica underground, alle sonorità Tekno/Acid/Industrial e alla cultura rave consapevole.  
A differenza delle piattaforme commerciali, Rude-Hz è progettato per dare voce diretta agli artisti, ai collettivi e ai divulgatori senza algoritmi opachi:
* **Vetrina Musicale & Streaming Continuo:** Gli ascoltatori possono esplorare artisti, tracce singole e playlist curate con un player audio sempre attivo durante la navigazione.
* **Redazione & Cultura:** Una sezione editoriale dedicata a storia della musica elettronica, approfondimenti tecnici, diritti d'autore/royalty e riduzione del danno / informazione consapevole.
* **Arene Creative (Contest):** Spazio dedicato a remix challenge e contest di produzione musicale per la community.
* **Sostegno Indipendente:** Il progetto è autofinanziato e supportato direttamente dalla community tramite donazioni volontarie nella sezione *Support*.

---

## 2. Guida per gli Utenti & Artisti (`/my-studio`)

### A. Registrazione e Attivazione Account
1. Clicca su **Registrati** nella barra in alto o nella schermata di accesso.
2. Inserisci il tuo **Nome d'Arte**, un'email valida e una password sicura.
3. Controlla la tua casella di posta (inclusa la cartella *Spam* al primo invio) e clicca sul pulsante **Verify Email Address**.
4. **Accesso immediato allo Studio:** Una volta verificata l'email, puoi accedere subito alla tua area riservata **`/my-studio`**.
5. **Visibilità Pubblica:** Per tutelare la qualità della piattaforma, i nuovi profili nascono in stato *"In Revisione"* (`OFF`). Puoi già compilare tutti i tuoi dati e caricare i brani, ma il tuo profilo diventerà visibile al pubblico solo dopo l'approvazione da parte dello staff.

### B. Gestione Profilo & Caricamento Musica (`/my-studio`)
All'interno della tua console personale hai due sezioni principali:
* **Sezione ARTIST (Identità & Bio):**
  * Compila la tua biografia e inserisci i tuoi collegamenti esterni (SoundCloud, Spotify, Instagram, YouTube, chiave pubblica Nostr o indirizzo Lightning).
  * Carica il tuo **Avatar** e la tua **Immagine di Copertina**: il sistema li ottimizzerà e convertirà automaticamente in formato leggero ad alta velocità per dispositivi mobili.
* **Sezione TRACKS (Caricamento Brani):**
  * Carica i tuoi file audio (formato **MP3**), indica il titolo, il genere musicale (es. *Acid Tekno*, *Hard Tekno*, *Industrial*) e carica una copertina dedicata (se non ne hai una, verrà assegnata l'immagine ufficiale Rude-Hz).

---

## 3. Guida per la Redazione / Editor (`/admin`)
Gli utenti con ruolo **Editor** accedono al pannello `/admin` con una visuale mirata esclusivamente ai contenuti editoriali (**Dashboard, News, Contest**).

### A. Pubblicazione e Gestione Articoli (`NEWS`)
1. Vai nella sezione **News** dalla barra superiore e clicca su **+ Nuova News**.
2. **Categoria Editoriale:** Se ti è stata assegnata una rubrica specifica (es. *Storia della Techno*, *Riduzione del Danno*, *Tecnica & Produzione*, *Diritti & Royalty*), i tuoi articoli verranno collegati direttamente a quell'area tematica.
3. **Compilazione:**
   * **Titolo & Sottotitolo:** Usa titoli chiari e incisivi.
   * **Contenuto:** Scrivi il testo dell'articolo in italiano (la piattaforma gestisce automaticamente la traduzione multilingua per i visitatori esteri).
   * **Immagine di Copertina:** Carica un'immagine orizzontale; verrà ridimensionata e ottimizzata automaticamente dal sistema.
4. Usa i pulsanti **Modifica** o **Elimina** nella lista per aggiornare o rimuovere gli articoli.

### B. Gestione Arene & Contest (`CONTEST`)
1. Dalla sezione **Contest**, clicca su **+ Nuovo Contest** per avviare una nuova sfida creativa o remix contest.
2. Imposta il titolo, il regolamento, le date di apertura/chiusura delle iscrizioni e le eventuali note legali/liberatorie per i partecipanti.

---

## 4. Guida per i Curatori Musicali (`/admin`)
Gli utenti con ruolo **Curator** (A&R) gestiscono il catalogo musicale della piattaforma (**Dashboard, Artisti, Tracce, Playlist**).

### A. Moderazione Artisti e Tracce (`ARTISTI` & `TRACCE`)
* **Interruttore Rapido `ON ⚡ / OFF 💤`:** Ogni artista e ogni traccia nella lista dispone di un pulsante di stato istantaneo.
  * Clicca su **`OFF 💤`** per portare lo stato su **`ON ⚡`**: l'artista o il brano diventa immediatamente visibile e ascoltabile sul sito pubblico.
  * Clicca su **`ON ⚡`** per mettere temporaneamente in pausa un artista o un brano senza cancellare i suoi dati.
* **Modifica Anagrafica:** Cliccando su **Modifica** puoi aiutare un artista a sistemare la biografia, i link o caricare al suo posto avatar e copertina.

### B. Creazione Playlist Ufficiali (`PLAYLIST`)
1. Vai su **Playlist** → **+ Nuova Playlist**.
2. Inserisci il nome della selezione (es. *Rude-Hz Hard Selection Vol. 1*), una breve descrizione e una copertina.
3. Seleziona le tracce approvate da includere nella scaletta e salva. Puoi modificare l'ordine o aggiungere nuovi brani in qualsiasi momento tramite il tasto **Edit**.

---

## 5. Guida per l'Amministratore Globale (`SUPER_ADMIN`)
Il **Super Admin** ha il controllo completo sull'infrastruttura, sullo staff e sulla sicurezza della piattaforma.

### A. Gestione Utenti, Staff e Permessi (`UTENTI`)
Dalla voce **Utenti** nella barra superiore puoi amministrare tutti gli account registrati:
* **Creazione Collaboratori (`+ Nuovo Utente`):** Crea un account per un nuovo membro del team assegnandogli il ruolo corretto:
  * **`super_admin`:** Accesso totale a tutte le funzioni e impostazioni.
  * **`editor`:** Accesso solo a *News* e *Contest* (con possibilità di vincolarlo a una specifica categoria editoriale).
  * **`curator`:** Accesso solo a *Artisti*, *Tracce* e *Playlist*.
  * **`artist`:** Accesso solo alla propria area personale `/my-studio`.
  * **`listener`:** Utente semplice registrato (senza pannello artista).
* **Sospensione Account:** Usa lo switch **`ON ⚡ / OFF 💤`** per abilitare o bloccare l'accesso di un utente.
* **Rimozione Sicura Artisti:** Eliminando un profilo dalla sezione *Artisti*, vengono rimossi i suoi brani e file multimediali, mentre l'account utente rimane registrato come semplice `listener` per evitare re-iscrizioni indesiderate.

### B. Monitoraggio Server & Statistiche (`STATISTICHE` & `DASHBOARD`)
* **Stato Hardware:** Nel riquadro in alto a destra della Dashboard puoi tenere sotto controllo in tempo reale la temperatura e il carico CPU del server.
* **Analitica Traffico:** Nella sezione **Statistiche** puoi consultare l'andamento delle visite negli ultimi 30 giorni, i tempi medi di permanenza, la ripartizione tra dispositivi mobile/desktop e le sorgenti di traffico.
* **Guida Rapida Integrata:** In ogni pagina del pannello è sempre disponibile il pulsante **`[ ? GUIDA ]`** in alto a destra per consultare un promemoria contestuale o stampare la scheda operativa in PDF.
