<?php

namespace App\Http\Resources;

use App\Models\Official;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Official */
class OfficialResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'position' => $this->position,
            'description' => $this->description,
            'period' => $this->whenLoaded('period', fn () => $this->period ? [
                'id' => $this->period->id,
                'name' => $this->period->name,
            ] : null),
            'photo' => $this->photo_url,
            'email' => $this->email,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'sort_order' => $this->sort_order,
        ];
    }
}
