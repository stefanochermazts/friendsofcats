<?php

declare(strict_types=1);

namespace App\Filament\Resources\NewsResource\Pages;

use App\Filament\Resources\NewsResource;
use App\Models\News;
use App\Services\OpenAITranslator;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateNews extends CreateRecord
{
    protected static string $resource = NewsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('ai_generate')
                ->label('Genera con OpenAI')
                ->icon('heroicon-o-sparkles')
                ->form([
                    \Filament\Forms\Components\Select::make('locale')
                        ->label('Lingua articolo')
                        ->options(['it'=>'Italiano','en'=>'English','de'=>'Deutsch','fr'=>'Français','es'=>'Español','sl'=>'Slovenščina'])
                        ->required()
                        ->default(fn() => app()->getLocale() ?? 'it'),
                    \Filament\Forms\Components\Textarea::make('prompt')
                        ->label('Prompt')
                        ->rows(6)
                        ->required()
                        ->placeholder('Descrivi l\'articolo da generare (tema, sezioni, stile, target, link, ecc.)'),
                    \Filament\Forms\Components\Select::make('translate_to')
                        ->label('Traduci anche in')
                        ->multiple()
                        ->options(['en'=>'English','de'=>'Deutsch','fr'=>'Français','es'=>'Español','sl'=>'Slovenščina','it'=>'Italiano'])
                        ->default(['en','de','fr','es','sl']),
                ])
                ->action(function (array $data, OpenAITranslator $ai): void {
                    $baseLocale = (string) $data['locale'];
                    $prompt = (string) $data['prompt'];
                    $targets = array_values(array_unique(array_filter((array) ($data['translate_to'] ?? []))));

                    $result = $ai->generateArticle($prompt, $baseLocale);
                    if (!($result['ok'] ?? false)) {
                        Notification::make()
                            ->title('Generazione non valida')
                            ->body('Il modello non ha restituito JSON valido. Contenuto grezzo visualizzato di seguito, correggi il prompt o riprova.')
                            ->danger()
                            ->persistent()
                            ->send();
                        // Pre-compila la form con il raw in body per editing manuale
                        $this->form->fill([
                            'locale' => $baseLocale,
                            'title' => 'Da completare',
                            'excerpt' => '',
                            'body' => (string) ($result['raw'] ?? ''),
                        ]);
                        return;
                    }

                    $article = (array) ($result['article'] ?? []);
                    $title = (string) ($article['title'] ?? 'Untitled');
                    $excerpt = (string) ($article['excerpt'] ?? '');
                    $body = (string) ($article['body_html'] ?? '');
                    $metaTitle = (string) ($article['meta_title'] ?? $title);
                    $metaDesc = (string) ($article['meta_description'] ?? $excerpt);

                    $news = News::create([
                        'locale' => $baseLocale,
                        'title' => $title,
                        'slug' => \Str::slug($title),
                        'excerpt' => $excerpt,
                        'body' => $body,
                        'is_published' => false,
                        'meta_title' => $metaTitle,
                        'meta_description' => $metaDesc,
                    ]);

                    // Traduzioni
                    foreach ($targets as $target) {
                        if ($target === $baseLocale) { continue; }
                        $translatedTitle = $ai->translate($news->title, $baseLocale, $target);
                        $translatedExcerpt = $news->excerpt ? $ai->translate($news->excerpt, $baseLocale, $target) : null;
                        $translatedBody = $ai->translate($news->body, $baseLocale, $target);

                        $metaDesc = $translatedExcerpt ?: strip_tags($translatedBody);
                        $metaDesc = \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags((string) $metaDesc))), 160);

                        $news->translations()->updateOrCreate(
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

                    Notification::make()->title('Articolo generato')->body('Bozza creata e traduzioni applicate.')->success()->send();
                    $this->redirect(\App\Filament\Resources\NewsResource::getUrl('edit', ['record' => $news]));
                })
                ->requiresConfirmation(),
        ];
    }
}


