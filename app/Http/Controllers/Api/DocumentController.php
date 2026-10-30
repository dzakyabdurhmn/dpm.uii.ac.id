<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $filters = $request->validate([
            'kategori' => ['nullable', 'string', 'max:100'],
            'tahun' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'triwulan' => ['nullable', 'integer', 'in:1,2,3,4'],
            'q' => ['nullable', 'string', 'max:100'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $documents = Document::query()
            ->published()
            ->with('category')
            ->when($filters['kategori'] ?? null, fn ($query, $slug) => $query->whereHas(
                'category',
                fn ($builder) => $builder->where('slug', $slug),
            ))
            ->when($filters['tahun'] ?? null, fn ($query, $year) => $query->where('year', (int) $year))
            ->when($filters['triwulan'] ?? null, fn ($query, $quarter) => $query->where('quarter', (int) $quarter))
            ->when($filters['q'] ?? null, fn ($query, $term) => $query->where('title', 'like', "%{$term}%"))
            ->orderByDesc('year')
            ->orderByDesc('quarter')
            ->latest('published_at')
            ->paginate($filters['per_page'] ?? 15)
            ->withQueryString();

        return DocumentResource::collection($documents)
            ->additional(['meta' => [
                'categories' => $this->categoryMeta(),
                'years' => Document::query()
                    ->published()
                    ->whereNotNull('year')
                    ->distinct()
                    ->orderByDesc('year')
                    ->pluck('year')
                    ->map(fn ($year) => (int) $year),
                'quarters' => Document::QUARTERS,
            ]])
            ->response();
    }

    /**
     * Daftar kategori + jumlah dokumen, untuk sidebar filter.
     */
    public function categories(): JsonResponse
    {
        return response()->json(['data' => $this->categoryMeta()]);
    }

    /**
     * Laporan keuangan dikelompokkan per tahun & triwulan.
     */
    public function reports(): JsonResponse
    {
        $documents = Document::query()
            ->published()
            ->with('category')
            ->whereHas('category', fn ($query) => $query->where('slug', 'laporan-keuangan'))
            ->orderByDesc('year')
            ->orderBy('quarter')
            ->get();

        $grouped = $documents
            ->groupBy(fn (Document $document) => $document->year ?? 0)
            ->map(fn ($items, $year) => [
                'year' => $year === 0 ? null : (int) $year,
                'quarters' => collect([1, 2, 3, 4])->map(fn (int $quarter) => [
                    'quarter' => $quarter,
                    'label' => Document::QUARTERS[$quarter],
                    'documents' => DocumentResource::collection(
                        $items->where('quarter', $quarter)->values()
                    )->resolve(),
                ])->all(),
            ])
            ->values();

        return response()->json(['data' => $grouped]);
    }

    public function download(Document $document): RedirectResponse
    {
        abort_unless($document->isPublished(), 404);

        $document->registerDownload();

        return redirect()->away($document->download_url);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function categoryMeta(): array
    {
        return DocumentCategory::query()
            ->withCount(['documents' => fn ($query) => $query->published()])
            ->orderBy('sort_order')
            ->get()
            ->map(fn (DocumentCategory $category) => [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'description' => $category->description,
                'total' => $category->documents_count,
                'endpoint' => '/api/documents?kategori='.$category->slug,
            ])
            ->all();
    }
}
