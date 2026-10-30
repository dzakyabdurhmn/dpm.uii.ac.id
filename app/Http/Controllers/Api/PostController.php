<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $filters = $request->validate([
            'kategori' => ['nullable', 'string', 'max:100'],
            'q' => ['nullable', 'string', 'max:100'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);

        $posts = Post::query()
            ->published()
            ->with('category')
            ->when($filters['kategori'] ?? null, fn ($query, $slug) => $query->whereHas(
                'category',
                fn ($builder) => $builder->where('slug', $slug),
            ))
            ->when($filters['q'] ?? null, fn ($query, $term) => $query->where('title', 'like', "%{$term}%"))
            ->latest('published_at')
            ->paginate($filters['per_page'] ?? 9)
            ->withQueryString();

        return PostResource::collection($posts)
            ->additional(['meta' => ['categories' => $this->categoryMeta()]])
            ->response();
    }

    public function show(Post $post): JsonResponse
    {
        abort_unless($post->isPublished(), 404);

        $post->load('category');

        return response()->json([
            'data' => (new PostResource($post))->resolve(),
            'related' => PostResource::collection(
                Post::query()
                    ->published()
                    ->with('category')
                    ->whereKeyNot($post->getKey())
                    ->latest('published_at')
                    ->limit(3)
                    ->get()
            )->resolve(),
        ]);
    }

    public function categories(): JsonResponse
    {
        return response()->json(['data' => $this->categoryMeta()]);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function categoryMeta(): array
    {
        return PostCategory::query()
            ->withCount(['posts' => fn ($query) => $query->published()])
            ->orderBy('name')
            ->get()
            ->map(fn (PostCategory $category) => [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'total' => $category->posts_count,
                'endpoint' => '/api/posts?kategori='.$category->slug,
            ])
            ->all();
    }
}
