@extends('layouts.site')

@section('title', 'Alat Kelengkapan — '.($siteSettings['site_name'] ?? 'DPM UII'))

@section('content')
    <style>
        .units-page { color: rgba(255,255,255,.85); }
        .units-hero { position: relative; background: #001E43; color: #fff; }
        .units-wrap { width: min(1180px, calc(100% - 40px)); margin: 0 auto; }
        .units-hero-inner { padding: 68px 0 70px; }
        .units-eyebrow { margin: 0 0 10px; color: rgba(255,255,255,.72); font-size: 12px; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; }
        .units-hero h1 { margin: 0; color: #fff; font-size: clamp(30px, 4.6vw, 46px); font-weight: 800; letter-spacing: -.03em; }
        .units-hero-copy { max-width: 720px; margin: 14px 0 0; color: rgba(255,255,255,.82); font-size: 15px; line-height: 1.85; }
        .units-section { padding: 48px 0 64px; background: #001E43; }
        .units-grid { display: grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap: 18px; }
        .unit-card { display: flex; flex-direction: column; overflow: hidden; border: 1px solid rgba(255,255,255,.1); border-radius: 10px; background: #001A3A; color: rgba(255,255,255,.85); transition: border-color .25s, background .25s, transform .25s, box-shadow .25s; box-shadow: 0 30px 60px -40px rgba(0,0,0,.9); }
        .unit-card:hover { border-color: rgba(255,255,255,.38); background: #002451; color: #fff; transform: translateY(-4px); box-shadow: 0 40px 70px -40px rgba(0,0,0,.95); }
        .unit-card-media { position: relative; width: 100%; height: 190px; background: radial-gradient(circle at top, rgba(255,255,255,.08), transparent 70%), #001E43; }
        .unit-card-media::after { content: ''; position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0,30,67,0) 40%, rgba(0,26,58,.9) 100%); }
        .unit-card-media img { position: relative; z-index: 1; width: 100%; height: 100%; object-fit: cover; }
        .unit-card-media-placeholder { position: relative; z-index: 1; display: grid; place-items: center; width: 100%; height: 100%; color: rgba(255,255,255,.4); font-size: 34px; }
        .unit-card-body { display: flex; flex-direction: column; gap: 10px; padding: 20px 24px 24px; }
        .unit-card-type { display: inline-block; align-self: flex-start; color: rgba(255,255,255,.64); font-size: 10px; font-weight: 800; letter-spacing: .18em; text-transform: uppercase; }
        .unit-card h2 { margin: 0; color: #fff; font-size: 18px; font-weight: 800; line-height: 1.4; }
        .unit-card-sub { margin: -4px 0 0; color: rgba(255,255,255,.6); font-size: 12px; }
        .unit-card-desc { display: -webkit-box; overflow: hidden; margin: 4px 0 0; color: rgba(255,255,255,.78); font-size: 13px; line-height: 1.9; -webkit-box-orient: vertical; -webkit-line-clamp: 4; }
        .unit-card-footer { margin-top: auto; display: flex; align-items: center; justify-content: space-between; padding-top: 12px; color: rgba(255,255,255,.6); font-size: 11px; text-transform: uppercase; letter-spacing: .16em; }
        .unit-card-footer span:last-child { color: #fff; }
        @media (max-width: 1080px) { .units-grid { grid-template-columns: repeat(2, minmax(0,1fr)); } }
        @media (max-width: 640px) { .units-wrap { width: min(100% - 28px, 1180px); } .units-hero-inner { padding: 48px 0 52px; } .units-section { padding: 34px 0 48px; } .units-grid { grid-template-columns: 1fr; gap: 16px; } .unit-card-media { height: 170px; } .unit-card-body { padding: 18px 20px 22px; } }
    </style>

    <div class="units-page">
        <section class="units-hero">
            <div class="units-wrap units-hero-inner">
                <p class="units-eyebrow">Kelembagaan</p>
                <h1>Alat Kelengkapan DPM UII</h1>
                <p class="units-hero-copy">
                    Badan dan lembaga yang menjalankan fungsi legislasi, pengawasan, advokasi, dan pengelolaan aset DPM UII.
                </p>
            </div>
        </section>

        <section class="units-section">
            <div class="units-wrap">
                <div class="units-grid">
                    @foreach ($units as $unit)
                        <a href="{{ $unit->url }}" class="unit-card">
                            <div class="unit-card-media">
                                @if ($unit->logo_path)
                                    <img src="{{ asset($unit->logo_path) }}" alt="{{ $unit->short_name }}" loading="lazy">
                                @else
                                    <div class="unit-card-media-placeholder">
                                        <i class="fa-solid fa-landmark"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="unit-card-body">
                                <span class="unit-card-type">{{ $unit->type }}</span>
                                <h2>{{ $unit->short_name }}</h2>
                                @if ($unit->abbreviation && $unit->abbreviation !== $unit->name)
                                    <p class="unit-card-sub">{{ $unit->name }}</p>
                                @endif
                                <p class="unit-card-desc">{{ $unit->description ?: 'Keterangan unit belum tersedia.' }}</p>
                                <div class="unit-card-footer">
                                    <span>Lihat Profil</span>
                                    <span aria-hidden="true">→</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection
