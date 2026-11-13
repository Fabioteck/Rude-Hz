# ARCHITECTURE.md - Rude-Hz Platform

## 1. Panoramica & Stack Tecnologico
**Rude-Hz** (`https://www.rude-hz.it`) è una piattaforma web radio e musicale interattiva progettata per la gestione di tracce audio, artisti, playlist, contest e contenuti redazionali.
- **Backend:** Laravel 12 (PHP 8.4)
- **Admin Panel:** Filament v3.2
- **Frontend / UI:** Blade templates, Tailwind CSS, Alpine.js, Vite
- **Database:** SQLite (configurato in modalità `WAL` con `busy_timeout = 5000`ms)
- **Infrastruttura di Produzione:** Raspberry Pi 4 con Apache2 + PHP-FPM (`www-data`), Fail2ban, Node.js (OpenClaw gateway).

---

## 2. Separazione dei Contesti (I 3 Livelli Architetturali)

### A. Frontend Pubblico (`/`)
Accessibile a tutti gli utenti (ospiti e autenticati):
- **Home & Player:** Web radio streaming player persistente.
- **Esplorazione Tracce & Artisti:** Catalogo pubblico (`/tracks`, `/artists`) con filtri, streaming audio (`/tracks/{track}/stream`) e metriche di visualizzazione.
- **News & Playlist:** Sezione notizie categorizzate e playlist pubbliche curate dalla redazione.
- **Contest:** Visualizzazione concorsi musicali attivi e classifiche.

### B. Area Privata Utente / Studio (`/my-studio`, `/console`, `/dashboard`)
Riservata agli utenti registrati (artisti/supporter):
- **Studio Personale (`/my-studio`):** Gestione del proprio profilo artista, upload e modifica tracce audio, caricamento cover/immagini, gestione liberatoria.
- **Assistente AI (`/console/assistant`):** Integrazione con Ollama locale (`qwen2.5-coder:1.5b`) e Gemini API per supporto agli artisti.
- **Manuali & Guide (`/console/manuals`):** Documentazione funzionale e guide per gli utenti della piattaforma.
- **Piani Utente:** Gestione dei piani di abbonamento (es. Free/Pro) e badge supporter.

### C. Pannello di Amministrazione (`/admin`)
Riservato esclusivamente agli amministratori (`is_admin = true`):
- **Gestione Redazionale:** Creazione e modifica di News, Categorie News, Contest e Playlist tramite Filament Resources e controller dedicati.
- **Moderazione Radio:** Approvazione, rotazione e archiviazione delle tracce caricate dagli artisti (`Admin\RadioController`).
- **Analytics & Monitoraggio:** Cruscotto statistico avanzato (`AdminStatisticController`) e monitoraggio delle risorse hardware del Raspberry Pi.

---

## 3. Mappa del Database & Relazioni Principali

* **`users`**: Tabella utenti con autenticazione, flag `is_admin`, gestione piani (`plan`, `plan_expires_at`), badge supporter. Implementa il contratto `FilamentUser` (`canAccessPanel`).
* **`artists`**: Profilo artistico collegato 1-a-1 con `users` (tramite `user_id`), include slug, stile, social, crypto e campi liberatoria.
* **`tracks`**: Tracce audio caricate dagli artisti, collegate ad `artist_id`, con stato di approvazione (`approved_at`), rotazione radio (`is_in_rotation`), copertina (`cover_path`) e soft deletes.
* **`playlists` & `playlist_track`**: Playlist redazionali e associazione molti-a-molti con le tracce audio.
* **`news` & `news_categories`**: Articoli redazionali e categorie di notizie.
* **`contests` & `contest_track`**: Concorsi musicali e tracce partecipanti.
* **`manuals`**: Manuali e guide operative della piattaforma.
* **`analytics`**: Tracciamento nativo delle visualizzazioni e interazioni utente.

---

## 4. Servizi Esterni & Integrazione IA
* **Ollama Assistant Service (`OllamaAssistantService`):** Integrazione con istanza Ollama locale (es. `qwen2.5-coder:1.5b`).
* **Gemini API:** Utilizzo della chiave API Gemini per assistenti intelligenti e generazione contenuti.

---

## 5. Documentazione API & Sviluppo (Dedoc Scramble)
* **Generatore OpenAPI:** Installato e configurato **Dedoc Scramble** (`dedoc/scramble`) per la generazione automatica della documentazione interattiva.
* **URL di Accesso:** Disponibile su `https://www.rude-hz.it/docs/api`.
* **Regole di Accesso:** Protetto tramite il Gate `viewApiDocs` (accessibile in ambiente `local` o da utenti amministratori con `is_admin = true`).

---

## 6. Storico dei Fix Critici
1. **Mitigazione Lock SQLite su Raspberry Pi:**
   * Abilitazione del journal mode `WAL` (`PRAGMA journal_mode=WAL;`), timeout di attesa incrementato a `5000ms` (`busy_timeout`) in `config/database.php` e isolamento delle sessioni su driver `file` anziché database per eliminare le contese di scrittura su SD card.
2. **Accesso Amministrativo Filament:**
   * Implementazione dell'interfaccia `Filament\Models\Contracts\FilamentUser` e del metodo `canAccessPanel(Panel $panel): bool` nel modello `User` per validare correttamente l'accesso al pannello `/admin` in base al flag `is_admin`.

---

## Aggiornamento Architetturale (13 Novembre 2026)
- **Sistema Ruoli RBAC:** Introdotta colonna `role` su `users` con 5 profili (`super_admin`, `editor`, `curator`, `artist`, `listener`) e `assigned_category_id` per delimitare i redattori alla propria categoria editoriale.
- **Moderazione & Switch ON/OFF:** Aggiunto flag `is_active` su `users`, `artists` e `tracks` con endpoint AJAX live (`toggle-active`) e eliminazione sicura degli artisti (converte l'utente associato in `listener`).
- **Media Pipeline WebP:** Integrato `App\Services\ImageOptimizerService` (Intervention Image v4) per la conversione e il ridimensionamento automatico in `.webp` di tutti gli upload, con placeholder ufficiale `public/images/rude-hz-placeholder.webp`.
- **Backup Automatici (`rude:backup`):** Comando Artisan schedulabile (`--type=daily|weekly`) per backup atomici SQLite ed export JSON in `database/backups/` (rotazione ultimi 14).
- **Email Verification & Supporto:** Attivato `MustVerifyEmail` via Resend SMTP (`://resend.com`) e link donazioni PayPal configurabile (`PAYPAL_DONATE_URL`).
