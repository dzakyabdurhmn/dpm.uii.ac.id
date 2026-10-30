@extends('layouts.site')

@section('title', $title.' — '.($siteSettings['site_name'] ?? 'DPM UII'))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($content->body ?? $title), 150))

@section('content')
    <style>
        .about-page { color: rgba(255,255,255,.85); }
        .about-hero { background: #001E43; color: #fff; }
        .about-wrap { width: min(1180px, calc(100% - 40px)); margin: 0 auto; }
        .about-hero-inner { padding: 68px 0 64px; }
        .about-eyebrow { margin: 0 0 10px; color: rgba(255,255,255,.72); font-size: 12px; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; }
        .about-hero h1 { margin: 0; color: #fff; font-size: clamp(30px, 4.6vw, 44px); font-weight: 800; letter-spacing: -.03em; }
        .about-hero-copy { max-width: 720px; margin: 14px 0 0; color: rgba(255,255,255,.82); font-size: 15px; line-height: 1.85; }
        .about-section { padding: 48px 0 70px; background: #001E43; }
        .about-grid { display: grid; grid-template-columns: minmax(0, 2fr) minmax(280px, 1fr); gap: 24px; align-items: start; }
        .about-panel { border: 1px solid rgba(255,255,255,.1); border-radius: 8px; background: #001A3A; overflow: hidden; }
        .about-panel-body { padding: clamp(24px, 4vw, 40px); }
        .about-prose { color: rgba(255,255,255,.84); font-size: 15px; line-height: 1.95; }
        .about-prose p { margin: 18px 0; }
        .about-prose h2, .about-prose h3, .about-prose h4 { margin: 34px 0 14px; color: #fff; font-weight: 800; }
        .about-prose a { color: #fff; text-decoration: underline; text-underline-offset: 4px; }
        .about-prose ul, .about-prose ol { margin: 18px 0; padding-left: 22px; }
        .about-prose li { margin: 10px 0; }
        .about-aside { display: grid; gap: 16px; }
        .about-aside-card { border: 1px solid rgba(255,255,255,.1); border-radius: 8px; background: #001A3A; overflow: hidden; }
        .about-aside-head { padding: 18px 22px 0; }
        .about-aside-head h2 { margin: 0; color: #fff; font-size: 12px; font-weight: 800; letter-spacing: .18em; text-transform: uppercase; }
        .about-aside-list { display: grid; }
        .about-aside-link { display: flex; align-items: center; justify-content: space-between; padding: 12px 22px; color: rgba(255,255,255,.84); font-size: 13px; border-top: 1px solid rgba(255,255,255,.08); }
        .about-aside-link:first-of-type { border-top: 0; }
        .about-aside-link:hover { color: #fff; background: rgba(255,255,255,.04); }
        .about-cta { padding: 22px; background: radial-gradient(circle at top, rgba(255,255,255,.08), transparent 70%); }
        .about-cta h2 { margin: 0; color: #fff; font-size: 14px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; }
        .about-cta p { margin: 10px 0 16px; color: rgba(255,255,255,.78); font-size: 13px; line-height: 1.8; }
        .about-cta-btn { display: inline-flex; align-items: center; justify-content: center; height: 40px; padding: 0 18px; border-radius: 6px; border: 1px solid rgba(255,255,255,.38); color: #fff; font-size: 12px; font-weight: 700; }
        .about-units { margin-top: 48px; }
        .about-units-head { display: flex; align-items: center; gap: 14px; margin-bottom: 22px; }
        .about-units-head h2 { margin: 0; color: #fff; font-size: 12px; font-weight: 800; letter-spacing: .2em; text-transform: uppercase; }
        .about-units-line { flex: 1; height: 1px; background: rgba(255,255,255,.12); }
        .about-units-grid { display: grid; grid-template-columns: repeat(4, minmax(0,1fr)); gap: 14px; }
        .about-unit-card { display: block; padding: 18px; border: 1px solid rgba(255,255,255,.1); border-radius: 8px; background: #001A3A; transition: border-color .2s, background .2s, transform .2s; }
        .about-unit-card:hover { border-color: rgba(255,255,255,.32); background: #002451; transform: translateY(-2px); }
        .about-unit-card h3 { margin: 0; color: #fff; font-size: 15px; font-weight: 800; }
        .about-unit-card p { margin: 6px 0 0; color: rgba(255,255,255,.7); font-size: 12px; }
        @media (max-width: 1100px) { .about-grid { grid-template-columns: 1fr; } .about-units-grid { grid-template-columns: repeat(2, minmax(0,1fr)); } }
        @media (max-width: 640px) { .about-wrap { width: min(100% - 28px, 1180px); } .about-hero-inner { padding: 48px 0 46px; } .about-section { padding: 34px 0 52px; } .about-units-grid { grid-template-columns: 1fr; } }
    </style>

    <div class="about-page">
        <section class="about-hero">
            <div class="about-wrap about-hero-inner">
                <p class="about-eyebrow">{{ $subtitle }}</p>
                <h1>{{ $title }}</h1>
                <p class="about-hero-copy">Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia — lembaga legislatif mahasiswa KM UII.</p>
            </div>
        </section>

        <section class="about-section">
            <div class="about-wrap">
                <div class="about-grid">
                    <article class="about-panel">
                        <div class="about-panel-body">
                            @if (filled($content?->body))
                                <div class="about-prose">
                                    {!! $content->body !!}
                                </div>
                            @else
                                <p class="about-prose">Konten bagian ini belum diisi. Silakan lengkapi melalui panel admin.</p>
                            @endif
                        </div>
                    </article>

                    <aside class="about-aside">
                        @if (\App\Models\SiteContent::configFor($section)['show_units'] ?? false)
                            <div class="about-aside-card">
                                <div class="about-aside-head">
                                    <h2>Alat Kelengkapan</h2>
                                </div>
                                <div class="about-aside-list">
                                    @foreach ($units as $unit)
                                        <a href="{{ $unit->url }}" class="about-aside-link">
                                            <span>{{ $unit->short_name }}</span>
                                            <span aria-hidden="true">→</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="about-aside-card about-cta">
                            <h2>Produk Hukum</h2>
                            <p>PDKM, GBHKM, PKM, dan PDPM Keluarga Mahasiswa Universitas Islam Indonesia.</p>
                            <a href="{{ route('legal-products.index') }}" class="about-cta-btn">Lihat Produk Hukum</a>
                        </div>
                    </aside>
                </div>

                @if ($officials->isNotEmpty())
                    <div class="about-units">
                        <div class="about-units-head">
                            <h2>Susunan Anggota Terkait</h2>
                            <div class="about-units-line"></div>
                        </div>
                        <div class="about-units-grid">
                            @foreach ($officials as $unit)
                                <a href="{{ $unit->url }}" class="about-unit-card">
                                    <h3>{{ $unit->short_name }}</h3>
                                    @if ($unit->abbreviation && $unit->abbreviation !== $unit->name)
                                        <p>{{ $unit->name }}</p>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
