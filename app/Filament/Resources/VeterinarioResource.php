<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VeterinarioResource\Pages;
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
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;

class VeterinarioResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationGroup = 'Professionisti';

    protected static ?string $modelLabel = 'Veterinario';

    protected static ?string $pluralModelLabel = 'Veterinari';

    protected static ?string $slug = 'veterinari';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('role', 'veterinario');
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

                Section::make('Dettagli Professionali')
                    ->schema([
                        TextInput::make('ragione_sociale')
                            ->label('Ragione Sociale')
                            ->maxLength(255),
                        
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
                        
                        TextInput::make('sito_web')
                            ->label('Sito Web')
                            ->url()
                            ->maxLength(255),
                        
                        Textarea::make('descrizione')
                            ->label('Descrizione')
                            ->rows(4)
                            ->maxLength(1000),
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

                Section::make('Stato')
                    ->schema([
                        BadgeColumn::make('professional_details_completed')
                            ->label('Dettagli Professionali Completati')
                            ->formatStateUsing(fn ($state) => $state ? 'Sì' : 'No')
                            ->colors([
                                'success' => fn ($state) => (bool) $state,
                                'danger' => fn ($state) => ! (bool) $state,
                            ]),
                    ]),
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
                
                BadgeColumn::make('professional_details_completed')
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
                
                Filter::make('professional_details_completed')
                    ->label('Dettagli Professionali Completati')
                    ->query(fn (Builder $query): Builder => $query->where('professional_details_completed', true)),
                
                Filter::make('professional_details_incomplete')
                    ->label('Dettagli Professionali Incompleti')
                    ->query(fn (Builder $query): Builder => $query->where('professional_details_completed', false)),
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
            'index' => Pages\ListVeterinari::route('/'),
            'create' => Pages\CreateVeterinario::route('/create'),
            'edit' => Pages\EditVeterinario::route('/{record}/edit'),
        ];
    }
} 