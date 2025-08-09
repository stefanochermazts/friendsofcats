<?php

declare(strict_types=1);

namespace App\Filament\Resources\NewsResource\Pages;

use App\Filament\Resources\NewsResource;
use App\Models\News;
use App\Services\OpenAITranslator;
use App\Models\Taxonomy;
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
                    // Scelta tipo di articolo (mappa a tassonomia principale)
                    \Filament\Forms\Components\Select::make('prompt_type')
                        ->label('Tipo di articolo')
                        ->options([
                            'guide' => 'Guide pratiche (/guide/)',
                            'salute' => 'Salute (/salute/)',
                            'alimentazione' => 'Alimentazione (/alimentazione/)',
                            'comportamento' => 'Comportamento (/comportamento/)',
                            'razze' => 'Scheda razza (/razze/)',
                            'adozioni' => 'Adozioni - guida (/adozioni/)',
                            'adozioni_conv' => 'Adozioni - convivenze (/adozioni/)',
                            'cura_lettiera' => 'Cura - lettiera (/cura/)',
                            'cura_viaggi' => 'Cura - viaggi (/cura/)',
                            'curiosita' => 'Curiosità (/curiosita/)',
                        ])->required()->reactive(),
                    // Esempi precompilati
                    \Filament\Forms\Components\Select::make('example')
                        ->label('Carica un esempio')
                        ->options([
                            'ex_guide' => 'Esempio Guide: Tagliare le unghie',
                            'ex_salute' => 'Esempio Salute: Diarrea acuta',
                            'ex_alim' => 'Esempio Alimentazione: Umido vs secco',
                            'ex_comp' => "Esempio Comportamento: pipì fuori lettiera",
                            'ex_razza' => 'Esempio Razza: Maine Coon',
                        ])->reactive()->afterStateUpdated(function ($state, callable $set) {
                            if ($state === 'ex_guide') {
                                $set('prompt_type','guide');
                                $set('topic','Tagliare le unghie al gatto senza stress');
                                $set('kw','tagliare unghie gatto');
                                $set('kws','come accorciare unghie gatto, forbicine gatto, limetta');
                            } elseif ($state === 'ex_salute') {
                                $set('prompt_type','salute');
                                $set('problema','Diarrea acuta nel gatto: cause, cosa fare e quando andare dal veterinario');
                                $set('kw','diarrea gatto cosa fare');
                                $set('kws','feci liquide gatto, disidratazione gatto, probiotici gatto');
                            } elseif ($state === 'ex_alim') {
                                $set('prompt_type','alimentazione');
                                $set('tema','Umido vs secco: cosa scegliere per il tuo gatto?');
                                $set('kw','umido o secco gatto');
                                $set('kws','fabbisogno proteico gatto, percentuale carne umido, crocchette grain free');
                            } elseif ($state === 'ex_comp') {
                                $set('prompt_type','comportamento');
                                $set('situazione','Il gatto fa pipì fuori dalla lettiera: cause e soluzioni');
                                $set('kw','gatto pipì fuori lettiera');
                            } elseif ($state === 'ex_razza') {
                                $set('prompt_type','razze');
                                $set('nome_razza','Maine Coon');
                                $set('kw','Maine Coon carattere');
                            }
                        })->hint('Opzionale'),
                    \Filament\Forms\Components\Select::make('locale')
                        ->label('Lingua articolo')
                        ->options(['it'=>'Italiano','en'=>'English','de'=>'Deutsch','fr'=>'Français','es'=>'Español','sl'=>'Slovenščina'])
                        ->required()
                        ->default(fn() => app()->getLocale() ?? 'it'),
                    // Variabili dei prompt (appaiono in base al tipo)
                    \Filament\Forms\Components\TextInput::make('topic')->label('TOPIC')->visible(fn($get)=>in_array($get('prompt_type'),['guide','adozioni','cura_lettiera','cura_viaggi']))->columnSpanFull(),
                    \Filament\Forms\Components\TextInput::make('problema')->label('PROBLEMA')->visible(fn($get)=>$get('prompt_type')==='salute')->columnSpanFull(),
                    \Filament\Forms\Components\TextInput::make('tema')->label('TEMA')->visible(fn($get)=>$get('prompt_type')==='alimentazione')->columnSpanFull(),
                    \Filament\Forms\Components\TextInput::make('situazione')->label('SITUAZIONE/PROBLEMA')->visible(fn($get)=>$get('prompt_type')==='comportamento')->columnSpanFull(),
                    \Filament\Forms\Components\TextInput::make('nome_razza')->label('NOME_RAZZA')->visible(fn($get)=>$get('prompt_type')==='razze')->columnSpanFull(),
                    \Filament\Forms\Components\TextInput::make('animale_residente')->label('ANIMALE_RESIDENTE')->visible(fn($get)=>$get('prompt_type')==='adozioni_conv')->columnSpanFull(),
                    \Filament\Forms\Components\TextInput::make('mezzo')->label('MEZZO')->visible(fn($get)=>$get('prompt_type')==='cura_viaggi')->columnSpanFull(),
                    \Filament\Forms\Components\TextInput::make('kw')->label('KW primaria')->required()->columnSpanFull(),
                    \Filament\Forms\Components\TextInput::make('kws')->label('KWS secondarie (separate da virgola)')->columnSpanFull(),

                    // Tassonomie da applicare
                    \Filament\Forms\Components\Select::make('additional_taxonomies')
                        ->label('Altre tassonomie (opzionale)')
                        ->multiple()->preload()
                        ->options(fn()=> Taxonomy::query()->pluck('name','id')),
                    \Filament\Forms\Components\Select::make('translate_to')
                        ->label('Traduci anche in')
                        ->multiple()
                        ->options(['en'=>'English','de'=>'Deutsch','fr'=>'Français','es'=>'Español','sl'=>'Slovenščina','it'=>'Italiano'])
                        ->default(['en','de','fr','es','sl']),
                ])
                ->action(function (array $data, OpenAITranslator $ai): void {
                    $baseLocale = (string) $data['locale'];
                    $promptType = (string) $data['prompt_type'];
                    $kw = (string) ($data['kw'] ?? '');
                    $kws = (string) ($data['kws'] ?? '');

                    // Mappa tipo -> slug tassonomia e template
                    $typeToSlug = [
                        'guide' => 'guide',
                        'salute' => 'salute',
                        'alimentazione' => 'alimentazione',
                        'comportamento' => 'comportamento',
                        'razze' => 'razze',
                        'adozioni' => 'adozioni',
                        'adozioni_conv' => 'adozioni',
                        'cura_lettiera' => 'cura',
                        'cura_viaggi' => 'cura',
                        'curiosita' => 'curiosita',
                    ];
                    $slug = $typeToSlug[$promptType] ?? 'guide';

                    $templates = [
                        'guide' => "Sei redattor* e SEO per catfriends.club. Scrivi una guida passo-passo su: {TOPIC}.\nCategoria: /guide/. Keyword primaria: {KW}. Secondarie: {KWS}.\nStruttura: H1 (kw all’inizio) → Introduzione (2–3 frasi) → TL;DR (3–5 bullet) → Indice → 6–7 H2 con istruzioni operative, checklist finale e, se utile, tabella (strumenti/tempi/costi).\nInserisci 3–5 link interni pertinenti tra /guide/, /cura/, /adozioni/.\nTono pratico, empatico, autorevole. 1200–1600 parole.\nChiudi con blocco JSON meta & schema (come da modello catfriends.club).",
                        'salute' => "Scrivi un articolo salute su {PROBLEMA} (gatto). Intento informazionale.\nCategoria: /salute/. KW primaria: {KW}; secondarie: {KWS}.\nStruttura: H1 → Intro → TL;DR → Indice → Sezioni H2: Sintomi, Possibili cause, Cosa fare a casa (passi concreti), Quando chiamare il veterinario (criteri oggettivi), Prevenzione → Box “Avvertenza veterinaria” → FAQ (5–7).\nLink interni a /salute/, /alimentazione/ e /comportamento/. 1300–1700 parole.\nChiudi con JSON meta & schema.",
                        'alimentazione' => "Articolo nutrizione su {TEMA} per gatti in Italia.\nCategoria: /alimentazione/. KW: {KW}; secondarie: {KWS}.\nStruttura: H1 → TL;DR → Indice → H2: Fabbisogni per età/peso, Confronto (tabella: umido/secco/cotto), Come leggere l’etichetta (proteine grezze, ceneri, additivi), Piano settimanale d’esempio → Errori comuni → FAQ.\nLink interni a /salute/ e /cura/. 1200–1600 parole.\nChiudi con JSON meta & schema.",
                        'comportamento' => "Articolo comportamento su {SITUAZIONE}.\nCategoria: /comportamento/. KW: {KW}.\nStruttura: H1 → TL;DR → Indice → H2: Perché succede (etologia), Ambiente ideale (arricchimento), Protocollo in 7 passi (graduale), Cosa evitare, Quando chiedere aiuto a un comportamentalista → FAQ.\nLink interni a /cura/ e /guide/. 1200–1500 parole + JSON meta & schema.",
                        'razze' => "Crea una scheda razza per {NOME_RAZZA}.\nCategoria: /razze/. KW: {KW}.\nStruttura: H1 → Intro breve → TL;DR → Indice → H2: Origini, Carattere e bisogni di gioco, Cura del mantello (tabella strumenti/frequenza/tempo), Salute (condizioni predisponenti, no diagnosi), Convivenza (bambini/anziani/altre specie), Costi ricorrenti → FAQ.\nLink interni a /alimentazione/ e /cura/. 1000–1300 parole + JSON meta & schema.",
                        'adozioni' => "Scrivi una guida all’adozione responsabile su {TOPIC}.\nCategoria: /adozioni/. KW primaria: {KW}; secondarie: {KWS}.\nStruttura: H1 → Intro → TL;DR → Indice → H2: Prima dell’adozione (autovalutazione, costi base, documenti), Come scegliere il gatto (età, temperamento), Iter con associazione/rifugio, Inserimento in casa (primi 14 giorni), Checklist documenti e kit base → FAQ (5–7).\nLink interni a /cura/, /comportamento/ e /alimentazione/. 1200–1600 parole.\nChiudi con JSON meta & schema.",
                        'adozioni_conv' => "Articolo pratico su {TOPIC}: inserire un nuovo gatto in casa dove c’è {ANIMALE_RESIDENTE}.\nCategoria: /adozioni/. KW: {KW}; secondarie: {KWS}.\nStruttura: H1 → TL;DR → Indice → H2: Preparare gli spazi (risorse duplicate), Protocollo di inserimento in 7 passi, Segnali di stress, Cosa evitare, Quando chiedere aiuto a un comportamentalista → FAQ.\nLink interni a /comportamento/, /cura/, /guide/. 1200–1500 parole + JSON meta & schema.",
                        'cura_lettiera' => "Scrivi una guida completa alla lettiera su {TOPIC}.\nCategoria: /cura/. KW: {KW}; secondarie: {KWS}.\nStruttura: H1 → TL;DR → Indice → H2: Quante lettiere e dove (regola N+1), Tipi di sabbia (tabella comparativa), Pulizia e odori (routine), Errori comuni, Troubleshooting → FAQ.\nLink interni a /comportamento/ e /guide/. 1200–1500 parole. JSON meta & schema.",
                        'cura_viaggi' => "Guida pratica su {TOPIC}: viaggiare con il gatto in {MEZZO}.\nCategoria: /cura/. KW: {KW}; secondarie: {KWS}.\nStruttura: H1 → TL;DR → Indice → H2: Preparazione, Acclimatazione al trasportino, Kit di viaggio, In viaggio, Sicurezza, Quando parlare col veterinario → FAQ.\nLink interni a /salute/ e /guide/. 1200–1500 parole. JSON meta & schema.",
                        'curiosita' => "Articolo “Miti da sfatare” su {TOPIC}.\nCategoria: /curiosita/. KW: {KW}; secondarie: {KWS}.\nStruttura: H1 → Intro → TL;DR → Indice → Elenco di 8–12 miti: per ciascuno MITO → Realtà → Cosa fare nella pratica, Fonti, FAQ.\nLink interni a /comportamento/, /salute/ e /adozioni/. 900–1200 parole. JSON meta & schema.",
                    ];

                    // Sostituisci variabili nel template
                    $vars = [
                        '{TOPIC}' => (string) ($data['topic'] ?? ''),
                        '{PROBLEMA}' => (string) ($data['problema'] ?? ''),
                        '{TEMA}' => (string) ($data['tema'] ?? ''),
                        '{SITUAZIONE}' => (string) ($data['situazione'] ?? ''),
                        '{NOME_RAZZA}' => (string) ($data['nome_razza'] ?? ''),
                        '{ANIMALE_RESIDENTE}' => (string) ($data['animale_residente'] ?? ''),
                        '{MEZZO}' => (string) ($data['mezzo'] ?? ''),
                        '{KW}' => $kw,
                        '{KWS}' => $kws,
                    ];
                    $basePrompt = $templates[$promptType] ?? '';
                    $fullPrompt = str_replace(array_keys($vars), array_values($vars), $basePrompt);

                    $targets = array_values(array_unique(array_filter((array) ($data['translate_to'] ?? []))));

                    $result = $ai->generateArticle($fullPrompt, $baseLocale);
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

                    // Collega tassonomia principale + aggiuntive
                    $primaryTax = Taxonomy::where('slug', $slug)->first();
                    $attachIds = [];
                    if ($primaryTax) { $attachIds[] = $primaryTax->id; }
                    $extra = (array) ($data['additional_taxonomies'] ?? []);
                    $attachIds = array_values(array_unique(array_merge($attachIds, $extra)));
                    if ($attachIds) { $news->taxonomies()->sync($attachIds); }

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


