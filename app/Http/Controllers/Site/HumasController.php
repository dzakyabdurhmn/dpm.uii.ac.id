<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class HumasController extends Controller
{
    /**
     * Aset internal yang boleh diunduh lewat halaman humas.
     *
     * @var array<string, array{name: string, type: string, icon: string, description: string}>
     */
    private const INTERNAL_FILES = [
        'UII Font.ttf' => [
            'name' => 'UII Font',
            'type' => 'Font Resmi',
            'icon' => 'font',
            'description' => 'Font resmi identitas visual UII untuk dokumen dan publikasi DPM UII.',
        ],
        'template-surat.docx' => [
            'name' => 'Template Surat',
            'type' => 'Template Dokumen',
            'icon' => 'document',
            'description' => 'Format surat resmi DPM UII yang siap diisi untuk keperluan administrasi internal.',
        ],
    ];

    public function download(): View
    {
        $files = collect(self::INTERNAL_FILES)
            ->map(function (array $file, string $filename): array {
                return $file + [
                    'filename' => $filename,
                    'size' => $this->fileSize(public_path('uploads/internal/'.$filename)),
                ];
            })
            ->values()
            ->all();

        return view('site.humas.download', [
            'files' => $files,
        ]);
    }

    public function downloadFile(string $file): BinaryFileResponse
    {
        abort_unless(array_key_exists($file, self::INTERNAL_FILES), 404);

        $path = public_path('uploads/internal/'.$file);

        abort_unless(is_file($path), 404);

        return response()->download($path, $file);
    }

    public function sosialisasi(): View
    {
        return view('site.humas.sosialisasi', [
            'regulations' => $this->regulations(),
        ]);
    }

    /**
     * @return array<int, array{type: string, title: string, full: string, slug: string, color: string, description: string, simpleExplanation: string, keyPoints: array<int, string>}>
     */
    private function regulations(): array
    {
        return [
            [
                'type' => 'Peraturan Dasar',
                'title' => 'PDKM',
                'full' => 'Peraturan Dasar Keluarga Mahasiswa UII',
                'slug' => 'pdkm',
                'color' => '#4ade80',
                'description' => 'Konstitusi tertinggi KM UII yang mengatur asas, tujuan, dan struktur fundamental organisasi.',
                'simpleExplanation' => 'PDKM itu ibarat "UUD"-nya KM UII. Semua aturan lain harus mengikuti PDKM dan tidak boleh bertentangan dengannya.',
                'keyPoints' => [
                    'Dasar hukum tertinggi di KM UII',
                    'Mengatur asas, tujuan, dan struktur organisasi',
                    'Perubahannya butuh persetujuan 2/3 anggota DPM',
                ],
            ],
            [
                'type' => 'Garis Besar Haluan',
                'title' => 'GBHKM',
                'full' => 'Garis-Garis Besar Haluan Keluarga Mahasiswa UII',
                'slug' => 'gbhkm',
                'color' => '#fbbf24',
                'description' => 'Arah kebijakan dan strategi KM UII untuk satu periode kepengurusan.',
                'simpleExplanation' => 'GBHKM adalah roadmap periode: visi, misi, dan strategi yang ingin dicapai selama kepengurusan berjalan.',
                'keyPoints' => [
                    'Menjadi arah kebijakan tiap periode',
                    'Memuat visi, misi, dan program strategis',
                    'Ditetapkan di awal periode kepengurusan',
                ],
            ],
            [
                'type' => 'Peraturan Keluarga Mahasiswa',
                'title' => 'PKM',
                'full' => 'Peraturan Keluarga Mahasiswa UII',
                'slug' => 'pkm',
                'color' => '#60a5fa',
                'description' => 'Peraturan teknis bernomor yang mengatur dana, kegiatan, pemilu, dan organisasi kemahasiswaan.',
                'simpleExplanation' => 'PKM mengatur hal-hal teknis yang dekat dengan mahasiswa: alokasi dana, kepanitiaan, pemilu, dan UKM.',
                'keyPoints' => [
                    'Bernomor dan ditetapkan per tahun',
                    'Mengatur dana, kegiatan, dan pemilu',
                    'Bisa diperbarui sesuai kebutuhan',
                ],
            ],
            [
                'type' => 'Peraturan DPM',
                'title' => 'PDPM',
                'full' => 'Peraturan Dewan Permusyawaratan Mahasiswa',
                'slug' => 'pdpm',
                'color' => '#f472b6',
                'description' => 'Aturan internal DPM UII: tata tertib sidang, mekanisme legislasi, dan pengawasan.',
                'simpleExplanation' => 'PDPM adalah aturan "rumah tangga" DPM: cara bersidang, membuat peraturan, dan mengawasi jalannya pemerintahan mahasiswa.',
                'keyPoints' => [
                    'Mengatur tata tertib persidangan',
                    'Mengatur mekanisme legislasi dan pengawasan',
                    'Berlaku khusus untuk internal DPM UII',
                ],
            ],
        ];
    }

    private function fileSize(string $path): string
    {
        $bytes = is_file($path) ? (int) filesize($path) : 0;

        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1).' MB';
        }

        return number_format($bytes / 1024).' KB';
    }
}
