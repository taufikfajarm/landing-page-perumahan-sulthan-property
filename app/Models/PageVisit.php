<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PageVisit extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'url',
        'ip_address',
        'user_agent',
        'visited_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
    ];

    // Scopes
    public function scopeToday($query)
    {
        return $query->whereDate('visited_at', Carbon::today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereYear('visited_at', Carbon::now()->year)
                     ->whereMonth('visited_at', Carbon::now()->month);
    }

    public function scopeLast30Days($query)
    {
        return $query->where('visited_at', '>=', Carbon::now()->subDays(30));
    }

    public function scopeLast12Months($query)
    {
        return $query->where('visited_at', '>=', Carbon::now()->subMonths(12));
    }
}
