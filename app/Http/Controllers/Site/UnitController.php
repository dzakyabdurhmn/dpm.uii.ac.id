<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Official;
use App\Models\OrganizationalUnit;
use App\Models\Period;
use Illuminate\View\View;

class UnitController extends Controller
{
    public function index(): View
    {
        return view('site.units.index', [
            'units' => OrganizationalUnit::query()
                ->active()
                ->whereNull('parent_id')
                ->whereIn('type', ['lembaga', 'badan', 'direktorat', 'komisi', 'pimpinan'])
                ->orderBy('sort_order')
                ->get(),
        ]);
    }

    public function show(OrganizationalUnit $unit): View
    {
        abort_unless($unit->is_active, 404);

        $periods = Period::query()->orderByDesc('name')->get(['id', 'name', 'is_active']);
        $activePeriod = Period::query()->where('is_active', true)->first(['id', 'name']);

        $periodIds = $periods->pluck('id')->toArray();

        // Get all officials for all periods for this unit
        $allOfficials = Official::query()
            ->where('organizational_unit_id', $unit->id)
            ->where('is_active', true)
            ->whereIn('period_id', $periodIds)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name', 'position', 'fakultas', 'prodi', 'angkatan', 'nim', 'description', 'photo_path', 'email', 'instagram', 'linkedin', 'period_id', 'sort_order']);

        // Group by period
        $officialsByPeriod = $allOfficials->groupBy('period_id');

        // Periode tanpa anggota tidak ditampilkan.
        $periods = $periods->filter(fn (Period $period): bool => ($officialsByPeriod[$period->id] ?? collect())->isNotEmpty())->values();

        $unitData = [];
        foreach ($periods as $period) {
            $members = $officialsByPeriod[$period->id] ?? collect();
            $lead = $members->first(
                fn (Official $official): bool => (bool) preg_match('/^(kepala|ketua|presiden|direktur)\b/i', (string) $official->position),
            );

            $unitData[$period->name] = [
                'period' => $period,
                'unit_name' => $unit->short_name,
                'lead' => $lead ? $this->memberData($lead) : null,
                'members' => $members
                    ->reject(fn (Official $official): bool => $lead !== null && $official->id === $lead->id)
                    ->map(fn (Official $official): array => $this->memberData($official))
                    ->values()
                    ->all(),
            ];
        }

        // Also get unassigned
        $unassigned = Official::query()
            ->where('organizational_unit_id', $unit->id)
            ->where('is_active', true)
            ->whereNull('period_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name', 'position', 'fakultas', 'prodi', 'angkatan', 'nim', 'description', 'photo_path', 'email', 'instagram', 'linkedin', 'sort_order'])
            ->map(fn (Official $official): array => $this->memberData($official))
            ->toArray();

        return view('site.units.show', [
            'unit' => $unit,
            'unitData' => $unitData,
            'activePeriod' => $activePeriod?->name,
            'unassigned' => $unassigned,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function memberData(Official $official): array
    {
        return [
            'name' => $official->name,
            'position' => $official->position,
            'fakultas' => $official->fakultas,
            'prodi' => $official->prodi,
            'angkatan' => $official->angkatan,
            'nim' => $official->nim,
            'description' => $official->description,
            'photo_path' => $official->photo_path,
            'email' => $official->email,
            'instagram' => $official->instagram,
            'linkedin' => $official->linkedin,
            'sort_order' => $official->sort_order,
        ];
    }
}
