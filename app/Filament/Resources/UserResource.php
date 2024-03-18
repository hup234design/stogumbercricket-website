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
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationGroup = 'Site Management';
    protected static ?string $navigationIcon = 'heroicon-o-users';

//    public static function shouldRegisterNavigation(): bool
//    {
//        return auth()->user()->hasRole('admin');
//    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->required()
                    ->email(),
//                    ->unique(table: static::$model, ignorable: fn ($record) => $record),
                Forms\Components\TextInput::make('password')
                    ->same('passwordConfirmation')
                    ->password()
                    ->maxLength(255)
                    ->required(fn ($component, $get, $livewire, $model, $record, $set, $state) => $record === null)
                    ->dehydrateStateUsing(fn ($state) => ! empty($state) ? Hash::make($state) : '')
                    ->hiddenOn('edit'),
                Forms\Components\TextInput::make('passwordConfirmation')
                    ->password()
                    ->dehydrated(false)
                    ->maxLength(255)
                    ->hiddenOn('edit'),
                Forms\Components\Select::make('roles')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->preload('true'),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->label('ID'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('roles.name'),
//                Tables\Columns\IconColumn::make('email_verified_at')
//                    ->options([
//                        'heroicon-o-check-circle',
//                        'heroicon-o-x-circle' => fn ($state): bool => $state === null,
//                    ])
//                    ->colors([
//                        'success',
//                        'danger' => fn ($state): bool => $state === null,
//                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('Y-m-d H:i:s'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('email_verified_at')
                    ->nullable(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                    ->hidden(fn(User $record) => ! auth()->user()->hasRole('admin') || $record->id == auth()->user()->id),
                Tables\Actions\EditAction::make()
                    ->slideOver(),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
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
        ];
    }
}
