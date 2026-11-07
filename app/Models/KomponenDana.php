<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KomponenDana extends Model
{
    protected $table = 'komponen_dana';

    protected $fillable = ['kode', 'nama', 'urutan', 'is_tampil', 'peran'];

    protected $casts = [
        'urutan' => 'integer',
        'is_tampil' => 'boolean',
    ];

    public function danaKomponen(): HasMany
    {
        return $this->hasMany(DanaKomponen::class, 'komponen_id');
    }
}
