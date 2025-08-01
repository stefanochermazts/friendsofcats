# Notifica Email per Registrazioni

Questa funzionalità invia automaticamente una email di notifica ogni volta che un nuovo utente si registra nell'applicazione.

## Configurazione

### 1. Variabile d'ambiente

Aggiungi la seguente variabile nel file `.env`:

```env
ADMIN_EMAIL=admin@tuodominio.com
```

### 2. Configurazione Mail

Assicurati che la configurazione delle mail sia corretta nel file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## Funzionalità

### Mail di Notifica

- **Oggetto**: "Nuovo utente registrato - [Nome App]"
- **Contenuto**: Include i dettagli dell'utente registrato:
  - Nome
  - Email
  - Data e ora di registrazione
  - Ruolo (se presente)

### Listener

Il listener `SendRegistrationNotification` viene eseguito automaticamente quando:
- Un utente si registra tramite il form di registrazione
- L'evento `Registered` viene lanciato

### Coda

Il listener implementa `ShouldQueue`, quindi le email vengono inviate in background per non rallentare l'esperienza utente.

## Test

### Comando di Test

Per testare l'invio della mail, usa il comando:

```bash
php artisan test:registration-notification
```

Oppure specifica un'email diversa:

```bash
php artisan test:registration-notification admin@test.com
```

### Verifica Log

Se usi il driver `log` per le mail, puoi verificare i log in:
```
storage/logs/laravel.log
```

## Personalizzazione

### Modifica Template

Il template della mail si trova in:
```
resources/views/emails/registration-notification.blade.php
```

### Modifica Contenuto

Per modificare il contenuto della mail, edita la classe:
```
app/Mail/RegistrationNotification.php
```

### Disabilitare Notifica

Per disabilitare temporaneamente la notifica, rimuovi il listener dall'EventServiceProvider o commenta la riga:

```php
// SendRegistrationNotification::class,
```

## Troubleshooting

### Email non inviata

1. Verifica che `ADMIN_EMAIL` sia configurato nel `.env`
2. Controlla la configurazione delle mail
3. Verifica i log per errori
4. Usa il comando di test per verificare

### Errori di Coda

Se usi le code, assicurati che il worker sia in esecuzione:

```bash
php artisan queue:work
```

## Sicurezza

- L'email dell'amministratore è configurata tramite variabile d'ambiente
- Il listener controlla che l'email sia configurata prima di inviare
- Le email vengono inviate solo per registrazioni valide 