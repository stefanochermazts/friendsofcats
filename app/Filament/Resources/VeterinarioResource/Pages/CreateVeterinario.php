<?php

namespace App\Filament\Resources\VeterinarioResource\Pages;

use App\Filament\Resources\VeterinarioResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVeterinario extends CreateRecord
{
    protected static string $resource = VeterinarioResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['role'] = 'veterinario';
        $data['email_verified_at'] = now();
        
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
} 