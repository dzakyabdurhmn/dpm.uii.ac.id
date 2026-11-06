@extends('layouts.site')

@section('title', 'Kedudukan, Tugas dan Wewenang | DPM UII')
@section('meta_description', 'Kedudukan, fungsi, tugas, dan wewenang Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia berdasarkan Peraturan Dasar Keluarga Mahasiswa UII.')

@push('styles')
<style>
  /* ============ KEDUDUKAN v2 ============ */
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

  /* pernyataan */
  .statement { position: relative; padding: 64px 0; text-align: center; border-bottom: 1px solid var(--b-default); background: var(--navy-card); overflow: hidden; }
  .statement::before { content: '“'; position: absolute; left: 50%; top: -30px; transform: translateX(-50%); font-family: 'Wix Madefor Display', serif; font-size: 260px; line-height: 1; color: rgba(255,255,255,.05); pointer-events: none; }
  .statement .eyebrow { position: relative; display: block; margin-bottom: 18px; font-size: 11.5px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--t-cap); }
  .statement blockquote { position: relative; max-width: 860px; margin: 0 auto 22px; font-family: 'Wix Madefor Display', sans-serif; font-size: clamp(24px, 3.6vw, 40px); font-weight: 700; line-height: 1.3; letter-spacing: -.8px; color: var(--white); }

  /* subnav */
  .subnav { position: sticky; top: 73px; z-index: 50; background: rgba(0,22,51,.95); border-bottom: 1px solid var(--b-default); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); }
  .subnav::after { content: ''; position: absolute; left: 0; bottom: -1px; height: 2px; width: calc(var(--p, 0) * 100%); background: var(--white); transition: width .1s linear; }
  .subnav-inner { display: flex; align-items: center; justify-content: space-between; gap: 20px; }
  .subnav ol { list-style: none; display: flex; gap: 4px; padding: 10px 0; overflow-x: auto; scrollbar-width: none; }
  .subnav ol::-webkit-scrollbar { display: none; }
  .subnav li a { display: flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 100px; border: 1px solid transparent; white-space: nowrap; font-size: 13.5px; font-weight: 600; color: var(--t-cap); transition: color .2s, background .2s, border-color .2s; }
  .subnav li a em { font-style: normal; font-size: 11px; opacity: .6; }
  .subnav li a:hover { color: var(--white); }
  .subnav li a[aria-current="true"] { color: var(--white); background: rgba(255,255,255,.10); border-color: rgba(255,255,255,.35); }
  .subnav .btn { flex-shrink: 0; }

  /* band */
  .band { padding: 96px 0; border-bottom: 1px solid var(--b-default); }
  .band.alt { background: var(--navy-footer); }
  .band-grid { display: grid; grid-template-columns: 300px minmax(0, 1fr); gap: 72px; align-items: start; }
  .band-head { position: sticky; top: 150px; }
  .big-no { display: block; margin-bottom: 8px; font-family: 'Wix Madefor Display', sans-serif; font-size: 88px; font-weight: 800; line-height: 1; letter-spacing: -4px; color: transparent; -webkit-text-stroke: 1px rgba(255,255,255,.28); }
  .band-head h2 { margin-bottom: 14px; font-size: clamp(28px, 3.2vw, 38px); letter-spacing: -.9px; line-height: 1.15; }
  .band-head p { font-size: 14.5px; color: var(--t-cap); line-height: 1.75; }

  .pasals { display: flex; flex-wrap: wrap; gap: 6px; }
  .pasal { display: inline-block; padding: 2px 10px; border: 1px solid var(--b-btn); border-radius: 100px; font-size: 11.5px; font-weight: 600; letter-spacing: .3px; color: var(--white); white-space: nowrap; vertical-align: middle; }
  .ic { width: 44px; height: 44px; display: grid; place-items: center; border: 1px solid var(--b-btn); border-radius: 8px; color: var(--white); }
  .ic svg { width: 20px; height: 20px; stroke: currentColor; fill: none; stroke-width: 1.7; stroke-linecap: round; stroke-linejoin: round; }

  /* kedudukan cards */
  .fgrid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
  .fcard { display: grid; grid-template-columns: auto 1fr; column-gap: 24px; padding: 26px 28px; background: var(--navy-card); border: 1px solid var(--b-default); border-radius: 8px; transition: border-color .2s, background .2s; }
  .fcard:hover { border-color: var(--b-btn); background: var(--navy-hover); }
  .fcard .ic { margin-top: 2px; flex-shrink: 0; }
  .fcard h3 { margin-bottom: 8px; font-size: 22px; letter-spacing: -.4px; }
  .fcard p { margin-bottom: 16px; font-size: 14.5px; color: var(--t-sub); line-height: 1.7; }

  /* tugas & wewenang numbered list */
  .nlist { list-style: none; display: grid; gap: 12px; counter-reset: x; }
  .nlist.two { grid-template-columns: 1fr 1fr; }
  .nlist li { display: grid; grid-template-columns: auto 1fr; gap: 18px; align-items: start; padding: 20px 22px; background: var(--navy-card); border: 1px solid var(--b-default); border-radius: 8px; font-size: 14.5px; line-height: 1.7; color: var(--t-body); transition: border-color .2s, background .2s; }
  .nlist li:hover { border-color: var(--b-btn); background: var(--navy-hover); }
  .nlist li b { font-family: 'Wix Madefor Display', sans-serif; font-size: 22px; font-weight: 800; letter-spacing: -.5px; line-height: 1.2; color: transparent; -webkit-text-stroke: 1px rgba(255,255,255,.4); }
  .nlist.two li:last-child:nth-child(odd) { grid-column: 1 / -1; }

  /* dasar hukum */
  .law-main { display: grid; grid-template-columns: auto 1fr auto; gap: 22px; align-items: center; padding: 26px; margin-bottom: 14px; border: 1px solid var(--b-btn); border-radius: 8px; background: var(--navy-card); box-shadow: var(--sh-md); }
  .law-main .abbr { width: 72px; height: 72px; display: grid; place-items: center; border: 1px solid var(--b-btn); border-radius: 8px; font-family: 'Wix Madefor Display', sans-serif; font-size: 17px; font-weight: 800; color: var(--white); }
  .law-main h3 { margin-bottom: 3px; font-size: 20px; letter-spacing: -.3px; }
  .law-main p { font-size: 14px; color: var(--t-cap); line-height: 1.6; max-width: 520px; }
  .law-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
  .law { display: flex; flex-direction: column; justify-content: space-between; gap: 16px; padding: 18px 20px; border: 1px solid var(--b-default); border-radius: 8px; background: var(--navy-card); transition: border-color .2s, background .2s; }
  .law:hover { border-color: var(--b-btn); background: var(--navy-hover); }
  .law .law-t { display: flex; flex-direction: column; gap: 4px; }
  .law .law-t small { font-size: 11.5px; font-weight: 600; letter-spacing: .6px; text-transform: uppercase; color: var(--t-cap); }
  .law .law-t strong { font-size: 15px; line-height: 1.45; color: var(--white); }
  .law-actions { display: flex; gap: 8px; }
  .btn.sm { padding: 9px 16px; font-size: 13px; }
  .btn.sm svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 1.9; stroke-linecap: round; stroke-linejoin: round; }
  .btn.sm:hover svg { transform: none; }
  .disclaimer { margin-top: 24px; padding: 18px 22px; border-left: 2px solid var(--b-btn-hover); background: rgba(255,255,255,.03); font-size: 13.5px; color: var(--t-sub); line-height: 1.7; }
  .disclaimer strong { color: var(--white); }

  /* dialog pratinjau */
  .pdlg { margin: auto; padding: 0; width: min(1000px, calc(100vw - 32px)); height: min(86vh, 860px); overflow: hidden; background: var(--navy-card); color: var(--t-body); border: 1px solid var(--b-btn); border-radius: 12px; box-shadow: var(--sh-lg); }
  .pdlg[open] { display: flex; flex-direction: column; }
  .pdlg::backdrop { background: rgba(0,0,0,.6); }
  .pdlg-head { display: flex; align-items: center; gap: 16px; padding: 14px 18px; border-bottom: 1px solid var(--b-default); }
  .pdlg-head .t { flex: 1; min-width: 0; }
  .pdlg-head small { display: block; font-size: 11px; font-weight: 600; letter-spacing: 1.2px; text-transform: uppercase; color: var(--t-cap); }
  .pdlg-head strong { display: block; font-size: 15px; line-height: 1.35; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .pdlg-x { width: 38px; height: 38px; flex-shrink: 0; display: grid; place-items: center; background: transparent; border: 1px solid var(--b-btn); border-radius: 6px; color: var(--white); cursor: pointer; transition: border-color .2s, background .2s; }
  .pdlg-x:hover { border-color: var(--b-btn-hover); background: var(--bg-hover); }
  .pdlg-x svg { width: 15px; height: 15px; stroke: currentColor; stroke-width: 2; stroke-linecap: round; fill: none; }
  .pdlg-body { position: relative; flex: 1; background: #0b1220; }
  .pdlg-body iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; }
  .pdlg-load { position: absolute; inset: 0; display: grid; place-items: center; font-size: 13.5px; color: var(--t-cap); }

  @media (max-width: 1080px) {
    .hero-grid { grid-template-columns: 1fr; }
    .hero-art { display: none; }
    .band { padding: 72px 0; }
    .band-grid { grid-template-columns: minmax(0, 1fr); gap: 32px; }
    .band-head { position: static; }
    .big-no { font-size: 64px; }
    .subnav .btn { display: none; }
    .fgrid { grid-template-columns: 1fr; }
    .fcard { grid-template-columns: 1fr; }
    .fcard .ic { margin-bottom: 12px; }
    .nlist.two { grid-template-columns: minmax(0,1fr); }
    .nlist li { padding: 16px; gap: 14px; }
    .law-main { grid-template-columns: 1fr; }
    .law-grid { grid-template-columns: 1fr; }
    .pdlg { width: 100vw; height: 100vh; max-height: 100vh; border-radius: 0; border: 0; }
    .pdlg-head .btn span { display: none; }
  }
  @media (max-width: 720px) {
    .pg-head { padding: 36px 0 44px; }
    .statement { padding: 48px 0; }
    .band { padding: 56px 0; }
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
        <span aria-current="page">Kedudukan, Tugas dan Wewenang</span>
      </nav>
      <span class="eyebrow">Tentang DPM UII</span>
      <h1>Kedudukan, Tugas dan Wewenang</h1>
      <p class="pg-desc">Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia: lembaga perwakilan seluruh mahasiswa yang memegang kekuasaan tertinggi di tingkat universitas.</p>
      <div class="meta">
        <span><small>Dasar</small> PDKM UII</span>
        <span><small>Tugas</small> 9</span>
        <span><small>Wewenang</small> 5</span>
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

<!-- ================= STATEMENT ================= -->
<section class="statement">
  <div class="container">
    <span class="eyebrow">Kedudukan DPM UII</span>
    <blockquote>Perwakilan Seluruh Mahasiswa dan Memegang Kekuasaan Tertinggi di Tingkat Universitas.</blockquote>
  </div>
</section>

<!-- ================= SUBNAV ================= -->
<div class="subnav" id="subnav">
  <div class="container subnav-inner">
    <ol id="toc">
      <li><a href="#kedudukan"><em>01</em>Kedudukan</a></li>
      <li><a href="#tugas"><em>02</em>Tugas</a></li>
      <li><a href="#wewenang"><em>03</em>Wewenang</a></li>
      <li><a href="#dasar-hukum"><em>04</em>Dasar Hukum</a></li>
    </ol>
    <a class="btn sm" href="{{ route('legal-products.type', 'pdkm') }}" rel="noopener">
      <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v11M7 11l5 5 5-5M5 20h14"/></svg>
      Unduh PDKM
    </a>
  </div>
</div>

<!-- ================= 01 KEDUDUKAN ================= -->
<section class="band" id="kedudukan" aria-labelledby="h-kedudukan">
  <div class="container band-grid">
    <header class="band-head">
      <span class="big-no" aria-hidden="true">01</span>
      <h2 id="h-kedudukan">Kedudukan</h2>
      <p>Posisi DPM dalam sistem pemerintahan mahasiswa Keluarga Mahasiswa UII.</p>
    </header>
    <div>
      <div class="fgrid">
        <article class="fcard reveal d1">
          <span class="ic"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 21h18M5 21V10M10 21V10M14 21V10M19 21V10M2 10 12 3l10 7z"/></svg></span>
          <div>
            <h3>Perwakilan Seluruh Mahasiswa</h3>
            <p>Dewan Permusyawaratan Mahasiswa Universitas (DPM U) adalah bentuk perwakilan dari seluruh mahasiswa Universitas Islam Indonesia dan merupakan lembaga permusyawaratan mahasiswa yang berkedudukan di tingkat universitas.</p>
          </div>
        </article>
        <article class="fcard reveal d2">
          <span class="ic"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3v18M5 21h14M5 7h14M5 7l-3 8a3.5 3.5 0 0 0 6 0zM19 7l-3 8a3.5 3.5 0 0 0 6 0z"/></svg></span>
          <div>
            <h3>Kekuasaan Tertinggi</h3>
            <p>Memegang kekuasaan tertinggi di tingkat universitas yang dijalankan menurut Peraturan Dasar Keluarga Mahasiswa Universitas Islam Indonesia (PDKM UII).</p>
          </div>
        </article>
        <article class="fcard reveal d3">
          <span class="ic"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c0-3.6 2.9-6 6.5-6s6.5 2.4 6.5 6M16 5a3.5 3.5 0 0 1 0 6.5M18 14.5c2.2.6 3.5 2.4 3.5 5.5"/></svg></span>
          <div>
            <h3>Kedaulatan Mahasiswa</h3>
            <p>Menjalankan kedaulatan mahasiswa dengan sistem permusyawaratan dan perwakilan.</p>
          </div>
        </article>
      </div>
    </div>
  </div>
</section>

<!-- ================= 02 TUGAS ================= -->
<section class="band alt" id="tugas" aria-labelledby="h-tugas">
  <div class="container band-grid">
    <header class="band-head">
      <span class="big-no" aria-hidden="true">02</span>
      <h2 id="h-tugas">Tugas</h2>
      <p>9 tugas DPM UII.</p>
    </header>
    <div>
      <ol class="nlist two">
        <li><b>01</b><span>Mengangkat dan memberhentikan mandataris DPM UII sebagai Ketua LEM UII.</span></li>
        <li><b>02</b><span>Mengesahkan hasil suksesi kepengurusan LK U.</span></li>
        <li><b>03</b><span>Menetapkan dan melantik Pengurus LK U.</span></li>
        <li><b>04</b><span>Menetapkan dan melantik Fungsionaris LEM UII.</span></li>
        <li><b>05</b><span>Menerima atau menolak Program Kerja dan Anggaran Kerja LEM UII yang waktunya ditentukan dalam Ketetapan DPM.</span></li>
        <li><b>06</b><span>Mengambil Sumpah Anggota DPM Fakultas.</span></li>
        <li><b>07</b><span>Memberikan hasil Keputusan Sidang Umum kepada seluruh Lembaga Kemahasiswaan dalam KM UII.</span></li>
        <li><b>08</b><span>Mengesahkan Anggaran Pendapatan dan Belanja LEM UII, LK U, DPM F, LEM F, dan LK F.</span></li>
        <li><b>09</b><span>Menampung dan menyerap seluruh aspirasi mahasiswa serta lembaga kemahasiswaan di dalam KM UII.</span></li>
      </ol>
    </div>
  </div>
</section>

<!-- ================= 03 WEWENANG ================= -->
<section class="band" id="wewenang" aria-labelledby="h-wewenang">
  <div class="container band-grid">
    <header class="band-head">
      <span class="big-no" aria-hidden="true">03</span>
      <h2 id="h-wewenang">Wewenang</h2>
      <p>5 wewenang DPM UII.</p>
    </header>
    <div>
      <ol class="nlist">
        <li><b>01</b><span>Menetapkan alat kelengkapan dewan yang dipilih dari dan oleh anggota.</span></li>
        <li><b>02</b><span>Membentuk Organ Pekerja.</span></li>
        <li><b>03</b><span>Membuat dan menetapkan PDPM UII.</span></li>
        <li><b>04</b><span>Menyusun, membahas, dan mengesahkan PKM UII atas persetujuan Ketua LEM UII.</span></li>
        <li><b>05</b><span>Mengusulkan dan memutuskan perubahan dalam Peraturan Dasar KM UII sebagaimana dimaksud pada Pasal 56 PDKM UII.</span></li>
      </ol>
    </div>
  </div>
</section>

<!-- ================= 04 DASAR HUKUM ================= -->
<section class="band alt" id="dasar-hukum" aria-labelledby="h-dasar-hukum">
  <div class="container band-grid">
    <header class="band-head">
      <span class="big-no" aria-hidden="true">04</span>
      <h2 id="h-dasar-hukum">Dasar Hukum</h2>
      <p>Peraturan yang menjadi rujukan.</p>
    </header>
    <div>
      <div class="law-main reveal d1">
        <span class="abbr">PDKM</span>
        <div>
          <h3>Peraturan Dasar Keluarga Mahasiswa UII</h3>
          <p>Konstitusi tertinggi KM UII yang mengatur asas, tujuan, kelembagaan, dan sistem pemerintahan mahasiswa.</p>
        </div>
        <a class="btn sm" href="{{ route('legal-products.type', 'pdkm') }}" rel="noopener">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v11M7 11l5 5 5-5M5 20h14"/></svg>Unduh
        </a>
      </div>
      <div class="law-grid">
        <div class="law reveal d2">
          <div class="law-t">
            <small>Peraturan DPM</small>
            <strong>Peraturan DPM UII (PDPM UII)</strong>
          </div>
          <div class="law-actions">
            <a class="btn sm" href="{{ route('legal-products.type', 'pdpm') }}">
              <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h5"/></svg>
              Buka arsip
            </a>
          </div>
        </div>
        <div class="law reveal d3">
          <div class="law-t">
            <small>PKM UII No. 3 Tahun 2019</small>
            <strong>Tentang DPM U & DPM F</strong>
          </div>
          <div class="law-actions">
            <button class="btn sm" type="button" data-id="1f1JHjVVp0Ia8MkHs1e52g5EAblsoHGkR" data-label="PKM UII No. 3 Tahun 2019" data-title="Tentang DPM U & DPM F">
              <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
              Pratinjau
            </button>
            <a class="btn sm" href="https://drive.google.com/uc?export=download&id=1f1JHjVVp0Ia8MkHs1e52g5EAblsoHGkR" rel="noopener">
              <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v11M7 11l5 5 5-5M5 20h14"/></svg>
              Unduh
            </a>
          </div>
        </div>
        <div class="law reveal d4">
          <div class="law-t">
            <small>PKM UII No. 4 Tahun 2019</small>
            <strong>Tentang Pedoman Pelaksanaan Foraslak Lembaga Legislatif KM UII</strong>
          </div>
          <div class="law-actions">
            <button class="btn sm" type="button" data-id="1COzbBfqkcoBMauJLuGf0BD4gDSnJZ3m9" data-label="PKM UII No. 4 Tahun 2019" data-title="Tentang Pedoman Pelaksanaan Foraslak Lembaga Legislatif KM UII">
              <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
              Pratinjau
            </button>
            <a class="btn sm" href="https://drive.google.com/uc?export=download&id=1COzbBfqkcoBMauJLuGf0BD4gDSnJZ3m9" rel="noopener">
              <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v11M7 11l5 5 5-5M5 20h14"/></svg>
              Unduh
            </a>
          </div>
        </div>
        <div class="law reveal d1">
          <div class="law-t">
            <small>PKM UII No. 1 Tahun 2019</small>
            <strong>Tentang Kode Etik Lembaga Legislatif UII</strong>
          </div>
          <div class="law-actions">
            <button class="btn sm" type="button" data-id="1Hxk1t8ST9iqVtVuqqtq9gW6FKFR_S6eH" data-label="PKM UII No. 1 Tahun 2019" data-title="Tentang Kode Etik Lembaga Legislatif UII">
              <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
              Pratinjau
            </button>
            <a class="btn sm" href="https://drive.google.com/uc?export=download&id=1Hxk1t8ST9iqVtVuqqtq9gW6FKFR_S6eH" rel="noopener">
              <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v11M7 11l5 5 5-5M5 20h14"/></svg>
              Unduh
            </a>
          </div>
        </div>
        <div class="law reveal d2">
          <div class="law-t">
            <small>PKM UII No. 3 Tahun 2018</small>
            <strong>Tentang Pengelolaan Aspirasi UII</strong>
          </div>
          <div class="law-actions">
            <button class="btn sm" type="button" data-id="1rFZTIC8A-ZSEucEm0LhIUSgWS1mo8icP" data-label="PKM UII No. 3 Tahun 2018" data-title="Tentang Pengelolaan Aspirasi UII">
              <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
              Pratinjau
            </button>
            <a class="btn sm" href="https://drive.google.com/uc?export=download&id=1rFZTIC8A-ZSEucEm0LhIUSgWS1mo8icP" rel="noopener">
              <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v11M7 11l5 5 5-5M5 20h14"/></svg>
              Unduh
            </a>
          </div>
        </div>
      </div>
      <p class="disclaimer"><strong>Catatan.</strong> Untuk rumusan yang mengikat, rujuklah teks resmi PDKM UII dan peraturan terkait pada halaman Produk Hukum.</p>
    </div>
  </div>
</section>

<!-- ================= PRATINJAU DIALOG ================= -->
<dialog class="pdlg" id="pdlg" aria-labelledby="pdTitle">
  <div class="pdlg-head">
    <div class="t"><small id="pdLabel"></small><strong id="pdTitle"></strong></div>
    <a class="btn sm" id="pdOpen" href="#" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h5"/></svg><span>Buka di Drive</span></a>
    <a class="btn sm" id="pdDl" href="#" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v11M7 11l5 5 5-5M5 20h14"/></svg><span>Unduh</span></a>
    <button class="pdlg-x" id="pdClose" type="button" aria-label="Tutup pratinjau"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg></button>
  </div>
  <div class="pdlg-body"><div class="pdlg-load">Memuat dokumen...</div><iframe id="pdFrame" title="Pratinjau dokumen" loading="lazy"></iframe></div>
</dialog>
@endsection

@push('scripts')
<script>
  // ---------- Sub-navigasi, progres baca ----------
  (function () {
    const links = [...document.querySelectorAll('#toc a')];
    const map = new Map(links.map(a => [a.getAttribute('href').slice(1), a]));
    const io = new IntersectionObserver(es => {
      es.forEach(en => {
        if (en.isIntersecting) {
          links.forEach(a => a.removeAttribute('aria-current'));
          const a = map.get(en.target.id);
          if (a) { a.setAttribute('aria-current', 'true'); a.scrollIntoView({ block: 'nearest', inline: 'center' }); }
        }
      });
    }, { rootMargin: '-30% 0px -60% 0px' });
    map.forEach((a, id) => { const s = document.getElementById(id); if (s) io.observe(s); });

    const bar = document.getElementById('subnav');
    const first = document.getElementById('kedudukan');
    function prog() {
      const start = first.offsetTop - 200;
      const end = document.documentElement.scrollHeight - window.innerHeight;
      const p = Math.min(1, Math.max(0, (window.scrollY - start) / Math.max(1, end - start)));
      bar.style.setProperty('--p', p.toFixed(3));
    }
    window.addEventListener('scroll', prog, { passive: true }); prog();
  })();

  // ---------- Pratinjau dokumen (Google Drive) ----------
  const $ = id => document.getElementById(id);
  const dlg = $('pdlg');
  document.addEventListener('click', e => {
    const b = e.target.closest('button[data-id]');
    if (!b) return;
    $('pdLabel').textContent = b.dataset.label;
    $('pdTitle').textContent = b.dataset.title.replace(/&/g, '&');
    $('pdOpen').href = 'https://drive.google.com/file/d/' + b.dataset.id + '/view';
    $('pdDl').href = 'https://drive.google.com/uc?export=download&id=' + b.dataset.id;
    $('pdFrame').src = 'https://drive.google.com/file/d/' + b.dataset.id + '/preview';
    dlg.showModal();
  });
  dlg.addEventListener('close', () => { $('pdFrame').src = 'about:blank'; });
  $('pdClose').addEventListener('click', () => dlg.close());
  dlg.addEventListener('click', e => { if (e.target === dlg) dlg.close(); });
</script>
@endpush