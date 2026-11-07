<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        return $this->listing('berita');
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

        $posts = Post::query()
            ->published()
            ->where('type', '!=', null)
            ->when($type && isset(Post::SOCIALIZATION_TYPES[$type]), fn ($q) => $q->where('type', $type))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $heading = 'Sosialisasi';
        if ($type && isset(Post::SOCIALIZATION_TYPES[$type])) {
            $heading .= ' — '.Post::SOCIALIZATION_TYPES[$type];
        }

        return view('site.news.index', [
            'posts' => $posts,
            'heading' => $heading,
            'description' => 'Sosialisasi peraturan, kebijakan, program, dan kegiatan DPM UII.',
            'socializationTypes' => Post::SOCIALIZATION_TYPES,
            'selectedType' => $type,
        ]);
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

    private function listing(string $type): View
    {
        $descriptions = [
            'berita' => 'Kegiatan yang diikuti DPM UII, agenda legislasi, dan kabar terbaru dari parlemen mahasiswa.',
            'berita-kegiatan' => 'Kegiatan dan agenda DPM UII serta parsip mahasiswa.',
            'pengumuman' => 'Seruan aksi, informasi resmi, dan pemberitahuan untuk KM UII.',
        ];

        $headings = [
            'berita' => 'Berita',
            'berita-kegiatan' => 'Berita Kegiatan',
            'pengumuman' => 'Pengumuman',
        ];

        $posts = Post::query()
            ->published()
            ->when($type !== 'berita', fn ($q) => $q->where('type', $type))
            ->latest('published_at')
            ->paginate(9);

        return view('site.news.index', [
            'posts' => $posts,
            'heading' => $headings[$type] ?? 'Berita',
            'description' => $descriptions[$type] ?? $descriptions['berita'],
        ]);
    }
}
