<?php

namespace App\Filament\Resources\VolontarioResource\Pages;

use App\Filament\Resources\VolontarioResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVolontario extends CreateRecord
{
    protected static string $resource = VolontarioResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['role'] = 'volontario';
        $data['email_verified_at'] = now();
        
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
} 