<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
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

        $officials = $unit->officials()
            ->where('is_active', true)
            ->with('period')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        // Anggota dikelompokkan per periode kepengurusan; periode aktif tampil
        // lebih dulu, lalu periode lama secara menurun.
        $periods = Period::query()
            ->whereIn('id', $officials->pluck('period_id')->filter()->unique())
            ->orderByDesc('is_active')
            ->orderByDesc('name')
            ->get();

        return view('site.units.show', [
            'unit' => $unit,
            'officials' => $officials,
            'periods' => $periods,
            'unassigned' => $officials->whereNull('period_id'),
            'units' => OrganizationalUnit::query()->active()->whereNull('parent_id')->orderBy('sort_order')->get(),
        ]);
    }
}
