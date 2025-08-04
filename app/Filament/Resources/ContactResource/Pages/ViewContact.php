<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContact extends ViewRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Modifica'),
            Actions\Action::make('markAsRead')
                ->label('Segna come Letto')
                ->icon('heroicon-o-eye')
                ->color('warning')
                ->action(function (): void {
                    $this->record->markAsRead();
                    $this->refreshFormData(['status', 'read_at']);
                })
                ->visible(fn (): bool => $this->record->isNew()),
            Actions\Action::make('markAsReplied')
                ->label('Segna come Risposto')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->action(function (): void {
                    $this->record->markAsReplied();
                    $this->refreshFormData(['status']);
                })
                ->visible(fn (): bool => !$this->record->isReplied()),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Marca automaticamente come letto quando viene visualizzato
        if ($this->record->isNew()) {
            $this->record->markAsRead();
        }

        return $data;
    }
}