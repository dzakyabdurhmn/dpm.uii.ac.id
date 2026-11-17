<?php

namespace App\Http\Middleware;

use App\Models\Period;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Menyimpan "periode kerja" admin di sesi.
 *
 * Sebelumnya periode hanya bisa diganti dengan mengaktifkan periode lain secara
 * global, sehingga admin harus bolak-balik pindah periode (dan situs ikut
 * berubah). Sekarang admin memilih periode sekali lewat pemilih di header, dan
 * semua halaman admin (alat kelengkapan, dsb.) mengikuti pilihan itu.
 */
class ShareAdminPeriod
{
    public function handle(Request $request, Closure $next): Response
    {
        $periods = Period::query()->orderByDesc('name')->get();

        $period = $periods->firstWhere('id', (int) $request->session()->get('admin_period_id'))
            ?? $periods->firstWhere('is_active', true)
            ?? $periods->first();

        if ($period !== null && $request->session()->get('admin_period_id') !== $period->id) {
            $request->session()->put('admin_period_id', $period->id);
        }

        View::share('adminPeriod', $period);
        View::share('adminPeriods', $periods);

        return $next($request);
    }
}
