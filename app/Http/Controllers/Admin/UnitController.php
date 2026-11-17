<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationalUnit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class UnitController extends Controller
{
    /**
     * Daftar alat kelengkapan. Unit bisa ditambah kapan saja, tetapi unit yang
     * sudah punya anggota tidak bisa dihapus agar data keanggotaan tidak hilang.
     */
    public function index(): View
    {
        $periodId = session('admin_period_id');

        return view('admin.units.index', [
            'units' => OrganizationalUnit::query()
                ->withCount([
                    'officials as members_count' => fn ($query) => $query->where('is_active', true),
                    'officials as members_all_count',
                    'officials as members_in_period_count' => fn ($query) => $query
                        ->where('is_active', true)
                        ->where('period_id', $periodId),
                ])
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.units.form', [
            'unit' => new OrganizationalUnit([
                'type' => 'badan',
                'is_active' => true,
                'sort_order' => (int) OrganizationalUnit::query()->max('sort_order') + 1,
            ]),
            'officials' => collect(),
            'isCreating' => true,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $unit = OrganizationalUnit::query()->create($this->validated($request));

        return redirect()
            ->route('admin.units.edit', $unit)
            ->with('success', 'Alat kelengkapan "'.$unit->short_name.'" berhasil ditambahkan. Sekarang tambahkan anggotanya.');
    }

    public function edit(OrganizationalUnit $unit): View
    {
        $unit->load('officials');

        return view('admin.units.form', [
            'unit' => $unit,
            'officials' => $unit->officials()
                ->with('period')
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
            'isCreating' => false,
        ]);
    }

    public function update(Request $request, OrganizationalUnit $unit): RedirectResponse
    {
        $unit->update($this->validated($request, $unit));

        return redirect()
            ->route('admin.units.edit', $unit)
            ->with('success', 'Unit "'.$unit->short_name.'" berhasil diperbarui.');
    }

    public function destroy(OrganizationalUnit $unit): RedirectResponse
    {
        $memberCount = $unit->officials()->count();

        if ($memberCount > 0) {
            return redirect()
                ->route('admin.units.index')
                ->with('error', 'Unit "'.$unit->short_name.'" tidak bisa dihapus karena masih memiliki '.$memberCount.' anggota. Pindahkan atau hapus anggotanya terlebih dahulu.');
        }

        $this->deleteLogo($unit);
        $unit->delete();

        return redirect()
            ->route('admin.units.index')
            ->with('success', 'Unit "'.$unit->short_name.'" berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, ?OrganizationalUnit $unit = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'abbreviation' => ['nullable', 'string', 'max:60'],
            'slug' => ['nullable', 'string', 'max:150', 'alpha_dash'],
            'type' => ['required', 'in:'.implode(',', OrganizationalUnit::TYPES)],
            'description' => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'logo' => ['nullable', 'image', 'max:2048'],
        ]);

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_active'] = $request->boolean('is_active');

        // Slug dikosongkan = biarkan sistem membuat/mempertahankan slug yang ada.
        if (blank($data['slug'] ?? null)) {
            unset($data['slug']);
        }

        unset($data['logo']);

        if ($request->hasFile('logo')) {
            if ($unit !== null) {
                $this->deleteLogo($unit);
            }

            $file = $request->file('logo');
            $path = $file->storeAs(
                'unit',
                Str::uuid()->toString().'.'.strtolower($file->getClientOriginalExtension() ?: 'png'),
                'uploads',
            );

            $data['logo_path'] = 'uploads/'.$path;
        }

        return $data;
    }

    private function deleteLogo(OrganizationalUnit $unit): void
    {
        if (filled($unit->logo_path) && Str::startsWith($unit->logo_path, 'uploads/')) {
            Storage::disk('uploads')->delete(Str::after($unit->logo_path, 'uploads/'));
        }
    }
}
