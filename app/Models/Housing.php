<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Housing extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'developer_name',
        'certificate_type',
        'location',
        'location_url',
        'latitude',
        'longitude',
        'featured_image',
        'description',
        'status',
        'badge_text',
        'badge_type',
        'is_featured',
        'site_plan',
        'siteplan_sip_id',
        'brochure_file',
        'video_url',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    protected static function booted()
    {
        static::saved(function ($housing) {
            \Illuminate\Support\Facades\Cache::forget('housing_index');
            \Illuminate\Support\Facades\Cache::forget("housing_show_{$housing->slug}");
            \Illuminate\Support\Facades\Cache::forget("housing_slug_{$housing->slug}");
        });

        static::deleted(function ($housing) {
            \Illuminate\Support\Facades\Cache::forget('housing_index');
            \Illuminate\Support\Facades\Cache::forget("housing_show_{$housing->slug}");
            \Illuminate\Support\Facades\Cache::forget("housing_slug_{$housing->slug}");
        });
    }

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

    public function getCoordinatesAttribute()
    {
        if (is_numeric($this->latitude) && is_numeric($this->longitude)) {
            return [
                'lat' => (float) $this->latitude,
                'lng' => (float) $this->longitude,
            ];
        }

        return null;
    }
}
