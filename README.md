# 🎧 Rude-Hz.it | The Techno Community Portal

**Rude-Hz** è una piattaforma nata per strutturare una community tekno originariamente sviluppata su WhatsApp.
 Il progetto permette agli artisti di caricare i propri master, ricevere validazione dall'admin e finire in rotazione su una web radio integrata con generazione automatica di QR Code univoci per ogni traccia.

## 🚀 Stack Tecnologico
- **Hardware:** Raspberry Pi 4 (Ubuntu 24.04)
- **Backend:** Laravel 13.x (PHP 8.4)
- **Database:** SQLite / NOSTR 
- **Frontend:** Blade + Tailwind CSS
- **Features:** 
  - Audio Player personalizzato con Autoplay.
  - Generazione QR Code dinamica (Simple-QRCode).
  - Sistema di moderazione Master (Approvazione/Kill Switch).
  - Web3 Ready: Campi per Lightning Network (Zaps) e Nostr (npub).

## 🛠️ Funzionalità Implementate
- [x] **Artist Dashboard:** Upload file audio (MP3/WAV) con gestione limiti server (64MB+).
- [x] **Profile Management:** Setup profilo artista con Social Links e LN Address.
- [x] **Admin War Room:** Pannello per approvazione tracce, ascolto rapido e cancellazione fisica dei file dal server.
- [x] **Landing Page:** Radio Player interattivo che pesca l'ultima traccia approvata, lista "Latest Drops" e griglia "Top Artists".

## 🚧 Work in Progress (Prossimi Step)
- [ ] Rifacimento totale Interfaccia Admin (Console di Comando).
- [ ] Modulo News / Blog per la community.
- [ ] Sistema di "Zaps" tramite rete Lightning per supporto diretto agli artisti.
- [ ] Gestione cancellazione fisica dei profili e logica di pulizia storage.

## 📦 Installazione Rapida
1. `composer install`
2. `npm install && npm run build`
3. `php artisan migrate:fresh --seed`
4. `php artisan storage:link`
5. Configura `php.ini` per permettere upload > 2MB.

---
*Born in WhatsApp. Raised in Techno.*
