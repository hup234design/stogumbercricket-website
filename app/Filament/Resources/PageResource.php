<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Set;
use FilamentTiptapEditor\TiptapEditor;
use App\Filament\Forms\Components\MediaImagePicker;
use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Filament\Services\FormComponents;
use App\Livewire\Blocks\GalleryBlock;
use App\Livewire\Blocks\ImageBlock;
use App\Models\MediaImage;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Livewire\Blocks\ContactBlock;
use App\Livewire\Blocks\CtaBlock;
use App\Livewire\Blocks\RichTextBlock;
use App\Livewire\Blocks\EventsBlock;
use App\Livewire\Blocks\FeaturesBlock;
use App\Livewire\Blocks\PostsBlock;
use App\Livewire\Blocks\SliderBlock;
use App\Livewire\Blocks\TestimonialsBlock;
use App\Models\Slider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Livewire\Component;
use Pboivin\FilamentPeek\Forms\Actions\InlinePreviewAction;
use RalphJSmit\Filament\SEO\SEO;
use RyanChandler\FilamentNavigation\Models\Navigation;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationGroup = null;
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static bool $showTimestamps = true;

    protected static string $pageType = 'page';

    protected static bool $includeSummary = false;

    public static function getPageType(): ?string
    {
        return static::$pageType;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('type', static::getPageType())
            ->when(static::getPageType() === 'page', function ($query) {
                return $query->orderBy('home', 'desc')->orderBy('order_column', 'asc');
            })
            ->when(static::getPageType() === 'post', function ($query) {
                return $query->orderBy('publish_at', 'desc');
            })
            ->when(static::getPageType() === 'event', function ($query) {
                return $query->orderBy('date', 'desc');
            })
            ->when(static::getPageType() === 'project', function ($query) {
                return $query->orderBy('order_column', 'asc');
            });
    }

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
                                            ->unique(Page::class, 'slug', ignoreRecord: true)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state)))
                                            ->disabled(fn() => static::getPageType() == 'index'),
                                    ])
                                    ->columns(2),
                                    Forms\Components\Textarea::make('summary')
                                        ->required()
                                        ->rows(3)
                                        ->columnSpanFull()
                                        ->visible(static::$includeSummary),
                                    TiptapEditor::make('content')
                                        ->columnSpanFull(),
                                    FormComponents::contentBlocks()
                                        ->columnSpanFull()
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
                                            Forms\Components\Select::make('header_slider_id')
                                                ->label('Slider')
                                                ->options(Slider::all()->pluck('title','id'))
                                                ->live(true),
                                            Group::make([
                                                Forms\Components\TextInput::make('header.title'),
                                                Forms\Components\TextInput::make('header.heading'),
                                                Forms\Components\Textarea::make('header.text'),
                                                MediaImagePicker::make('header_image_id')
                                                    ->label('Header Image')
                                                    ->conversion("banner")
                                                    ->columnSpanFull(),
                                            ])
                                                ->hidden(fn(Forms\Get $get) => $get('header_slider_id'))
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

                        Forms\Components\Toggle::make('visible')
                            ->inlineLabel()
                            ->required()
                            ->visible(fn() => static::getPageType() != 'index'),

                        Forms\Components\Toggle::make('display_title')
                            ->inlineLabel()
                            ->required(),

                        View::make('filament-navigation::card-divider')
                            ->visible(static::$showTimestamps && static::getPageType() != 'index'),

                        Placeholder::make('created_at')
                            ->label(__('filament-navigation::filament-navigation.attributes.created_at'))
                            ->visible(static::$showTimestamps)
                            ->content(fn (?Page $record) => $record ? $record->created_at->translatedFormat(Table::$defaultDateTimeDisplayFormat) : new HtmlString('&mdash;')),

                        Placeholder::make('updated_at')
                            ->label(__('filament-navigation::filament-navigation.attributes.updated_at'))
                            ->visible(static::$showTimestamps)
                            ->content(fn (?Page $record) => $record ? $record->updated_at->translatedFormat(Table::$defaultDateTimeDisplayFormat) : new HtmlString('&mdash;')),

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
                Tables\Columns\IconColumn::make('home')
                    ->boolean()
                    ->visible(fn() => static::getPageType() == 'page'),
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
                Tables\Actions\DeleteAction::make()
                    ->hidden(static::getPageType() == 'index'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->reorderable(static::getPageType() == 'page' ? 'order_column' : null);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
