<?php

namespace App\Livewire\Blocks;

use Awcodes\FilamentTableRepeater\Components\TableRepeater;
use Filament\Forms;
use FilamentTiptapEditor\TiptapEditor;
use App\Filament\Forms\Components\MediaImagePicker;
use App\Filament\Services\FormComponents;
use App\Filament\Support\ContentBlock;
use App\Models\Heroicon;
use Illuminate\Contracts\View\View;
use PHPUnit\Metadata\Group;

class ListBlock extends ContentBlock
{
    public static function block() {
        return Forms\Components\Builder\Block::make('list-block')
            ->label('List')
            ->icon('heroicon-m-list-bullet')
            ->schema(
                FormComponents::contentBlock(
                    [
                        TableRepeater::make('items')
                            ->withoutHeader()
                            ->schema([
                                Forms\Components\TextInput::make('text')
                                    ->label(false)
                            ])
                            ->columnSpanFull(),
                                        Forms\Components\Fieldset::make('Layout')
                    ->schema([
                        Forms\Components\Select::make('list_columns')
                            ->options([
                                1 => 1,
                                2 => 2,
                                3 => 3,
                                4 => 4,
                            ])
                            ->required()
                            ->default(1)
                            ->placeholder(null),
                        Forms\Components\Select::make('list_alignment')
                            ->options([
                                'left' => 'Left',
                                'center' => 'Center',
                            ])
                            ->required()
                            ->default('left')
                            ->placeholder(null),
                    ])
                    ->columns(2),

                Forms\Components\Fieldset::make('Icon')
                    ->schema([
                        Forms\Components\Toggle::make('use_icon')
                            ->inline(false)
                            ->default(false)
                            ->live(true),
                        Forms\Components\Select::make('icon_style')
                            ->options([
                                "o" => "Outline",
                                "s" => "Solid",
                            ])
                            ->required()
                            ->default("o")
                            ->placeholder(null)
                            ->visible(fn(Forms\Get $get) => $get('use_icon')),
                        Forms\Components\Select::make('icon')
                            ->options(Heroicon::all()->pluck('name','name'))
                            ->searchable()
                            ->visible(fn(Forms\Get $get) => $get('use_icon')),
                        Forms\Components\ColorPicker::make('color')
                            ->required()
                            ->default('#00FF00')
                            ->visible(fn(Forms\Get $get) => $get('use_icon')),
                        ])
                        ->columns(4),
                    ]
                )
            );
    }

    public function render(): View
    {
        return view('livewire.blocks.list-block');
    }
}
