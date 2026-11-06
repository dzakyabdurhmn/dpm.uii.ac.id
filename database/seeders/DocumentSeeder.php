<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Period;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        $basePath = public_path('uploads/produk-hukum');

        if (! File::isDirectory($basePath)) {
            $this->command->error("Directory not found: {$basePath}");

            return;
        }

        // Clear existing documents first (keep categories)
        Document::query()->delete();
        $this->command->info('Cleared existing documents.');

        // Ensure categories exist
        $this->ensureCategories();

        // Get periods for reference
        $periods = Period::query()->orderBy('starts_on')->get();

        // ============================================================
        // Import all folders
        // ============================================================

        // 1. Surat Keputusan (Decision Letters)
        $this->importSuratKeputusan($basePath, $periods);

        // 2. Surat Ketetapan (Decrees)
        $this->importSuratKetetapan($basePath, $periods);

        // 3. Keterangan Akademik (Academic Certificates)
        $this->importKeteranganAkademik($basePath, $periods);

        $this->command->info('Documents imported successfully!');
        $this->command->info('Total: '.Document::count().' records');
    }

    private function ensureCategories(): void
    {
        $categories = [
            [
                'name' => 'Surat Keputusan',
                'slug' => 'surat-keputusan',
                'group' => 'Keputusan',
                'description' => 'Surat keputusan yang dikeluarkan DPM UII: badan, tim kelengkapan dewan, lembaga, dan penyelenggara pemilu.',
                'sort_order' => 2,
                'type' => 'main',
            ],
            [
                'name' => 'Badan Kelengkapan Dewan',
                'slug' => 'badan-kelengkapan-dewan',
                'group' => 'Keputusan',
                'description' => 'Surat keputusan dari badan-badan kelengkapan Dewan: Baleg, Bawas, BAK, BPA, Bksaj, Mentari, Pimpinan, KPU, Panwas, Sekretariat.',
                'sort_order' => 1,
                'type' => 'sub',
                'parent_slug' => 'surat-keputusan',
            ],
            [
                'name' => 'DPM Fakultas',
                'slug' => 'dpm-fakultas',
                'group' => 'Keputusan',
                'description' => 'Surat keputusan dari DPM Fakultas se-UII: FBE, FH, FIA, FK, FMIPA, FTI, FTSP, FPSB, FPSI, FIA, FEB, dll.',
                'sort_order' => 2,
                'type' => 'sub',
                'parent_slug' => 'surat-keputusan',
            ],
            [
                'name' => 'Lembaga & LK',
                'slug' => 'lembaga-lk',
                'group' => 'Keputusan',
                'description' => 'Surat keputusan dari Lembaga Khusus, LK, dan unit kerja lain: Pers Himmah, Tim Produksi, dll.',
                'sort_order' => 3,
                'type' => 'sub',
                'parent_slug' => 'surat-keputusan',
            ],
            [
                'name' => 'Surat Ketetapan',
                'slug' => 'surat-ketetapan',
                'group' => 'Keputusan',
                'description' => 'Ketetapan dan penetapan yang dikeluarkan DPM UII dalam sidang paripurna.',
                'sort_order' => 3,
                'type' => 'main',
            ],
            [
                'name' => 'Keterangan Akademik',
                'slug' => 'keterangan-akademik',
                'group' => 'Akademik',
                'description' => 'Surat keterangan akademik yang diterbitkan DPM UII.',
                'sort_order' => 8,
                'type' => 'main',
            ],
            [
                'name' => 'Laporan Kinerja',
                'slug' => 'laporan-kinerja',
                'group' => 'Kinerja',
                'description' => 'Laporan kinerja DPM UII: Foraslak, Laporan Akhir, Evaluasi Kinerja, dan dokumen penilaian kinerja per periode.',
                'sort_order' => 9,
                'type' => 'main',
            ],
        ];

        $parentIds = [];

        // First pass: create main categories
        foreach ($categories as $category) {
            if ($category['type'] === 'main') {
                $created = DocumentCategory::query()->updateOrCreate(
                    ['slug' => $category['slug']],
                    array_merge($category, ['parent_id' => null])
                );
                $parentIds[$category['slug']] = $created->id;
            }
        }

        // Second pass: create sub-categories
        foreach ($categories as $category) {
            if ($category['type'] === 'sub') {
                $parentId = $parentIds[$category['parent_slug']] ?? null;
                $data = $category;
                unset($data['parent_slug']);
                DocumentCategory::query()->updateOrCreate(
                    ['slug' => $data['slug']],
                    array_merge($data, ['parent_id' => $parentId])
                );
            }
        }
    }

    private function importSuratKeputusan(string $basePath, $periods): void
    {
        $dir = $basePath.'/SURAT KEPUTUSAN';
        if (! File::isDirectory($dir)) {
            $this->command->warn("Surat Keputusan directory not found: {$dir}");

            return;
        }

        $files = File::files($dir);
        $processed = 0;
        $skipped = 0;

        foreach ($files as $file) {
            $filename = $file->getFilename();
            if (! Str::endsWith($filename, '.pdf')) {
                continue;
            }

            // Skip if file doesn't exist or is 0 bytes
            if (! $file->isFile() || $file->getSize() === 0) {
                $skipped++;

                continue;
            }

            // Skip duplicate files (keep best version)
            if ($this->isDuplicate($files, $filename)) {
                $skipped++;

                continue;
            }

            $data = $this->parseSuratKeputusanFilename($filename);
            if (! $data) {
                $this->command->warn("Could not parse Surat Keputusan filename: {$filename}");

                continue;
            }

            // Determine sub-category based on filename
            $subCategorySlug = $this->determineSubCategory($filename);
            $subCategory = DocumentCategory::where('slug', $subCategorySlug)->first();

            // Fallback to main category
            $category = $subCategory ?? DocumentCategory::where('slug', 'surat-keputusan')->first();

            if (! $category) {
                $this->command->error('Surat Keputusan category not found');

                continue;
            }

            $year = $data['year'] ?? $this->extractYearFromFilename($filename) ?? 2024;

            try {
                Document::create([
                    'document_category_id' => $category->id,
                    'period_id' => $this->findPeriodId($periods, $year),
                    'title' => $data['title'],
                    'slug' => $this->generateUniqueSlug($data['title']),
                    'description' => $data['description'] ?? 'Surat Keputusan DPM UII',
                    'file_path' => 'uploads/produk-hukum/SURAT KEPUTUSAN/'.$filename,
                    'mime_type' => 'application/pdf',
                    'size' => $file->getSize(),
                    'year' => $year,
                    'quarter' => null,
                    'published_at' => now(),
                    'is_featured' => false,
                    'sort_order' => $processed + 1,
                ]);

                $catLabel = $subCategory ? $subCategory->name : 'Surat Keputusan (Utama)';
                $this->command->info("Created Document: {$catLabel} | {$year} | {$data['title']}");
                $processed++;
            } catch (\Exception $e) {
                $this->command->error("Failed to create document for {$filename}: ".$e->getMessage());
                $skipped++;
            }
        }

        $this->command->info("Surat Keputusan: {$processed} imported, {$skipped} duplicates skipped");
    }

    private function importSuratKetetapan(string $basePath, $periods): void
    {
        $dir = $basePath.'/SURAT KETETAPAN';
        if (! File::isDirectory($dir)) {
            $this->command->warn("Surat Ketetapan directory not found: {$dir}");

            return;
        }

        $category = DocumentCategory::where('slug', 'surat-ketetapan')->first();
        if (! $category) {
            $this->command->error('Surat Ketetapan category not found');

            return;
        }

        $files = File::files($dir);
        $processed = 0;
        $skipped = 0;

        foreach ($files as $file) {
            $filename = $file->getFilename();
            if (! Str::endsWith($filename, '.pdf')) {
                continue;
            }

            // Skip duplicate files
            if ($this->isDuplicate($files, $filename)) {
                $skipped++;

                continue;
            }

            $data = $this->parseSuratKetetapanFilename($filename);
            if (! $data) {
                $this->command->warn("Could not parse Surat Ketetapan filename: {$filename}");

                continue;
            }

            $year = $data['year'] ?? $this->extractYearFromFilename($filename) ?? 2024;

            Document::create([
                'document_category_id' => $category->id,
                'period_id' => $this->findPeriodId($periods, $year),
                'title' => $data['title'],
                'slug' => $this->generateUniqueSlug($data['title']),
                'description' => $data['description'] ?? 'Surat Ketetapan DPM UII',
                'file_path' => 'uploads/produk-hukum/SURAT KETETAPAN/'.$filename,
                'mime_type' => 'application/pdf',
                'size' => $file->getSize(),
                'year' => $year,
                'quarter' => null,
                'published_at' => now(),
                'is_featured' => false,
                'sort_order' => $processed + 1,
            ]);

            $this->command->info("Created Document: Surat Ketetapan | {$year} | {$data['title']}");
            $processed++;
        }

        $this->command->info("Surat Ketetapan: {$processed} imported, {$skipped} duplicates skipped");
    }

    private function importKeteranganAkademik(string $basePath, $periods): void
    {
        $dir = $basePath.'/KETERANGAN AKADEMIK';
        if (! File::isDirectory($dir)) {
            $this->command->warn("Keterangan Akademik directory not found: {$dir}");

            return;
        }

        $category = DocumentCategory::where('slug', 'keterangan-akademik')->first();
        if (! $category) {
            $this->command->error('Keterangan Akademik category not found');

            return;
        }

        $files = File::files($dir);
        $processed = 0;
        $skipped = 0;

        foreach ($files as $file) {
            $filename = $file->getFilename();
            if (! Str::endsWith($filename, '.pdf')) {
                continue;
            }

            // Skip duplicate files
            if ($this->isDuplicate($files, $filename)) {
                $skipped++;

                continue;
            }

            $data = $this->parseKeteranganAkademikFilename($filename);
            if (! $data) {
                $this->command->warn("Could not parse Keterangan Akademik filename: {$filename}");

                continue;
            }

            $year = $data['year'] ?? $this->extractYearFromFilename($filename) ?? 2024;

            Document::create([
                'document_category_id' => $category->id,
                'period_id' => $this->findPeriodId($periods, $year),
                'title' => $data['title'],
                'slug' => $this->generateUniqueSlug($data['title']),
                'description' => $data['description'] ?? 'Keterangan Akademik DPM UII',
                'file_path' => 'uploads/produk-hukum/KETERANGAN AKADEMIK/'.$filename,
                'mime_type' => 'application/pdf',
                'size' => $file->getSize(),
                'year' => $year,
                'quarter' => null,
                'published_at' => now(),
                'is_featured' => false,
                'sort_order' => $processed + 1,
            ]);

            $this->command->info("Created Document: Keterangan Akademik | {$year} | {$data['title']}");
            $processed++;
        }

        $this->command->info("Keterangan Akademik: {$processed} imported, {$skipped} duplicates skipped");
    }

    private function parseSuratKeputusanFilename(string $filename): ?array
    {
        $name = Str::replaceLast('.pdf', '', $filename);
        $name = $this->getBaseFilename($name);

        // Pattern: "SK [SUBJECT] [YEAR]" or "SURAT KEPUTUSAN [SUBJECT] [YEAR]"
        // Also: "SK-BALEG KOMISI I REVISI", "SK-STRUKTUR KPSU-UII 2021", etc.

        // Try to extract year from filename
        $year = $this->extractYearFromFilename($filename);

        // Clean up the title
        $title = $name;

        // Remove "SURAT KEPUTUSAN" prefix
        $title = preg_replace('/^SURAT\s+KEPUTUSAN\s+/i', '', $title);
        // Remove "SK" prefix
        $title = preg_replace('/^SK\s*[-_]?\s*/i', '', $title);
        // Remove trailing year
        if ($year) {
            $title = preg_replace('/\s+'.preg_quote((string) $year, '/').'\s*$/i', '', $title);
        }
        // Remove version suffixes
        $title = preg_replace('/[-_](final|v?\d+)$/i', '', $title);

        $title = trim($title, ' -_');
        $title = $this->titleCase($title);

        if (empty($title)) {
            $title = 'Surat Keputusan DPM UII';
        }

        return [
            'title' => $title,
            'year' => $year,
            'description' => 'Surat Keputusan DPM UII',
        ];
    }

    private function parseSuratKetetapanFilename(string $filename): ?array
    {
        $name = Str::replaceLast('.pdf', '', $filename);
        $name = $this->getBaseFilename($name);

        $year = $this->extractYearFromFilename($filename);

        // "S-TAP-SU-XLI_DPM UII-final"
        $title = $name;
        $title = preg_replace('/^S-TAP-SU-/i', '', $title);
        $title = preg_replace('/_DPM\s*UII/i', '', $title);
        if ($year) {
            $title = preg_replace('/\s+'.preg_quote((string) $year, '/').'\s*$/i', '', $title);
        }
        $title = preg_replace('/[-_](final|v?\d+)$/i', '', $title);

        $title = trim($title, ' -_');
        $title = $this->titleCase($title);

        if (empty($title)) {
            $title = 'Surat Ketetapan DPM UII';
        }

        // Parse roman numeral for number
        $number = null;
        if (preg_match('/X{0,3}(?:IX|IV|V?I{0,3})/i', $name, $matches)) {
            $number = $this->romanToInt(strtoupper($matches[0]));
        }

        return [
            'title' => $title,
            'year' => $year,
            'description' => 'Surat Ketetapan DPM UII',
        ];
    }

    private function parseKeteranganAkademikFilename(string $filename): ?array
    {
        $name = Str::replaceLast('.pdf', '', $filename);
        $name = $this->getBaseFilename($name);

        $year = $this->extractYearFromFilename($filename);

        // "KA RPKM KODE ETIK LEMBAGA LEGISLATIF"
        // "KETERANGAN AKADEMIK PEDOMAN KEGIATAN"
        $title = $name;
        $title = preg_replace('/^KETERANGAN\s+AKADEMIK\s+/i', '', $title);
        $title = preg_replace('/^KA\s+/i', '', $title);
        $title = preg_replace('/^RPKM\s+/i', '', $title);
        if ($year) {
            $title = preg_replace('/\s+'.preg_quote((string) $year, '/').'\s*$/i', '', $title);
        }
        $title = preg_replace('/[-_](final|v?\d+)$/i', '', $title);

        $title = trim($title, ' -_');
        $title = $this->titleCase($title);

        if (empty($title)) {
            $title = 'Keterangan Akademik DPM UII';
        }

        return [
            'title' => $title,
            'year' => $year,
            'description' => 'Keterangan Akademik DPM UII',
        ];
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
        // Remove version suffixes like -1, -2, -3, -4, -final, _final, etc.
        // Handle multiple suffixes: "final-1", "final-2", etc.
        $name = $filename;
        // First remove trailing -1, -2, -3, -4 etc (numbered versions)
        $name = preg_replace('/[-_](\d+)(?=\.pdf$)/i', '', $name);
        // Then remove -final, _final, -finall
        $name = preg_replace('/[-_](final|finall)(?=\.pdf$)/i', '', $name);

        return $name;
    }

    private function isDuplicate(array $files, string $filename): bool
    {
        $baseName = $this->getBaseFilename($filename);

        // Build a map of base names to best file (prefer final versions, then shorter names)
        $bestFiles = [];

        foreach ($files as $file) {
            $name = $file->getFilename();
            $base = $this->getBaseFilename($name);
            $hasFinal = Str::contains($name, ['-final', '_final', '-finall']);
            $score = strlen($name);
            if ($hasFinal) {
                $score -= 1000; // Prefer final versions
            }

            if (! isset($bestFiles[$base]) || $score < $bestFiles[$base]['score']) {
                $bestFiles[$base] = ['name' => $name, 'score' => $score];
            }
        }

        // This file is a duplicate if it's not the best version
        return $bestFiles[$baseName]['name'] !== $filename;
    }

    private function titleCase(string $text): string
    {
        $text = mb_strtolower($text);
        $text = ucwords($text);

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
            'Bksaj' => 'Bksaj',
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
            'Nomor' => 'Nomor',
            'Administrasi' => 'Administrasi',
            'Monitoring' => 'Monitoring',
            'Advokasi' => 'Advokasi',
            'Pesona' => 'Pesona',
            'Taaruf' => 'Taaruf',
            'Kode' => 'Kode',
            'Etik' => 'Etik',
            'Lembaga' => 'Lembaga',
            'Legislatif' => 'Legislatif',
            'Struktur' => 'Struktur',
            'Pembentukan' => 'Pembentukan',
            'Pengelolaan' => 'Pengelolaan',
            'Aset' => 'Aset',
            'Kegiatan' => 'Kegiatan',
            'Pedoman' => 'Pedoman',
            'Tim' => 'Tim',
            'Pesta' => 'Pesta',
            'Final' => 'Final',
        ];

        // Fix specific "NoMOr" issue
        $text = str_ireplace('NoMOr', 'Nomor', $text);

        foreach ($replacements as $search => $replace) {
            $text = str_ireplace($search, $replace, $text);
        }

        return $text;
    }

    /**
     * Map a document year to the closest period. Dokumen lawas sebelum periode
     * tercatat tetap dikelompokkan ke periode terdekat.
     *
     * @param  Collection<int, Period>  $periods
     */
    private function findPeriodId($periods, int $year): ?int
    {
        // 1. Cocokkan nama periode akademik secara persis: 2024 -> "2024/2025".
        foreach ($periods as $period) {
            if ($period->name === $year.'/'.($year + 1)) {
                return $period->id;
            }
        }

        // 2. Periode yang mulai pada tahun yang sama.
        foreach ($periods as $period) {
            if ((int) $period->starts_on->year === $year) {
                return $period->id;
            }
        }

        // 3. Periode terdekat berdasarkan selisih tahun.
        $nearest = null;
        $nearestDistance = null;

        foreach ($periods as $period) {
            $distance = abs((int) $period->starts_on->year - $year);

            if ($nearestDistance === null || $distance < $nearestDistance) {
                $nearest = $period;
                $nearestDistance = $distance;
            }
        }

        return $nearest?->id;
    }

    private function generateUniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (Document::where('slug', $slug)->exists()) {
            $slug = $originalSlug.'-'.$counter++;
        }

        return $slug;
    }

    private function determineSubCategory(string $filename): ?string
    {
        $name = Str::upper($filename);

        // Badan Kelengkapan Dewan (Central bodies)
        $badanKeywords = [
            'BALEG', 'BALLEG', 'BAWAS', 'PANWAS', 'PANITIA PENGAWAS', 'PENGAWAS PEMILU', 'PEMILU',
            'BAK', 'BPA', 'BKSAJ', 'MENTARI',
            'PIMPINAN', 'KPU', 'KOMISI', 'SEKRETARIS', 'DIREKTORAT',
            'STRUKTUR KPSU', 'TIM MO', 'TIM AD', 'TIM PRODUKSI',
            'PEMBENTUKAN DPM FPSB',
        ];

        // DPM Fakultas (Faculty DPMs)
        $fakultasKeywords = [
            'DPM FBE', 'DPM FH', 'DPM FIA', 'DPM FK', 'DPM FMIPA',
            'DPM FTI', 'DPM FTSP', 'DPM FPSB', 'DPM FPSI', 'DPM FEB',
            'DPM FISIP',
        ];

        // Check for Badan Kelengkapan Dewan
        foreach ($badanKeywords as $keyword) {
            if (Str::contains($name, $keyword)) {
                return 'badan-kelengkapan-dewan';
            }
        }

        // Check for DPM Fakultas
        foreach ($fakultasKeywords as $keyword) {
            if (Str::contains($name, $keyword)) {
                return 'dpm-fakultas';
            }
        }

        // Lembaga & LK (catch-all for others like Pers Himmah, Tim Produksi, etc.)
        // Check for specific lembaga patterns
        if (Str::contains($name, ['PERS HIMMAH', 'PENGESAHAN STRUKTUR', 'TIM PRODUKSI', 'LEMBAGA KHUSUS'])) {
            return 'lembaga-lk';
        }

        // Default to main category
        return null;
    }
}
