<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\RegistrationNotification;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestRegistrationNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:registration-notification {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the registration notification email';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $adminEmail = $this->argument('email') ?? config('mail.admin_email');
        
        if (!$adminEmail) {
            $this->error('Email dell\'amministratore non configurata. Aggiungi ADMIN_EMAIL nel file .env');
            return 1;
        }

        // Crea un utente di test o usa il primo utente esistente
        $user = User::first();
        
        if (!$user) {
            $this->error('Nessun utente trovato nel database. Crea prima un utente.');
            return 1;
        }

        try {
            Mail::to($adminEmail)->send(new RegistrationNotification($user));
            
            $this->info("✅ Mail di notifica inviata con successo a: {$adminEmail}");
            $this->info("📧 Dettagli utente: {$user->name} ({$user->email})");
            
            return 0;
        } catch (\Exception $e) {
            $this->error("❌ Errore nell'invio della mail: " . $e->getMessage());
            return 1;
        }
    }
} 