@extends('layouts.site')

@section('title', 'Unduh Font & Template — '.($siteSettings['site_name'] ?? 'DPM UII'))
@section('meta_description', 'Unduh font resmi UII dan template surat DPM UII untuk keperluan dokumen internal.')

@section('content')
<style>
    .humas-page { color: rgba(255,255,255,.85); }
    .humas-hero { background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%); }
    .humas-wrap { width: min(1180px, calc(100% - 40px)); margin: 0 auto; }
    .humas-hero-inner { padding: 68px 0 64px; position: relative; overflow: hidden; }
    .humas-hero-inner::before {
        content: '';
        position: absolute; inset: 0;
        background: repeating-linear-gradient(135deg, rgba(255,255,255,.035) 0 1px, transparent 1px 26px);
        pointer-events: none;
    }
    .humas-eyebrow { margin: 0 0 10px; color: rgba(255,255,255,.72); font-size: 12px; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; }
    .humas-hero h1 { margin: 0; color: #fff; font-size: clamp(30px, 4.6vw, 44px); font-weight: 800; letter-spacing: -.03em; }
    .humas-hero-copy { max-width: 720px; margin: 14px 0 0; color: rgba(255,255,255,.82); font-size: 15px; line-height: 1.85; }

    .humas-section { padding: 56px 0 70px; background: #001E43; }
    .humas-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 28px; }

    .humas-card {
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 16px;
        background: linear-gradient(145deg, #001A3A 0%, #001633 100%);
        overflow: hidden;
        transition: border-color .2s, box-shadow .2s, transform .2s;
        display: flex;
        flex-direction: column;
    }
    .humas-card:hover {
        border-color: rgba(255,255,255,.25);
        box-shadow: 0 16px 48px rgba(0,0,0,.4);
        transform: translateY(-4px);
    }

    .humas-card-header {
        padding: 28px 32px 20px;
        border-bottom: 1px solid rgba(255,255,255,.08);
        background: rgba(255,255,255,.02);
    }
    .humas-icon {
        width: 64px; height: 64px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 16px;
    }
    .humas-icon.font { background: rgba(34,197,94,.15); color: #4ade80; }
    .humas-icon.document { background: rgba(250,204,21,.15); color: #fbbf24; }
    .humas-icon svg { width: 30px; height: 30px; stroke: currentColor; fill: none; stroke-width: 2; }
    .humas-type {
        display: inline-block;
        font-size: 11px; font-weight: 800; letter-spacing: .1em; text-transform: uppercase;
        color: rgba(255,255,255,.5); margin-bottom: 8px;
    }
    .humas-card-header h2 { margin: 0; color: #fff; font-size: 22px; font-weight: 800; letter-spacing: -.01em; }
    .humas-card-header p { margin: 8px 0 0; color: rgba(255,255,255,.65); font-size: 14px; line-height: 1.7; }

    .humas-card-body {
        padding: 24px 32px 32px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .humas-meta {
        display: flex; gap: 20px; margin-bottom: 20px; flex-wrap: wrap;
    }
    .humas-meta-item {
        display: flex; align-items: center; gap: 8px;
        font-size: 13px; color: rgba(255,255,255,.6);
    }
    .humas-meta-item svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; }
    .humas-meta-item strong { color: #fff; font-weight: 600; }

    .humas-desc {
        color: rgba(255,255,255,.78); font-size: 14.5px; line-height: 1.85;
        margin-bottom: 28px; flex: 1;
    }

    .btn-download {
        display: inline-flex; align-items: center; justify-content: center; gap: 10px;
        width: 100%;
        height: 48px;
        padding: 0 24px;
        border-radius: 10px;
        background: transparent;
        border: 2px solid;
        color: #fff;
        font-size: 14px; font-weight: 700; letter-spacing: .02em;
        text-decoration: none;
        transition: all .2s;
    }
    .btn-download.font { border-color: #4ade80; color: #4ade80; }
    .btn-download.font:hover { background: rgba(34,197,94,.15); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(34,197,94,.2); }
    .btn-download.document { border-color: #fbbf24; color: #fbbf24; }
    .btn-download.document:hover { background: rgba(250,204,21,.15); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(250,204,21,.2); }
    .btn-download svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2.5; }

    @media (max-width: 720px) {
        .humas-wrap { width: min(100% - 28px, 1180px); }
        .humas-hero-inner { padding: 48px 0 46px; }
        .humas-section { padding: 40px 0 52px; }
        .humas-grid { grid-template-columns: 1fr; }
        .humas-card-header { padding: 24px; }
        .humas-card-body { padding: 20px 24px 28px; }
    }
</style>

<div class="humas-page">
    <section class="humas-hero">
        <div class="humas-wrap humas-hero-inner">
            <p class="humas-eyebrow">Humas DPM UII</p>
            <h1>Unduh Font & Template</h1>
            <p class="humas-hero-copy">
                Aset brand resmi DPM UII untuk keperluan dokumen internal. Gunakan font dan template standar untuk konsistensi visual organisasi.
            </p>
        </div>
    </section>

    <section class="humas-section">
        <div class="humas-wrap">
            <div class="humas-grid">
                @foreach ($files as $file)
                    <article class="humas-card">
                        <header class="humas-card-header">
                            <div class="humas-icon {{ $file['icon'] }}" aria-hidden="true">
                                @if ($file['icon'] === 'font')
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="4 7 4 4 20 4 20 7"/><line x1="9" y1="20" x2="15" y2="20"/><line x1="12" y1="4" x2="12" y2="20"/><line x1="4" y1="7" x2="20" y2="7"/></svg>
                                @else
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                @endif
                            </div>
                            <span class="humas-type">{{ $file['type'] }}</span>
                            <h2>{{ $file['name'] }}</h2>
                            <p>{{ $file['description'] }}</p>
                        </header>
                        <div class="humas-card-body">
                            <div class="humas-meta">
                                <div class="humas-meta-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    <strong>{{ $file['filename'] }}</strong>
                                </div>
                                <div class="humas-meta-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                    <strong>{{ $file['size'] }}</strong>
                                </div>
                            </div>
                            <p class="humas-desc">{{ $file['description'] }}</p>
                            <a href="{{ route('humas.download.file', $file['filename']) }}" class="btn-download {{ $file['icon'] }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 16v1a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                <span>Unduh Sekarang</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div style="margin-top: 48px; padding: 28px; background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.08); border-radius: 12px;">
                <h3 style="margin: 0 0 16px; color: #fff; font-size: 18px; font-weight: 800;">Panduan Penggunaan</h3>
                <ul style="margin: 0; padding-left: 22px; color: rgba(255,255,255,.8); line-height: 2;">
                    <li><strong>Font UII:</strong> Install file <code>UII Font.ttf</code> di sistem operasi (Windows: klik kanan → Install / Mac: double-click → Install Font). Gunakan untuk dokumen resmi DPM UII.</li>
                    <li><strong>Template Surat:</strong> Buka <code>template-surat.docx</code> dengan Microsoft Word atau LibreOffice. Ganti bagian-bagian yang diberi tanda kurung [...] dengan data yang sesuai.</li>
                    <li><strong>Konsistensi:</strong> Selalu gunakan font dan template ini untuk surat resmi, SK, dan dokumen internal DPM UII agar identitas visual tetap konsisten.</                    </li>
                </ul>
            </div>
        </div>
    </section>
</div>
@endsection