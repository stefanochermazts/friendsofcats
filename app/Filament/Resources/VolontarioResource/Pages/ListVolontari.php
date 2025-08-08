<?php

namespace App\Filament\Resources\VolontarioResource\Pages;

use App\Filament\Resources\VolontarioResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVolontari extends ListRecords
{
    protected static string $resource = VolontarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nuovo Volontario'),
        ];
    }
} 