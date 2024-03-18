<?php

namespace App\Models;

use App\Concerns\HasMediaImages;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class PostCategory extends Model implements Sortable
{
    use HasMediaImages;
    use SortableTrait;

    protected $guarded = [];

    public function posts() : HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function visible_posts() : HasMany
    {
        return $this->hasMany(Post::class)->where('visible', true);
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order_column', 'ASC');
        });
    }
}
