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

        $rules = [
            'body' => ['nullable', 'string'],
        ];

        // Sambutan punya blok identitas penanda tangan di bawah editor.
        if ($section === 'sambutan') {
            $rules += [
                'signature_role' => ['nullable', 'string', 'max:100'],
                'signature_name' => ['nullable', 'string', 'max:150'],
                'signature_fakultas' => ['nullable', 'string', 'max:150'],
                'signature_nim' => ['nullable', 'string', 'max:30'],
            ];
        }

        $data = $request->validate($rules);

        $attributes = [
            'title' => $config['title'],
            'subtitle' => $config['subtitle'],
            'body' => $data['body'] ?? null,
        ];

        if ($section === 'sambutan') {
            $attributes += [
                'signature_role' => $data['signature_role'] ?? null,
                'signature_name' => $data['signature_name'] ?? null,
                'signature_fakultas' => $data['signature_fakultas'] ?? null,
                'signature_nim' => $data['signature_nim'] ?? null,
            ];
        }

        PageContent::query()->updateOrCreate(['key' => $section], $attributes);

        return redirect()
            ->route('admin.page-contents.edit', $section)
            ->with('success', 'Konten "'.$config['title'].'" berhasil diperbarui.');
    }
}
