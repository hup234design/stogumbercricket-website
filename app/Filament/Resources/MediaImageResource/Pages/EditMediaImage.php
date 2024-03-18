<?php

namespace App\Filament\Resources\MediaImageResource\Pages;

use App\Filament\Resources\MediaImageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Image;

class EditMediaImage extends EditRecord
{
    protected static string $resource = MediaImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $originalImagePath = $record->getFirstMedia('media_images')->getPath();

        $conversions = [];


        foreach($data['conversions'] as $conversion=>$conversion_data)
        {
            $conversionPath = $record->getFirstMedia('media_images')->getPath($conversion);
            $originalImage = Image::load( $originalImagePath );

            $conversions[$conversion] = [
                'x' => floor($conversion_data['x']),
                'y' => floor($conversion_data['y']),
                'width' => floor($conversion_data['width']),
                'height' => floor($conversion_data['height']),
            ];

            $originalImage->manualCrop(
                $conversions[$conversion]['width'],
                $conversions[$conversion]['height'],
                $conversions[$conversion]['x'],
                $conversions[$conversion]['y']
            )
                ->optimize()
                ->width( config('cms.media_conversions.' . $conversion . '.width' ) )
                ->save( $conversionPath );
        }

        return parent::handleRecordUpdate($record, [
            'alt' => $data['alt'],
            'caption' => $data['caption'],
            'conversions' => $conversions
        ]);
    }

//    protected function handleRecordCreation(array $data): Model
//    {
//        $mediaImage = null;
//
//        foreach ($data['images'] as $filename) {
//            // get original filename
//            $originalFilename = $data['original_file_names'][$filename];
//            $alt = Str::headline(pathinfo($originalFilename, PATHINFO_FILENAME));
//
//            $mediaImage = MediaImage::create([
//                'original_filename' => $originalFilename,
//                'alt' => $alt
//            ]);
//
//            $mediaImage
//                ->addMediaFromDisk($filename, 'public')
//                ->toMediaCollection('media_images', 'media');
//        }
//
//        return $mediaImage;
//    }
}
