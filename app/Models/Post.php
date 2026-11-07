<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasUniqueSlug;

    public const STATUS_DRAFT = 'draft';

    public const STATUS_PUBLISHED = 'published';

    /**
     * Jenis sosialisasi: peraturan, kebijakan, program, dan lainnya.
     *
     * @var array<string, string>
     */
    public const SOCIALIZATION_TYPES = [
        'peraturan' => 'Sosialisasi Peraturan',
        'kebijakan' => 'Sosialisasi Kebijakan',
        'program' => 'Sosialisasi Program',
        'lainnya' => 'Sosialisasi Lainnya',
    ];

    protected $fillable = [
        'type',
        'title',
        'slug',
        'excerpt',
        'body',
        'status',
        'published_at',
        'featured_image',
        'meta_title',
        'meta_description',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Post $post): void {
            if ($post->status === self::STATUS_PUBLISHED && blank($post->published_at)) {
                $post->published_at = now();
            }
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', self::STATUS_PUBLISHED)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function isSocialization(): bool
    {
        return filled($this->type);
    }

    public function getTypeLabelAttribute(): ?string
    {
        return $this->type ? (self::SOCIALIZATION_TYPES[$this->type] ?? $this->type) : null;
    }

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    public function getUrlAttribute(): string
    {
        return route('news.show', $this);
    }
}
