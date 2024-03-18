<?php

namespace App\Livewire;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use App\Filament\Forms\Components\MediaImagePicker;
use App\Models\MediaImage;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\Image\Image;

class MediaBrowser extends Component implements HasTable, HasForms, HasActions
{
    use InteractsWithTable;
    use InteractsWithForms;
    use InteractsWithActions;

    public string $modalId;
    public string $statePath;
    public string $conversion = "thumbnail";
    public bool $multiple = false;

    public array|null $selectMediaImageIds = [];

    public int|null $mediaImageId = null;
    public array|null $mediaImageIds = [];
    public MediaImage $mediaImage;
    public array|null $mediaImagePageUsage = [];
    public array|null $mediaImageSlideUsage = [];

    public $imgDimensions = "";
    public $imgSize = "";

    public function table(Table $table): Table
    {
        return $table
            ->query(
                MediaImage::query()
                    ->when(! $this->multiple, function($query) {
                        $query->where('id', '!=', $this->mediaImageId);
                    })
                    ->when($this->multiple, function($query) {
                        $query->whereNotIn('id', $this->mediaImageIds);
                    })
            )
            ->contentGrid([
                'sm' => 2,
                'md' => 4,
                'lg' => 6,
            ])
            ->paginated([12, 24, 36, 48, 60, 'all'])
            ->columns([
                Stack::make([
                    SpatieMediaLibraryImageColumn::make('media_image')
                        ->collection('media_images')
                        ->conversion("thumbnail")
                        ->width('100%')
                        ->height('auto')
                        ->action(function (MediaImage $record): void {
                            if(! $this->multiple) {
                                $this->mediaImage = $record;
                                $image = Image::load($record->getFirstMedia('media_images')->getPath());
                                //$this->size = $image->getSize();
                                $this->imgDimensions = $image->getWidth() . " x " . $image->getHeight();

                                $units = array('B', 'KB', 'MB', 'GB', 'TB');
                                $bytes = max($record->getFirstMedia('media_images')->size, 0);
                                $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
                                $pow = min($pow, count($units) - 1);
                                $bytes /= (1 << (10 * $pow));
                                $this->imgSize = round($bytes, 2) . ' ' . $units[$pow];

                                $this->mediaImageId = $record->getKey();
                                $this->mediaImagePageUsage = $record->getPageUsage();
                                $this->mediaImageSlideUsage = $record->getSlideUsage();
                            }
                        }),
                    TextColumn::make('alt')
                        ->searchable(),
                ])
            ])
            ->filters([
                // ...
            ])
            ->actions([
                \Filament\Tables\Actions\Action::make('Select')
                    ->label('Select This Image')
                    ->action(function(MediaImage $record) {
                        $this->dispatch('insert-media-image',
                            statePath: $this->statePath,
                            media_image: $record->id
                        );
                    })
                    ->hidden(fn() => $this->multiple),
                \Filament\Tables\Actions\Action::make('Insert')
                    ->label('Insert This Image')
                    ->action(function(MediaImage $record) {
                        if(! in_array($record->id, $this->selectMediaImageIds) ) {
                            $this->selectMediaImageIds[] = $record->id;
                        }
//                        $this->mediaImageIds[] = $record->id;
//                        $this->dispatch('insert-gallery-image',
//                            statePath: $this->statePath,
//                            media_image: $record->id
//                        );
                    })
                    ->visible(fn(MediaImage $record) => $this->multiple && ! in_array($record->id, $this->selectMediaImageIds)),
            ])
            ->bulkActions([
                // ...
            ])
            ->headerActions([
                Action::make('Upload')
                    ->label('Upload Images')
                    ->form([
                        FileUpload::make('images')
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
                    ])
                    ->action(function (array $data): void {
                        foreach ($data['images'] as $filename) {
                            // get original filename
                            $originalFilename = $data['original_file_names'][$filename];
                            $alt = Str::headline(pathinfo($originalFilename, PATHINFO_FILENAME));

                            $image = Image::load( storage_path('app/public/' . $filename)  );
                            $width = $image->getWidth();
                            $height = $image->getHeight();

                            $conversions = [];

                            foreach ( config('cms.media_conversions', []) as $conversion=>$conversion_data )
                            {
                                $x = max(0, floor(($width - $conversion_data['width']) / 2) );
                                $y = max(0, floor(($height - $conversion_data['height']) / 2) );

                                $conversions[$conversion] = [
                                    'x' => $x,
                                    'y' => $y,
                                    'width' => $conversion_data['width'],
                                    'height' => $conversion_data['height'],
                                ];
                            }

                            $mediaImage = MediaImage::create([
                                'original_filename' => $originalFilename,
                                'alt' => $alt,
                                'conversions' => $conversions,
                            ]);

                            $mediaImage
                                ->addMediaFromDisk($filename, 'public')
                                ->toMediaCollection('media_images', 'media');
                        }
                    })
            ]);
    }


//    public function selectImage()
//    {
//        $this->dispatch('insert-media-image',
//            statePath: $this->statePath,
//            media_image: $this->mediaImageId
//        );
//    }

    public function selectAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('select')
            ->label('Use This Image')
            ->action(function() {
                if( $this->multiple ) {
                    //$this->mediaImageIds[] = $this->mediaImageId;
                    $this->selectMediaImageIds[] = $this->mediaImageId;
                } else {
//                    $event = $this->multiple ? 'insert-gallery-image' : 'insert-media-image';
                    $this->dispatch('insert-media-image',
                        statePath: $this->statePath,
                        media_image: $this->mediaImageId
                    );
                }
            });
    }

    public function selectMultipleAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('selectMultiple')
            ->label('Use These Images')
            ->action(function() {
                $this->dispatch('insert-gallery-images',
                    statePath: $this->statePath,
                    media_images: $this->selectMediaImageIds
                );
            });
    }

    public function duplicateAction(): \Filament\Actions\Action
    {
        return \Filament\Actions\Action::make('duplicate')
            ->requiresConfirmation()
            ->action(function() {
                $media = $this->mediaImage->getFirstMedia('media_images');
                $duplicate = MediaImage::create([
                    'original_filename' => $this->mediaImage->original_filename . "(copy)",
                    'alt' => $this->mediaImage->alt . "(copy)",
                    'caption' => $this->mediaImage->caption
                ]);
                $duplicate->copyMedia($media->getPath())->toMediaCollection('media_images');

                $this->mediaImage = $duplicate;
                $this->mediaImageId = $duplicate->getKey();
            });
    }

    public function removeSelectedImage($idx) {
        unset($this->selectMediaImageIds[$idx]);
    }

    public function mount() {
        if ($this->mediaImageId && $mediaImage = MediaImage::find($this->mediaImageId)) {
            $this->mediaImage = $mediaImage;
        } else {
            $this->mediaImageId = null;
        }
    }

    public function render()
    {
        return view('livewire.media-browser');
    }
}
