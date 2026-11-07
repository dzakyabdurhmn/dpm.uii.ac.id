<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DanaRevisi extends Model
{
    protected $table = 'dana_revisi';

    protected $fillable = ['dana_triwulan_id', 'diubah_oleh', 'alasan', 'snapshot', 'dibuat_pada'];

    protected $casts = [
        'snapshot' => 'array',
        'dibuat_pada' => 'datetime',
    ];

    public function triwulan(): BelongsTo
    {
        return $this->belongsTo(DanaTriwulan::class, 'dana_triwulan_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diubah_oleh');
    }
}
