<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Konten halaman statis. Seksinya tetap (tidak bisa ditambah/dihapus),
 * admin hanya mengubah isi tiap seksi.
 */
class ContentController extends Controller
{
    public function index(): View
    {
        return view('admin.contents.index', [
            'sections' => SiteContent::SECTIONS,
            'contents' => SiteContent::query()->get()->keyBy('key'),
        ]);
    }

    public function edit(string $section): View
    {
        $config = SiteContent::configFor($section);

        abort_if($config === null, 404);

        return view('admin.contents.form', [
            'section' => $section,
            'config' => $config,
            'content' => SiteContent::query()->where('key', $section)->first(),
        ]);
    }

    public function update(Request $request, string $section): RedirectResponse
    {
        $config = SiteContent::configFor($section);

        abort_if($config === null, 404);

        $data = $request->validate([
            'body' => ['nullable', 'string'],
        ]);

        SiteContent::query()->updateOrCreate(
            ['key' => $section],
            [
                'title' => $config['title'],
                'body' => $data['body'] ?? null,
            ],
        );

        return redirect()
            ->route('admin.contents.edit', $section)
            ->with('success', 'Konten "'.$config['title'].'" berhasil diperbarui.');
    }
}
