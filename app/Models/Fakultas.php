<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fakultas extends Model
{
    protected $table = 'fakultas';

    protected $fillable = ['kode', 'nama', 'urutan'];

    protected $casts = ['urutan' => 'integer'];

    public function lembaga(): HasMany
    {
        return $this->hasMany(Lembaga::class);
    }

    public function alokasiTaktis(): HasMany
    {
        return $this->hasMany(AlokasiTaktis::class);
    }

    public function mahasiswa(): HasMany
    {
        return $this->hasMany(MahasiswaFakultas::class);
    }
}
