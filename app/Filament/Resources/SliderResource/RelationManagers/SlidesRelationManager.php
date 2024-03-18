<?php

namespace App\Filament\Resources\SliderResource\RelationManagers;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Filament\Forms\Components\MediaImagePicker;
use App\Models\MediaImage;
use Filament\Resources\RelationManagers\RelationManager;

class SlidesRelationManager extends RelationManager
{
    protected static string $relationship = 'slides';

    protected static ?string $recordTitleAttribute = 'heading';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('subheading')
                    ->nullable()
                    ->maxLength(255),
                TextInput::make('heading')
                    ->required()
                    ->maxLength(255),
                Textarea::make('text')
                    ->nullable()
                    ->rows(3),
                MediaImagePicker::make('media_image_id')
                    ->label('Slide Image')
                    ->afterStateHydrated(function (MediaImagePicker $component, $state) {
                        if ($state && ! MediaImage::where('id', $state)->exists() ) {
                            $component->state(null);
                        }
                    }),
            ])
            ->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('heading'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->slideOver(),
            ])
            ->actions([
                EditAction::make()
                    ->slideOver(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->defaultSort('order_column', 'ASC')
            ->reorderable('order_column');;
    }
}
