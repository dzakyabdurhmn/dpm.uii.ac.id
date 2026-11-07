<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlokasiTaktis extends Model
{
    protected $table = 'alokasi_taktis';

    protected $fillable = ['dana_triwulan_id', 'fakultas_id', 'jumlah', 'keterangan'];

    protected $casts = ['jumlah' => 'integer'];

    public function triwulan(): BelongsTo
    {
        return $this->belongsTo(DanaTriwulan::class, 'dana_triwulan_id');
    }

    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }
}
