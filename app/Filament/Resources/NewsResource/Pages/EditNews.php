<?php

declare(strict_types=1);

namespace App\Filament\Resources\NewsResource\Pages;

use App\Filament\Resources\NewsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use App\Services\OpenAITranslator;
use Illuminate\Support\Arr;

class EditNews extends EditRecord
{
    protected static string $resource = NewsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('translate')
                ->label('Traduci con OpenAI')
                ->icon('heroicon-o-language')
                ->form([
                    \Filament\Forms\Components\Select::make('target_locale')
                        ->label('Lingua di destinazione')
                        ->options(['en'=>'English','de'=>'Deutsch','fr'=>'Français','es'=>'Español','sl'=>'Slovenščina','it'=>'Italiano'])
                        ->required(),
                ])
                ->action(function (array $data, OpenAITranslator $translator): void {
                    $record = $this->getRecord();
                    $target = (string) $data['target_locale'];
                    $source = (string) $record->locale;

                    // Se esiste già una traduzione per la lingua destinazione, la aggiorno; altrimenti la creo
                    $translatedTitle = $translator->translate($record->title, $source, $target);
                    $translatedExcerpt = $record->excerpt ? $translator->translate($record->excerpt, $source, $target) : null;
                    $translatedBody = $translator->translate($record->body, $source, $target);

                    $record->translations()->updateOrCreate(
                        ['locale' => $target],
                        [
                            'title' => $translatedTitle,
                            'slug' => \Str::slug($translatedTitle),
                            'excerpt' => $translatedExcerpt,
                            'body' => $translatedBody,
                            'meta_title' => $translatedTitle,
                            'meta_description' => $translatedExcerpt ? \Str::limit(strip_tags($translatedExcerpt), 150) : null,
                        ]
                    );

                    Notification::make()
                        ->title('Traduzione creata/aggiornata')
                        ->body("Traduzione in {$target} salvata con successo.")
                        ->success()
                        ->send();
                })
                ->requiresConfirmation(),

            Actions\Action::make('translate_all')
                ->label('Traduci tutte le lingue')
                ->icon('heroicon-o-globe-alt')
                ->form([
                    \Filament\Forms\Components\Select::make('locales')
                        ->label('Lingue di destinazione')
                        ->multiple()
                        ->options(['en'=>'English','de'=>'Deutsch','fr'=>'Français','es'=>'Español','sl'=>'Slovenščina'])
                        ->required(),
                ])
                ->action(function (array $data, OpenAITranslator $translator): void {
                    $record = $this->getRecord();
                    $source = (string) $record->locale;
                    $targets = (array) ($data['locales'] ?? []);

                    foreach ($targets as $target) {
                        if ($target === $source) {
                            continue;
                        }
                        $translatedTitle = $translator->translate($record->title, $source, $target);
                        $translatedExcerpt = $record->excerpt ? $translator->translate($record->excerpt, $source, $target) : null;
                        $translatedBody = $translator->translate($record->body, $source, $target);

                        $metaDesc = $translatedExcerpt ?: strip_tags($translatedBody);
                        $metaDesc = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags((string) $metaDesc))), 160);

                        $record->translations()->updateOrCreate(
                            ['locale' => $target],
                            [
                                'title' => $translatedTitle,
                                'slug' => \Str::slug($translatedTitle),
                                'excerpt' => $translatedExcerpt,
                                'body' => $translatedBody,
                                'meta_title' => $translatedTitle,
                                'meta_description' => $metaDesc,
                            ]
                        );
                    }

                    Notification::make()
                        ->title('Traduzioni completate')
                        ->body('Le traduzioni selezionate sono state generate e salvate.')
                        ->success()
                        ->send();
                })
                ->requiresConfirmation(),

            Actions\DeleteAction::make(),
        ];
    }
}


