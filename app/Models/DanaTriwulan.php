<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DanaTriwulan extends Model
{
    protected $table = 'dana_triwulan';

    protected $fillable = [
        'periode_id', 'triwulan', 'total_dana', 'status',
        'diterbitkan_pada', 'diterbitkan_oleh', 'sumber_url',
    ];

    protected $casts = [
        'triwulan' => 'integer',
        'total_dana' => 'integer',
        'diterbitkan_pada' => 'datetime',
        'diterbitkan_oleh' => 'integer',
    ];

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Period::class, 'periode_id');
    }

    public function komponen(): HasMany
    {
        return $this->hasMany(DanaKomponen::class);
    }

    public function alokasiDistribusi(): HasMany
    {
        return $this->hasMany(AlokasiDistribusi::class);
    }

    public function alokasiTaktis(): HasMany
    {
        return $this->hasMany(AlokasiTaktis::class);
    }

    public function info(): HasMany
    {
        return $this->hasMany(DanaInfo::class);
    }

    public function seksi(): HasMany
    {
        return $this->hasMany(DanaSeksi::class);
    }

    public function revisi(): HasMany
    {
        return $this->hasMany(DanaRevisi::class);
    }
}
