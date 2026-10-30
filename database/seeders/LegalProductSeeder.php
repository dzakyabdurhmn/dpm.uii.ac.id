<?php

namespace Database\Seeders;

use App\Models\LegalProduct;
use App\Models\Period;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LegalProductSeeder extends Seeder
{
    public function run(): void
    {
        $basePath = public_path('uploads/produk-hukum');

        if (!File::isDirectory($basePath)) {
            $this->command->error("Directory not found: {$basePath}");
            return;
        }

        // Clear existing data first
        LegalProduct::query()->delete();
        $this->command->info('Cleared existing legal products.');

        // Get periods for reference
        $periods = Period::query()->pluck('id', 'name')->toArray();

        // ============================================================
        // PDKM - Peraturan Dasar Keluarga Mahasiswa (single, not numbered)
        // ============================================================
        $this->importPdkm($basePath, $periods);

        // ============================================================
        // GBHKM - Garis-Garis Besar Haluan Keluarga Mahasiswa (single, not numbered)
        // ============================================================
        $this->importGbhkm($basePath, $periods);

        // ============================================================
        // PKM - Peraturan Keluarga Mahasiswa (numbered, yearly)
        // ============================================================
        $this->importPkm($basePath, $periods);

        // ============================================================
        // PDPM - Peraturan Dewan Permusyawaratan Mahasiswa (numbered, yearly)
        // ============================================================
        $this->importPdpm($basePath, $periods);

        $this->command->info('Legal products imported successfully!');
        $this->command->info('Total: ' . LegalProduct::count() . ' records');
    }

    private function importPdkm(string $basePath, array $periods): void
    {
        $dir = $basePath . '/PDKM UII';
        if (!File::isDirectory($dir)) {
            $this->command->warn("PDKM directory not found: {$dir}");
            return;
        }

        $files = File::files($dir);
        foreach ($files as $file) {
            $filename = $file->getFilename();
            if (Str::endsWith($filename, '.pdf')) {
                $this->createLegalProduct([
                    'type' => 'pdkm',
                    'number' => null,
                    'year' => $this->extractYearFromFilename($filename) ?? 2024,
                    'period_id' => $this->findPeriodId($periods, $this->extractYearFromFilename($filename) ?? 2024),
                    'title' => $this->cleanTitle($filename, 'pdkm'),
                    'description' => 'Peraturan Dasar Keluarga Mahasiswa (PDKM) merupakan konstitusi tertinggi KM UII yang mengatur asas, tujuan, kelembagaan, dan sistem pemerintahan mahasiswa.',
                    'file_path' => 'uploads/produk-hukum/PDKM UII/' . $filename,
                    'mime_type' => 'application/pdf',
                    'size' => $file->getSize(),
                    'is_published' => true,
                    'published_at' => now(),
                    'sort_order' => 1,
                ]);
            }
        }
    }

    private function importGbhkm(string $basePath, array $periods): void
    {
        $dir = $basePath . '/GBHKM';
        if (!File::isDirectory($dir)) {
            $this->command->warn("GBHKM directory not found: {$dir}");
            return;
        }

        $files = File::files($dir);
        foreach ($files as $file) {
            $filename = $file->getFilename();
            if (Str::endsWith($filename, '.pdf')) {
                $year = $this->extractYearFromFilename($filename) ?? 2024;
                $this->createLegalProduct([
                    'type' => 'gbhkm',
                    'number' => null,
                    'year' => $year,
                    'period_id' => $this->findPeriodId($periods, $year),
                    'title' => $this->cleanTitle($filename, 'gbhkm'),
                    'description' => 'Garis-Garis Besar Haluan Keluarga Mahasiswa (GBHKM) berisi arah kebijakan KM UII per periode: visi, misi, dan strategi pengembangan organisasi.',
                    'file_path' => 'uploads/produk-hukum/GBHKM/' . $filename,
                    'mime_type' => 'application/pdf',
                    'size' => $file->getSize(),
                    'is_published' => true,
                    'published_at' => now(),
                    'sort_order' => 1,
                ]);
            }
        }
    }

    private function importPkm(string $basePath, array $periods): void
    {
        $dir = $basePath . '/PKM UII';
        if (!File::isDirectory($dir)) {
            $this->command->warn("PKM directory not found: {$dir}");
            return;
        }

        $files = File::files($dir);
        $sortOrder = 1;

        foreach ($files as $file) {
            $filename = $file->getFilename();
            if (!Str::endsWith($filename, '.pdf')) {
                continue;
            }

            // Skip duplicate files
            if ($this->isDuplicate($files, $filename)) {
                continue;
            }

            // Use base filename (without version suffixes) for parsing
            $baseFilename = $this->getBaseFilename($filename);
            $data = $this->parsePkmFilename($baseFilename);
            if (!$data) {
                $this->command->warn("Could not parse PKM filename: {$filename}");
                continue;
            }

            $this->createLegalProduct([
                'type' => 'pkm',
                'number' => $data['number'],
                'year' => $data['year'],
                'period_id' => $this->findPeriodId($periods, $data['year']),
                'title' => $data['title'],
                'description' => $data['description'] ?? 'Peraturan Keluarga Mahasiswa (PKM) merupakan peraturan teknis yang menjabarkan PDKM dan GBHKM, disusun per nomor dan tahun.',
                'file_path' => 'uploads/produk-hukum/PKM UII/' . $filename,
                'mime_type' => 'application/pdf',
                'size' => $file->getSize(),
                'is_published' => true,
                'published_at' => now(),
                'sort_order' => $sortOrder++,
            ]);
        }
    }

    private function importPdpm(string $basePath, array $periods): void
    {
        $dir = $basePath . '/PDPM UII';
        if (!File::isDirectory($dir)) {
            $this->command->warn("PDPM directory not found: {$dir}");
            return;
        }

        $files = File::files($dir);
        $sortOrder = 1;

        foreach ($files as $file) {
            $filename = $file->getFilename();
            if (!Str::endsWith($filename, '.pdf')) {
                continue;
            }

            // Skip duplicate files
            if ($this->isDuplicate($files, $filename)) {
                continue;
            }

            // Use base filename (without version suffixes) for parsing
            $baseFilename = $this->getBaseFilename($filename);
            $data = $this->parsePdpmFilename($baseFilename);
            if (!$data) {
                $this->command->warn("Could not parse PDPM filename: {$filename}");
                continue;
            }

            $this->createLegalProduct([
                'type' => 'pdpm',
                'number' => $data['number'],
                'year' => $data['year'],
                'period_id' => $this->findPeriodId($periods, $data['year']),
                'title' => $data['title'],
                'description' => $data['description'] ?? 'Peraturan Dewan Permusyawaratan Mahasiswa (PDPM) merupakan peraturan internal DPM: tata tertib, mekanisme kerja, persidangan, dan hal teknis operasional.',
                'file_path' => 'uploads/produk-hukum/PDPM UII/' . $filename,
                'mime_type' => 'application/pdf',
                'size' => $file->getSize(),
                'is_published' => true,
                'published_at' => now(),
                'sort_order' => $sortOrder++,
            ]);
        }
    }

    private function parsePkmFilename(string $filename): ?array
    {
        // Remove .pdf extension
        $name = Str::replaceLast('.pdf', '', $filename);

        // Pattern 1: "PKM No. X Th YYYY tentang ..." or "PKM NOMOR X TAHUN YYYY TENTANG ..."
        if (preg_match('/PKM\s+(?:No\.?|NOMOR)\s+(\d+)\s+(?:Th|TAHUN)\s+(\d{4})\s+(?:tentang|TENTANG|TTG)\s+(.+)/i', $name, $matches)) {
            return [
                'number' => (int) $matches[1],
                'year' => (int) $matches[2],
                'title' => $this->titleCase($matches[3]),
                'description' => null,
            ];
        }

        // Pattern 2: "PKM No. X Tahun YYYY tentang ..."
        if (preg_match('/PKM\s+No\.\s+(\d+)\s+Tahun\s+(\d{4})\s+tentang\s+(.+)/i', $name, $matches)) {
            return [
                'number' => (int) $matches[1],
                'year' => (int) $matches[2],
                'title' => $this->titleCase($matches[3]),
                'description' => null,
            ];
        }

        // Pattern 3: "PKM NOMOR X TAHUN YYYY TENTANG ..."
        if (preg_match('/PKM\s+NOMOR\s+(\d+)\s+TAHUN\s+(\d{4})\s+TENTANG\s+(.+)/i', $name, $matches)) {
            return [
                'number' => (int) $matches[1],
                'year' => (int) $matches[2],
                'title' => $this->titleCase($matches[3]),
                'description' => null,
            ];
        }

        // Pattern 4: "PKM UII Nomor X Tahun YYYY tentang ..." or "PKM UII NOMOR X TAHUN YYYY TENTANG ..."
        if (preg_match('/PKM\s+UII\s+(?:Nomor|NOMOR)\s+(\d+)\s+(?:Tahun|TAHUN)\s+(\d{4})\s+(?:tentang|TENTANG|TTG)\s+(.+)/i', $name, $matches)) {
            return [
                'number' => (int) $matches[1],
                'year' => (int) $matches[2],
                'title' => $this->titleCase($matches[3]),
                'description' => null,
            ];
        }

        // Pattern 5: "PKM PEMILWA DAN PENJELASAN YYYY"
        if (preg_match('/PKM\s+(.+)\s+(\d{4})/i', $name, $matches)) {
            $title = $this->titleCase($matches[1]);
            $year = (int) $matches[2];

            // Try to extract number from title if it's a specific regulation
            $number = null;
            if (preg_match('/nomor\s+(\d+)/i', $title, $numMatches)) {
                $number = (int) $numMatches[1];
            }

            return [
                'number' => $number,
                'year' => $year,
                'title' => $title,
                'description' => null,
            ];
        }

        return null;
    }

    private function parsePdpmFilename(string $filename): ?array
    {
        $name = Str::replaceLast('.pdf', '', $filename);

        // Pattern 1: "PDPM X YYYY" or "PDPM SU XLI YYYY" (with space)
        // More permissive roman numeral pattern to match XL, XLI, etc.
        if (preg_match('/PDPM\s+(?:SU\s+)?([XVILCDM]+|\d+)\s+(\d{4})/i', $name, $matches)) {
            $year = (int) $matches[2];

            // Extract number from roman numeral or number
            $numberStr = strtoupper(trim($matches[1]));
            $number = $this->romanToInt($numberStr) ?? ((int) $numberStr ?: 1);

            // Extract title from the rest
            $titlePart = Str::afterLast($name, $year);
            $title = $titlePart ? $this->titleCase($titlePart) : 'Peraturan Dewan Permusyawaratan Mahasiswa';

            return [
                'number' => $number,
                'year' => $year,
                'title' => $title,
                'description' => null,
            ];
        }

        // Pattern 2: "Peraturan DPM UII Nomor X Tahun YYYY TENTANG ..."
        if (preg_match('/Peraturan\s+DPM\s+UII\s+Nomor\s+(\d+)\s+Tahun\s+(\d{4})\s+TENTANG\s+(.+)/i', $name, $matches)) {
            return [
                'number' => (int) $matches[1],
                'year' => (int) $matches[2],
                'title' => $this->titleCase($matches[3]),
                'description' => null,
            ];
        }

        // Pattern 3: "PDPM Nomor X Tahun YYYY ..."
        if (preg_match('/PDPM\s+Nomor\s+(\d+)\s+Tahun\s+(\d{4})\s+(.+)/i', $name, $matches)) {
            return [
                'number' => (int) $matches[1],
                'year' => (int) $matches[2],
                'title' => $this->titleCase($matches[3]),
                'description' => null,
            ];
        }

        // Pattern 4: "PDPM UII NOMOR X TAHUN YYYY TENTANG ..."
        if (preg_match('/PDPM\s+UII\s+NOMOR\s+(\d+)\s+TAHUN\s+(\d{4})\s+TENTANG\s+(.+)/i', $name, $matches)) {
            return [
                'number' => (int) $matches[1],
                'year' => (int) $matches[2],
                'title' => $this->titleCase($matches[3]),
                'description' => null,
            ];
        }

        // Pattern 5: "PDPM SU XLI YYYY" (with SU prefix) - fallback
        if (preg_match('/PDPM\s+SU\s+(X{0,3}(?:IX|IV|V?I{0,3})|XL[IV]?)\s+(\d{4})/i', $name, $matches)) {
            $roman = strtoupper(trim($matches[1]));
            $year = (int) $matches[2];
            $number = $this->romanToInt($roman) ?? 1;

            return [
                'number' => $number,
                'year' => $year,
                'title' => 'Peraturan Dewan Permusyawaratan Mahasiswa',
                'description' => null,
            ];
        }

        return null;
    }

    private function romanToInt(string $roman): ?int
    {
        $roman = strtoupper(trim($roman));
        $map = [
            'I' => 1, 'II' => 2, 'III' => 3, 'IV' => 4, 'V' => 5,
            'VI' => 6, 'VII' => 7, 'VIII' => 8, 'IX' => 9, 'X' => 10,
            'XI' => 11, 'XII' => 12, 'XIII' => 13, 'XIV' => 14, 'XV' => 15,
            'XVI' => 16, 'XVII' => 17, 'XVIII' => 18, 'XIX' => 19, 'XX' => 20,
            'XXI' => 21, 'XXII' => 22, 'XXIII' => 23, 'XXIV' => 24, 'XXV' => 25,
            'XXVI' => 26, 'XXVII' => 27, 'XXVIII' => 28, 'XXIX' => 29, 'XXX' => 30,
            'XXXI' => 31, 'XXXII' => 32, 'XXXIII' => 33, 'XXXIV' => 34, 'XXXV' => 35,
            'XXXVI' => 36, 'XXXVII' => 37, 'XXXVIII' => 38, 'XXXIX' => 39, 'XL' => 40,
            'XLI' => 41, 'XLII' => 42, 'XLIII' => 43, 'XLIV' => 44, 'XLV' => 45,
        ];

        return $map[$roman] ?? null;
    }

    private function extractYearFromFilename(string $filename): ?int
    {
        if (preg_match('/(?:20\d{2}|19\d{2})/', $filename, $matches)) {
            return (int) $matches[0];
        }
        return null;
    }

    private function getBaseFilename(string $filename): string
    {
        // Remove version suffixes like -1, -2, -final, _final, etc.
        return preg_replace('/[-_](final|v?\d+)(?=\.pdf$)/i', '', $filename);
    }

    private function isDuplicate(array $files, string $filename): bool
    {
        $baseName = $this->getBaseFilename($filename);

        foreach ($files as $file) {
            $otherName = $file->getFilename();
            if ($otherName === $filename) {
                continue;
            }
            if ($this->getBaseFilename($otherName) === $baseName) {
                // Keep the one without suffix or with "final" in name
                if (Str::contains($filename, ['-final', '_final', '-1', '_1'])) {
                    return true; // This is a duplicate version
                }
            }
        }
        return false;
    }

    private function cleanTitle(string $filename, string $type): string
    {
        $name = Str::replaceLast('.pdf', '', $filename);
        $name = $this->getBaseFilename($name);

        // Remove common prefixes
        $name = preg_replace('/^(PDKM|GBHKM|PKM|PDPM)\s+(?:UII\s+)?/i', '', $name);
        $name = preg_replace('/^(?:NOMOR|No\.?|Nomor)\s+\d+\s+(?:TAHUN|Th)\s+\d{4}\s+(?:TENTANG|tentang)\s*/i', '', $name);
        $name = preg_replace('/^(?:SU\s+)?(?:X{0,3}(?:IX|IV|V?I{0,3})|\d+)\s+\d{4}\s*/i', '', $name);

        $name = trim($name, ' -_');

        if (empty($name)) {
            $typeLabels = [
                'pdkm' => 'Peraturan Dasar Keluarga Mahasiswa UII',
                'gbhkm' => 'Garis-Garis Besar Haluan Keluarga Mahasiswa',
                'pkm' => 'Peraturan Keluarga Mahasiswa',
                'pdpm' => 'Peraturan Dewan Permusyawaratan Mahasiswa',
            ];
            return $typeLabels[$type] ?? Str::ucfirst($type);
        }

        return $this->titleCase($name);
    }

    private function titleCase(string $text): string
    {
        // Convert to title case but preserve certain words
        $text = mb_strtolower($text);
        $text = ucwords($text);

        // Fix common abbreviations
        $replacements = [
            'Uii' => 'UII',
            'Km' => 'KM',
            'Dpm' => 'DPM',
            'Pdkm' => 'PDKM',
            'Gbhkm' => 'GBHKM',
            'Pkm' => 'PKM',
            'Pdpm' => 'PDPM',
            'Sk' => 'SK',
            'Tap' => 'TAP',
            'Su' => 'SU',
            'Fbe' => 'FBE',
            'Fh' => 'FH',
            'Fiai' => 'FIAI',
            'Fk' => 'FK',
            'Fmipa' => 'FMIPA',
            'Fti' => 'FTI',
            'Ftsp' => 'FTSP',
            'Kpu' => 'KPU',
            'Bak' => 'BAK',
            'Bpa' => 'BPA',
            'Baleg' => 'Baleg',
            'Bawas' => 'Bawas',
            'Bosaj' => 'Bosaj',
            'Mentari' => 'Mentari',
            'Panwas' => 'Panwas',
            'Mo' => 'MO',
            'Ad' => 'AD',
            'Kpsu' => 'KPSU',
            'Rpkm' => 'RPKM',
            'Lmbg' => 'LMBG',
            'UkMK' => 'UKMK',
            'Ttg' => 'Tentang',
            'Nmr' => 'Nomor',
            'Thn' => 'Tahun',
            'Pdpm' => 'PDPM',
            'Pemilwa' => 'Pemilwa',
            'Foraslak' => 'Foraslak',
            'UkMK' => 'UKMK',
            'Nomotor' => 'Nomor',
            'Administrasi' => 'Administrasi',
            'Monitoring' => 'Monitoring',
            'Advokasi' => 'Advokasi',
            'Pesona' => 'Pesona',
            'Taaruf' => 'Taaruf',
            'Nomor' => 'Nomor',  // Ensure Nomor stays Nomor
            'Nomor' => 'Nomor',
        ];

        // First fix the specific "NoMOr" issue that comes from ucwords on "NOMOR"
        $text = str_ireplace('NoMOr', 'Nomor', $text);
        $text = str_ireplace('Nomor', 'Nomor', $text); // Normalize

        foreach ($replacements as $search => $replace) {
            $text = str_ireplace($search, $replace, $text);
        }

        return $text;
    }

    private function findPeriodId(array $periods, int $year): ?int
    {
        // Map year to period name (e.g., 2024 -> 2024/2025)
        $periodName = $year . '/' . ($year + 1);
        return $periods[$periodName] ?? null;
    }

    private function createLegalProduct(array $data): void
    {
        $slug = Str::slug($data['title'] . '-' . $data['type'] . '-' . ($data['number'] ?? 'single') . '-' . $data['year']);

        // Ensure unique slug
        $originalSlug = $slug;
        $counter = 1;
        while (LegalProduct::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        LegalProduct::create(array_merge($data, [
            'slug' => $slug,
        ]));

        $number = $data['number'] ?? '-';
        $this->command->info("Created: {$data['type']} | No. {$number} | {$data['year']} | {$data['title']}");
    }
}