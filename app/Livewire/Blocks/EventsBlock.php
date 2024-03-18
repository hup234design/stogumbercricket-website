<?php

namespace App\Livewire\Blocks;

use Filament\Forms;
use FilamentTiptapEditor\TiptapEditor;
use App\Filament\Services\FormComponents;
use App\Filament\Support\ContentBlock;
use App\Models\Event;
use Illuminate\Contracts\View\View;

class EventsBlock extends ContentBlock
{
    public static function block() {
        return Forms\Components\Builder\Block::make('events-block')
            ->label('Events')
            ->icon('heroicon-o-calendar-days')
            ->schema(
                FormComponents::contentBlock(
                    [
                        //
                    ]
                )
            );
    }

    public function render(): View
    {
        return view('livewire.blocks.events-block', [
            'events' => Event::upcoming()->visible()->orderBy('date', 'asc')->take(3)->get(),
        ]);
    }
}
