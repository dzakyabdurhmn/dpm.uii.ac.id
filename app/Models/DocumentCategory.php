<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentCategory extends Model
{
    use HasUniqueSlug;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'group',
        'sort_order',
        'parent_id',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'parent_id' => 'integer',
        ];
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    public function getUrlAttribute(): string
    {
        return route('documents.category', $this->slug);
    }

    public function isMainCategory(): bool
    {
        return $this->type === 'main' || $this->parent_id === null;
    }

    public function isSubCategory(): bool
    {
        return $this->type === 'sub' || $this->parent_id !== null;
    }

    public function getFullGroupAttribute(): string
    {
        if ($this->parent) {
            return $this->parent->name.' > '.$this->name;
        }

        return $this->group;
    }
}
