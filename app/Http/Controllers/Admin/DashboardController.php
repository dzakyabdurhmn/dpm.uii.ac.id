<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Document;
use App\Models\LegalProduct;
use App\Models\Media;
use App\Models\Official;
use App\Models\OrganizationalUnit;
use App\Models\Period;
use App\Models\Post;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $period = Period::query()->find(session('admin_period_id')) ?? Period::active();

        return view('admin.dashboard', [
            'period' => $period,
            'stats' => [
                'posts' => Post::query()->count(),
                'posts_published' => Post::query()->published()->count(),
                'posts_draft' => Post::query()->where('status', Post::STATUS_DRAFT)->count(),
                'announcements' => Post::query()->published()->category('pengumuman')->count(),
                'legal_products' => LegalProduct::query()->count(),
                'documents' => Document::query()->count(),
                'documents_published' => Document::query()->published()->count(),
                'media' => Media::query()->count(),
                'units' => OrganizationalUnit::query()->active()->count(),
                'members' => $period
                    ? Official::query()->where('period_id', $period->id)->where('is_active', true)->count()
                    : Official::query()->where('is_active', true)->count(),
                'complaints_new' => Complaint::query()->where('status', 'baru')->count(),
            ],
            'latestPosts' => Post::query()->latest('id')->limit(5)->get(),
            'latestLegalProducts' => LegalProduct::query()->ordered()->limit(5)->get(),
            'latestComplaints' => Complaint::query()->latest('id')->limit(5)->get(),
            'unitsWithoutMembers' => OrganizationalUnit::query()
                ->active()
                ->when($period, fn ($query) => $query->whereDoesntHave(
                    'officials',
                    fn ($inner) => $inner->where('period_id', $period->id)->where('is_active', true),
                ))
                ->orderBy('sort_order')
                ->get(),
        ]);
    }
}
