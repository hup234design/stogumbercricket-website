<?php

namespace App\Models;

use App\Concerns\HasMediaImages;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class EventCategory extends Model implements Sortable
{
    use HasMediaImages;
    use SortableTrait;

    protected $guarded = [];

    public function events() : HasMany
    {
        return $this->hasMany(Event::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order_column', 'ASC');
        });
    }
}
