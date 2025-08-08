# Sistema Multilingue - CatFriends.club

## Panoramica

Il sistema multilingue di CatFriends.club supporta 5 lingue:
- **Italiano (it)** - Lingua predefinita
- **Inglese (en)**
- **Francese (fr)**
- **Tedesco (de)**
- **Spagnolo (es)**

## Funzionalità Implementate

### 1. Dashboard Multilingue

**File di traduzione creati:**
- `lang/it/dashboard.php`
- `lang/en/dashboard.php`
- `lang/fr/dashboard.php`
- `lang/de/dashboard.php`
- `lang/es/dashboard.php`

**Contenuti tradotti:**
- Titoli delle dashboard per ogni ruolo
- Descrizioni dei ruoli
- Statistiche e metriche
- Messaggi di successo/errore
- Elementi di navigazione
- Menu utente

### 2. Selezione Ruoli Multilingue

**File di traduzione:**
- Utilizza i file `dashboard.php` per le traduzioni

**Contenuti tradotti:**
- Titolo della pagina di selezione
- Nomi dei ruoli
- Descrizioni dei ruoli
- Attività specifiche per ruolo
- Pulsanti e azioni

### 3. Email Multilingue

**File di traduzione creati:**
- `resources/lang/it/emails.php`
- `resources/lang/en/emails.php`
- `resources/lang/fr/emails.php`
- `resources/lang/de/emails.php`
- `resources/lang/es/emails.php`

**Layout Email:**
- **Layout minimal**: Design pulito con bordo nero e sfondo bianco
- **Logo SVG**: Gatto stilizzato in alto a sinistra
- **Tipografia pulita**: Font leggibili e spaziatura ottimale
- **Design responsive**: Adattabile a dispositivi mobili

**Email supportate:**
- **Email di verifica**: Invio automatico dopo registrazione
- **Notifica registrazione admin**: Notifica automatica agli amministratori

**Contenuti tradotti:**
- Oggetti delle email
- Messaggi di benvenuto
- Istruzioni di verifica
- Note di sicurezza
- Informazioni utente
- Testi di footer

### 4. Pagina di Verifica Email Multilingue

**File di traduzione creati:**
- `resources/lang/it/verification.php`
- `resources/lang/en/verification.php`
- `resources/lang/fr/verification.php`
- `resources/lang/de/verification.php`
- `resources/lang/es/verification.php`

**Contenuti tradotti:**
- Titoli e sottotitoli
- Messaggi di verifica
- Pulsanti e azioni
- Note informative
- Messaggi di errore

### 5. Pagina Contatti Multilingue

**File di traduzione creati:**
- `resources/lang/it/contact.php`
- `resources/lang/en/contact.php`
- `resources/lang/fr/contact.php`
- `resources/lang/de/contact.php`
- `resources/lang/es/contact.php`

**Contenuti tradotti:**
- Titoli e sottotitoli
- Informazioni di contatto
- Campi del form
- Messaggi di validazione
- Messaggi di successo/errore

## Gestione della Lingua

### Salvataggio della Lingua Utente

**Modifiche al modello User:**
- Aggiunto campo `locale` al modello User
- Campo aggiunto a `$fillable`
- Migrazione creata per aggiungere la colonna `locale`

**Registrazione utente:**
- La lingua corrente viene salvata durante la registrazione
- Default: italiano (`it`)

### Invio Email nella Lingua Corretta

**Listener aggiornati:**
- `SendCustomEmailVerification`: Usa la lingua salvata nell'utente
- `SendRegistrationNotification`: Usa la lingua salvata nell'utente

**Logica:**
1. Recupera la lingua dall'utente (`$user->locale`)
2. Imposta la lingua per l'applicazione (`app()->setLocale($locale)`)
3. Invia l'email con le traduzioni corrette

## Comandi di Test

### Test Email Multilingue
```bash
php artisan test:multilingual-emails {locale}
```

**Esempi:**
```bash
php artisan test:multilingual-emails it
php artisan test:multilingual-emails en
php artisan test:multilingual-emails fr
php artisan test:multilingual-emails de
php artisan test:multilingual-emails es
```

### Preview Email Layout
```bash
php artisan preview:email-layout {locale}
```

### Preview Email Contenuto
```bash
php artisan preview:multilingual-emails {locale}
```

### Aggiornamento Lingua Utenti Esistenti
```bash
php artisan users:update-locale {locale}
```

## Struttura dei File di Traduzione

### Dashboard (`dashboard.php`)
```php
return [
    'dashboard' => 'Dashboard',
    'welcome' => 'Benvenuto su',
    'associazione' => 'Associazione',
    'associazione_desc' => 'Rifugio, ONLUS, associazione animalista',
    'associazione_activities' => 'Gestisci gatti in adozione, volontari e attività di sensibilizzazione',
    // ... altre traduzioni
];
```

### Email (`emails.php`)
```php
return [
    'verification' => [
        'subject' => 'Verifica il tuo indirizzo email - :app_name',
        'welcome' => '🎉 Benvenuto su :app_name!',
        'greeting' => 'Ciao :name,',
        // ... altre traduzioni
    ],
    'registration_notification' => [
        'subject' => 'Nuovo utente registrato - :app_name',
        'title' => '🎉 Nuovo utente registrato!',
        // ... altre traduzioni
    ],
];
```

### Verifica (`verification.php`)
```php
return [
    'verify_email' => 'Verifica Email',
    'verify_email_address' => 'Verifica il tuo indirizzo email',
    'verification_message' => 'Grazie per esserti registrato!...',
    // ... altre traduzioni
];
```

## Utilizzo delle Traduzioni

### Nei Template Blade
```php
{{ __('dashboard.dashboard') }}
{{ __('emails.verification.welcome', ['app_name' => $appName]) }}
{{ __('verification.verify_email') }}
```

### Nei Controller
```php
return back()->with('success', __('dashboard.role_saved_success'));
return back()->withErrors(['role' => __('dashboard.role_save_error')]);
```

## Note Tecniche

### Posizione File di Traduzione
- I file di traduzione devono essere in `resources/lang/{locale}/`
- Laravel cerca automaticamente le traduzioni in questa directory
- I file devono seguire la convenzione `{nome}.php`

### Middleware di Lingua
- `SetLocale`: Gestisce la lingua basata su parametri URL e sessione
- `AuthLocale`: Forza l'italiano per le route di autenticazione

### Gestione Sessione
- La lingua viene salvata in sessione (`Session::put('locale', $locale)`)
- Recuperata durante la registrazione per salvare nell'utente

### Helper EmailTranslations
- Gestisce il caricamento delle traduzioni per le email
- Forza il caricamento manuale delle traduzioni quando necessario
- Gestisce le sostituzioni di placeholder nelle traduzioni

### Fallback
- Se la lingua non è disponibile, viene usato l'italiano come default
- Le traduzioni mancanti mostrano la chiave di traduzione

## Test e Verifica

1. **Test registrazione con diverse lingue:**
   - Cambia lingua dal selettore
   - Registra un nuovo utente
   - Verifica che le email siano nella lingua corretta

2. **Test dashboard multilingue:**
   - Accedi con utenti esistenti
   - Cambia lingua
   - Verifica che tutto il contenuto sia tradotto

3. **Test email multilingue:**
   - Usa il comando `test:multilingual-emails`
   - Verifica le email inviate

## Manutenzione

### Aggiungere Nuove Traduzioni
1. Aggiungi le chiavi ai file di traduzione appropriati
2. Usa le chiavi nei template/controller
3. Testa con diverse lingue

### Aggiungere Nuove Lingue
1. Crea i file di traduzione per la nuova lingua
2. Aggiungi la lingua al middleware `SetLocale`
3. Aggiorna i controlli di validazione

### Aggiornare Traduzioni Esistenti
1. Modifica i file di traduzione
2. Pulisci la cache: `php artisan cache:clear`
3. Testa le modifiche 