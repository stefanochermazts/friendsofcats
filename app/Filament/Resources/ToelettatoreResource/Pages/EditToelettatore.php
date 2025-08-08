<?php

namespace App\Filament\Resources\ToelettatoreResource\Pages;

use App\Filament\Resources\ToelettatoreResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditToelettatore extends EditRecord
{
    protected static string $resource = ToelettatoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Elimina Toelettatore'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
} 