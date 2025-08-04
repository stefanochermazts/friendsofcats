<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CheckFilamentCSS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:filament-css';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verifica che il CSS personalizzato sia caricato nella pagina admin';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🔍 Verificando caricamento CSS nella pagina admin...');
        $this->newLine();

        try {
            // Tenta di fare una richiesta alla dashboard admin
            $response = Http::timeout(10)->get(url('/admin'));
            
            if ($response->successful()) {
                $body = $response->body();
                
                if (str_contains($body, 'FriendsOfCats Admin Styles - Loaded Successfully')) {
                    $this->line('✅ CSS personalizzato caricato nella pagina');
                    
                    // Verifica se contiene alcuni stili specifici
                    if (str_contains($body, '.fi-main')) {
                        $this->line('✅ Stili di layout trovati');
                    }
                    
                    if (str_contains($body, 'max-width: none !important')) {
                        $this->line('✅ Override di larghezza massima applicato');
                    }
                    
                    $this->newLine();
                    $this->info('🎉 Gli stili personalizzati sono correttamente caricati!');
                    
                } else {
                    $this->warn('⚠️  CSS personalizzato non trovato nella pagina');
                    $this->line('   Potrebbe essere necessario effettuare il login admin');
                }
                
            } else {
                $this->warn('⚠️  Non riesco ad accedere alla pagina admin (login richiesto)');
                $this->line('   Codice di stato: ' . $response->status());
            }
            
        } catch (\Exception $e) {
            $this->error('❌ Errore nel controllo della pagina: ' . $e->getMessage());
        }

        $this->newLine();
        $this->info('📋 Passaggi per verificare manualmente:');
        $this->line('   1. Vai su: ' . url('/admin'));
        $this->line('   2. Apri Strumenti Sviluppatore (F12)');
        $this->line('   3. Cerca "FriendsOfCats Admin Styles" nel codice HTML');
        $this->line('   4. Verifica che gli stili .fi-main siano presenti');

        $this->newLine();
        $this->warn('💡 Se gli stili non si applicano:');
        $this->line('   • Ricarica con Ctrl+F5 (svuota cache browser)');
        $this->line('   • Verifica che non ci siano errori JavaScript');
        $this->line('   • Controlla che il render hook sia registrato');

        return Command::SUCCESS;
    }
}