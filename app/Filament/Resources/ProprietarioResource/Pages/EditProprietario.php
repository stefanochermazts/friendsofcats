<?php

namespace App\Filament\Resources\ProprietarioResource\Pages;

use App\Filament\Resources\ProprietarioResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProprietario extends EditRecord
{
    protected static string $resource = ProprietarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Elimina Proprietario'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
} 