<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProsesAkad extends Model
{
    protected $fillable = [
        'title',
        'description',
        'images',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'images' => 'array',
    ];

    // Relationships
    public function images(): HasMany
    {
        return $this->hasMany(ProsesAkadImage::class)->orderBy('order');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
