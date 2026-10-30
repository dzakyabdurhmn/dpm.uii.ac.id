<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.post-categories.index', [
            'categories' => PostCategory::query()->withCount('posts')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.post-categories.form', [
            'category' => new PostCategory,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $category = PostCategory::query()->create($this->validated($request));

        return redirect()
            ->route('admin.post-categories.index')
            ->with('success', 'Kategori "'.$category->name.'" berhasil dibuat.');
    }

    public function edit(PostCategory $postCategory): View
    {
        return view('admin.post-categories.form', [
            'category' => $postCategory,
        ]);
    }

    public function update(Request $request, PostCategory $postCategory): RedirectResponse
    {
        $postCategory->update($this->validated($request));

        return redirect()
            ->route('admin.post-categories.index')
            ->with('success', 'Kategori "'.$postCategory->name.'" berhasil diperbarui.');
    }

    public function destroy(PostCategory $postCategory): RedirectResponse
    {
        if ($postCategory->posts()->exists()) {
            return back()->with('error', 'Kategori masih dipakai berita. Pindahkan beritanya terlebih dahulu.');
        }

        $postCategory->delete();

        return redirect()
            ->route('admin.post-categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $data['slug'] = Str::slug($data['name']);

        return $data;
    }
}
