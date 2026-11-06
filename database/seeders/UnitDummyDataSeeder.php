<?php

namespace Database\Seeders;

use App\Models\Official;
use App\Models\OrganizationalUnit;
use App\Models\Period;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UnitDummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create periods
        $periods = collect([
            ['name' => '2025/2026', 'is_active' => true, 'start_date' => '2025-01-01', 'end_date' => '2026-12-31'],
            ['name' => '2024/2025', 'is_active' => false, 'start_date' => '2024-01-01', 'end_date' => '2024-12-31'],
            ['name' => '2023/2024', 'is_active' => false, 'start_date' => '2023-01-01', 'end_date' => '2023-12-31'],
        ])->map(function ($data) {
            return Period::firstOrCreate(
                ['name' => $data['name']],
                $data
            );
        });

        $period2025 = $periods->where('name', '2025/2026')->first();
        $period2024 = $periods->where('name', '2024/2025')->first();
        $period2023 = $periods->where('name', '2023/2024')->first();

        // Get all active units
        $units = OrganizationalUnit::whereNull('parent_id')->where('is_active', true)->get();

        foreach ($units as $index => $unit) {
            // Update unit with additional info
            $unit->update([
                'abbreviation' => $this->getAbbreviation($unit->name),
                'description' => $this->getDescription($unit->name),
                'tasks' => $this->getTasks($unit->name),
                'work_programs' => $this->getWorkPrograms($unit->name),
                'email' => Str::slug($unit->name).'@dpm.uii.ac.id',
            ]);

            // Clear existing officials for this unit
            $unit->officials()->delete();

            // Define officials based on unit type
            $officialsData = $this->getOfficialsForUnit($unit->name);

            foreach ($officialsData as $order => $data) {
                // Generate and save photo using ui-avatars
                $photoPath = $this->savePhotoFromUrl($data['name'], $unit->slug.'-'.Str::slug($data['position']));

                Official::create([
                    'organizational_unit_id' => $unit->id,
                    'period_id' => $period2025->id,
                    'name' => $data['name'],
                    'position' => $data['position'],
                    'description' => $data['description'],
                    'photo_path' => $photoPath,
                    'email' => Str::slug($data['name']).'@students.uii.ac.id',
                    'instagram' => Str::slug($data['name']),
                    'linkedin' => Str::slug($data['name']),
                    'sort_order' => $order,
                    'is_active' => true,
                ]);
            }

            // Add some previous period officials
            if ($period2024) {
                $prevOfficials = [
                    ['name' => 'Mantan '.$officialsData[0]['name'], 'position' => $officialsData[0]['position'], 'description' => 'Pengurus periode sebelumnya'],
                    ['name' => 'Mantan '.$officialsData[1]['name'], 'position' => $officialsData[1]['position'], 'description' => 'Pengurus periode sebelumnya'],
                ];

                foreach ($prevOfficials as $order => $data) {
                    // Generate and save photo using ui-avatars
                    $photoPath = $this->savePhotoFromUrl($data['name'], $unit->slug.'-prev-'.Str::slug($data['position']));

                    Official::create([
                        'organizational_unit_id' => $unit->id,
                        'period_id' => $period2024->id,
                        'name' => $data['name'],
                        'position' => $data['position'],
                        'description' => $data['description'],
                        'photo_path' => $photoPath,
                        'email' => Str::slug($data['name']).'@students.uii.ac.id',
                        'instagram' => Str::slug($data['name']),
                        'linkedin' => Str::slug($data['name']),
                        'sort_order' => $order + 100,
                        'is_active' => true,
                    ]);
                }
            }

            // Add one unassigned official
            $photoPath = $this->savePhotoFromUrl('Anggota '.$unit->short_name, $unit->slug.'-unassigned');

            Official::create([
                'organizational_unit_id' => $unit->id,
                'period_id' => null,
                'name' => 'Anggota '.$unit->short_name,
                'position' => 'Anggota',
                'description' => 'Anggota biasa tanpa periode kepengurusan tertentu',
                'photo_path' => $photoPath,
                'email' => Str::slug('anggota-'.$unit->short_name).'@students.uii.ac.id',
                'instagram' => Str::slug('anggota-'.$unit->short_name),
                'linkedin' => Str::slug('anggota-'.$unit->short_name),
                'sort_order' => 999,
                'is_active' => true,
            ]);
        }

        $this->command->info('Dummy data created successfully!');
    }

    private function getAbbreviation(string $name): string
    {
        $abbreviations = [
            'Mentari' => 'Mentari',
            'Badan Legislasi' => 'Baleg',
            'Badan Pengawasan' => 'Bawas',
            'Badan Kerjasama, Advokasi & Jaringan' => 'Bksaj',
            'Badan Audit Kemahasiswaan' => 'BAK',
            'Badan Pengelola Aset' => 'BPA',
            'Pimpinan Dewan' => 'Pimpinan',
        ];
        $abbr = $abbreviations[$name] ?? $name;

        // Limit to 32 chars for DB column
        return Str::limit($abbr, 32, '');
    }

    private function getTasks(string $name): string
    {
        $tasks = [
            'Mentari' => "Mengelola media komunikasi DPM UII\nMengurus kesekretariatan dan administrasi dewan\nMendokumentasikan kegiatan dan sidang dewan\nMenerbitkan buletin dan publikasi resmi DPM",
            'Badan Legislasi' => "Menyusun rancangan produk hukum DPM\nMengkaji dan memberikan pertimbangan hukum\nMengkoordinasikan proses legislasi\nMengarsipkan dan mendokumentasikan produk hukum",
            'Badan Pengawasan' => "Mengawasi pelaksanaan fungsi dewan\nMengawasi pengelolaan dana dan aset\nMelakukan investigasi pelanggaran\nMenyusun laporan pengawasan berkala",
            'Badan Kerjasama, Advokasi & Jaringan' => "Membangun kerjasama antar lembaga\nMengadvokasi aspirasi mahasiswa\nMengelola jaringan alumni DPM\nMengkoordinasikan program kerja sama",
            'Badan Audit Kemahasiswaan' => "Mengaudit keuangan lembaga KM UII\nMemeriksa kelayakan pengelolaan dana\nMenyusun laporan hasil audit (LHA)\nMemberikan rekomendasi perbaikan",
            'Badan Pengelola Aset' => "Mengelola inventaris aset DPM\nMencatat dan memelihara aset\nMenyusun laporan pengelolaan aset\nMengkoordinasikan pengadaan barang",
            'Pimpinan Dewan' => "Memimpin rapat paripurna dewan\nMewakili dewan dalam forum eksternal\nMengkoordinasikan kerja alat kelengkapan\nMenetapkan agenda kebijakan dewan",
        ];

        return $tasks[$name] ?? "Tugas dan fungsi {$name} akan diisi.";
    }

    private function getWorkPrograms(string $name): string
    {
        $programs = [
            'Mentari' => "Lanjutan Website DPM UII\nProduksi Video Profil DPM\nPenerbitan Buletin Berkala\nSistem Informasi Sidang Digital",
            'Badan Legislasi' => "Penyusunan PDPM Baru\nKajian Hukum Produk Hukum KM\nDigitalisasi Arsip Produk Hukum\nPelatihan Legislasi untuk Anggota",
            'Badan Pengawasan' => "Audit Kinerja Alat Kelengkapan\nPengawasan Dana Periode 2025/2026\nSistem Pelaporan Pelanggaran Online\nEvaluasi Pelaksanaan Program Kerja",
            'Badan Kerjasama, Advokasi & Jaringan' => "Kerjasama dengan DPM Se-Jawa Tengah\nForum Aspirasi Mahasiswa Tingkat Nasional\nJaringan Alumni DPM UII\nProgram Magang Antar Lembaga",
            'Badan Audit Kemahasiswaan' => "Audit Keuangan Lembaga KM UII\nPenyusunan LHA Tahunan\nPelatihan Audit Internal\nSistem Monitoring Dana Real-time",
            'Badan Pengelola Aset' => "Inventarisasi Aset Lengkap\nSistem Manajemen Aset Digital\nPemeliharaan Rutin Aset\nPengadaan Perlengkapan Sidang",
            'Pimpinan Dewan' => "Rapat Paripurna Bulanan\nKoordinasi Alat Kelengkapan\nAdvokasi Kebijakan Mahasiswa\nEvaluasi Kinerja Dewan",
        ];

        return $programs[$name] ?? "Program kerja {$name} akan diisi.";
    }

    private function getDescription(string $name): string
    {
        $descriptions = [
            'Mentari' => 'Mentari adalah alat kelengkapan Dewan Permusyawaratan Mahasiswa UII yang bertanggung jawab atas media komunikasi, kesekretariatan, dokumentasi, dan penerbitan publikasi resmi DPM. Unit ini menjadi jembatan informasi antara dewan dengan mahasiswa dan publik.',
            'Badan Legislasi' => 'Badan Legislasi (Baleg) berfungsi menyusun, mengkaji, dan mengkoordinasikan proses pembentukan produk hukum DPM UII. Termasuk rancangan peraturan, kajian hukum, serta pengarsipan dan dokumentasi produk hukum.',
            'Badan Pengawasan' => 'Badan Pengawasan (Bawas) menjalankan fungsi pengawasan terhadap pelaksanaan fungsi dewan, pengelolaan dana dan aset, serta investigasi pelanggaran. Menyusun laporan pengawasan berkala untuk akuntabilitas dewan.',
            'Badan Kerjasama, Advokasi & Jaringan' => 'Badan Kerjasama, Advokasi & Jaringan (Bksaj) membangun kerjasama antar lembaga, mengadvokasi aspirasi mahasiswa ke forum tingkat tinggi, mengelola jaringan alumni DPM, serta mengkoordinasikan program kerja sama antar lembaga.',
            'Badan Audit Kemahasiswaan' => 'Badan Audit Kemahasiswaan (BAK) bertugas mengaudit keuangan seluruh lembaga KM UII, memeriksa kelayakan pengelolaan dana, menyusun Laporan Hasil Audit (LHA), dan memberikan rekomendasi perbaikan pengelolaan keuangan.',
            'Badan Pengelola Aset' => 'Badan Pengelola Aset (BPA) mengelola inventaris aset DPM, mencatat dan memelihara aset, menyusun laporan pengelolaan aset, serta mengkoordinasikan pengadaan barang dan jasa untuk kebutuhan dewan.',
            'Pimpinan Dewan' => 'Pimpinan Dewan memimpin rapat paripurna, mewakili dewan dalam forum eksternal, mengkoordinasikan kerja seluruh alat kelengkapan, serta menetapkan agenda kebijakan dewan untuk periode kepengurusan.',
        ];

        return $descriptions[$name] ?? "Deskripsi {$name} akan diisi.";
    }

    private function getOfficialsForUnit(string $name): array
    {
        $officials = [
            'Mentari' => [
                ['name' => 'Ahmad Rizki Pratama', 'position' => 'Ketua', 'description' => 'Koordinasi seluruh divisi Mentari, mengelola media komunikasi dan kesekretariatan DPM'],
                ['name' => 'Siti Nurhaliza', 'position' => 'Wakil Ketua', 'description' => 'Asisten ketua dalam pengelolaan media, dokumentasi, dan administrasi dewan'],
                ['name' => 'Muhammad Fajar Sidiq', 'position' => 'Sekretaris', 'description' => 'Mengurus administrasi, surat-menyurat, dan pencatatan rapat dewan'],
                ['name' => 'Dewi Sartika', 'position' => 'Bendahara', 'description' => 'Mengelola keuangan operasional Mentari dan pelaporan dana'],
                ['name' => 'Rizky Ramadhan', 'position' => 'Kepala Divisi Media', 'description' => 'Mengelola media sosial, website, dan produksi konten visual DPM'],
                ['name' => 'Nurul Aini', 'position' => 'Kepala Divisi Kesekretariatan', 'description' => 'Mengkoordinasikan administrasi, arsip, dan dokumen resmi dewan'],
                ['name' => 'Budi Santoso', 'position' => 'Staf Dokumentasi', 'description' => 'Mendokumentasikan kegiatan dan sidang dewan secara visual'],
                ['name' => 'Fitri Handayani', 'position' => 'Staf Publikasi', 'description' => 'Menyusun dan menerbitkan buletin serta materi publikasi DPM'],
            ],
            'Badan Legislasi' => [
                ['name' => 'Andi Wijaya', 'position' => 'Ketua', 'description' => 'Memimpin proses legislasi dan penyusunan produk hukum DPM'],
                ['name' => 'Rina Marlina', 'position' => 'Wakil Ketua', 'description' => 'Membantu ketua dalam kajian hukum dan koordinasi legislasi'],
                ['name' => 'Doni Saputra', 'position' => 'Sekretaris', 'description' => 'Mengelola administrasi legislasi dan arsip produk hukum'],
                ['name' => 'Sari Indah', 'position' => 'Bendahara', 'description' => 'Mengelola anggaran operasional Badan Legislasi'],
                ['name' => 'Eko Prasetyo', 'position' => 'Anggota Ahli Hukum', 'description' => 'Memberikan pertimbangan hukum atas rancangan produk hukum'],
                ['name' => 'Maya Sari', 'position' => 'Anggota Penyusun', 'description' => 'Menyusun draf rancangan peraturan dan perundang-undangan'],
                ['name' => 'Hendra Gunawan', 'position' => 'Anggota Arsiparis', 'description' => 'Mengelola sistem arsip dan dokumentasi produk hukum digital'],
            ],
            'Badan Pengawasan' => [
                ['name' => 'Irwan Setiawan', 'position' => 'Ketua', 'description' => 'Memimpin fungsi pengawasan kinerja dan keuangan DPM'],
                ['name' => 'Lestari Dewi', 'position' => 'Wakil Ketua', 'description' => 'Mengkoordinasikan tim pengawas dan penyusunan laporan'],
                ['name' => 'Agus Supriyanto', 'position' => 'Sekretaris', 'description' => 'Mencatat hasil pengawasan dan mengelola administrasi Bawas'],
                ['name' => 'Yuni Rahmawati', 'position' => 'Bendahara', 'description' => 'Mengelola dana operasional pengawasan'],
                ['name' => 'Rian Pratama', 'position' => 'Auditor Utama', 'description' => 'Melakukan audit kinerja dan keuangan alat kelengkapan'],
                ['name' => 'Dina Kartika', 'position' => 'Investigator', 'description' => 'Menyelidiki pelanggaran dan menyusun laporan investigasi'],
                ['name' => 'Fajar Hidayat', 'position' => 'Analis Data', 'description' => 'Menganalisis data pelaksanaan program kerja dan anggaran'],
            ],
            'Badan Kerjasama, Advokasi & Jaringan' => [
                ['name' => 'Reza Pahlevi', 'position' => 'Ketua', 'description' => 'Membangun jaringan kerjasama dan advokasi aspirasi mahasiswa'],
                ['name' => 'Putri Ayu', 'position' => 'Wakil Ketua', 'description' => 'Mengkoordinasikan program kerjasama dan advokasi'],
                ['name' => 'Dimas Aditya', 'position' => 'Sekretaris', 'description' => 'Mengurus administrasi kerjasama dan surat-menyurat eksternal'],
                ['name' => 'Aulia Rahma', 'position' => 'Bendahara', 'description' => 'Mengelola dana kerjasama dan program advokasi'],
                ['name' => 'Ivan Setiawan', 'position' => 'Koordinator Kerjasama', 'description' => 'Menjalin kerjasama dengan DPM lain dan lembaga eksternal'],
                ['name' => 'Sinta Dewi', 'position' => 'Koordinator Advokasi', 'description' => 'Mengadvokasi aspirasi mahasiswa ke forum tingkat tinggi'],
                ['name' => 'Bayu Prasetyo', 'position' => 'Koordinator Jaringan Alumni', 'description' => 'Mengelola database dan kegiatan alumni DPM UII'],
            ],
            'Badan Audit Kemahasiswaan' => [
                ['name' => 'Hasan Basri', 'position' => 'Ketua', 'description' => 'Memimpin audit keuangan seluruh lembaga KM UII'],
                ['name' => 'Nabila Putri', 'position' => 'Wakil Ketua', 'description' => 'Membantu ketua dalam perencanaan dan eksekusi audit'],
                ['name' => 'Adi Nugroho', 'position' => 'Sekretaris', 'description' => 'Mengelola administrasi audit dan penyusunan LHA'],
                ['name' => 'Rika Wulandari', 'position' => 'Bendahara', 'description' => 'Mengelola dana operasional Badan Audit'],
                ['name' => 'Tommy Gunawan', 'position' => 'Auditor Senior', 'description' => 'Melakukan audit lapangan ke lembaga-lembaga KM'],
                ['name' => 'Lina Marlina', 'position' => 'Auditor Junior', 'description' => 'Membantu pelaksanaan audit dan verifikasi dokumen'],
                ['name' => 'Yoga Pratama', 'position' => 'Analis Laporan', 'description' => 'Menganalisis laporan keuangan dan menyusun temuan audit'],
            ],
            'Badan Pengelola Aset' => [
                ['name' => 'Dedi Supriadi', 'position' => 'Ketua', 'description' => 'Mengelola seluruh aset dan inventaris DPM UII'],
                ['name' => 'Mega Safitri', 'position' => 'Wakil Ketua', 'description' => 'Mengkoordinasikan pencatatan dan pemeliharaan aset'],
                ['name' => 'Rudy Hartono', 'position' => 'Sekretaris', 'description' => 'Mengurus administrasi aset dan surat pengadaan'],
                ['name' => 'Citra Lestari', 'position' => 'Bendahara', 'description' => 'Mengelola anggaran pengadaan dan pemeliharaan aset'],
                ['name' => 'Eka Prasetyo', 'position' => 'Staf Inventaris', 'description' => 'Mencatat, melabeli, dan memonitor kondisi aset'],
                ['name' => 'Wahyu Hidayat', 'position' => 'Staf Pemeliharaan', 'description' => 'Melakukan pemeliharaan rutin fasilitas dan perlengkapan'],
                ['name' => 'Intan Permata', 'position' => 'Staf Pengadaan', 'description' => 'Mengurus proses pengadaan barang dan jasa DPM'],
            ],
            'Pimpinan Dewan' => [
                ['name' => 'Ketua Dewan', 'position' => 'Ketua DPM', 'description' => 'Memimpin dewan dan mewakili DPM dalam forum eksternal'],
                ['name' => 'Wakil Ketua Dewan', 'position' => 'Wakil Ketua DPM', 'description' => 'Membantu ketua dewan dan mengkoordinasikan alat kelengkapan'],
                ['name' => 'Sekretaris Dewan', 'position' => 'Sekretaris DPM', 'description' => 'Mengelola administrasi dewan dan pencatatan keputusan'],
                ['name' => 'Bendahara Dewan', 'position' => 'Bendahara DPM', 'description' => 'Mengelola keuangan dewan dan pertanggungjawaban dana'],
                ['name' => 'Anggota Pimpinan 1', 'position' => 'Anggota Pimpinan', 'description' => 'Membantu pelaksanaan fungsi pimpinan dewan'],
                ['name' => 'Anggota Pimpinan 2', 'position' => 'Anggota Pimpinan', 'description' => 'Membantu pelaksanaan fungsi pimpinan dewan'],
                ['name' => 'Anggota Pimpinan 3', 'position' => 'Anggota Pimpinan', 'description' => 'Membantu pelaksanaan fungsi pimpinan dewan'],
            ],
        ];

        return $officials[$name] ?? [
            ['name' => 'Ketua '.$name, 'position' => 'Ketua', 'description' => 'Ketua '.$name],
            ['name' => 'Wakil '.$name, 'position' => 'Wakil Ketua', 'description' => 'Wakil Ketua '.$name],
            ['name' => 'Sekretaris '.$name, 'position' => 'Sekretaris', 'description' => 'Sekretaris '.$name],
            ['name' => 'Bendahara '.$name, 'position' => 'Bendahara', 'description' => 'Bendahara '.$name],
            ['name' => 'Anggota '.$name, 'position' => 'Anggota', 'description' => 'Anggota '.$name],
        ];
    }

    private function savePhotoFromUrl(string $name, string $filename): ?string
    {
        try {
            // Use ui-avatars.com for generated avatars
            $url = 'https://ui-avatars.com/api/?name='.urlencode($name).'&size=400&background=001E43&color=fff&bold=true&format=png';
            $contents = file_get_contents($url);
            if ($contents === false) {
                return null;
            }

            $path = 'uploads/fungsionaris/'.Str::slug($filename).'.png';
            $fullPath = storage_path('app/public/'.$path);

            // Ensure directory exists
            if (! file_exists(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0755, true);
            }

            file_put_contents($fullPath, $contents);

            return $path;
        } catch (\Exception $e) {
            $this->command->warn("Failed to download photo for {$name}: ".$e->getMessage());

            return null;
        }
    }
}
