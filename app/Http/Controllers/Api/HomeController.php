<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DocumentResource;
use App\Http\Resources\LegalProductResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\UnitResource;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\LegalProduct;
use App\Models\OrganizationalUnit;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Semua data yang dibutuhkan halaman beranda FE dalam satu request.
     * Di-cache 1 menit agar ringan; perubahan konten muncul dalam 1 menit.
     */
    public function index(): JsonResponse
    {
        $payload = Cache::remember('api.home', now()->addMinute(), function (): array {
            $reports = Document::query()
                ->published()
                ->with('category')
                ->whereHas('category', fn ($query) => $query->where('slug', 'laporan-keuangan'))
                ->orderByDesc('year')
                ->orderBy('quarter')
                ->get();

            return [
                'stats' => [
                    'legal_products' => LegalProduct::query()->active()->count(),
                    'documents' => Document::query()->published()->count(),
                    'units' => OrganizationalUnit::query()->active()->count(),
                    'posts' => Post::query()->published()->count(),
                ],
                'legal_products' => [
                    'types' => $this->legalTypeMeta(),
                    'latest' => LegalProductResource::collection(
                        LegalProduct::query()
                            ->active()
                            ->with('amends')
                            ->whereNotNull('number')
                            ->ordered()
                            ->limit(4)
                            ->get()
                    )->resolve(),
                ],
                'documents' => [
                    'categories' => $this->documentCategories(),
                    'latest' => DocumentResource::collection(
                        Document::query()
                            ->published()
                            ->with('category')
                            ->latest('published_at')
                            ->limit(5)
                            ->get()
                    )->resolve(),
                ],
                'reports' => $reports
                    ->groupBy(fn (Document $document) => $document->year ?? 0)
                    ->map(fn ($items, $year) => [
                        'year' => $year === 0 ? null : (int) $year,
                        'items' => DocumentResource::collection($items)->resolve(),
                    ])
                    ->values()
                    ->all(),
                'posts' => PostResource::collection(
                    Post::query()
                        ->published()
                        ->with('category')
                        ->latest('published_at')
                        ->limit(3)
                        ->get()
                )->resolve(),
                'units' => UnitResource::collection(
                    OrganizationalUnit::query()
                        ->active()
                        ->whereNull('parent_id')
                        ->with(['officials' => fn ($query) => $query->where('is_active', true)])
                        ->orderBy('sort_order')
                        ->limit(6)
                        ->get()
                )->resolve(),
            ];
        });

        return response()->json(['data' => $payload]);
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    private function legalTypeMeta(): array
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
                'endpoint' => '/api/legal-products?type='.$key,
            ];
        }

        return $meta;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function documentCategories(): array
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
