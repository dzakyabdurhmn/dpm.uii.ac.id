<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\LegalProduct;
use App\Models\Media;
use App\Models\Period;
use App\Models\Post;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'posts' => Post::query()->count(),
                'posts_published' => Post::query()->published()->count(),
                'legal_products' => LegalProduct::query()->count(),
                'documents' => Document::query()->count(),
                'documents_published' => Document::query()->published()->count(),
                'periods' => Period::query()->count(),
                'media' => Media::query()->count(),
            ],
            'activePeriod' => Period::query()->where('is_active', true)->first(),
            'latestPosts' => Post::query()->latest('id')->limit(5)->get(),
            'latestLegalProducts' => LegalProduct::query()->ordered()->limit(5)->get(),
            'latestDocuments' => Document::query()->with('category')->latest('id')->limit(5)->get(),
        ]);
    }
}
