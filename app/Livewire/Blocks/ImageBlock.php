<?php

namespace App\Livewire\Blocks;

use Filament\Forms;
use FilamentTiptapEditor\TiptapEditor;
use App\Filament\Forms\Components\MediaImagePicker;
use App\Filament\Services\FormComponents;
use App\Filament\Support\ContentBlock;
use App\Models\MediaImage;
use Illuminate\Contracts\View\View;

class ImageBlock extends ContentBlock
{
    public static function block() {
        return Forms\Components\Builder\Block::make('image-block')
            ->label('Image')
            ->icon('heroicon-o-photo')
            ->schema(
                FormComponents::contentBlock(
                    [
                        MediaImagePicker::make('media_image_id')
                            ->required(),
                    ]
                )
            );
    }

    public function render(): View
    {
        return view('livewire.blocks.image-block');
    }
}
