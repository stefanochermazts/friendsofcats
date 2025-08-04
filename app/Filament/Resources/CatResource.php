<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatResource\Pages;
use App\Filament\Resources\CatResource\RelationManagers;
use App\Models\Cat;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;

class CatResource extends Resource
{
    protected static ?string $model = Cat::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';
    
    protected static ?string $modelLabel = 'Gatto';
    
    protected static ?string $pluralModelLabel = 'Gatti';
    
    protected static ?string $navigationLabel = 'Gatti';
    
    protected static ?int $navigationSort = 2;
    
    protected static ?string $navigationGroup = 'Gestione Gatti';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informazioni Base')
                    ->schema([
                        Forms\Components\TextInput::make('nome')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1),
                            
                        Forms\Components\Select::make('razza')
                            ->label('Razza')
                            ->options([
                                'Europeo' => 'Europeo',
                                'Persiano' => 'Persiano', 
                                'Maine Coon' => 'Maine Coon',
                                'Siamese' => 'Siamese',
                                'Ragdoll' => 'Ragdoll',
                                'British Shorthair' => 'British Shorthair',
                                'Abissino' => 'Abissino',
                                'Birmano' => 'Birmano',
                                'Bengala' => 'Bengala',
                                'Scottish Fold' => 'Scottish Fold',
                                'Sphynx' => 'Sphynx',
                                'Misto' => 'Misto',
                                'Sconosciuta' => 'Sconosciuta',
                            ])
                            ->searchable()
                            ->columnSpan(1),
                            
                        Forms\Components\TextInput::make('eta')
                            ->label('Età (mesi)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(300)
                            ->suffix('mesi')
                            ->columnSpan(1),
                            
                        Forms\Components\Select::make('sesso')
                            ->label('Sesso')
                            ->options([
                                'maschio' => 'Maschio',
                                'femmina' => 'Femmina',
                            ])
                            ->columnSpan(1),
                            
                        Forms\Components\TextInput::make('peso')
                            ->label('Peso')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(15)
                            ->step(0.1)
                            ->suffix('kg')
                            ->columnSpan(1),
                            
                        Forms\Components\TextInput::make('colore')
                            ->label('Colore')
                            ->maxLength(255)
                            ->columnSpan(1),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Stato Sanitario')
                    ->schema([
                        Forms\Components\Toggle::make('microchip')
                            ->label('Microchip')
                            ->default(false)
                            ->live(),
                            
                        Forms\Components\TextInput::make('numero_microchip')
                            ->label('Numero Microchip')
                            ->maxLength(255)
                            ->visible(fn (Forms\Get $get): bool => $get('microchip')),
                            
                        Forms\Components\Toggle::make('sterilizzazione')
                            ->label('Sterilizzato/a')
                            ->default(false),
                            
                        Forms\Components\TagsInput::make('vaccinazioni')
                            ->label('Vaccinazioni')
                            ->placeholder('Es: FIV, FeLV, Calicivirus')
                            ->columnSpanFull(),
                            
                        Forms\Components\Textarea::make('stato_sanitario')
                            ->label('Note Stato Sanitario')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Comportamento e Socialità')
                    ->schema([
                        Forms\Components\Select::make('livello_socialita')
                            ->label('Livello di Socialità')
                            ->options([
                                'basso' => 'Basso - Timido, necessita tempo',
                                'medio' => 'Medio - Normale interazione',
                                'alto' => 'Alto - Molto socievole',
                            ])
                            ->default('medio')
                            ->required(),
                            
                        Forms\Components\Textarea::make('comportamento')
                            ->label('Comportamento Generale')
                            ->placeholder('Descrivi il carattere e le abitudini del gatto...')
                            ->rows(3)
                            ->columnSpanFull(),
                            
                        Forms\Components\Textarea::make('note_comportamentali')
                            ->label('Note Comportamentali Specifiche')
                            ->placeholder('Particolarità, preferenze, paure, etc...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
                    
                Forms\Components\Section::make('Adozione e Date')
                    ->schema([
                        Forms\Components\Toggle::make('disponibile_adozione')
                            ->label('Disponibile per Adozione')
                            ->default(true)
                            ->live(),
                            
                        Forms\Components\DatePicker::make('data_arrivo')
                            ->label('Data di Arrivo')
                            ->default(now()),
                            
                        Forms\Components\DatePicker::make('data_adozione')
                            ->label('Data di Adozione')
                            ->visible(fn (Forms\Get $get): bool => !$get('disponibile_adozione')),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Foto')
                    ->schema([
                        Forms\Components\FileUpload::make('foto_principale')
                            ->label('Foto Principale')
                            ->image()
                            ->disk('public')
                            ->directory('cats/main')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                                '4:3',
                                '16:9',
                            ])
                            ->loadingIndicatorPosition('center')
                            ->panelLayout('grid')
                            ->downloadable()
                            ->openable()
                            ->previewable(),
                            
                        Forms\Components\FileUpload::make('galleria_foto')
                            ->label('Galleria Foto')
                            ->image()
                            ->disk('public')
                            ->directory('cats/gallery')
                            ->visibility('public')
                            ->multiple()
                            ->maxFiles(10)
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->reorderable(),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Gestione')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Responsabile')
                            ->relationship('user', 'name')
                            ->default(fn() => auth()->id())
                            ->required(),
                            
                        Forms\Components\Select::make('associazione_id')
                            ->label('Associazione di Riferimento')
                            ->relationship('associazione', 'name', fn (Builder $query) => $query->where('role', 'associazione'))
                            ->placeholder('Seleziona un\'associazione'),
                    ])
                    ->columns(2)
                    ->visible(fn() => auth()->user()->role === 'admin'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foto_principale')
                    ->label('Foto')
                    ->disk('public')
                    ->circular()
                    ->size(60)
                    ->defaultImageUrl(asset('/images/cat-logo.svg')),
                    
                Tables\Columns\TextColumn::make('nome')
                    ->label('Nome')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->size('lg'),
                    
                Tables\Columns\TextColumn::make('razza')
                    ->label('Razza')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                    
                Tables\Columns\TextColumn::make('galleria_foto')
                    ->label('Galleria')
                    ->formatStateUsing(function ($record) {
                        $count = $record->galleria_foto ? count($record->galleria_foto) : 0;
                        return $count > 0 ? "📸 {$count} foto" : '🚫 Nessuna';
                    })
                    ->badge()
                    ->color(fn ($record) => $record->galleria_foto && count($record->galleria_foto) > 0 ? 'success' : 'gray'),
                    
                Tables\Columns\TextColumn::make('eta')
                    ->label('Età')
                    ->formatStateUsing(fn ($state) => $state ? (
                        $state < 12 ? "{$state} mesi" : 
                        floor($state/12) . " anni" . ($state % 12 > 0 ? " e " . ($state % 12) . " mesi" : "")
                    ) : 'N/A')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => match (true) {
                        $state < 6 => 'warning',
                        $state < 24 => 'success', 
                        default => 'primary'
                    }),
                    
                Tables\Columns\TextColumn::make('sesso')
                    ->label('Sesso')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'maschio' => 'info',
                        'femmina' => 'pink',
                        default => 'gray'
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'maschio' => '♂ Maschio',
                        'femmina' => '♀ Femmina',
                        default => $state
                    }),
                    
                BadgeColumn::make('livello_socialita')
                    ->label('Socialità')
                    ->colors([
                        'danger' => 'basso',
                        'warning' => 'medio',
                        'success' => 'alto',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'basso' => '😿 Timido',
                        'medio' => '😸 Normale', 
                        'alto' => '😺 Socievole',
                        default => $state
                    }),
                    
                IconColumn::make('sterilizzazione')
                    ->label('Sterilizzato')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                    
                BadgeColumn::make('stato_gatto')
                    ->label('Stato')
                    ->getStateUsing(function ($record) {
                        // 1. Se ha una data di adozione -> Adottato (priorità massima)
                        if ($record->data_adozione) {
                            return 'adottato';
                        }
                        
                        // 2. Se disponibile per adozione -> Disponibile (anche per proprietari!)
                        if ($record->disponibile_adozione) {
                            return 'disponibile';
                        }
                        
                        // 3. Se il proprietario è un 'proprietario' e NON disponibile -> Di proprietà
                        if ($record->user && $record->user->role === 'proprietario') {
                            return 'di_proprieta';
                        }
                        
                        // 4. Altrimenti -> In valutazione (per associazioni/rifugi)
                        return 'in_valutazione';
                    })
                    ->colors([
                        'info' => 'di_proprieta',      // Blu per "Di proprietà"
                        'success' => 'disponibile',    // Verde per "Disponibile"
                        'gray' => 'adottato',          // Grigio per "Adottato"
                        'warning' => 'in_valutazione', // Giallo per "In valutazione"
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'di_proprieta' => '👨‍👩‍👧‍👦 Di proprietà',
                        'disponibile' => '🏠 Disponibile',
                        'adottato' => '❤️ Adottato',
                        'in_valutazione' => '🔍 In valutazione',
                        default => $state
                    }),
                    
                Tables\Columns\TextColumn::make('data_arrivo')
                    ->label('Arrivo')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Responsabile')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Registrato')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('razza')
                    ->label('Razza')
                    ->options([
                        'Europeo' => 'Europeo',
                        'Persiano' => 'Persiano', 
                        'Maine Coon' => 'Maine Coon',
                        'Siamese' => 'Siamese',
                        'Ragdoll' => 'Ragdoll',
                        'British Shorthair' => 'British Shorthair',
                        'Abissino' => 'Abissino',
                        'Birmano' => 'Birmano',
                        'Bengala' => 'Bengala',
                        'Scottish Fold' => 'Scottish Fold',
                        'Sphynx' => 'Sphynx',
                        'Misto' => 'Misto',
                        'Sconosciuta' => 'Sconosciuta',
                    ]),
                    
                Tables\Filters\SelectFilter::make('eta_range')
                    ->label('Fascia Età')
                    ->options([
                        'cucciolo' => 'Cucciolo (0-6 mesi)',
                        'giovane' => 'Giovane (6-24 mesi)',
                        'adulto' => 'Adulto (2-8 anni)',
                        'senior' => 'Senior (8+ anni)',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when($data['value'], function (Builder $query, $value): Builder {
                            return match ($value) {
                                'cucciolo' => $query->where('eta', '<=', 6),
                                'giovane' => $query->whereBetween('eta', [7, 24]),
                                'adulto' => $query->whereBetween('eta', [25, 96]),
                                'senior' => $query->where('eta', '>', 96),
                                default => $query
                            };
                        });
                    }),
                    
                Tables\Filters\TernaryFilter::make('sterilizzazione')
                    ->label('Sterilizzazione')
                    ->placeholder('Tutti')
                    ->trueLabel('Sterilizzati')
                    ->falseLabel('Non sterilizzati'),
                    
                Tables\Filters\SelectFilter::make('livello_socialita')
                    ->label('Livello Socialità')
                    ->options([
                        'basso' => 'Basso - Timido',
                        'medio' => 'Medio - Normale',
                        'alto' => 'Alto - Socievole',
                    ]),
                    
                Tables\Filters\TernaryFilter::make('disponibile_adozione')
                    ->label('Disponibilità Adozione')
                    ->placeholder('Tutti')
                    ->trueLabel('Disponibili')
                    ->falseLabel('Adottati'),
                    
                Tables\Filters\SelectFilter::make('sesso')
                    ->label('Sesso')
                    ->options([
                        'maschio' => 'Maschio',
                        'femmina' => 'Femmina',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Visualizza'),
                Tables\Actions\EditAction::make()
                    ->label('Modifica'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Elimina selezionati'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->defaultPaginationPageOption(25);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCats::route('/'),
            'create' => Pages\CreateCat::route('/create'),
            'edit' => Pages\EditCat::route('/{record}/edit'),
        ];
    }
    
    /**
     * Area admin: solo per amministratori
     */
    public static function canAccess(): bool
    {
        // Verifica se l'utente è autenticato e ha ruolo admin
        if (!auth()->check()) {
            return false;
        }
        
        $user = auth()->user();
        if (!$user || !isset($user->role)) {
            return false;
        }
        
        return $user->role === 'admin';
    }
}
