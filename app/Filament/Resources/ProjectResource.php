<?php

namespace App\Filament\Resources;

use Filament\Resources\Resource;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\View;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;
use App\Filament\Forms\Components\MediaImagePicker;
use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Services\FormComponents;
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
use App\Models\Page;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use RalphJSmit\Filament\SEO\SEO;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationGroup = 'Projects';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';

    public static function shouldRegisterNavigation(): bool
    {
        return cms('projects_enabled') ?: false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make([
                    Tabs::make('Label')
                        ->tabs([
                            Tabs\Tab::make('Content')
                                ->schema([
                                    FormComponents::titleSlug(Project::class),
                                    Textarea::make('summary')
                                        ->required()
                                        ->rows(3)
                                        ->columnSpanFull(),
                                    TiptapEditor::make('content')
                                        ->columnSpanFull(),
                                    FormComponents::contentBlocks()
                                        ->columnSpanFull(),
                                ]),
                            Tabs\Tab::make('Featured Image')
                                ->schema([
                                    FormComponents::featuredImage(),
                                ]),
                            Tabs\Tab::make('Header')
                                ->schema([
                                    FormComponents::headerSection(),
                                ]),
                            Tabs\Tab::make('SEO')
                                ->schema([
                                    FormComponents::seo(),
                                ]),
                        ])
                        ->contained(true),
                ])->columnSpan([12, 'lg' => 8, 'xl' => 9]),

                Group::make([
                    Section::make('')->schema([
                        Select::make('project_category_id')
                            ->label('Category')
                            ->inlineLabel()
                            ->relationship('project_category', 'title')
                            ->createOptionForm([
                                TextInput::make('title')
                                    ->required(),
                                TextInput::make('slug')
                                    ->required(),
                                Textarea::make('description'),
                            ]),
                        Toggle::make('visible')
                            ->inlineLabel()
                            ->required(),

                        View::make('filament-navigation::card-divider'),

                        Placeholder::make('created_at')
                            ->label(__('filament-navigation::filament-navigation.attributes.created_at'))
                            ->content(fn (?Project $record) => $record ? $record->created_at->translatedFormat(Table::$defaultDateTimeDisplayFormat) : new HtmlString('&mdash;')),

                        Placeholder::make('updated_at')
                            ->label(__('filament-navigation::filament-navigation.attributes.updated_at'))
                            ->content(fn (?Project $record) => $record ? $record->updated_at->translatedFormat(Table::$defaultDateTimeDisplayFormat) : new HtmlString('&mdash;')),

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
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                ToggleColumn::make('visible'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                CreateAction::make(),
            ])
            ->reorderable('order_column');
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
