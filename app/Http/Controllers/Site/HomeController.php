<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\OrganizationalUnit;
use App\Models\Post;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('site.home', [
            'latestNews' => Post::query()
                ->published()
                ->category('berita-kegiatan', 'berita')
                ->latest('published_at')
                ->limit(4)
                ->get(),
            'latestAnnouncements' => Post::query()
                ->published()
                ->category('pengumuman')
                ->latest('published_at')
                ->limit(4)
                ->get(),
            // Kartu "Alat Kelengkapan" di Beranda memakai data yang sama dengan
            // halaman /alat-kelengkapan, supaya unit baru langsung muncul.
            'units' => OrganizationalUnit::query()
                ->active()
                ->whereNull('parent_id')
                ->whereIn('type', ['lembaga', 'badan'])
                ->orderBy('sort_order')
                ->get(),
        ]);
    }
}
