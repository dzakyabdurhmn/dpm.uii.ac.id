<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DocumentRequest;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Period;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DocumentController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));
        $categoryId = $request->query('kategori');

        $documents = Document::query()
            ->with(['category', 'period'])
            ->when($search !== '', fn ($query) => $query->where('title', 'like', "%{$search}%"))
            ->when($categoryId, fn ($query) => $query->where('document_category_id', $categoryId))
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.documents.index', [
            'documents' => $documents,
            'categories' => DocumentCategory::query()->orderBy('sort_order')->get(),
            'search' => $search,
            'categoryId' => $categoryId,
        ]);
    }

    public function create(Request $request): View
    {
        $defaultCategory = filled($request->query('kategori'))
            ? DocumentCategory::query()->where('slug', $request->query('kategori'))->first()
            : null;

        return view('admin.documents.form', [
            'document' => new Document([
                'document_category_id' => $defaultCategory?->id,
                'published_at' => now(),
                'year' => now()->year,
            ]),
            'categories' => DocumentCategory::query()->orderBy('sort_order')->get(),
            'periods' => Period::query()->orderByDesc('name')->get(),
        ]);
    }

    public function store(DocumentRequest $request): RedirectResponse
    {
        $document = Document::query()->create($this->payload($request));

        return redirect()
            ->route('admin.documents.edit', $document)
            ->with('success', 'Dokumen "'.$document->title.'" berhasil ditambahkan.');
    }

    public function edit(Document $document): View
    {
        return view('admin.documents.form', [
            'document' => $document,
            'categories' => DocumentCategory::query()->orderBy('sort_order')->get(),
            'periods' => Period::query()->orderByDesc('name')->get(),
        ]);
    }

    public function update(DocumentRequest $request, Document $document): RedirectResponse
    {
        $document->update($this->payload($request, $document));

        return redirect()
            ->route('admin.documents.edit', $document)
            ->with('success', 'Dokumen "'.$document->title.'" berhasil diperbarui.');
    }

    public function destroy(Document $document): RedirectResponse
    {
        if (filled($document->file_path)) {
            Storage::disk('uploads')->delete(Str::after($document->file_path, 'uploads/'));
        }

        $document->delete();

        return redirect()
            ->route('admin.documents.index')
            ->with('success', 'Dokumen berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(DocumentRequest $request, ?Document $document = null): array
    {
        $data = collect($request->validated())->except(['file'])->all();

        if ($request->hasFile('file')) {
            if ($document && filled($document->file_path)) {
                Storage::disk('uploads')->delete(Str::after($document->file_path, 'uploads/'));
            }

            $file = $request->file('file');
            $path = $file->storeAs(
                'documents/'.now()->format('Y/m'),
                Str::uuid()->toString().'.'.strtolower($file->getClientOriginalExtension() ?: 'bin'),
                'uploads',
            );

            $data['file_path'] = 'uploads/'.$path;
            $data['mime_type'] = $file->getMimeType() ?: $file->getClientMimeType();
            $data['size'] = (int) $file->getSize();
        }

        return $data;
    }
}
