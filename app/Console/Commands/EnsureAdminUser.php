<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class EnsureAdminUser extends Command
{
    protected $signature = 'user:ensure-admin {email=admin@catfriends.club}';

    protected $description = 'Verifica che l\'utente dato sia admin; se non lo è, lo imposta come admin.';

    public function handle(): int
    {
        $email = (string) $this->argument('email');

        /** @var User|null $user */
        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->error("Utente non trovato: {$email}");
            return self::FAILURE;
        }

        $this->line("Trovato utente #{$user->id} {$user->email} con ruolo attuale: " . ($user->role ?: '(null)'));

        if ($user->isAdmin()) {
            $this->info('L\'utente è già amministratore.');
            return self::SUCCESS;
        }

        $user->role = 'admin';
        $user->save();

        $this->info('Ruolo aggiornato a admin.');
        return self::SUCCESS;
    }
}


