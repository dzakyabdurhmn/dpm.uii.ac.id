<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanKinerjaController extends Controller
{
    public function index(Request $request): View
    {
        // Filter kategori yang relevan untuk Laporan Kinerja
        $kinerjaCategories = DocumentCategory::whereIn('slug', [
            'surat-ketetapan', 'ketetapan', 'laporan-kinerja', 'dokumen',
        ])->orWhere('group', 'Kinerja')->get();

        $documents = Document::query()
            ->published()
            ->with(['category.parent'])
            ->whereHas('category', fn ($q) => $q->whereIn('slug', ['surat-ketetapan', 'ketetapan', 'laporan-kinerja', 'dokumen']))
            ->orWhereHas('category', fn ($q) => $q->where('group', 'Kinerja'))
            ->latest('published_at')
            ->get();

        // Group by year (format: 2025/2026)
        $grouped = $documents->groupBy(fn ($d) => $d->year ?? date('Y'));

        $periods = Period::query()->orderByDesc('name')->get();

        return view('site.laporan-kinerja', [
            'documents' => $documents,
            'grouped' => $grouped,
            'periods' => $periods,
            'section' => 'laporan-kinerja',
        ]);
    }
}
