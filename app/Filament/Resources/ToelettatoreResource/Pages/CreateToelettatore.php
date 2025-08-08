<?php

namespace App\Filament\Resources\ToelettatoreResource\Pages;

use App\Filament\Resources\ToelettatoreResource;
use Filament\Resources\Pages\CreateRecord;

class CreateToelettatore extends CreateRecord
{
    protected static string $resource = ToelettatoreResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['role'] = 'toelettatore';
        $data['email_verified_at'] = now();
        
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
} 