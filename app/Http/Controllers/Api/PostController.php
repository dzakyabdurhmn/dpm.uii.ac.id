<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $filters = $request->validate([
            'jenis' => ['nullable', 'string', Rule::in(array_keys(Post::SOCIALIZATION_TYPES))],
            'q' => ['nullable', 'string', 'max:100'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);

        $posts = Post::query()
            ->published()
            ->when($filters['jenis'] ?? null, fn ($query, $type) => $query->where('type', $type))
            ->when($filters['q'] ?? null, fn ($query, $term) => $query->where('title', 'like', "%{$term}%"))
            ->latest('published_at')
            ->paginate($filters['per_page'] ?? 9)
            ->withQueryString();

        return PostResource::collection($posts)->response();
    }

    public function show(Post $post): JsonResponse
    {
        abort_unless($post->isPublished(), 404);

        return response()->json([
            'data' => (new PostResource($post))->resolve(),
            'related' => PostResource::collection(
                Post::query()
                    ->published()
                    ->whereKeyNot($post->getKey())
                    ->latest('published_at')
                    ->limit(3)
                    ->get()
            )->resolve(),
        ]);
    }
}
