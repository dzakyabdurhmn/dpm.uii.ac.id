<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        return $this->listing(null);
    }

    /**
     * Pengumuman: seruan aksi, informasi resmi, dan pemberitahuan untuk KM UII.
     */
    public function announcements(): View
    {
        return $this->listing('pengumuman');
    }

    /**
     * Arsip kategori apa pun: /berita/kategori/{slug}.
     */
    public function category(PostCategory $postCategory): View
    {
        return $this->listing($postCategory->slug);
    }

    public function show(Post $post): View
    {
        abort_unless($post->isPublished(), 404);

        return view('site.news.show', [
            'post' => $post,
            'related' => Post::query()
                ->published()
                ->whereKeyNot($post->getKey())
                ->latest('published_at')
                ->limit(3)
                ->get(),
        ]);
    }

    private function listing(?string $categorySlug): View
    {
        $category = $categorySlug
            ? PostCategory::query()->where('slug', $categorySlug)->first()
            : null;

        $posts = Post::query()
            ->published()
            ->with('category')
            ->when($category, fn ($query) => $query->where('post_category_id', $category->id))
            ->latest('published_at')
            ->paginate(9);

        return view('site.news.index', [
            'posts' => $posts,
            'heading' => $category?->name ?? 'Berita',
            'description' => $category?->description
                ?? 'Kegiatan yang diikuti DPM UII, agenda legislasi, dan kabar terbaru dari parlemen mahasiswa.',
        ]);
    }
}
