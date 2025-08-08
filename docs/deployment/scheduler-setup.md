# Setup Scheduler Laravel in Produzione

## 🎯 Panoramica

Il sistema CatFriends.club utilizza un job schedulato per generare automaticamente post di richiesta adozione nel Catbook. Questa guida spiega come configurare lo scheduler in produzione.

## 📋 Componenti del Sistema

### 1. **Job**: `GenerateAdoptionPosts`
- **File**: `app/Jobs/GenerateAdoptionPosts.php`
- **Funzione**: Genera automaticamente post di richiesta adozione per gatti disponibili
- **Parametri configurabili**:
  - `maxPostsPerRun`: Numero massimo di post per esecuzione (default: 5)
  - `daysBetweenPosts`: Giorni di attesa tra post dello stesso gatto (default: 7)

### 2. **Command**: `GenerateAdoptionPostsCommand`
- **File**: `app/Console/Commands/GenerateAdoptionPostsCommand.php`
- **Signature**: `adoption:generate-posts`
- **Funzione**: Wrapper per eseguire il job manualmente o in coda

### 3. **Scheduler Configuration**
- **File**: `routes/console.php`
- **Frequenza**: Quotidiana alle 10:00
- **Comando**: `adoption:generate-posts --max-posts=5 --days-between=7`

## 🚀 Setup in Produzione

### 1. **Configurazione Cron (Server Linux/Ubuntu)**

Aggiungi questa riga al crontab del server:

```bash
# Apri crontab
sudo crontab -e

# Aggiungi questa riga (sostituisci il path con quello corretto)
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

**Importante**: Il cron deve essere configurato per eseguire `schedule:run` ogni minuto. Laravel gestirà internamente quando eseguire i task schedulati.

### 2. **Verifica Path Corretti**

```bash
# Verifica che il path sia corretto
which php
# Output esempio: /usr/bin/php

# Testa il comando
cd /path/to/your/project
php artisan schedule:list
```

### 3. **Configurazione Supervisor (Raccomandato per Queue)**

Se usi code asincrone, configura Supervisor:

```ini
# File: /etc/supervisor/conf.d/laravel-worker.conf
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/project/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path/to/your/project/storage/logs/worker.log
stopwaitsecs=3600
```

```bash
# Ricarica configurazione
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

### 4. **Setup su Server Windows (IIS)**

Per server Windows, usa Task Scheduler:

1. Apri **Task Scheduler**
2. Crea **Basic Task**
3. Configura trigger: **Daily** ogni minuto
4. Action: **Start a program**
   - Program: `C:\php\php.exe`
   - Arguments: `artisan schedule:run`
   - Start in: `C:\path\to\your\project`

### 5. **Setup su Shared Hosting**

Se usi hosting condiviso che supporta cron:

```bash
# Aggiungi al cPanel Cron Jobs
* * * * * /usr/local/bin/php /home/username/public_html/artisan schedule:run
```

### 6. **Setup su Docker**

Nel `docker-compose.yml`:

```yaml
services:
  scheduler:
    build: .
    volumes:
      - ./:/var/www/html
    command: ["php", "artisan", "schedule:work"]
    depends_on:
      - app
      - database
```

## 🔧 Comandi di Gestione

### Comandi Disponibili

```bash
# Visualizza informazioni sul job
php artisan adoption:generate-posts --info

# Esecuzione manuale immediata
php artisan adoption:generate-posts --sync

# Esecuzione in coda (richiede queue worker)
php artisan adoption:generate-posts

# Con parametri personalizzati
php artisan adoption:generate-posts --max-posts=10 --days-between=3

# Visualizza scheduler configurati
php artisan schedule:list

# Test esecuzione scheduler (per debug)
php artisan schedule:run
```

### Monitoraggio e Debug

```bash
# Controlla i log dello scheduler
tail -f storage/logs/laravel.log | grep "GenerateAdoptionPosts"

# Controlla lo stato della coda
php artisan queue:status

# Visualizza job falliti
php artisan queue:failed

# Riprova job falliti
php artisan queue:retry all
```

## ⚠️ Considerazioni Importanti

### 1. **Timezone**
Assicurati che il server abbia il timezone corretto:

```bash
# Controlla timezone
php artisan tinker --execute="echo config('app.timezone')"

# Nel file .env
APP_TIMEZONE=Europe/Rome
```

### 2. **Permissions**
Verifica i permessi:

```bash
# Il web server deve poter scrivere nei log
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

### 3. **Database Connection**
Il job richiede connessione al database:

```bash
# Testa connessione
php artisan tinker --execute="DB::connection()->getPdo(); echo 'DB OK';"
```

### 4. **Memory Limits**
Per job con molti dati:

```ini
# Nel php.ini
memory_limit = 256M
max_execution_time = 300
```

## 📊 Monitoring in Produzione

### 1. **Setup Notifiche**

Modifica `routes/console.php` per aggiungere notifiche:

```php
Schedule::command('adoption:generate-posts --max-posts=5 --days-between=7')
    ->dailyAt('10:00')
    ->withoutOverlapping()
    ->onSuccess(function () {
        // Invia notifica di successo (opzionale)
        Log::info('✅ Job adozione completato con successo');
    })
    ->onFailure(function () {
        // Invia email di alert admin
        Mail::to(config('mail.admin_email'))->send(new JobFailedNotification());
        Log::error('❌ Job adozione fallito - Alert inviato');
    });
```

### 2. **Health Check**

Crea un endpoint per verificare lo stato:

```php
// In routes/web.php
Route::get('/health/scheduler', function () {
    $lastRun = Cache::get('last_adoption_job_run');
    $isHealthy = $lastRun && $lastRun > now()->subHours(25);
    
    return response()->json([
        'status' => $isHealthy ? 'healthy' : 'error',
        'last_run' => $lastRun,
        'next_run' => now()->setTime(10, 0)->addDay(),
    ]);
});
```

## 🔄 Backup e Rollback

Se hai problemi, puoi sempre:

1. **Disattivare temporaneamente**:
   ```bash
   # Commenta la riga nel routes/console.php
   // Schedule::command('adoption:generate-posts ...
   ```

2. **Tornare al sistema precedente**:
   ```bash
   # Ripristina il metodo nel CatBookController se necessario
   ```

3. **Esecuzione manuale**:
   ```bash
   # Esegui manualmente quando serve
   php artisan adoption:generate-posts --sync
   ```

## 📞 Troubleshooting

### Problema: Scheduler non si esegue
- ✅ Controlla se il cron è configurato
- ✅ Verifica i path nel crontab
- ✅ Controlla i permessi dei file
- ✅ Verifica il timezone

### Problema: Job fallisce
- ✅ Controlla i log in `storage/logs/laravel.log`
- ✅ Verifica la connessione al database
- ✅ Controlla i limiti di memoria
- ✅ Testa con `--sync` per debug immediato

### Problema: Performance lenta
- ✅ Riduci `--max-posts`
- ✅ Aumenta `--days-between`
- ✅ Ottimizza le query del database
- ✅ Aggiungi indici se necessario

---

**Supporto**: Per problemi contatta il team di sviluppo con i log del comando `php artisan adoption:generate-posts --info`
