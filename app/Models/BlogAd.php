<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogAd extends Model
{
    protected $fillable = [
        'title',
        'housing_id',
        'marketing_id',
        'image',
        'ad_type',
        'is_active',
        'views_count',
        'clicks_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function housing()
    {
        return $this->belongsTo(Housing::class);
    }

    public function marketing()
    {
        return $this->belongsTo(Marketing::class);
    }

    // Query Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeBanner($query)
    {
        return $query->where('ad_type', 'banner');
    }

    public function scopeCard($query)
    {
        return $query->where('ad_type', 'card');
    }

    // Tracking Methods
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function incrementClicks()
    {
        $this->increment('clicks_count');
    }

    public function getCtrAttribute()
    {
        if ($this->views_count == 0) {
            return 0;
        }
        return round(($this->clicks_count / $this->views_count) * 100, 2);
    }

    // Accessors
    public function getWhatsappUrlAttribute()
    {
        if (!$this->marketing) {
            return '#';
        }

        $message = "Saya tertarik dengan promo {$this->title}";
        
        if ($this->housing) {
            $message .= " perumahan {$this->housing->name}";
        }
        
        $message .= ", mohon informasi lebih lanjut.\n\n";
        $message .= "Saya melihat iklan ini di website sulthanproperty.com";

        return $this->marketing->whatsapp_link . '?text=' . urlencode($message);
    }
}
