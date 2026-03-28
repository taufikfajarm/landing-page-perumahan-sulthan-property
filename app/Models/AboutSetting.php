<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSetting extends Model
{
    protected $fillable = [
        'title',
        'description',
        'vision',
        'mission',
        'office_photo',
        'office_address',
        'office_phone',
        'office_email',
        'maps_embed_url',
        'why_choose_us',
    ];

    protected $casts = [
        'why_choose_us' => 'array',
    ];
}
