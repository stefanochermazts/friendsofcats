<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\GenerateSitemap;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Scheduler per la generazione automatica di post di adozione
Schedule::command('adoption:generate-posts --max-posts=5 --days-between=7')
    ->dailyAt('10:00')
    ->withoutOverlapping()
    ->onSuccess(function () {
        \Log::info('✅ Job generazione post di adozione completato con successo');
    })
    ->onFailure(function () {
        \Log::error('❌ Job generazione post di adozione fallito');
    })
    ->description('Genera post automatici di richiesta adozione per gatti disponibili');

// Scheduler: genera sitemap statica ogni 6 ore
Schedule::command('sitemap:generate')
    ->cron('0 */6 * * *')
    ->withoutOverlapping()
    ->onSuccess(function () {
        \Log::info('✅ Sitemap statica rigenerata');
    })
    ->onFailure(function () {
        \Log::error('❌ Rigenerazione sitemap statica fallita');
    })
    ->description('Rigenera public/sitemap.xml ogni 6 ore');
