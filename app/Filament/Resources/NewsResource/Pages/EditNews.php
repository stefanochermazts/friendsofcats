<?php

declare(strict_types=1);

namespace App\Filament\Resources\NewsResource\Pages;

use App\Filament\Resources\NewsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use App\Services\OpenAITranslator;
use App\Services\OpenAIImageService;
use Illuminate\Support\Arr;

class EditNews extends EditRecord
{
    protected static string $resource = NewsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('generate_cover')
                ->label('Genera immagine copertina')
                ->icon('heroicon-o-photo')
                ->form([
                    \Filament\Forms\Components\Textarea::make('topic')->label('TOPIC')->rows(2),
                    \Filament\Forms\Components\TextInput::make('gatto')->label('GATTO')->placeholder('es. europeo tigrato a pelo corto'),
                    \Filament\Forms\Components\TextInput::make('eta')->label('ETA')->placeholder('cucciolo/adulto/anziano'),
                    \Filament\Forms\Components\TextInput::make('azione')->label('AZIONE')->placeholder('calmo/curioso/gioca/osserva'),
                    \Filament\Forms\Components\TextInput::make('emozione')->label('EMOZIONE')->placeholder('sereno/attento'),
                    \Filament\Forms\Components\TextInput::make('setting')->label('SETTING')->placeholder('salotto/cucina/...'),
                    \Filament\Forms\Components\TextInput::make('props')->label('PROPS')->placeholder('forbicine chiuse, limetta, ...'),
                    \Filament\Forms\Components\TextInput::make('pos_copy')->label('POSIZIONE COPY')->placeholder('in alto a destra'),
                    \Filament\Forms\Components\TextInput::make('ora')->label('ORA DEL GIORNO')->placeholder('mattina/sera'),
                    \Filament\Forms\Components\TextInput::make('tipo_luce')->label('TIPO DI LUCE')->placeholder('diffusa/morbida'),
                    \Filament\Forms\Components\TextInput::make('altezza')->label('ALTEZZA CAMERA')->placeholder('altezza occhi gatto'),
                ])
                ->action(function (array $data, OpenAIImageService $img): void {
                    $record = $this->getRecord();
                    $prompt = "Fotografia realistica in ambiente domestico italiano (arredi luminosi, luce naturale). Tema: {TOPIC}.\nSoggetto: {GATTO}, {ETA}, comportamento {AZIONE}, espressione {EMOZIONE}.\nContesto: {SETTING}, {PROPS}.\nComposizione: rule of thirds, copy-space a {POSIZIONE COPY}; sfondo sfocato, niente disordine.\nIlluminazione: {ORA DEL GIORNO}, luce {TIPO DI LUCE}.\nColori: palette naturale e calda.\nCamera: 50–85mm, f/2.8–4, scatto a {ALTEZZA CAMERA}.\nStile: editoriale autentico, zero look stock.\nEvitare: testo/lettering, watermark, mani che tengono forte il gatto, pose forzate, arti extra, occhi cartoon, sofferenza.\nFormato: 16:9 (1920×1080) safe area per mobile crop 4:5.\nVarianti: genera 3 versioni coerenti cambiando solo inquadratura/props minori.";

                    $vars = [
                        '{TOPIC}' => (string) ($data['topic'] ?? $record->title),
                        '{GATTO}' => (string) ($data['gatto'] ?? ''),
                        '{ETA}' => (string) ($data['eta'] ?? ''),
                        '{AZIONE}' => (string) ($data['azione'] ?? ''),
                        '{EMOZIONE}' => (string) ($data['emozione'] ?? ''),
                        '{SETTING}' => (string) ($data['setting'] ?? ''),
                        '{PROPS}' => (string) ($data['props'] ?? ''),
                        '{POSIZIONE COPY}' => (string) ($data['pos_copy'] ?? ''),
                        '{ORA DEL GIORNO}' => (string) ($data['ora'] ?? ''),
                        '{TIPO DI LUCE}' => (string) ($data['tipo_luce'] ?? ''),
                        '{ALTEZZA CAMERA}' => (string) ($data['altezza'] ?? ''),
                    ];
                    $finalPrompt = str_replace(array_keys($vars), array_values($vars), $prompt);

                    $res = $img->generateCover($finalPrompt, (int) $record->id);
                    if (!($res['ok'] ?? false)) {
                        Notification::make()->title('Errore generazione immagine')->body($res['error'] ?? '')->danger()->send();
                        return;
                    }
                    $record->cover_image = $res['path'];
                    // Semplice alt suggerito
                    $record->cover_alt = 'Foto di un gatto: ' . ($data['gatto'] ?? '');
                    $record->save();

                    Notification::make()->title('Copertina generata')->success()->send();
                    $this->refreshFormData(['cover_image','cover_alt']);
                }),
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


