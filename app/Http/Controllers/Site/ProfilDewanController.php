<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Period;
use App\Models\ProfilDewan;
use Illuminate\View\View;

class ProfilDewanController extends Controller
{
    /**
     * List semua pimpinan dan komisi Dewan (halaman utama profil-dewan).
     */
    public function index(): View
    {
        $periode = Period::active();

        $profils = ProfilDewan::query()
            ->where('status', 'Aktif')
            ->when($periode, fn ($query) => $query->where('periode', $periode->name))
            ->orderBy('jabatan')
            ->get();

        // Group by jabatan type
        $pimpinan = $profils->filter(fn ($p) => str_contains($p->jabatan, 'Ketua Umum')
            || str_contains($p->jabatan, 'Wakil Ketua Umum')
            || str_contains($p->jabatan, 'Sekretaris')
            || str_contains($p->jabatan, 'Ketua Komisi'));
        $komisi1 = $profils->filter(fn ($p) => str_contains($p->jabatan, 'Komisi I'));
        $komisi2 = $profils->filter(fn ($p) => str_contains($p->jabatan, 'Komisi II'));
        $komisi3 = $profils->filter(fn ($p) => str_contains($p->jabatan, 'Komisi III'));
        $komisi4 = $profils->filter(fn ($p) => str_contains($p->jabatan, 'Komisi IV'));

        return view('site.profil-dewan-list', [
            'profils' => $profils,
            'pimpinan' => $pimpinan,
            'komisi1' => $komisi1,
            'komisi2' => $komisi2,
            'komisi3' => $komisi3,
            'komisi4' => $komisi4,
            'periode' => $periode?->name,
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
}
