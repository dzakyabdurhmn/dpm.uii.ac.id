<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Deskripsi singkat alat kelengkapan dipakai di kartu Beranda dan hero
     * halaman unit. Sebelumnya kosong sehingga kartu menampilkan teks karangan
     * di blade; sekarang nilainya hidup di database dan bisa diubah lewat admin.
     *
     * @var array<string, string>
     */
    private const DESCRIPTIONS = [
        'mentari' => 'Media dan Kesekretariatan',
        'badan-legislasi' => 'Badan Legislasi',
        'badan-pengawasan' => 'Badan Pengawasan',
        'badan-kerjasama-advokasi-dan-jaringan' => 'Badan Kerjasama, Advokasi, dan Jaringan',
        'badan-audit-kemahasiswaan' => 'Badan Audit Kemahasiswaan',
        'badan-pengelola-aset' => 'Badan Pengelola Aset',
        'pimpinan-dewan' => 'Pimpinan Dewan',
    ];

    public function up(): void
    {
        foreach (self::DESCRIPTIONS as $slug => $description) {
            DB::table('organizational_units')
                ->where('slug', $slug)
                ->where(static fn ($query) => $query->whereNull('description')->orWhere('description', ''))
                ->update(['description' => $description]);
        }
    }

    public function down(): void
    {
        // Backfill data tidak dibalik: deskripsi bisa saja sudah diubah admin.
    }
};
