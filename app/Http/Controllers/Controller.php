<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class Controller
{
    /**
     * Read a query parameter as a single trimmed string.
     *
     * Query strings can arrive as arrays when the frontend repeats the key
     * (?tahun=2024&tahun=2023 or ?tahun[]=2024). Filters only ever need one
     * value, so take the first usable one instead of crashing on an array.
     */
    protected function queryString(Request $request, string $key): ?string
    {
        $value = $request->query($key);

        if (is_array($value)) {
            $value = collect($value)->first(fn ($item) => is_scalar($item) && filled((string) $item));
        }

        if (! is_scalar($value)) {
            return null;
        }

        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }
}
