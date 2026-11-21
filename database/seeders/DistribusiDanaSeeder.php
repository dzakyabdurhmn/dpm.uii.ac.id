<?php

namespace Database\Seeders;

use App\Models\AlokasiDistribusi;
use App\Models\AlokasiTaktis;
use App\Models\DanaKomponen;
use App\Models\DanaTriwulan;
use App\Models\Fakultas;
use App\Models\KomponenDana;
use App\Models\Lembaga;
use App\Models\MahasiswaFakultas;
use App\Models\Period;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistribusiDanaSeeder extends Seeder
{
    /**
     * Data Distribusi Dana Triwulan I DPM UII 2025/2026.
     *
     * @var array<string, array{nama: string, urutan: int, mahasiswa: int, dana: int}>
     */
    private array $fakultasData = [
        'FBE' => ['nama' => 'Fakultas Bisnis & Ekonomika', 'urutan' => 1, 'mahasiswa' => 3441, 'dana' => 61_587_238],
        'FH' => ['nama' => 'Fakultas Hukum', 'urutan' => 2, 'mahasiswa' => 3408, 'dana' => 61_166_000],
        'FTI' => ['nama' => 'Fakultas Teknik Industri', 'urutan' => 3, 'mahasiswa' => 2843, 'dana' => 53_926_000],
        'FISB' => ['nama' => 'Fakultas Ilmu Sosial Budaya', 'urutan' => 4, 'mahasiswa' => 2213, 'dana' => 45_850_000],
        'FTSP' => ['nama' => 'Fakultas Teknik Sipil & Perencanaan', 'urutan' => 5, 'mahasiswa' => 2055, 'dana' => 43_830_000],
        'FMIPA' => ['nama' => 'Fakultas MIPA', 'urutan' => 6, 'mahasiswa' => 1464, 'dana' => 36_250_000],
        'FPSI' => ['nama' => 'Fakultas Psikologi', 'urutan' => 7, 'mahasiswa' => 1334, 'dana' => 34_590_000],
        'FIAI' => ['nama' => 'Fakultas Ilmu Agama Islam', 'urutan' => 8, 'mahasiswa' => 858, 'dana' => 28_490_000],
        'FK' => ['nama' => 'Fakultas Kedokteran', 'urutan' => 9, 'mahasiswa' => 805, 'dana' => 27_810_000],
    ];

    public function run(): void
    {
        DB::transaction(function () {
            $fakultas = $this->seedFakultas();
            $periode = Period::query()->where('name', '2025/2026')->firstOrFail();
            $triwulan = $this->seedTriwulan($periode);

            $this->seedKomponen($triwulan);
            $this->seedLembagaUniversitas();
            $this->seedMahasiswa($periode, $fakultas);
            $this->seedAlokasiTaktis($triwulan, $fakultas);
            $this->seedAlokasiDistribusi($triwulan, $fakultas);
        });
    }

    /**
     * @return array<string, Fakultas>
     */
    private function seedFakultas(): array
    {
        // Kode lama yang sudah tidak dipakai lagi.
        Fakultas::query()->where('kode', 'FPSB')->update(['kode' => 'FPSI']);

        $fakultas = [];

        foreach ($this->fakultasData as $kode => $data) {
            $fakultas[$kode] = Fakultas::query()->updateOrCreate(
                ['kode' => $kode],
                ['nama' => $data['nama'], 'urutan' => $data['urutan']],
            );
        }

        $legacyIds = Fakultas::query()
            ->whereIn('kode', ['FE', 'FB', 'FTDI', 'FPSIB'])
            ->pluck('id');

        if ($legacyIds->isNotEmpty()) {
            MahasiswaFakultas::query()->whereIn('fakultas_id', $legacyIds)->delete();
            AlokasiTaktis::query()->whereIn('fakultas_id', $legacyIds)->delete();
            Lembaga::query()->whereIn('fakultas_id', $legacyIds)->update(['fakultas_id' => null]);
            Fakultas::query()->whereIn('id', $legacyIds)->delete();
        }

        return $fakultas;
    }

    private function seedTriwulan(Period $periode): DanaTriwulan
    {
        $triwulan = DanaTriwulan::query()->updateOrCreate(
            ['periode_id' => $periode->id, 'triwulan' => 1],
            ['total_dana' => 688_575_000, 'status' => 'terbit'],
        );

        return $triwulan;
    }

    private function seedKomponen(DanaTriwulan $triwulan): void
    {
        $komponen = [
            'transisi' => ['nama' => 'Dana Transisi', 'urutan' => 1, 'peran' => 'lainnya', 'jumlah' => 12_000_000],
            'taktis' => ['nama' => 'Dana Taktis', 'urutan' => 2, 'peran' => 'taktis', 'jumlah' => 103_286_250],
            'aset' => ['nama' => 'Pengembangan dan Pengelolaan Aset', 'urutan' => 3, 'peran' => 'lainnya', 'jumlah' => 3_000_000],
            'distribusi' => ['nama' => 'Dana Distribusi', 'urutan' => 4, 'peran' => 'distribusi', 'jumlah' => 570_288_750],
        ];

        foreach ($komponen as $kode => $data) {
            $komponenDana = KomponenDana::query()->updateOrCreate(
                ['kode' => $kode],
                [
                    'nama' => $data['nama'],
                    'urutan' => $data['urutan'],
                    'peran' => $data['peran'],
                    'is_tampil' => true,
                ],
            );

            DanaKomponen::query()->updateOrCreate(
                ['dana_triwulan_id' => $triwulan->id, 'komponen_id' => $komponenDana->id],
                ['jumlah' => $data['jumlah']],
            );
        }
    }

    private function seedLembagaUniversitas(): void
    {
        $lembaga = [
            'Lembaga Khusus Universitas' => 'lembaga_khusus',
            'DPM Universitas' => 'dpm',
            'LEM Universitas' => 'lem',
            'Mapala UII' => 'lembaga_khusus',
            'Himmah UII' => 'lembaga_khusus',
            'Marching Band UII' => 'lembaga_khusus',
            'KOPMA UII' => 'kopma',
        ];

        foreach ($lembaga as $nama => $jenis) {
            Lembaga::query()->updateOrCreate(
                ['nama' => $nama],
                ['tingkat' => 'universitas', 'jenis' => $jenis, 'is_aktif' => true],
            );
        }
    }

    /**
     * @param  array<string, Fakultas>  $fakultas
     */
    private function seedMahasiswa(Period $periode, array $fakultas): void
    {
        foreach ($this->fakultasData as $kode => $data) {
            MahasiswaFakultas::query()->updateOrCreate(
                ['periode_id' => $periode->id, 'fakultas_id' => $fakultas[$kode]->id],
                ['jumlah_mahasiswa' => $data['mahasiswa']],
            );
        }
    }

    /**
     * @param  array<string, Fakultas>  $fakultas
     */
    private function seedAlokasiTaktis(DanaTriwulan $triwulan, array $fakultas): void
    {
        $taktis = [
            'universitas' => 41_200_000,
            'FH' => 700_000,
            'FTI' => 5_000_000,
            'FISB' => 9_000_000,
            'FTSP' => 4_400_000,
            'FMIPA' => 5_200_000,
            'FPSI' => 0,
            'FIAI' => 3_000_000,
            'FK' => 6_600_000,
            'FBE' => 5_500_000,
        ];

        AlokasiTaktis::query()->where('dana_triwulan_id', $triwulan->id)->delete();

        foreach ($taktis as $kode => $jumlah) {
            AlokasiTaktis::query()->create([
                'dana_triwulan_id' => $triwulan->id,
                'fakultas_id' => $kode === 'universitas' ? null : $fakultas[$kode]->id,
                'jumlah' => $jumlah,
            ]);
        }
    }

    /**
     * @param  array<string, Fakultas>  $fakultas
     */
    private function seedAlokasiDistribusi(DanaTriwulan $triwulan, array $fakultas): void
    {
        AlokasiDistribusi::query()->where('dana_triwulan_id', $triwulan->id)->delete();

        $universitas = [
            'Mapala UII' => 37_125_798,
            'Himmah UII' => 37_125_798,
            'Marching Band UII' => 31_822_112,
            'KOPMA UII' => 0,
            'LEM Universitas' => 60_108_434,
            'DPM Universitas' => 10_607_371,
        ];

        foreach ($universitas as $nama => $jumlah) {
            $lembaga = Lembaga::query()->where('nama', $nama)->firstOrFail();

            AlokasiDistribusi::query()->create([
                'dana_triwulan_id' => $triwulan->id,
                'lembaga_id' => $lembaga->id,
                'jumlah' => $jumlah,
            ]);
        }

        foreach ($this->fakultasData as $kode => $data) {
            $total = $data['dana'];
            $lem = (int) round($total * 0.62);
            $lpm = (int) round($total * 0.32);
            $dpm = $total - $lem - $lpm;

            $alokasi = ['lem' => $lem, 'lpm' => $lpm, 'dpm' => $dpm];

            foreach ($alokasi as $jenis => $jumlah) {
                $lembaga = Lembaga::query()->updateOrCreate(
                    ['nama' => strtoupper($jenis).' '.$kode],
                    [
                        'tingkat' => 'fakultas',
                        'jenis' => $jenis,
                        'fakultas_id' => $fakultas[$kode]->id,
                        'is_aktif' => true,
                    ],
                );

                AlokasiDistribusi::query()->create([
                    'dana_triwulan_id' => $triwulan->id,
                    'lembaga_id' => $lembaga->id,
                    'jumlah' => $jumlah,
                ]);
            }
        }
    }
}
