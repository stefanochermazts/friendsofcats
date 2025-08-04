<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Contact;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $newContacts = Contact::where('status', 'new')->count();
        
        return [
            Stat::make('Utenti Totali', User::count())
                ->description('Tutti gli utenti registrati')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            
            Stat::make('Nuovi Contatti', $newContacts)
                ->description('Richieste di contatto non lette')
                ->descriptionIcon('heroicon-m-envelope')
                ->color($newContacts > 0 ? 'danger' : 'success')
                ->url(route('filament.admin.resources.contacts.index')),
            
            Stat::make('Nuovi Utenti (30 giorni)', User::where('created_at', '>=', now()->subDays(30))->count())
                ->description('Registrazioni negli ultimi 30 giorni')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('success'),
            
            Stat::make('Email Verificate', User::whereNotNull('email_verified_at')->count())
                ->description('Utenti con email verificata')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('info'),
            
            Stat::make('Proprietari di Gatti', User::where('role', 'owner')->count())
                ->description('Utenti proprietari di gatti')
                ->descriptionIcon('heroicon-m-heart')
                ->color('warning'),
            
            Stat::make('Associazioni', User::where('role', 'association')->count())
                ->description('Associazioni animaliste')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('danger'),
        ];
    }
} 