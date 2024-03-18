<?php

namespace App\Filament\Resources\MediaImageResource\Pages;

use App\Filament\Resources\MediaImageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\MediaImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Image\Image;

class CreateMediaImage extends CreateRecord
{
    protected static string $resource = MediaImageResource::class;

    protected static bool $canCreateAnother = false;

    protected function handleRecordCreation(array $data): Model
    {
        $mediaImage = null;

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

        return $mediaImage;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
