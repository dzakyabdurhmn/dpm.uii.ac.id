<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use App\Models\Menu;
use Illuminate\Contracts\Console\Kernel;

$menu = Menu::where('location', 'header')->first();

if (! $menu) {
    echo "Menu not found!\n";
    exit(1);
}

$menu->items()->delete();

$tree = [
    [
        'label' => 'Tentang',
        'url' => '#fungsi',
        'children' => [
            ['label' => 'Sambutan', 'url' => '/tentang/sambutan'],
            ['label' => 'Sejarah KM', 'url' => '/tentang/sejarah'],
            ['label' => 'Visi Misi', 'url' => '/tentang/visi-misi'],
            ['label' => 'Struktur', 'url' => '/tentang/struktur'],
            ['label' => 'Kedudukan, Tugas dan Wewenang', 'url' => '/tentang/kedudukan-tugas-wewenang'],
            ['label' => 'Profil Dewan', 'url' => '/tentang/profil-dewan'],
        ],
    ],
    [
        'label' => 'Alat Kelengkapan',
        'url' => '#unit',
        'children' => [
            ['label' => 'Mentari', 'url' => '/unit/mentari'],
            ['label' => 'Baleg', 'url' => '/unit/badan-legislasi'],
            ['label' => 'Bawas', 'url' => '/unit/badan-pengawasan'],
            ['label' => 'Bksaj', 'url' => '/unit/badan-kerjasama-advokasi-dan-jaringan'],
            ['label' => 'BAK', 'url' => '/unit/badan-audit-kemahasiswaan'],
            ['label' => 'BPA', 'url' => '/unit/badan-pengelola-aset'],
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
        'label' => 'Dana',
        'url' => '/dana',
        'children' => [
            ['label' => 'Distribusi Dana', 'url' => '/dana/distribusi-dana'],
            ['label' => 'LPJ', 'url' => '/dana/lpj'],
            ['label' => 'LHA', 'url' => '/dana/lha'],
        ],
    ],
    [
        'label' => 'Laporan Kinerja',
        'url' => '/laporan-kinerja',
    ],
    [
        'label' => 'Keputusan',
        'url' => '/keputusan',
        'children' => [
            ['label' => 'Surat Keputusan DPM UII', 'url' => '/dokumen/kategori/surat-keputusan'],
            ['label' => 'Ketetapan DPM UII', 'url' => '/dokumen/kategori/surat-ketetapan'],
            ['label' => 'Keputusan Bersama', 'url' => '/keputusan?jenis=skb'],
            ['label' => 'Semua Keputusan', 'url' => '/keputusan'],
        ],
    ],
    [
        'label' => 'Keterangan Akademik',
        'url' => '/dokumen/kategori/keterangan-akademik',
    ],
    [
        'label' => 'Berita',
        'url' => '/#berita',
    ],
    [
        'label' => 'Aspirasi',
        'url' => '/#aspirasi',
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
            'sort_order' => $i + 1,
            'is_active' => true,
        ]);
        if (! empty($item['children'])) {
            createItems($menu, $item['children'], $c->id);
        }
    }
}

createItems($menu, $tree);
echo "Menu updated successfully!\n";
