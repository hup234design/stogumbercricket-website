<?php

namespace App\Livewire\Blocks;

use Filament\Forms;
use App\Filament\Support\ContentBlock;
use Illuminate\Contracts\View\View;

class ContactBlock extends ContentBlock
{
    public static function block() {
        return Forms\Components\Builder\Block::make('contact-block')
            ->icon('heroicon-o-envelope')
            ->schema([
                ...self::defaultSchema(),
            ]);
    }

    public function render(): View
    {
        return view('livewire.blocks.contact-block');
    }
}
