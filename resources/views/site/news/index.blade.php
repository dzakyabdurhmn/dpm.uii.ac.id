@extends('layouts.site')

@section('title', ($heading ?? 'Berita').' — '.($siteSettings['site_name'] ?? 'DPM UII'))

@section('content')
    <style>
        .news-page { color: rgba(255,255,255,.85); }
        .news-hero { background: #001E43; color: #fff; }
        .news-wrap { width: min(1180px, calc(100% - 40px)); margin: 0 auto; }
        .news-hero-inner { padding: 68px 0 64px; }
        .news-eyebrow { margin: 0 0 10px; color: rgba(255,255,255,.72); font-size: 12px; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; }
        .news-hero h1 { margin: 0; color: #fff; font-size: clamp(30px, 4.6vw, 44px); font-weight: 800; letter-spacing: -.03em; }
        .news-hero-copy { max-width: 720px; margin: 14px 0 0; color: rgba(255,255,255,.82); font-size: 15px; line-height: 1.85; }
        .news-section { padding: 48px 0 70px; background: #001E43; }
        .news-grid { display: grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap: 18px; }
        .news-card { overflow: hidden; border: 1px solid rgba(255,255,255,.1); border-radius: 8px; background: #001A3A; transition: border-color .2s, background .2s, transform .2s; }
        .news-card:hover { border-color: rgba(255,255,255,.32); background: #002451; transform: translateY(-2px); }
        .news-card-image { display: block; width: 100%; height: 190px; object-fit: cover; background: #001E43; }
        .news-card-image-empty { display: block; height: 6px; background: linear-gradient(90deg, rgba(255,255,255,.18), transparent); }
        .news-card-body { padding: 18px 20px 20px; }
        .news-card-meta { display: flex; flex-wrap: wrap; gap: 8px 12px; margin: 0 0 10px; color: rgba(255,255,255,.62); font-size: 11px; }
        .news-card-meta span + span::before { content: '·'; margin-right: 12px; color: rgba(255,255,255,.38); }
        .news-card-title { display: block; color: #fff; font-size: 16px; font-weight: 800; line-height: 1.5; }
        .news-card-excerpt { display: -webkit-box; overflow: hidden; margin: 10px 0 0; color: rgba(255,255,255,.76); font-size: 13px; line-height: 1.8; -webkit-box-orient: vertical; -webkit-line-clamp: 3; }
        .news-card-link { display: inline-flex; margin-top: 16px; color: #fff; font-size: 12px; font-weight: 700; text-decoration: underline; text-underline-offset: 3px; }
        .news-empty { padding: 28px; border: 1px dashed rgba(255,255,255,.24); border-radius: 8px; text-align: center; color: rgba(255,255,255,.72); font-size: 13px; }
        .news-pagination { margin-top: 36px; display: flex; justify-content: center; }
        .news-pagination nav { display: flex; gap: 8px; }
        .news-pagination .page-link { display: inline-flex; align-items: center; justify-content: center; min-width: 38px; height: 38px; padding: 0 12px; border-radius: 6px; border: 1px solid rgba(255,255,255,.18); color: rgba(255,255,255,.8); font-size: 12px; }
        .news-pagination .page-item.active .page-link { border-color: rgba(255,255,255,.52); color: #fff; }
        .news-pagination .page-link:hover { border-color: rgba(255,255,255,.38); color: #fff; }
        @media (max-width: 980px) { .news-grid { grid-template-columns: repeat(2, minmax(0,1fr)); } }
        @media (max-width: 640px) { .news-wrap { width: min(100% - 28px, 1180px); } .news-hero-inner { padding: 48px 0 46px; } .news-section { padding: 34px 0 52px; } .news-grid { grid-template-columns: 1fr; } }
    </style>

    <div class="news-page">
        <section class="news-hero">
            <div class="news-wrap news-hero-inner">
                <p class="news-eyebrow">Kabar Parlemen</p>
                <h1>{{ $heading ?? 'Berita' }}</h1>
                <p class="news-hero-copy">{{ $description ?? 'Informasi terbaru seputar kegiatan legislatif, keputusan, dan agenda DPM UII.' }}</p>
            </div>
        </section>

        <section class="news-section">
            <div class="news-wrap">
                @if ($posts->isEmpty())
                    <div class="news-empty">Belum ada berita yang dipublikasikan.</div>
                @else
                    <div class="news-grid">
                        @foreach ($posts as $post)
                            <article class="news-card">
                                <a href="{{ $post->url }}">
                                    @if ($post->featured_image)
                                        <img class="news-card-image" src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}" loading="lazy">
                                    @else
                                        <span class="news-card-image-empty"></span>
                                    @endif
                                </a>
                                <div class="news-card-body">
                                    <div class="news-card-meta">
                                        @if ($post->published_at)<span>{{ $post->published_at->translatedFormat('d F Y') }}</span>@endif
                                        @if ($post->category)<span>{{ $post->category->name }}</span>@endif
                                    </div>
                                    <a class="news-card-title" href="{{ $post->url }}">{{ $post->title }}</a>
                                    @if ($post->excerpt)<p class="news-card-excerpt">{{ $post->excerpt }}</p>@endif
                                    <a class="news-card-link" href="{{ $post->url }}">Baca selengkapnya</a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <div class="news-pagination">
                        {{ $posts->links() }}
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
