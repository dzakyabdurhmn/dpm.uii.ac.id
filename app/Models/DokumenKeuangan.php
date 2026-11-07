<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumenKeuangan extends Model
{
    protected $table = 'dokumen_keuangan';

    protected $fillable = [
        'jenis', 'periode_id', 'lembaga_id', 'semester',
        'judul', 'tanggal', 'file_path', 'status',
    ];

    protected $casts = ['tanggal' => 'date'];

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Period::class, 'periode_id');
    }

    public function lembaga(): BelongsTo
    {
        return $this->belongsTo(Lembaga::class, 'lembaga_id');
    }
}
