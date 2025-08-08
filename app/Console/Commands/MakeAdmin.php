<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Usage examples:
     *  php artisan user:make-admin user@example.com --name="Admin" --password="secret123"
     *  php artisan user:make-admin user@example.com --set-password="newStrongPass!"  (promuove ed eventualmente resetta la password)
     *
     * Note: se non passi --password/--set-password, la password esistente rimane invariata.
     *       Se l'utente non esiste e non passi --password, verrà generata una password sicura casuale.
     */
    protected $signature = 'user:make-admin {email : Email dell\'utente}
                                        {--name= : Nome da assegnare (opzionale)}
                                        {--password= : Password da usare in creazione (se nuovo utente)}
                                        {--set-password= : Nuova password da impostare anche se l\'utente esiste}';

    /**
     * The console command description.
     */
    protected $description = 'Crea o promuove un utente a admin in modo sicuro (produzione-ready)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $rawEmail = trim((string) $this->argument('email'));
        $email = strtolower($rawEmail);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Email non valida: ' . $rawEmail);
            return self::FAILURE;
        }

        $nameOption = $this->option('name');
        $createPasswordOption = $this->option('password');
        $setPasswordOption = $this->option('set-password');

        $user = User::where('email', $email)->first();

        if ($user) {
            // Promuovi utente esistente
            $wasAdmin = $user->role === 'admin';
            $originalRole = $user->role ?? '(null)';

            if (!empty($nameOption)) {
                $user->name = (string) $nameOption;
            }

            $user->role = 'admin';

            if ($user->email_verified_at === null) {
                $user->email_verified_at = Carbon::now();
            }

            $newPasswordDisplayed = null;
            if (!empty($setPasswordOption)) {
                $user->password = Hash::make((string) $setPasswordOption);
                $newPasswordDisplayed = (string) $setPasswordOption;
            }

            $user->save();

            $this->info('Utente aggiornato con successo.');
            $this->line(' - ID: ' . $user->id);
            $this->line(' - Email: ' . $user->email);
            $this->line(' - Nome: ' . $user->name);
            $this->line(' - Ruolo precedente: ' . $originalRole);
            $this->line(' - Ruolo attuale: ' . $user->role);
            $this->line(' - Email verificata: ' . ($user->email_verified_at ? 'sì' : 'no'));
            if ($newPasswordDisplayed !== null) {
                $this->warn(' - Password RESETTATA a: ' . $newPasswordDisplayed);
            } elseif ($wasAdmin) {
                $this->line(' - L\'utente era già admin; nessun reset password eseguito.');
            }

            $this->line('Login admin: ' . url('/admin'));
            return self::SUCCESS;
        }

        // Crea nuovo utente admin
        $name = !empty($nameOption)
            ? (string) $nameOption
            : ucfirst(strtok($email, '@'));

        $passwordToUse = (string) ($createPasswordOption ?: Str::password(16));

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($passwordToUse);
        $user->role = 'admin';
        $user->email_verified_at = Carbon::now();
        $user->save();

        $this->info('Utente admin creato con successo.');
        $this->line(' - ID: ' . $user->id);
        $this->line(' - Email: ' . $user->email);
        $this->line(' - Nome: ' . $user->name);
        $this->warn(' - Password: ' . $passwordToUse);
        $this->line('Login admin: ' . url('/admin'));

        return self::SUCCESS;
    }
}


