<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use App\Filament\Resources\ContactResource\Widgets\ContactStatsOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListContacts extends ListRecords
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nuovo Contatto'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ContactStatsOverview::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tutti')
                ->badge(fn () => $this->getModel()::count()),
            
            'new' => Tab::make('Nuovi')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'new'))
                ->badge(fn () => $this->getModel()::where('status', 'new')->count())
                ->badgeColor('danger'),
            
            'read' => Tab::make('Letti')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'read'))
                ->badge(fn () => $this->getModel()::where('status', 'read')->count())
                ->badgeColor('warning'),
            
            'replied' => Tab::make('Risposti')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'replied'))
                ->badge(fn () => $this->getModel()::where('status', 'replied')->count())
                ->badgeColor('success'),
        ];
    }

    public function getDefaultActiveTab(): string | int | null
    {
        return 'new';
    }
}