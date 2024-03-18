<?php

namespace App\Concerns;

use App\Models\MediaImage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasMediaImages
{
    public function featured_image() : BelongsTo
    {
        return $this->belongsTo(MediaImage::class, 'featured_image_id');
    }

    public function header_image() : BelongsTo
    {
        return $this->belongsTo(MediaImage::class, 'header_image_id');
    }

    public function seo_image() : BelongsTo
    {
        return $this->belongsTo(MediaImage::class, 'seo_image_id');
    }
}
