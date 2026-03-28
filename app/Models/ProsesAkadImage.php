<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProsesAkadImage extends Model
{
    protected $fillable = [
        'proses_akad_id',
        'image_path',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    // Relationships
    public function prosesAkad(): BelongsTo
    {
        return $this->belongsTo(ProsesAkad::class);
    }
}
