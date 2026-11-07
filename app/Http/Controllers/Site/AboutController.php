<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function show(string $section): View
    {
        if ($section === 'visi-misi') {
            return view('site.visi-misi');
        }

        if ($section === 'sejarah') {
            return view('site.sejarah');
        }

        if ($section === 'kedudukan-tugas-wewenang') {
            return view('site.kedudukan-tugas-wewenang');
        }

        if ($section === 'struktur') {
            return view('site.struktur');
        }

        if ($section === 'sambutan') {
            $content = PageContent::query()->where('key', 'sambutan')->first();

            return view('site.about', [
                'section' => 'sambutan',
                'title' => 'Sambutan',
                'subtitle' => 'Sambutan Ketua DPM UII',
                'content' => $content,
                'units' => collect(),
                'officials' => collect(),
            ]);
        }

        abort(404);
    }
}
