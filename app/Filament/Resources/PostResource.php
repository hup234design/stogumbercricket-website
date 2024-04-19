<?php

namespace App\Filament\Resources;

use App\Livewire\Blocks\ClubOfficersBlock;
use Carbon\Carbon;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\View;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use FilamentTiptapEditor\TiptapEditor;
use App\Filament\Forms\Components\MediaImagePicker;
use App\Filament\Resources\PostResource\Pages;
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
use App\Models\Post;
use App\Models\Slider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use RalphJSmit\Filament\SEO\SEO;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationGroup = null;
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

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
                                            ->unique(Post::class, 'slug', ignoreRecord: true)
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
                                    Forms\Components\TextInput::make('header.title'),
                                    Forms\Components\TextInput::make('header.heading'),
                                    Forms\Components\Textarea::make('header.text'),
                                    MediaImagePicker::make('header_image_id')
                                        ->label('Header Image')
                                        ->conversion("banner")
                                        ->columnSpanFull(),
                                ]),
                            Forms\Components\Tabs\Tab::make('SEO')
                                ->schema([
//                                    Section::make()
//                                        ->schema([
                                    SEO::make(),
                                    MediaImagePicker::make('seo_image_id')
                                        ->label('Image')
                                        ->conversion("seo"),
//                                        ])
                                ]),
                        ])
                        ->contained(true),
                ])->columnSpan([12, 'lg' => 8, 'xl' => 9]),

                Group::make([
                    Section::make('')->schema([

                        Forms\Components\Select::make('post_category_id')
                            ->label('Category')
                            ->inlineLabel()
                            ->relationship('post_category', 'title')
                            ->createOptionForm([
                                Forms\Components\TextInput::make('title')
                                    ->required(),
                                Forms\Components\TextInput::make('slug')
                                    ->required(),
                                Forms\Components\Textarea::make('description'),
                            ]),

                        Forms\Components\DateTimePicker::make('publish_at')
                            ->inlineLabel()
                            ->required()
                            ->default(Carbon::now()),

                        Forms\Components\Toggle::make('visible')
                            ->inlineLabel()
                            ->required(),

                        Forms\Components\Toggle::make('featured')
                            ->inlineLabel()
                            ->required(),

                        View::make('filament-navigation::card-divider'),

                        Placeholder::make('created_at')
                            ->label(__('filament-navigation::filament-navigation.attributes.created_at'))
                            ->content(fn (?Post $record) => $record ? $record->created_at->translatedFormat(Table::$defaultDateTimeDisplayFormat) : new HtmlString('&mdash;')),

                        Placeholder::make('updated_at')
                            ->label(__('filament-navigation::filament-navigation.attributes.updated_at'))
                            ->content(fn (?Post $record) => $record ? $record->updated_at->translatedFormat(Table::$defaultDateTimeDisplayFormat) : new HtmlString('&mdash;')),

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
                Tables\Columns\ToggleColumn::make('visible'),
                Tables\Columns\ToggleColumn::make('featured'),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
