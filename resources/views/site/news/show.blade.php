@extends('layouts.site')

@section('title', ($post->meta_title ?: $post->title).' — '.($siteSettings['site_name'] ?? 'DPM UII'))
@section('meta_description', $post->meta_description ?: $post->excerpt)
@if ($post->featured_image)
    @section('og_image', asset($post->featured_image))
@endif

@section('content')
    <style>
        .news-detail { color: rgba(255,255,255,.85); }
        .news-detail-wrap { width: min(860px, calc(100% - 40px)); margin: 0 auto; }
        .news-detail-hero { background: #001E43; color: #fff; }
        .news-detail-hero-inner { padding: 58px 0 48px; }
        .news-detail-breadcrumb { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; color: rgba(255,255,255,.6); font-size: 12px; }
        .news-detail-breadcrumb a { color: rgba(255,255,255,.8); }
        .news-detail-breadcrumb a:hover { color: #fff; }
        .news-detail-hero h1 { margin: 18px 0 0; color: #fff; font-size: clamp(28px, 4.8vw, 44px); font-weight: 800; line-height: 1.16; letter-spacing: -.03em; }
        .news-detail-meta { display: flex; flex-wrap: wrap; gap: 10px 16px; margin-top: 16px; color: rgba(255,255,255,.66); font-size: 12px; }
        .news-detail-meta span + span::before { content: '·'; margin-right: 16px; color: rgba(255,255,255,.38); }
        .news-detail-body-section { padding: 0 0 64px; background: #001E43; }
        .news-detail-media { width: min(1180px, calc(100% - 40px)); margin: -28px auto 0; border-radius: 8px; overflow: hidden; border: 1px solid rgba(255,255,255,.12); box-shadow: 0 30px 60px rgba(0,0,0,.35); }
        .news-detail-media img { display: block; width: 100%; height: auto; }
        .news-detail-content { margin-top: 38px; }
        .news-detail-excerpt { margin: 0 0 24px; color: rgba(255,255,255,.9); font-size: 17px; line-height: 1.9; }
        .news-detail-prose { color: rgba(255,255,255,.82); font-size: 15px; line-height: 1.95; }
        .news-detail-prose p { margin: 18px 0; }
        .news-detail-prose h2, .news-detail-prose h3, .news-detail-prose h4 { margin: 34px 0 14px; color: #fff; font-weight: 800; }
        .news-detail-prose a { color: #fff; text-decoration: underline; text-underline-offset: 4px; }
        .news-detail-prose ul, .news-detail-prose ol { margin: 18px 0; padding-left: 22px; }
        .news-detail-prose li { margin: 10px 0; }
        .news-detail-related { padding: 48px 0 70px; background: #001633; border-top: 1px solid rgba(255,255,255,.1); }
        .news-detail-related-head { display: flex; align-items: end; justify-content: space-between; margin-bottom: 20px; }
        .news-detail-related-head h2 { margin: 0; color: #fff; font-size: clamp(22px, 3vw, 28px); font-weight: 800; }
        .news-detail-related-grid { display: grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap: 16px; }
        .news-detail-related-card { display: block; padding: 18px 20px; border: 1px solid rgba(255,255,255,.1); border-radius: 8px; background: #001A3A; transition: border-color .2s, background .2s, transform .2s; }
        .news-detail-related-card:hover { border-color: rgba(255,255,255,.32); background: #002451; transform: translateY(-2px); }
        .news-detail-related-meta { color: rgba(255,255,255,.62); font-size: 11px; }
        .news-detail-related-card h3 { margin: 8px 0 0; color: #fff; font-size: 15px; font-weight: 800; line-height: 1.5; }
        @media (max-width: 980px) { .news-detail-related-grid { grid-template-columns: repeat(2, minmax(0,1fr)); } }
        @media (max-width: 640px) { .news-detail-wrap, .news-detail-media { width: min(100% - 28px, 1180px); } .news-detail-hero-inner { padding: 46px 0 38px; } .news-detail-media { margin-top: -18px; } .news-detail-related-grid { grid-template-columns: 1fr; } }
    </style>

    <div class="news-detail">
        <section class="news-detail-hero">
            <div class="news-detail-wrap news-detail-hero-inner">
                <nav class="news-detail-breadcrumb" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}">Beranda</a>
                    <span>/</span>
                    <a href="{{ route('news.index') }}">Berita</a>
                    <span>/</span>
                    <span>{{ $post->title }}</span>
                </nav>
                <h1>{{ $post->title }}</h1>
                <div class="news-detail-meta">
                    @if ($post->published_at)<span>{{ $post->published_at->translatedFormat('d F Y') }}</span>@endif
                </div>
            </div>
        </section>

        <section class="news-detail-body-section">
            @if ($post->featured_image)
                <figure class="news-detail-media">
                    <img src="{{ asset($post->featured_image) }}" alt="{{ $post->title }}">
                </figure>
            @endif

            <article class="news-detail-wrap news-detail-content">
                @if ($post->excerpt)
                    <p class="news-detail-excerpt">{{ $post->excerpt }}</p>
                @endif
                <div class="news-detail-prose">
                    {!! $post->body !!}
                </div>
            </article>
        </section>

        @if ($related->isNotEmpty())
            <section class="news-detail-related">
                <div class="news-detail-wrap">
                    <div class="news-detail-related-head">
                        <h2>Berita Lainnya</h2>
                    </div>
                    <div class="news-detail-related-grid">
                        @foreach ($related as $item)
                            <a class="news-detail-related-card" href="{{ $item->url }}">
                                <div class="news-detail-related-meta">{{ $item->published_at?->translatedFormat('d M Y') }}</div>
                                <h3>{{ $item->title }}</h3>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </div>
@endsection
