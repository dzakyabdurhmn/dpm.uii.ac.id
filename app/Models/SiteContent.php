<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Fixed content sections of the public site.
 *
 * Setiap seksi punya route dan view sendiri — tidak ada halaman bebas yang bisa
 * ditambah atau dihapus seperti CMS WordPress. Admin hanya mengubah isinya.
 */
class SiteContent extends Model
{
    protected $fillable = [
        'key',
        'period_id',
        'title',
        'body',
    ];

    /**
     * @var array<string, array{title: string, subtitle: string, show_units: bool, show_officials: bool}>
     */
    public const SECTIONS = [
        'sambutan' => [
            'title' => 'Sambutan',
            'subtitle' => 'Sambutan Ketua DPM UII',
            'show_units' => false,
            'show_officials' => false,
        ],
        'sejarah' => [
            'title' => 'Sejarah KM UII',
            'subtitle' => 'Tentang DPM UII',
            'show_units' => false,
            'show_officials' => false,
        ],
        'visi-misi' => [
            'title' => 'Visi Misi',
            'subtitle' => 'Informasi tentang DPM UII',
            'show_units' => false,
            'show_officials' => false,
        ],
        'struktur' => [
            'title' => 'Struktur',
            'subtitle' => 'Informasi tentang DPM UII',
            'show_units' => true,
            'show_officials' => false,
        ],
        'kedudukan-tugas-wewenang' => [
            'title' => 'Kedudukan, Tugas dan Wewenang',
            'subtitle' => 'Informasi tentang DPM UII',
            'show_units' => false,
            'show_officials' => false,
        ],
    ];

    /**
     * @return array<int, string>
     */
    public static function keys(): array
    {
        return array_keys(self::SECTIONS);
    }

    public static function configFor(string $key): ?array
    {
        return self::SECTIONS[$key] ?? null;
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function getRouteAttribute(): string
    {
        return route('about.show', $this->key);
    }
}
