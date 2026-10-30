<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BioLinkGroup extends Model
{
    protected $fillable = [
        'bio_link_id',
        'title',
        'slug',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function bioLink(): BelongsTo
    {
        return $this->belongsTo(BioLink::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(BioLinkItem::class)->orderBy('sort_order');
    }

    public function activeItems(): HasMany
    {
        return $this->hasMany(BioLinkItem::class)
            ->where('is_active', true)
            ->orderBy('sort_order');
    }
}
