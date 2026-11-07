<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanHalaman extends Model
{
    protected $table = 'pengaturan_halaman';

    protected $fillable = ['halaman', 'kunci', 'nilai'];
}
