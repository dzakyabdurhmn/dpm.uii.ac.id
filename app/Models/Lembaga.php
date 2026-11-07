<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lembaga extends Model
{
    protected $table = 'lembaga';

    protected $fillable = ['nama', 'tingkat', 'jenis', 'fakultas_id', 'parent_id', 'is_aktif'];

    protected $casts = ['is_aktif' => 'boolean'];

    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(Fakultas::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function alokasiDistribusi(): HasMany
    {
        return $this->hasMany(AlokasiDistribusi::class);
    }
}
