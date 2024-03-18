<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Slider extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function slides() : HasMany
    {
        return $this->hasMany(Slide::class)->with('media_image');
    }
}
