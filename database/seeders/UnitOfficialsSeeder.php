<?php

namespace Database\Seeders;

use App\Models\Official;
use App\Models\OrganizationalUnit;
use App\Models\Period;
use Illuminate\Database\Seeder;

class UnitOfficialsSeeder extends Seeder
{
    public function run(): void
    {
        $periods = Period::all()->keyBy('name');
        $units = OrganizationalUnit::active()->whereNull('parent_id')->get()->keyBy('slug');

        // Clear existing officials
        Official::truncate();

        // ===========================================
        // PERIODE 2025/2026
        // ===========================================
        $p2025 = $periods['2025/2026'];

        // ---- MENTARI ----
        $mentari = $units['mentari'] ?? null;
        if ($mentari) {
            Official::create(['organizational_unit_id' => $mentari->id, 'period_id' => $p2025->id, 'name' => 'Rizky Pratama', 'position' => 'Ketua', 'fakultas' => 'Fakultas Ilmu Agama Islam', 'prodi' => 'Ilmu Agama Islam', 'angkatan' => '2022', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $mentari->id, 'period_id' => $p2025->id, 'name' => 'Nadia Amalia', 'position' => 'Wakil Ketua', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2023', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $mentari->id, 'period_id' => $p2025->id, 'name' => 'Bagas Wicaksono', 'position' => 'Sekretaris', 'fakultas' => 'Fakultas Teknologi Industri', 'prodi' => 'Informatika', 'angkatan' => '2023', 'sort_order' => 3, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $mentari->id, 'period_id' => $p2025->id, 'name' => 'Siti Rahmawati', 'position' => 'Bendahara', 'fakultas' => 'Fakultas Bisnis dan Ekonomika', 'prodi' => 'Akuntansi', 'angkatan' => '2024', 'sort_order' => 4, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $mentari->id, 'period_id' => $p2025->id, 'name' => 'Farhan Maulana', 'position' => 'Kepala Divisi Media', 'fakultas' => 'Fakultas Psikologi dan Ilmu Sosial Budaya', 'prodi' => 'Ilmu Komunikasi', 'angkatan' => '2024', 'sort_order' => 5, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $mentari->id, 'period_id' => $p2025->id, 'name' => 'Dewi Lestari', 'position' => 'Kepala Divisi Kesekretariatan', 'fakultas' => 'Fakultas Ilmu Agama Islam', 'prodi' => 'Hukum Ekonomi Syariah', 'angkatan' => '2024', 'sort_order' => 6, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $mentari->id, 'period_id' => $p2025->id, 'name' => 'Muhammad Fadli', 'position' => 'Staf Dokumentasi', 'fakultas' => 'Fakultas MIPA', 'prodi' => 'Statistika', 'angkatan' => '2025', 'sort_order' => 7, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $mentari->id, 'period_id' => $p2025->id, 'name' => 'Putri Ayu', 'position' => 'Staf Publikasi', 'fakultas' => 'Fakultas Teknik Sipil dan Perencanaan', 'prodi' => 'Teknik Sipil', 'angkatan' => '2025', 'sort_order' => 8, 'is_active' => true]);
        }

        // ---- BALEG ----
        $baleg = $units['badan-legislasi'] ?? null;
        if ($baleg) {
            Official::create(['organizational_unit_id' => $baleg->id, 'period_id' => $p2025->id, 'name' => 'Ahmad Zaki', 'position' => 'Ketua', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2022', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $baleg->id, 'period_id' => $p2025->id, 'name' => 'Rina Safitri', 'position' => 'Wakil Ketua', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2023', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $baleg->id, 'period_id' => $p2025->id, 'name' => 'Budi Santoso', 'position' => 'Sekretaris', 'fakultas' => 'Fakultas Ilmu Agama Islam', 'prodi' => 'Hukum Ekonomi Syariah', 'angkatan' => '2023', 'sort_order' => 3, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $baleg->id, 'period_id' => $p2025->id, 'name' => 'Linda Kusuma', 'position' => 'Anggota', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2024', 'sort_order' => 4, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $baleg->id, 'period_id' => $p2025->id, 'name' => 'Doni Pratama', 'position' => 'Anggota', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2024', 'sort_order' => 5, 'is_active' => true]);
        }

        // ---- BAWAS ----
        $bawas = $units['badan-pengawasan'] ?? null;
        if ($bawas) {
            Official::create(['organizational_unit_id' => $bawas->id, 'period_id' => $p2025->id, 'name' => 'Surya Pratama', 'position' => 'Ketua', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2022', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bawas->id, 'period_id' => $p2025->id, 'name' => 'Maya Indah', 'position' => 'Wakil Ketua', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2023', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bawas->id, 'period_id' => $p2025->id, 'name' => 'Eko Prasetyo', 'position' => 'Sekretaris', 'fakultas' => 'Fakultas Ilmu Agama Islam', 'prodi' => 'Ilmu Agama Islam', 'angkatan' => '2023', 'sort_order' => 3, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bawas->id, 'period_id' => $p2025->id, 'name' => 'Novianti', 'position' => 'Anggota', 'fakultas' => 'Fakultas Psikologi dan Ilmu Sosial Budaya', 'prodi' => 'Ilmu Komunikasi', 'angkatan' => '2024', 'sort_order' => 4, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bawas->id, 'period_id' => $p2025->id, 'name' => 'Reza Mahendra', 'position' => 'Anggota', 'fakultas' => 'Fakultas Teknologi Industri', 'prodi' => 'Teknik Industri', 'angkatan' => '2024', 'sort_order' => 5, 'is_active' => true]);
        }

        // ---- BKSAJ ----
        $bksaj = $units['badan-kerjasama-advokasi-dan-jaringan'] ?? null;
        if ($bksaj) {
            Official::create(['organizational_unit_id' => $bksaj->id, 'period_id' => $p2025->id, 'name' => 'Raka Aditya', 'position' => 'Ketua', 'fakultas' => 'Fakultas Bisnis dan Ekonomika', 'prodi' => 'Manajemen', 'angkatan' => '2022', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bksaj->id, 'period_id' => $p2025->id, 'name' => 'Salsabila', 'position' => 'Wakil Ketua', 'fakultas' => 'Fakultas Ilmu Agama Islam', 'prodi' => 'Ilmu Agama Islam', 'angkatan' => '2023', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bksaj->id, 'period_id' => $p2025->id, 'name' => 'Yusuf Rahman', 'position' => 'Sekretaris', 'fakultas' => 'Fakultas Teknologi Industri', 'prodi' => 'Informatika', 'angkatan' => '2023', 'sort_order' => 3, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bksaj->id, 'period_id' => $p2025->id, 'name' => 'Intan Permata', 'position' => 'Anggota', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2024', 'sort_order' => 4, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bksaj->id, 'period_id' => $p2025->id, 'name' => 'Fikri Maulana', 'position' => 'Anggota', 'fakultas' => 'Fakultas Teknik Sipil dan Perencanaan', 'prodi' => 'Perencanaan Wilayah dan Kota', 'angkatan' => '2024', 'sort_order' => 5, 'is_active' => true]);
        }

        // ---- BAK ----
        $bak = $units['badan-audit-kemahasiswaan'] ?? null;
        if ($bak) {
            Official::create(['organizational_unit_id' => $bak->id, 'period_id' => $p2025->id, 'name' => 'Dimas Prasetyo', 'position' => 'Ketua', 'fakultas' => 'Fakultas Bisnis dan Ekonomika', 'prodi' => 'Akuntansi', 'angkatan' => '2022', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bak->id, 'period_id' => $p2025->id, 'name' => 'Nurlita', 'position' => 'Wakil Ketua', 'fakultas' => 'Fakultas Bisnis dan Ekonomika', 'prodi' => 'Akuntansi', 'angkatan' => '2023', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bak->id, 'period_id' => $p2025->id, 'name' => 'Andi Wijaya', 'position' => 'Sekretaris', 'fakultas' => 'Fakultas MIPA', 'prodi' => 'Matematika', 'angkatan' => '2023', 'sort_order' => 3, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bak->id, 'period_id' => $p2025->id, 'name' => 'Rizki Amalia', 'position' => 'Anggota', 'fakultas' => 'Fakultas Bisnis dan Ekonomika', 'prodi' => 'Manajemen', 'angkatan' => '2024', 'sort_order' => 4, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bak->id, 'period_id' => $p2025->id, 'name' => 'Bayu Setiawan', 'position' => 'Anggota', 'fakultas' => 'Fakultas Teknologi Industri', 'prodi' => 'Sistem Informasi', 'angkatan' => '2024', 'sort_order' => 5, 'is_active' => true]);
        }

        // ---- BPA ----
        $bpa = $units['badan-pengelola-aset'] ?? null;
        if ($bpa) {
            Official::create(['organizational_unit_id' => $bpa->id, 'period_id' => $p2025->id, 'name' => 'Agung Wicaksono', 'position' => 'Ketua', 'fakultas' => 'Fakultas Teknik Sipil dan Perencanaan', 'prodi' => 'Teknik Sipil', 'angkatan' => '2022', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bpa->id, 'period_id' => $p2025->id, 'name' => 'Dian Sastri', 'position' => 'Wakil Ketua', 'fakultas' => 'Fakultas Teknologi Industri', 'prodi' => 'Teknik Industri', 'angkatan' => '2023', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bpa->id, 'period_id' => $p2025->id, 'name' => 'Eka Putra', 'position' => 'Sekretaris', 'fakultas' => 'Fakultas MIPA', 'prodi' => 'Fisika', 'angkatan' => '2023', 'sort_order' => 3, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bpa->id, 'period_id' => $p2025->id, 'name' => 'Gita Savitri', 'position' => 'Anggota', 'fakultas' => 'Fakultas Teknik Sipil dan Perencanaan', 'prodi' => 'Arsitektur', 'angkatan' => '2024', 'sort_order' => 4, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bpa->id, 'period_id' => $p2025->id, 'name' => 'Hendra Gunawan', 'position' => 'Anggota', 'fakultas' => 'Fakultas Kedokteran', 'prodi' => 'Pendidikan Dokter', 'angkatan' => '2024', 'sort_order' => 5, 'is_active' => true]);
        }

        // ===========================================
        // PERIODE 2024/2025
        // ===========================================
        $p2024 = $periods['2024/2025'];

        // Mentari 2024/2025
        if ($mentari) {
            Official::create(['organizational_unit_id' => $mentari->id, 'period_id' => $p2024->id, 'name' => 'Rafi Adriansyah', 'position' => 'Ketua', 'fakultas' => 'Fakultas Ilmu Agama Islam', 'prodi' => 'Ilmu Agama Islam', 'angkatan' => '2021', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $mentari->id, 'period_id' => $p2024->id, 'name' => 'Nisa Khairunnisa', 'position' => 'Wakil Ketua', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2022', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $mentari->id, 'period_id' => $p2024->id, 'name' => 'Dani Pratama', 'position' => 'Sekretaris', 'fakultas' => 'Fakultas Teknologi Industri', 'prodi' => 'Informatika', 'angkatan' => '2022', 'sort_order' => 3, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $mentari->id, 'period_id' => $p2024->id, 'name' => 'Maya Sari', 'position' => 'Bendahara', 'fakultas' => 'Fakultas Bisnis dan Ekonomika', 'prodi' => 'Akuntansi', 'angkatan' => '2023', 'sort_order' => 4, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $mentari->id, 'period_id' => $p2024->id, 'name' => 'Rizky Ananda', 'position' => 'Kepala Divisi Media', 'fakultas' => 'Fakultas Psikologi dan Ilmu Sosial Budaya', 'prodi' => 'Ilmu Komunikasi', 'angkatan' => '2023', 'sort_order' => 5, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $mentari->id, 'period_id' => $p2024->id, 'name' => 'Bayu Pratama', 'position' => 'Staf Dokumentasi', 'fakultas' => 'Fakultas MIPA', 'prodi' => 'Statistika', 'angkatan' => '2024', 'sort_order' => 6, 'is_active' => true]);
        }

        // Baleg 2024/2025
        if ($baleg) {
            Official::create(['organizational_unit_id' => $baleg->id, 'period_id' => $p2024->id, 'name' => 'Hendra Wijaya', 'position' => 'Ketua', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2021', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $baleg->id, 'period_id' => $p2024->id, 'name' => 'Siti Nurhaliza', 'position' => 'Wakil Ketua', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2022', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $baleg->id, 'period_id' => $p2024->id, 'name' => 'Ahmad Fauzi', 'position' => 'Sekretaris', 'fakultas' => 'Fakultas Ilmu Agama Islam', 'prodi' => 'Hukum Ekonomi Syariah', 'angkatan' => '2022', 'sort_order' => 3, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $baleg->id, 'period_id' => $p2024->id, 'name' => 'Dewi Sartika', 'position' => 'Anggota', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2023', 'sort_order' => 4, 'is_active' => true]);
        }

        // Bawas 2024/2025
        if ($bawas) {
            Official::create(['organizational_unit_id' => $bawas->id, 'period_id' => $p2024->id, 'name' => 'Rian Saputra', 'position' => 'Ketua', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2021', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bawas->id, 'period_id' => $p2024->id, 'name' => 'Lestari Dewi', 'position' => 'Wakil Ketua', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2022', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bawas->id, 'period_id' => $p2024->id, 'name' => 'Bambang Sutrisno', 'position' => 'Sekretaris', 'fakultas' => 'Fakultas Ilmu Agama Islam', 'prodi' => 'Ilmu Agama Islam', 'angkatan' => '2022', 'sort_order' => 3, 'is_active' => true]);
        }

        // Bksaj 2024/2025
        if ($bksaj) {
            Official::create(['organizational_unit_id' => $bksaj->id, 'period_id' => $p2024->id, 'name' => 'Dimas Aditya', 'position' => 'Ketua', 'fakultas' => 'Fakultas Bisnis dan Ekonomika', 'prodi' => 'Manajemen', 'angkatan' => '2021', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bksaj->id, 'period_id' => $p2024->id, 'name' => 'Rina Marlina', 'position' => 'Wakil Ketua', 'fakultas' => 'Fakultas Ilmu Agama Islam', 'prodi' => 'Ilmu Agama Islam', 'angkatan' => '2022', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bksaj->id, 'period_id' => $p2024->id, 'name' => 'Yudi Prasetyo', 'position' => 'Sekretaris', 'fakultas' => 'Fakultas Teknologi Industri', 'prodi' => 'Informatika', 'angkatan' => '2022', 'sort_order' => 3, 'is_active' => true]);
        }

        // BAK 2024/2025
        if ($bak) {
            Official::create(['organizational_unit_id' => $bak->id, 'period_id' => $p2024->id, 'name' => 'Eko Sulistyo', 'position' => 'Ketua', 'fakultas' => 'Fakultas Bisnis dan Ekonomika', 'prodi' => 'Akuntansi', 'angkatan' => '2021', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bak->id, 'period_id' => $p2024->id, 'name' => 'Novi Andriani', 'position' => 'Wakil Ketua', 'fakultas' => 'Fakultas Bisnis dan Ekonomika', 'prodi' => 'Akuntansi', 'angkatan' => '2022', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bak->id, 'period_id' => $p2024->id, 'name' => 'Andre Pratama', 'position' => 'Sekretaris', 'fakultas' => 'Fakultas MIPA', 'prodi' => 'Matematika', 'angkatan' => '2022', 'sort_order' => 3, 'is_active' => true]);
        }

        // BPA 2024/2025
        if ($bpa) {
            Official::create(['organizational_unit_id' => $bpa->id, 'period_id' => $p2024->id, 'name' => 'Fajar Sidiq', 'position' => 'Ketua', 'fakultas' => 'Fakultas Teknik Sipil dan Perencanaan', 'prodi' => 'Teknik Sipil', 'angkatan' => '2021', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bpa->id, 'period_id' => $p2024->id, 'name' => 'Gina Rahmawati', 'position' => 'Wakil Ketua', 'fakultas' => 'Fakultas Teknologi Industri', 'prodi' => 'Teknik Industri', 'angkatan' => '2022', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bpa->id, 'period_id' => $p2024->id, 'name' => 'Haris Setiawan', 'position' => 'Sekretaris', 'fakultas' => 'Fakultas MIPA', 'prodi' => 'Fisika', 'angkatan' => '2022', 'sort_order' => 3, 'is_active' => true]);
        }

        // ===========================================
        // PERIODE 2023/2024
        // ===========================================
        $p2023 = $periods['2023/2024'];

        // Mentari 2023/2024
        if ($mentari) {
            Official::create(['organizational_unit_id' => $mentari->id, 'period_id' => $p2023->id, 'name' => 'Rizwan Hakim', 'position' => 'Ketua', 'fakultas' => 'Fakultas Ilmu Agama Islam', 'prodi' => 'Ilmu Agama Islam', 'angkatan' => '2020', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $mentari->id, 'period_id' => $p2023->id, 'name' => 'Nurul Hidayah', 'position' => 'Wakil Ketua', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2021', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $mentari->id, 'period_id' => $p2023->id, 'name' => 'Cahyo Aditya', 'position' => 'Sekretaris', 'fakultas' => 'Fakultas Teknologi Industri', 'prodi' => 'Informatika', 'angkatan' => '2021', 'sort_order' => 3, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $mentari->id, 'period_id' => $p2023->id, 'name' => 'Putri Wulandari', 'position' => 'Bendahara', 'fakultas' => 'Fakultas Bisnis dan Ekonomika', 'prodi' => 'Akuntansi', 'angkatan' => '2022', 'sort_order' => 4, 'is_active' => true]);
        }

        // Baleg 2023/2024
        if ($baleg) {
            Official::create(['organizational_unit_id' => $baleg->id, 'period_id' => $p2023->id, 'name' => 'Joko Susilo', 'position' => 'Ketua', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2020', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $baleg->id, 'period_id' => $p2023->id, 'name' => 'Maya Anggraini', 'position' => 'Wakil Ketua', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2021', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $baleg->id, 'period_id' => $p2023->id, 'name' => 'Adi Nugroho', 'position' => 'Sekretaris', 'fakultas' => 'Fakultas Ilmu Agama Islam', 'prodi' => 'Hukum Ekonomi Syariah', 'angkatan' => '2021', 'sort_order' => 3, 'is_active' => true]);
        }

        // Bawas 2023/2024
        if ($bawas) {
            Official::create(['organizational_unit_id' => $bawas->id, 'period_id' => $p2023->id, 'name' => 'Slamet Riyadi', 'position' => 'Ketua', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2020', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bawas->id, 'period_id' => $p2023->id, 'name' => 'Tri Wahyuni', 'position' => 'Wakil Ketua', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2021', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bawas->id, 'period_id' => $p2023->id, 'name' => 'Budi Hartono', 'position' => 'Sekretaris', 'fakultas' => 'Fakultas Ilmu Agama Islam', 'prodi' => 'Ilmu Agama Islam', 'angkatan' => '2021', 'sort_order' => 3, 'is_active' => true]);
        }

        // Bksaj 2023/2024
        if ($bksaj) {
            Official::create(['organizational_unit_id' => $bksaj->id, 'period_id' => $p2023->id, 'name' => 'Eko Prasetyo', 'position' => 'Ketua', 'fakultas' => 'Fakultas Bisnis dan Ekonomika', 'prodi' => 'Manajemen', 'angkatan' => '2020', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bksaj->id, 'period_id' => $p2023->id, 'name' => 'Sari Dewi', 'position' => 'Wakil Ketua', 'fakultas' => 'Fakultas Ilmu Agama Islam', 'prodi' => 'Ilmu Agama Islam', 'angkatan' => '2021', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bksaj->id, 'period_id' => $p2023->id, 'name' => 'Yusuf Hidayat', 'position' => 'Sekretaris', 'fakultas' => 'Fakultas Teknologi Industri', 'prodi' => 'Informatika', 'angkatan' => '2021', 'sort_order' => 3, 'is_active' => true]);
        }

        // BAK 2023/2024
        if ($bak) {
            Official::create(['organizational_unit_id' => $bak->id, 'period_id' => $p2023->id, 'name' => 'Fahrul Rozi', 'position' => 'Ketua', 'fakultas' => 'Fakultas Bisnis dan Ekonomika', 'prodi' => 'Akuntansi', 'angkatan' => '2020', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bak->id, 'period_id' => $p2023->id, 'name' => 'Indah Permata', 'position' => 'Wakil Ketua', 'fakultas' => 'Fakultas Bisnis dan Ekonomika', 'prodi' => 'Akuntansi', 'angkatan' => '2021', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bak->id, 'period_id' => $p2023->id, 'name' => 'Agus Salim', 'position' => 'Sekretaris', 'fakultas' => 'Fakultas MIPA', 'prodi' => 'Matematika', 'angkatan' => '2021', 'sort_order' => 3, 'is_active' => true]);
        }

        // BPA 2023/2024
        if ($bpa) {
            Official::create(['organizational_unit_id' => $bpa->id, 'period_id' => $p2023->id, 'name' => 'Bambang Widodo', 'position' => 'Ketua', 'fakultas' => 'Fakultas Teknik Sipil dan Perencanaan', 'prodi' => 'Teknik Sipil', 'angkatan' => '2020', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bpa->id, 'period_id' => $p2023->id, 'name' => 'Citra Lestari', 'position' => 'Wakil Ketua', 'fakultas' => 'Fakultas Teknologi Industri', 'prodi' => 'Teknik Industri', 'angkatan' => '2021', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $bpa->id, 'period_id' => $p2023->id, 'name' => 'Dedi Mulyadi', 'position' => 'Sekretaris', 'fakultas' => 'Fakultas MIPA', 'prodi' => 'Fisika', 'angkatan' => '2021', 'sort_order' => 3, 'is_active' => true]);
        }

        // ---- PIMPINAN DEWAN ----
        $pimpinan = $units['pimpinan-dewan'] ?? null;
        if ($pimpinan) {
            Official::create(['organizational_unit_id' => $pimpinan->id, 'period_id' => $p2025->id, 'name' => 'Troy Amirul Akhmad', 'position' => 'Ketua Umum', 'fakultas' => '', 'prodi' => '', 'angkatan' => '', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $pimpinan->id, 'period_id' => $p2025->id, 'name' => 'Aulia Rahmawati', 'position' => 'Sekretaris Jenderal', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2023', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $pimpinan->id, 'period_id' => $p2025->id, 'name' => 'Bagas Pramudya', 'position' => 'Bendahara Umum', 'fakultas' => 'Fakultas Bisnis dan Ekonomika', 'prodi' => 'Akuntansi', 'angkatan' => '2023', 'sort_order' => 3, 'is_active' => true]);
        }

        // ---- KOMISI I ----
        $komisi1 = $units['komisi-i'] ?? null;
        if ($komisi1) {
            Official::create(['organizational_unit_id' => $komisi1->id, 'period_id' => $p2025->id, 'name' => 'Rizky Ananda', 'position' => 'Ketua Komisi I', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2023', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $komisi1->id, 'period_id' => $p2025->id, 'name' => 'Nadia Safitri', 'position' => 'Anggota', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2024', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $komisi1->id, 'period_id' => $p2025->id, 'name' => 'Farhan Hidayat', 'position' => 'Anggota', 'fakultas' => 'Fakultas Ilmu Agama Islam', 'prodi' => 'Hukum Ekonomi Syariah', 'angkatan' => '2024', 'sort_order' => 3, 'is_active' => true]);
        }

        // ---- KOMISI II ----
        $komisi2 = $units['komisi-ii'] ?? null;
        if ($komisi2) {
            Official::create(['organizational_unit_id' => $komisi2->id, 'period_id' => $p2025->id, 'name' => 'Salsabila Putri', 'position' => 'Ketua Komisi II', 'fakultas' => 'Fakultas Psikologi dan Ilmu Sosial Budaya', 'prodi' => 'Ilmu Komunikasi', 'angkatan' => '2023', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $komisi2->id, 'period_id' => $p2025->id, 'name' => 'Muhammad Iqbal', 'position' => 'Anggota', 'fakultas' => 'Fakultas Teknologi Industri', 'prodi' => 'Informatika', 'angkatan' => '2024', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $komisi2->id, 'period_id' => $p2025->id, 'name' => 'Dewi Lestari', 'position' => 'Anggota', 'fakultas' => 'Fakultas Bisnis dan Ekonomika', 'prodi' => 'Manajemen', 'angkatan' => '2024', 'sort_order' => 3, 'is_active' => true]);
        }

        // ---- KOMISI III ----
        $komisi3 = $units['komisi-iii'] ?? null;
        if ($komisi3) {
            Official::create(['organizational_unit_id' => $komisi3->id, 'period_id' => $p2025->id, 'name' => 'Ahmad Fauzan', 'position' => 'Ketua Komisi III', 'fakultas' => 'Fakultas Teknik Sipil dan Perencanaan', 'prodi' => 'Teknik Sipil', 'angkatan' => '2023', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $komisi3->id, 'period_id' => $p2025->id, 'name' => 'Kinanti Maharani', 'position' => 'Anggota', 'fakultas' => 'Fakultas Kedokteran', 'prodi' => 'Pendidikan Dokter', 'angkatan' => '2024', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $komisi3->id, 'period_id' => $p2025->id, 'name' => 'Yoga Prasetyo', 'position' => 'Anggota', 'fakultas' => 'Fakultas MIPA', 'prodi' => 'Statistika', 'angkatan' => '2024', 'sort_order' => 3, 'is_active' => true]);
        }

        // ---- KOMISI IV ----
        $komisi4 = $units['komisi-iv'] ?? null;
        if ($komisi4) {
            Official::create(['organizational_unit_id' => $komisi4->id, 'period_id' => $p2025->id, 'name' => 'Zahra Nabila', 'position' => 'Ketua Komisi IV', 'fakultas' => 'Fakultas Ilmu Agama Islam', 'prodi' => 'Ilmu Agama Islam', 'angkatan' => '2023', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $komisi4->id, 'period_id' => $p2025->id, 'name' => 'Daffa Alfarizi', 'position' => 'Anggota', 'fakultas' => 'Fakultas Teknologi Industri', 'prodi' => 'Teknik Industri', 'angkatan' => '2024', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $komisi4->id, 'period_id' => $p2025->id, 'name' => 'Nurul Hidayah', 'position' => 'Anggota', 'fakultas' => 'Fakultas Hukum', 'prodi' => 'Ilmu Hukum', 'angkatan' => '2025', 'sort_order' => 3, 'is_active' => true]);
        }

        // ===========================================
        // PERIODE 2024/2025
        // ===========================================
        $p2024 = $periods['2024/2025'];

        // ---- PIMPINAN DEWAN ----
        if ($pimpinan) {
            Official::create(['organizational_unit_id' => $pimpinan->id, 'period_id' => $p2024->id, 'name' => 'Fikri Maulana', 'position' => 'Ketua Umum', 'fakultas' => '', 'prodi' => '', 'angkatan' => '', 'sort_order' => 1, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $pimpinan->id, 'period_id' => $p2024->id, 'name' => 'Intan Permata', 'position' => 'Sekretaris Jenderal', 'fakultas' => '', 'prodi' => '', 'angkatan' => '', 'sort_order' => 2, 'is_active' => true]);
            Official::create(['organizational_unit_id' => $pimpinan->id, 'period_id' => $p2024->id, 'name' => 'Raka Wirawan', 'position' => 'Bendahara Umum', 'fakultas' => '', 'prodi' => '', 'angkatan' => '', 'sort_order' => 3, 'is_active' => true]);
        }

        // ---- KOMISI I ----
        if ($komisi1) {
            Official::create(['organizational_unit_id' => $komisi1->id, 'period_id' => $p2024->id, 'name' => 'Contoh Nama', 'position' => 'Ketua Komisi I', 'fakultas' => '', 'prodi' => '', 'angkatan' => '', 'sort_order' => 1, 'is_active' => true]);
        }

        // ---- KOMISI II ----
        if ($komisi2) {
            Official::create(['organizational_unit_id' => $komisi2->id, 'period_id' => $p2024->id, 'name' => 'Contoh Nama', 'position' => 'Ketua Komisi II', 'fakultas' => '', 'prodi' => '', 'angkatan' => '', 'sort_order' => 1, 'is_active' => true]);
        }

        // ---- KOMISI III ----
        if ($komisi3) {
            Official::create(['organizational_unit_id' => $komisi3->id, 'period_id' => $p2024->id, 'name' => 'Contoh Nama', 'position' => 'Ketua Komisi III', 'fakultas' => '', 'prodi' => '', 'angkatan' => '', 'sort_order' => 1, 'is_active' => true]);
        }

        // ---- KOMISI IV ----
        if ($komisi4) {
            Official::create(['organizational_unit_id' => $komisi4->id, 'period_id' => $p2024->id, 'name' => 'Contoh Nama', 'position' => 'Ketua Komisi IV', 'fakultas' => '', 'prodi' => '', 'angkatan' => '', 'sort_order' => 1, 'is_active' => true]);
        }

        // ===========================================
        // PERIODE 2023/2024
        // ===========================================
        $p2023 = $periods['2023/2024'];

        // No pimpinan/komisi data for 2023/2024 (only unit officials)

        $this->command->info('All unit officials created for all periods!');
    }
}
