<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClubOfficerResource\Pages;
use App\Filament\Resources\ClubOfficerResource\RelationManagers;
use App\Models\ClubOfficer;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Filament\Forms\Components\MediaImagePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClubOfficerResource extends Resource
{
    protected static ?string $model = ClubOfficer::class;

    //protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationGroup = 'Stogumber CC';
    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                TextInput::make('role'),
                Textarea::make('description')
                    ->rows(5)
                    ->columnSpanFull(),
                MediaImagePicker::make('media_image_id')
                    ->label('Profile Image')
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID'),
                ImageColumn::make('Profile Image')
                    ->getStateUsing( function(ClubOfficer $record) {
                        return $record
                            ->media_image?->getFirstMedia('media_images')
                            ->getUrl();
                        })
                        ->width(120)
                        ->height('auto'),
//                SpatieMediaLibraryImageColumn::make('media_image')
//                    ->getStateUsing(function (Model $record) {
////                        //return $record->getMediaImage('featured_image')?->original_file_name;
//                        return $record->media_image?->getMedia()[0]->getUrl('thumbnail');
//                    })
//                    ->height(80),
                TextColumn::make('name'),
                TextColumn::make('role'),
                TextColumn::make('created_at')->dateTime(),
                TextColumn::make('updated_at')->since(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
                    ->slideOver(),
            ])
            ->bulkActions([
                ForceDeleteBulkAction::make(),
            ])
            ->defaultSort('order_column', 'ASC')
            ->reorderable('order_column');
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
            'index' => Pages\ListClubOfficers::route('/'),
        ];
    }
}
