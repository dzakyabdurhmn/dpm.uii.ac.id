@extends('layouts.site')

@section('title', 'Visi dan Misi | DPM UII')
@section('meta_description', 'Visi dan Misi Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia.')

@push('styles')
<style>
  /* ============ VISI MISI ============ */
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

  /* visi band */
  .visi-band { position: relative; padding: 96px 0; border-bottom: 1px solid var(--b-default); text-align: center; overflow: hidden; background: var(--navy-card); }
  .visi-band::before { content: '“'; position: absolute; left: 50%; top: -50px; transform: translateX(-50%); font-family: 'Wix Madefor Display', serif; font-size: 340px; line-height: 1; color: rgba(255,255,255,.045); pointer-events: none; }
  .visi-band .tag { position: relative; display: inline-block; margin-bottom: 26px; padding: 6px 18px; border: 1px solid var(--b-btn); border-radius: 100px; font-size: 11.5px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; }
  .visi-band blockquote { position: relative; max-width: 980px; margin: 0 auto; font-family: 'Wix Madefor Display', sans-serif; font-size: clamp(24px, 3.7vw, 44px); font-weight: 700; line-height: 1.32; letter-spacing: -1px; }
  .visi-band blockquote em { font-style: normal; text-decoration: underline; text-decoration-thickness: 1px; text-underline-offset: 8px; text-decoration-color: rgba(255,255,255,.4); }
  .visi-band .rule { width: 64px; height: 1px; margin: 36px auto 0; background: var(--b-btn-hover); }

  /* misi band */
  .misi-head { display: flex; align-items: flex-end; justify-content: space-between; gap: 24px; flex-wrap: wrap; margin-bottom: 40px; }
  .misi-head h2 { font-size: clamp(30px, 4vw, 48px); letter-spacing: -1.2px; }
  .misi-head h2 + p { margin-top: 10px; font-size: 15px; color: var(--t-cap); }
  .misi-count { font-family: 'Wix Madefor Display', sans-serif; font-size: 88px; font-weight: 800; line-height: .9; letter-spacing: -4px; color: transparent; -webkit-text-stroke: 1px rgba(255,255,255,.28); }
  .misi { list-style: none; display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
  .misi li { display: grid; grid-template-columns: auto 1fr; gap: 20px; padding: 26px 28px; background: var(--navy-card); border: 1px solid var(--b-default); border-radius: 8px; transition: border-color .2s, background .2s; }
  .misi li:hover { border-color: var(--b-btn); background: var(--navy-hover); }
  .misi li b { font-family: 'Wix Madefor Display', sans-serif; font-size: 34px; font-weight: 800; line-height: 1; letter-spacing: -1.5px; color: transparent; -webkit-text-stroke: 1px rgba(255,255,255,.42); }
  .misi li p { font-size: 15px; line-height: 1.75; color: var(--t-body); }
  .misi li:last-child:nth-child(odd) { grid-column: 1 / -1; }
  .vm-band { padding: 80px 0; border-bottom: 1px solid var(--b-default); }
  .vm-band.alt { background: var(--navy-footer); }

  /* sub cta */
  .sub-cta { margin-top: 36px; padding: 22px 26px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 16px; border: 1px solid var(--b-btn); border-radius: 8px; background: var(--navy-card); }
  .sub-cta p { font-size: 14.5px; color: var(--t-sub); }
  .sub-cta strong { color: var(--white); }
  .link-plain { display: inline-flex; align-items: center; gap: 6px; font-size: 13px; font-weight: 600; color: var(--t-sub); text-decoration: none; border-bottom: 1px solid transparent; padding-bottom: 1px; transition: color .2s, border-color .2s; }
  .link-plain:hover { color: var(--white); border-color: var(--b-btn); }
  .link-plain::after { content: '→'; font-size: 11px; opacity: .6; transition: transform .2s, opacity .2s; }
  .link-plain:hover::after { transform: translateX(4px); opacity: 1; }

  @media (max-width: 1080px) {
    .hero-grid { grid-template-columns: 1fr; }
    .hero-art { display: none; }
    .misi { grid-template-columns: minmax(0, 1fr); }
    .misi-count { font-size: 64px; }
  }
  @media (max-width: 720px) {
    .pg-head { padding: 36px 0 44px; }
    .visi-band { padding: 64px 0; }
    .vm-band { padding: 56px 0; }
    .misi li { padding: 20px 18px; gap: 14px; }
    .misi li b { font-size: 26px; }
    .misi-count { display: none; }
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
        <span aria-current="page">Visi dan Misi</span>
      </nav>
      <span class="eyebrow">Tentang DPM UII</span>
      <h1>Visi dan Misi</h1>
      <p class="pg-desc">Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia, lembaga legislatif tertinggi dalam sistem student government KM UII.</p>
      <div class="meta">
        <span><small>Visi</small> 1</span>
        <span><small>Misi</small> 13</span>
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

<!-- ================= SUBNAV ================= -->
<div class="subnav" id="subnav">
  <div class="container subnav-inner">
    <ol id="toc">
      <li><a href="#visi"><em>01</em>Visi</a></li>
      <li><a href="#misi"><em>02</em>Misi</a></li>
    </ol>
    <a href="{{ url('/#fungsi') }}" class="link-plain">Tentang DPM</a>
  </div>
</div>

<!-- ================= VISI ================= -->
<section class="visi-band" id="visi" aria-labelledby="h-visi">
  <div class="container">
    <span class="tag" id="h-visi">Visi</span>
    <blockquote>Terbinanya Mahasiswa Universitas Islam Indonesia Menjadi Insan Ulil Albab yang Turut Bertanggung Jawab atas Terwujudnya Tatanan Masyarakat yang Diridhai oleh Allah SWT.</blockquote>
    <div class="rule"></div>
  </div>
</section>

<!-- ================= MISI ================= -->
<section class="vm-band alt" id="misi" aria-labelledby="h-misi">
  <div class="container">
    <div class="misi-head">
      <div>
        <h2 id="h-misi">Misi</h2>
      </div>
      <span class="misi-count" aria-hidden="true">13</span>
    </div>
    <ol class="misi">
      <li><b>01</b><p>Mewujudkan peran fungsi lembaga aspirasi mahasiswa yang responsif, progresif, adaptif, inovatif serta kolaboratif.</p></li>
      <li><b>02</b><p>Optimalisasi fungsi lembaga mahasiswa yang amar ma'ruf nahi munkar.</p></li>
      <li><b>03</b><p>Memperkuat Ukhuwah Islamiyah, persaudaraan Islam dan persaudaraan sebangsa di dalam kelembagaan Keluarga Mahasiswa UII.</p></li>
      <li><b>04</b><p>Mewujudkan kelembagaan mahasiswa sebagai pembaharu dengan menghidupkan tradisi intelektual yang responsif terhadap permasalahan keumatan.</p></li>
      <li><b>05</b><p>Membangun kehidupan kampus yang berorientasi pada pembentukan mahasiswa menjadi Insan Ulil Albab.</p></li>
      <li><b>06</b><p>Menanamkan nilai-nilai keislaman dan kebangsaan yang kafah pada diri mahasiswa UII berlandaskan semangat rahmatan lil alamin guna mewujudkan Indonesia yang adil dan madani.</p></li>
      <li><b>07</b><p>Menguatkan tradisi intelektual dengan dasar studi ilmiah dalam kehidupan kampus sebagai basis pencerahan dan pembentukan karakter mahasiswa UII guna mewujudkan perubahan sosial transformatif.</p></li>
      <li><b>08</b><p>Optimalisasi bargaining position KM UII terhadap birokrat kampus.</p></li>
      <li><b>09</b><p>Optimalisasi pengawasan KM UII terhadap kebijakan birokrat kampus dan pemerintah.</p></li>
      <li><b>10</b><p>Mengembangkan jaringan kemahasiswaan di tingkat regional, nasional dan internasional.</p></li>
      <li><b>11</b><p>Mewujudkan kemandirian dan independensi "Student Government" Keluarga Mahasiswa Universitas Islam Indonesia.</p></li>
      <li><b>12</b><p>Optimalisasi sistem kelembagaan kemahasiswaan yang demokratis dan transparan dalam lingkungan KM UII.</p></li>
      <li><b>13</b><p>Optimalisasi peran dan fungsi mahasiswa Universitas Islam Indonesia sebagai katalisator pergerakan dalam membersamai perjuangan rakyat.</p></li>
    </ol>
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
          if (a) a.setAttribute('aria-current', 'true');
        }
      });
    }, { rootMargin: '-30% 0px -60% 0px' });
    map.forEach((a, id) => { const s = document.getElementById(id); if (s) io.observe(s); });

    const bar = document.getElementById('subnav');
    const first = document.getElementById('visi');
    let ticking = false;
    function prog() {
      const start = first.offsetTop - 200;
      const end = document.documentElement.scrollHeight - window.innerHeight;
      const p = Math.min(1, Math.max(0, (window.scrollY - start) / Math.max(1, end - start)));
      bar.style.setProperty('--p', p.toFixed(3));
      ticking = false;
    }
    function onScroll() {
      if (!ticking) {
        requestAnimationFrame(prog);
        ticking = true;
      }
    }
    window.addEventListener('scroll', onScroll, { passive: true }); prog();
  })();
</script>
@endpush