<?php

namespace App\Livewire\Blocks;

use Filament\Forms;
use App\Filament\Forms\Components\MediaGalleryPicker;
use App\Filament\Forms\Components\MediaImagePicker;
use App\Filament\Services\FormComponents;
use App\Filament\Support\ContentBlock;
use Illuminate\Contracts\View\View;

class GalleryBlock extends ContentBlock
{
    public static function block() {
        return Forms\Components\Builder\Block::make('gallery-block')
            ->label('Gallery')
            ->icon('heroicon-o-squares-2x2')
            ->schema(
                FormComponents::contentBlock(
                    [
                        Forms\Components\Group::make([
                            Forms\Components\Select::make('layout')
                                ->options([
                                    'columns' => 'Columns',
                                    'mosaic' => 'Mosaic',
                                    'slider' => 'Slider'
                                ])
                                ->default('columns')
                                ->live(true),
                            Forms\Components\Select::make('columns')
                                ->options([
                                    3 => 3,
                                    4 => 4,
                                    5 => 5,
                                    6 => 6
                                ])
                                ->default(4),
                            Forms\Components\Select::make('rounded')
                                ->options([
                                    'no' => 'No',
                                    'yes' => 'Yes',
                                    'circle' => 'Circle'
                                ])
                                ->default('no'),
                        ])
                            ->columns(3),
                        MediaGalleryPicker::make('media_image_ids')
                            ->required(),
                    ]
                )
            );
    }

    public function render(): View
    {
        return view('livewire.blocks.gallery-block');
    }
}
