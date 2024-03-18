<?php

namespace App\Livewire\Blocks;

use App\Filament\Support\ContentBlock;
use App\Models\ClubOfficer;
use Filament\Forms;
use Illuminate\Contracts\View\View;
use function view;

class ClubOfficersBlock extends ContentBlock
{
    public static function block() {
        return Forms\Components\Builder\Block::make('club-officers-block')
            ->icon('heroicon-m-identification')
            ->schema([
                ...self::defaultSchema(),
            ]);
    }

    public function render(): View
    {
        return view('livewire.blocks.club-officers-block', [
            'club_officers' => ClubOfficer::all(),
        ]);
    }
}
