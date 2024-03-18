<?php

namespace App\Models;

use App\Models\MediaImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class ClubOfficer extends Model implements Sortable
{
    use SortableTrait;

    protected $guarded = [];

    public function media_image() : BelongsTo
    {
        return $this->belongsTo(MediaImage::class, 'media_image_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order_column', 'ASC');
        });
    }
}

