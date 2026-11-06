<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Period;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentController extends Controller
{
    public function index(Request $request): View
    {
        return $this->listing($request, $this->queryString($request, 'kategori'));
    }

    /**
     * Laporan kinerja: hasil Foraslak DPM UII.
     */
    public function reports(Request $request): View
    {
        $year = $this->queryString($request, 'tahun');
        $quarter = $this->queryString($request, 'triwulan');
        $period = $this->queryString($request, 'periode');
        $search = $this->queryString($request, 'q');

        $documents = Document::query()
            ->published()
            ->with('category')
            ->whereHas('category', fn ($query) => $query->where('slug', 'laporan-kinerja'))
            ->when($year, fn ($query) => $query->where('year', (int) $year))
            ->when($quarter, fn ($query) => $query->where('quarter', (int) $quarter))
            ->when($period, fn ($query) => $query->where('period_id', (int) $period))
            ->when($search, fn ($query) => $query->where('title', 'like', "%{$search}%"))
            ->orderByDesc('year')
            ->orderByDesc('quarter')
            ->latest('published_at')
            ->paginate(15)
            ->withQueryString();

        // Handle AJAX request for live search
        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return view('site.documents._list', [
                'documents' => $documents,
            ])->render();
        }

        $periods = Period::query()->orderByDesc('name')->get();
        $activePeriod = Period::active();

        // Count documents per period
        $periodCounts = [];
        foreach ($periods as $p) {
            $periodCounts[$p->id] = Document::query()
                ->published()
                ->whereHas('category', fn ($query) => $query->where('slug', 'laporan-kinerja'))
                ->where('period_id', $p->id)
                ->count();
        }

        $selectedPeriod = $period ? $periods->firstWhere('id', (int) $period) : $activePeriod;

        return view('site.documents.kinerja', [
            'documents' => $documents,
            'periods' => $periods,
            'activePeriod' => $activePeriod,
            'selectedPeriod' => $selectedPeriod,
            'periodCounts' => $periodCounts,
            'totalCount' => $documents->total(),
            'filters' => [
                'kategori' => 'laporan-kinerja',
                'tahun' => $year,
                'triwulan' => $quarter,
                'periode' => $period,
                'q' => $search,
            ],
        ]);
    }

    /**
     * Semua keputusan & ketetapan DPM UII (grup Keputusan), filterable by periode.
     */
    public function decisions(Request $request): View
    {
        $documents = $this->documents($request, null)
            ->whereHas('category', fn ($query) => $query->where('group', 'Keputusan'))
            ->paginate(15)
            ->withQueryString();

        // Handle AJAX request for live search
        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return view('site.documents._list', [
                'documents' => $documents,
            ])->render();
        }

        return view('site.documents.index', [
            'documents' => $documents,
            'categories' => $this->categoryList(),
            'years' => $this->years(),
            'periods' => $this->periods(),
            'filters' => $this->filters($request, null),
            'heading' => 'Keputusan',
            'description' => 'Surat keputusan, ketetapan, keputusan badan, DPM Fakultas, dan lembaga DPM UII per periode.',
        ]);
    }

    /**
     * Semua dokumen dalam grup "Dana" (distribusi, LPJ, LHA, laporan keuangan).
     */
    public function dana(Request $request): View
    {
        $documents = $this->documents($request, null)
            ->whereHas('category', fn ($query) => $query->where('group', 'Dana'))
            ->paginate(15)
            ->withQueryString();

        return view('site.documents.index', [
            'documents' => $documents,
            'categories' => $this->categoryList(),
            'years' => $this->years(),
            'periods' => $this->periods(),
            'filters' => $this->filters($request, null),
            'heading' => 'Dana',
            'description' => 'Distribusi dana, laporan pertanggungjawaban (LPJ), dan laporan hasil audit (LHA) KM UII.',
        ]);
    }

    /**
     * Arsip kategori apa pun: /dokumen/kategori/{slug}.
     */
    public function category(Request $request, DocumentCategory $category): View
    {
        return $this->listing($request, $category->slug, $category);
    }

    /**
     * Satu kategori di dalam grup Dana: distribusi, LPJ, atau LHA.
     */
    public function danaCategory(Request $request, DocumentCategory $category): View
    {
        abort_unless($category->group === 'Dana', 404);

        return $this->listing($request, $category->slug, $category);
    }

    public function download(Document $document): RedirectResponse
    {
        abort_unless($document->isPublished(), 404);

        $document->registerDownload();

        return redirect()->away($document->download_url);
    }

    private function listing(Request $request, ?string $categorySlug, ?DocumentCategory $category = null): View
    {
        $category ??= $categorySlug
            ? DocumentCategory::query()->where('slug', $categorySlug)->first()
            : null;

        $documents = $this->documents($request, $categorySlug)
            ->paginate(15)
            ->withQueryString();

        // Handle AJAX request for live search
        if ($request->ajax() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return view('site.documents._list', [
                'documents' => $documents,
            ])->render();
        }

        return view('site.documents.index', [
            'documents' => $documents,
            'categories' => $this->categoryList(),
            'years' => $this->years(),
            'periods' => $this->periods(),
            'filters' => $this->filters($request, $categorySlug ?? $category?->slug),
            'heading' => $category?->name ?? 'Dokumen & laporan',
            'description' => $category?->description
                ?? 'Produk hukum, surat keputusan, laporan kinerja, dan pengelolaan dana DPM UII.',
        ]);
    }

    private function documents(Request $request, ?string $categorySlug)
    {
        $year = $this->queryString($request, 'tahun');
        $quarter = $this->queryString($request, 'triwulan');
        $period = $this->queryString($request, 'periode');
        $search = $this->queryString($request, 'q');

        return Document::query()
            ->published()
            ->with('category')
            ->when($categorySlug, fn ($query) => $query->whereHas(
                'category',
                fn ($builder) => $builder->where('slug', $categorySlug),
            ))
            ->when($year, fn ($query) => $query->where('year', (int) $year))
            ->when($quarter, fn ($query) => $query->where('quarter', (int) $quarter))
            ->when($period, fn ($query) => $query->where('period_id', (int) $period))
            ->when($search, fn ($query) => $query->where('title', 'like', "%{$search}%"))
            ->orderByDesc('year')
            ->orderByDesc('quarter')
            ->latest('published_at');
    }

    /**
     * @return array{kategori: string|null, tahun: string|null, triwulan: string|null, periode: string|null, q: string|null}
     */
    private function filters(Request $request, ?string $categorySlug): array
    {
        return [
            'kategori' => $categorySlug ?? $this->queryString($request, 'kategori'),
            'tahun' => $this->queryString($request, 'tahun'),
            'triwulan' => $this->queryString($request, 'triwulan'),
            'periode' => $this->queryString($request, 'periode'),
            'q' => $this->queryString($request, 'q'),
        ];
    }

    private function categoryList()
    {
        return DocumentCategory::query()->orderBy('sort_order')->get();
    }

    private function periods()
    {
        return Period::query()->orderByDesc('name')->get();
    }

    private function years()
    {
        return Document::query()
            ->published()
            ->whereNotNull('year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');
    }
}
