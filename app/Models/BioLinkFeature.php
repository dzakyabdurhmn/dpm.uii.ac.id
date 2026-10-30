<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BioLinkFeature extends Model
{
    protected $fillable = [
        'bio_link_id',
        'eyebrow',
        'title',
        'description',
        'button_text',
        'button_url',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function bioLink(): BelongsTo
    {
        return $this->belongsTo(BioLink::class);
    }
}
