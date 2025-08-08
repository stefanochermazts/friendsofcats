<?php

namespace App\Filament\Resources\VolontarioResource\Pages;

use App\Filament\Resources\VolontarioResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVolontario extends EditRecord
{
    protected static string $resource = VolontarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Elimina Volontario'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
} 