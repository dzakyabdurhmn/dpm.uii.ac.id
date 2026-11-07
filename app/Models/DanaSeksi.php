<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DanaSeksi extends Model
{
    protected $table = 'dana_seksi';

    protected $fillable = ['dana_triwulan_id', 'seksi', 'urutan', 'is_tampil', 'judul'];

    protected $casts = [
        'urutan' => 'integer',
        'is_tampil' => 'boolean',
    ];

    public function triwulan(): BelongsTo
    {
        return $this->belongsTo(DanaTriwulan::class, 'dana_triwulan_id');
    }
}
