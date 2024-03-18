<?php

namespace App\Console\Commands;

use App\Models\MediaImage;
use Illuminate\Console\Command;
use Spatie\Image\Image;

class UpdateMediaImageConversions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:update-media-image-conversions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lets Go';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Update Media Image Conversions");

        foreach ( MediaImage::whereNull('conversions')->get() as $mediaImage )
        {
            $conversions = [];

            $image = Image::load( $mediaImage->media[0]->getPath() );

            foreach( config('cms.media_conversions', []) as $conversion=>$config )
            {
                $width = $image->getWidth();
                $height = $image->getHeight();

                $x = max(0, floor(($width - $config['width']) / 2) );
                $y = max(0, floor(($height - $config['height']) / 2) );

                $conversions[ $conversion ] = [
                    'x' => $x,
                    'y' => $y,
                    'width' => $config['width'],
                    'height' => $config['height']
                ];
            }

            $mediaImage->update(['conversions' => $conversions]);

            $this->info("Added conversion for Media Image ID " . $mediaImage->id );
        }

        $this->info("Finished");
    }
}
