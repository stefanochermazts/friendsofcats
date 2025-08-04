<?php

namespace App\Filament\Resources\ContactResource\Widgets;

use App\Models\Contact;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContactStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalContacts = Contact::count();
        $newContacts = Contact::where('status', 'new')->count();
        $readContacts = Contact::where('status', 'read')->count();
        $repliedContacts = Contact::where('status', 'replied')->count();

        return [
            Stat::make('Richieste Totali', $totalContacts)
                ->description('Tutte le richieste di contatto')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('primary'),

            Stat::make('Nuove Richieste', $newContacts)
                ->description('Richieste non ancora lette')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color($newContacts > 0 ? 'danger' : 'success'),

            Stat::make('Richieste Lette', $readContacts)
                ->description('In attesa di risposta')
                ->descriptionIcon('heroicon-m-eye')
                ->color('warning'),

            Stat::make('Richieste Risposte', $repliedContacts)
                ->description('Richieste già gestite')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }

    protected function getColumns(): int
    {
        return 4;
    }
}