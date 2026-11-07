<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MahasiswaFakultas extends Model
{
    protected $table = 'mahasiswa_fakultas';

    protected $fillable = ['periode_id', 'fakultas_id', 'jumlah_mahasiswa'];

    protected $casts = ['jumlah_mahasiswa' => 'integer'];

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Period::class, 'periode_id');
    }

    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }
}
