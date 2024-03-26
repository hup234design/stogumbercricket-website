<?php

namespace App\Livewire\Blocks;

use App\Filament\Services\FormComponents;
use App\Models\Download;
use Filament\Forms;
use App\Filament\Support\ContentBlock;
use Illuminate\Contracts\View\View;

class DownloadsBlock extends ContentBlock
{
    public static function block() {
        return Forms\Components\Builder\Block::make('downloads-block')
            ->icon('heroicon-o-arrow-down-tray')
            ->schema(
                FormComponents::contentBlock(
                    [
                        Forms\Components\Toggle::make('all')
                            ->inlineLabel()
                            ->label('Include All Documents')
                            ->default(true)
                            ->live(),
                        Forms\Components\Select::make('downloads')
                            ->multiple()
                            ->required()
                            ->options(Download::all()->pluck('title','id'))
                            ->hidden(fn(Forms\Get $get) => $get('all'))
                    ]
                )
            );
    }

    public function render(): View
    {
        $downloads = $this->data['all']
            ? Download::all()
            : Download::whereIn('id', $this->data['downloads'])->get();

        return view('livewire.blocks.downloads-block', compact('downloads'));
    }
}
