<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Period;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanKinerjaController extends Controller
{
    /** @var array<int, string> */
    private const CATEGORY_SLUGS = ['surat-ketetapan', 'ketetapan', 'laporan-kinerja', 'dokumen'];

    public function index(Request $request): View
    {
        $documents = Document::query()
            ->published()
            ->with(['category.parent', 'period'])
            ->where(function (Builder $query) {
                $query->whereHas('category', fn (Builder $q) => $q->whereIn('slug', self::CATEGORY_SLUGS))
                    ->orWhereHas('category', fn (Builder $q) => $q->where('group', 'Kinerja'));
            })
            ->latest('published_at')
            ->get();

        $groups = $documents->groupBy(fn (Document $document) => $document->period?->name ?? 'Tahun '.($document->year ?? '—'));

        return view('site.laporan-kinerja', [
            'documents' => $documents,
            'periods' => Period::query()->orderByDesc('name')->get(),
            'kinerjaCategories' => DocumentCategory::query()
                ->whereIn('slug', self::CATEGORY_SLUGS)
                ->orWhere('group', 'Kinerja')
                ->get(),
            'section' => 'laporan-kinerja',
            'groups' => $groups,
        ]);
    }
}
