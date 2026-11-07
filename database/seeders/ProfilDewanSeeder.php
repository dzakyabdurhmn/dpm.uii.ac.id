<?php

namespace Database\Seeders;

use App\Models\ProfilDewan;
use Illuminate\Database\Seeder;

class ProfilDewanSeeder extends Seeder
{
    public function run(): void
    {
        // Sample data for 2025/2026 period - Ketua Dewan
        ProfilDewan::create([
            'nama_lengkap' => 'Rizky Ananda',
            'nim' => '202024001',
            'fakultas' => 'Fakultas Hukum',
            'program_studi' => 'Ilmu Hukum',
            'angkatan' => '2020',
            'email_kampus' => 'rizy@uii.ac.id',
            'jabatan' => 'Ketua Komisi I',
            'unit_kerja' => 'Dewan Permusyawaratan Mahasiswa',
            'periode' => '2025/2026',
            'masa_jabatan' => '1 Juni 2025 - 31 Mei 2027',
            'status' => 'Aktif',
            'bio' => 'Mahasiswa aktif Fakultas Hukum UII, terpilih sebagai Ketua Komisi I DPM UII periode 2025/2026.',
            'tugas_tanggung_jawab' => 'Memimpin dan mengoordinasikan kerja Komisi I, melakukan Laporan Kinerja pada Sidang Pleno DPM UII, berkoordinasi dengan alat kelengkapan dewan dan pimpinan.',
            'instagram' => 'https://instagram.com/rizy.ananda',
            'email' => 'rizy@uii.ac.id',
        ]);

        // Sample data for 2025/2026 period - Sekretaris Jendral
        ProfilDewan::create([
            'nama_lengkap' => 'Aulia Rahmawati',
            'nim' => '202024002',
            'fakultas' => 'Fakultas Hukum',
            'program_studi' => 'Ilmu Hukum',
            'angkatan' => '2023',
            'email_kampus' => 'aulia@uii.ac.id',
            'jabatan' => 'Sekretaris Jendral',
            'unit_kerja' => 'Dewan Permusyawaratan Mahasiswa',
            'periode' => '2025/2026',
            'masa_jabatan' => '1 Juni 2025 - 31 Mei 2027',
            'status' => 'Aktif',
            'bio' => 'Mahasiswa aktif Fakultas Hukum UII, menjabat sebagai Sekretaris Jendral DPM UII periode 2025/2026.',
            'tugas_tanggung_jawab' => 'Menyusun rapat dan meeting, mencatat keputusan plenog, melakukan pengarsipan dokumen resmi DPM UII.',
            'instagram' => 'https://instagram.com/aulia.rahmawati',
            'email' => 'aulia@uii.ac.id',
        ]);

        // Sample data for 2025/2026 period - Komisi I Anggota
        ProfilDewan::create([
            'nama_lengkap' => 'Farhan Hidayat',
            'nim' => '202024003',
            'fakultas' => 'Fakultas Ilmu Agama Islam',
            'program_studi' => 'Hukum Ekonomi Syariah',
            'angkatan' => '2024',
            'email_kampus' => 'farhan@uii.ac.id',
            'jabatan' => 'Anggota Komisi I',
            'unit_kerja' => 'Dewan Permusyawaratan Mahasiswa',
            'periode' => '2025/2026',
            'masa_jabatan' => '1 Juni 2025 - 31 Mei 2027',
            'status' => 'Aktif',
            'bio' => 'Mahasiswa aktif Fakultas Ilmu Agama Islam UII, menjadi anggota Komisi I DPM UII periode 2025/2026.',
            'tugas_tanggung_jawab' => 'Membantu koordinasi kerja Komisi I, melakukan penelitian dan studi kasus sesuai bidang tugas.',
            'instagram' => 'https://instagram.com/farhan.hidayat',
            'email' => 'farhan@uii.ac.id',
        ]);

        // Sample data for 2024/2025 period - Ketua Umum
        ProfilDewan::create([
            'nama_lengkap' => 'Fikri Maulana',
            'nim' => '202023001',
            'fakultas' => '',
            'program_studi' => '',
            'angkatan' => '',
            'email_kampus' => 'fikri@uii.ac.id',
            'jabatan' => 'Ketua Umum',
            'unit_kerja' => 'Dewan Permusyawaratan Mahasiswa',
            'periode' => '2024/2025',
            'masa_jabatan' => '1 Juni 2024 - 31 Mei 2026',
            'status' => 'Selesai',
            'bio' => 'Mengelola seluruh kegiatan DPM UII periode 2024/2025.',
            'tugas_tanggung_jawab' => 'Mendorong berjalannya program-program DPM UII, melakukan koordinasi dengan seluruh unit kerja dan alat kelengkapan.',
            'instagram' => 'https://instagram.com/fikri.maulana',
            'email' => 'fikri@uii.ac.id',
        ]);

        // Sample data for 2024/2025 period - Sekretaris Jendral
        ProfilDewan::create([
            'nama_lengkap' => 'Intan Permata',
            'nim' => '202023002',
            'fakultas' => '',
            'program_studi' => '',
            'angkatan' => '',
            'email_kampus' => 'intan@uii.ac.id',
            'jabatan' => 'Sekretaris Jendral',
            'unit_kerja' => 'Dewan Permusyawaratan Mahasiswa',
            'periode' => '2024/2025',
            'masa_jabatan' => '1 Juni 2024 - 31 Mei 2026',
            'status' => 'Selesai',
            'bio' => 'Mengatur administrasi dan sekretariat DPM UII periode 2024/2025.',
            'tugas_tanggung_jawab' => 'Menyusun berita acara, mengurus surat menyurat DPM UII, serta menyelenggarakan rapat plenipoten.',
            'instagram' => 'https://instagram.com/intan.permata',
            'email' => 'intan@uii.ac.id',
        ]);

        // Sample data for 2024/2025 period - Komisi II Ketua
        ProfilDewan::create([
            'nama_lengkap' => 'Raka Wirawan',
            'nim' => '202023003',
            'fakultas' => 'Fakultas Teknologi Industri',
            'program_studi' => 'Teknik Industri',
            'angkatan' => '2023',
            'email_kampus' => 'raka@uii.ac.id',
            'jabatan' => 'Ketua Komisi II',
            'unit_kerja' => 'Dewan Permusyawaratan Mahasiswa',
            'periode' => '2024/2025',
            'masa_jabatan' => '1 Juni 2024 - 31 Mei 2026',
            'status' => 'Selesai',
            'bio' => 'MimpinKomisi II untuk memperbaiki tata tertib dan kerangka kerja komisi.',
            'tugas_tanggung_jawab' => 'Mengarahkan anggota Komisi II, melakukan evaluasi kerja rutin, serta melaporkan hasil komisi pada sidang plenog.',
            'instagram' => 'https://instagram.com/raka.wirawan',
            'email' => 'raka@uii.ac.id',
        ]);

        $this->command->info('Sample ProfilDewan data created successfully.');
    }
}
