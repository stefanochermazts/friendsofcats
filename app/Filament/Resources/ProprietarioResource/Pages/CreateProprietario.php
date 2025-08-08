<?php

namespace App\Filament\Resources\ProprietarioResource\Pages;

use App\Filament\Resources\ProprietarioResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProprietario extends CreateRecord
{
    protected static string $resource = ProprietarioResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['role'] = 'proprietario';
        $data['email_verified_at'] = now();
        
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
} 