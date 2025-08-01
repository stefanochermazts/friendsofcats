# Setup script per FriendsOfCats Laravel Project
# Questo script configura automaticamente il progetto Laravel con PostgreSQL in Laragon

param(
    [string]$DbName = "friendsofcats",
    [string]$DbUser = "postgres",
    [string]$DbPassword = "",
    [string]$AppPort = "8001"
)

Write-Host "🐱 Configurazione del progetto FriendsOfCats..." -ForegroundColor Cyan
Write-Host "=====================================`n" -ForegroundColor Cyan

# Funzione per verificare se un comando è disponibile
function Test-Command {
    param([string]$Command)
    try {
        Get-Command $Command -ErrorAction Stop
        return $true
    }
    catch {
        return $false
    }
}

# Verifica prerequisiti
Write-Host "🔍 Verifica prerequisiti..." -ForegroundColor Yellow

if (-not (Test-Command "php")) {
    Write-Host "❌ PHP non trovato. Assicurati che Laragon sia avviato e PHP sia nel PATH." -ForegroundColor Red
    exit 1
}

if (-not (Test-Command "composer")) {
    Write-Host "❌ Composer non trovato. Installa Composer o assicurati che sia nel PATH." -ForegroundColor Red
    exit 1
}

if (-not (Test-Command "npm")) {
    Write-Host "❌ Node.js/npm non trovato. Installa Node.js." -ForegroundColor Red
    exit 1
}

Write-Host "✅ Tutti i prerequisiti sono soddisfatti`n" -ForegroundColor Green

# Installa dipendenze PHP
Write-Host "📦 Installazione dipendenze PHP..." -ForegroundColor Yellow
try {
    composer install --no-interaction --prefer-dist --optimize-autoloader
    Write-Host "✅ Dipendenze PHP installate con successo`n" -ForegroundColor Green
}
catch {
    Write-Host "❌ Errore durante l'installazione delle dipendenze PHP" -ForegroundColor Red
    exit 1
}

# Installa dipendenze Node.js
Write-Host "📦 Installazione dipendenze Node.js..." -ForegroundColor Yellow
try {
    npm install
    Write-Host "✅ Dipendenze Node.js installate con successo`n" -ForegroundColor Green
}
catch {
    Write-Host "❌ Errore durante l'installazione delle dipendenze Node.js" -ForegroundColor Red
    exit 1
}

# Crea file .env se non esiste
if (-not (Test-Path ".env")) {
    Write-Host "⚙️ Creazione file .env..." -ForegroundColor Yellow
    
    if (Test-Path ".env.example") {
        Copy-Item ".env.example" ".env"
    } else {
        # Crea un file .env di base se .env.example non esiste
        @"
APP_NAME="FriendsOfCats"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost:$AppPort

APP_LOCALE=it
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=it_IT

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=$DbName
DB_USERNAME=$DbUser
DB_PASSWORD=$DbPassword

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
"@ | Out-File -FilePath ".env" -Encoding UTF8
    }
    
    Write-Host "✅ File .env creato`n" -ForegroundColor Green
} else {
    Write-Host "ℹ️ File .env già esistente, saltato`n" -ForegroundColor Blue
}

# Genera chiave applicazione
Write-Host "🔑 Generazione chiave applicazione..." -ForegroundColor Yellow
try {
    php artisan key:generate --force
    Write-Host "✅ Chiave applicazione generata`n" -ForegroundColor Green
}
catch {
    Write-Host "❌ Errore durante la generazione della chiave" -ForegroundColor Red
    exit 1
}

# Verifica connessione database
Write-Host "🗄️ Verifica connessione database PostgreSQL..." -ForegroundColor Yellow
$dbExists = $false
try {
    # Tenta di connettersi al database
    $result = php artisan tinker --execute="try { \DB::connection()->getPdo(); echo 'connected'; } catch(Exception \$e) { echo 'failed: ' . \$e->getMessage(); }" 2>$null
    if ($result -match "connected") {
        $dbExists = $true
        Write-Host "✅ Connessione al database riuscita`n" -ForegroundColor Green
    } else {
        Write-Host "⚠️ Impossibile connettersi al database. Verifica che:" -ForegroundColor Yellow
        Write-Host "   - Laragon sia avviato" -ForegroundColor Yellow
        Write-Host "   - PostgreSQL sia attivo" -ForegroundColor Yellow
        Write-Host "   - Il database '$DbName' esista" -ForegroundColor Yellow
        Write-Host "   - Le credenziali nel file .env siano corrette`n" -ForegroundColor Yellow
    }
}
catch {
    Write-Host "⚠️ Impossibile verificare la connessione al database`n" -ForegroundColor Yellow
}

# Esegui migrazioni se il database è connesso
if ($dbExists) {
    Write-Host "🏗️ Esecuzione migrazioni database..." -ForegroundColor Yellow
    try {
        php artisan migrate --force
        Write-Host "✅ Migrazioni completate`n" -ForegroundColor Green
    }
    catch {
        Write-Host "⚠️ Errore durante le migrazioni. Controlla la configurazione del database`n" -ForegroundColor Yellow
    }
} else {
    Write-Host "⏭️ Migrazioni saltate - configura prima il database`n" -ForegroundColor Yellow
}

# Installa Breeze se non già installato
Write-Host "🎨 Configurazione Laravel Breeze..." -ForegroundColor Yellow
try {
    php artisan breeze:install blade --dark
    Write-Host "✅ Laravel Breeze configurato`n" -ForegroundColor Green
}
catch {
    Write-Host "ℹ️ Laravel Breeze già configurato o errore durante l'installazione`n" -ForegroundColor Blue
}

# Ottimizza per lo sviluppo
Write-Host "⚡ Ottimizzazioni per sviluppo..." -ForegroundColor Yellow
try {
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
    php artisan cache:clear
    Write-Host "✅ Cache pulite`n" -ForegroundColor Green
}
catch {
    Write-Host "⚠️ Errore durante la pulizia delle cache`n" -ForegroundColor Yellow
}

# Compila assets
Write-Host "🎨 Compilazione assets frontend..." -ForegroundColor Yellow
try {
    npm run build
    Write-Host "✅ Assets compilati per produzione`n" -ForegroundColor Green
}
catch {
    Write-Host "⚠️ Errore durante la compilazione degli assets`n" -ForegroundColor Yellow
}

# Crea storage link
Write-Host "🔗 Creazione link storage..." -ForegroundColor Yellow
try {
    php artisan storage:link
    Write-Host "✅ Link storage creato`n" -ForegroundColor Green
}
catch {
    Write-Host "ℹ️ Link storage già esistente o errore durante la creazione`n" -ForegroundColor Blue
}

# Riepilogo finale
Write-Host "=====================================`n" -ForegroundColor Cyan
Write-Host "🎉 Setup completato!" -ForegroundColor Green
Write-Host "`nPer avviare il progetto:" -ForegroundColor White
Write-Host "  composer run dev" -ForegroundColor Yellow
Write-Host "`nIl server sarà disponibile su:" -ForegroundColor White
Write-Host "  http://localhost:$AppPort" -ForegroundColor Yellow

if (-not $dbExists) {
    Write-Host "`n⚠️ IMPORTANTE: Configura il database PostgreSQL in Laragon:" -ForegroundColor Red
    Write-Host "  1. Avvia Laragon" -ForegroundColor Yellow
    Write-Host "  2. Avvia PostgreSQL" -ForegroundColor Yellow
    Write-Host "  3. Crea il database '$DbName'" -ForegroundColor Yellow
    Write-Host "  4. Esegui: php artisan migrate" -ForegroundColor Yellow
}

Write-Host "`n🐱 Buon sviluppo con FriendsOfCats!" -ForegroundColor Cyan