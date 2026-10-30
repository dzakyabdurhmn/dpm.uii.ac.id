<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Period;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PeriodController extends Controller
{
    public function index(): View
    {
        return view('admin.periods.index', [
            'periods' => Period::query()->orderByDesc('name')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.periods.form', [
            'period' => new Period([
                'name' => $this->suggestedName(),
                'is_active' => false,
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $period = Period::query()->create($this->validated($request));

        return redirect()
            ->route('admin.periods.index')
            ->with('success', 'Periode '.$period->name.' berhasil ditambahkan.');
    }

    public function edit(Period $period): View
    {
        return view('admin.periods.form', [
            'period' => $period,
        ]);
    }

    public function update(Request $request, Period $period): RedirectResponse
    {
        $period->update($this->validated($request, $period));

        return redirect()
            ->route('admin.periods.index')
            ->with('success', 'Periode '.$period->name.' berhasil diperbarui.');
    }

    public function destroy(Period $period): RedirectResponse
    {
        if ($period->is_active) {
            return back()->with('error', 'Periode aktif tidak bisa dihapus. Aktifkan periode lain terlebih dahulu.');
        }

        $period->delete();

        return redirect()
            ->route('admin.periods.index')
            ->with('success', 'Periode berhasil dihapus.');
    }

    /**
     * Jadikan periode ini satu-satunya periode aktif.
     */
    public function activate(Period $period): RedirectResponse
    {
        DB::transaction(function () use ($period): void {
            Period::query()->whereKeyNot($period->getKey())->update(['is_active' => false]);
            $period->update(['is_active' => true]);
        });

        return redirect()
            ->route('admin.periods.index')
            ->with('success', 'Periode '.$period->name.' sekarang aktif.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, ?Period $period = null): array
    {
        $request->merge(['is_active' => $request->boolean('is_active')]);

        return $request->validate([
            'name' => ['required', 'string', 'max:20', 'regex:/^\d{4}\/\d{4}$/', 'unique:periods,name'.($period ? ','.$period->id : '')],
            'starts_on' => ['nullable', 'date'],
            'ends_on' => ['nullable', 'date', 'after_or_equal:starts_on'],
            'is_active' => ['boolean'],
        ], [
            'name.regex' => 'Format periode harus tahun/tahun, contoh 2026/2027.',
        ]);
    }

    private function suggestedName(): string
    {
        $current = (int) now()->format('Y');

        return $current.'/'.($current + 1);
    }
}
