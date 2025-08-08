# Documentazione CatFriends Club

Benvenuto nella documentazione del progetto CatFriends Club.

## Indice Documentazione

- 📋 [Analisi Funzionale](./analysis/analisi-funzionale.md)
  - Requisiti, attori, flussi, obiettivi MVP
- ⭐ [Funzionalità di Piattaforma](./features.md)
  - Elenco completo delle feature e accessi per ruolo
- 🌐 [Sistema Multilingue](./multilingual-system.md)
  - Gestione lingue (IT, EN, DE, FR, ES, SL) e flussi email multilingue
- ✉️ [Verifica Email](./email-verification.md)
  - Flusso di verifica, override nel `User` model e template mail
- 🔔 [Notifica Registrazione Admin](./registration-notification.md)
  - Invio immediato senza coda e configurazione `ADMIN_EMAIL`
- ⏰ [Scheduler Setup](./deployment/scheduler-setup.md)
  - Istruzioni per cron in produzione (job schedulati CatBook)
- 🧭 [Indice Rapido](./INDEX.md)
  - Link e note operative

## Note per i Contributor

- Segui PSR-12 e le best practice Laravel.
- Mantieni i documenti allineati alla codebase ogni volta che introduci nuove feature o modifichi flussi esistenti.
- Apri una PR separata per aggiornare la documentazione quando serve.