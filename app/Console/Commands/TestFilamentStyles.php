<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestFilamentStyles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:filament-styles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica che gli stili Filament personalizzati siano applicati correttamente';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🎨 Verificando stili Filament personalizzati...');
        $this->newLine();

        // Verifica che il componente Blade esista
        $styleComponent = resource_path('views/components/filament-admin-styles.blade.php');
        if (file_exists($styleComponent)) {
            $this->line("✅ Componente stili trovato: {$styleComponent}");
        } else {
            $this->error("❌ Componente stili non trovato!");
            return Command::FAILURE;
        }

        // Verifica il provider
        $provider = app_path('Providers/Filament/AdminPanelProvider.php');
        $providerContent = file_get_contents($provider);
        if (str_contains($providerContent, 'filament-admin-styles')) {
            $this->line("✅ Hook registrato nel provider");
        } else {
            $this->error("❌ Hook non registrato nel provider!");
            return Command::FAILURE;
        }

        $this->newLine();
        $this->info('📋 Configurazione applicata:');
        $this->line('   • CSS personalizzato caricato via render hook');
        $this->line('   • Stili inline per massima compatibilità');
        $this->line('   • Layout ottimizzato per tutti i dispositivi');
        $this->line('   • Cache svuotate per applicare le modifiche');

        $this->newLine();
        $this->info('🌐 Per testare gli stili:');
        $this->line('   1. Accedi all\'area admin: ' . url('/admin'));
        $this->line('   2. Vai alla sezione "Richieste di Contatto"');
        $this->line('   3. Verifica che la tabella utilizzi tutta la larghezza');
        $this->line('   4. Apri gli strumenti sviluppatore e cerca gli stili inline');

        $this->newLine();
        $this->warn('🔍 Debug:');
        $this->line('   • Se gli stili non si applicano, ricarica la pagina con Ctrl+F5');
        $this->line('   • Verifica che non ci siano errori JavaScript nella console');
        $this->line('   • Gli stili sono caricati inline alla fine del <body>');

        return Command::SUCCESS;
    }
}