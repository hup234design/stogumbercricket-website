<?php

namespace App\Filament\Support;

use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Filament\Forms\Components\MediaImagePicker;
use App\Models\MediaImage;
use Livewire\Component;

class ContentBlock extends Component
{
    public $data = [];

    public static function defaultSchema() {
        return [
//            Group::make([
//                Group::make([
//                    Toggle::make('include_header')
//                        ->label('Header')
//                        ->live(onBlur: true)
//                        ->default(false)
//                        ->afterStateUpdated(function (Set $set, Get $get, $state) {
//                            $set('header_alignment', $get('header_alignment') ?: 'center');
//                        }),
//                    Toggle::make('full_width')
//                        ->default(false),
//                    Select::make('style')
//                        ->live(onBlur: true)
//                        ->options([
//                            'brand'       => 'Brand',
//                            'brand-light' => 'Brand (Light)',
//                            'dark'        => 'Dark',
//                            'light'       => 'Light',
//                            'bgimage'     => 'Background Image',
//                        ])
//                        ->placeholder('Default')
//                        ->selectablePlaceholder('true'),
//                ]),
//                //Group::make([
//                    Section::make('Header')
//                        ->schema([
//                            TextInput::make('header_title')
//                                ->inlineLabel(),
//                            Textarea::make('header_text')
//                                ->inlineLabel(),
//                            Radio::make('header_alignment')
//                                ->inlineLabel()
//                                ->options([
//                                    'left' => 'Left',
//                                    'center' => 'Center',
//                                    'right' => 'Right',
//                                ])
//                                ->columns(3)
//                        ])
//                        ->collapsible(),
//                        //->visible(fn (Get $get) => $get('include_header')),
//
//                    Section::make('Background Image')
//                        ->schema([
//                            MediaImagePicker::make('background_image_id')
//                                ->columnSpanFull(),
//                        ])
//                        ->collapsible()
//                        ->collapsed()
//                        ->visible(fn (Get $get) => $get('style') == 'block-bgimage'),
//                ])
//                    ->columnSpan(3)
//            ])
//                ->columns(4),
        ];
    }

    public function mount($data = [])
    {
        $this->data = $data;
    }
}
