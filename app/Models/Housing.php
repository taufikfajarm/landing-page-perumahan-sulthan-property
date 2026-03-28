<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Housing extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'location',
        'location_url',
        'featured_image',
        'description',
        'status',
        'badge_text',
        'badge_type',
        'is_featured',
        'site_plan',
        'siteplan_sip_id',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    // Relationships
    public function types()
    {
        return $this->hasMany(HousingType::class);
    }

    public function facilities()
    {
        return $this->hasMany(HousingFacility::class);
    }

    public function accessPoints()
    {
        return $this->hasMany(HousingAccessPoint::class);
    }

    // Query Scopes
    public function scopeReady($query)
    {
        return $query->where('status', 'ready');
    }

    public function scopeSoldout($query)
    {
        return $query->where('status', 'soldout');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        return $this->status === 'ready' 
            ? '<span class="badge badge-success">Ready</span>' 
            : '<span class="badge badge-danger">Sold Out</span>';
    }
}
