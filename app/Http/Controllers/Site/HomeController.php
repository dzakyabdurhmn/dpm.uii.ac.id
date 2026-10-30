<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\LegalProduct;
use App\Models\OrganizationalUnit;
use App\Models\Post;
use App\Models\SiteContent;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('site.home', [
            'latestLegal' => LegalProduct::query()
                ->active()
                ->ordered()
                ->limit(4)
                ->get(),
            'latestDocuments' => Document::query()
                ->published()
                ->with('category')
                ->latest('published_at')
                ->limit(4)
                ->get(),
            'latestNews' => Post::query()
                ->published()
                ->with('category')
                ->whereHas('category', fn ($query) => $query->where('slug', 'kegiatan'))
                ->latest('published_at')
                ->limit(4)
                ->get(),
            'latestAnnouncements' => Post::query()
                ->published()
                ->with('category')
                ->whereHas('category', fn ($query) => $query->where('slug', 'pengumuman'))
                ->latest('published_at')
                ->limit(3)
                ->get(),
            'units' => OrganizationalUnit::query()
                ->active()
                ->whereIn('type', ['badan', 'lembaga'])
                ->orderBy('sort_order')
                ->get(),
            'contentSections' => SiteContent::query()
                ->whereIn('key', array_keys(SiteContent::SECTIONS))
                ->whereNotNull('body')
                ->where('body', '!=', '')
                ->get()
                ->keyBy('key'),
            'financialCategories' => DocumentCategory::query()
                ->where('group', 'Dana')
                ->whereHas('documents', fn ($query) => $query->published())
                ->orderBy('sort_order')
                ->get(),
        ]);
    }
}
