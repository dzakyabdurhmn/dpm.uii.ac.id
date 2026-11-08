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
use App\Models\Lembaga;
use App\Models\MahasiswaFakultas;
use App\Models\Period;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DistribusiDanaController extends Controller
{
    /**
     * List all triwulan for all periods (history).
     */
    public function index(): View
    {
        $triwulanList = DanaTriwulan::with('periode')
            ->orderByDesc('periode_id')
            ->orderByDesc('triwulan')
            ->paginate(20);

        return view('admin.distribusi-dana.index', [
            'triwulanList' => $triwulanList,
        ]);
    }

    /**
     * Show form to create new triwulan.
     */
    public function create(): View
    {
        $periods = Period::orderByDesc('name')->get();
        $komponen = KomponenDana::where('is_tampil', true)->orderBy('urutan')->get();
        $lembaga = Lembaga::where('is_active', true)->orderBy('tingkat')->orderBy('sort_order')->get();
        $fakultas = Fakultas::orderBy('urutan')->get();

        return view('admin.distribusi-dana.form', [
            'periods' => $periods,
            'komponen' => $komponen,
            'lembaga' => $lembaga,
            'fakultas' => $fakultas,
            'triwulan' => null,
            'existingData' => [],
        ]);
    }

    /**
     * Store new triwulan.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateRequest($request);

        $periode = Period::findOrFail($validated['periode_id']);

        $triwulan = DanaTriwulan::create([
            'periode_id' => $periode->id,
            'triwulan' => $validated['triwulan'],
            'total_dana' => $validated['total_dana'],
            'status' => $validated['status'],
        ]);

        $this->saveRelatedData($triwulan, $periode, $validated);

        return redirect()
            ->route('admin.distribusi-dana.edit', $triwulan)
            ->with('success', 'Triwulan baru berhasil dibuat.');
    }

    /**
     * Show form to edit existing triwulan.
     */
    public function edit(DanaTriwulan $distribusiDana): View
    {
        $periods = Period::orderByDesc('name')->get();
        $komponen = KomponenDana::where('is_tampil', true)->orderBy('urutan')->get();
        $lembaga = Lembaga::where('is_active', true)->orderBy('tingkat')->orderBy('sort_order')->get();
        $fakultas = Fakultas::orderBy('urutan')->get();

        // Load existing data
        $existingData = [
            'komponen' => DanaKomponen::where('dana_triwulan_id', $distribusiDana->id)
                ->pluck('jumlah', 'komponen_id')
                ->toArray(),
            'alokasi_distribusi' => AlokasiDistribusi::where('dana_triwulan_id', $distribusiDana->id)
                ->pluck('jumlah', 'lembaga_id')
                ->toArray(),
            'alokasi_taktis' => AlokasiTaktis::where('dana_triwulan_id', $distribusiDana->id)
                ->get()
                ->mapWithKeys(fn ($t) => [$t->fakultas_id ?? 'universitas' => ['jumlah' => $t->jumlah, 'keterangan' => $t->keterangan]])
                ->toArray(),
            'mahasiswa' => MahasiswaFakultas::where('periode_id', $distribusiDana->periode_id)
                ->pluck('jumlah_mahasiswa', 'fakultas_id')
                ->toArray(),
            'dana_info' => DanaInfo::where('dana_triwulan_id', $distribusiDana->id)
                ->pluck('teks', 'seksi')
                ->toArray(),
            'dana_seksi' => DanaSeksi::where('dana_triwulan_id', $distribusiDana->id)
                ->orderBy('urutan')
                ->get()
                ->mapWithKeys(fn ($s) => [$s->seksi => ['judul' => $s->judul, 'urutan' => $s->urutan, 'is_tampil' => $s->is_tampil]])
                ->toArray(),
        ];

        return view('admin.distribusi-dana.form', [
            'periods' => $periods,
            'komponen' => $komponen,
            'lembaga' => $lembaga,
            'fakultas' => $fakultas,
            'triwulan' => $distribusiDana,
            'existingData' => $existingData,
        ]);
    }

    /**
     * Update existing triwulan.
     */
    public function update(Request $request, DanaTriwulan $distribusiDana): RedirectResponse
    {
        $validated = $this->validateRequest($request, $distribusiDana);

        $distribusiDana->update([
            'periode_id' => $validated['periode_id'],
            'triwulan' => $validated['triwulan'],
            'total_dana' => $validated['total_dana'],
            'status' => $validated['status'],
        ]);

        $periode = Period::findOrFail($validated['periode_id']);
        $this->saveRelatedData($distribusiDana, $periode, $validated);

        return redirect()
            ->route('admin.distribusi-dana.edit', $distribusiDana)
            ->with('success', 'Data distribusi dana berhasil diperbarui.');
    }

    /**
     * Delete triwulan.
     */
    public function destroy(DanaTriwulan $distribusiDana): RedirectResponse
    {
        $distribusiDana->delete();

        return redirect()
            ->route('admin.distribusi-dana.index')
            ->with('success', 'Triwulan berhasil dihapus.');
    }

    /**
     * Validation rules.
     */
    private function validateRequest(Request $request, ?DanaTriwulan $existing = null): array
    {
        $triwulanRule = ['required', 'integer', 'min:1', 'max:4'];
        if ($existing) {
            $triwulanRule[] = 'unique:dana_triwulan,triwulan,'.$existing->id.',id,periode_id,'.$request->input('periode_id');
        } else {
            $triwulanRule[] = 'unique:dana_triwulan,triwulan,NULL,id,periode_id,'.$request->input('periode_id');
        }

        return $request->validate([
            'periode_id' => ['required', 'exists:periods,id'],
            'triwulan' => $triwulanRule,
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
    }

    /**
     * Save all related data for a triwulan.
     */
    private function saveRelatedData(DanaTriwulan $triwulan, Period $periode, array $validated): void
    {
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

        // Alokasi taktis (universitas = fakultas_id null)
        if (isset($validated['alokasi_taktis'])) {
            foreach ($validated['alokasi_taktis'] as $key => $t) {
                $fakultasId = $t['fakultas_id'] ?? null;
                AlokasiTaktis::updateOrCreate(
                    ['dana_triwulan_id' => $triwulan->id, 'fakultas_id' => $fakultasId],
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
    }
}
