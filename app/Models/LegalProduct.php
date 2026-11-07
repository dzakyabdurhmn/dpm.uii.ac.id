<?php

namespace App\Models;

use App\Models\Concerns\HasUniqueSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class LegalProduct extends Model
{
    use HasUniqueSlug;

    /**
     * Each product type behaves differently on purpose:
     * PDKM is a single constitutional document (no number, no year),
     * GBHKM is enacted once per leadership period,
     * PKM/PDPM are numbered regulations renewed every year.
     *
     * @var array<string, array{label: string, name: string, numbered: bool, description: string}>
     */
    public const TYPES = [
        'pdkm' => [
            'label' => 'PDKM',
            'name' => 'Peraturan Dasar Keluarga Mahasiswa',
            'numbered' => false,
            'description' => 'Konstitusi tertinggi KM UII yang mengatur asas, tujuan, kelembagaan, dan sistem pemerintahan mahasiswa.',
        ],
        'gbhkm' => [
            'label' => 'GBHKM',
            'name' => 'Garis-Garis Besar Haluan Keluarga Mahasiswa',
            'numbered' => false,
            'description' => 'GBHKM merupakan manifestasi dari arah gerak dan cita-cita mahasiswa UII yang disusun dan disahkan oleh DPM UII melalui Sidang Umum atau Sidang Istimewa. Dokumen ini berfungsi sebagai pedoman resmi dan landasan penyusunan rencana kerja yang berkesinambungan bagi seluruh lembaga kemahasiswaan di lingkungan KM UII.',
        ],
        'pkm' => [
            'label' => 'PKM',
            'name' => 'Peraturan Keluarga Mahasiswa',
            'numbered' => true,
            'description' => 'Peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.',
        ],
        'pdpm' => [
            'label' => 'PDPM UII',
            'name' => 'Peraturan Dewan Permusyawaratan Mahasiswa',
            'numbered' => true,
            'description' => 'Peraturan DPM: tata tertib, mekanisme kerja, persidangan, dan hal teknis operasional.',
        ],
    ];

    protected $fillable = [
        'type',
        'number',
        'year',
        'edition',
        'period_id',
        'amends_id',
        'title',
        'slug',
        'description',
        'file_path',
        'mime_type',
        'status',
        'size',
        'is_published',
        'published_at',
        'enacted_on',
        'forum',
        'sort_order',
        'downloads',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'enacted_on' => 'date',
            'number' => 'integer',
            'year' => 'integer',
            'size' => 'integer',
            'downloads' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public static function isNumberedType(string $type): bool
    {
        return (bool) (self::TYPES[$type]['numbered'] ?? false);
    }

    public static function labelFor(string $type, bool $withName = false): string
    {
        $meta = self::TYPES[$type] ?? null;

        if (! $meta) {
            return Str::upper($type);
        }

        return $withName ? $meta['label'].' — '.$meta['name'] : $meta['label'];
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function amends(): BelongsTo
    {
        return $this->belongsTo(self::class, 'amends_id');
    }

    public function amendments(): HasMany
    {
        return $this->hasMany(self::class, 'amends_id');
    }

    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query
            ->orderByDesc('year')
            ->orderByDesc('number')
            ->orderBy('sort_order')
            ->orderBy('title');
    }

    public function isNumbered(): bool
    {
        return self::isNumberedType($this->type);
    }

    /** e.g. "PKM UII No. 1 Tahun 2018" */
    public function getRegulationNumberAttribute(): ?string
    {
        if (! $this->isNumbered() || ! $this->number) {
            return null;
        }

        $label = self::TYPES[$this->type]['label'] ?? Str::upper($this->type);

        return trim($label.' UII No. '.$this->number.($this->year ? ' Tahun '.$this->year : ''));
    }

    public function getTypeLabelAttribute(): string
    {
        return self::labelFor($this->type);
    }

    public function getHeadingAttribute(): string
    {
        return $this->regulation_number ?: $this->type_label.' UII';
    }

    public function isAmendment(): bool
    {
        return $this->amends_id !== null;
    }

    /**
     * Produk hukum selalu berkas yang diunggah ke server — tidak ada tautan luar.
     */
    public function hasFile(): bool
    {
        return filled($this->file_path);
    }

    public function getDownloadUrlAttribute(): ?string
    {
        return $this->file_path ? asset($this->file_path) : null;
    }

    public function getExtensionAttribute(): string
    {
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
