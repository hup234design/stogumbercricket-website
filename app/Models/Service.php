<?php

namespace App\Models;

use App\Concerns\HasMediaImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Service extends Model implements Sortable
{
    use HasMediaImages;
    use SortableTrait;
    use HasFactory;
    use HasSEO;

    protected $guarded = [];

    protected $casts = [
        'content_blocks' => 'array',
        'header' => 'array',
        'visible' => 'boolean',
    ];

    public function getDynamicSEOData(): SEOData
    {
        $image_id = $this->seo_image_id ?: $this->featured_image_id;

        return new SEOData(
            image: $image_id ? MediaImage::find($image_id)?->getFirstMediaUrl('media_images', 'seo') : null,
        );
    }

    public function service_category() : BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function scopeVisible($query) {
        return $query->where('visible', true);
    }

}
