# 🐱 CatFriends Club

CatFriends Club è una piattaforma TALL (Laravel + Livewire + Alpine.js + Tailwind CSS) per la gestione di gatti, adozioni, CatBook (social), volontari e profili professionali (veterinari e toelettatori). Include pannello admin con Filament e un sistema multilingua completo (IT, EN, DE, FR, ES, SL).

<p align="left">
  <img src="public/images/cat-logo.svg" alt="CatFriends Club" height="64" />
</p>

- **Framework**: Laravel
- **Admin**: Filament
- **Frontend**: Blade, Livewire, Alpine.js, Tailwind CSS
- **DB**: PostgreSQL
- **Altre dipendenze**: Laravel Mail, Storage pubblico, Scheduler

## Indice
- [Funzionalità principali](#funzionalità-principali)
- [Requisiti](#requisiti)
- [Avvio rapido](#avvio-rapido)
- [Configurazione ambiente](#configurazione-ambiente)
- [Database e seeding](#database-e-seeding)
- [Comandi utili](#comandi-utili)
- [Build front-end](#build-front-end)
- [Testing](#testing)
- [Scheduler in produzione](#scheduler-in-produzione)
- [Traduzioni](#traduzioni)
- [Struttura principali rotte](#struttura-principali-rotte)
- [Sicurezza](#sicurezza)

## Funzionalità principali
- ✅ Gestione gatti con foto principale e galleria (drag & drop, preview, rimozione, validazione dimensione lato client/server)
- ✅ Dettaglio gatto con layout responsive, microchip, galleria foto, OG tags e social sharing
- ✅ Adozioni pubbliche con filtri compatti e ricerca per vicinanza (città + raggio)
- ✅ CatBook con filtri lingua integrati al selettore globale, link al profilo del gatto e traduzioni complete
- ✅ Volontari con stesse funzioni dei proprietari e collegamento opzionale ad associazione
- ✅ Sezione Professionisti (veterinari/toelettatori) con foto principale + galleria, profilo pubblico e directory
- ✅ Directory Professionisti con ricerca per vicinanza (come Adozioni) e autocomplete città
- ✅ Moduli di contatto: associazioni e professionisti, con email di conferma/notification
- ✅ Admin panel con Filament

Per maggiori dettagli: `docs/features.md` e `docs/analysis/analisi-funzionale.md`.

## Requisiti
- PHP 8.2+
- Composer 2+
- Node.js 18+ / PNPM o NPM
- PostgreSQL 13+
- Estensioni PHP comuni (pdo_pgsql, fileinfo, mbstring, openssl, etc.)

## Avvio rapido
```bash
# 1) Installazione dipendenze backend/frontend
composer install
npm install

# 2) Copia configurazione
cp .env.example .env
# oppure su Windows
copy .env.example .env

# 3) Genera APP_KEY
php artisan key:generate

# 4) Configura DB in .env (vedi sezione successiva) e poi:
php artisan migrate --seed

# 5) Link storage pubblico
php artisan storage:link

# 6) Avvio
php artisan serve --port=8001
npm run dev
```

Apri: `http://localhost:8001`.

## Configurazione ambiente
Nel file `.env` imposta almeno:
```
APP_NAME="CatFriends Club"
APP_URL=http://localhost:8001

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=catfriends
DB_USERNAME=postgres
DB_PASSWORD=secret

FILESYSTEM_DISK=public

# Email (per moduli contatto & verifiche)
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_FROM_ADDRESS="no-reply@localhost"
MAIL_FROM_NAME="CatFriends Club"

# Email fallback destinatario (notifiche contatti)
ADMIN_EMAIL=stefano.chermaz@gmail.com
```

## Database e seeding
- Le migrazioni sono in `database/migrations`.
- Il seeder principale (`php artisan migrate --seed`) crea dati minimi. Sono presenti anche comandi di utilità in `app/Console/Commands` (es. creazione gatti di esempio).

## Comandi utili
```bash
# Pulizia cache
php artisan config:clear && php artisan view:clear && php artisan cache:clear

# Fix storage
php artisan storage:link

# Filament (admin)
php artisan serve # poi visita /admin (richiede utente con ruolo admin)
```

## Build front-end
Durante lo sviluppo:
```bash
npm run dev
```
In produzione:
```bash
npm run build
```

## Testing
```bash
php artisan test
```

## Scheduler in produzione
Alcune funzionalità (es. job schedulati per generare post automatici) richiedono il Laravel Scheduler. Vedi guida: `docs/deployment/scheduler-setup.md`.

## Traduzioni
- File: `resources/lang/{it,en,de,fr,es,sl}`
- Le chiavi comuni sono anche in i18n JSON (`resources/lang/*.json`).

## Struttura principali rotte
- Pubblico
  - `/` Homepage
  - `/adoptions` Vetrina adozioni + ricerca per vicinanza
  - `/professionals` Directory professionisti + ricerca per vicinanza
  - `/professionals/{id}` Profilo professionista con foto e contatti
  - `/catbook` Feed (richiede login)
  - `/contact` Modulo contatti (prefill per gatto/associazione/professionista)
- Admin (Filament)
  - `/admin`

## Sicurezza
- Dati form validati via Request/Livewire
- Upload immagini su disco pubblico con limiti dimensione (adeguati a `upload_max_filesize`)
- Protezione CSRF per i form

---
Se qualcosa non funziona o vuoi suggerire una miglioria, apri una issue o invia una PR. Buon lavoro con CatFriends Club! 🐾
