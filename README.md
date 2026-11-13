# 🎧 Rude-Hz.it | The Harder Side of Sound

**Rude-Hz** è una piattaforma indipendente nata per dare struttura, voce e spazio creativo alla community underground Tekno, Acid e Industrial.  
Progettata per unire musica, editoria culturale e partecipazione attiva senza algoritmi commerciali, permette agli artisti di pubblicare i propri master, ai curatori di creare playlist ufficiali e alla redazione di divulgare contenuti tecnici e culturali.

---

## 🚀 Stack Tecnologico & Infrastruttura
- **Server:** Raspberry Pi 4 (Ubuntu 24.04 LTS + Nginx)
- **Backend:** Laravel 12.x (PHP 8.4)
- **Database & Cache:** SQLite (modalità **WAL** + `busy_timeout`) + **Redis** + PostgreSQL ready
- **Frontend:** Blade, Livewire, Alpine.js, Tailwind CSS + HTML5 Canvas Arcade Engine
- **Media & API:** Intervention Image v4 (conversione automatica **WebP**), Dedoc Scramble (OpenAPI Docs), Resend SMTP

---

## 🛠️ Funzionalità Implementate
- [x] **Pannello Admin Dark Cyber-Tech (`/admin`):** Console di comando Mobile-First con paginazione rapida, ricerca istantanea, switch live **`ON ⚡ / OFF 💤`** e drawer **`[ ? GUIDA ]`** contestuale per gli operatori.
- [x] **Sistema Ruoli & Permessi (RBAC):** Gestione granulare con 5 profili (`super_admin`, `editor` vincolato alla propria categoria editoriale, `curator`, `artist`, `listener`) e menu dinamici per ruolo.
- [x] **Artist Studio (`/my-studio`):** Area personale per gestire biografia, social link, chiavi Nostr (`npub`), Lightning Address (Zaps) e caricare tracce MP3/WAV e copertine.
- [x] **Media Pipeline WebP Automatica:** Ottimizzazione e ridimensionamento automatico in `.webp` di tutti gli upload (avatar, cover, news) con placeholder ufficiale Rude-Hz.
- [x] **Frontend Cyberpunk Arcade & Player Globale:**
  - Player audio persistente attivo su tutta la navigazione.
  - Sfondo interattivo retro-arcade anni '80 (particelle fluo reattive, UFO, alieni, astronauta e luna).
  - Supporto multilingua (`IT` / `EN` / `ES`) con bandiere SVG e traduzione automatica in cache su Redis.
- [x] **Modulo Redazionale, Playlist, Contest & Pagine Statiche:** Gestione completa di News categorizzate, Playlist ufficiali, Arene Contest e pagine *Progetto* / *Supporto* (con integrazione PayPal).
- [x] **Registrazione con Verifica Email & Backup Automatici:** Conferma account via Resend SMTP e comando Artisan `rude:backup` (`--type=daily|weekly`) con rotazione automatica.
- [x] **Documentazione API (`/docs/api`):** Specifica OpenAPI interattiva protetta per gli amministratori tramite Dedoc Scramble.

---

## 🚧 Prossimi Sviluppi (Roadmap)
- [ ] Integrazione diretta micro-pagamenti **Lightning Network (Zaps)** sui profili artista.
- [ ] Notifiche push/email per nuove uscite e apertura contest.
- [ ] Espansione sezione **Eventi & Sound System** curata dai Curator.

---

## 📦 Installazione & Comandi Utili
1. `composer install`
2. `npm install && npm run build`
3. `cp .env.example .env && php artisan key:generate`
4. `php artisan migrate --force`
5. `php artisan storage:link`
6. **Backup manuale/schedulato:** `php artisan rude:backup --type=daily`

---

## 📚 Documentazione Interna
- **`docs/GUIDA_UTENTI_RUDE_HZ.md`:** Manuale operativo non tecnico per Artisti, Redattori, Curatori e Super Admin.
- **`ARCHITECTURE.md`:** Mappa tecnica del database, dei servizi e delle rotte.

---
*Born in WhatsApp. Raised in Techno.*
