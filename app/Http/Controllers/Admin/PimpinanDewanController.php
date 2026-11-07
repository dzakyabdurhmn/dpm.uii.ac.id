<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Period;
use App\Models\PimpinanDewan;
use App\Models\PimpinanTugas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PimpinanDewanController extends Controller
{
    public function index(): View
    {
        $periode = Period::where('is_active', true)->first();
        $pimpinan = PimpinanDewan::where('periode_id', $periode?->id)
            ->orderBy('sort_order')
            ->get();

        return view('admin.pimpinan-dewan.index', compact('periode', 'pimpinan'));
    }

    public function create(): View
    {
        $periode = Period::where('is_active', true)->first();
        $jabatanOptions = [
            'Ketua', 'Sekretaris Jenderal',
            'Komisi 1', 'Komisi 2', 'Komisi 3', 'Komisi 4',
            'Anggota Komisi 1', 'Anggota Komisi 2', 'Anggota Komisi 3', 'Anggota Komisi 4',
        ];

        return view('admin.pimpinan-dewan.form', compact('periode', 'jabatanOptions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'periode_id' => ['required', 'exists:periods,id'],
            'jabatan' => ['required', 'string', 'max:100'],
            'nama' => ['required', 'string', 'max:100'],
            'fakultas' => ['nullable', 'string', 'max:100'],
            'prodi' => ['nullable', 'string', 'max:100'],
            'angkatan' => ['nullable', 'string', 'max:20'],
            'nim' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'instagram' => ['nullable', 'string', 'max:150'],
            'linkedin' => ['nullable', 'string', 'max:150'],
            'foto_path' => ['nullable', 'string', 'max:2048'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['boolean'],
        ]);

        PimpinanDewan::create($validated);

        return redirect()->route('admin.pimpinan-dewan.index')
            ->with('success', 'Pimpinan dewan berhasil ditambahkan.');
    }

    public function edit(PimpinanDewan $pimpinan): View
    {
        $periode = Period::where('is_active', true)->first();
        $jabatanOptions = [
            'Ketua', 'Sekretaris Jenderal',
            'Komisi 1', 'Komisi 2', 'Komisi 3', 'Komisi 4',
            'Anggota Komisi 1', 'Anggota Komisi 2', 'Anggota Komisi 3', 'Anggota Komisi 4',
        ];

        return view('admin.pimpinan-dewan.form', compact('pimpinan', 'periode', 'jabatanOptions'));
    }

    public function update(Request $request, PimpinanDewan $pimpinan): RedirectResponse
    {
        $validated = $request->validate([
            'periode_id' => ['required', 'exists:periods,id'],
            'jabatan' => ['required', 'string', 'max:100'],
            'nama' => ['required', 'string', 'max:100'],
            'fakultas' => ['nullable', 'string', 'max:100'],
            'prodi' => ['nullable', 'string', 'max:100'],
            'angkatan' => ['nullable', 'string', 'max:20'],
            'nim' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'instagram' => ['nullable', 'string', 'max:150'],
            'linkedin' => ['nullable', 'string', 'max:150'],
            'foto_path' => ['nullable', 'string', 'max:2048'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['boolean'],
        ]);

        $pimpinan->update($validated);

        return redirect()->route('admin.pimpinan-dewan.index')
            ->with('success', 'Pimpinan dewan berhasil diperbarui.');
    }

    public function destroy(PimpinanDewan $pimpinan): RedirectResponse
    {
        $pimpinan->delete();

        return redirect()->route('admin.pimpinan-dewan.index')
            ->with('success', 'Pimpinan dewan berhasil dihapus.');
    }

    public function tugas(PimpinanDewan $pimpinan): View
    {
        $tugas = $pimpinan->tugas()->orderBy('sort_order')->get();

        return view('admin.pimpinan-dewan.tugas', compact('pimpinan', 'tugas'));
    }

    public function tugasStore(Request $request, PimpinanDewan $pimpinan): RedirectResponse
    {
        $validated = $request->validate([
            'tugas' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $pimpinan->tugas()->create($validated);

        return redirect()->route('admin.pimpinan-dewan.tugas', $pimpinan)
            ->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function tugasUpdate(Request $request, PimpinanDewan $pimpinan, PimpinanTugas $tugas): RedirectResponse
    {
        $validated = $request->validate([
            'tugas' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $tugas->update($validated);

        return redirect()->route('admin.pimpinan-dewan.tugas', $pimpinan)
            ->with('success', 'Tugas berhasil diperbarui.');
    }

    public function tugasDestroy(PimpinanDewan $pimpinan, PimpinanTugas $tugas): RedirectResponse
    {
        $tugas->delete();

        return redirect()->route('admin.pimpinan-dewan.tugas', $pimpinan)
            ->with('success', 'Tugas berhasil dihapus.');
    }
}
