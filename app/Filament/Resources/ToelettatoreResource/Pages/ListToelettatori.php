<?php

namespace App\Filament\Resources\ToelettatoreResource\Pages;

use App\Filament\Resources\ToelettatoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListToelettatori extends ListRecords
{
    protected static string $resource = ToelettatoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nuovo Toelettatore'),
        ];
    }
} 