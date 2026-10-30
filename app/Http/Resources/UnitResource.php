<?php

namespace App\Http\Resources;

use App\Models\OrganizationalUnit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin OrganizationalUnit */
class UnitResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'logo' => $this->logo_path ? asset($this->logo_path) : null,
            'sort_order' => $this->sort_order,
            'url' => route('units.show', $this),
            'officials' => OfficialResource::collection($this->whenLoaded('officials')),
        ];
    }
}
