<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Official;
use App\Models\OrganizationalUnit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OfficialController extends Controller
{
    public function store(Request $request, OrganizationalUnit $unit): RedirectResponse
    {
        $data = $this->validated($request);
        $data['photo_path'] = $this->storePhoto($request, $unit);

        $unit->officials()->create($data);

        return redirect()
            ->route('admin.units.edit', $unit)
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function update(Request $request, OrganizationalUnit $unit, Official $official): RedirectResponse
    {
        $this->ensureBelongsToUnit($unit, $official);

        $data = $this->validated($request);

        if ($request->hasFile('photo')) {
            $this->deletePhoto($official);
            $data['photo_path'] = $this->storePhoto($request, $unit);
        }

        $official->update($data);

        return redirect()
            ->route('admin.units.edit', $unit)
            ->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy(OrganizationalUnit $unit, Official $official): RedirectResponse
    {
        $this->ensureBelongsToUnit($unit, $official);

        $this->deletePhoto($official);
        $official->delete();

        return redirect()
            ->route('admin.units.edit', $unit)
            ->with('success', 'Anggota berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'position' => ['nullable', 'string', 'max:150'],
            'fakultas' => ['nullable', 'string', 'max:150'],
            'prodi' => ['nullable', 'string', 'max:150'],
            'angkatan' => ['nullable', 'string', 'max:20'],
            'nim' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'max:255'],
            'period_id' => ['nullable', 'integer', 'exists:periods,id'],
            'email' => ['nullable', 'email', 'max:150'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'linkedin' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'photo' => ['nullable', 'image', 'max:4096'],
        ]);

        unset($data['photo']);

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function storePhoto(Request $request, OrganizationalUnit $unit): ?string
    {
        if (! $request->hasFile('photo')) {
            return null;
        }

        $file = $request->file('photo');
        $path = $file->storeAs(
            'fungsionaris/'.$unit->slug,
            Str::uuid()->toString().'.'.strtolower($file->getClientOriginalExtension() ?: 'jpg'),
            'uploads',
        );

        return 'uploads/'.$path;
    }

    private function deletePhoto(Official $official): void
    {
        if (filled($official->photo_path)) {
            Storage::disk('uploads')->delete(Str::after($official->photo_path, 'uploads/'));
        }
    }

    private function ensureBelongsToUnit(OrganizationalUnit $unit, Official $official): void
    {
        abort_unless($official->organizational_unit_id === $unit->id, 404);
    }
}
