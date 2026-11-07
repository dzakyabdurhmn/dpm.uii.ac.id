<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlokasiDistribusi;
use App\Models\AlokasiTaktis;
use App\Models\DanaInfo;
use App\Models\DanaKomponen;
use App\Models\DanaSeksi;
use App\Models\DanaTriwulan;
use App\Models\Fakultas;
use App\Models\KomponenDana;
use App\Models\MahasiswaFakultas;
use App\Models\Period;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DistribusiDanaController extends Controller
{
    public function index(): View
    {
        $periode = Period::where('is_active', true)->first();
        $triwulan = $periode?->danaTriwulan()->orderByDesc('triwulan')->first();

        $komponen = KomponenDana::where('is_tampil', true)
            ->orderBy('urutan')
            ->get();

        $alokasiDistribusi = AlokasiDistribusi::where('dana_triwulan_id', $triwulan?->id)
            ->with('lembaga.fakultas')
            ->get();

        $alokasiTaktis = AlokasiTaktis::where('dana_triwulan_id', $triwulan?->id)
            ->with('fakultas')
            ->get();

        $mahasiswa = MahasiswaFakultas::where('periode_id', $periode?->id)
            ->with('fakultas')
            ->get();

        $danaInfo = DanaInfo::where('dana_triwulan_id', $triwulan?->id)
            ->pluck('teks', 'seksi');

        $danaSeksi = DanaSeksi::where('dana_triwulan_id', $triwulan?->id)
            ->orderBy('urutan')
            ->get();

        $totalDana = $triwulan?->total_dana ?? 0;
        $distribusiTotal = $komponen->firstWhere('peran', 'distribusi')?->pivot->jumlah ?? 0;
        $taktisTotal = $komponen->firstWhere('peran', 'taktis')?->pivot->jumlah ?? 0;

        return view('admin.distribusi-dana.index', compact(
            'periode', 'triwulan', 'komponen', 'alokasiDistribusi',
            'alokasiTaktis', 'mahasiswa', 'danaInfo', 'danaSeksi',
            'totalDana', 'distribusiTotal', 'taktisTotal'
        ));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'periode_id' => ['required', 'exists:periods,id'],
            'triwulan' => ['required', 'integer', 'min:1', 'max:4'],
            'total_dana' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:draft,terbit'],
            'komponen' => ['nullable', 'array'],
            'komponen.*.id' => ['required_if:komponen,,exists:komponen_dana,id'],
            'komponen.*.jumlah' => ['required_if:komponen,,numeric', 'min:0'],
            'alokasi_distribusi' => ['nullable', 'array'],
            'alokasi_distribusi.*.lembaga_id' => ['required_if:alokasi_distribusi,,exists:lembagas,id'],
            'alokasi_distribusi.*.jumlah' => ['required_if:alokasi_distribusi,,numeric', 'min:0'],
            'alokasi_taktis' => ['nullable', 'array'],
            'alokasi_taktis.*.fakultas_id' => ['nullable', 'exists:fakultas,id'],
            'alokasi_taktis.*.jumlah' => ['required_if:alokasi_taktis,,numeric', 'min:0'],
            'alokasi_taktis.*.keterangan' => ['nullable', 'string'],
            'mahasiswa' => ['nullable', 'array'],
            'mahasiswa.*.fakultas_id' => ['required_if:mahasiswa,,exists:fakultas,id'],
            'mahasiswa.*.jumlah_mahasiswa' => ['required_if:mahasiswa,,integer', 'min:0'],
            'dana_info' => ['nullable', 'array'],
            'dana_info.*.seksi' => ['required_if:dana_info,,string'],
            'dana_info.*.teks' => ['required_if:dana_info,,string'],
            'dana_seksi' => ['nullable', 'array'],
            'dana_seksi.*.seksi' => ['required_if:dana_seksi,,string'],
            'dana_seksi.*.judul' => ['required_if:dana_seksi,,string'],
            'dana_seksi.*.urutan' => ['required_if:dana_seksi,,integer'],
            'dana_seksi.*.is_tampil' => ['boolean'],
        ]);

        $periode = Period::findOrFail($validated['periode_id']);

        $triwulan = DanaTriwulan::updateOrCreate(
            ['periode_id' => $periode->id, 'triwulan' => $validated['triwulan']],
            [
                'total_dana' => $validated['total_dana'],
                'status' => $validated['status'],
            ]
        );

        // Komponen dana
        if (isset($validated['komponen'])) {
            foreach ($validated['komponen'] as $k) {
                DanaKomponen::updateOrCreate(
                    ['dana_triwulan_id' => $triwulan->id, 'komponen_id' => $k['id']],
                    ['jumlah' => $k['jumlah']]
                );
            }
        }

        // Alokasi distribusi
        if (isset($validated['alokasi_distribusi'])) {
            foreach ($validated['alokasi_distribusi'] as $a) {
                AlokasiDistribusi::updateOrCreate(
                    ['dana_triwulan_id' => $triwulan->id, 'lembaga_id' => $a['lembaga_id']],
                    ['jumlah' => $a['jumlah']]
                );
            }
        }

        // Alokasi taktis
        if (isset($validated['alokasi_taktis'])) {
            foreach ($validated['alokasi_taktis'] as $t) {
                AlokasiTaktis::updateOrCreate(
                    ['dana_triwulan_id' => $triwulan->id, 'fakultas_id' => $t['fakultas_id'] ?? null],
                    ['jumlah' => $t['jumlah'], 'keterangan' => $t['keterangan'] ?? null]
                );
            }
        }

        // Mahasiswa fakultas
        if (isset($validated['mahasiswa'])) {
            foreach ($validated['mahasiswa'] as $m) {
                MahasiswaFakultas::updateOrCreate(
                    ['periode_id' => $periode->id, 'fakultas_id' => $m['fakultas_id']],
                    ['jumlah_mahasiswa' => $m['jumlah_mahasiswa']]
                );
            }
        }

        // Dana info
        if (isset($validated['dana_info'])) {
            foreach ($validated['dana_info'] as $i) {
                DanaInfo::updateOrCreate(
                    ['dana_triwulan_id' => $triwulan->id, 'seksi' => $i['seksi']],
                    ['teks' => $i['teks']]
                );
            }
        }

        // Dana seksi
        if (isset($validated['dana_seksi'])) {
            foreach ($validated['dana_seksi'] as $s) {
                DanaSeksi::updateOrCreate(
                    ['dana_triwulan_id' => $triwulan->id, 'seksi' => $s['seksi']],
                    ['judul' => $s['judul'], 'urutan' => $s['urutan'], 'is_tampil' => $s['is_tampil'] ?? false]
                );
            }
        }

        return redirect()->route('admin.distribusi-dana')
            ->with('success', 'Data distribusi dana berhasil disimpan.');
    }
}
