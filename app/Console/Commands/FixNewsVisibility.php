<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\News;
use Illuminate\Console\Command;

class FixNewsVisibility extends Command
{
    protected $signature = 'fix:news-visibility';

    protected $description = 'Imposta published_at per news pubblicate senza data e mostra riepilogo';

    public function handle(): int
    {
        $fixedNull = News::where('is_published', true)
            ->whereNull('published_at')
            ->update(['published_at' => now()]);
        $this->info("News fixate (published_at NULL -> now): {$fixedNull}");

        $fixedFuture = News::where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '>', now())
            ->update(['published_at' => now()]);
        $this->info("News fixate (published_at futura -> now): {$fixedFuture}");

        $published = News::published()->count();
        $this->info("Totale news pubblicate: {$published}");
        
        return self::SUCCESS;
    }
}


