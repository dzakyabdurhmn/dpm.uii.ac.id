<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilDewan extends Model
{
    protected $fillable = [
        'nama_lengkap',
        'nim',
        'fakultas',
        'program_studi',
        'angkatan',
        'email_kampus',
        'jabatan',
        'unit_kerja',
        'periode',
        'masa_jabatan',
        'status',
        'bio',
        'tugas_tanggung_jawab',
        'instagram',
        'email',
    ];
}
