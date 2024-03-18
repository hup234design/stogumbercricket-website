<?php

namespace App\Models;

use Carbon\Carbon;
use App\Concerns\HasMediaImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Event extends Model
{
    use HasMediaImages;
    use HasFactory;
    use HasSEO;

    protected $guarded = [];

    protected $casts = [
        'content_blocks' => 'array',
        'header' => 'array',
        'visible' => 'boolean',
        'date' => 'date',
    ];

    public function getDynamicSEOData(): SEOData
    {
        $image_id = $this->seo_image_id ?: $this->featured_image_id;

        return new SEOData(
            image: $image_id ? MediaImage::find($image_id)?->getFirstMediaUrl('media_images', 'seo') : null,
        );
    }

    public function event_category() : BelongsTo
    {
        return $this->belongsTo(EventCategory::class);
    }

    public function scopeVisible($query) {
        return $query->where('visible', true);
    }

    public function scopeUpcoming($query) {
        return $query->whereDate('date', '>=', Carbon::now());
    }

    public function scopePrevious($query) {
        return $query->whereDate('date', '<', Carbon::now());
    }

    public function getFormattedDateAttribute() {
        return $this->date->format('l jS M Y');
    }

    public function getFormattedDateTimeAttribute() {
        $result = $this->formatted_date;
        if( $this->start_time ) {
            $result .= " ( " . Carbon::parse($this->start_time)->format('H:i');
            if( $this->end_time ) {
                $result .= " - " . Carbon::parse($this->end_time)->format('H:i');
            }
            $result .= " )";
        }
        return $result;
    }

}
