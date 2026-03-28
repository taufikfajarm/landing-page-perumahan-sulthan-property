<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstallmentPlan extends Model
{
    protected $fillable = [
        'housing_type_id',
        'tenor_years',
        'monthly_payment',
        'dp_type',
        'dp_value',
        'sort_order',
    ];

    protected $casts = [
        'monthly_payment' => 'decimal:2',
        'dp_value' => 'decimal:2',
    ];

    public function housingType(): BelongsTo
    {
        return $this->belongsTo(HousingType::class);
    }

    public function getFormattedMonthlyPaymentAttribute(): string
    {
        return 'Rp ' . number_format($this->monthly_payment, 0, ',', '.');
    }

    public function getApproximateMonthlyPaymentAttribute(): string
    {
        if (!$this->monthly_payment) return '-';
        
        $payment = (float) $this->monthly_payment;
        if ($payment >= 1000000000) {
            $value = floor($payment / 10000000) / 100;
            $formatted = rtrim(rtrim(number_format($value, 2, ',', '.'), '0'), ',');
            return $formatted . ' Milyaran';
        } elseif ($payment >= 1000000) {
            $value = floor($payment / 100000) / 10;
            $formatted = rtrim(rtrim(number_format($value, 1, ',', '.'), '0'), ',');
            return $formatted . ' Jutaan';
        }
        
        return 'Rp ' . number_format($payment, 0, ',', '.');
    }

    public function getFormattedDpAttribute(): string
    {
        if (!$this->dp_value) {
            return '-';
        }

        if ($this->dp_type === 'percentage') {
            return $this->dp_value . '%';
        }

        return 'Rp ' . number_format($this->dp_value, 0, ',', '.');
    }
}
