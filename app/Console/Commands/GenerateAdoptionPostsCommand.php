<?php

namespace App\Console\Commands;

use App\Jobs\GenerateAdoptionPosts;
use Illuminate\Console\Command;

class GenerateAdoptionPostsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adoption:generate-posts 
                            {--max-posts=5 : Numero massimo di post da generare}
                            {--days-between=7 : Giorni di attesa tra post dello stesso gatto}
                            {--sync : Esegui il job in modo sincrono (non in coda)}
                            {--info : Mostra solo informazioni sul job senza eseguirlo}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera automaticamente post di richiesta adozione per gatti disponibili';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if ($this->option('info')) {
            $this->showJobInfo();
            return 0;
        }

        $maxPosts = (int) $this->option('max-posts');
        $daysBetween = (int) $this->option('days-between');
        $sync = $this->option('sync');

        $this->info('🤖 Avvio generazione post di adozione...');
        $this->info("📊 Parametri: max-posts={$maxPosts}, days-between={$daysBetween}");

        if ($sync) {
            $this->info('⚡ Modalità sincrona - Job eseguito immediatamente');
            
            try {
                $job = new GenerateAdoptionPosts($maxPosts, $daysBetween);
                $job->handle();
                $this->info('✅ Job completato con successo!');
            } catch (\Exception $e) {
                $this->error('❌ Errore durante l\'esecuzione del job: ' . $e->getMessage());
                return 1;
            }
        } else {
            $this->info('📋 Modalità asincrona - Job aggiunto alla coda');
            
            try {
                GenerateAdoptionPosts::dispatch($maxPosts, $daysBetween);
                $this->info('✅ Job aggiunto alla coda con successo!');
                $this->warn('⚠️  Assicurati che il queue worker sia in esecuzione: php artisan queue:work');
            } catch (\Exception $e) {
                $this->error('❌ Errore nell\'aggiunta del job alla coda: ' . $e->getMessage());
                return 1;
            }
        }

        return 0;
    }

    /**
     * Mostra informazioni sul job
     */
    private function showJobInfo(): void
    {
        $info = GenerateAdoptionPosts::getNextRunInfo();
        
        $this->info('🔍 Informazioni Job GenerateAdoptionPosts');
        $this->table(
            ['Parametro', 'Valore'],
            [
                ['Frequenza schedulata', $info['frequency']],
                ['Post massimi per esecuzione', $info['max_posts_per_run']],
                ['Giorni tra post dello stesso gatto', $info['days_between_posts']],
                ['Gatti target', $info['target_cats']],
                ['Tentativi massimi', '3'],
                ['Backoff tra tentativi', '60 secondi'],
            ]
        );

        $this->info('🛠️  Comandi disponibili:');
        $this->line('  • Esecuzione manuale:      php artisan adoption:generate-posts --sync');
        $this->line('  • Esecuzione in coda:      php artisan adoption:generate-posts');
        $this->line('  • Con parametri custom:    php artisan adoption:generate-posts --max-posts=10 --days-between=3');
        
        $this->info('📋 Per vedere lo stato della coda: php artisan queue:status');
        $this->info('🏃 Per avviare il worker:       php artisan queue:work');
    }
}