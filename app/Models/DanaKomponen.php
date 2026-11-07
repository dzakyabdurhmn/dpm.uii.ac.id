<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DanaKomponen extends Model
{
    protected $table = 'dana_komponen';

    protected $fillable = ['dana_triwulan_id', 'komponen_id', 'jumlah'];

    protected $casts = ['jumlah' => 'integer'];

    public function triwulan(): BelongsTo
    {
        return $this->belongsTo(DanaTriwulan::class, 'dana_triwulan_id');
    }

    public function komponen(): BelongsTo
    {
        return $this->belongsTo(KomponenDana::class, 'komponen_id');
    }
}
