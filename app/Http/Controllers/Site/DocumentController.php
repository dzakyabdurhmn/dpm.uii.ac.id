<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Period;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class DocumentController extends Controller
{
    /**
     * Jenis publikasi yang tampil di halaman Dokumen dan Publikasi.
     *
     * @var array<string, string>
     */
    private const PUBLICATION_TYPES = [
        'keputusan' => 'Keputusan',
        'ketetapan' => 'Ketetapan',
        'laporan' => 'Laporan Kinerja',
        'dokumen' => 'Dokumen Resmi',
    ];

    /**
     * Dokumen dan Publikasi: satu arsip untuk keputusan, ketetapan, laporan
     * kinerja, dan dokumen resmi DPM UII, dikelompokkan per periode.
     */
    public function index(Request $request): View
    {
        $categories = DocumentCategory::query()->orderBy('sort_order')->get();
        $categoryType = $categories->mapWithKeys(
            fn (DocumentCategory $category): array => [$category->id => $this->publicationType($category)],
        );

        $categoryIdsByType = collect(self::PUBLICATION_TYPES)->map(
            fn (string $label, string $key): array => $categories
                ->filter(fn (DocumentCategory $category): bool => $this->publicationType($category) === $key)
                ->pluck('id')
                ->all(),
        );

        $totalCategoryCounts = Document::query()
            ->published()
            ->selectRaw('document_category_id, count(*) as aggregate')
            ->groupBy('document_category_id')
            ->pluck('aggregate', 'document_category_id');

        $typeCounts = collect(self::PUBLICATION_TYPES)->map(
            fn (string $label, string $key): int => (int) $totalCategoryCounts
                ->only($categoryIdsByType[$key])
                ->sum(),
        );

        $periods = Period::query()->orderByDesc('starts_on')->orderByDesc('name')->get();

        $periodDocCounts = Document::query()
            ->published()
            ->selectRaw('period_id, count(*) as aggregate')
            ->groupBy('period_id')
            ->pluck('aggregate', 'period_id');

        $selectedPeriod = $this->selectedPeriod($request, $periods, $periodDocCounts);

        $type = $this->queryString($request, 'jenis');
        if ($type === null || ! array_key_exists($type, self::PUBLICATION_TYPES)) {
            $type = 'semua';
        }

        $search = $this->queryString($request, 'q');

        $documents = Document::query()
            ->published()
            ->with(['category.parent'])
            ->when($selectedPeriod, fn ($query) => $query->where('period_id', $selectedPeriod->id))
            ->when($type !== 'semua', fn ($query) => $query->whereIn('document_category_id', $categoryIdsByType[$type]))
            ->when($search, fn ($query) => $query->where(function ($query) use ($search): void {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            }))
            ->orderByDesc('published_at')
            ->orderByDesc('year')
            ->orderBy('title')
            ->get();

        $periodCategoryCounts = Document::query()
            ->published()
            ->when($selectedPeriod, fn ($query) => $query->where('period_id', $selectedPeriod->id))
            ->selectRaw('document_category_id, count(*) as aggregate')
            ->groupBy('document_category_id')
            ->pluck('aggregate', 'document_category_id');

        $periodTypeCounts = collect(self::PUBLICATION_TYPES)->map(
            fn (string $label, string $key): int => (int) $periodCategoryCounts
                ->filter(fn (int|string $count, int|string $categoryId): bool => ($categoryType[$categoryId] ?? 'dokumen') === $key)
                ->sum(),
        );

        $groups = collect(self::PUBLICATION_TYPES)
            ->map(fn (string $label, string $key): array => [
                'key' => $key,
                'label' => $label,
                'documents' => $documents
                    ->filter(fn (Document $document): bool => $this->publicationType($document->category) === $key)
                    ->values(),
            ])
            ->filter(fn (array $group): bool => $group['documents']->isNotEmpty())
            ->values();

        return view('site.documents.publications', [
            'types' => self::PUBLICATION_TYPES,
            'typeCounts' => $typeCounts,
            'periodTypeCounts' => $periodTypeCounts,
            'periods' => $periods,
            'periodDocCounts' => $periodDocCounts,
            'selectedPeriod' => $selectedPeriod,
            'groups' => $groups,
            'totalCount' => $documents->count(),
            'filters' => [
                'periode' => $selectedPeriod?->id ?? 'all',
                'jenis' => $type,
                'q' => $search,
            ],
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
     * Satu kategori di dalam grup Dana: distribusi, LPJ, atau LHA.
     */
    public function danaCategory(Request $request, DocumentCategory $category): View
    {
        abort_unless($category->group === 'Dana', 404);

        return $this->listing($request, $category->slug, $category);
    }

    /**
     * Halaman LPJ (Laporan Pertanggungjawaban).
     */
    public function lpj(Request $request): View
    {
        $documents = Document::query()
            ->published()
            ->with('category')
            ->whereHas('category', fn ($q) => $q->where('group', 'Dana')->where('slug', 'lpj'))
            ->orderByDesc('year')
            ->orderByDesc('quarter')
            ->latest('published_at')
            ->get();

        return view('site.documents.lpj', [
            'documents' => $documents,
            'type' => 'lpj',
        ]);
    }

    /**
     * Halaman LHA (Laporan Hasil Audit).
     */
    public function lha(Request $request): View
    {
        $documents = Document::query()
            ->published()
            ->with('category')
            ->whereHas('category', fn ($q) => $q->where('group', 'Dana')->where('slug', 'lha'))
            ->orderByDesc('year')
            ->orderByDesc('quarter')
            ->latest('published_at')
            ->get();

        return view('site.documents.lha', [
            'documents' => $documents,
            'type' => 'lha',
        ]);
    }

    public function download(Document $document): RedirectResponse
    {
        abort_unless($document->isPublished(), 404);

        $document->registerDownload();

        return redirect()->away($document->download_url);
    }

    private function publicationType(?DocumentCategory $category): string
    {
        if ($category === null) {
            return 'dokumen';
        }

        return match ($category->slug) {
            'surat-ketetapan' => 'ketetapan',
            'laporan-kinerja' => 'laporan',
            'surat-keputusan' => 'keputusan',
            default => $category->parent?->slug === 'surat-keputusan'
                ? 'keputusan'
                : match ($category->group) {
                    'Keputusan' => 'keputusan',
                    'Kinerja', 'Laporan' => 'laporan',
                    default => 'dokumen',
                },
        };
    }

    /**
     * @param  Collection<int, Period>  $periods
     * @param  Collection<int|string, int>  $periodDocCounts
     */
    private function selectedPeriod(Request $request, Collection $periods, Collection $periodDocCounts): ?Period
    {
        $period = $this->queryString($request, 'periode');

        if ($period === 'all') {
            return null;
        }

        if ($period !== null && is_numeric($period)) {
            return $periods->firstWhere('id', (int) $period);
        }

        $activePeriod = Period::active();
        if ($activePeriod !== null && (int) ($periodDocCounts[$activePeriod->id] ?? 0) > 0) {
            return $activePeriod;
        }

        return $periods->first(
            fn (Period $candidate): bool => (int) ($periodDocCounts[$candidate->id] ?? 0) > 0,
        );
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
