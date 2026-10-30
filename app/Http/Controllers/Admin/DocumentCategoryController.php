<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DocumentCategoryController extends Controller
{
    /**
     * Grup yang dikenali navigasi publik.
     */
    public const GROUPS = ['Dana', 'Laporan', 'Keputusan', 'Produk Hukum'];

    public function index(): View
    {
        return view('admin.document-categories.index', [
            'categories' => DocumentCategory::query()
                ->withCount('documents')
                ->orderBy('sort_order')
                ->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.document-categories.form', [
            'category' => new DocumentCategory(['sort_order' => 0]),
            'groups' => self::GROUPS,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $category = DocumentCategory::query()->create($this->validated($request));

        return redirect()
            ->route('admin.document-categories.index')
            ->with('success', 'Kategori "'.$category->name.'" berhasil dibuat.');
    }

    public function edit(DocumentCategory $documentCategory): View
    {
        return view('admin.document-categories.form', [
            'category' => $documentCategory,
            'groups' => self::GROUPS,
        ]);
    }

    public function update(Request $request, DocumentCategory $documentCategory): RedirectResponse
    {
        $documentCategory->update($this->validated($request, $documentCategory));

        return redirect()
            ->route('admin.document-categories.index')
            ->with('success', 'Kategori "'.$documentCategory->name.'" berhasil diperbarui.');
    }

    public function destroy(DocumentCategory $documentCategory): RedirectResponse
    {
        if ($documentCategory->documents()->exists()) {
            return back()->with('error', 'Kategori masih punya dokumen. Pindahkan dokumennya terlebih dahulu.');
        }

        $documentCategory->delete();

        return redirect()
            ->route('admin.document-categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, ?DocumentCategory $category = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'group' => ['nullable', 'string', 'max:40'],
            'description' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        return $data;
    }
}
