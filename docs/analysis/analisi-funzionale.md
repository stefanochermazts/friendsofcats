# Analisi Funzionale - CatFriends Clubgit add .

## 1. Introduzione

Questo documento descrive la piattaforma web **CatFriends Club**, focalizzata sulla gestione di **gatti**, adozioni, social (CatBook) e profili professionali. Utenti destinatari:

- **Associazioni** (rifugi, onlus)
- **Proprietari**
- **Volontari** (con o senza associazione)
- **Veterinari**
- **Toelettatori**
- **Visitatori Pubblici**

Obiettivo: definire funzionalità reali dell’MVP presenti in codebase e la roadmap immediata.

## 2. Scopo e Obiettivi

1. Centralizzare gestione gatti (anagrafiche, stati, media) per associazioni, proprietari e volontari.
2. Fornire profili pubblici per gatti e professionisti con contatti e condivisione social.
3. Offrire una directory professionisti con ricerca per vicinanza e contatto diretto.
4. Integrare un feed sociale (CatBook) con filtri lingua e condivisione.
5. Garantire un sistema multilingua completo (IT, EN, DE, FR, ES, SL) e branding coerente “CatFriends Club”.

## 3. Ambito del Sistema

- **Utenti registrati**: associazioni, volontari, proprietari, veterinari, toelettatori, admin.
- **Area pubblica**: adozioni (`/adoptions`), profili gatti (`/cats/{id}`), directory professionisti (`/professionals`), CatBook (parziale), contatti.
- **Tecnologie**: TALL Stack (Laravel, Livewire, Alpine.js, Tailwind CSS), PostgreSQL, Filament (admin).
- **i18n**: 6 lingue supportate (it, en, de, fr, es, sl).

## 4. Attori

| Attore                           | Descrizione                                                                  |
| -------------------------------- | ---------------------------------------------------------------------------- |
| Associazione / Admin             | Gestisce gatti, volontari, adozioni, profilo associazione.                  |
| Volontario (con/ senza assoc.)   | Gestisce gatti e può collegarsi a un’associazione.                          |
| Proprietario Gatto               | Gestisce i propri gatti e i relativi media.                                  |
| Veterinario                      | Profilo pubblico professionale e gestione dettagli studio.                   |
| Toelettatore (Groomer)           | Profilo pubblico professionale e servizi offerti.                            |
| Visitatore Pubblico              | Naviga adozioni, consulta profili gatti e professionisti, contatta.          |

## 5. Funzionalità e Use Cases (MVP)

### 5.1 Autenticazione, Email e Profili
- Registrazione/login con verifica email. Invio email di verifica personalizzata via `User::sendEmailVerificationNotification()` (no duplicazioni). 
- Notifica admin su nuova registrazione inviata immediatamente (senza coda). Email e layout brandizzati “CatFriends Club”.
- Salvataggio lingua utente (`locale`) e invio email nella lingua corretta.

### 5.2 Gatti: gestione e profilo pubblico
- CRUD gatti con stati: “Di proprietà”, “Adottabile”, “Non adottabile”, “Adottato”.
- Foto principale + galleria, drag & drop, preview, rimozione, validazione dimensione file.
- Pagina dettaglio `/cats/{id}` ottimizzata: layout non full-width, hero 400px, immagine principale inclusa in galleria, microchip mostrato correttamente, “giorni dalla permanenza” in formato leggibile (X giorni e Y ore).
- OG tags e pulsanti di condivisione social; nome gatto nei post CatBook cliccabile e linkato al profilo.
- “Featured Cats” in home reindirizza correttamente a `/cats/{id}`.

### 5.3 Adozioni pubbliche (`/adoptions`)
- Filtri compatti in contenitore collassabile; statistiche ridotte e coerenti (totale in header, età in una riga a 4 colonne). 
- Conteggio totale gatti in alto a destra (desktop/tablet).
- Infinite scroll al posto di “Load more”.

### 5.4 CatBook
- Creazione post con lingua automatica in base alla lingua selezionata in header.
- Filtro lingua integrato con selettore globale; post mostrati secondo lingua corrente.
- Pulsanti “Mi piace”, “Commenta”, “Condividi” tradotti in tutte le lingue supportate; fix traduzioni DE.
- Nome gatto cliccabile → dettaglio gatto. OG tags su condivisione.
- Meccanismo di generazione automatica post sostituito con job pianificato (vedi `docs/deployment/scheduler-setup.md`).
- Sistema “Segui” (follow) per gatti e utenti implementato a livello di modello/DB; notifiche roadmap.

### 5.5 Directory Professionisti (`/professionals`)
- Profili pubblici per veterinari/toelettatori: foto principale, galleria, descrizione, contatti, link Google Maps.
- Upload foto come per i gatti (drag & drop, preview, DataTransfer fix per foto principale). 
- Ricerca per vicinanza (città + raggio) con geocodifica Nominatim e Haversine in PostgreSQL; fix su alias `distance` (uso `whereRaw`).
- Slider raggio con label dinamica; pulsante tradotto `professionals.apply_filters` in 6 lingue.
- Card con immagine più alta (doppia altezza) e dettagli sintetici; contatto diretto: email e form “Scrivi un messaggio” con precompilazione.

### 5.6 Navigazione e Responsive
- Menù desktop + hamburger menu mobile coerenti tra home e sezioni autenticate.
- Ordine voci: Home → Adozioni → Professionisti → CatBook (se loggato) → Contattaci.
- Ottimizzazione layout mobile CatBook (margini ridotti, textarea/select/bottone foto full-width). 

### 5.7 Homepage
- Sezione hero, CTA per registrazione, adozioni, CatBook.
- Statistiche reali e coerenti lato DB con endpoint dedicato e contatori animati.
- Traduzioni complete, incluso fix per “Veterinari e Toelettatori”.

## 6. Requisiti Non-Funzionali
- **Sicurezza**: CSRF, validazione input, prepared statements Eloquent/Query Builder, middleware ruoli.
- **Performance**: infinite scroll, lazy loading immagini, query ottimizzate con eager loading e indici.
- **i18n**: 6 lingue complete; lingua utente persistita; email multilingue.
- **Disponibilità**: scheduling via cron per job pianificati; invii email immediati (nessun worker richiesto per le notifiche base).
- **Accessibilità**: attenzione a contrasto, ruoli ARIA nelle viste principali.
- **Logging**: uso di log per troubleshooting (es. richieste contatto professionisti).

## 7. Architettura Tecnica
- **Backend**: Laravel 11, Filament per pannello admin.
- **Frontend**: Blade, Livewire, Alpine.js, Tailwind CSS.
- **Database**: PostgreSQL; tabelle chiave: `users`, `cats`, `posts`, `post_comments`, `post_likes`, `cat_follows`, `user_follows`, `contacts`.
- **Storage**: upload pubblico per media (foto principale + gallerie), gestione rimozione file.
- **Geocoding**: `App\Services\GeocodingService` (Nominatim), caching opportuno; Haversine in query per filtro distanza.
- **Routing**: pagine pubbliche (`/adoptions`, `/professionals`, `/cats/{id}`), CatBook, dashboard; middleware lingua (`SetLocale`/`AuthLocale`).
- **Email**: `App\Mail\EmailVerification`, `RegistrationNotification`; layout `emails/layouts/minimal.blade.php` brand “CatFriends Club”.
- **Scheduler**: job schedulato per generazione post; vedi `docs/deployment/scheduler-setup.md`.

## 8. Multilingua e Localizzazione
- Traduzioni in `resources/lang/{locale}` (IT, EN, DE, FR, ES, SL), file: `emails.php`, `verification.php`, `contact.php`, `professionals.php`, ecc.
- Integrazione selettore lingua header con CatBook (filtri/creazione post). 
- Riferimento: `docs/multilingual-system.md`.

## 9. SEO, Open Graph e Condivisione
- OG tags su `/cats/{id}` e condivisione CatBook.
- Pulsanti social (Facebook, Twitter/X, WhatsApp) e JSON-LD (ove pertinente) roadmap.

## 10. Roadmap (Post-MVP)
- Memoriale virtuale e storie di successo.
- Gamification (badge, punti) e leaderboard community.
- Eventi (open-day, raccolte fondi) con RSVP.
- Mappa interattiva (gatti e professionisti).
- Chat diretta e messaggistica privata.
- Notifiche push tempo reale.
- Mobile app.

---

*Fine Analisi Funzionale CatFriends Club (MVP)*
