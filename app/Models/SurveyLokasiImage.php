<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurveyLokasiImage extends Model
{
    protected $fillable = [
        'survey_lokasi_id',
        'image_path',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    // Relationships
    public function surveyLokasi(): BelongsTo
    {
        return $this->belongsTo(SurveyLokasi::class);
    }
}
