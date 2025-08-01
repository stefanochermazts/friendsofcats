<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Columns\BadgeColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Gestione Utenti';

    protected static ?string $modelLabel = 'Utente';

    protected static ?string $pluralModelLabel = 'Utenti';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informazioni Utente')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),
                        
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        
                        Select::make('role')
                            ->label('Ruolo')
                            ->options([
                                'admin' => 'Amministratore',
                                'association' => 'Associazione',
                                'volunteer' => 'Volontario',
                                'owner' => 'Proprietario',
                                'veterinarian' => 'Veterinario',
                                'donor' => 'Donatore',
                                'groomer' => 'Toelettatore',
                            ])
                            ->required()
                            ->default('owner'),
                        
                        Toggle::make('email_verified_at')
                            ->label('Email Verificata')
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Sicurezza')
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
                
                BadgeColumn::make('role')
                    ->label('Ruolo')
                    ->colors([
                        'danger' => 'admin',
                        'warning' => 'association',
                        'success' => 'volunteer',
                        'info' => 'owner',
                        'primary' => 'veterinarian',
                        'secondary' => 'donor',
                        'gray' => 'groomer',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'admin' => 'Amministratore',
                        'association' => 'Associazione',
                        'volunteer' => 'Volontario',
                        'owner' => 'Proprietario',
                        'veterinarian' => 'Veterinario',
                        'donor' => 'Donatore',
                        'groomer' => 'Toelettatore',
                        default => $state,
                    }),
                
                ToggleColumn::make('email_verified_at')
                    ->label('Email Verificata')
                    ->disabled(),
                
                TextColumn::make('created_at')
                    ->label('Data Registrazione')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->label('Ruolo')
                    ->options([
                        'admin' => 'Amministratore',
                        'association' => 'Associazione',
                        'volunteer' => 'Volontario',
                        'owner' => 'Proprietario',
                        'veterinarian' => 'Veterinario',
                        'donor' => 'Donatore',
                        'groomer' => 'Toelettatore',
                    ]),
                
                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->label('Email Verificata'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
