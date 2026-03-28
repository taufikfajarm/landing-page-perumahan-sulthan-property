<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class HousingType extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'housing_id',
        'name',
        'slug',
        'floor_plan',
        'image_tampak_depan',
        'image_ruang_tamu',
        'image_kamar',
        'image_dapur',
        'custom_images',
        'land_size',
        'building_size',
        'bedrooms',
        'bathrooms',
        'price',
        'specifications',
        'promo_title',
        'promo_description',
        'promo_valid_until',
    ];

    protected $casts = [
        'specifications' => 'array',
        'custom_images' => 'array',
        'price' => 'decimal:2',
    ];

    // Media Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery')
            ->useDisk('public');
    }

    // Relationships
    public function housing()
    {
        return $this->belongsTo(Housing::class);
    }

    public function installmentPlans()
    {
        return $this->hasMany(InstallmentPlan::class)->orderBy('sort_order');
    }

    public function bankPartners()
    {
        return $this->belongsToMany(BankPartner::class)->orderBy('sort_order');
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getApproximatePriceAttribute()
    {
        if (!$this->price) return null;
        
        $price = (float) $this->price;
        if ($price >= 1000000000) {
            $value = floor($price / 10000000) / 100;
            $formatted = rtrim(rtrim(number_format($value, 2, ',', '.'), '0'), ',');
            return $formatted . ' Milyaran';
        } elseif ($price >= 1000000) {
            $value = floor($price / 1000000);
            return number_format($value, 0, ',', '.') . ' Jutaan';
        }
        
        return 'Rp ' . number_format($price, 0, ',', '.');
    }
}
