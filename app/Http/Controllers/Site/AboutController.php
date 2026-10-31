<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\OrganizationalUnit;
use App\Models\SiteContent;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function show(string $section): View
    {
        // Handle visi-misi with custom static view
        if ($section === 'visi-misi') {
            return view('site.visi-misi');
        }

        // Handle sejarah with custom static view
        if ($section === 'sejarah') {
            return view('site.sejarah');
        }

        // Handle kedudukan-tugas-wewenang with custom static view
        if ($section === 'kedudukan-tugas-wewenang') {
            return view('site.kedudukan-tugas-wewenang');
        }

        $config = SiteContent::configFor($section);

        abort_if($config === null, 404);

        $units = collect();
        $officials = collect();

        if ($config['show_units']) {
            $units = OrganizationalUnit::query()
                ->active()
                ->whereNull('parent_id')
                ->orderBy('sort_order')
                ->get();
        }

        if ($config['show_officials']) {
            $officials = OrganizationalUnit::query()
                ->active()
                ->with(['officials' => fn ($query) => $query->where('is_active', true)])
                ->orderBy('sort_order')
                ->get()
                ->filter(fn (OrganizationalUnit $unit) => $unit->officials->isNotEmpty());
        }

        return view('site.about', [
            'section' => $section,
            'title' => $config['title'],
            'subtitle' => $config['subtitle'],
            'content' => SiteContent::query()->where('key', $section)->first(),
            'units' => $units,
            'officials' => $officials,
        ]);
    }
}
