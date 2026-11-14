# RUDE-Hz - Contesto Permanente di Progetto

## 1. Stack Tecnologico e Architettura
- Framework: Laravel 12.0 su PHP 8.4 + Filament v3.2.
- Frontend: Blade, Tailwind CSS, Alpine.js, Vite 8 (Design target: Cyber-Tech, Mobile-First).
- Database: SQLIte (database/database.sqlite) in modalità WAL (journal_mode=WAL, busy_timeout=5000, synchronous=NORMAL) e SESSION_DRIVER=file.
- Web Server e Permessi: Apache2 + PHP-FPM su Raspberry Pi 4. Proprietario obbligatorio su database e storage: www-data:www-data (664/775).

## 2. I 3 Livelli Applicativi (Veti ARGHITECTURE.md)
1. Frontend Pubblico: /, /tracks, /artists, /playlists, /news, /contests.
1. Area Utente / Studio: /my-studio (gestione profilo artista, upload tracce MP3 e cover, playlist, manuali, piani utente).
1. Pannello Admin: /admin (redazione, moderazione artisti/tracce, analytics nativi, monitoraggio hardware RPi).

## 3. Metodo di Lavoro Obbligatorio
- Procedi sempre per piccoli step con ciclo chiuso: Audit -> Backup -> Modifica -> Verifica interna (max 3 tentativi, ninte curl ciechi su Livewire).
- Prima di modificare il DB, esegui sempre: sqlite3 database/database.sqlite ".backup 'database/backups/backup_$(date +%Y%%m%d_%H%M%S).sqlite'"
## 4. Roadmap Attiva
- Ripristino artisti storici (Endocrino, Parentesi) e 9 tracce MP3 orfane in storage.
- Installazione Dedoc Scramble per documentazione interattiva API/flussi.
- Restyling UI/UX Cyber-Tech Mobile-First di /admin e /my-studio.

## 5. Aggiornamenti Recenti & Convenzioni Attive
- **Ruoli RBAC:** `super_admin`, `editor` (vincolato a `assigned_category_id`), `curator`, `artist`, `listener`. Gli `editor` e `listener` non generano record nella tabella `artists`.
- **Media Pipeline:** Usare sempre `ImageOptimizerService::optimizeAndStore()` per gli upload immagini e `ImageOptimizerService::placeholderUrl()` come fallback.
- **Backup:** Comando disponibile `php artisan rude:backup --type=daily` e `--type=weekly`.
- **Regola Esecuzione:** Gemini CLI modifica solo i file di codice; comandi `php artisan`, `npm run build`, `chown` e `git` vengono eseguiti manualmente dall'utente.

## 6. Stato Consolidato al 14 Novembre 2026
- **Navigazione Admin Compatta:** Voci barra superiore abbreviate (`DASHBOARD`, `ARTISTI`, `TRACCE`, `PLAYLIST`, `CONTEST`, `NEWS`, `PAGES`, `STATS`, `USERS`) filtrate per ruolo RBAC, affiancate da `[ ? GUIDA ]`, pill email utente ed `ESCI`.
- **Player Globale:** Componente `app/Livewire/Player.php` + `resources/views/livewire/player.blade.php` persistente su tutto il frontend con coda JSON (`#rude-tracks-data`) e funzione globale `window.playRudeTrack(idOrObj)`.
- **Pagine Dinamiche & Modifica Tracce:** `/project` e `/support` leggono da `StaticPage`; le tracce in `/admin` supportano la modifica completa dei metadati (`admin.radio.edit`).
- **Documentazione Utenti:** Manuale operativo completo disponibile in `docs/GUIDA_UTENTI_RUDE_HZ.md`.
