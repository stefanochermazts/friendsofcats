<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationLabel = 'News';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Toggle::make('add_translations')
                    ->label('Aggiungi traduzioni')
                    ->helperText('Attiva per aggiungere versioni in altre lingue')
                    ->default(false)
                    ->reactive()
                    ->dehydrated(false)
                    ->columnSpanFull(),
                Select::make('locale')
                    ->label('Lingua')
                    ->options([
                        'it' => 'Italiano',
                        'en' => 'English',
                        'de' => 'Deutsch',
                        'fr' => 'Français',
                        'es' => 'Español',
                        'sl' => 'Slovenščina',
                    ])->required()->default(fn() => app()->getLocale() ?? 'it')->columnSpanFull(),
                TextInput::make('title')->label('Titolo')->required()->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set): void {
                        $set('slug', \Str::slug((string) $state));
                    }),
                TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true)->helperText('Se lasci vuoto, verrà generato dal titolo al blur.'),
                Textarea::make('excerpt')->label('Sommario')->rows(3)->maxLength(500),
                RichEditor::make('body')->label('Contenuto')->required()->columnSpanFull(),
                FileUpload::make('cover_image')->label('Immagine di copertina')->image()->directory('news')->disk('public'),
                Select::make('is_published')
                    ->label('Pubblicata')
                    ->boolean()
                    ->options([1 => 'Sì', 0 => 'No'])
                    ->default(0)
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $get, callable $set): void {
                        if ($state && !$get('published_at')) {
                            $set('published_at', now());
                        }
                    }),
                DateTimePicker::make('published_at')->label('Data pubblicazione')->seconds(false),
                TextInput::make('meta_title')->label('Meta Title')->maxLength(255),
                TextInput::make('meta_description')->label('Meta Description')->maxLength(255),
                Section::make('Traduzioni')
                    ->collapsible()
                    ->visible(fn (Get $get) => (bool) $get('add_translations'))
                    ->schema([
                        Repeater::make('translations')
                            ->relationship()
                            ->label('Traduzioni')
                            ->minItems(0)
                            ->defaultItems(0)
                            ->collapsed()
                            ->itemLabel(fn ($state) => ($state['locale'] ?? '??') . ' — ' . (\Illuminate\Support\Str::limit((string) ($state['title'] ?? ''), 40)))
                            ->schema([
                                Select::make('locale')->label('Lingua')->options([
                                    'it' => 'Italiano','en' => 'English','de' => 'Deutsch','fr' => 'Français','es' => 'Español','sl' => 'Slovenščina'
                                ])->required(),
                                TextInput::make('title')->label('Titolo')->required()->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, callable $set): void {
                                        $set('slug', \Str::slug((string) $state));
                                    }),
                                TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true)
                                    ->helperText('Lascia vuoto per generare automaticamente dallo slug del titolo.')
                                    ->afterStateUpdated(function ($state, callable $set, callable $get): void {
                                        if (!$state && $title = $get('title')) {
                                            $set('slug', \Str::slug((string) $title));
                                        }
                                    }),
                                Textarea::make('excerpt')->label('Sommario')->rows(2)->maxLength(500),
                                RichEditor::make('body')->label('Contenuto')->required(),
                                TextInput::make('meta_title')->label('Meta Title')->maxLength(255),
                                TextInput::make('meta_description')->label('Meta Description')->maxLength(255),
                            ])->columns(2),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')->label('Cover')->disk('public')->height(40),
                TextColumn::make('title')->label('Titolo')->searchable()->limit(40),
                TextColumn::make('locale')->label('Lang')->badge(),
                BadgeColumn::make('is_published')->label('Stato')
                    ->colors(['success' => fn ($state) => $state])
                    ->formatStateUsing(fn ($state) => $state ? 'Pubblicata' : 'Bozza'),
                TextColumn::make('published_at')->label('Pubblicata il')->dateTime('d/m/Y H:i'),
                TextColumn::make('updated_at')->label('Aggiornata')->since(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('locale')->options([
                    'it' => 'Italiano','en' => 'English','de' => 'Deutsch','fr' => 'Français','es' => 'Español','sl' => 'Slovenščina'
                ]),
                Tables\Filters\TernaryFilter::make('is_published')->label('Pubblicata'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}


