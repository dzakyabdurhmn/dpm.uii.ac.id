<?php

namespace App\Http\Resources;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Document */
class DocumentResource extends JsonResource
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
            'description' => $this->description,
            'category' => $this->whenLoaded('category', fn () => $this->category ? [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ] : null),
            'year' => $this->year,
            'quarter' => $this->quarter,
            'quarter_label' => $this->quarter_label,
            'file' => [
                'url' => $this->download_url,
                'extension' => $this->extension,
                'size' => $this->size,
                'human_size' => $this->human_size,
                'is_external' => $this->isExternal(),
            ],
            'download_url' => route('documents.download', $this),
            'downloads' => $this->downloads,
            'published_at' => $this->published_at?->toIso8601String(),
        ];
    }
}
