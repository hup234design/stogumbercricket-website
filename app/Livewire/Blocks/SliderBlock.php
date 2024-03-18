<?php

namespace App\Livewire\Blocks;

use Filament\Forms;
use App\Filament\Support\ContentBlock;
use Illuminate\Contracts\View\View;

class SliderBlock extends ContentBlock
{
    public static function block() {
        return Forms\Components\Builder\Block::make('slider-block')
            ->icon('heroicon-m-arrows-right-left')
            ->schema([
                ...self::defaultSchema(),
            ]);
    }

    public function render(): View
    {
        return view('livewire.blocks.slider-block');
    }
}
