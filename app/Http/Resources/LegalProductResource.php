<?php

namespace App\Http\Resources;

use App\Models\LegalProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin LegalProduct */
class LegalProductResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'type_label' => $this->type_label,
            'type_name' => LegalProduct::TYPES[$this->type]['name'] ?? null,
            'is_numbered' => $this->isNumbered(),
            'number' => $this->number,
            'year' => $this->year,
            'regulation_number' => $this->regulation_number,
            'heading' => $this->heading,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'is_amendment' => $this->isAmendment(),
            'amends' => $this->whenLoaded('amends', fn () => $this->amends ? [
                'id' => $this->amends->id,
                'heading' => $this->amends->heading,
                'slug' => $this->amends->slug,
            ] : null),
            'period' => $this->whenLoaded('period', fn () => $this->period ? [
                'id' => $this->period->id,
                'name' => $this->period->name,
            ] : null),
            'file' => [
                'url' => $this->download_url,
                'extension' => $this->extension,
                'size' => $this->size,
                'human_size' => $this->human_size,
                'available' => $this->hasFile(),
            ],
            'download_url' => $this->hasFile() ? route('legal-products.download', $this) : null,
            'downloads' => $this->downloads,
            'published_at' => $this->published_at?->toIso8601String(),
        ];
    }
}
