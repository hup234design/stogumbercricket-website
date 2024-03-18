<?php

namespace App\Models\Fixtures;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fixture extends Model
{
    protected $guarded = [];

    protected $casts = [
        'date' => 'date',
    ];

    public function team() : BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function opponent() : BelongsTo
    {
        return $this->belongsTo(Opponent::class);
    }

    public function venue() : BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    public function scopeUpcoming($query) {
        return $query
            ->whereDate('date', '>=', Carbon::now())
            ->orderBy('date', 'asc');
    }

    public function scopeResults($query) {
        return $query
            ->whereDate('date', '<', Carbon::now())
            ->orderBy('date', 'desc');
    }

    public function getFormattedDateAttribute() {
        return $this->date ?  $this->date->format('l F j, Y') : null;
    }

    public function getFormattedStartTimeAttribute() {
        return $this->start_time ? Carbon::parse($this->start_time)->format('H:i') : null;
    }
}
