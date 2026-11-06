@extends('layouts.site')

@section('title', $title.' — '.($siteSettings['site_name'] ?? 'DPM UII'))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($content->body ?? $title), 150))

@section('content')
    @php
        $bodyHtml = $content?->body;
        $sambutanMain = $bodyHtml;
        $sambutanSignature = null;

        if ($section === 'sambutan' && filled($bodyHtml)) {
            $normalized = preg_replace('#<p>(?:\s|&nbsp;|<br\s*/?>)*</p>#i', '', $bodyHtml);

            if (preg_match('#<p[^>]*>\s*<strong>(.*?)</strong>\s*</p>#is', $normalized, $match, PREG_OFFSET_CAPTURE)) {
                $sambutanMain = substr($normalized, 0, $match[0][1]);
                $tailHtml = substr($normalized, $match[0][1] + strlen($match[0][0]));

                preg_match_all('#<p[^>]*>(.*?)</p>#is', $tailHtml, $lineMatches);
                $lines = array_values(array_filter(array_map(
                    fn (string $line): string => trim(strip_tags($line)),
                    $lineMatches[1] ?? []
                )));

                if ($lines !== []) {
                    $role = array_shift($lines);
                    $period = null;

                    if ($lines !== [] && str_starts_with($lines[array_key_last($lines)], 'Periode')) {
                        $period = array_pop($lines);
                    }

                    $sambutanSignature = [
                        'name' => trim(strip_tags($match[1][0])),
                        'role' => $role,
                        'org' => $lines,
                        'period' => $period,
                    ];
                }
            }
        }
    @endphp

    <style>
        .about-page { color: rgba(255,255,255,.85); }
        .about-hero { background: #001E43; color: #fff; }
        .about-hero--letter { position: relative; overflow: hidden; background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%); }
        .about-hero--letter::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, rgba(255,255,255,.035) 0 1px, transparent 1px 28px); }
        .about-hero--letter .about-hero-inner { position: relative; }
        .about-hero--letter .about-eyebrow { display: inline-flex; align-items: center; gap: 10px; }
        .about-hero--letter .about-eyebrow::before { content: ''; width: 28px; height: 2px; background: rgba(255,255,255,.7); }
        .about-wrap { width: min(1180px, calc(100% - 40px)); margin: 0 auto; }
        .about-hero-inner { padding: 68px 0 64px; }
        .about-eyebrow { margin: 0 0 10px; color: rgba(255,255,255,.72); font-size: 12px; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; }
        .about-hero h1 { margin: 0; color: #fff; font-size: clamp(30px, 4.6vw, 44px); font-weight: 800; letter-spacing: -.03em; }
        .about-hero-copy { max-width: 720px; margin: 14px 0 0; color: rgba(255,255,255,.82); font-size: 15px; line-height: 1.85; }
        .about-section { padding: 48px 0 70px; background: #001E43; }
        .about-grid { display: grid; grid-template-columns: minmax(0, 2fr) minmax(280px, 1fr); gap: 24px; align-items: start; }
        .about-panel { border: 1px solid rgba(255,255,255,.1); border-radius: 8px; background: #001A3A; overflow: hidden; }
        .about-panel-body { padding: clamp(24px, 4vw, 40px); }
        .about-panel--letter { position: relative; border-color: rgba(255,255,255,.16); box-shadow: 0 20px 60px rgba(0,0,0,.25); }
        .about-panel--letter::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; z-index: 1; background: linear-gradient(90deg, rgba(255,255,255,.85), rgba(255,255,255,.18) 45%, transparent); }
        .about-panel--letter .about-panel-body { position: relative; }
        .about-panel--letter .about-panel-body::before { content: '“'; position: absolute; top: 4px; right: 24px; font-family: 'Wix Madefor Display', sans-serif; font-size: 180px; line-height: 1; color: rgba(255,255,255,.045); pointer-events: none; }
        .about-prose { color: rgba(255,255,255,.84); font-size: 15px; line-height: 1.95; }
        .about-prose > *:first-child { margin-top: 0; }
        .about-prose > *:last-child { margin-bottom: 0; }
        .about-prose p { margin: 0 0 20px; }
        .about-prose h2, .about-prose h3, .about-prose h4 { color: #fff; font-weight: 800; letter-spacing: -.4px; }
        .about-prose h2 { margin: 40px 0 16px; font-size: clamp(23px, 3vw, 30px); line-height: 1.2; }
        .about-prose h3 { position: relative; margin: 34px 0 14px; padding-left: 16px; font-size: clamp(18px, 2.4vw, 23px); line-height: 1.3; }
        .about-prose h3::before { content: ''; position: absolute; left: 0; top: .2em; bottom: .2em; width: 3px; border-radius: 2px; background: rgba(255,255,255,.45); }
        .about-prose h4 { margin: 28px 0 12px; font-size: 16px; }
        .about-prose strong { color: #fff; font-weight: 700; }
        .about-prose a { color: #fff; text-decoration: none; border-bottom: 1px solid rgba(255,255,255,.4); transition: border-color .2s; }
        .about-prose a:hover { border-color: #fff; }
        .about-prose ul, .about-prose ol { margin: 20px 0; }
        .about-prose ul { list-style: none; padding-left: 0; display: grid; gap: 10px; }
        .about-prose ul li { position: relative; padding-left: 26px; }
        .about-prose ul li::before { content: ''; position: absolute; left: 4px; top: .72em; width: 7px; height: 7px; border-radius: 50%; background: rgba(255,255,255,.7); box-shadow: 0 0 0 4px rgba(255,255,255,.06); }
        .about-prose ol { padding-left: 24px; display: grid; gap: 10px; }
        .about-prose ol li::marker { color: rgba(255,255,255,.65); font-weight: 700; }
        .about-prose blockquote { margin: 30px 0; padding: 20px 26px; border-left: 3px solid rgba(255,255,255,.45); border-radius: 0 10px 10px 0; background: rgba(255,255,255,.04); color: rgba(255,255,255,.92); font-size: 16.5px; line-height: 1.85; }
        .about-prose blockquote p:last-child { margin-bottom: 0; }
        .about-prose img { display: block; max-width: 100%; height: auto; margin: 26px 0; border: 1px solid rgba(255,255,255,.12); border-radius: 10px; }
        .about-prose figure { margin: 26px 0; }
        .about-prose figcaption { margin-top: 10px; font-size: 12.5px; color: rgba(255,255,255,.6); text-align: center; }
        .about-prose hr { margin: 36px 0; border: 0; height: 1px; background: rgba(255,255,255,.14); }
        .about-prose table { width: 100%; margin: 26px 0; border-collapse: collapse; font-size: 14px; }
        .about-prose th, .about-prose td { padding: 12px 14px; border: 1px solid rgba(255,255,255,.12); text-align: left; }
        .about-prose th { background: rgba(255,255,255,.06); color: #fff; font-weight: 700; }
        .about-prose code { padding: 2px 7px; border-radius: 4px; background: rgba(255,255,255,.08); font-size: .9em; }
        .about-prose pre { margin: 26px 0; padding: 18px 20px; overflow-x: auto; border: 1px solid rgba(255,255,255,.12); border-radius: 8px; background: rgba(0,0,0,.25); }
        .about-prose pre code { padding: 0; background: none; }

        /* sambutan ketua */
        .about-prose--sambutan { font-size: 16px; line-height: 2.05; }
        .about-prose--sambutan > p:first-child { margin-bottom: 26px; padding-bottom: 22px; border-bottom: 1px solid rgba(255,255,255,.12); font-family: 'Wix Madefor Display', sans-serif; font-size: clamp(18px, 2.2vw, 22px); font-weight: 700; line-height: 1.55; letter-spacing: -.2px; color: #fff; }
        .about-prose--sambutan > p:nth-child(2) { font-size: 17px; font-weight: 600; color: rgba(255,255,255,.95); }
        .about-prose--sambutan > p:nth-child(3)::first-letter { float: left; margin: .08em 12px 0 0; font-family: 'Wix Madefor Display', sans-serif; font-size: 4.1em; font-weight: 800; line-height: .78; color: #fff; }
        .about-signature { display: grid; justify-items: start; gap: 3px; margin-top: 38px; padding-top: 26px; border-top: 1px solid rgba(255,255,255,.12); }
        .about-signature::before { content: ''; width: 56px; height: 2px; margin-bottom: 18px; background: rgba(255,255,255,.5); }
        .about-signature-role { font-size: 11.5px; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; color: rgba(255,255,255,.58); }
        .about-signature-name { margin: 3px 0 7px; font-family: 'Wix Madefor Display', sans-serif; font-size: clamp(21px, 2.8vw, 27px); font-weight: 800; line-height: 1.2; letter-spacing: -.4px; color: #fff; }
        .about-signature-org { font-size: 14px; line-height: 1.65; color: rgba(255,255,255,.78); }
        .about-signature-period { display: inline-flex; width: fit-content; margin-top: 12px; padding: 6px 13px; border: 1px solid rgba(255,255,255,.28); border-radius: 100px; background: rgba(255,255,255,.05); font-size: 11px; font-weight: 700; letter-spacing: .09em; text-transform: uppercase; color: #fff; }
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
        @media (max-width: 640px) {
            .about-wrap { width: min(100% - 28px, 1180px); }
            .about-hero-inner { padding: 48px 0 46px; }
            .about-section { padding: 34px 0 52px; }
            .about-units-grid { grid-template-columns: 1fr; }
            .about-panel--letter .about-panel-body::before { top: 0; right: 16px; font-size: 120px; }
            .about-prose--sambutan > p:nth-child(3)::first-letter { font-size: 3.4em; margin-right: 9px; }
        }
    </style>

    <div class="about-page">
        <section class="about-hero {{ $section === 'sambutan' ? 'about-hero--letter' : '' }}">
            <div class="about-wrap about-hero-inner">
                <p class="about-eyebrow">{{ $subtitle }}</p>
                <h1>{{ $title }}</h1>
                <p class="about-hero-copy">Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia</p>
            </div>
        </section>

        <section class="about-section">
            <div class="about-wrap">
                <div class="about-grid">
                    <article class="about-panel {{ $section === 'sambutan' ? 'about-panel--letter' : '' }}">
                        <div class="about-panel-body">
                            @if ($section === 'sambutan' && filled($sambutanMain))
                                <div class="about-prose about-prose--sambutan">
                                    {!! $sambutanMain !!}
                                </div>

                                @if ($sambutanSignature)
                                    <div class="about-signature">
                                        <span class="about-signature-role">{{ $sambutanSignature['role'] }}</span>
                                        <strong class="about-signature-name">{{ $sambutanSignature['name'] }}</strong>
                                        @if ($sambutanSignature['org'] !== [])
                                            <span class="about-signature-org">
                                                @foreach ($sambutanSignature['org'] as $orgLine)
                                                    {{ $orgLine }}@if (! $loop->last)<br>@endif
                                                @endforeach
                                            </span>
                                        @endif
                                        @if ($sambutanSignature['period'])
                                            <span class="about-signature-period">{{ $sambutanSignature['period'] }}</span>
                                        @endif
                                    </div>
                                @endif
                            @elseif (filled($content?->body))
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
