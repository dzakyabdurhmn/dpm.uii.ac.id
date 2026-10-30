<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LegalProductRequest;
use App\Models\LegalProduct;
use App\Models\Period;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LegalProductController extends Controller
{
    public function index(Request $request): View
    {
        $type = $this->queryString($request, 'jenis');
        $type = array_key_exists($type ?? '', LegalProduct::TYPES) ? $type : null;
        $search = $this->queryString($request, 'q') ?? '';

        $products = LegalProduct::query()
            ->with(['amends', 'period'])
            ->when($type, fn ($query) => $query->ofType($type))
            ->when($search !== '', fn ($query) => $query->where('title', 'like', "%{$search}%"))
            ->ordered()
            ->paginate(20)
            ->withQueryString();

        return view('admin.legal-products.index', [
            'products' => $products,
            'type' => $type,
            'search' => $search,
            'counts' => LegalProduct::query()
                ->selectRaw('type, count(*) as total')
                ->groupBy('type')
                ->pluck('total', 'type'),
        ]);
    }

    public function create(Request $request): View
    {
        $type = $this->queryString($request, 'jenis');

        return view('admin.legal-products.form', [
            'product' => new LegalProduct([
                'type' => array_key_exists($type ?? '', LegalProduct::TYPES) ? $type : 'pkm',
                'is_published' => true,
                'year' => now()->year,
            ]),
            'periods' => Period::query()->orderByDesc('name')->get(),
            'amendableOptions' => LegalProduct::query()->ordered()->get(),
            'types' => LegalProduct::TYPES,
        ]);
    }

    public function store(LegalProductRequest $request): RedirectResponse
    {
        $product = LegalProduct::query()->create($this->payload($request));

        return redirect()
            ->route('admin.legal-products.edit', $product)
            ->with('success', $product->heading.' berhasil ditambahkan.');
    }

    public function edit(LegalProduct $legalProduct): View
    {
        return view('admin.legal-products.form', [
            'product' => $legalProduct,
            'periods' => Period::query()->orderByDesc('name')->get(),
            'amendableOptions' => LegalProduct::query()
                ->ofType($legalProduct->type)
                ->whereKeyNot($legalProduct->getKey())
                ->ordered()
                ->get(),
            'types' => LegalProduct::TYPES,
        ]);
    }

    public function update(LegalProductRequest $request, LegalProduct $legalProduct): RedirectResponse
    {
        $legalProduct->update($this->payload($request, $legalProduct));

        return redirect()
            ->route('admin.legal-products.edit', $legalProduct)
            ->with('success', $legalProduct->heading.' berhasil diperbarui.');
    }

    public function destroy(LegalProduct $legalProduct): RedirectResponse
    {
        if (filled($legalProduct->file_path)) {
            Storage::disk('uploads')->delete(Str::after($legalProduct->file_path, 'uploads/'));
        }

        $legalProduct->delete();

        return redirect()
            ->route('admin.legal-products.index')
            ->with('success', 'Produk hukum berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(LegalProductRequest $request, ?LegalProduct $product = null): array
    {
        $data = collect($request->validated())->except(['file'])->all();

        if ($request->hasFile('file')) {
            if ($product && filled($product->file_path)) {
                Storage::disk('uploads')->delete(Str::after($product->file_path, 'uploads/'));
            }

            $file = $request->file('file');
            $path = $file->storeAs(
                'produk-hukum/'.now()->format('Y'),
                Str::uuid()->toString().'.'.strtolower($file->getClientOriginalExtension() ?: 'pdf'),
                'uploads',
            );

            $data['file_path'] = 'uploads/'.$path;
            $data['mime_type'] = $file->getMimeType() ?: $file->getClientMimeType();
            $data['size'] = (int) $file->getSize();
        }

        return $data;
    }
}
