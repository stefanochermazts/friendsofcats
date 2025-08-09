<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssociationResource\Pages;
use App\Filament\Resources\AssociationResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ToggleColumn;
use App\Filament\Resources\CatResource;

class AssociationResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    
    protected static ?string $navigationGroup = 'Gestione Utenti';
    
    protected static ?string $modelLabel = 'Associazione';
    
    protected static ?string $pluralModelLabel = 'Associazioni';
    
    protected static ?string $slug = 'associazioni';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informazioni Base')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome Utente')
                            ->required()
                            ->maxLength(255),
                        
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(User::class, 'email', ignoreRecord: true),
                        
                        TextInput::make('ragione_sociale')
                            ->label('Ragione Sociale')
                            ->required()
                            ->maxLength(255),
                        
                        TextInput::make('telefono')
                            ->label('Telefono')
                            ->tel()
                            ->maxLength(20),
                        
                        TextInput::make('sito_web')
                            ->label('Sito Web')
                            ->url()
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Indirizzo')
                    ->schema([
                        TextInput::make('indirizzo')
                            ->label('Indirizzo')
                            ->required()
                            ->maxLength(255),
                        
                        TextInput::make('citta')
                            ->label('Città')
                            ->required()
                            ->maxLength(255),
                        
                        TextInput::make('cap')
                            ->label('CAP')
                            ->required()
                            ->maxLength(10),
                        
                        TextInput::make('provincia')
                            ->label('Provincia')
                            ->required()
                            ->maxLength(3)
                            ->placeholder('Ex. MI, RM, NA'),
                        
                        TextInput::make('paese')
                            ->label('Paese')
                            ->required()
                            ->maxLength(255)
                            ->default('Italia'),
                    ])->columns(3),

                Forms\Components\Section::make('Coordinate geografiche')
                    ->schema([
                        TextInput::make('latitude')
                            ->label('Latitudine')
                            ->numeric()
                            ->step(0.00000001)
                            ->placeholder('Es. 45.4642035'),
                        
                        TextInput::make('longitude')
                            ->label('Longitudine')
                            ->numeric()
                            ->step(0.00000001)
                            ->placeholder('Es. 9.1899814'),
                    ])->columns(2)
                    ->description('Le coordinate vengono calcolate automaticamente dall\'indirizzo'),

                Forms\Components\Section::make('Informazioni Aggiuntive')
                    ->schema([
                        Textarea::make('descrizione')
                            ->label('Descrizione')
                            ->maxLength(1000)
                            ->rows(4)
                            ->placeholder('Descrizione delle attività dell\'associazione...'),
                        
                        Toggle::make('association_details_completed')
                            ->label('Dettagli Completati')
                            ->disabled()
                            ->helperText('Indica se l\'associazione ha completato tutti i dettagli richiesti'),
                        
                        Toggle::make('email_verified_at')
                            ->label('Email Verificata')
                            ->disabled(),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'associazione'))
            ->columns([
                TextColumn::make('ragione_sociale')
                    ->label('🏢 Ragione Sociale')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                TextColumn::make('name')
                    ->label('👤 Nome Utente')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('email')
                    ->label('📧 Email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                
                // Sostituzione: Numero gatti dell'associazione
                TextColumn::make('cats_as_associazione_count')
                    ->label('🐱 Gatti')
                    ->counts('catsAsAssociazione')
                    ->sortable()
                    ->url(fn (User $record) => CatResource::getUrl('index', [
                        'tableFilters' => [
                            'associazione_id' => ['value' => (string) $record->id],
                        ],
                    ]))
                    ->openUrlInNewTab(),
                
                // Sostituzione: Stato completamento dettagli registrazione (già presente)
                BadgeColumn::make('association_details_completed')
                    ->label('📝 Dettagli')
                    ->colors([
                        'success' => true,
                        'danger' => false,
                    ])
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Completati' : 'Incompleti'),
                
                BadgeColumn::make('email_verified_at')
                    ->label('✅ Email')
                    ->colors([
                        'success' => fn ($state) => $state !== null,
                        'danger' => fn ($state) => $state === null,
                    ])
                    ->formatStateUsing(fn ($state): string => $state ? 'Verificata' : 'Non Verificata'),
                
                TextColumn::make('created_at')
                    ->label('📅 Registrazione')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->since(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('association_details_completed')
                    ->label('Dettagli Completati')
                    ->placeholder('Tutti')
                    ->trueLabel('Solo completati')
                    ->falseLabel('Solo incompleti'),
                
                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label('Email Verificata')
                    ->placeholder('Tutti')
                    ->trueLabel('Solo verificate')
                    ->falseLabel('Solo non verificate'),
                
                Tables\Filters\Filter::make('has_coordinates')
                    ->label('Con Coordinate')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('latitude')->whereNotNull('longitude')),
                
                Tables\Filters\SelectFilter::make('provincia')
                    ->label('Provincia')
                    ->options(function (): array {
                        return User::where('role', 'associazione')
                            ->whereNotNull('provincia')
                            ->pluck('provincia', 'provincia')
                            ->toArray();
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Visualizza'),
                Tables\Actions\EditAction::make()
                    ->label('Modifica'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListAssociations::route('/'),
            'create' => Pages\CreateAssociation::route('/create'),
            'view' => Pages\ViewAssociation::route('/{record}'),
            'edit' => Pages\EditAssociation::route('/{record}/edit'),
        ];
    }
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', 'associazione');
    }
}
