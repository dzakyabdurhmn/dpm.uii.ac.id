<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LegalProductResource;
use App\Models\LegalProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LegalProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $filters = $request->validate([
            'type' => ['nullable', Rule::in(array_keys(LegalProduct::TYPES))],
            'year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'q' => ['nullable', 'string', 'max:100'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $products = LegalProduct::query()
            ->active()
            ->with(['amends', 'period'])
            ->when($filters['type'] ?? null, fn ($query, $type) => $query->ofType($type))
            ->when($filters['year'] ?? null, fn ($query, $year) => $query->where('year', (int) $year))
            ->when($filters['q'] ?? null, fn ($query, $term) => $query->where('title', 'like', "%{$term}%"))
            ->ordered()
            ->paginate($filters['per_page'] ?? 20)
            ->withQueryString();

        return LegalProductResource::collection($products)
            ->additional(['meta' => ['types' => $this->typeMeta()]])
            ->response();
    }

    /**
     * Ringkasan tiap jenis: dipakai FE untuk tab/segment.
     */
    public function types(): JsonResponse
    {
        return response()->json(['data' => $this->typeMeta()]);
    }

    /**
     * Kelompokkan per tahun untuk jenis bernomor (PKM/PDPM) — siap dipakai
     * halaman arsip tanpa perlu grouping di FE.
     */
    public function grouped(Request $request): JsonResponse
    {
        $filters = $request->validate([
            'type' => ['required', Rule::in(array_keys(LegalProduct::TYPES))],
        ]);

        $products = LegalProduct::query()
            ->active()
            ->with(['amends'])
            ->ofType($filters['type'])
            ->ordered()
            ->get();

        $groups = $products
            ->groupBy(fn (LegalProduct $item) => $item->year ?? 0)
            ->map(fn ($items, $year) => [
                'year' => $year === 0 ? null : (int) $year,
                'total' => $items->count(),
                'items' => LegalProductResource::collection($items)->resolve(),
            ])
            ->values();

        return response()->json([
            'data' => [
                'type' => $filters['type'],
                'meta' => $this->typeMeta()[$filters['type']] ?? null,
                'groups' => $groups,
            ],
        ]);
    }

    public function download(LegalProduct $legalProduct): RedirectResponse
    {
        abort_unless($legalProduct->is_published, 404);
        abort_unless($legalProduct->hasFile(), 404);

        $legalProduct->registerDownload();

        return redirect()->away($legalProduct->download_url);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    private function typeMeta(): array
    {
        $counts = LegalProduct::query()
            ->active()
            ->selectRaw('type, count(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

        $meta = [];

        foreach (LegalProduct::TYPES as $key => $config) {
            $meta[$key] = [
                'key' => $key,
                'label' => $config['label'],
                'name' => $config['name'],
                'description' => $config['description'],
                'numbered' => $config['numbered'],
                'total' => (int) ($counts[$key] ?? 0),
                'url' => '/produk-hukum#'.$key,
                'endpoint' => '/api/legal-products?type='.$key,
            ];
        }

        return $meta;
    }
}
