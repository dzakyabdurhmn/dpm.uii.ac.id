@extends('layouts.site')

@section('title', 'Struktur Lembaga KM UII | DPM UII')
@section('meta_description', 'Bagan struktur lembaga dalam Keluarga Mahasiswa Universitas Islam Indonesia, dari tingkat universitas hingga fakultas.')

@push('styles')
<style>
  /* ============ STRUKTUR ============ */
  .nav-item.current > a::after { transform: scaleX(1); }
  .mega-links a[aria-current] { background: var(--bg-hover); }
  :focus-visible { outline: 2px solid var(--white); outline-offset: 2px; }
  html { scroll-padding-top: 150px; }

  /* hero */
  .pg-head { position: relative; overflow: hidden; border-bottom: 1px solid var(--b-default); padding: 56px 0 64px;
    background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%); }
  .pg-head::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 28px); }
  .hero-grid { position: relative; display: grid; grid-template-columns: 1.2fr .8fr; gap: 40px; align-items: center; }
  .crumb { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 28px; font-size: 12.5px; color: var(--t-cap); }
  .crumb a { transition: color .2s; } .crumb a:hover { color: var(--white); }
  .crumb span[aria-hidden] { opacity: .5; }
  .crumb span[aria-current] { color: var(--white); font-weight: 600; }
  .pg-head h1 { font-size: clamp(34px, 5.6vw, 62px); letter-spacing: -1.6px; line-height: 1.06; margin-bottom: 18px; }
  .pg-desc { max-width: 580px; margin-bottom: 28px; font-size: 16px; color: var(--t-sub); }
  .meta { display: flex; flex-wrap: wrap; gap: 10px; }
  .meta span { display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; border: 1px solid var(--b-btn); border-radius: 100px; font-size: 12.5px; font-weight: 600; color: var(--white); background: rgba(0,22,51,.5); }
  .meta span small { font-size: 11px; font-weight: 500; letter-spacing: .8px; text-transform: uppercase; color: var(--t-cap); }
  .hero-art { display: flex; justify-content: flex-end; }
  .hero-art svg { width: min(100%, 460px); height: auto; }

  /* org chart */
  .org-wrap { padding: 72px 0 40px; }
  .org-card { border: 1px solid var(--b-default); border-radius: 12px; background: var(--navy-footer); padding: 28px; }
  .org-scroll { overflow-x: auto; }
  .org { display: block; width: 100%; min-width: 560px; max-width: 760px; margin: 0 auto; height: auto; }
  .org .ob rect { fill: #001A3A; stroke: rgba(255,255,255,.75); stroke-width: 2; transition: fill .2s, stroke .2s; }
  .org .ob.main rect { fill: #002451; stroke: #fff; stroke-width: 2.4; }
  .org .ob:hover rect { fill: #002A5A; stroke: #fff; }
  .org .ob text { fill: #fff; font-family: 'Wix Madefor Display', sans-serif; font-weight: 700; font-size: 13.5px; letter-spacing: .3px; }
  .ln-s { stroke: #fff; stroke-width: 3; }
  .ln-d { stroke: rgba(255,255,255,.85); stroke-width: 3; stroke-dasharray: 3 7; }
  .ln-f { stroke: #DC2626; stroke-width: 4; }
  .legend { display: flex; flex-wrap: wrap; gap: 14px 32px; margin-top: 22px; padding-top: 20px; border-top: 1px solid var(--b-default); }
  .legend div { display: flex; align-items: center; gap: 12px; font-size: 13.5px; color: var(--t-sub); }
  .legend svg { width: 56px; height: 6px; overflow: visible; }
  .scroll-hint { display: none; margin-bottom: 10px; font-size: 12.5px; color: var(--t-cap); }
  .org-note { margin-top: 16px; padding: 14px 18px; border-left: 2px solid var(--b-btn-hover); background: rgba(255,255,255,.03); font-size: 13.5px; color: var(--t-sub); line-height: 1.7; }

  /* level groups */
  .lv { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
  .lv article { padding: 24px; background: var(--navy-card); border: 1px solid var(--b-default); border-radius: 8px; transition: border-color .2s, background .2s; }
  .lv article:hover { border-color: var(--b-btn); background: var(--navy-hover); }
  .lv h3 { margin: 16px 0 8px; font-size: 18px; letter-spacing: -.2px; }
  .lv p { font-size: 14px; color: var(--t-sub); line-height: 1.7; }
  .lv .tags { margin-top: 14px; }
  .tags { display: flex; flex-wrap: wrap; gap: 8px; }
  .tags span { padding: 5px 12px; border: 1px solid var(--b-default); border-radius: 6px; background: rgba(255,255,255,.04); font-size: 12.5px; font-weight: 500; color: var(--t-body); }

  .band { padding: 96px 0; border-bottom: 1px solid var(--b-default); }
  .band.alt { background: var(--navy-footer); }
  .band-grid { display: grid; grid-template-columns: 300px minmax(0, 1fr); gap: 72px; align-items: start; }
  .band-head { position: sticky; top: 150px; }
  .big-no { display: block; margin-bottom: 8px; font-family: 'Wix Madefor Display', sans-serif; font-size: 88px; font-weight: 800; line-height: 1; letter-spacing: -4px; color: transparent; -webkit-text-stroke: 1px rgba(255,255,255,.28); }
  .band-head h2 { margin-bottom: 14px; font-size: clamp(28px, 3.2vw, 38px); letter-spacing: -.9px; line-height: 1.15; }
  .band-head p { font-size: 14.5px; color: var(--t-cap); line-height: 1.75; }
  .ic { width: 44px; height: 44px; display: grid; place-items: center; border: 1px solid var(--b-btn); border-radius: 8px; color: var(--white); }
  .ic svg { width: 20px; height: 20px; stroke: currentColor; fill: none; stroke-width: 1.7; stroke-linecap: round; stroke-linejoin: round; }

  @media (max-width: 1080px) {
    .hero-grid { grid-template-columns: 1fr; }
    .hero-art { display: none; }
    .lv { grid-template-columns: 1fr; }
  }
  @media (max-width: 720px) {
    .pg-head { padding: 36px 0 44px; }
    .org-wrap { padding: 44px 0 24px; }
    .org-card { padding: 18px; }
    .scroll-hint { display: block; }
  }
  @media (prefers-reduced-motion: reduce) { .reveal { opacity: 1; transform: none; } }
</style>
@endpush

@section('content')
<!-- ================= PAGE HEADER ================= -->
<section class="pg-head">
  <div class="container hero-grid">
    <div>
      <nav class="crumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Beranda</a><span aria-hidden="true">/</span>
        <a href="{{ url('/#fungsi') }}">Tentang</a><span aria-hidden="true">/</span>
        <span aria-current="page">Struktur Lembaga</span>
      </nav>
      <span class="eyebrow">Tentang DPM UII</span>
      <h1>Struktur Lembaga KM UII</h1>
      <p class="pg-desc">Bagan hubungan lembaga dalam Keluarga Mahasiswa Universitas Islam Indonesia, dari tingkat universitas hingga fakultas.</p>
      <div class="meta">
        <span><small>Tingkat</small> Universitas</span>
        <span><small>Tingkat</small> Fakultas</span>
      </div>
    </div>
    <div class="hero-art">
      <svg viewBox="0 0 640 520" fill="none" stroke="rgba(255,255,255,0.42)" stroke-width="1.6" stroke-linejoin="round" aria-hidden="true">
        <defs><g id="col"><rect x="0" y="0" width="28" height="170"/><path d="M9 6V164M19 6V164" stroke="rgba(255,255,255,0.18)"/><rect x="-6" y="-8" width="40" height="8" fill="rgba(255,255,255,0.09)"/><rect x="-6" y="170" width="40" height="8" fill="rgba(255,255,255,0.09)"/></g></defs>
        <path d="M50 205 L320 62 L590 205 Z" fill="rgba(255,255,255,0.07)"/>
        <path d="M92 195 L320 76 L548 195"/>
        <circle cx="320" cy="150" r="30" fill="rgba(255,255,255,0.09)"/><circle cx="320" cy="150" r="20"/>
        <path d="M320 134 L324 146 L336 146 L326 154 L330 166 L320 159 L310 166 L314 154 L304 146 L316 146 Z" fill="rgba(255,255,255,0.3)" stroke="none"/>
        <rect x="50" y="205" width="540" height="22" fill="rgba(255,255,255,0.09)"/>
        <use href="#col" x="96" y="235"/><use href="#col" x="176" y="235"/><use href="#col" x="256" y="235"/>
        <use href="#col" x="336" y="235"/><use href="#col" x="416" y="235"/><use href="#col" x="496" y="235"/>
        <path d="M70 413 H570M50 433 H590M30 453 H610M10 473 H630"/>
      </svg>
    </div>
  </div>
</section>

<!-- ================= ORG CHART ================= -->
<section class="org-wrap">
  <div class="container">
    <div class="org-card">
      <p class="scroll-hint">Geser bagan ke samping untuk melihat seluruhnya.</p>
      <div class="org-scroll">
        <svg viewBox="80 150 560 535" role="img" aria-label="Bagan struktur lembaga KM UII: DPM Universitas, LEM Universitas, Lembaga Khusus Universitas, UKM, DPM Fakultas, LEM Fakultas, Lembaga Khusus Fakultas, Himpunan Mahasiswa Jurusan" class="org">
          <g fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path d="M290 193H258V257 M190 283H141V303 M360 474V516 M283 547H215 M436 547H527V562" class="ln-s"/>
            <path d="M255 309V328 M360 578V611" class="ln-f"/>
            <path d="M430 193H548V220 M360 223V414 M430 444H550V460" class="ln-d"/>
          </g>
          <g class="ob main">
            <rect x="290" y="163" width="140" height="60" rx="10"/>
            <text x="360.0" y="189.5" text-anchor="middle"><tspan x="360.0" dy="0">DPM</tspan><tspan x="360.0" dy="17">UNIVERSITAS</tspan></text>
          </g>
          <g class="ob ">
            <rect x="470" y="220" width="155" height="62" rx="10"/>
            <text x="547.5" y="247.5" text-anchor="middle"><tspan x="547.5" dy="0">LEMBAGA KHUSUS</tspan><tspan x="547.5" dy="17">UNIVERSITAS</tspan></text>
          </g>
          <g class="ob main">
            <rect x="190" y="257" width="130" height="52" rx="10"/>
            <text x="255.0" y="279.5" text-anchor="middle"><tspan x="255.0" dy="0">LEM</tspan><tspan x="255.0" dy="17">UNIVERSITAS</tspan></text>
          </g>
          <g class="ob ">
            <rect x="96" y="303" width="90" height="56" rx="10"/>
            <text x="141.0" y="336.0" text-anchor="middle"><tspan x="141.0" dy="0">UKM K</tspan></text>
          </g>
          <g class="ob ">
            <rect x="193" y="328" width="125" height="56" rx="10"/>
            <text x="255.5" y="352.5" text-anchor="middle"><tspan x="255.5" dy="0">UKM</tspan><tspan x="255.5" dy="17">UNIVERSITAS</tspan></text>
          </g>
          <g class="ob main">
            <rect x="290" y="414" width="140" height="60" rx="10"/>
            <text x="360.0" y="440.5" text-anchor="middle"><tspan x="360.0" dy="0">DPM</tspan><tspan x="360.0" dy="17">FAKULTAS</tspan></text>
          </g>
          <g class="ob ">
            <rect x="470" y="460" width="155" height="62" rx="10"/>
            <text x="547.5" y="487.5" text-anchor="middle"><tspan x="547.5" dy="0">LEMBAGA KHUSUS</tspan><tspan x="547.5" dy="17">FAKULTAS</tspan></text>
          </g>
          <g class="ob main">
            <rect x="283" y="516" width="153" height="62" rx="10"/>
            <text x="359.5" y="543.5" text-anchor="middle"><tspan x="359.5" dy="0">LEM</tspan><tspan x="359.5" dy="17">FAKULTAS</tspan></text>
          </g>
          <g class="ob ">
            <rect x="95" y="517" width="120" height="60" rx="10"/>
            <text x="155.0" y="535.0" text-anchor="middle"><tspan x="155.0" dy="0">HIMPUNAN</tspan><tspan x="155.0" dy="17">MAHASISWA</tspan><tspan x="155.0" dy="17">JURUSAN</tspan></text>
          </g>
          <g class="ob ">
            <rect x="482" y="562" width="90" height="56" rx="10"/>
            <text x="527.0" y="595.0" text-anchor="middle"><tspan x="527.0" dy="0">UKM K</tspan></text>
          </g>
          <g class="ob ">
            <rect x="280" y="611" width="162" height="60" rx="10"/>
            <text x="361.0" y="637.5" text-anchor="middle"><tspan x="361.0" dy="0">UKM</tspan><tspan x="361.0" dy="17">FAKULTAS</tspan></text>
          </g>
        </svg>
      </div>
      <div class="legend">
        <div><svg viewBox="0 0 56 6"><path d="M0 3H56" fill="none" stroke="#fff" stroke-width="3" /></svg>Garis Instruksi</div>
        <div><svg viewBox="0 0 56 6"><path d="M0 3H56" fill="none" stroke="#fff" stroke-width="3" stroke-dasharray="3 7" stroke-linecap="round"/></svg>Garis Koordinasi</div>
        <div><svg viewBox="0 0 56 6"><path d="M0 3H56" fill="none" stroke="#DC2626" stroke-width="4" stroke-dasharray="none"/></svg>Garis Instruksi Terusan</div>
      </div>
    </div>
    <p class="org-note"><strong style="color:#fff">Catatan.</strong> Beberapa fakultas memiliki struktur yang berbeda tergantung Garis Besar Program Kerja (GBPK) masing-masing.</p>
  </div>
</section>

<!-- ================= KELOMPOK LEMBAGA ================= -->
<section class="band alt" style="border-top:1px solid var(--b-default)">
  <div class="container band-grid">
    <header class="band-head">
      <span class="big-no" aria-hidden="true">01</span>
      <h2>Kelompok Lembaga</h2>
      <p>Lembaga dalam bagan dikelompokkan menurut fungsinya.</p>
    </header>
    <div class="lv">
      <article class="reveal d1">
        <span class="ic"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3v18M5 21h14M5 7h14M5 7l-3 8a3.5 3.5 0 0 0 6 0zM19 7l-3 8a3.5 3.5 0 0 0 6 0z"/></svg></span>
        <h3>Legislatif</h3>
        <p>Dewan Permusyawaratan Mahasiswa pada tingkat universitas dan fakultas.</p>
        <div class="tags"><span>DPM Universitas</span><span>DPM Fakultas</span></div>
      </article>
      <article class="reveal d2">
        <span class="ic"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 21h18M5 21V10M10 21V10M14 21V10M19 21V10M2 10 12 3l10 7z"/></svg></span>
        <h3>Eksekutif</h3>
        <p>Lembaga Eksekutif Mahasiswa beserta unit kegiatan dan himpunan di bawahnya.</p>
        <div class="tags"><span>LEM Universitas</span><span>LEM Fakultas</span><span>UKM</span><span>UKM K</span><span>Himpunan Mahasiswa Jurusan</span></div>
      </article>
      <article class="reveal d3">
        <span class="ic"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="18" cy="5" r="2.5"/><circle cx="6" cy="12" r="2.5"/><circle cx="18" cy="19" r="2.5"/><path d="m8.2 10.8 7.6-4.4M8.2 13.2l7.6 4.4"/></svg></span>
        <h3>Lembaga Khusus</h3>
        <p>Lembaga khusus pada tingkat universitas dan fakultas, berhubungan dengan DPM melalui garis koordinasi.</p>
        <div class="tags"><span>Lembaga Khusus Universitas</span><span>Lembaga Khusus Fakultas</span></div>
      </article>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
  // Reveal on scroll
  const io = new IntersectionObserver((entries) => {
    entries.forEach(en => { if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); } });
  }, { threshold: 0.12 });
  document.querySelectorAll('.reveal').forEach(el => io.observe(el));
</script>
@endpush