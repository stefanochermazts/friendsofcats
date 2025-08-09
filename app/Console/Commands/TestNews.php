<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\News;
use Illuminate\Console\Command;

class TestNews extends Command
{
    protected $signature = 'test:news {--locale=it}';

    protected $description = 'Diagnostica visibilità news per homepage e indice';

    public function handle(): int
    {
        $locale = (string) $this->option('locale');

        $total = \DB::table('news')->count();
        $this->info("News totali: {$total}");

        $publishedCount = News::published()->count();
        $this->info("News pubblicate: {$publishedCount}");

        $rawPublished = \DB::table('news')->where('is_published', 1)->count();
        $this->line("Raw is_published=1: {$rawPublished}");

        $nullDates = \DB::table('news')->whereNull('published_at')->count();
        $this->line("Con published_at NULL: {$nullDates}");

        $future = \DB::table('news')->whereNotNull('published_at')->where('published_at', '>', now())->count();
        $this->line("Con published_at FUTURA: {$future}");

        $list = News::with('translations')
            ->published()
            ->recent()
            ->get()
            ->filter(fn (News $n) => $n->hasTranslation($locale) || $n->locale === $locale)
            ->map(fn (News $n) => [
                'id' => $n->id,
                'title' => $n->translation($locale)->title ?? $n->title,
                'locale' => $n->locale,
                'published_at' => optional($n->published_at)->toDateTimeString(),
            ])->values()->all();

        $this->table(['ID', 'Titolo', 'Locale', 'Published At'], $list);

        // Verifica riempimento automatico published_at
        $needsFix = News::where('is_published', true)->whereNull('published_at')->count();
        if ($needsFix > 0) {
            $this->warn("Fix: {$needsFix} news pubblicate senza published_at. Eseguo set now()...");
            News::where('is_published', true)->whereNull('published_at')->update(['published_at' => now()]);
        }

        return self::SUCCESS;
    }
}


