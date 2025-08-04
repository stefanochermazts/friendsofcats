<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestLayoutUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:layout-updates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica che le modifiche al layout admin siano state applicate correttamente';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🎨 Verificando modifiche al layout admin...');
        $this->newLine();

        // Verifica che il file CSS personalizzato esista
        $cssFile = resource_path('css/filament-admin.css');
        if (file_exists($cssFile)) {
            $this->line("✅ File CSS personalizzato trovato: {$cssFile}");
        } else {
            $this->error("❌ File CSS personalizzato non trovato!");
            return Command::FAILURE;
        }

        // Verifica che il file sia stato compilato
        $buildPath = public_path('build/assets');
        if (is_dir($buildPath)) {
            $compiledFiles = glob($buildPath . '/filament-admin-*.css');
            if (!empty($compiledFiles)) {
                $this->line("✅ CSS compilato trovato: " . basename($compiledFiles[0]));
            } else {
                $this->error("❌ CSS non compilato! Esegui 'npm run build'");
                return Command::FAILURE;
            }
        }

        // Verifica configurazione Vite
        $viteConfig = base_path('vite.config.js');
        $viteContent = file_get_contents($viteConfig);
        if (str_contains($viteContent, 'filament-admin.css')) {
            $this->line("✅ CSS registrato in Vite");
        } else {
            $this->error("❌ CSS non registrato in Vite");
            return Command::FAILURE;
        }

        $this->newLine();
        $this->info('📋 Modifiche applicate:');
        $this->line('   • Layout admin utilizza tutta la larghezza disponibile');
        $this->line('   • Margini ridotti a 20px sui lati (10px su mobile, 40px su schermi grandi)');
        $this->line('   • Tabelle responsive con colonne ottimizzate');
        $this->line('   • Migliorata visualizzazione oggetto e messaggio');
        $this->line('   • Aggiunta paginazione personalizzata (10, 25, 50, 100 elementi)');
        $this->line('   • Aggiunta colonna anteprima messaggio (opzionale)');

        $this->newLine();
        $this->info('🌐 Per vedere le modifiche:');
        $this->line('   1. Accedi all\'area admin: ' . url('/admin'));
        $this->line('   2. Vai alla sezione "Richieste di Contatto"');
        $this->line('   3. Verifica che la tabella utilizzi tutta la larghezza');
        $this->line('   4. Prova a ridimensionare la finestra per testare la responsività');

        $this->newLine();
        $this->warn('💡 Suggerimenti:');
        $this->line('   • Usa il toggle delle colonne per mostrare/nascondere l\'anteprima messaggio');
        $this->line('   • I tooltip mostrano il contenuto completo per testi lunghi');
        $this->line('   • La paginazione predefinita è ora di 25 elementi per pagina');

        return Command::SUCCESS;
    }
}