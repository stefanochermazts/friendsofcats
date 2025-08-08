<?php

namespace App\Jobs;

use App\Models\Cat;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateAdoptionPosts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Numero massimo di post da generare per esecuzione
     */
    private int $maxPostsPerRun;

    /**
     * Giorni di attesa prima di ricreare un post per lo stesso gatto
     */
    private int $daysBetweenPosts;

    /**
     * Create a new job instance.
     */
    public function __construct(int $maxPostsPerRun = 5, int $daysBetweenPosts = 7)
    {
        $this->maxPostsPerRun = $maxPostsPerRun;
        $this->daysBetweenPosts = $daysBetweenPosts;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('🤖 Avvio generazione automatica post di adozione', [
            'max_posts' => $this->maxPostsPerRun,
            'days_between' => $this->daysBetweenPosts
        ]);

        try {
            // Trova gatti disponibili per adozione che non hanno avuto post recenti
            $eligibleCats = Cat::with(['user'])
                ->where('disponibile_adozione', true)
                ->whereHas('user', function ($query) {
                    // Solo gatti di utenti attivi
                    $query->whereNotNull('email_verified_at');
                })
                ->whereDoesntHave('posts', function ($query) {
                    $query->where('type', 'adoption_request')
                          ->where('created_at', '>', now()->subDays($this->daysBetweenPosts));
                })
                ->inRandomOrder()
                ->limit($this->maxPostsPerRun)
                ->get();

            if ($eligibleCats->isEmpty()) {
                Log::info('🐱 Nessun gatto eleggibile per nuovi post di adozione');
                return;
            }

            $createdPosts = 0;

            foreach ($eligibleCats as $cat) {
                try {
                    $post = Post::createAdoptionRequest($cat);
                    $createdPosts++;

                    Log::info('✅ Post di adozione creato', [
                        'cat_id' => $cat->id,
                        'cat_name' => $cat->nome,
                        'post_id' => $post->id,
                        'user_name' => $cat->user->name ?? 'Unknown'
                    ]);

                } catch (\Exception $e) {
                    Log::error('❌ Errore nella creazione post per gatto', [
                        'cat_id' => $cat->id,
                        'cat_name' => $cat->nome,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            Log::info('🎉 Generazione post di adozione completata', [
                'posts_created' => $createdPosts,
                'cats_processed' => $eligibleCats->count()
            ]);

        } catch (\Exception $e) {
            Log::error('💥 Errore generale nel job GenerateAdoptionPosts', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e; // Re-throw per permettere retry del job se configurato
        }
    }

    /**
     * Calcola il prossimo orario di esecuzione (per informazioni)
     */
    public static function getNextRunInfo(): array
    {
        return [
            'frequency' => 'Daily at 10:00 AM',
            'max_posts_per_run' => 5,
            'days_between_posts' => 7,
            'target_cats' => 'Available for adoption, verified users only'
        ];
    }

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $backoff = 60;
}