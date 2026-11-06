<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        return $this->listing(null);
    }

    /**
     * Berita Kegiatan: kegiatan dan agenda DPM UII serta parsip mahasiswa.
     */
    public function activities(): View
    {
        return $this->listing('berita-kegiatan');
    }

    /**
     * Pengumuman: seruan aksi, informasi resmi, dan pemberitahuan untuk KM UII.
     */
    public function announcements(): View
    {
        return $this->listing('pengumuman');
    }

    /**
     * Sosialisasi: sosialisasi peraturan, kebijakan, program, dan kegiatan.
     */
    public function socialization(Request $request): View
    {
        $type = $request->query('jenis');
        $category = PostCategory::query()->where('slug', Post::SOCIALIZATION_CATEGORY_SLUG)->first();

        $posts = Post::query()
            ->published()
            ->with('category')
            ->where('post_category_id', $category->id ?? 0)
            ->when($type && isset(Post::SOCIALIZATION_TYPES[$type]), fn ($q) => $q->where('type', $type))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $heading = $category?->name ?? 'Sosialisasi';
        if ($type && isset(Post::SOCIALIZATION_TYPES[$type])) {
            $heading .= ' — '.Post::SOCIALIZATION_TYPES[$type];
        }

        return view('site.news.index', [
            'posts' => $posts,
            'heading' => $heading,
            'description' => $category?->description ?? 'Sosialisasi peraturan, kebijakan, program, dan kegiatan DPM UII.',
            'socializationTypes' => Post::SOCIALIZATION_TYPES,
            'selectedType' => $type,
        ]);
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

        $descriptions = [
            'berita-kegiatan' => 'Kegiatan dan agenda DPM UII serta parsip mahasiswa.',
            'pengumuman' => 'Seruan aksi, informasi resmi, dan pemberitahuan untuk KM UII.',
            'sosialisasi' => 'Sosialisasi peraturan, kebijakan, program, dan kegiatan DPM UII.',
        ];

        return view('site.news.index', [
            'posts' => $posts,
            'heading' => $category?->name ?? 'Berita',
            'description' => $category?->description ?? ($descriptions[$categorySlug] ?? 'Kegiatan yang diikuti DPM UII, agenda legislasi, dan kabar terbaru dari parlemen mahasiswa.'),
        ]);
    }
}
