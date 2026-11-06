<?php

namespace Database\Seeders;

use App\Models\Official;
use App\Models\OrganizationalUnit;
use App\Models\Period;
use Illuminate\Database\Seeder;

class ProfilDewanSeeder extends Seeder
{
    public function run(): void
    {
        $periods = Period::all()->keyBy('name');

        $pimpinan = OrganizationalUnit::where('type', 'pimpinan')->first();
        $komisi = OrganizationalUnit::where('type', 'komisi')->orderBy('sort_order')->get();

        // Clear existing
        Official::truncate();

        // 2025/2026
        $p2025 = $periods['2025/2026'];

        // Pimpinan
        Official::create([
            'organizational_unit_id' => $pimpinan->id,
            'period_id' => $p2025->id,
            'name' => 'Troy Amirul Akhmad',
            'position' => 'Ketua Umum',
            'fakultas' => '',
            'prodi' => '',
            'angkatan' => '',
            'sort_order' => 1,
            'is_active' => true,
        ]);
        Official::create([
            'organizational_unit_id' => $pimpinan->id,
            'period_id' => $p2025->id,
            'name' => 'Aulia Rahmawati',
            'position' => 'Sekretaris Jenderal',
            'fakultas' => 'Fakultas Hukum',
            'prodi' => 'Ilmu Hukum',
            'angkatan' => '2023',
            'sort_order' => 2,
            'is_active' => true,
        ]);
        Official::create([
            'organizational_unit_id' => $pimpinan->id,
            'period_id' => $p2025->id,
            'name' => 'Bagas Pramudya',
            'position' => 'Bendahara Umum',
            'fakultas' => 'Fakultas Bisnis dan Ekonomika',
            'prodi' => 'Akuntansi',
            'angkatan' => '2023',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // Komisi I
        $k1 = $komisi->firstWhere('abbreviation', 'I');
        Official::create(['organizational_unit_id' => $k1->id, 'period_id' => $p2025->id, 'name' => 'Rizky Ananda', 'position' => 'Ketua Komisi I', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2023', 'sort_order' => 1, 'is_active' => true]);
        Official::create(['organizational_unit_id' => $k1->id, 'period_id' => $p2025->id, 'name' => 'Nadia Safitri', 'position' => 'Anggota', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2024', 'sort_order' => 2, 'is_active' => true]);
        Official::create(['organizational_unit_id' => $k1->id, 'period_id' => $p2025->id, 'name' => 'Farhan Hidayat', 'position' => 'Anggota', 'fakultas' => 'Fakultas Ilmu Agama Islam', 'prodi' => 'Hukum Ekonomi Syariah', 'angkatan' => '2024', 'sort_order' => 3, 'is_active' => true]);

        // Komisi II
        $k2 = $komisi->firstWhere('abbreviation', 'II');
        Official::create(['organizational_unit_id' => $k2->id, 'period_id' => $p2025->id, 'name' => 'Salsabila Putri', 'position' => 'Ketua Komisi II', 'fakultas' => 'Fakultas Psikologi dan Ilmu Sosial Budaya', 'prodi' => 'Ilmu Komunikasi', 'angkatan' => '2023', 'sort_order' => 1, 'is_active' => true]);
        Official::create(['organizational_unit_id' => $k2->id, 'period_id' => $p2025->id, 'name' => 'Muhammad Iqbal', 'position' => 'Anggota', 'fakultas' => 'Fakultas Teknologi Industri', 'prodi' => 'Informatika', 'angkatan' => '2024', 'sort_order' => 2, 'is_active' => true]);
        Official::create(['organizational_unit_id' => $k2->id, 'period_id' => $p2025->id, 'name' => 'Dewi Lestari', 'position' => 'Anggota', 'fakultas' => 'Fakultas Bisnis dan Ekonomika', 'prodi' => 'Manajemen', 'angkatan' => '2024', 'sort_order' => 3, 'is_active' => true]);

        // Komisi III
        $k3 = $komisi->firstWhere('abbreviation', 'III');
        Official::create(['organizational_unit_id' => $k3->id, 'period_id' => $p2025->id, 'name' => 'Ahmad Fauzan', 'position' => 'Ketua Komisi III', 'fakultas' => 'Fakultas Teknik Sipil dan Perencanaan', 'prodi' => 'Teknik Sipil', 'angkatan' => '2023', 'sort_order' => 1, 'is_active' => true]);
        Official::create(['organizational_unit_id' => $k3->id, 'period_id' => $p2025->id, 'name' => 'Kinanti Maharani', 'position' => 'Anggota', 'fakultas' => 'Fakultas Kedokteran', 'prodi' => 'Pendidikan Dokter', 'angkatan' => '2024', 'sort_order' => 2, 'is_active' => true]);
        Official::create(['organizational_unit_id' => $k3->id, 'period_id' => $p2025->id, 'name' => 'Yoga Prasetyo', 'position' => 'Anggota', 'fakultas' => 'Fakultas MIPA', 'prodi' => 'Statistika', 'angkatan' => '2024', 'sort_order' => 3, 'is_active' => true]);

        // Komisi IV
        $k4 = $komisi->firstWhere('abbreviation', 'IV');
        Official::create(['organizational_unit_id' => $k4->id, 'period_id' => $p2025->id, 'name' => 'Zahra Nabila', 'position' => 'Ketua Komisi IV', 'fakultas' => 'Fakultas Ilmu Agama Islam', 'prodi' => 'Ilmu Agama Islam', 'angkatan' => '2023', 'sort_order' => 1, 'is_active' => true]);
        Official::create(['organizational_unit_id' => $k4->id, 'period_id' => $p2025->id, 'name' => 'Daffa Alfarizi', 'position' => 'Anggota', 'fakultas' => 'Fakultas Teknologi Industri', 'prodi' => 'Teknik Industri', 'angkatan' => '2024', 'sort_order' => 2, 'is_active' => true]);
        Official::create(['organizational_unit_id' => $k4->id, 'period_id' => $p2025->id, 'name' => 'Nurul Hidayah', 'position' => 'Anggota', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2025', 'sort_order' => 3, 'is_active' => true]);

        // 2024/2025 - sample data
        $p2024 = $periods['2024/2025'];
        Official::create(['organizational_unit_id' => $pimpinan->id, 'period_id' => $p2024->id, 'name' => 'Fikri Maulana', 'position' => 'Ketua Umum', 'fakultas' => '', 'prodi' => '', 'angkatan' => '', 'sort_order' => 1, 'is_active' => true]);
        Official::create(['organizational_unit_id' => $pimpinan->id, 'period_id' => $p2024->id, 'name' => 'Intan Permata', 'position' => 'Sekretaris Jenderal', 'fakultas' => '', 'prodi' => '', 'angkatan' => '', 'sort_order' => 2, 'is_active' => true]);
        Official::create(['organizational_unit_id' => $pimpinan->id, 'period_id' => $p2024->id, 'name' => 'Raka Wirawan', 'position' => 'Bendahara Umum', 'fakultas' => '', 'prodi' => '', 'angkatan' => '', 'sort_order' => 3, 'is_active' => true]);
        $k1b = $komisi->firstWhere('abbreviation', 'I');
        Official::create(['organizational_unit_id' => $k1b->id, 'period_id' => $p2024->id, 'name' => 'Contoh Nama', 'position' => 'Ketua Komisi I', 'fakultas' => '', 'prodi' => '', 'angkatan' => '', 'sort_order' => 1, 'is_active' => true]);
        $k2b = $komisi->firstWhere('abbreviation', 'II');
        Official::create(['organizational_unit_id' => $k2b->id, 'period_id' => $p2024->id, 'name' => 'Contoh Nama', 'position' => 'Ketua Komisi II', 'fakultas' => '', 'prodi' => '', 'angkatan' => '', 'sort_order' => 1, 'is_active' => true]);
        $k3b = $komisi->firstWhere('abbreviation', 'III');
        Official::create(['organizational_unit_id' => $k3b->id, 'period_id' => $p2024->id, 'name' => 'Contoh Nama', 'position' => 'Ketua Komisi III', 'fakultas' => '', 'prodi' => '', 'angkatan' => '', 'sort_order' => 1, 'is_active' => true]);
        $k4b = $komisi->firstWhere('abbreviation', 'IV');
        Official::create(['organizational_unit_id' => $k4b->id, 'period_id' => $p2024->id, 'name' => 'Contoh Nama', 'position' => 'Ketua Komisi IV', 'fakultas' => '', 'prodi' => '', 'angkatan' => '', 'sort_order' => 1, 'is_active' => true]);

        $this->command->info('Sample profil dewan officials created.');
    }
}
