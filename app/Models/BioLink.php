<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BioLink extends Model
{
    protected $fillable = [
        'site_name',
        'tagline',
        'handle',
        'logo',
        'description',
        'theme_color',
        'social_links',
        'address',
        'email',
        'phone',
        'is_active',
    ];

    protected $casts = [
        'social_links' => 'array',
        'is_active' => 'boolean',
    ];

    public function groups(): HasMany
    {
        return $this->hasMany(BioLinkGroup::class)->orderBy('sort_order');
    }

    public function features(): HasMany
    {
        return $this->hasMany(BioLinkFeature::class)->orderBy('created_at');
    }

    public function activeGroups(): HasMany
    {
        return $this->hasMany(BioLinkGroup::class)
            ->where('is_active', true)
            ->orderBy('sort_order');
    }

    public function activeFeatures(): HasMany
    {
        return $this->hasMany(BioLinkFeature::class)
            ->where('is_active', true)
            ->orderBy('created_at');
    }

    public static function getActive(): ?self
    {
        return static::where('is_active', true)->first();
    }
}
