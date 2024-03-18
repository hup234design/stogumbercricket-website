<?php

namespace App\Models;

use Carbon\Carbon;
use App\Concerns\HasMediaImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Post extends Model
{
    use HasMediaImages;
    use HasFactory;
    use HasSEO;

    protected $guarded = [];

    protected $casts = [
        'content_blocks' => 'array',
        'header' => 'array',
        'visible' => 'boolean',
        'publish_at' => 'datetime',
        'featured' => 'boolean',
    ];

    public function getDynamicSEOData(): SEOData
    {
        $image_id = $this->seo_image_id ?: $this->featured_image_id;

        return new SEOData(
            image: $image_id ? MediaImage::find($image_id)?->getFirstMediaUrl('media_images', 'seo') : null,
        );
    }

    public function post_category() : BelongsTo
    {
        return $this->belongsTo(PostCategory::class);
    }

    public function scopeVisible($query)
    {
        return $query->where('visible', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopePublished($query)
    {
        return $query->visible()->where('publish_at', '<=', Carbon::now());
    }

    public function scopeRecent($query)
    {
        return $query->published()->orderBy('publish_at','desc');
    }

    public function getFormattedDateAttribute() {
        return $this->publish_at->format('l jS M Y');
    }

    /*
     * PROJECTS
     */

    public function project_category() : BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class);
    }

    public function scopeProjects($query) {
        return $query->where('type', 'project');
    }

}
