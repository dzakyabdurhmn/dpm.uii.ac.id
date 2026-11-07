<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\LegalProduct;
use App\Models\Period;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LegalProductController extends Controller
{
    public function index(Request $request): View
    {
        return $this->listing($request);
    }

    /**
     * Show legal products filtered by type (pdkm, gbhkm, pkm, pdpm).
     */
    public function type(Request $request, string $type): View
    {
        abort_unless(array_key_exists($type, LegalProduct::TYPES), 404);

        // PDKM uses a dedicated view with custom design
        if ($type === 'pdkm') {
            return $this->showPdkm($request);
        }

        // GBHKM disusun per periode kepengurusan, bukan per edisi/nomor.
        if ($type === 'gbhkm') {
            return $this->showGbhkm();
        }

        return $this->listing($request, $type);
    }

    /**
     * Show PDKM with dedicated custom view.
     */
    private function showPdkm(Request $request): View
    {
        $products = LegalProduct::query()
            ->active()
            ->with(['amends', 'period'])
            ->where('type', 'pdkm')
            ->orderByDesc('year')
            ->orderBy('sort_order')
            ->get();

        abort_unless($products->isNotEmpty(), 404);

        $product = $products->first();

        return view('site.legal-products.pdkm', [
            'product' => $product,
            'products' => $products,
            'types' => LegalProduct::TYPES,
            'currentType' => 'pdkm',
        ]);
    }

    /**
     * GBHKM berlaku satu naskah per periode kepengurusan DPM UII.
     */
    private function showGbhkm(): View
    {
        $products = LegalProduct::query()
            ->active()
            ->ofType('gbhkm')
            ->with('period')
            ->orderByDesc('year')
            ->orderBy('sort_order')
            ->get();

        $periods = Period::query()
            ->orderByDesc('starts_on')
            ->orderByDesc('name')
            ->get();

        $byPeriod = $products
            ->filter(fn (LegalProduct $product) => $product->period_id !== null)
            ->keyBy('period_id');

        $entries = $periods->map(fn (Period $period) => $this->gbhkmEntry($byPeriod->get($period->id), $period));

        // Data lama tanpa relasi periode tetap ditampilkan sebagai arsip.
        foreach ($products->whereNull('period_id') as $product) {
            $entries->push($this->gbhkmEntry($product, null));
        }

        abort_unless($entries->isNotEmpty(), 404);

        $defaultIndex = $entries->search(fn (array $entry) => $entry['hasDoc']);

        return view('site.legal-products.gbhkm', [
            'entries' => $entries->values(),
            'defaultIndex' => $defaultIndex === false ? 0 : $defaultIndex,
            'types' => LegalProduct::TYPES,
            'currentType' => 'gbhkm',
        ]);
    }

    /**
     * @return array{label: string, running: bool, status: string, enacted: ?string, forum: ?string, title: ?string, url: ?string, download: ?string, size: ?string, extension: ?string, hasDoc: bool}
     */
    private function gbhkmEntry(?LegalProduct $product, ?Period $period): array
    {
        $enacted = $product?->enacted_on ?? $product?->published_at;

        $status = 'Belum ditetapkan';

        if ($product !== null) {
            $status = $product->status === 'tidak_aktif'
                ? 'Tidak Berlaku'
                : ($period?->is_active ? 'Berjalan' : 'Arsip');
        }

        return [
            'label' => $period?->name ?? ($product?->year ? (string) $product->year : 'Tanpa periode'),
            'running' => (bool) $period?->is_active,
            'status' => $status,
            'enacted' => $enacted?->locale('id')->translatedFormat('j F Y') ?? ($product?->year ? (string) $product->year : null),
            'forum' => $product?->forum,
            'title' => $product?->title,
            'url' => $product?->download_url,
            'download' => $product !== null && $product->hasFile() ? route('legal-products.download', $product) : null,
            'size' => $product?->human_size,
            'extension' => $product?->extension,
            'hasDoc' => $product !== null && $product->hasFile(),
        ];
    }

    private function listing(Request $request, ?string $type = null): View
    {
        $products = LegalProduct::query()
            ->active()
            ->with(['amends', 'period'])
            ->ordered()
            ->when($type, fn ($query) => $query->where('type', $type))
            ->get();

        // PDKM and GBHKM are single constitutional documents, so they are shown as
        // one "berlaku" card each. PKM and PDPM are numbered per year and grouped.
        $singles = collect(['pdkm', 'gbhkm'])->mapWithKeys(fn (string $type) => [
            $type => $products->firstWhere('type', $type),
        ]);

        $numbered = collect(['pkm', 'pdpm'])->mapWithKeys(fn (string $type) => [
            $type => $products->where('type', $type)->groupBy(fn (LegalProduct $item) => $item->year ?? 'Tanpa tahun'),
        ]);

        // List of all unique years in descending order
        $years = $products
            ->whereNotNull('year')
            ->pluck('year')
            ->unique()
            ->sortDesc()
            ->values();

        $yearCounts = $products
            ->whereNotNull('year')
            ->groupBy('year')
            ->map(fn ($group) => $group->count());

        $typeCounts = $products
            ->groupBy('type')
            ->map(fn ($group) => $group->count());

        $selectedYear = $this->queryString($request, 'tahun');
        $selectedType = $type ?? $this->queryString($request, 'jenis');
        $selectedType = array_key_exists($selectedType ?? '', LegalProduct::TYPES) ? $selectedType : null;

        // Single view handles both cases via @if($currentType) conditional
        return view('site.legal-products.index', [
            'products' => $products,
            'singles' => $singles,
            'numbered' => $numbered,
            'years' => $years,
            'yearCounts' => $yearCounts,
            'typeCounts' => $typeCounts,
            'selectedYear' => $selectedYear,
            'selectedType' => $selectedType,
            'total' => $products->count(),
            'latest' => $products->take(5),
            'types' => LegalProduct::TYPES,
            'currentType' => $type,
        ]);
    }

    public function download(LegalProduct $legalProduct): RedirectResponse
    {
        abort_unless($legalProduct->is_published, 404);

        abort_unless($legalProduct->hasFile(), 404);

        $legalProduct->registerDownload();

        return redirect()->away($legalProduct->download_url);
    }

    protected function queryString(Request $request, string $key): ?string
    {
        $value = $request->query($key);
        if (is_array($value)) {
            return $value[0] ?? null;
        }

        return $value !== '' ? $value : null;
    }
}
