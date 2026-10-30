<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * Known official social links used until an administrator changes them.
     *
     * @var array<string, string>
     */
    private const DEFAULTS = [
        'social_whatsapp' => 'https://wa.me/6281511092004',
        'social_instagram' => 'https://www.instagram.com/dpmuii/',
        'social_linkedin' => 'https://www.linkedin.com/company/dewan-permusyawaratan-mahasiswa/',
        'social_twitter' => 'https://twitter.com/DPM_UII',
        'social_youtube' => 'https://www.youtube.com/@dpmuii',
    ];

    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * All settings as a key => value map, cached until the next write.
     *
     * @return array<string, string|null>
     */
    public static function map(): array
    {
        $storedSettings = cache()->rememberForever('site.settings', fn (): array => static::query()->pluck('value', 'key')->all());

        return array_replace(self::DEFAULTS, $storedSettings);
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        $value = static::map()[$key] ?? null;

        return filled($value) ? $value : $default;
    }

    public static function put(string $key, ?string $value): void
    {
        static::query()->updateOrCreate(['key' => $key], ['value' => $value]);

        cache()->forget('site.settings');
    }

    protected static function booted(): void
    {
        static::saved(fn () => cache()->forget('site.settings'));
        static::deleted(fn () => cache()->forget('site.settings'));
    }
}
