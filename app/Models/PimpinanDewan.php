<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PimpinanDewan extends Model
{
    protected $table = 'pimpinan_dewan';
    protected $fillable = [
        'periode_id',
        'jabatan',
        'nama',
        'fakultas',
        'prodi',
        'angkatan',
        'nim',
        'email',
        'instagram',
        'linkedin',
        'foto_path',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function tugas(): HasMany
    {
        return $this->hasMany(PimpinanTugas::class)->orderBy('sort_order');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto_path ? asset($this->foto_path) : null;
    }
}
