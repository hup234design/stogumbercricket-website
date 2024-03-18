<?php

namespace App\Livewire\Blocks;

use Filament\Forms;
use App\Filament\Support\ContentBlock;
use Illuminate\Contracts\View\View;

class CtaBlock extends ContentBlock
{
    public static function block() {
        return Forms\Components\Builder\Block::make('cta-block')
            ->icon('heroicon-o-arrow-top-right-on-square')
            ->schema([
                ...self::defaultSchema(),
            ]);
    }

    public function render(): View
    {
        return view('livewire.blocks.cta-block');
    }
}
