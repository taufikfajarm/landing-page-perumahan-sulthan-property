<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HousingAccessPoint extends Model
{
    protected $fillable = [
        'housing_id',
        'destination',
        'duration_minutes',
        'order',
    ];

    protected $casts = [
        'duration_minutes' => 'integer',
        'order' => 'integer',
    ];

    // Default ordering
    protected static function booted()
    {
        static::addGlobalScope('ordered', function ($query) {
            $query->orderBy('order');
        });
    }

    // Relationships
    public function housing(): BelongsTo
    {
        return $this->belongsTo(Housing::class);
    }
}
