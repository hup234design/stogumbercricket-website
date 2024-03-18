<?php

namespace App\Livewire\Blocks;

use Filament\Forms;
use App\Filament\Support\ContentBlock;
use Illuminate\Contracts\View\View;

class TestimonialsBlock extends ContentBlock
{
    public static function block() {
        return Forms\Components\Builder\Block::make('testimonials-block')
            ->icon('heroicon-o-chat-bubble-left')
            ->schema([
                ...self::defaultSchema(),
            ]);
    }

    public function render(): View
    {
        return view('livewire.blocks.testimonials-block');
    }
}
