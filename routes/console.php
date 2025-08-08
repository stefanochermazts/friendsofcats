<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

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
