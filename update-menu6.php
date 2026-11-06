<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Menu;
use Illuminate\Contracts\Console\Kernel;

$menu = Menu::where('location', 'header')->first();

$menu->items()->delete();

$tree = [
    [
        'label' => 'Tentang',
        'url' => '#fungsi',
        'children' => [
            ['label' => 'Sambutan', 'url' => '/tentang/sambutan'],
            ['label' => 'Sejarah', 'url' => '/tentang/sejarah'],
            ['label' => 'Visi Misi', 'url' => '/tentang/visi-misi'],
            ['label' => 'Struktur', 'url' => '/tentang/struktur'],
            ['label' => 'Kedudukan, Tugas dan Wewenang', 'url' => '/tentang/kedudukan-tugas-wewenang'],
            ['label' => 'Profil Dewan', 'url' => '/tentang/profil-dewan'],
        ],
    ],
    [
        'label' => 'Organisasi',
        'url' => '#unit',
        'children' => [
            ['label' => 'Mentari', 'url' => '/unit/mentari', 'description' => 'Media & Kesekretariatan'],
            ['label' => 'Baleg', 'url' => '/unit/badan-legislasi', 'description' => 'Badan Legislasi'],
            ['label' => 'Bawas', 'url' => '/unit/badan-pengawasan', 'description' => 'Badan Pengawasan'],
            ['label' => 'Bksaj', 'url' => '/unit/badan-kerjasama-advokasi-dan-jaringan', 'description' => 'Badan Kerjasama, Advokasi & Jaringan'],
            ['label' => 'BAK', 'url' => '/unit/badan-audit-kemahasiswaan', 'description' => 'Badan Audit Kemahasiswaan'],
            ['label' => 'BPA', 'url' => '/unit/badan-pengelola-aset', 'description' => 'Badan Pengelola Aset'],
        ],
    ],
    [
        'label' => 'Produk Hukum',
        'url' => '/produk-hukum',
        'children' => [
            ['label' => 'PDKM', 'url' => '/produk-hukum?jenis=pdkm'],
            ['label' => 'GBHKM', 'url' => '/produk-hukum?jenis=gbhkm'],
            ['label' => 'PKM', 'url' => '/produk-hukum?jenis=pkm'],
            ['label' => 'PDPM', 'url' => '/produk-hukum?jenis=pdpm'],
            ['label' => 'Semua Produk Hukum', 'url' => '/produk-hukum'],
        ],
    ],
    [
        'label' => 'Dokumen & Keputusan',
        'url' => '/keputusan',
        'children' => [
            ['label' => 'Surat Keputusan', 'url' => '/dokumen/kategori/surat-keputusan'],
            ['label' => 'Badan Kelengkapan Dewan', 'url' => '/dokumen/kategori/badan-kelengkapan-dewan'],
            ['label' => 'DPM Fakultas', 'url' => '/dokumen/kategori/dpm-fakultas'],
            ['label' => 'Lembaga & LK', 'url' => '/dokumen/kategori/lembaga-lk'],
            ['label' => 'Surat Ketetapan', 'url' => '/dokumen/kategori/surat-ketetapan'],
            ['label' => 'Keterangan Akademik', 'url' => '/dokumen/kategori/keterangan-akademik'],
            ['label' => 'Laporan Kinerja', 'url' => '/laporan-kinerja'],
            ['label' => 'Semua Dokumen', 'url' => '/dokumen'],
        ],
    ],
    [
        'label' => 'Dana',
        'url' => '/dana',
        'children' => [
            ['label' => 'Distribusi Dana', 'url' => '/dana/distribusi-dana'],
            ['label' => 'LPJ', 'url' => '/dana/lpj'],
            ['label' => 'LHA', 'url' => '/dana/lha'],
        ],
    ],
    [
        'label' => 'Humas',
        'url' => '/#berita',
        'children' => [
            ['label' => 'Berita', 'url' => '/#berita'],
            ['label' => 'Pengumuman', 'url' => '/pengumuman'],
            ['label' => 'Aspirasi Mahasiswa', 'url' => '/#aspirasi'],
            ['label' => 'Sosialisasi Peraturan', 'url' => '/humas/sosialisasi'],
            ['label' => 'Unduh Font & Template', 'url' => '/humas/unduh'],
        ],
    ],
];

function createItems($menu, $items, $parentId = null)
{
    foreach ($items as $i => $item) {
        $c = $menu->items()->create([
            'menu_id' => $menu->id,
            'parent_id' => $parentId,
            'label' => $item['label'],
            'url' => $item['url'] ?? null,
            'description' => $item['description'] ?? null,
            'sort_order' => $i + 1,
            'is_active' => true,
        ]);
        if (! empty($item['children'])) {
            createItems($menu, $item['children'], $c->id);
        }
    }
}

createItems($menu, $tree);
echo "Menu updated!\n";
