# Analisi Funzionale - FriendsOfCats

## 1. Introduzione

Il documento descrive in dettaglio la **Piattaforma FriendsOfCats**, un sistema web e mobile pensato unicamente per la gestione di **gatti**, destinato a:

* **Associazioni animaliste** (rifugi, onlus)
* **Proprietari di gatti**
* **Veterinari**
* **Volontari** (foster carers, cat sitter)
* **Donatori**
* **Toelettatori** (groomers)
* **Visitatore Pubblico** (amanti dei gatti)

Scopo: definire funzionalità, flussi utente e requisiti per la versione MVP e per eventuali funzioni avanzate (memoriale virtuale, feed comunitario) .

## 2. Scopo e Obiettivi

1. Centralizzare la gestione dei gatti (anagrafiche, adozioni, volontari) per rifugi e associazioni .
2. Fornire ai proprietari e veterinari un’area dedicata al proprio gatto (salute, feed, ricordi, memoriale).
3. Coinvolgere la community (volontari, donatori, cat sitter) nella cura e promozione delle adozioni.
4. Popolare automaticamente la sezione pubblica del sito con dati inseriti in area riservata.
5. Garantire una piattaforma focalizzata **esclusivamente** sui gatti .

## 3. Ambito del Sistema

* **Utenti registrati**: associazioni, volontari, proprietari, veterinari, donatori, toelettatori.
* **Area pubblica**: adozioni, memoriale, feed, storie di successo.
* **Tecnologie MVP**: Laravel TALL (Laravel, Livewire, Alpine.js, Tailwind CSS), PostgreSQL, servizi di notifica. Per la costruzione degli admin panel vorrei che tu usassi filament e come template di frontend mi piacerebbe che prendessi spunto da questo sito.

## 4. Attori

| Attore                           | Descrizione                                                                  |
| -------------------------------- | ---------------------------------------------------------------------------- |
| Associazione / Admin             | Gestisce anagrafiche, volontari, adozioni, memoriale.                        |
| Volontario (Foster / Cat Sitter) | Riceve incarichi, aggiorna disponibilità, supporta socializzazione.          |
| Proprietario Gatto               | Gestisce profilo gatto, salute, ricordi, memoriale.                          |
| Veterinario                      | Aggiorna diagnosi, piani di cura, risultati di esami, prescrive trattamenti. |
| Donatore                         | Effettua donazioni e supporta progetti specifici.                            |
| Toelettatore (Groomer)           | Gestisce servizi di toelettatura e benessere estetico dei gatti.             |
| Visitatore Pubblico              | Consulta vetrina adozioni, storie di successo, feed comunitario.             |
| Sistema di Notifiche             | Gestisce invio push/email per promemoria, incarichi e aggiornamenti.         |

## 5. Funzionalità e Use Cases

### 5.1 Autenticazione & Profili

* Registrazione/Login (email+pwd, ruoli: associazione, volontario, proprietario, veterinario, donatore, toelettatore).
* Gestione Profilo (nome, contatti, logo/foto, certificazioni veterinario).

### 5.2 Gestione Animali (Associazioni)

* CRUD schede (nome, razza, età, stato sanitario, microchip, comportamento).
* Filtri avanzati (razza, età, sterilizzazione, livello di socialità).
* Lista d’attesa per adozioni e organizzazione di open-day.

### 5.3 Piattaforma Adozioni

* Vetrina pubblica con filtri (località, razza, età, sterilizzazione).
* Modulo di contatto con questionario breve per potenziali adottanti.
* Sezione “Storie di Successo” con testimonianze e foto.

### 5.4 Registro Salute & Promemoria (Proprietari & Veterinari)

* CRUD voci vaccini e trattamenti (FIV, FeLV, calicivirus, ecc.).
* Pianificazione visite veterinarie con reminder configurabili.
* Upload referti, esami del sangue e documenti veterinari.
* Dashboard veterinario per monitoraggio salute multiplo gatto.

### 5.5 Rubrica Volontari & Workflow

* Elenco volontari con disponibilità e competenze (foster, cat sitter).
* Assegnazione incarichi via notifica push/email.
* Monitoraggio formazione e certificazioni volontari.

### 5.6 Servizi Aggiuntivi Professionali

* Prenotazione toelettatura con toelettatori certificati.
* Donazioni mirate (vaccini, sterilizzazione) per singoli progetti.

### 5.7 Sezioni Pubbliche

* **Adozioni**: elenco gatti disponibili, aggiornato in real time dai dati CRM.
* **Ricordi**: memoriale virtuale dei gatti adottati o scomparsi.
* **Feed Aggregato**: mix di ultime adozioni, storie, memoriale, con widget “Gatto della settimana”.
* **Segnalazioni Lost & Found**: alert georiferiti per gatti smarriti e ritrovati.

## 6. Requisiti Non-Funzionali

* **Focalizzazione**: il sistema supporta **solo** gatti.
* **Sicurezza & GDPR**: crittografia dati sensibili, gestione consensi per dati sanitari.
* **Performance**: API ≤ 200 ms CRUD.
* **Scalabilità**: architettura modulare microservizi.
* **Disponibilità**: SLA ≥ 99.5%.
* **Accessibilità**: conformità **WCAG 2.1 AA** per frontend e API.
* **i18n**: Italiano, Inglese, Spagnolo, Francese, Tedesco.
* **Theming**: supporto per temi chiaro e scuro, con switch manuale e rilevazione automatica delle preferenze di sistema.

## 7. Stile Visivo e Design

* **Approccio Minimalista**: layout pulito con uso preminente di bianco e nero per background e tipografia, garantendo massima leggibilità e riducendo al minimo gli elementi distraenti.
* **Eleganza e Sobrietà**: utilizzo di spaziature generose, font sans-serif moderni e accenti visivi discreti per un'estetica raffinata.
* **Valorizzazione delle Immagini**: griglie e card pensate per mettere in risalto le foto inviate dagli utenti, con possibilità di visualizzazioni full-screen e gallerie interattive.
* **Coerenza Visuale**: componenti UI armonizzate, con stili uniformi per bottoni, form e card, per un'esperienza utente fluida e intuitiva.

---

*Fine Analisi Funzionale FriendsOfCats MVP + Memoriale Virtuale*
