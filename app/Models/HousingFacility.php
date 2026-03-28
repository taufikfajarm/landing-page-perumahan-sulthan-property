<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HousingFacility extends Model
{
    protected $fillable = [
        'housing_id',
        'name',
        'icon',
        'order',
    ];

    protected $casts = [
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
