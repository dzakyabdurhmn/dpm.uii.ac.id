<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Konten halaman statis (hanya Sambutan Ketua yang punya isi editor).
 * Seksinya tetap: tidak bisa ditambah/dihapus lewat admin.
 */
class PageContent extends Model
{
    protected $fillable = [
        'key',
        'title',
        'subtitle',
        'body',
        'signature_role',
        'signature_name',
        'signature_fakultas',
        'signature_nim',
    ];

    /**
     * @var array<string, array{title: string, subtitle: string}>
     */
    public const SECTIONS = [
        'sambutan' => [
            'title' => 'Sambutan',
            'subtitle' => 'Sambutan Ketua DPM UII',
        ],
        'sejarah' => [
            'title' => 'Sejarah KM UII',
            'subtitle' => 'Tentang DPM UII',
        ],
        'visi-misi' => [
            'title' => 'Visi Misi',
            'subtitle' => 'Tentang DPM UII',
        ],
        'struktur' => [
            'title' => 'Struktur',
            'subtitle' => 'Tentang DPM UII',
        ],
        'kedudukan-tugas-wewenang' => [
            'title' => 'Kedudukan, Tugas dan Wewenang',
            'subtitle' => 'Tentang DPM UII',
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

    public function getRouteAttribute(): string
    {
        return route('about.show', $this->key);
    }
}
