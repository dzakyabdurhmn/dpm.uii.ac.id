<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\AlokasiDistribusi;
use App\Models\AlokasiTaktis;
use App\Models\DanaInfo;
use App\Models\DanaKomponen;
use App\Models\DanaSeksi;
use App\Models\DanaTriwulan;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Fakultas;
use App\Models\KomponenDana;
use App\Models\Lembaga;
use App\Models\MahasiswaFakultas;
use App\Models\Period;
use Illuminate\Http\Request;

class DistribusiDanaController extends Controller
{
    public function index(Request $request)
    {
        $published = DanaTriwulan::where('status', 'terbit')
            ->orderByDesc('triwulan')
            ->get();

        if ($published->isEmpty()) {
            abort(404, 'Data distribusi dana belum tersedia.');
        }

        $periods = Period::query()
            ->whereIn('id', $published->pluck('periode_id')->unique())
            ->orderByDesc('name')
            ->get();

        $periode = $periods->firstWhere('id', (int) $request->query('periode')) ?? $periods->first();

        $triwulanOptions = $published->where('periode_id', $periode->id)->sortByDesc('triwulan')->values();

        $triwulan = $triwulanOptions->firstWhere('triwulan', (int) $request->query('triwulan'))
            ?? $triwulanOptions->first();

        $triwulanLabel = static fn (int $number): string => 'Triwulan '.(['I', 'II', 'III', 'IV'][$number - 1] ?? $number);

        // Komponen dana dengan jumlah
        $komponen = KomponenDana::where('is_tampil', true)
            ->orderBy('urutan')
            ->get()
            ->map(function ($k) use ($triwulan) {
                $komponenData = DanaKomponen::where('dana_triwulan_id', $triwulan->id)
                    ->where('komponen_id', $k->id)
                    ->first();
                $k->jumlah = $komponenData?->jumlah ?? 0;

                return $k;
            });

        $totalDana = $triwulan->total_dana;
        $distribusiTotal = $komponen->firstWhere('peran', 'distribusi')?->jumlah ?? 0;
        $taktisTotal = $komponen->firstWhere('peran', 'taktis')?->jumlah ?? 0;
        $taktisSisa = max(0, $taktisTotal - AlokasiTaktis::where('dana_triwulan_id', $triwulan->id)->sum('jumlah'));

        // Alokasi distribusi grouped by tingkat
        $alokasiDistribusi = AlokasiDistribusi::where('dana_triwulan_id', $triwulan->id)
            ->with('lembaga.fakultas')
            ->get();

        $universitasLembaga = $alokasiDistribusi->filter(function ($a) {
            return $a->lembaga->tingkat === 'universitas';
        });

        $fakultasLembaga = $alokasiDistribusi->filter(function ($a) {
            return $a->lembaga->tingkat === 'fakultas';
        });

        // Total per fakultas (grouped)
        $totalPerFakultas = $fakultasLembaga->groupBy(function ($a) {
            return $a->lembaga->fakultas_id;
        })->map(function ($items, $fakultasId) {
            $fakultas = Fakultas::find($fakultasId);

            return [
                'fakultas' => $fakultas,
                'total' => $items->sum('jumlah'),
            ];
        })->sortByDesc('total');

        // Lembaga khusus (anak dari Lembaga Khusus Universitas)
        $lembagaKhususInduk = Lembaga::where('nama', 'Lembaga Khusus Universitas')->first();
        $lembagaKhususAnak = $lembagaKhususInduk?->children;

        // Alokasi taktis
        $alokasiTaktis = AlokasiTaktis::where('dana_triwulan_id', $triwulan->id)
            ->with('fakultas')
            ->get();

        // Mahasiswa fakultas untuk rasio
        $mahasiswa = MahasiswaFakultas::where('periode_id', $periode->id)
            ->with('fakultas')
            ->get();

        $totalMahasiswa = $mahasiswa->sum('jumlah_mahasiswa');

        // Dana info
        $danaInfo = DanaInfo::where('dana_triwulan_id', $triwulan->id)
            ->pluck('teks', 'seksi');

        // Dana seksi (tampilkan atau tidak)
        $danaSeksi = DanaSeksi::where('dana_triwulan_id', $triwulan->id)
            ->where('is_tampil', true)
            ->orderBy('urutan')
            ->get();

        // Dokumen keuangan (LPJ & LHA) via Document model
        $lpjCategory = DocumentCategory::where('slug', 'lpj')->first();
        $lhaCategory = DocumentCategory::where('slug', 'lha')->first();

        $dokumenLpj = $lpjCategory
            ? Document::query()
                ->published()
                ->where('document_category_id', $lpjCategory->id)
                ->where('period_id', $periode->id)
                ->with('category')
                ->latest('published_at')
                ->get()
            : collect();

        $dokumenLha = $lhaCategory
            ? Document::query()
                ->published()
                ->where('document_category_id', $lhaCategory->id)
                ->where('period_id', $periode->id)
                ->with('category')
                ->latest('published_at')
                ->get()
            : collect();

        // Hitung persentase
        $bilahPersen = $totalDana > 0 ? round(($distribusiTotal / $totalDana) * 100, 1) : 0;

        $universitasTotal = $universitasLembaga->sum('jumlah');
        $fakultasTotal = $fakultasLembaga->sum('jumlah');
        $universitasPersen = $distribusiTotal > 0 ? (int) round(($universitasTotal / $distribusiTotal) * 100) : 0;
        $fakultasPersen = $distribusiTotal > 0 ? (int) round(($fakultasTotal / $distribusiTotal) * 100) : 0;

        return view('site.dana.distribusi', compact(
            'triwulan', 'periode', 'periods', 'triwulanOptions', 'triwulanLabel',
            'komponen', 'totalDana', 'distribusiTotal', 'taktisTotal', 'taktisSisa',
            'alokasiDistribusi', 'universitasLembaga', 'fakultasLembaga', 'totalPerFakultas',
            'lembagaKhususAnak', 'universitasTotal', 'fakultasTotal', 'universitasPersen',
            'fakultasPersen', 'alokasiTaktis', 'mahasiswa', 'totalMahasiswa', 'danaInfo',
            'danaSeksi', 'dokumenLpj', 'dokumenLha', 'bilahPersen'
        ));
    }
}
