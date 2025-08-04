<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Support\Enums\FontWeight;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationLabel = 'Richieste di Contatto';

    protected static ?string $modelLabel = 'Richiesta di Contatto';

    protected static ?string $pluralModelLabel = 'Richieste di Contatto';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informazioni Contatto')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('subject')
                            ->label('Oggetto')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('message')
                            ->label('Messaggio')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ])->columns(2),
                
                Forms\Components\Section::make('Stato')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Stato')
                            ->options([
                                'new' => 'Nuovo',
                                'read' => 'Letto',
                                'replied' => 'Risposto',
                            ])
                            ->default('new')
                            ->required(),
                        Forms\Components\DateTimePicker::make('read_at')
                            ->label('Data di Lettura')
                            ->nullable(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Medium),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Oggetto')
                    ->searchable()
                    ->sortable()
                    ->limit(60)
                    ->wrap()
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 60 ? $state : null;
                    }),

                Tables\Columns\TextColumn::make('message')
                    ->label('Anteprima Messaggio')
                    ->limit(80)
                    ->wrap()
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 80 ? $state : null;
                    })
                    ->toggleable()
                    ->toggledHiddenByDefault(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Stato')
                    ->colors([
                        'danger' => 'new',
                        'warning' => 'read',
                        'success' => 'replied',
                    ])
                    ->formatStateUsing(function (string $state): string {
                        return match ($state) {
                            'new' => 'Nuovo',
                            'read' => 'Letto',
                            'replied' => 'Risposto',
                            default => $state,
                        };
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data Creazione')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('read_at')
                    ->label('Data Lettura')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable()
                    ->placeholder('Non letto'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Stato')
                    ->options([
                        'new' => 'Nuovo',
                        'read' => 'Letto',
                        'replied' => 'Risposto',
                    ]),

                Filter::make('created_at')
                    ->label('Data Creazione')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Dal'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Al'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Visualizza'),
                Tables\Actions\EditAction::make()
                    ->label('Modifica'),
                Tables\Actions\Action::make('markAsRead')
                    ->label('Segna come Letto')
                    ->icon('heroicon-o-eye')
                    ->color('warning')
                    ->action(function (Contact $record): void {
                        $record->markAsRead();
                    })
                    ->visible(fn (Contact $record): bool => $record->isNew()),
                Tables\Actions\Action::make('markAsReplied')
                    ->label('Segna come Risposto')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(function (Contact $record): void {
                        $record->markAsReplied();
                    })
                    ->visible(fn (Contact $record): bool => !$record->isReplied()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Elimina Selezionati'),
                    Tables\Actions\BulkAction::make('markAsRead')
                        ->label('Segna come Letti')
                        ->icon('heroicon-o-eye')
                        ->color('warning')
                        ->action(function ($records): void {
                            foreach ($records as $record) {
                                if ($record->isNew()) {
                                    $record->markAsRead();
                                }
                            }
                        }),
                    Tables\Actions\BulkAction::make('markAsReplied')
                        ->label('Segna come Risposti')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records): void {
                            foreach ($records as $record) {
                                if (!$record->isReplied()) {
                                    $record->markAsReplied();
                                }
                            }
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->defaultPaginationPageOption(25);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Dettagli del Contatto')
                    ->schema([
                        Infolists\Components\TextEntry::make('name')
                            ->label('Nome')
                            ->weight(FontWeight::Bold),
                        Infolists\Components\TextEntry::make('email')
                            ->label('Email')
                            ->copyable()
                            ->icon('heroicon-m-envelope'),
                        Infolists\Components\TextEntry::make('subject')
                            ->label('Oggetto')
                            ->weight(FontWeight::Medium),
                        Infolists\Components\TextEntry::make('message')
                            ->label('Messaggio')
                            ->columnSpanFull()
                            ->prose(),
                    ])->columns(2),

                Infolists\Components\Section::make('Informazioni di Sistema')
                    ->schema([
                        Infolists\Components\TextEntry::make('status')
                            ->label('Stato')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'new' => 'danger',
                                'read' => 'warning', 
                                'replied' => 'success',
                                default => 'gray',
                            })
                            ->formatStateUsing(function (string $state): string {
                                return match ($state) {
                                    'new' => 'Nuovo',
                                    'read' => 'Letto',
                                    'replied' => 'Risposto',
                                    default => $state,
                                };
                            }),
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Data Creazione')
                            ->dateTime('d/m/Y H:i'),
                        Infolists\Components\TextEntry::make('read_at')
                            ->label('Data Lettura')
                            ->dateTime('d/m/Y H:i')
                            ->placeholder('Non ancora letto'),
                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Ultimo Aggiornamento')
                            ->dateTime('d/m/Y H:i'),
                    ])->columns(2),
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
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'view' => Pages\ViewContact::route('/{record}'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'new')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $newCount = static::getModel()::where('status', 'new')->count();
        return $newCount > 0 ? 'danger' : null;
    }
}