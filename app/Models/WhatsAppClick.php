<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class WhatsAppClick extends Model
{
    protected $table = 'whatsapp_clicks';
    
    public $timestamps = false;
    
    protected $fillable = [
        'marketing_id',
        'clicked_at',
    ];

    protected $casts = [
        'clicked_at' => 'datetime',
    ];

    // Relationships
    public function marketing(): BelongsTo
    {
        return $this->belongsTo(Marketing::class);
    }

    // Scopes
    public function scopeThisMonth($query)
    {
        return $query->whereYear('clicked_at', Carbon::now()->year)
                     ->whereMonth('clicked_at', Carbon::now()->month);
    }
}
