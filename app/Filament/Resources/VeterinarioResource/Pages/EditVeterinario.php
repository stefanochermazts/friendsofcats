<?php

namespace App\Filament\Resources\VeterinarioResource\Pages;

use App\Filament\Resources\VeterinarioResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVeterinario extends EditRecord
{
    protected static string $resource = VeterinarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Elimina Veterinario'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
} 