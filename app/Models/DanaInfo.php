<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DanaInfo extends Model
{
    protected $table = 'dana_info';

    protected $fillable = ['dana_triwulan_id', 'seksi', 'teks'];

    public function triwulan(): BelongsTo
    {
        return $this->belongsTo(DanaTriwulan::class, 'dana_triwulan_id');
    }
}
