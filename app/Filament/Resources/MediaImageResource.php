<?php

namespace App\Filament\Resources;

use Filament\Actions\Action;
use Filament\Actions\ReplicateAction;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\SpatieMediaLibraryImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use App\Filament\Forms\Components\MediaImageCropper;
use App\Filament\Forms\Components\MediaImagePicker;
use App\Filament\Resources\MediaImageResource\Pages;
use App\Filament\Resources\MediaImageResource\RelationManagers;
use App\Models\MediaImage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Spatie\Image\Image;
use Spatie\MediaLibrary\MediaCollections\FileAdder;

class MediaImageResource extends Resource
{
    protected static ?string $model = MediaImage::class;


    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Site Management';

    protected static ?string $modelLabel = "Image";
    protected static ?string $pluralModelLabel = "Images";

//    public static function infoList(Infolist $infolist): Infolist
//    {
//        return $infolist
//            ->schema([
//                Section::make('Image Details')
//                    ->schema([
//                        SpatieMediaLibraryImageEntry::make('media_image')
//                            ->label(false)
//                            ->collection('media_images')
//                            ->width('100%')
//                            ->height('auto'),
//                        Group::make([
//                            TextEntry::make('original_filename'),
//                            TextEntry::make('alt'),
//                            TextEntry::make('caption')
//                        ])
//                        ->columnSpan(2),
//                    ])
//                    ->columns(3)
//            ]);
//    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('images')
                    ->required()
                    ->multiple()
                    ->storeFileNamesIn('original_file_names')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->columnSpanFull()
                    ->visibleOn('create'),

                Forms\Components\Tabs::make('Conversions')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Image')
                            ->schema([
                                Forms\Components\ViewField::make('image')
                                    ->label(false)
                                    ->view('filament.forms.components.media-image'),
                                Forms\Components\Group::make([
                                    Forms\Components\TextInput::make('alt')
                                        ->required(),
                                    Forms\Components\Textarea::make('caption')
                                        ->rows(5),
                                ]),
                            ])
                            ->columns(2),
                        Forms\Components\Tabs\Tab::make('Banner Conversion')
                            ->schema([
                                Forms\Components\ViewField::make('conversions.banner')
                                    ->label(false)
                                    ->view('filament.forms.components.media-image-cropper')
                                    ->viewData([
                                        'conversion' => 'banner',
                                        'config' => config('cms.media_conversions.banner')
                                    ]),
                            ])
                            ->extraAttributes(['class' => 'p-0']),
                        Forms\Components\Tabs\Tab::make('SEO Conversion')
                            ->schema([
                                Forms\Components\ViewField::make('conversions.seo')
                                    ->label(false)
                                    ->view('filament.forms.components.media-image-cropper')
                                    ->viewData([
                                        'conversion' => 'seo',
                                        'config' => config('cms.media_conversions.seo')
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make('Thumbnail Conversion')
                            ->schema([
                                Forms\Components\ViewField::make('conversions.thumbnail')
                                    ->label(false)
                                    ->view('filament.forms.components.media-image-cropper')
                                    ->viewData([
                                        'conversion' => 'thumbnail',
                                        'config' => config('cms.media_conversions.thumbnail')
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->hiddenOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                        Tables\Columns\Layout\Stack::make([
                            Tables\Columns\SpatieMediaLibraryImageColumn::make('media_image')
                                ->label('Image')
                                ->collection('media_images')
                                ->conversion('thumbnail')
                                ->width('100%')
                                ->height('auto'),
                            Tables\Columns\TextColumn::make('alt')
                                ->searchable()
                                ->description('ALT', 'above')
                                ->extraAttributes(['class' => 'mt-2']),
                            Tables\Columns\TextColumn::make('original_filename')
                                ->searchable()
                                ->description('Original Filename', 'above')
                                ->extraAttributes(['class' => 'mt-2']),
                        ])
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
//                    ->label(false),
                Tables\Actions\DeleteAction::make(),
//                    ->label(false),
                Tables\Actions\Action::make('duplicate')
//                    ->label(false)
                    ->color('info')
                    ->icon('heroicon-s-document-duplicate')
                    ->requiresConfirmation()
                    ->action(function(MediaImage $record) {
                        $media = $record->getFirstMedia('media_images');
                        $duplicate = MediaImage::create([
                            'original_filename' => $record->original_filename,
                            'alt' => $record->alt,
                            'caption' => $record->caption,
                            'conversions' => $record->conversions
                        ]);
                        $duplicate->copyMedia($media->getPath())->toMediaCollection('media_images');
                        redirect()->route('filament.admin.resources.media-images.edit', $duplicate->id);
                    }),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->contentGrid([
                'sm' => 2,
                'md' => 3,
                'lg' => 4,
            ])
            ->paginated([12, 24, 36, 60, 'all']);
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
            'index' => Pages\ListMediaImages::route('/'),
            'create' => Pages\CreateMediaImage::route('/create'),
            'edit' => Pages\EditMediaImage::route('/{record}/edit'),
        ];
    }
}
