<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Konten halaman statis: hanya Sambutan Ketua yang punya editor WYSIWYG.
 * Seksinya tetap (tidak bisa ditambah/dihapus).
 */
class PageContentController extends Controller
{
    public function index(): View
    {
        $contents = PageContent::query()->get()->keyBy('key');

        return view('admin.page-contents.index', [
            'sections' => PageContent::SECTIONS,
            'contents' => $contents,
        ]);
    }

    public function edit(string $section): View
    {
        $config = PageContent::configFor($section);

        abort_if($config === null, 404);

        return view('admin.page-contents.form', [
            'section' => $section,
            'config' => $config,
            'content' => PageContent::query()->where('key', $section)->first(),
        ]);
    }

    public function update(Request $request, string $section): RedirectResponse
    {
        $config = PageContent::configFor($section);

        abort_if($config === null, 404);

        $data = $request->validate([
            'body' => ['nullable', 'string'],
        ]);

        PageContent::query()->updateOrCreate(
            ['key' => $section],
            [
                'title' => $config['title'],
                'subtitle' => $config['subtitle'],
                'body' => $data['body'] ?? null,
            ],
        );

        return redirect()
            ->route('admin.page-contents.edit', $section)
            ->with('success', 'Konten "'.$config['title'].'" berhasil diperbarui.');
    }
}
