<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationalUnit;
use App\Models\Period;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UnitController extends Controller
{
    /**
     * Alat kelengkapan adalah daftar tetap: hanya bisa diubah, tidak bisa
     * ditambah atau dihapus. CMS-nya ada pada data anggota di tiap unit.
     */
    public function index(): View
    {
        return view('admin.units.index', [
            'units' => OrganizationalUnit::query()
                ->withCount(['officials' => fn ($query) => $query->where('is_active', true)])
                ->orderBy('sort_order')
                ->get(),
        ]);
    }

    public function edit(OrganizationalUnit $unit): View
    {
        return view('admin.units.form', [
            'unit' => $unit,
            'periods' => Period::query()->orderByDesc('is_active')->orderByDesc('name')->get(),
            'officials' => $unit->officials()
                ->with('period')
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function update(Request $request, OrganizationalUnit $unit): RedirectResponse
    {
        $unit->update($this->validated($request));

        return redirect()
            ->route('admin.units.edit', $unit)
            ->with('success', 'Unit "'.$unit->short_name.'" berhasil diperbarui.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'abbreviation' => ['nullable', 'string', 'max:32'],
            'type' => ['required', 'in:'.implode(',', OrganizationalUnit::TYPES)],
            'description' => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $data['slug'] = Str::slug($request->input('name'));
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
