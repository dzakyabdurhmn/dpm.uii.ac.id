<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrganizationalUnit extends Model
{
    use HasUniqueSlug;

    public const TYPES = ['pimpinan', 'direktorat', 'badan', 'lembaga', 'komisi'];

    protected $fillable = [
        'parent_id',
        'type',
        'name',
        'abbreviation',
        'slug',
        'description',
        'tasks',
        'work_programs',
        'email',
        'logo_path',
        'sort_order',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    public function officials(): HasMany
    {
        return $this->hasMany(Official::class)->orderBy('sort_order');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getUrlAttribute(): string
    {
        return route('units.show', $this);
    }

    /** "Mentari" when abbreviated, otherwise the full name. */
    public function getShortNameAttribute(): string
    {
        return $this->abbreviation ?: $this->name;
    }
}
