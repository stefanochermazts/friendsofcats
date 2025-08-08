# Sistema di Verifica Email

Questo sistema implementa la verifica email completa per gli utenti che si registrano nell'applicazione.

## Funzionalità

### 1. Verifica Automatica
- Quando un utente si registra, riceve automaticamente una mail di verifica
- Il link di verifica è valido per 60 minuti
- Design moderno e responsive per la mail

### 2. Protezione delle Route
- Le route protette richiedono la verifica email
- Middleware personalizzato per gestire la verifica
- Reindirizzamento automatico alla pagina di verifica

### 3. Mail Personalizzata
- Template HTML moderno e responsive (`resources/views/emails/layouts/minimal.blade.php`)
- Branding: CatFriends Club
- Messaggi multilingua (IT, EN, DE, FR, ES, SL)
- Link di fallback per browser che non supportano i pulsanti

## Configurazione

### 1. Modello User
Il modello `User` implementa `MustVerifyEmail`:
```php
class User extends Authenticatable implements MustVerifyEmail
```

### 2. Mail di Verifica
- **Classe**: `App\Mail\EmailVerification`
- **Template**: `resources/views/emails/email-verification.blade.php`
- **Invio**: override in `App\Models\User::sendEmailVerificationNotification()`

### 3. Middleware
- **Classe**: `App\Http\Middleware\EnsureEmailIsVerified`
- **Alias**: `verified`

## Utilizzo

### Applicare il Middleware

Per proteggere una route che richiede email verificata:

```php
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});
```

### Verificare lo Stato

Nel codice:
```php
if ($user->hasVerifiedEmail()) {
    // Email verificata
} else {
    // Email non verificata
}
```

### Inviare Nuova Verifica

```php
$user->sendEmailVerificationNotification();
```

## Test

### Preview/Testing
- Comando preview email multilingue:
```bash
php artisan preview:multilingual-emails it
```

### Verifica Manuale

1. Registra un nuovo utente
2. Controlla la mail ricevuta
3. Clicca sul link di verifica
4. Verifica che l'utente sia marcato come verificato

## Personalizzazione

### Modifica Template Mail

Il template si trova in:
```
resources/views/emails/email-verification.blade.php
```

### Modifica Contenuto

Per modificare il contenuto della mail, edita:
```
app/Mail/EmailVerification.php
```

### Modifica Durata Link

Nel listener `SendCustomEmailVerification`, modifica:
```php
now()->addMinutes(60) // Cambia 60 con i minuti desiderati
```

## Route Disponibili

### Verifica Email
- `GET /email/verify` - Mostra la pagina di verifica
- `GET /email/verify/{id}/{hash}` - Verifica l'email
- `POST /email/verification-notification` - Invia nuova mail di verifica

### Gestione
- `POST /logout` - Logout (disponibile anche se email non verificata)

## Sicurezza

### Link Firmati
- I link di verifica sono firmati digitalmente
- Validità temporale (60 minuti)
- Protezione contro attacchi di timing

### Controlli
- Verifica dell'hash dell'email
- Controllo dell'ID utente
- Validazione della firma

## Troubleshooting

### Email non ricevuta
1. Controlla la configurazione SMTP
2. Verifica i log: `storage/logs/laravel.log`
3. Usa il comando di test

### Link non funziona
1. Verifica che non sia scaduto (60 minuti)
2. Controlla che l'URL sia completo
3. Prova a richiedere una nuova verifica

### Errore di verifica
1. Controlla che l'utente esista
2. Verifica che l'email non sia già verificata
3. Controlla i log per errori specifici

## Integrazione con Filament

Per Filament Admin, aggiungi il middleware alle route:

```php
Route::middleware(['auth', 'verified'])->group(function () {
    // Route Filament protette
});
```

## Note

- Il sistema è completamente integrato con Laravel
- Supporta le code per l'invio asincrono
- Compatibile con tutti i driver mail supportati da Laravel
- Design responsive per tutti i dispositivi 