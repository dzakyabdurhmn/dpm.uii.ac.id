<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Official;
use App\Models\OrganizationalUnit;
use App\Models\Period;
use App\Models\SiteContent;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function show(string $section): View
    {
        // Handle visi-misi with custom static view
        if ($section === 'visi-misi') {
            return view('site.visi-misi');
        }

        // Handle sejarah with custom static view
        if ($section === 'sejarah') {
            return view('site.sejarah');
        }

        // Handle kedudukan-tugas-wewenang with custom static view
        if ($section === 'kedudukan-tugas-wewenang') {
            return view('site.kedudukan-tugas-wewenang');
        }

        // Handle struktur with custom static view
        if ($section === 'struktur') {
            return view('site.struktur');
        }

        // Handle profil-dewan with custom view
        if ($section === 'profil-dewan') {
            $periods = Period::query()->orderByDesc('name')->get(['id', 'name']);
            $activePeriod = Period::active()->first(['id', 'name']);

            // Get all needed units in one query
            $pimpinanUnit = OrganizationalUnit::query()
                ->active()
                ->where('type', 'pimpinan')
                ->first(['id', 'name', 'abbreviation', 'description']);

            $komisiUnits = OrganizationalUnit::query()
                ->active()
                ->where('type', 'komisi')
                ->orderBy('sort_order')
                ->get(['id', 'name', 'abbreviation', 'description']);

            // Build unit IDs array (filter out null)
            $unitIds = collect([$pimpinanUnit])->whereNotNull()->merge($komisiUnits)->pluck('id');

            // Get all officials for all periods in one query
            $allOfficials = Official::query()
                ->whereIn('period_id', $periods->pluck('id'))
                ->where('is_active', true)
                ->whereIn('organizational_unit_id', $unitIds)
                ->orderBy('sort_order')
                ->get(['id', 'name', 'position', 'fakultas', 'prodi', 'angkatan', 'photo_path', 'organizational_unit_id', 'period_id', 'sort_order']);

            // Group officials by period_id and organizational_unit_id
            $officialsByPeriodAndUnit = $allOfficials->groupBy(['period_id', 'organizational_unit_id']);

            $profilData = [];
            foreach ($periods as $period) {
                $pimpinan = collect();
                $komisi = [];

                if ($pimpinanUnit) {
                    $pimpinan = ($officialsByPeriodAndUnit[$period->id][$pimpinanUnit->id] ?? collect())
                        ->map(function ($o) {
                            return [
                                'name' => $o->name,
                                'position' => $o->position,
                                'fakultas' => $o->fakultas,
                                'prodi' => $o->prodi,
                                'angkatan' => $o->angkatan,
                                'photo_path' => $o->photo_path,
                            ];
                        })->toArray();
                }

                foreach ($komisiUnits as $unit) {
                    $members = ($officialsByPeriodAndUnit[$period->id][$unit->id] ?? collect())
                        ->map(function ($o) {
                            return [
                                'name' => $o->name,
                                'position' => $o->position,
                                'fakultas' => $o->fakultas,
                                'prodi' => $o->prodi,
                                'angkatan' => $o->angkatan,
                                'photo_path' => $o->photo_path,
                            ];
                        })->toArray();

                    if (! empty($members)) {
                        $komisi[] = [
                            'name' => $unit->name,
                            'roman' => $unit->abbreviation,
                            'description' => $unit->description,
                            'members' => $members,
                        ];
                    }
                }

                $profilData[$period->name] = [
                    'pimpinan' => $pimpinan,
                    'komisi' => $komisi,
                ];
            }

            return view('site.profil-dewan', [
                'profilData' => $profilData,
                'activePeriod' => $activePeriod?->name,
            ]);
        }

        $config = SiteContent::configFor($section);

        abort_if($config === null, 404);

        $units = collect();
        $officials = collect();

        if ($config['show_units']) {
            $units = OrganizationalUnit::query()
                ->active()
                ->whereNull('parent_id')
                ->orderBy('sort_order')
                ->get();
        }

        if ($config['show_officials']) {
            $officials = OrganizationalUnit::query()
                ->active()
                ->with(['officials' => fn ($query) => $query->where('is_active', true)])
                ->orderBy('sort_order')
                ->get()
                ->filter(fn (OrganizationalUnit $unit) => $unit->officials->isNotEmpty());
        }

        return view('site.about', [
            'section' => $section,
            'title' => $config['title'],
            'subtitle' => $config['subtitle'],
            'content' => SiteContent::query()->where('key', $section)->first(),
            'units' => $units,
            'officials' => $officials,
        ]);
    }
}
