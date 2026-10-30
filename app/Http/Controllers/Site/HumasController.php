<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class HumasController extends Controller
{
    public function download(): View
    {
        $files = [
            [
                'name' => 'UII Font',
                'filename' => 'UII Font.ttf',
                'path' => 'uploads/internal/UII Font.ttf',
                'size' => $this->formatBytes(File::size(public_path('uploads/internal/UII Font.ttf'))),
                'type' => 'Font',
                'description' => 'Font resmi Universitas Islam Indonesia untuk dokumen internal DPM UII.',
                'icon' => 'font',
            ],
            [
                'name' => 'Template Surat DPM UII',
                'filename' => 'template-surat.docx',
                'path' => 'uploads/internal/template-surat.docx',
                'size' => $this->formatBytes(File::size(public_path('uploads/internal/template-surat.docx'))),
                'type' => 'Template',
                'description' => 'Template resmi surat DPM UII format .docx (Microsoft Word).',
                'icon' => 'document',
            ],
        ];

        return view('site.humas.download', [
            'files' => $files,
        ]);
    }

    public function downloadFile(string $filename)
    {
        $allowedFiles = ['UII Font.ttf', 'template-surat.docx'];
        
        if (!in_array($filename, $allowedFiles)) {
            abort(404);
        }

        $path = public_path('uploads/internal/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }

        return response()->download($path, $filename);
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 1) . ' MB';
        }
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 0) . ' KB';
        }
        return $bytes . ' B';
    }

    public function sosialisasi(): View
    {
        $regulations = [
            [
                'title' => 'PDKM UII',
                'full' => 'Peraturan Dasar Keluarga Mahasiswa',
                'slug' => 'pdkm',
                'icon' => 'book',
                'color' => '#4ade80',
                'description' => 'Konstitusi tertinggi KM UII yang mengatur asas, tujuan, kelembagaan, dan sistem pemerintahan mahasiswa.',
                'keyPoints' => [
                    'Dasar hukum kelahiran & kelangsungan hidup KM UII',
                    'Mengatur identitas, ciri khas, dan tujuan organisasi',
                    'Menetapkan struktur: DPM, LEM, BPM, DPMF, LEMF, SMF',
                    'Mengatur hak & kewajiban anggota KM UII',
                    'Prosedur perubahan PDKM (butuh 2/3 suara DPM)',
                ],
                'simpleExplanation' => 'PDKM itu seperti <strong>UUD 1945 bagi KM UII</strong>. Dia yang paling atas, yang paling sakral, dan yang paling susah diubah. Semua peraturan lain harus mengikuti PDKM.',
            ],
            [
                'title' => 'GBHKM UII',
                'full' => 'Garis-Garis Besar Haluan Keluarga Mahasiswa',
                'slug' => 'gbhkm',
                'icon' => 'compass',
                'color' => '#fbbf24',
                'description' => 'Arah kebijakan KM UII per periode: visi, misi, dan strategi pengembangan organisasi.',
                'keyPoints' => 'Ditetapkan tiap periode kepengurusan DPM',
                'simpleExplanation' => 'GBHKM itu <strong>peta jalan (roadmap)</strong> periode kepengurusan. Kalau PDKM adalah konstitusi, GBHKM adalah program kerja 5 tahunan yang disepakati di awal periode.',
            ],
            [
                'title' => 'PKM UII',
                'full' => 'Peraturan Keluarga Mahasiswa',
                'slug' => 'pkm',
                'icon' => 'gavel',
                'color' => '#60a5fa',
                'description' => 'Peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.',
                'keyPoints' => [
                    'Bernomor urut dan tahun (contoh: PKM No. 3 Tahun 2024)',
                    'Mengatur hal teknis: dana, kegiatan, organisasi, pemilu, dll',
                    'Dapat diubah/dicabut oleh DPM melalui proses legislasi',
                    'Wajib bersumber dari PDKM dan GBHKM',
                ],
                'simpleExplanation' => 'PKM itu <strong>peraturan pelaksana (derivative regulation)</strong>. PDKM bilang "dana dikelola transparan", PKM No. 3 Tahun 2024 bilang "caranya gimana, berapa persen, kapan disetor". PKM bersifat teknis & bersifat tahunan.',
            ],
            [
                'title' => 'PDPM UII',
                'full' => 'Peraturan Dewan Permusyawaratan Mahasiswa',
                'slug' => 'pdpm',
                'icon' => 'scale',
                'color' => '#f472b6',
                'description' => 'Peraturan internal DPM: tata tertib, mekanisme kerja, persidangan, dan hal teknis operasional.',
                'keyPoints' => [
                    'Mengatur tata tertib sidang paripurna DPM',
                    'Mekanisme pembentukan komisus, panitia, badan',
                    'Prosedur legislasi: mengajukan, membahas, menyahkan rancangan peraturan',
                    'Tata cara pengawasan & interpelasi',
                ],
                'simpleExplanation' => 'PDPM itu <strong>buku aturan main internal DPM</strong>. Kalau PKM mengatur seluruh KM UII, PDPM khusus ngatur "cara kerja DPM biar lancar & tertib".',
            ],
        ];

        return view('site.humas.sosialisasi', [
            'regulations' => $regulations,
        ]);
    }
}