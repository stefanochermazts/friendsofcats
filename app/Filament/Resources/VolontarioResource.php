<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VolontarioResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;

class VolontarioResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationGroup = 'Utenti';

    protected static ?string $modelLabel = 'Volontario';

    protected static ?string $pluralModelLabel = 'Volontari';

    protected static ?string $slug = 'volontari';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', 'volontario');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informazioni Personali')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome Completo')
                            ->required()
                            ->maxLength(255),
                        
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        
                        TextInput::make('telefono')
                            ->label('Telefono')
                            ->tel()
                            ->maxLength(255),
                        
                        Select::make('locale')
                            ->label('Lingua')
                            ->options([
                                'it' => 'Italiano',
                                'en' => 'English',
                            ])
                            ->default('it'),
                    ])->columns(2),

                Section::make('Dettagli Personali')
                    ->schema([
                        TextInput::make('indirizzo')
                            ->label('Indirizzo')
                            ->maxLength(255),
                        
                        TextInput::make('citta')
                            ->label('Città')
                            ->maxLength(255),
                        
                        TextInput::make('cap')
                            ->label('CAP')
                            ->maxLength(10),
                        
                        TextInput::make('provincia')
                            ->label('Provincia')
                            ->maxLength(255),
                        
                        Select::make('paese')
                            ->label('Paese')
                            ->options([
                                'Italia' => 'Italia',
                                'Svizzera' => 'Svizzera',
                                'Austria' => 'Austria',
                                'Germania' => 'Germania',
                                'Francia' => 'Francia',
                            ])
                            ->default('Italia'),
                        
                        Textarea::make('descrizione')
                            ->label('Descrizione')
                            ->rows(4)
                            ->maxLength(1000),
                    ])->columns(2),

                Section::make('Associazione')
                    ->schema([
                        Select::make('associazione_id')
                            ->label('Associazione di Appartenenza')
                            ->relationship('associazione', 'name')
                            ->searchable()
                            ->preload(),
                        
                        BadgeColumn::make('association_details_completed')
                            ->label('Dettagli Associazione Completati')
                            ->formatStateUsing(fn ($state) => $state ? 'Sì' : 'No')
                            ->colors([
                                'success' => fn ($state) => (bool) $state,
                                'danger' => fn ($state) => ! (bool) $state,
                            ]),
                    ])->columns(2),

                Section::make('Sicurezza')
                    ->schema([
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->dehydrated(fn ($state): bool => filled($state))
                            ->required(fn (string $context): bool => $context === 'create'),
                        
                        TextInput::make('password_confirmation')
                            ->label('Conferma Password')
                            ->password()
                            ->dehydrated(false)
                            ->required(fn (string $context): bool => $context === 'create'),
                        
                        Toggle::make('email_verified_at')
                            ->label('Email Verificata')
                            ->disabled()
                            ->dehydrated(false),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('telefono')
                    ->label('Telefono')
                    ->searchable(),
                
                TextColumn::make('citta')
                    ->label('Città')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('associazione.name')
                    ->label('Associazione')
                    ->searchable()
                    ->sortable(),
                
                BadgeColumn::make('association_details_completed')
                    ->label('Dettagli Completati')
                    ->formatStateUsing(fn ($state) => $state ? 'Sì' : 'No')
                    ->colors([
                        'success' => fn ($state) => (bool) $state,
                        'danger' => fn ($state) => ! (bool) $state,
                    ]),
                
                TextColumn::make('created_at')
                    ->label('Registrato il')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('paese')
                    ->label('Paese')
                    ->options([
                        'Italia' => 'Italia',
                        'Svizzera' => 'Svizzera',
                        'Austria' => 'Austria',
                        'Germania' => 'Germania',
                        'Francia' => 'Francia',
                    ]),
                
                Filter::make('with_association')
                    ->label('Con Associazione')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('associazione_id')),
                
                Filter::make('without_association')
                    ->label('Senza Associazione')
                    ->query(fn (Builder $query): Builder => $query->whereNull('associazione_id')),
                
                Filter::make('association_details_completed')
                    ->label('Dettagli Associazione Completati')
                    ->query(fn (Builder $query): Builder => $query->where('association_details_completed', true)),
                
                Filter::make('association_details_incomplete')
                    ->label('Dettagli Associazione Incompleti')
                    ->query(fn (Builder $query): Builder => $query->where('association_details_completed', false)),
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
            'index' => Pages\ListVolontari::route('/'),
            'create' => Pages\CreateVolontario::route('/create'),
            'edit' => Pages\EditVolontario::route('/{record}/edit'),
        ];
    }
} 