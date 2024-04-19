<?php

namespace App\Filament\Services;

use App\Livewire\Blocks\ClubOfficersBlock;
use App\Livewire\Blocks\DownloadsBlock;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\View;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Table;
use App\Filament\Forms\Components\MediaImagePicker;
use App\Livewire\Blocks\ContactBlock;
use App\Livewire\Blocks\CtaBlock;
use App\Livewire\Blocks\EventsBlock;
use App\Livewire\Blocks\FeaturesBlock;
use App\Livewire\Blocks\GalleryBlock;
use App\Livewire\Blocks\ImageBlock;
use App\Livewire\Blocks\ListBlock;
use App\Livewire\Blocks\PostsBlock;
use App\Livewire\Blocks\RichTextBlock;
use App\Livewire\Blocks\SliderBlock;
use App\Livewire\Blocks\TestimonialsBlock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use RalphJSmit\Filament\SEO\SEO;

class FormComponents {

    public static function contentBlocks() {
        return Builder::make('content_blocks')
            ->label(false)
            ->addActionLabel('Add Content Block')
            ->blockNumbers(false)
            ->schema([
                GalleryBlock::block(),
                RichTextBlock::block(),
                EventsBlock::block(),
                PostsBlock::block(),
                ListBlock::block(),
                ClubOfficersBlock::block(),
                DownloadsBlock::block(),
                ContactBlock::block()
            ])
            ->collapsible()
            ->collapsed(true)
            ->cloneable();
    }

    public static function titleSlug(string $table) {
        return Group::make([
            TextInput::make('title')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn (string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
            TextInput::make('slug')
                ->required()
                ->unique($table, 'slug', ignoreRecord: true)
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, Set $set) => $set('slug', Str::slug($state))),
        ])
            ->columns(2);
    }

    public static function headerSection() {
        return Group::make([
            TextInput::make('header.title'),
            TextInput::make('header.heading'),
            Textarea::make('header.text'),
            MediaImagePicker::make('header_image_id')
                ->label('Header Image')
                ->conversion("banner")
                ->columnSpanFull(),
        ]);
    }

    public static function featuredImage() {
        return Group::make([
            MediaImagePicker::make('featured_image_id')
                ->label(false)
                ->columnSpanFull(),
            Select::make('featured_image_position')
                ->options([
                    'before-title'   => 'Before Title',
                    'before-content' => 'Before Content',
                    'after-content'  => 'After Content'
                ])
                ->default('before_content'),
            Select::make('featured_image_visibility')
                ->options([
                    'desktop-only'  => 'Desktop Only',
                    'mobile-only'  => 'Mobile Only',
                    'hidden'  => 'Hidden',
                ])
                ->placeholder('Visible'),
        ]);
    }

    public static function seo() {
        return Group::make([
            SEO::make(),
            MediaImagePicker::make('seo_image_id')
                ->label('Image')
                ->conversion("seo"),
        ]);
    }

    public static function timestampsSection() {
        return Section::make()
            ->schema([
                View::make('filament-navigation::card-divider'),

                Placeholder::make('created_at')
                    ->label(__('filament-navigation::filament-navigation.attributes.created_at'))
                    ->content(fn (?Page $record) => $record ? $record->created_at->translatedFormat(Table::$defaultDateTimeDisplayFormat) : new HtmlString('&mdash;')),

                Placeholder::make('updated_at')
                    ->label(__('filament-navigation::filament-navigation.attributes.updated_at'))
                    ->content(fn (?Page $record) => $record ? $record->updated_at->translatedFormat(Table::$defaultDateTimeDisplayFormat) : new HtmlString('&mdash;')),
            ]);
    }

    public static function contentBlock($content = [], $options = []) {
        return [
            Group::make([
                Select::make('style')
                    ->inlineLabel()
                    ->live(onBlur: true)
                    ->options([
                        'brand'       => 'Brand',
                        'brand-light' => 'Brand (Light)',
                        'dark'        => 'Dark',
                        'light'       => 'Light',
                        'bgimage'     => 'Background Image',
                    ])
                    ->placeholder('Default')
                    ->selectablePlaceholder('true'),
                Toggle::make('boxed')
                    ->inlineLabel()
                    ->default(false)
                    ->visible(fn (Get $get) => $get('style')),
                MediaImagePicker::make('background_image_id')
                    ->label('Background Image')
                    ->inlineLabel()
                    ->visible(fn (Get $get) => $get('style') == 'bgimage'),
                Toggle::make('include_header')
                    ->inlineLabel()
                    ->live(onBlur: true)
                    ->default(false)
                    ->columnSpanFull()
                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                        $set('header_alignment', $get('header_alignment') ?: 'center');
                    }),
                TextInput::make('header_title')
                    ->inlineLabel()
                    ->visible(fn (Get $get) => $get('include_header')),
                Textarea::make('header_text')
                    ->inlineLabel()
                    ->visible(fn (Get $get) => $get('include_header')),
                Radio::make('header_alignment')
                    ->inlineLabel()
                    ->options([
                        'left' => 'Left',
                        'center' => 'Center',
                    ])
                    ->columns(3)
                    ->visible(fn (Get $get) => $get('include_header'))
            ]),
            ...$content
        ];
//        Tabs::make('content_block')
//            ->tabs([
//                Tabs\Tab::make('Content')
//                    ->schema([
//                        ...$content
//                    ]),
//                Tabs\Tab::make('Header')
//                    ->schema([
//                        TextInput::make('header_title')
//                            ->inlineLabel(),
//                        Textarea::make('header_text')
//                            ->inlineLabel(),
//                        Radio::make('header_alignment')
//                            ->inlineLabel()
//                            ->options([
//                                'left' => 'Left',
//                                'center' => 'Center',
//                                'right' => 'Right',
//                            ])
//                            ->columns(3)
//                    ]),
//                Tabs\Tab::make('Options')
//                    ->schema([
//                        ...$options
//                    ])
//            ]);
    }
}
