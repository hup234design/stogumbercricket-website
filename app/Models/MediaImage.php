<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaImage extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'conversions' => 'array'
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        foreach( config('cms.media_conversions', []) as $name=>$data )
        $this->addMediaConversion($name)
            ->fit(Fit::Crop, $data['width'], $data['height'])
            ->quality($data['quality'])
            ->nonQueued();
    }

//    public function getMediaThumbnailAttribute()
//    {
//        return $this->getFirstMedia("media_images")?->getPath('thumbnail');
//    }

    public function getPageUsage() {
        $id = $this->id;

        $pages = Page::query()
            ->select([
                'id', 'title', 'type',
                DB::raw("IF(featured_image_id = $id, TRUE, FALSE) as used_in_featured_image"),
                DB::raw("IF(header_image_id = $id, TRUE, FALSE) as used_in_header_image"),
                DB::raw("IF(seo_image_id = $id, TRUE, FALSE) as used_in_seo_image"),
                DB::raw("IF(JSON_EXTRACT(content_blocks, '$[*].data.background_image_id') = $id OR JSON_EXTRACT(content_blocks, '$[*].data.media_image_id') = $id OR JSON_EXTRACT(content_blocks, '$[*].data.media_image_ids') LIKE '%\"$id\"%', TRUE, FALSE) as used_in_content_blocks")
            ])
            ->where('featured_image_id', $id)
            ->orWhere('header_image_id', $id)
            ->orWhere('seo_image_id', $id)
            ->orWhereRaw('JSON_EXTRACT(content_blocks, "$[*].data.background_image_id") = ?', [$id])
            ->orWhereRaw('JSON_EXTRACT(content_blocks, "$[*].data.media_image_id") = ?', [$id])
            ->orWhereRaw('JSON_EXTRACT(content_blocks, "$[*].data.media_image_ids") LIKE ?', ["%\"$id\"%"])
            ->get();

        $processedResults = $pages->map(function($page) {
            return [
                'id' => $page->id,
                'title' => $page->title,
                'type' => $page->type,
                'used_in' => collect([
                    'featured_image' => $page->used_in_featured_image,
                    'header_image' => $page->used_in_header_image,
                    'seo_image' => $page->used_in_seo_image,
                    'content_blocks' => $page->used_in_content_blocks
                ])->filter()->keys()->all() // Only return the fields where the image is used
            ];
        });

        return $processedResults->toArray();
    }

    public function getSlideUsage() {
        $id = $this->id;

        $slides = Slide::query()
            ->where('media_image_id', $id)
            ->get();

        $processedResults = $slides->map(function($slide) {
            return [
                'id' => $slide->id,
                'heading' => $slide->heading,
                'slider' => $slide->slider->title
            ];
        });

        return $processedResults->toArray();
    }

}
