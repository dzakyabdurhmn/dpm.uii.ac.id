<?php

namespace Database\Seeders;

use App\Models\Complaint;
use App\Models\DocumentCategory;
use App\Models\OrganizationalUnit;
use App\Models\Period;
use App\Models\PimpinanDewan;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedAdmin();
        $this->seedSettings();
        $this->seedPeriod();
        $this->seedDocumentCategories();
        $this->seedUnits();
        $this->seedPimpinanDewan();
        $this->seedComplaints();
        $this->call(LegalProductSeeder::class);
        $this->call(DocumentSeeder::class);
        $this->call(PostSeeder::class);
    }

    /**
     * Exactly one account exists: the administrator. There is no registration route.
     */
    private function seedAdmin(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'admin@dpm.uii.ac.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin12345'),
                'email_verified_at' => now(),
            ],
        );
    }

    private function seedSettings(): void
    {
        $settings = [
            'site_name' => 'DPM UII',
            'site_tagline' => 'Dewan Permusyawaratan Mahasiswa UII',
            'site_logo' => null,
            'hero_title' => 'Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia',
            'hero_subtitle' => 'Lembaga legislatif tertinggi dalam sistem student government KM UII: menyusun produk hukum, mengawasi jalannya pemerintahan mahasiswa, dan menyalurkan aspirasi mahasiswa.',
            'hero_image' => null,
            'about_text' => 'Keluarga Mahasiswa Universitas Islam Indonesia (KM UII) berdiri pada 21 September 1950 dengan ciri khas “student government”: pemerintahan dari, oleh, dan untuk mahasiswa. DPM UII menjalankan fungsi legislasi, pengawasan, dan penganggaran dalam sistem tersebut.',
            'contact_email' => 'dpm@uii.ac.id',
            'contact_phone' => '0815 1109 2004',
            'contact_address' => 'Kampus Terpadu UII, Jl. Kaliurang KM 14.5, Sleman, Yogyakarta',
            'footer_text' => 'Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia.',
            'social_instagram' => 'https://www.instagram.com/dpmuii/',
            'social_linkedin' => 'https://www.linkedin.com/company/dewan-permusyawaratan-mahasiswa/',
            'social_twitter' => 'https://twitter.com/DPM_UII',
            'social_facebook' => null,
            'social_youtube' => null,
            'meta_description' => 'Portal resmi DPM UII — produk hukum, surat keputusan, laporan keuangan triwulan, laporan kinerja, dan berita terbaru.',
        ];

        foreach ($settings as $key => $value) {
            Setting::put($key, $value);
        }
    }

    /**
     * Periode kepengurusan: arsip tahun-tahun sebelumnya tetap tersimpan.
     * Periode berikutnya cukup ditambahkan lewat admin (menu Periode).
     */
    private function seedPeriod(): void
    {
        $periods = [
            ['name' => '2023/2024', 'starts_on' => '2023-09-01', 'ends_on' => '2024-08-31', 'is_active' => false],
            ['name' => '2024/2025', 'starts_on' => '2024-09-01', 'ends_on' => '2025-08-31', 'is_active' => false],
            ['name' => '2025/2026', 'starts_on' => '2025-09-01', 'ends_on' => '2026-08-31', 'is_active' => true],
        ];

        foreach ($periods as $period) {
            Period::query()->updateOrCreate(['name' => $period['name']], $period);
        }
    }

    private function seedDocumentCategories(): void
    {
        $categories = [
            ['name' => 'Produk Hukum', 'group' => 'Produk Hukum', 'description' => 'PDKM, GBHKM, PKM, dan PDPM sebagai dasar penyelenggaraan KM UII.', 'sort_order' => 1],
            ['name' => 'Surat Keputusan', 'group' => 'Keputusan', 'description' => 'Surat keputusan yang dikeluarkan DPM UII: badan, tim kelengkapan dewan, lembaga, dan penyelenggara pemilu.', 'sort_order' => 2],
            ['name' => 'Laporan Kinerja', 'group' => 'Laporan', 'description' => 'Hasil Forum Aspirasi dan Laporan Akhir Kinerja (Foraslak) DPM UII per periode.', 'sort_order' => 3],
            ['name' => 'Distribusi Dana', 'group' => 'Dana', 'description' => 'Rincian distribusi dan alokasi dana KM UII per lembaga.', 'sort_order' => 4],
            ['name' => 'LPJ', 'group' => 'Dana', 'description' => 'Laporan pertanggungjawaban penggunaan dana kegiatan KM UII.', 'sort_order' => 5],
            ['name' => 'LHA', 'group' => 'Dana', 'description' => 'Laporan hasil audit pengelolaan keuangan dan aset kemahasiswaan.', 'sort_order' => 6],
            ['name' => 'Laporan Keuangan', 'group' => 'Dana', 'description' => 'Laporan keuangan triwulan dan laporan penggunaan dana kegiatan.', 'sort_order' => 7],
        ];

        foreach ($categories as $category) {
            DocumentCategory::query()->firstOrCreate(
                ['slug' => str($category['name'])->slug()->value()],
                $category,
            );
        }
    }

    private function seedUnits(): void
    {
        // Hanya kerangka alat kelengkapan yang disiapkan. Penjelasan tiap unit
        // sengaja dikosongkan: diisi sendiri lewat admin (menu Alat Kelengkapan).
        $units = [
            ['type' => 'pimpinan', 'name' => 'Pimpinan Dewan', 'abbreviation' => null, 'sort_order' => 1],
            ['type' => 'lembaga', 'name' => 'Mentari', 'abbreviation' => 'Mentari', 'sort_order' => 2],
            ['type' => 'badan', 'name' => 'Badan Legislasi', 'abbreviation' => 'Baleg', 'sort_order' => 3],
            ['type' => 'badan', 'name' => 'Badan Pengawasan', 'abbreviation' => 'Bawas', 'sort_order' => 4],
            ['type' => 'badan', 'name' => 'Badan Kerjasama, Advokasi, dan Jaringan', 'abbreviation' => 'Bksaj', 'sort_order' => 5],
            ['type' => 'badan', 'name' => 'Badan Audit Kemahasiswaan', 'abbreviation' => 'BAK', 'sort_order' => 6],
            ['type' => 'badan', 'name' => 'Badan Pengelola Aset', 'abbreviation' => 'BPA', 'sort_order' => 7],
            // Komisi Dewan
            ['type' => 'komisi', 'name' => 'Komisi I', 'abbreviation' => 'I', 'description' => 'Bidang Hukum, Peraturan, dan Ketertiban Dewan', 'sort_order' => 10],
            ['type' => 'komisi', 'name' => 'Komisi II', 'abbreviation' => 'II', 'description' => 'Bidang Anggaran, Keuangan, dan Aset Dewan', 'sort_order' => 11],
            ['type' => 'komisi', 'name' => 'Komisi III', 'abbreviation' => 'III', 'description' => 'Bidang Aspirasi, Kemitraan, dan Jaringan Dewan', 'sort_order' => 12],
            ['type' => 'komisi', 'name' => 'Komisi IV', 'abbreviation' => 'IV', 'description' => 'Bidang SDM, Organisasi, dan Protokol Dewan', 'sort_order' => 13],
        ];

        foreach ($units as $unit) {
            OrganizationalUnit::query()->updateOrCreate(
                ['slug' => str($unit['name'])->slug()->value()],
                $unit + ['is_active' => true],
            );
        }

        // Unit contoh dari struktur sebelumnya diganti oleh alat kelengkapan di atas.
        OrganizationalUnit::query()
            ->whereIn('slug', ['direktorat-sekretaris-jenderal', 'badan-kerjasama-jaringan-dan-advokasi'])
            ->doesntHave('officials')
            ->delete();
    }

    private function seedPimpinanDewan(): void
    {
        $periode = Period::where('is_active', true)->first();

        if (! $periode) {
            return;
        }

        $pimpinan = [
            ['jabatan' => 'Ketua', 'nama' => 'Ketua DPM UII', 'fakultas' => 'Fakultas Hukum', 'nim' => '21000001', 'sort_order' => 1],
            ['jabatan' => 'Sekretaris Jenderal', 'nama' => 'Sekretaris Jenderal DPM UII', 'fakultas' => 'Fakultas Ilmu Komunikasi', 'nim' => '21000002', 'sort_order' => 2],
            ['jabatan' => 'Komisi 1', 'nama' => 'Ketua Komisi I', 'fakultas' => 'Fakultas Hukum', 'nim' => '21000003', 'sort_order' => 3],
            ['jabatan' => 'Komisi 2', 'nama' => 'Ketua Komisi II', 'fakultas' => 'Fakultas Ekonomi', 'nim' => '21000004', 'sort_order' => 4],
            ['jabatan' => 'Komisi 3', 'nama' => 'Ketua Komisi III', 'fakultas' => 'Fakultas Ilmu Sosial dan Politik', 'nim' => '21000005', 'sort_order' => 5],
            ['jabatan' => 'Komisi 4', 'nama' => 'Ketua Komisi IV', 'fakultas' => 'Fakultas Teknik', 'nim' => '21000006', 'sort_order' => 6],
            ['jabatan' => 'Anggota Komisi 1', 'nama' => 'Anggota Komisi I', 'fakultas' => 'Fakultas Hukum', 'nim' => '21000007', 'sort_order' => 7],
            ['jabatan' => 'Anggota Komisi 2', 'nama' => 'Anggota Komisi II', 'fakultas' => 'Fakultas Ekonomi', 'nim' => '21000008', 'sort_order' => 8],
            ['jabatan' => 'Anggota Komisi 3', 'nama' => 'Anggota Komisi III', 'fakultas' => 'Fakultas Ilmu Sosial dan Politik', 'nim' => '21000009', 'sort_order' => 9],
            ['jabatan' => 'Anggota Komisi 4', 'nama' => 'Anggota Komisi IV', 'fakultas' => 'Fakultas Teknik', 'nim' => '21000010', 'sort_order' => 10],
        ];

        foreach ($pimpinan as $p) {
            PimpinanDewan::updateOrCreate(
                ['periode_id' => $periode->id, 'jabatan' => $p['jabatan']],
                array_merge($p, ['periode_id' => $periode->id, 'is_active' => true])
            );
        }
    }

    private function seedComplaints(): void
    {
        $complaints = [
            [
                'ticket_number' => 'DPM-261029-7A8B',
                'name' => 'Fathurrahman Al-Ghifari',
                'student_id' => '21522045',
                'faculty' => 'Fakultas Teknologi Industri',
                'email' => '21522045@students.uii.ac.id',
                'phone' => '081234567890',
                'category' => 'Fasilitas & Sarana Prasarana',
                'subject' => 'Permohonan Penambahan Stopkontak dan Penguatan Wifi Gedung FTI',
                'message' => 'Mohon kepada DPM UII untuk mengadvokasikan penambahan fasilitas stopkontak di selasar lantai 2 dan 3 Gedung Mas Mansyur FTI serta optimalisasi jaringan wifi edukasi yang sering mengalami lonjakan trafik pada jam kuliah sibuk.',
                'status' => 'baru',
                'is_anonymous' => false,
                'created_at' => now()->subHours(2),
            ],
            [
                'ticket_number' => 'DPM-261029-3K9L',
                'name' => null,
                'student_id' => '22311099',
                'faculty' => 'Fakultas Bisnis dan Ekonomika',
                'email' => 'mahasiswa.fbe@students.uii.ac.id',
                'phone' => null,
                'category' => 'Finansial & UKT',
                'subject' => 'Transparansi Mekanisme Pengajuan Keringanan UKT Semester Genap',
                'message' => 'Kami mengharapkan adanya kejelasan batas waktu verifikasi berkas dan indikator penilaian bagi rekan-rekan mahasiswa yang mengajukan permohonan banding/keringanan pembayaran UKT.',
                'status' => 'baru',
                'is_anonymous' => true,
                'created_at' => now()->subHours(5),
            ],
            [
                'ticket_number' => 'DPM-261028-9F2M',
                'name' => 'Nabila Zahra Syahrani',
                'student_id' => '23411012',
                'faculty' => 'Fakultas Hukum',
                'email' => 'nabila.zahra@students.uii.ac.id',
                'phone' => '085712349988',
                'category' => 'Advokasi & Kebijakan Kampus',
                'subject' => 'Advokasi Perpanjangan Jam Operasional Perpustakaan Pusat UII',
                'message' => 'Sehubungan dengan meningkatnya kebutuhan ruang belajar yang representatif dan kondusif bagi mahasiswa menjelang periode ujian, kami mengusulkan advokasi perpanjangan jam operasional Perpustakaan Pusat hingga pukul 21.00 WIB.',
                'status' => 'diproses',
                'is_anonymous' => false,
                'created_at' => now()->subDay(),
            ],
            [
                'ticket_number' => 'DPM-261025-1C4E',
                'name' => 'Muhammad Ilham Pratama',
                'student_id' => '20320078',
                'faculty' => 'Fakultas Ilmu Agama Islam',
                'email' => 'ilham.pratama@students.uii.ac.id',
                'phone' => '087811223344',
                'category' => 'Konstitusi KM UII',
                'subject' => 'Klarifikasi Tahapan Sosialisasi Perubahan PKM Pemilwa KM UII',
                'message' => 'Bagaimanakah alur keterlibatan lembaga legislatif fakultas dalam pembahasan draf akhir revisi PKM tentang Pemilwa sebelum disahkan dalam Sidang Paripurna DPM UII?',
                'status' => 'selesai',
                'is_anonymous' => false,
                'response' => 'Terima kasih atas perhatian dan aspirasi Saudara. Komisi I (Legislasi) DPM UII telah menyelenggarakan agenda Uji Publik Draf PKM Pemilwa bersama delegasi DPM Fakultas se-UII. Risalah pembahasan dan matriks persandingan pasal dapat diakses terbuka pada portal ini.',
                'responded_at' => now()->subDays(2),
                'created_at' => now()->subDays(4),
            ],
            [
                'ticket_number' => 'DPM-261020-8H5Z',
                'name' => 'Rendi Kurniawan',
                'student_id' => '22511033',
                'faculty' => 'Fakultas Teknik Sipil dan Perencanaan',
                'email' => 'rendi.k@students.uii.ac.id',
                'phone' => '089988776655',
                'category' => 'Lainnya',
                'subject' => 'Pengajuan Proposal Sponsor Produk Minuman Luar Kampus',
                'message' => 'Pengajuan proposal kerjasama sponsorship komersial untuk kegiatan perlombaan eksternal.',
                'status' => 'ditolak',
                'is_anonymous' => false,
                'response' => 'Kanal Layanan Aspirasi DPM UII dikhususkan untuk penyerapan aspirasi, advokasi kebijakan kemahasiswaan, dan pengawalan hak-hak mahasiswa KM UII. Untuk pengajuan sponsorship dan kerjasama komersial, silakan berkoordinasi langsung dengan Direktorat Kemitraan Kampus.',
                'responded_at' => now()->subDays(7),
                'created_at' => now()->subDays(9),
            ],
        ];

        foreach ($complaints as $complaintData) {
            Complaint::query()->firstOrCreate(
                ['ticket_number' => $complaintData['ticket_number']],
                $complaintData,
            );
        }
    }

    private function seedBioLink(): void
    {
        $bioLink = BioLink::query()->updateOrCreate(
            ['is_active' => true],
            [
                'site_name' => 'DPM UII',
                'tagline' => 'Dewan Permusyawaratan Mahasiswa UII',
                'handle' => '@dpmuii',
                'description' => 'Portal resmi DPM UII — produk hukum, surat keputusan, laporan, dan aspirasi mahasiswa.',
                'theme_color' => '#001E43',
                'social_links' => [
                    ['label' => 'Instagram', 'icon' => 'fa-brands fa-instagram', 'url' => 'https://www.instagram.com/dpmuii/'],
                    ['label' => 'LinkedIn', 'icon' => 'fa-brands fa-linkedin-in', 'url' => 'https://www.linkedin.com/company/dewan-permusyawaratan-mahasiswa/'],
                ],
                'address' => 'Kampus Terpadu UII, Jl. Kaliurang KM 14.5, Sleman, Yogyakarta',
                'email' => 'dpm@uii.ac.id',
                'phone' => '0815 1109 2004',
            ],
        );

        $group = BioLinkGroup::query()->updateOrCreate(
            ['bio_link_id' => $bioLink->id, 'slug' => 'tautan-utama'],
            ['title' => 'Tautan Utama', 'sort_order' => 1, 'is_active' => true],
        );

        foreach ([
            ['title' => 'Produk Hukum', 'url' => '/produk-hukum', 'icon' => 'book-open', 'sort_order' => 1],
            ['title' => 'Surat Keputusan', 'url' => '/keputusan', 'icon' => 'document-text', 'sort_order' => 2],
            ['title' => 'Aspirasi', 'url' => '/aspirasi', 'icon' => 'chat-bubble-left-right', 'sort_order' => 3],
        ] as $item) {
            BioLinkItem::query()->updateOrCreate(
                ['bio_link_group_id' => $group->id, 'title' => $item['title']],
                $item + ['icon_type' => 'heroicons', 'is_active' => true, 'open_in_new_tab' => false],
            );
        }

        BioLinkFeature::query()->updateOrCreate(
            ['bio_link_id' => $bioLink->id, 'title' => 'Informasi Terbaru'],
            [
                'eyebrow' => 'Sorotan',
                'description' => 'Ikuti perkembangan terbaru DPM UII melalui portal resmi.',
                'button_text' => 'Kunjungi Portal',
                'button_url' => '/',
                'icon' => 'sparkles',
                'is_active' => true,
            ],
        );
    }
}
