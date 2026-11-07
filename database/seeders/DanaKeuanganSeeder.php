<?php

namespace Database\Seeders;

use App\Models\AlokasiDistribusi;
use App\Models\AlokasiTaktis;
use App\Models\DanaInfo;
use App\Models\DanaKomponen;
use App\Models\DanaRevisi;
use App\Models\DanaSeksi;
use App\Models\DanaTriwulan;
use App\Models\DokumenKeuangan;
use App\Models\Fakultas;
use App\Models\KomponenDana;
use App\Models\Lembaga;
use App\Models\MahasiswaFakultas;
use App\Models\PengaturanHalaman;
use App\Models\Period;
use App\Models\User;
use Illuminate\Database\Seeder;

class DanaKeuanganSeeder extends Seeder
{
    public function run(): void
    {
        $periode = Period::updateOrCreate(
            ['name' => '2025/2026'],
            ['starts_on' => '2025-06-01', 'ends_on' => '2026-05-31', 'is_active' => true]
        );

        $admin = User::first();

        // ---------- Fakultas (9 fakultas UII) ----------
        $fakultasData = [
            ['kode' => 'FBE', 'nama' => 'Fakultas Bisnis dan Ekonomika', 'urutan' => 1],
            ['kode' => 'FH', 'nama' => 'Fakultas Hukum', 'urutan' => 2],
            ['kode' => 'FIAI', 'nama' => 'Fakultas Ilmu Agama Islam', 'urutan' => 3],
            ['kode' => 'FISB', 'nama' => 'Fakultas Ilmu Sosial Budaya', 'urutan' => 4],
            ['kode' => 'FK', 'nama' => 'Fakultas Kedokteran', 'urutan' => 5],
            ['kode' => 'FMIPA', 'nama' => 'Fakultas Matematika dan Ilmu Pengetahuan Alam', 'urutan' => 6],
            ['kode' => 'FPSB', 'nama' => 'Fakultas Psikologi', 'urutan' => 7],
            ['kode' => 'FTDI', 'nama' => 'Fakultas Teknik Desain Inovasi', 'urutan' => 8],
            ['kode' => 'FTI', 'nama' => 'Fakultas Teknologi Industri', 'urutan' => 9],
        ];
        $fakultas = [];
        foreach ($fakultasData as $fd) {
            $fakultas[] = Fakultas::updateOrCreate(['kode' => $fd['kode']], $fd);
        }

        // ---------- Lembaga ----------
        $lembagaData = [
            ['nama' => 'Lembaga Khusus Universitas', 'tingkat' => 'universitas', 'jenis' => 'lembaga_khusus', 'fakultas_id' => null, 'parent_id' => null],
            ['nama' => 'DPM Universitas', 'tingkat' => 'universitas', 'jenis' => 'dpm', 'fakultas_id' => null, 'parent_id' => null],
            ['nama' => 'LEM Universitas', 'tingkat' => 'universitas', 'jenis' => 'lem', 'fakultas_id' => null, 'parent_id' => null],
            ['nama' => 'Mapala UII', 'tingkat' => 'universitas', 'jenis' => 'lembaga_khusus', 'fakultas_id' => null, 'parent_id' => null],
            ['nama' => 'Himmah UII', 'tingkat' => 'universitas', 'jenis' => 'lembaga_khusus', 'fakultas_id' => null, 'parent_id' => null],
            ['nama' => 'Marching Band UII', 'tingkat' => 'universitas', 'jenis' => 'lembaga_khusus', 'fakultas_id' => null, 'parent_id' => null],
            ['nama' => 'KOPMA UII', 'tingkat' => 'universitas', 'jenis' => 'kopma', 'fakultas_id' => null, 'parent_id' => null],
            ['nama' => 'LEM FH', 'tingkat' => 'fakultas', 'jenis' => 'lem', 'fakultas_id' => $fakultas[1]->id, 'parent_id' => null],
            ['nama' => 'LPM FH', 'tingkat' => 'fakultas', 'jenis' => 'lpm', 'fakultas_id' => $fakultas[1]->id, 'parent_id' => null],
            ['nama' => 'DPM FH', 'tingkat' => 'fakultas', 'jenis' => 'dpm', 'fakultas_id' => $fakultas[1]->id, 'parent_id' => null],
            ['nama' => 'LEM FTI', 'tingkat' => 'fakultas', 'jenis' => 'lem', 'fakultas_id' => $fakultas[8]->id, 'parent_id' => null],
            ['nama' => 'LPM FTI', 'tingkat' => 'fakultas', 'jenis' => 'lpm', 'fakultas_id' => $fakultas[8]->id, 'parent_id' => null],
            ['nama' => 'DPM FTI', 'tingkat' => 'fakultas', 'jenis' => 'dpm', 'fakultas_id' => $fakultas[8]->id, 'parent_id' => null],
        ];
        $lembaga = [];
        foreach ($lembagaData as $ld) {
            $lembaga[] = Lembaga::updateOrCreate(['nama' => $ld['nama']], $ld);
        }

        // ---------- Komponen Dana ----------
        $komponenData = [
            ['kode' => 'transisi', 'nama' => 'Dana Transisi', 'urutan' => 1, 'is_tampil' => true, 'peran' => 'lainnya'],
            ['kode' => 'taktis', 'nama' => 'Dana Taktis', 'urutan' => 2, 'is_tampil' => true, 'peran' => 'taktis'],
            ['kode' => 'aset', 'nama' => 'Pengembangan dan Pengelolaan Aset', 'urutan' => 3, 'is_tampil' => true, 'peran' => 'lainnya'],
            ['kode' => 'distribusi', 'nama' => 'Dana Distribusi', 'urutan' => 4, 'is_tampil' => true, 'peran' => 'distribusi'],
        ];
        $komponen = [];
        foreach ($komponenData as $kd) {
            $komponen[] = KomponenDana::updateOrCreate(['kode' => $kd['kode']], $kd);
        }

        // ---------- Dana Triwulan (Triwulan I 2025/2026) ----------
        $triwulan = DanaTriwulan::updateOrCreate(
            ['periode_id' => $periode->id, 'triwulan' => 1],
            [
                'total_dana' => 688575000,
                'status' => 'terbit',
                'diterbitkan_pada' => now(),
                'diterbitkan_oleh' => $admin?->id,
                'sumber_url' => null,
            ]
        );

        // ---------- Dana Komponen ----------
        $komponenJumlah = [
            'transisi' => 12000000,
            'taktis' => 103286250,
            'aset' => 3000000,
            'distribusi' => 570288750,
        ];
        foreach ($komponen as $k) {
            DanaKomponen::updateOrCreate(
                ['dana_triwulan_id' => $triwulan->id, 'komponen_id' => $k->id],
                ['jumlah' => $komponenJumlah[$k->kode]]
            );
        }

        // ---------- Alokasi Distribusi ----------
        $alokasiDistribusi = [
            ['nama' => 'Mapala UII', 'jumlah' => 37125798],
            ['nama' => 'Himmah UII', 'jumlah' => 37125798],
            ['nama' => 'Marching Band UII', 'jumlah' => 31822112],
            ['nama' => 'KOPMA UII', 'jumlah' => 0],
            ['nama' => 'LEM Universitas', 'jumlah' => 60108434],
            ['nama' => 'DPM Universitas', 'jumlah' => 10607371],
            ['nama' => 'LEM FH', 'jumlah' => 24396952],
            ['nama' => 'LPM FH', 'jumlah' => 12591975],
            ['nama' => 'DPM FH', 'jumlah' => 2360995],
            ['nama' => 'LEM FTI', 'jumlah' => 24396952],
            ['nama' => 'LPM FTI', 'jumlah' => 12591975],
            ['nama' => 'DPM FTI', 'jumlah' => 2360995],
        ];
        foreach ($alokasiDistribusi as $ad) {
            $lem = Lembaga::where('nama', $ad['nama'])->first();
            if ($lem) {
                AlokasiDistribusi::updateOrCreate(
                    ['dana_triwulan_id' => $triwulan->id, 'lembaga_id' => $lem->id],
                    ['jumlah' => $ad['jumlah']]
                );
            }
        }

        // ---------- Alokasi Taktis ----------
        $alokasiTaktis = [
            ['fakultas' => null, 'jumlah' => 41200000, 'keterangan' => 'Universitas'],
            ['fakultas' => 'FH', 'jumlah' => 700000, 'keterangan' => null],
            ['fakultas' => 'FTI', 'jumlah' => 5000000, 'keterangan' => null],
        ];
        foreach ($alokasiTaktis as $at) {
            $fk = $at['fakultas'] ? Fakultas::where('kode', $at['fakultas'])->first() : null;
            AlokasiTaktis::updateOrCreate(
                ['dana_triwulan_id' => $triwulan->id, 'fakultas_id' => $fk?->id],
                ['jumlah' => $at['jumlah'], 'keterangan' => $at['keterangan']]
            );
        }

        // ---------- Mahasiswa Fakultas ----------
        $mahasiswa = [
            'FBE' => 3441, 'FH' => 3408, 'FTI' => 2843, 'FIAI' => 1800, 'FISB' => 2213,
            'FK' => 805, 'FMIPA' => 1464, 'FPSB' => 1334, 'FTDI' => 2055,
        ];
        foreach ($mahasiswa as $kode => $jm) {
            $fk = Fakultas::where('kode', $kode)->first();
            if ($fk) {
                MahasiswaFakultas::updateOrCreate(
                    ['periode_id' => $periode->id, 'fakultas_id' => $fk->id],
                    ['jumlah_mahasiswa' => $jm]
                );
            }
        }

        // ---------- Dana Info ----------
        $infoData = [
            'overview' => 'Total dana distribusi periode 2025/2026 Triwulan I sebesar Rp688.575.000,00.',
            'pembagian' => 'Dana dibagi menjadi komponen transisi, taktis, aset, dan distribusi.',
            'universitas' => 'Dana tingkat universitas dialokasikan kepada DPM Universitas dan LEM Universitas.',
            'fakultas' => 'Dana tingkat fakultas dialokasikan kepada LEM, LPM, dan DPM tiap fakultas.',
            'per_fakultas' => 'Setiap fakultas menerima alokasi sesuai dengan jumlah mahasiswa dan kebutuhan program kerja.',
            'rasio' => 'Rasio alokasi per fakultas dihitung berdasarkan proporsi jumlah mahasiswa per fakultas terhadap total mahasiswa.',
            'taktis' => 'Dana taktis dialokasikan untuk kebutuhan operasional dan program kerja tingkat universitas dan fakultas.',
        ];
        foreach ($infoData as $seksi => $teks) {
            DanaInfo::updateOrCreate(
                ['dana_triwulan_id' => $triwulan->id, 'seksi' => $seksi],
                ['teks' => $teks]
            );
        }

        // ---------- Dana Seksi ----------
        $seksiData = [
            ['seksi' => 'overview', 'urutan' => 1, 'is_tampil' => true, 'judul' => 'Ringkasan'],
            ['seksi' => 'pembagian', 'urutan' => 2, 'is_tampil' => true, 'judul' => 'Pembagian Komponen'],
            ['seksi' => 'universitas', 'urutan' => 3, 'is_tampil' => true, 'judul' => 'Tingkat Universitas'],
            ['seksi' => 'fakultas', 'urutan' => 4, 'is_tampil' => true, 'judul' => 'Tingkat Fakultas'],
            ['seksi' => 'per_fakultas', 'urutan' => 5, 'is_tampil' => true, 'judul' => 'Per Fakultas'],
            ['seksi' => 'rasio', 'urutan' => 6, 'is_tampil' => true, 'judul' => 'Rasio Mahasiswa'],
            ['seksi' => 'taktis', 'urutan' => 7, 'is_tampil' => true, 'judul' => 'Dana Taktis'],
        ];
        foreach ($seksiData as $sd) {
            DanaSeksi::updateOrCreate(
                ['dana_triwulan_id' => $triwulan->id, 'seksi' => $sd['seksi']],
                ['urutan' => $sd['urutan'], 'is_tampil' => $sd['is_tampil'], 'judul' => $sd['judul']]
            );
        }

        // ---------- Dokumen Keuangan ----------
        $lemUii = Lembaga::where('nama', 'DPM Universitas')->first();
        if ($lemUii) {
            DokumenKeuangan::updateOrCreate(
                ['jenis' => 'lpj', 'periode_id' => $periode->id, 'lembaga_id' => $lemUii->id, 'semester' => 'ganjil'],
                ['judul' => 'LPJ DPM Universitas Semester Ganjil 2025/2026', 'tanggal' => '2026-01-15', 'file_path' => null, 'status' => 'terbit']
            );
            DokumenKeuangan::updateOrCreate(
                ['jenis' => 'lha', 'periode_id' => $periode->id, 'lembaga_id' => $lemUii->id, 'semester' => 'ganjil'],
                ['judul' => 'LHA DPM Universitas Semester Ganjil 2025/2026', 'tanggal' => '2026-02-01', 'file_path' => null, 'status' => 'draft']
            );
        }

        // ---------- Pengaturan Halaman ----------
        $pengaturan = [
            'distribusi_dana' => [
                'hero_deskripsi' => 'Transparansi distribusi dana DPM UII periode 2025/2026.',
                'judul_overview' => 'Ringkasan Dana',
                'catatan_sumber' => 'Sumber: Sekretariat Jenderal DPM UII',
                'dasar_hukum' => 'PDKM UII dan PDPM UII',
            ],
        ];
        foreach ($pengaturan as $halaman => $items) {
            foreach ($items as $kunci => $nilai) {
                PengaturanHalaman::updateOrCreate(
                    ['halaman' => $halaman, 'kunci' => $kunci],
                    ['nilai' => $nilai]
                );
            }
        }

        // ---------- Dana Revisi ----------
        if ($admin) {
            DanaRevisi::create([
                'dana_triwulan_id' => $triwulan->id,
                'diubah_oleh' => $admin->id,
                'alasan' => 'Pembentukan data awal distribusi dana Triwulan I.',
                'snapshot' => ['total_dana' => 688575000, 'status' => 'terbit'],
                'dibuat_pada' => now(),
            ]);
        }

        $this->command->info('Dummy data Dana Keuangan created successfully.');
    }
}
