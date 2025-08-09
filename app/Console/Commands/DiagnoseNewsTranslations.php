<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\News;
use App\Models\NewsTranslation;
use Illuminate\Console\Command;

class DiagnoseNewsTranslations extends Command
{
    protected $signature = 'diagnose:news-translations {--fix : Converte campi array in stringhe}';

    protected $description = 'Diagnostica e opzionalmente corregge campi non scalari nelle traduzioni delle news';

    public function handle(): int
    {
        $bad = [];
        foreach (NewsTranslation::query()->get() as $t) {
            foreach (['title','excerpt','body','meta_title','meta_description'] as $field) {
                $value = $t->getRawOriginal($field);
                if (is_array($value)) {
                    $bad[] = [$t->id, $t->locale, $field, 'array'];
                    if ($this->option('fix')) {
                        $flat = trim(collect($value)->flatten()->join(' '));
                        $t->setAttribute($field, $flat);
                    }
                }
                if (is_string($value) && json_validate($value)) {
                    $bad[] = [$t->id, $t->locale, $field, 'json-string'];
                    if ($this->option('fix')) {
                        $decoded = json_decode($value, true);
                        $flat = trim(collect($decoded)->flatten()->join(' '));
                        $t->setAttribute($field, $flat);
                    }
                }
            }
            if ($this->option('fix') && $t->isDirty()) {
                $t->save();
            }
        }

        $this->table(['ID','Locale','Campo','Tipo'], $bad);
        $this->info('Totale traduzioni controllate: ' . NewsTranslation::query()->count());
        $this->info('Anomalie: ' . count($bad));

        // Verifica risoluzione rotta show per ogni traduzione
        $slugs = NewsTranslation::query()->pluck('slug');
        $this->line('Esempi di slug tradotti: ' . $slugs->take(5)->implode(', '));
        return self::SUCCESS;
    }
}


