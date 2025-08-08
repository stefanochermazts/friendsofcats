# Indice Rapido Documentazione - CatFriends Club

## 📋 Documenti Principali

### [docs/README.md](./README.md)
- **Scopo**: Overview generale e navigazione
- **Quando consultarlo**: Per capire la struttura generale della documentazione

### [docs/analysis/analisi-funzionale.md](./analysis/analisi-funzionale.md)
- **Scopo**: Requisiti funzionali, casi d'uso, modello dati
- **Quando consultarlo**: Per domande su funzionalità, requisiti, attori del sistema

## 🚀 Configurazione Progetto

### Dettagli Tecnici Importanti
- **Porta Server**: 8001 (non 8000)
- **Database**: PostgreSQL
- **Admin**: Filament
- **Stack**: Laravel, Livewire, Alpine.js, Tailwind CSS

### Struttura Directory (principale)
```
CatFriendsClub/
├── app/
├── bootstrap/
├── config/
├── database/
├── docs/
│   ├── analysis/
│   ├── deployment/
│   └── ...
├── public/
├── resources/
├── routes/
└── tests/
```

## 📝 Template Disponibili

### Per Nuove User Stories
```markdown
##### US[XXX]: [Titolo User Story]
- **Come** [tipo di utente]
- **Voglio** [obiettivo/funzionalità]
- **Così che** [beneficio/motivazione]

**Criteri di Accettazione:**
- [ ] Criterio 1
- [ ] Criterio 2
- [ ] Criterio 3

**Priorità**: Alta/Media/Bassa  
**Stima**: [Story Points]  
**Epic**: [Nome Epic]
```

### Per Nuovi Casi d'Uso
```markdown
##### UC[XX]: [Nome Caso d'Uso]
- **Attore Primario**: 
- **Precondizioni**: 
- **Flusso Principale**: 
  1. 
  2. 
  3. 
- **Flussi Alternativi**: 
- **Postcondizioni**: 
```

## 🔄 Workflow di Aggiornamento

1. **Modifica Codice** → Aggiorna documentazione tecnica
2. **Nuova Feature** → Aggiungi user story
3. **Nuovo Requisito** → Aggiorna analisi funzionale
4. **Cambio Stack** → Aggiorna framework di sviluppo

---

**Ultimo aggiornamento**: {{ date('Y-m-d') }}  
**Versione**: 1.0