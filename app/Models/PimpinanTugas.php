<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PimpinanTugas extends Model
{
    protected $fillable = [
        'pimpinan_dewan_id',
        'tugas',
        'sort_order',
    ];

    public function pimpinan(): BelongsTo
    {
        return $this->belongsTo(PimpinanDewan::class);
    }
}
