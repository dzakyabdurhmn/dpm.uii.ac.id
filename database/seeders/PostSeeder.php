<?php

namespace Database\Seeders;

use App\Models\Period;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $period = Period::where('is_active', true)->first();

        $posts = [
            // Pengumuman
            [
                'title' => 'DPM UII Gelar Sidang Paripurna Ke-1 Periode 2025/2026',
                'slug' => 'dpm-uii-gelar-sidang-paripurna-ke-1-periode-2025-2026',
                'excerpt' => 'Dewan Permusyawaratan Mahasiswa UII menyelenggarakan Sidang Paripurna pertama periode 2025/2026 untuk membahas program kerja dan anggaran tahunan.',
                'body' => '<p>Pada hari Senin, 15 September 2025, DPM UII menggelar Sidang Paripurna pertama periode 2025/2026 di Ruang Sidang DPM UII. Sidang dibuka oleh Ketua DPM UII dan dihadiri seluruh anggota dewan.</p><p>Agenda utama sidang meliputi pembahasan program kerja tahunan, anggaran pendapatan dan belanja (APB), serta penetapan struktur pengurus alat kelengkapan dewan.</p><p>"Sidang ini menjadi momen penting untuk menyepakati arah kebijakan dewan selama satu periode ke depan," ujar Ketua DPM UII.</p>',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'PKM UII No. 3 Tahun 2024 Resmi Berlaku: Tentang Distribusi Dana KM UII',
                'slug' => 'pkm-uis-no-3-tahun-2024-resmi-berlaku-tentang-distribusi-dana-km-uis',
                'excerpt' => 'Peraturan Keluarga Mahasiswa Nomor 3 Tahun 2024 mengenai pengelolaan dan distribusi dana KM UII telah disahkan dan berlaku efektif.',
                'body' => '<p>PKM UII Nomor 3 Tahun 2024 tentang Distribusi dan Alokasi Dana KM UII telah disahkan oleh Pimpinan DPM UII pada tanggal 10 Agustus 2024.</p><p>Peraturan ini mengatur mekanisme transparan dalam pengelolaan dana Kemahasiswaan, termasuk alokasi untuk Lembaga Eksekutif, Alat Kelengkapan Dewan, dan Lembaga Khusus.</p>',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Audit Keuangan Lembaga KM UII Triwulan II 2024',
                'slug' => 'audit-keuangan-lembaga-km-uis-triwulan-ii-2024',
                'excerpt' => 'Badan Audit Kemahasiswaan (BAK) menyelesaikan audit keuangan lembaga-lembaga KM UII untuk triwulan II tahun 2024.',
                'body' => '<p>Hasil audit menunjukkan bahwa mayoritas lembaga telah mengelola dana sesuai peraturan. Beberapa temuan perbaikan telah disampaikan ke masing-masing lembaga.</p>',
                'published_at' => now()->subDays(30),
            ],
            [
                'title' => 'Pengumuman Penerima Beasiswa Prestasi KM UII 2024',
                'slug' => 'pengumuman-penerima-beasiswa-prestasi-km-uis-2024',
                'excerpt' => 'DPM UII melalui BPA mengumumkan daftar penerima beasiswa prestasi bagi mahasiswa berprestasi akademik dan non-akademik.',
                'body' => '<p>Sebanyak 25 mahasiswa menerima beasiswa prestasi tahun 2024. Seleksi dilakukan berdasarkan IPK, prestasi lomba, dan aktifitas organisasi.</p>',
                'published_at' => now()->subDays(60),
            ],

            // Berita Kegiatan
            [
                'title' => 'Rapat Koordinasi Alat Kelengkapan Dewan Periode 2025/2026',
                'slug' => 'rapat-koordinasi-alat-kelengkapan-dewan-periode-2025-2026',
                'excerpt' => 'Ketua DPM UII memimpin rapat koordinasi seluruh alat kelengkapan dewan untuk menyelaraskan program kerja periode 2025/2026.',
                'body' => '<p>Rapat koordinasi dihadiri oleh ketua-ketua Baleg, Bawas, BAK, BPA, Bksaj, dan Mentari. Setiap alat kelengkapan menyampaikan rencana program kerja masing-masing.</p>',
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Forum Aspirasi Mahasiswa Tingkat Fakultas - Gelombang I',
                'slug' => 'forum-aspirasi-mahasiswa-tingkat-fakultas-gelombang-i',
                'excerpt' => 'DPM UII melalui BKSAJ menggelar Forum Aspirasi Mahasiswa tingkat fakultas untuk menampung keluhan dan usulan mahasiswa.',
                'body' => '<p>Forum Aspirasi diadakan secara hybrid (online dan offline) di 8 fakultas di UII. Mahasiswa dapat menyampaikan aspirasi langsung ke wakil DPM Fakultas masing-masing.</p><p>Hasil forum akan dijadikan bahan pertimbangan dalam penyusunan program advokasi DPM UII.</p>',
                'published_at' => now()->subDays(15),
            ],
            [
                'title' => 'Pelatihan Legislasi untuk Anggota DPM UII Baru',
                'slug' => 'pelatihan-legislasi-untuk-anggota-dpm-uis-baru',
                'excerpt' => 'Badan Legislasi (Baleg) mengadakan pelatihan dasar legislasi bagi anggota DPM UII periode 2025/2026.',
                'body' => '<p>Pelatihan berlangsung selama 2 hari dan mencakup materi: tata cara sidang, teknis drafting peraturan, dan kajian hukum dasar.</p><p>"Kami ingin memastikan seluruh anggota memahami proses legislasi dengan baik," kata Ketua Baleg.</p>',
                'published_at' => now()->subDays(20),
            ],
            [
                'title' => 'Pembukaan Lomba Karya Tulis Ilmiah (LKTI) KM UII 2025',
                'slug' => 'pembukaan-lomba-karya-tulis-ilmiah-lkti-km-uis-2025',
                'excerpt' => 'Mentari DPM UII membuka pendaftaran Lomba Karya Tulis Ilmiah tingkat KM UII tahun 2025.',
                'body' => '<p>Lomba ini terbuka untuk seluruh mahasiswa UII dengan tema "Inovasi Mahasiswa untuk Kampus Berkelanjutan". Hadiah total mencapai 20 juta rupiah.</p><p>Pendaftaran dibuka hingga 31 Oktober 2025 melalui website resmi DPM UII.</p>',
                'published_at' => now()->subDays(40),
            ],
            [
                'title' => 'Kunjungan Kerja DPM UII ke DPM Se-Jawa Tengah',
                'slug' => 'kunjungan-kerja-dpm-uis-ke-dpm-se-jawa-tengah',
                'excerpt' => 'Delegasi DPM UII melakukan kunjungan kerja ke DPM Universitas lain di Jawa Tengah untuk silaturahmi dan sharing pengalaman.',
                'body' => '<p>Kunjungan dilakukan ke 4 universitas: UNDIP, UNNES, UNS, dan UGM. Bahasan meliputi penguatan legislasi mahasiswa, advokasi kebijakan, dan kerjasama antar DPM.</p>',
                'published_at' => now()->subDays(50),
            ],

            // Sosialisasi - Peraturan
            [
                'title' => 'Sosialisasi PKM UII No. 3 Tahun 2024: Distribusi Dana KM UII',
                'slug' => 'sosialisasi-pkm-uis-no-3-tahun-2024-distribusi-dana-km-uis',
                'excerpt' => 'Badan Legislasi menggelar sosialisasi PKM Nomor 3 Tahun 2024 mengenai pengelolaan dan distribusi dana KM UII kepada seluruh lembaga.',
                'body' => '<p>Sosialisasi diadakan secara hybrid di Ruang Sidang DPM UII dan via Zoom. Peserta meliputi bendahara dan ketua keuangan seluruh lembaga KM UII.</p><p>Materi meliputi: alur pengajuan dana, mekanisme pencairan, pertanggungjawaban (LPJ), dan sanksi pelanggaran.</p>',
                'type' => 'peraturan',
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Sosialisasi Perubahan PKM Pedoman Administrasi KM UII',
                'slug' => 'sosialisasi-perubahan-pkm-pedoman-administrasi-km-uis',
                'excerpt' => 'Baleg mengadakan sosialisasi perubahan PKM tentang pedoman administrasi bagi seluruh pengurus alat kelengkapan dewan.',
                'body' => '<p>Sosialisasi difokuskan pada pasal-pasal yang berubah terkait tata kelola administrasi dewan dan alat kelengkapan.</p>',
                'type' => 'peraturan',
                'published_at' => now()->subDays(12),
            ],

            // Sosialisasi - Kebijakan
            [
                'title' => 'Sosialisasi Kebijakan Baru: Advokasi Keringanan UKT Mahasiswa',
                'slug' => 'sosialisasi-kebijakan-baru-adovkasi-keringanan-ukt-mahasiswa',
                'excerpt' => 'BKSAJ menggelar sosialisasi kebijakan advokasi keringanan UKT bagi mahasiswa terdampak ekonomi.',
                'body' => '<p>Kebijakan ini merupakan hasil advokasi DPM UII kepada Rektorat UII. Sosialisasi menjelaskan syarat, prosedur pengajuan, dan jadwal verifikasi.</p>',
                'type' => 'kebijakan',
                'published_at' => now()->subDays(8),
            ],

            // Sosialisasi - Program
            [
                'title' => 'Sosialisasi Program Magang Mahasiswa DPM UII Batch 2',
                'slug' => 'sosialisasi-program-magang-mahasiswa-dpm-uis-batch-2',
                'excerpt' => 'Mentari membuka pendaftaran program magang di sekretariat DPM UII untuk mahasiswa tingkat 1-3.',
                'body' => '<p>Program magang bertujuan memberikan pengalaman kerja nyata di lingkungan parlemen mahasiswa. Durasi 3 bulan dengan sertifikat resmi.</p>',
                'type' => 'program',
                'published_at' => now()->subDays(18),
            ],
            [
                'title' => 'Sosialisasi Program Beasiswa Prestasi KM UII 2025',
                'slug' => 'sosialisasi-program-beasiswa-prestasi-km-uis-2025',
                'excerpt' => 'BPA menggelar sosialisasi program beasiswa prestasi tahun 2025 bagi mahasiswa berprestasi.',
                'body' => '<p>Sosialisasi menjelaskan kriteria seleksi, jenis beasiswa, nilai hadiah, dan tata cara pendaftaran melalui sistem online.</p>',
                'type' => 'program',
                'published_at' => now()->subDays(25),
            ],

            // Sosialisasi - Lainnya
            [
                'title' => 'Sosialisasi Kegiatan Konsolidasi Aksi Mahasiswa UII',
                'slug' => 'sosialisasi-kegiatan-konsolidasi-aksi-mahasiswa-uis',
                'excerpt' => 'DPM UII menggelar sosialisasi terkait konsolidasi aksi mahasiswa menyambut HARDIKNAS.',
                'body' => '<p>Sosialisasi dibuka untuk seluruh ormawa dan mahasiswa UII. Membahas rundown acara, aturan partisipasi, dan koordinasi keamanan.</p>',
                'type' => 'lainnya',
                'published_at' => now()->subDays(6),
            ],
        ];

        foreach ($posts as $postData) {
            Post::updateOrCreate(
                ['slug' => $postData['slug']],
                $postData + ['status' => Post::STATUS_PUBLISHED]
            );
        }

        $this->command->info('Posts seeded: '.Post::count().' records');
    }
}
