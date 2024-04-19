<?php

namespace App\Filament\Resources;

use App\Livewire\Blocks\ClubOfficersBlock;
use Carbon\Carbon;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\View;
use FilamentTiptapEditor\TiptapEditor;
use App\Filament\Forms\Components\MediaImagePicker;
use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Livewire\Blocks\ContactBlock;
use App\Livewire\Blocks\CtaBlock;
use App\Livewire\Blocks\EventsBlock;
use App\Livewire\Blocks\FeaturesBlock;
use App\Livewire\Blocks\GalleryBlock;
use App\Livewire\Blocks\ImageBlock;
use App\Livewire\Blocks\PostsBlock;
use App\Livewire\Blocks\RichTextBlock;
use App\Livewire\Blocks\SliderBlock;
use App\Livewire\Blocks\TestimonialsBlock;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Page;
use App\Models\Slider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use RalphJSmit\Filament\SEO\SEO;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationGroup = null;
    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([
                    Forms\Components\Tabs::make('Label')
                        ->tabs([
                            Forms\Components\Tabs\Tab::make('CONTENT')
                                ->schema([
                                    Group::make([
                                        Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                                        Forms\Components\TextInput::make('slug')
                                            ->required()
                                            ->unique(Event::class, 'slug', ignoreRecord: true)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state))),
                                    ])
                                        ->columns(2),
                                    Forms\Components\Textarea::make('summary')
                                        ->required()
                                        ->rows(3)
                                        ->columnSpanFull(),
                                    TiptapEditor::make('content')
                                        ->columnSpanFull(),
                                    Forms\Components\Builder::make('content_blocks')
                                        ->label(false)
                                        ->addActionLabel('Add Content Block')
                                        ->blockNumbers(false)
                                        ->schema([
                                            ImageBlock::block(),
                                            GalleryBlock::block(),
                                            ContactBlock::block(),
                                            CtaBlock::block(),
                                            RichTextBlock::block(),
                                            EventsBlock::block(),
                                            FeaturesBlock::block(),
                                            PostsBlock::block(),
                                            SliderBlock::block(),
                                            TestimonialsBlock::block(),
                                            ClubOfficersBlock::block(),
                                        ])
                                        ->columnSpanFull()
                                        ->collapsible()
                                        ->collapsed(true)
                                        ->hiddenOn('create'),
                                ]),
                            Forms\Components\Tabs\Tab::make('FEATURED IMAGE')
                                ->schema([
                                    MediaImagePicker::make('featured_image_id')
                                        ->label(false)
                                        ->columnSpanFull(),
                                    Forms\Components\Select::make('featured_image_position')
                                        ->options([
                                            'before-title'   => 'Before Title',
                                            'before-content' => 'Before Content',
                                            'after-content'  => 'After Content'
                                        ])
                                        ->default('before_content'),
                                    Forms\Components\Select::make('featured_image_visibility')
                                        ->options([
                                            'desktop-only'  => 'Desktop Only',
                                            'mobile-only'  => 'Mobile Only',
                                            'hidden'  => 'Hidden',
                                        ])
                                        ->placeholder('Visible'),
                                ]),
                            Forms\Components\Tabs\Tab::make('HEADER')
                                ->schema([
                                    Group::make([
                                        Forms\Components\TextInput::make('header.title'),
                                        Forms\Components\TextInput::make('header.heading'),
                                        Forms\Components\Textarea::make('header.text'),
                                        MediaImagePicker::make('header_image_id')
                                            ->label('Header Image')
                                            ->conversion("banner")
                                            ->columnSpanFull(),
                                    ])
                                ]),
                            Forms\Components\Tabs\Tab::make('SEO')
                                ->schema([
                                    SEO::make(),
                                    MediaImagePicker::make('seo_image_id')
                                        ->label('Image')
                                        ->conversion("seo"),
                                ]),
                        ])
                        ->contained(true),
                ])->columnSpan([12, 'lg' => 8, 'xl' => 9]),

                Group::make([
                    Section::make('')->schema([
                        Forms\Components\Select::make('event_category_id')
                            ->label('Category')
                            ->inlineLabel()
                            ->relationship('event_category', 'title')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('title')
                                    ->required(),
                                Forms\Components\TextInput::make('slug')
                                    ->required(),
                                Forms\Components\Textarea::make('description'),
                            ]),
                        Forms\Components\DatePicker::make('date')
                            ->inlineLabel()
                            ->native(false)
                            ->default(Carbon::now())
                            ->closeOnDateSelection(),
                        Forms\Components\TimePicker::make('start_time')
                            ->inlineLabel()
                            ->native(false)
                            ->seconds(false),
                        Forms\Components\TimePicker::make('end_time')
                            ->inlineLabel()
                            ->native(false)
                            ->seconds(false)
                            ->visible(fn(Forms\Get $get) => $get('start_time')),
                        Forms\Components\Toggle::make('visible')
                            ->inlineLabel()
                            ->required(),
                        View::make('filament-navigation::card-divider'),
                        Placeholder::make('created_at')
                            ->label(__('filament-navigation::filament-navigation.attributes.created_at'))
                            ->content(fn (?Event $record) => $record ? $record->created_at->translatedFormat(Table::$defaultDateTimeDisplayFormat) : new HtmlString('&mdash;')),
                        Placeholder::make('updated_at')
                            ->label(__('filament-navigation::filament-navigation.attributes.updated_at'))
                            ->content(fn (?Event $record) => $record ? $record->updated_at->translatedFormat(Table::$defaultDateTimeDisplayFormat) : new HtmlString('&mdash;')),
                    ]),
                ])->columnSpan([12, 'lg' => 4, 'xl' => 3]),
            ])
            ->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated(true)
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->date(),
                Tables\Columns\TextColumn::make('start_time')
                    ->time(),
                Tables\Columns\ToggleColumn::make('visible'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
