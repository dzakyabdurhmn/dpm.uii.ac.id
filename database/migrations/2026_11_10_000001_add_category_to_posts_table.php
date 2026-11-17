<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Sebelumnya kolom `type` dipakai untuk dua hal sekaligus: jenis sosialisasi
     * dan pemisah berita/pengumuman. Akibatnya Beranda menampilkan post yang sama
     * di kolom "Berita Kegiatan" dan "Pengumuman", sementara halaman Pengumuman
     * selalu kosong. `category` memisahkan keduanya secara eksplisit.
     *
     * @var array<string, string>
     */
    private const BACKFILL = [
        'dpm-uii-gelar-sidang-paripurna-ke-1-periode-2025-2026' => 'berita-kegiatan',
        'pkm-uis-no-3-tahun-2024-resmi-berlaku-tentang-distribusi-dana-km-uis' => 'berita',
        'audit-keuangan-lembaga-km-uis-triwulan-ii-2024' => 'berita-kegiatan',
        'pengumuman-penerima-beasiswa-prestasi-km-uis-2024' => 'pengumuman',
        'rapat-koordinasi-alat-kelengkapan-dewan-periode-2025-2026' => 'berita-kegiatan',
        'forum-aspirasi-mahasiswa-tingkat-fakultas-gelombang-i' => 'berita-kegiatan',
        'pelatihan-legislasi-untuk-anggota-dpm-uis-baru' => 'berita-kegiatan',
        'pembukaan-lomba-karya-tulis-ilmiah-lkti-km-uis-2025' => 'pengumuman',
        'kunjungan-kerja-dpm-uis-ke-dpm-se-jawa-tengah' => 'berita-kegiatan',
    ];

    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table): void {
            $table->string('category')->default('berita')->after('type')->index();
        });

        // Post sosialisasi tetap dikenali dari kolom type.
        DB::table('posts')->whereNotNull('type')->update(['category' => 'sosialisasi']);

        foreach (self::BACKFILL as $slug => $category) {
            DB::table('posts')->where('slug', $slug)->update(['category' => $category]);
        }

        // Sisa post lama tanpa type dianggap berita kegiatan.
        DB::table('posts')
            ->whereNull('type')
            ->where('category', 'berita')
            ->where('title', 'like', 'Pengumuman%')
            ->update(['category' => 'pengumuman']);
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table): void {
            $table->dropIndex(['category']);
            $table->dropColumn('category');
        });
    }
};
