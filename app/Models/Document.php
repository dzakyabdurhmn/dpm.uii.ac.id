<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasUniqueSlug;

    public const QUARTERS = [
        1 => 'Triwulan I',
        2 => 'Triwulan II',
        3 => 'Triwulan III',
        4 => 'Triwulan IV',
    ];

    protected $fillable = [
        'document_category_id',
        'period_id',
        'title',
        'slug',
        'description',
        'file_path',
        'external_url',
        'mime_type',
        'size',
        'year',
        'quarter',
        'published_at',
        'downloads',
        'is_featured',
        'sort_order',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_featured' => 'boolean',
            'year' => 'integer',
            'quarter' => 'integer',
            'size' => 'integer',
            'downloads' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(DocumentCategory::class, 'document_category_id');
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function scopeQuarter(Builder $query, int $quarter): Builder
    {
        return $query->where('quarter', $quarter);
    }

    public function isPublished(): bool
    {
        return $this->published_at !== null && $this->published_at->isPast();
    }

    public function isExternal(): bool
    {
        return filled($this->external_url);
    }

    public function getDownloadUrlAttribute(): string
    {
        return $this->isExternal() ? $this->external_url : asset($this->file_path);
    }

    public function getQuarterLabelAttribute(): ?string
    {
        return $this->quarter ? (self::QUARTERS[$this->quarter] ?? null) : null;
    }

    public function getExtensionAttribute(): string
    {
        if ($this->isExternal()) {
            return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>';
        }

        return Str::upper(pathinfo((string) $this->file_path, PATHINFO_EXTENSION) ?: 'FILE');
    }

    public function getHumanSizeAttribute(): string
    {
        $bytes = (int) $this->size;

        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1).' MB';
        }

        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 0).' KB';
        }

        return $bytes > 0 ? $bytes.' B' : '-';
    }

    public function registerDownload(): void
    {
        $this->increment('downloads');
    }
}
