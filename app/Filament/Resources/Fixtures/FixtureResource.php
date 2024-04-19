<?php

namespace App\Filament\Resources\Fixtures;

use App\Filament\Resources\Fixtures\FixtureResource\Pages;
use App\Filament\Resources\Fixtures\FixtureResource\RelationManagers;
use App\Models\Fixtures\Fixture;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FixtureResource extends Resource
{
    protected static ?string $model = Fixture::class;

    protected static ?string $navigationGroup = "Stogumber CC";
    protected static ?int $navigationSort = 10;
//    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('team_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('opponent_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('venue_id')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('home')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\TextInput::make('start_time'),
                Forms\Components\Toggle::make('cancelled')
                    ->required(),
                Forms\Components\TextInput::make('result')
                    ->maxLength(255),
                Forms\Components\TextInput::make('runs')
                    ->maxLength(255),
                Forms\Components\TextInput::make('overs')
                    ->maxLength(255),
                Forms\Components\TextInput::make('wickets')
                    ->maxLength(255),
                Forms\Components\TextInput::make('note')
                    ->maxLength(255),
                Forms\Components\TextInput::make('opponent_runs')
                    ->maxLength(255),
                Forms\Components\TextInput::make('opponent_overs')
                    ->maxLength(255),
                Forms\Components\TextInput::make('opponent_wickets')
                    ->maxLength(255),
                Forms\Components\TextInput::make('opponent_note')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('team_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('opponent_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('venue_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('home')
                    ->boolean(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time'),
                Tables\Columns\IconColumn::make('cancelled')
                    ->boolean(),
                Tables\Columns\TextColumn::make('result')
                    ->searchable(),
                Tables\Columns\TextColumn::make('runs')
                    ->searchable(),
                Tables\Columns\TextColumn::make('overs')
                    ->searchable(),
                Tables\Columns\TextColumn::make('wickets')
                    ->searchable(),
                Tables\Columns\TextColumn::make('note')
                    ->searchable(),
                Tables\Columns\TextColumn::make('opponent_runs')
                    ->searchable(),
                Tables\Columns\TextColumn::make('opponent_overs')
                    ->searchable(),
                Tables\Columns\TextColumn::make('opponent_wickets')
                    ->searchable(),
                Tables\Columns\TextColumn::make('opponent_note')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListFixtures::route('/'),
            'create' => Pages\CreateFixture::route('/create'),
            'edit' => Pages\EditFixture::route('/{record}/edit'),
        ];
    }
}
