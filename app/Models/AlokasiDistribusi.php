<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlokasiDistribusi extends Model
{
    protected $table = 'alokasi_distribusi';

    protected $fillable = ['dana_triwulan_id', 'lembaga_id', 'jumlah'];

    protected $casts = ['jumlah' => 'integer'];

    public function triwulan(): BelongsTo
    {
        return $this->belongsTo(DanaTriwulan::class, 'dana_triwulan_id');
    }

    public function lembaga(): BelongsTo
    {
        return $this->belongsTo(Lembaga::class, 'lembaga_id');
    }
}
