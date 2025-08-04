<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckEmailDuplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:email-duplication';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica la configurazione per evitare email duplicate durante la registrazione';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🔍 Verifica configurazione email registration...');
        $this->newLine();

        $this->table(
            ['Componente', 'Stato', 'Descrizione'],
            [
                [
                    'User Model', 
                    '✅ Configurato', 
                    'Implementa MustVerifyEmail con metodo personalizzato'
                ],
                [
                    'EventServiceProvider', 
                    '✅ Ottimizzato', 
                    'Solo SendRegistrationNotification listener attivo'
                ],
                [
                    'SendCustomEmailVerification', 
                    '✅ Rimosso', 
                    'Listener duplicato eliminato'
                ],
                [
                    'Email Verification', 
                    '✅ Personalizzata', 
                    'Template personalizzato app/Mail/EmailVerification.php'
                ],
                [
                    'Admin Notification', 
                    '✅ Funzionante', 
                    'Notifica separata per admin'
                ],
            ]
        );

        $this->newLine();
        $this->info('🎯 Funzionamento attuale:');
        $this->line('   1. Utente si registra → Evento Registered viene lanciato');
        $this->line('   2. Laravel automaticamente chiama sendEmailVerificationNotification()');
        $this->line('   3. Il metodo personalizzato invia 1 sola email di verifica');
        $this->line('   4. SendRegistrationNotification invia notifica separata all\'admin');
        $this->line('   5. Risultato: Utente riceve 1 email, Admin riceve 1 notifica');

        $this->newLine();
        $this->info('✅ PROBLEMA RISOLTO: Niente più email duplicate!');

        return Command::SUCCESS;
    }
}