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
        $owners = User::where('role', 'proprietario')->count();
        $associations = User::where('role', 'associazione')->count();
        $vets = User::where('role', 'veterinario')->count();
        $groomers = User::where('role', 'toelettatore')->count();
        $volunteers = User::where('role', 'volontario')->count();
        
        return [
            Stat::make('Utenti Totali', User::count())
                ->description('Tutti gli utenti registrati')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary')
                ->url(route('filament.admin.resources.users.index')),
            
            Stat::make('Nuovi Contatti', $newContacts)
                ->description('Richieste di contatto non lette')
                ->descriptionIcon('heroicon-m-envelope')
                ->color($newContacts > 0 ? 'danger' : 'success')
                ->url(route('filament.admin.resources.contacts.index')),
            
            Stat::make('Nuovi Utenti (30 giorni)', User::where('created_at', '>=', now()->subDays(30))->count())
                ->description('Registrazioni negli ultimi 30 giorni')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('success')
                ->url(route('filament.admin.resources.users.index')),
            
            Stat::make('Email Verificate', User::whereNotNull('email_verified_at')->count())
                ->description('Utenti con email verificata')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('info')
                ->url(route('filament.admin.resources.users.index')),
            
            Stat::make('Proprietari', $owners)
                ->description('Utenti proprietari di gatti')
                ->descriptionIcon('heroicon-m-home')
                ->color('warning')
                ->url(route('filament.admin.resources.proprietari.index')),
            
            Stat::make('Associazioni', $associations)
                ->description('Associazioni animaliste')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('danger')
                ->url(route('filament.admin.resources.associazioni.index')),
            
            Stat::make('Veterinari', $vets)
                ->description('Professionisti veterinari')
                ->descriptionIcon('heroicon-m-heart')
                ->color('success')
                ->url(route('filament.admin.resources.veterinari.index')),
            
            Stat::make('Toelettatori', $groomers)
                ->description('Servizi di toelettatura')
                ->descriptionIcon('heroicon-m-scissors')
                ->color('info')
                ->url(route('filament.admin.resources.toelettatori.index')),
            
            Stat::make('Volontari', $volunteers)
                ->description('Volontari collegati alle associazioni')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary')
                ->url(route('filament.admin.resources.volontari.index')),
        ];
    }
} 