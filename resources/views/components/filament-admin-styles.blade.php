<!-- FriendsOfCats Admin Styles - Loaded Successfully -->
<style>
/* Personalizzazioni CSS per l'area Admin di Filament */

/* Rimuove i margini laterali eccessivi e utilizza tutta la larghezza disponibile */
.fi-main {
    max-width: none !important;
    padding-left: 20px !important;
    padding-right: 20px !important;
}

/* Contenitore principale delle pagine */
.fi-page {
    max-width: none !important;
    width: 100% !important;
}

/* Contenuto principale delle risorse */
.fi-resource-page {
    max-width: none !important;
}

/* Tabelle - utilizza tutta la larghezza disponibile */
.fi-ta {
    width: 100% !important;
}

/* Container dei widget */
.fi-wi-stats-overview {
    max-width: none !important;
}

/* Sezioni dei form */
.fi-fo-section {
    max-width: none !important;
}

/* Layout delle pagine di dettaglio */
.fi-resource-view-page,
.fi-resource-edit-page,
.fi-resource-create-page {
    max-width: none !important;
}

/* Container principale del panel */
.fi-panel-app > div > main {
    max-width: none !important;
    padding-left: 20px !important;
    padding-right: 20px !important;
}

/* Override specifico per i contenitori di layout */
[data-theme="light"] .fi-main,
[data-theme="dark"] .fi-main {
    max-width: calc(100vw - 40px) !important;
    margin-left: auto !important;
    margin-right: auto !important;
}

/* Assicura che le tabelle siano responsive */
.fi-ta-table {
    width: 100% !important;
    table-layout: auto !important;
}

/* Migliora la visualizzazione delle colonne della tabella */
.fi-ta-cell {
    padding: 12px 8px !important;
}

/* Colonne con testo lungo - permettono wrapping */
.fi-ta-cell[data-column="message"],
.fi-ta-cell[data-column="subject"] {
    white-space: normal !important;
    max-width: 350px !important;
    line-height: 1.4 !important;
}

/* Colonne con testo breve */
.fi-ta-cell[data-column="name"] {
    min-width: 150px !important;
    max-width: 200px !important;
}

.fi-ta-cell[data-column="email"] {
    min-width: 200px !important;
    max-width: 250px !important;
}

.fi-ta-cell[data-column="status"] {
    min-width: 100px !important;
    text-align: center !important;
}

.fi-ta-cell[data-column="created_at"],
.fi-ta-cell[data-column="read_at"] {
    min-width: 140px !important;
    white-space: nowrap !important;
}

/* Layout responsive per schermi più piccoli */
@media (max-width: 768px) {
    .fi-main {
        padding-left: 10px !important;
        padding-right: 10px !important;
    }
    
    .fi-panel-app > div > main {
        padding-left: 10px !important;
        padding-right: 10px !important;
    }
    
    [data-theme="light"] .fi-main,
    [data-theme="dark"] .fi-main {
        max-width: calc(100vw - 20px) !important;
    }
}

/* Layout per schermi molto grandi */
@media (min-width: 1920px) {
    .fi-main {
        padding-left: 40px !important;
        padding-right: 40px !important;
    }
    
    .fi-panel-app > div > main {
        padding-left: 40px !important;
        padding-right: 40px !important;
    }
}

/* Ottimizzazioni per la visualizzazione delle statistiche */
.fi-wi-stats-overview .fi-wi-stats-overview-stat {
    flex: 1 !important;
    min-width: 0 !important;
}

/* Migliora la visualizzazione dei filtri */
.fi-ta-filters {
    width: 100% !important;
}

/* Assicura che i modali mantengano dimensioni appropriate */
.fi-modal {
    max-width: min(90vw, 1200px) !important;
}
</style>