<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\EmailVerification;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class TestEmailVerification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email-verification {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the email verification email';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->argument('email');
        
        if (!$email) {
            $this->error('Specifica un indirizzo email come parametro');
            $this->info('Esempio: php artisan test:email-verification user@example.com');
            return 1;
        }

        // Cerca l'utente o crea un utente di test
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->warn("Utente con email {$email} non trovato. Creo un utente di test...");
            $user = User::create([
                'name' => 'Utente Test',
                'email' => $email,
                'password' => bcrypt('password'),
            ]);
        }

        try {
            // Genera l'URL di verifica
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(60),
                [
                    'id' => $user->getKey(),
                    'hash' => sha1($user->getEmailForVerification()),
                ]
            );

            // Invia la mail di verifica
            Mail::to($user->email)->send(new EmailVerification(
                verificationUrl: $verificationUrl,
                userName: $user->name
            ));
            
            $this->info("✅ Mail di verifica inviata con successo a: {$email}");
            $this->info("📧 Nome utente: {$user->name}");
            $this->info("🔗 URL di verifica: {$verificationUrl}");
            
            return 0;
        } catch (\Exception $e) {
            $this->error("❌ Errore nell'invio della mail: " . $e->getMessage());
            return 1;
        }
    }
} 