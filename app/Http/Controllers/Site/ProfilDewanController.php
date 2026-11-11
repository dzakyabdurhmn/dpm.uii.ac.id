<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Official;
use App\Models\Period;
use App\Models\ProfilDewan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfilDewanController extends Controller
{
    /**
     * Komisi yang ditampilkan di halaman, urut I sampai IV.
     *
     * @var array<int, array{romawi: string, nama: string}>
     */
    private const KOMISI = [
        1 => ['romawi' => 'I', 'nama' => 'Komisi I'],
        2 => ['romawi' => 'II', 'nama' => 'Komisi II'],
        3 => ['romawi' => 'III', 'nama' => 'Komisi III'],
        4 => ['romawi' => 'IV', 'nama' => 'Komisi IV'],
    ];

    /**
     * Urutan tampilan jabatan pimpinan, dari yang paling tinggi.
     *
     * @var array<int, string>
     */
    private const URUTAN_PIMPINAN = ['wakil ketua umum', 'ketua umum', 'bendahara', 'sekretaris'];

    /**
     * List semua pimpinan dan komisi Dewan (halaman utama profil-dewan).
     */
    public function index(Request $request): View
    {
        $periode = Period::query()->where('name', $request->query('periode'))->first() ?? Period::active();

        $profils = ProfilDewan::query()
            ->when($periode, fn ($query) => $query->where('periode', $periode->name))
            // Periode aktif hanya memuat anggota yang masih aktif; arsip periode lama memuat seluruh anggotanya.
            ->when(! $periode || $periode->is_active, fn ($query) => $query->where('status', 'Aktif'))
            ->get();

        $pimpinan = $profils
            ->filter(fn (ProfilDewan $profil) => $this->nomorKomisi($profil->jabatan) === null)
            ->sortBy(fn (ProfilDewan $profil) => $this->urutanPimpinan($profil->jabatan).'|'.$profil->nama_lengkap)
            ->values();

        $komisi = collect(self::KOMISI)
            ->map(fn (array $meta, int $nomor) => $meta + [
                'nomor' => $nomor,
                'anggota' => $profils
                    ->filter(fn (ProfilDewan $profil) => $this->nomorKomisi($profil->jabatan) === $nomor)
                    ->sortBy(fn (ProfilDewan $profil) => ($this->adalahKetua($profil->jabatan) ? '0' : '1').'|'.$profil->nama_lengkap)
                    ->values(),
            ])
            ->filter(fn (array $seksi) => $seksi['anggota']->isNotEmpty())
            ->values();

        // Foto anggota diambil dari data Kwarcis yang sudah ada, agar kartu tidak kosong.
        $fotos = Official::query()
            ->whereHas('unit', fn ($query) => $query->whereIn('slug', ['pimpinan-dewan', 'komisi-i', 'komisi-ii', 'komisi-iii', 'komisi-iv']))
            ->when($periode !== null, fn ($query) => $query->where('period_id', $periode->id))
            ->whereNotNull('photo_path')
            ->pluck('photo_path', 'name');

        return view('site.profil-dewan-list', [
            'periode' => $periode,
            'periodePilihan' => Period::query()
                ->whereIn('name', ProfilDewan::query()->distinct()->pluck('periode'))
                ->orderByDesc('name')
                ->get(),
            'pimpinan' => $pimpinan,
            'komisi' => $komisi,
            'fotos' => $fotos,
        ]);
    }

    /**
     * Detail profil Dewan per individu.
     */
    public function show($nim): View
    {
        $profil = ProfilDewan::where('nim', $nim)->first()
            ?? abort(404, 'Profil Dewan tidak ditemukan.');

        return view('site.profil-dewan-detail', compact('profil'));
    }

    /**
     * Nomor komisi dari jabatan, null bila jabatan bukan komisi.
     */
    private function nomorKomisi(?string $jabatan): ?int
    {
        if (! preg_match('/komisi\s*(iv|iii|ii|i|4|3|2|1)\b/i', (string) $jabatan, $cocok)) {
            return null;
        }

        return match (strtolower($cocok[1])) {
            'i', '1' => 1,
            'ii', '2' => 2,
            'iii', '3' => 3,
            'iv', '4' => 4,
        };
    }

    private function adalahKetua(?string $jabatan): bool
    {
        return str_contains(strtolower((string) $jabatan), 'ketua');
    }

    /**
     * Urutan tampilan jabatan pimpinan.
     */
    private function urutanPimpinan(?string $jabatan): int
    {
        $jabatan = strtolower((string) $jabatan);

        foreach (self::URUTAN_PIMPINAN as $urut => $kata) {
            if (str_contains($jabatan, $kata)) {
                return $urut;
            }
        }

        return count(self::URUTAN_PIMPINAN);
    }
}
