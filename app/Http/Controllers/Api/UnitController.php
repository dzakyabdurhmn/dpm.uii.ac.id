<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UnitResource;
use App\Models\OrganizationalUnit;
use Illuminate\Http\JsonResponse;

class UnitController extends Controller
{
    public function index(): JsonResponse
    {
        $units = OrganizationalUnit::query()
            ->active()
            ->with(['officials' => fn ($query) => $query->where('is_active', true)])
            ->orderBy('sort_order')
            ->get();

        return UnitResource::collection($units)->response();
    }

    public function show(OrganizationalUnit $unit): JsonResponse
    {
        abort_unless($unit->is_active, 404);

        $unit->load(['officials' => fn ($query) => $query->where('is_active', true)]);

        return (new UnitResource($unit))->response();
    }
}
