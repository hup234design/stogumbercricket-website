<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $guarded = [
        'quiz'
    ];

    public function getNameAttribute() {
        return $this->first_name . " " . $this->last_name;
    }

    public function scopeSpam($query) {
        return $query->where('spam', true);
    }

    public function scopeNotSpam($query) {
        return $query->where('spam', false);
    }

    protected static function boot()
    {
        parent::boot();

        // Order by home page then sort order
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });

    }
}
