<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Post */
class PostResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'body' => $this->when($request->routeIs('api.posts.show'), $this->body),
            'category' => $this->whenLoaded('category', fn () => $this->category ? [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ] : null),
            'featured_image' => $this->featured_image ? asset($this->featured_image) : null,
            'published_at' => $this->published_at?->toIso8601String(),
            'url' => route('news.show', $this),
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
        ];
    }
}
