@extends('layouts.site')

@section('title', 'DPM UII – Dewan Permusyawaratan Mahasiswa UII')
@section('meta_description', 'Portal resmi Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia: produk hukum, laporan, dana, berita, pengumuman, dan aspirasi mahasiswa.')

@push('styles')
<style>
  /* ---------- Hero banner ---------- */
  .hero { position: relative; background: var(--navy-footer); }
  .slider { position: relative; height: clamp(480px, 76vh, 660px); overflow: hidden; }

  .slide { position: absolute; inset: 0; opacity: 0; visibility: hidden; transition: opacity .9s ease, visibility .9s; }
  .slide.active { opacity: 1; visibility: visible; z-index: 1; }

  .slide-bg { position: absolute; inset: 0; background: linear-gradient(135deg, #002A5A 0%, #001E43 52%, #001633 100%); }
  .slide-bg::after {
    content: ''; position: absolute; inset: 0; opacity: .5;
    background-image:
      repeating-linear-gradient(135deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 28px);
  }
  .slide-art { position: absolute; right: 2%; bottom: 0; width: min(58%, 780px); height: 100%; display: flex; align-items: flex-end; justify-content: flex-end; }
  .slide-art svg { width: 100%; height: auto; max-height: 100%; }
  .slide-photo { position: absolute; inset: 0; background-size: cover; background-position: center; opacity: 0; transition: opacity .8s; }
  .slide.has-photo .slide-photo { opacity: 1; }
  .slide.has-photo .slide-art, .slide.has-photo .slide-bg::after { display: none; }
  .slide.active.has-photo .slide-photo { animation: kenburns 16s ease-out forwards; }
  @keyframes kenburns { from { transform: scale(1); } to { transform: scale(1.07); } }

  .slide-overlay {
    position: absolute; inset: 0;
    background:
      linear-gradient(90deg, rgba(0,30,67,.97) 0%, rgba(0,30,67,.86) 40%, rgba(0,30,67,.30) 100%),
      linear-gradient(0deg, rgba(0,22,51,.9) 0%, transparent 34%);
  }

  .slide-content { position: relative; z-index: 2; height: 100%; display: flex; align-items: center; }
  .slide-text { max-width: 660px; padding: 0 0 76px; }
  .hero-label { display: flex; align-items: center; gap: 14px; margin-bottom: 22px; font-size: 12.5px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--t-sub); }
  .hero-label::before { content: ''; width: 40px; height: 2px; background: var(--white); flex-shrink: 0; }
  .slide h1 { font-size: clamp(28px, 4.4vw, 52px); letter-spacing: -1px; line-height: 1.14; margin-bottom: 20px; }
  .slide p.lead { font-size: clamp(15px, 1.5vw, 17px); color: var(--t-sub); max-width: 560px; margin-bottom: 32px; }
  .hero-actions { display: flex; flex-wrap: wrap; gap: 12px; }

  .slide.active .slide-text > * { animation: rise .8s ease both; }
  .slide.active .slide-text > *:nth-child(2) { animation-delay: .1s; }
  .slide.active .slide-text > *:nth-child(3) { animation-delay: .2s; }
  .slide.active .slide-text > *:nth-child(4) { animation-delay: .3s; }
  @keyframes rise { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }

  /* control bar */
  .slider-bar { position: absolute; left: 0; right: 0; bottom: 0; z-index: 5; background: rgba(0,22,51,.78); border-top: 1px solid var(--b-default); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); }
  .slider-bar-inner { display: flex; align-items: center; justify-content: space-between; gap: 20px; padding-top: 14px; padding-bottom: 14px; }
  .counter { font-family: 'Wix Madefor Display', sans-serif; font-weight: 700; font-size: 14px; letter-spacing: 1px; color: var(--white); min-width: 64px; }
  .counter span { color: var(--t-cap); font-weight: 500; }
  .dots { display: flex; gap: 10px; flex: 1; max-width: 360px; }
  .dot { position: relative; flex: 1; height: 3px; padding: 0; border: 0; background: rgba(255,255,255,.25); overflow: hidden; cursor: pointer; }
  .dot::before { content: ''; position: absolute; inset: -10px 0; }
  .dot.active::after { content: ''; position: absolute; inset: 0; background: var(--white); transform-origin: left; animation: progress 7s linear forwards; }
  .slider.paused .dot.active::after { animation-play-state: paused; }
  @keyframes progress { from { transform: scaleX(0); } to { transform: scaleX(1); } }
  .arrows { display: flex; gap: 8px; }
  .arrow { width: 38px; height: 38px; display: grid; place-items: center; background: transparent; border: 1px solid var(--b-btn); border-radius: 6px; color: var(--white); transition: border-color .2s, background .2s; }
  .arrow:hover { border-color: var(--b-btn-hover); background: var(--bg-hover); }
  .arrow svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

  /* ---------- Akses cepat ---------- */
  .quick-access { background: var(--navy-card); border-bottom: 1px solid var(--b-default); }
  .qa-grid { display: grid; grid-template-columns: repeat(5, 1fr); }
  .qa-item { display: flex; align-items: center; gap: 14px; padding: 22px 20px; transition: background .2s; }
  .qa-item + .qa-item { border-left: 1px solid var(--b-default); }
  .qa-item:hover { background: var(--navy-hover); }
  .qa-item .ic { width: 42px; height: 42px; flex-shrink: 0; display: grid; place-items: center; border: 1px solid var(--b-btn); border-radius: 8px; color: var(--white); }
  .qa-item .ic svg { width: 20px; height: 20px; stroke: currentColor; fill: none; stroke-width: 1.7; stroke-linecap: round; stroke-linejoin: round; }
  .qa-item strong { display: block; font-family: 'Wix Madefor Display', sans-serif; font-size: 14.5px; font-weight: 600; color: var(--white); line-height: 1.3; }
  .qa-item small { display: block; font-size: 12px; color: var(--t-cap); font-weight: 500; line-height: 1.4; }

  @media (max-width: 900px) {
    .qa-grid { grid-template-columns: 1fr 1fr; }
    .qa-item + .qa-item { border-left: 0; }
    .qa-item { border-top: 1px solid var(--b-default); }
    .qa-item:nth-child(-n+2) { border-top: 0; }
    .qa-item:nth-child(even) { border-left: 1px solid var(--b-default); }
    .qa-item:last-child { grid-column: 1 / -1; border-left: 0; }
  }
  @media (max-width: 720px) {
    .slider { height: clamp(520px, 86vh, 640px); }
    .slide-art { width: 100%; right: 0; opacity: .32; }
    .slide-overlay { background: linear-gradient(0deg, rgba(0,22,51,.96) 0%, rgba(0,30,67,.78) 55%, rgba(0,30,67,.55) 100%); }
    .slide-text { padding-bottom: 84px; }
    .counter { display: none; }
    .qa-item { padding: 18px 14px; gap: 10px; }
    .qa-item small { display: none; }
  }

  /* ---------- Sections ---------- */
  section.block { padding: 96px 0; }
  .sec-head { display: flex; align-items: flex-end; justify-content: space-between; gap: 24px; margin-bottom: 44px; flex-wrap: wrap; }
  .sec-head h2 { font-size: clamp(28px, 4vw, 42px); letter-spacing: -1px; line-height: 1.15; max-width: 640px; }
  .sec-head p { margin-top: 12px; max-width: 560px; color: var(--t-sub); font-size: 15px; }

  .alt { background: var(--navy-footer); border-top: 1px solid var(--b-default); border-bottom: 1px solid var(--b-default); }

  .grid { display: grid; gap: 18px; }
  .g3 { grid-template-columns: repeat(3, 1fr); }
  .g4 { grid-template-columns: repeat(4, 1fr); }

  .card {
    position: relative; display: block;
    background: var(--navy-card);
    border: 1px solid var(--b-default); border-radius: 8px;
    padding: 28px;
    transition: border-color .25s, background .25s, transform .25s, box-shadow .25s;
  }
  a.card:hover, .card.hov:hover { background: var(--navy-hover); border-color: var(--b-btn); transform: translateY(-2px); box-shadow: var(--sh-md); }

  .icon-box { width: 48px; height: 48px; display: grid; place-items: center; margin-bottom: 22px; border: 1px solid var(--b-btn); border-radius: 8px; color: var(--white); }
  .icon-box svg { width: 22px; height: 22px; stroke: currentColor; fill: none; stroke-width: 1.7; stroke-linecap: round; stroke-linejoin: round; }

  .card h3 { font-size: 19px; margin-bottom: 10px; letter-spacing: -.2px; }
  .card p { font-size: 14px; color: var(--t-sub); }

  /* Fungsi cards: number */
  .num { position: absolute; top: 22px; right: 26px; font-family: 'Wix Madefor Display', sans-serif; font-size: 44px; font-weight: 800; color: rgba(255,255,255,0.06); line-height: 1; }

  /* Produk hukum */
  .law .abbr { font-family: 'Wix Madefor Display', sans-serif; font-size: 40px; font-weight: 800; letter-spacing: -1px; color: var(--white); line-height: 1; margin-bottom: 14px; }
  .law .tag { display: block; margin-bottom: 18px; font-size: 11px; font-weight: 600; letter-spacing: 1.6px; text-transform: uppercase; color: var(--t-cap); }
  .law .go { margin-top: 22px; display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: var(--white); }
  .law .go svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; transition: transform .2s; }
  .law:hover .go svg { transform: translateX(4px); }

  /* Alat kelengkapan */
  .unit { display: flex; gap: 18px; align-items: flex-start; padding: 24px; }
  .unit .code { flex: 0 0 auto; min-width: 64px; height: 64px; padding: 0 10px; display: grid; place-items: center; border: 1px solid var(--b-btn); border-radius: 8px; font-family: 'Wix Madefor Display', sans-serif; font-weight: 800; font-size: 15px; letter-spacing: .5px; color: var(--white); }
  .unit h3 { font-size: 16px; margin-bottom: 4px; }
  .unit p { font-size: 13px; color: var(--t-cap); font-weight: 500; }

  /* Berita & pengumuman */
  .two { display: grid; grid-template-columns: 1.4fr 1fr; gap: 24px; }
  .news-list, .notice-list { display: flex; flex-direction: column; gap: 14px; }
  .news-item { display: grid; grid-template-columns: 120px 1fr; gap: 20px; padding: 18px; align-items: center; }
  .news-thumb { aspect-ratio: 4/3; border-radius: 6px; border: 1px solid var(--b-default); background:
      linear-gradient(135deg, rgba(255,255,255,0.08), rgba(255,255,255,0.02)); display: grid; place-items: center; color: var(--t-cap); }
  .news-thumb svg { width: 28px; height: 28px; stroke: currentColor; fill: none; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; }
  .meta { font-size: 12px; font-weight: 500; color: var(--t-cap); letter-spacing: .3px; margin-bottom: 6px; }
  .news-item h3 { font-size: 16.5px; line-height: 1.4; margin-bottom: 6px; }
  .news-item p { font-size: 13.5px; color: var(--t-sub); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

  .panel-title { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
  .panel-title h3 { font-size: 18px; }

  .notice { display: grid; grid-template-columns: 56px 1fr; gap: 16px; padding: 18px; align-items: center; }
  .date-box { text-align: center; padding: 8px 0; border: 1px solid var(--b-btn); border-radius: 6px; }
  .date-box strong { display: block; font-family: 'Wix Madefor Display', sans-serif; font-size: 20px; font-weight: 800; color: var(--white); line-height: 1.1; }
  .date-box span { display: block; font-size: 10px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--t-cap); }
  .notice h3 { font-size: 14.5px; line-height: 1.45; }

  /* Dana & Laporan */
  .quick { display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 22px 24px; }
  .quick span.t { font-family: 'Wix Madefor Display', sans-serif; font-size: 16px; font-weight: 600; color: var(--white); }
  .quick small { display: block; margin-top: 2px; font-family: 'Inter', sans-serif; font-size: 12.5px; font-weight: 500; color: var(--t-cap); }
  .quick svg { width: 18px; height: 18px; flex-shrink: 0; stroke: var(--white); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; opacity: .7; transition: transform .2s, opacity .2s; }
  .quick:hover svg { transform: translateX(4px); opacity: 1; }

  /* Aspirasi */
  .aspirasi { display: grid; grid-template-columns: 1fr 1fr; gap: 56px; align-items: start; }
  .aspirasi h2 { font-size: clamp(30px, 4.4vw, 48px); letter-spacing: -1.2px; line-height: 1.12; margin-bottom: 18px; }
  .aspirasi .hash { display: inline-block; margin-top: 26px; padding: 8px 18px; border: 1px solid var(--b-btn); border-radius: 100px; font-size: 13px; font-weight: 600; color: var(--white); letter-spacing: .4px; }
  .form-card { padding: 32px; box-shadow: var(--sh-lg); }
  .field { margin-bottom: 18px; }
  .field label { display: block; margin-bottom: 8px; font-size: 12.5px; font-weight: 600; letter-spacing: .6px; text-transform: uppercase; color: var(--t-sub); }
  .field input, .field textarea {
    width: 100%; padding: 13px 16px;
    background: rgba(255,255,255,0.03);
    border: 1px solid var(--b-default); border-radius: 6px;
    color: var(--white); font-size: 14.5px;
    transition: border-color .2s, background .2s;
  }
  .field input::placeholder, .field textarea::placeholder { color: rgba(255,255,255,0.38); }
  .field input:focus, .field textarea:focus { outline: none; border-color: var(--b-btn-hover); background: rgba(255,255,255,0.05); }
  .field textarea { min-height: 130px; resize: vertical; }
  .field.err input, .field.err textarea { border-color: #DC2626; }
  .field .msg-err { display: none; margin-top: 6px; font-size: 12.5px; color: #DC2626; }
  .field.err .msg-err { display: block; }
  .form-card .btn { width: 100%; }
  .success { display: none; margin-top: 16px; padding: 13px 16px; border: 1px solid #16A34A; border-radius: 6px; font-size: 13.5px; color: #16A34A; }
  .success.show { display: block; }

  /* ---------- Responsive ---------- */
  @media (max-width: 1080px) {
    .g4 { grid-template-columns: repeat(2, 1fr); }
    .two, .aspirasi { grid-template-columns: 1fr; }
  }
  @media (max-width: 720px) {
    section.block { padding: 68px 0; }
    .g3, .g4 { grid-template-columns: 1fr; }
    .news-item { grid-template-columns: 92px 1fr; gap: 14px; padding: 14px; }
    .form-card { padding: 24px; }
  }
</style>

@endpush

@section('content')
<!-- ================= HERO BANNER ================= -->
<!-- Foto banner: letakkan file di folder images/ (hero-1.jpg, hero-2.jpg, hero-3.jpg) atau ubah data-img di bawah.
     Jika foto belum ada, otomatis tampil ilustrasi institusional. Ukuran ideal 1920x800 px. -->
<section class="hero" aria-label="Banner utama">
  <div class="slider" id="slider">

    <!-- Slide 1 -->
    <div class="slide active" data-img="images/hero-1.jpg">
      <div class="slide-bg"></div>
      <div class="slide-art" aria-hidden="true">
        <svg viewBox="0 0 640 520" fill="none" stroke="rgba(255,255,255,0.42)" stroke-width="1.6" stroke-linejoin="round">
          <defs>
            <g id="col">
              <rect x="0" y="0" width="28" height="170"/>
              <path d="M9 6V164M19 6V164" stroke="rgba(255,255,255,0.2)"/>
              <rect x="-6" y="-8" width="40" height="8" fill="rgba(255,255,255,0.09)"/>
              <rect x="-6" y="170" width="40" height="8" fill="rgba(255,255,255,0.09)"/>
            </g>
          </defs>
          <path d="M50 205 L320 62 L590 205 Z" fill="rgba(255,255,255,0.07)"/>
          <path d="M92 195 L320 76 L548 195"/>
          <circle cx="320" cy="150" r="30" fill="rgba(255,255,255,0.09)"/>
          <circle cx="320" cy="150" r="20"/>
          <path d="M320 134 L324 146 L336 146 L326 154 L330 166 L320 159 L310 166 L314 154 L304 146 L316 146 Z" fill="rgba(255,255,255,0.18)" stroke="none"/>
          <rect x="50" y="205" width="540" height="22" fill="rgba(255,255,255,0.09)"/>
          <use href="#col" x="96"  y="235"/>
          <use href="#col" x="176" y="235"/>
          <use href="#col" x="256" y="235"/>
          <use href="#col" x="336" y="235"/>
          <use href="#col" x="416" y="235"/>
          <use href="#col" x="496" y="235"/>
          <path d="M70 413 H570"/>
          <path d="M50 433 H590"/>
          <path d="M30 453 H610"/>
          <path d="M10 473 H630"/>
          <path d="M10 473 V500 H630 V473" stroke="rgba(255,255,255,0.2)"/>
        </svg>
      </div>
      <div class="slide-photo"></div>
      <div class="slide-overlay"></div>
      <div class="container slide-content">
        <div class="slide-text">
          <div class="hero-label">Portal Resmi · Keluarga Mahasiswa UII</div>
          <h1>Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia</h1>
          <p class="lead">Lembaga legislatif Keluarga Mahasiswa UII yang menjalankan fungsi legislasi, pengawasan, dan penyaluran aspirasi mahasiswa.</p>
          <div class="hero-actions">
            <a href="/tentang/profil-dewan" class="btn">Profil Lembaga <svg viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
            <a href="/produk-hukum" class="btn">Produk Hukum</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Slide 2 -->
    <div class="slide" data-img="images/hero-2.jpg">
      <div class="slide-bg"></div>
      <div class="slide-art" aria-hidden="true">
        <svg viewBox="0 0 640 520" fill="none" stroke="rgba(255,255,255,0.42)" stroke-width="1.6" stroke-linejoin="round">
          <rect x="170" y="60" width="300" height="390" rx="6" transform="rotate(-7 320 255)" fill="rgba(255,255,255,0.10)"/>
          <rect x="170" y="60" width="300" height="390" rx="6" transform="rotate(7 320 255)" fill="rgba(255,255,255,0.10)"/>
          <rect x="170" y="60" width="300" height="390" rx="6" fill="rgba(255,255,255,0.09)"/>
          <path d="M215 120 H425" stroke-width="3"/>
          <path d="M215 150 H400 M215 176 H425 M215 202 H410 M215 228 H425 M215 254 H385 M215 292 H425 M215 318 H405 M215 344 H425" stroke="rgba(255,255,255,0.26)"/>
          <circle cx="320" cy="400" r="34" fill="rgba(255,255,255,0.09)"/>
          <circle cx="320" cy="400" r="24"/>
          <path d="M320 384 L324 396 L336 396 L326 404 L330 416 L320 409 L310 416 L314 404 L304 396 L316 396 Z" fill="rgba(255,255,255,0.18)" stroke="none"/>
          <path d="M300 430 L292 470 L320 456 L348 470 L340 430" fill="rgba(255,255,255,0.09)"/>
        </svg>
      </div>
      <div class="slide-photo"></div>
      <div class="slide-overlay"></div>
      <div class="container slide-content">
        <div class="slide-text">
          <div class="hero-label">Produk Hukum</div>
          <h1>Landasan Hukum Keluarga Mahasiswa UII</h1>
          <p class="lead">Arsip resmi PDKM, GBHKM, PKM, dan PDPM-U yang dapat diakses oleh seluruh civitas kemahasiswaan Universitas Islam Indonesia.</p>
          <div class="hero-actions">
            <a href="/produk-hukum" class="btn">Akses Produk Hukum <svg viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
            <a href="/keputusan" class="btn">Surat Keputusan</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Slide 3 -->
    <div class="slide" data-img="images/hero-3.jpg">
      <div class="slide-bg"></div>
      <div class="slide-art" aria-hidden="true">
        <svg viewBox="0 0 640 520" fill="none" stroke="rgba(255,255,255,0.42)" stroke-width="1.6" stroke-linejoin="round">
          <path d="M250 70 H520 A16 16 0 0 1 536 86 V176 A16 16 0 0 1 520 192 H340 L300 226 V192 H250 A16 16 0 0 1 234 176 V86 A16 16 0 0 1 250 70 Z" fill="rgba(255,255,255,0.09)"/>
          <path d="M268 108 H500 M268 134 H470 M268 160 H430" stroke="rgba(255,255,255,0.26)"/>
          <circle cx="150" cy="310" r="32" fill="rgba(255,255,255,0.10)"/>
          <path d="M92 450 C92 380 208 380 208 450 Z" fill="rgba(255,255,255,0.10)"/>
          <circle cx="490" cy="310" r="32" fill="rgba(255,255,255,0.10)"/>
          <path d="M432 450 C432 380 548 380 548 450 Z" fill="rgba(255,255,255,0.10)"/>
          <circle cx="320" cy="290" r="40" fill="rgba(255,255,255,0.10)"/>
          <path d="M240 450 C240 366 400 366 400 450 Z" fill="rgba(255,255,255,0.10)"/>
          <path d="M40 450 H600"/>
          <path d="M40 450 V490 H600 V450" stroke="rgba(255,255,255,0.2)"/>
        </svg>
      </div>
      <div class="slide-photo"></div>
      <div class="slide-overlay"></div>
      <div class="container slide-content">
        <div class="slide-text">
          <div class="hero-label">Aspirasi Mahasiswa</div>
          <h1>Rumah Aspirasi Mahasiswa UII</h1>
          <p class="lead">Setiap kritik, saran, dan gagasan mahasiswa dicatat dan diteruskan kepada pihak yang berwenang untuk ditindaklanjuti.</p>
          <div class="hero-actions">
            <a href="#aspirasi" class="btn">Sampaikan Aspirasi <svg viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
          </div>
        </div>
      </div>
    </div>

    <!-- Kontrol -->
    <div class="slider-bar">
      <div class="container slider-bar-inner">
        <div class="counter"><b id="curNo">01</b> <span>/ <span id="totNo">03</span></span></div>
        <div class="dots" role="tablist" aria-label="Pilih banner">
          <button class="dot active" aria-label="Banner 1"></button>
          <button class="dot" aria-label="Banner 2"></button>
          <button class="dot" aria-label="Banner 3"></button>
        </div>
        <div class="arrows">
          <button class="arrow" id="prevBtn" aria-label="Banner sebelumnya"><svg viewBox="0 0 24 24"><path d="M15 6l-6 6 6 6"/></svg></button>
          <button class="arrow" id="nextBtn" aria-label="Banner berikutnya"><svg viewBox="0 0 24 24"><path d="M9 6l6 6-6 6"/></svg></button>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ================= AKSES CEPAT ================= -->
<nav class="quick-access" aria-label="Akses cepat">
  <div class="container qa-grid">
    <a class="qa-item" href="/produk-hukum">
      <span class="ic"><svg viewBox="0 0 24 24"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h6"/></svg></span>
      <span><strong>Produk Hukum</strong><small>Arsip peraturan resmi</small></span>
    </a>
    <a class="qa-item" href="/dana/distribusi-dana">
      <span class="ic"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v10M9.5 9.5h4a1.5 1.5 0 0 1 0 3h-3a1.5 1.5 0 0 0 0 3H15"/></svg></span>
      <span><strong>Keuangan</strong><small>Distribusi, LPJ, dan LHA</small></span>
    </a>
    <a class="qa-item" href="/laporan-kinerja">
      <span class="ic"><svg viewBox="0 0 24 24"><path d="M4 20V10M10 20V4M16 20v-7M2 20h20"/></svg></span>
      <span><strong>Laporan Kinerja</strong><small>Capaian kerja lembaga</small></span>
    </a>
    <a class="qa-item" href="/keputusan">
      <span class="ic"><svg viewBox="0 0 24 24"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="m9 14 2 2 4-4"/></svg></span>
      <span><strong>Surat Keputusan</strong><small>Keputusan resmi dewan</small></span>
    </a>
    <a class="qa-item" href="#aspirasi">
      <span class="ic"><svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H8l-5 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></span>
      <span><strong>Aspirasi</strong><small>Sampaikan masukan Anda</small></span>
    </a>
  </div>
</nav>

<!-- ================= FUNGSI ================= -->
<section class="block" id="fungsi">
  <div class="container">
    <div class="sec-head reveal">
      <div>
        <span class="eyebrow">Tentang DPM UII</span>
        <h2>3 Fungsi Utama</h2>
        <p>Dewan Permusyawaratan Mahasiswa <br>Universitas Islam Indonesia</p>
      </div>
      <a href="/tentang/profil-dewan" class="link-more">Profil Dewan
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
      </a>
    </div>

    <div class="grid g3">
      <div class="card hov reveal">
        <span class="num">01</span>
        <div class="icon-box"><svg viewBox="0 0 24 24"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h6"/></svg></div>
        <h3>Legislasi</h3>
        <p>Dalam menjalankan fungsi legislasi, DPM UII bertugas merancang, membahas, dan menetapkan seluruh produk hukum yang berlaku di lingkungan mahasiswa. Tugas ini mencakup penetapan aturan tertinggi seperti Peraturan Dasar Keluarga Mahasiswa (PDKM UII) dan Garis-garis Besar Haluan KM UII (GBHKM UII), hingga pembentukan Peraturan KM, Peraturan DPM, serta Keputusan DPM UII yang menjadi acuan legalitas seluruh aktivitas organisasi kampus.</p>
      </div>
      <div class="card hov reveal d1">
        <span class="num">02</span>
        <div class="icon-box"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3M11 8v6M8 11h6"/></svg></div>
        <h3>Anggaran</h3>
        <p>Dalam fungsi anggaran, DPM UII memiliki wewenang penuh untuk membahas dan menetapkan arah kebijakan keuangan Keluarga Mahasiswa. Hal ini meliputi penetapan besaran sumber dana KM UII, pengalokasian anggaran kerja operasional bagi lembaga legislatif, eksekutif (LEM UII), maupun lembaga-lembaga khusus, serta penyusunan aturan distribusi dan pertanggungjawaban dana kemahasiswaan.</p>
      </div>
      <div class="card hov reveal d2">
        <span class="num">03</span>
        <div class="icon-box"><svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H8l-5 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
        <h3>Pengawasan</h3>
        <p>Dalam fungsi pengawasan, DPM UII berperan mengawal jalannya roda kepengurusan agar tetap sesuai dengan aturan hukum dan garis kebijakan yang berlaku. DPM UII memverifikasi rencana strategis dan program kerja LEM UII di awal periode, memberikan instruksi secara periodik atas pelaksanaan program kerja dan laporan keuangan LEM UII per triwulan, serta melakukan koordinasi secara periodik terhadap laporan keuangan dan kegiatan Lembaga Khusus melalui Rapat Dengar Pendapat (RDP) per triwulan. Pengawasan ini diakhiri dengan kewenangan menilai (baik menerima atau menolak) Laporan Pertanggungjawaban (LPJ) Keuangan lembaga tingkat universitas dan fakultas, serta Laporan Akhir Jabatan LEM UII.</p>
      </div>
    </div>
  </div>
</section>

<!-- ================= PRODUK HUKUM ================= -->
<section class="block alt" id="produk-hukum">
  <div class="container">
    <div class="sec-head reveal">
      <div>
        <span class="eyebrow">Produk Hukum</span>
        <h2>Landasan hukum Keluarga Mahasiswa UII</h2>
        <p>Akses arsip peraturan resmi berdasarkan jenisnya.</p>
      </div>
      <a href="/produk-hukum" class="link-more">Lihat semua arsip
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
      </a>
    </div>

    <div class="grid g4">
      <a href="{{ route('legal-products.type', 'pdkm') }}" class="card law reveal">
        <span class="tag">Produk Hukum</span>
        <div class="abbr">PDKM</div>
        <p>Peraturan Dasar Keluarga Mahasiswa</p>
        <span class="go">Buka arsip <svg viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
      </a>
      <a href="{{ route('legal-products.type', 'gbhkm') }}" class="card law reveal d1">
        <span class="tag">Produk Hukum</span>
        <div class="abbr">GBHKM</div>
        <p>Garis-Garis Besar Haluan Keluarga Mahasiswa</p>
        <span class="go">Buka arsip <svg viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
      </a>
      <a href="{{ route('legal-products.type', 'pkm') }}" class="card law reveal d2">
        <span class="tag">Produk Hukum</span>
        <div class="abbr">PKM</div>
        <p>Peraturan Keluarga Mahasiswa</p>
        <span class="go">Buka arsip <svg viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
      </a>
      <a href="{{ route('legal-products.type', 'pdpm') }}" class="card law reveal d3">
        <span class="tag">Produk Hukum</span>
        <div class="abbr">PDPM-U</div>
        <p>Peraturan Dewan Permusyawaratan Mahasiswa</p>
        <span class="go">Buka arsip <svg viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
      </a>
    </div>
  </div>
</section>

<!-- ================= ALAT KELENGKAPAN ================= -->
<section class="block" id="unit">
  <div class="container">
    <div class="sec-head reveal">
      <div>
        <span class="eyebrow">Alat Kelengkapan</span>
        <h2>Badan dan unit kerja DPM UII</h2>
        <p>Enam alat kelengkapan yang menggerakkan kerja parlemen mahasiswa.</p>
      </div>
    </div>

    <div class="grid g3">
      <a href="/unit/mentari" class="card unit reveal"><div><h3>Mentari</h3><p>Media &amp; Kesekretariatan</p></div></a>
      <a href="/unit/badan-legislasi" class="card unit reveal d1"><div><h3>Baleg</h3><p>Badan Legislasi</p></div></a>
      <a href="/unit/badan-pengawasan" class="card unit reveal d2"><div><h3>Bawas</h3><p>Badan Pengawasan</p></div></a>
      <a href="/unit/badan-kerjasama-advokasi-dan-jaringan" class="card unit reveal"><div><h3>Bosaj</h3><p>Badan Kerjasama, Advokasi &amp; Jaringan</p></div></a>
      <a href="/unit/badan-audit-kemahasiswaan" class="card unit reveal d1"><div><h3>BAK</h3><p>Badan Audit Kemahasiswaan</p></div></a>
      <a href="/unit/badan-pengelola-aset" class="card unit reveal d2"><div><h3>BPA</h3><p>Badan Pengelola Aset</p></div></a>
    </div>
  </div>
</section>

<!-- ================= BERITA & PENGUMUMAN ================= -->
<section class="block alt" id="berita">
  <div class="container">
    <div class="sec-head reveal">
      <div>
        <span class="eyebrow">Kabar Parlemen</span>
        <h2>Berita dan pengumuman terbaru</h2>
      </div>
    </div>

    <div class="two">
      <div class="reveal">
        <div class="panel-title">
          <h3>Berita Kegiatan</h3>
          <a href="/berita" class="link-more">Semua berita</a>
        </div>
        <div class="news-list">
          @forelse($latestNews as $post)
            <a href="{{ $post->url }}" class="card news-item">
              <div class="news-thumb">
                @if($post->featured_image)
                  <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" loading="lazy">
                @else
                  <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="2"/><path d="m21 16-5-5-9 9"/></svg>
                @endif
              </div>
              <div>
                <div class="meta">{{ $post->category?->name ?? 'Berita' }} · {{ $post->published_at?->translatedFormat('d M Y') }}</div>
                <h3>{{ Str::limit($post->title, 60) }}</h3>
                <p>{{ Str::limit($post->excerpt ?? $post->body, 120) }}</p>
              </div>
            </a>
          @empty
            <div class="card news-item" style="justify-content:center;padding:32px;color:var(--t-cap);">
              Belum ada berita kegiatan.
            </div>
          @endforelse
        </div>
      </div>

      <div class="reveal d1">
        <div class="panel-title">
          <h3>Pengumuman</h3>
          <a href="/pengumuman" class="link-more">Semua</a>
        </div>
        <div class="notice-list">
          @forelse($latestAnnouncements as $post)
            <a href="{{ $post->url }}" class="card notice">
              <div class="date-box">
                <strong>{{ $post->published_at?->format('d') }}</strong>
                <span>{{ $post->published_at?->format('M') }}</span>
              </div>
              <h3>{{ Str::limit($post->title, 70) }}</h3>
            </a>
          @empty
            <div class="card notice" style="grid-template-columns:1fr;padding:24px;text-align:center;color:var(--t-cap);">
              Belum ada pengumuman.
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ================= KEUANGAN & LAPORAN ================= -->
<section class="block" id="dokumen">
  <div class="container">
    <div class="sec-head reveal">
      <div>
        <span class="eyebrow">Transparansi</span>
        <h2>Keuangan, laporan, dan keputusan</h2>
        <p>Dokumen publik sebagai bentuk akuntabilitas kepada seluruh mahasiswa.</p>
      </div>
    </div>

    <div class="grid g3">
      <a href="/dana/distribusi-dana" class="card quick reveal"><div><span class="t">Distribusi Keuangan</span><small>Alokasi dana lembaga KM UII</small></div><svg viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
      <a href="/dana/lpj" class="card quick reveal d1"><div><span class="t">LPJ</span><small>Laporan pertanggungjawaban</small></div><svg viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
      <a href="/dana/lha" class="card quick reveal d2"><div><span class="t">LHA</span><small>Laporan hasil audit</small></div><svg viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
      <a href="/laporan-kinerja" class="card quick reveal"><div><span class="t">Laporan Kinerja</span><small>Capaian kerja DPM UII</small></div><svg viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
      <a href="/keputusan" class="card quick reveal d1"><div><span class="t">Keputusan</span><small>Surat keputusan resmi</small></div><svg viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
      <a href="/dokumen" class="card quick reveal d2"><div><span class="t">Semua Dokumen</span><small>Arsip dokumen lengkap</small></div><svg viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
    </div>
  </div>
</section>

<!-- ================= ASPIRASI ================= -->
<section class="block alt" id="aspirasi">
  <div class="container aspirasi">
    <div class="reveal">
      <span class="eyebrow">Aspirasi</span>
      <h2>Suaramu menentukan arah Keluarga Mahasiswa</h2>
      <p style="color:var(--t-sub);font-size:15.5px;max-width:480px">Sampaikan kritik, saran, atau gagasanmu langsung kepada DPM UII. Setiap aspirasi dicatat dan diteruskan kepada pihak yang berwenang.</p>
      <span class="hash">#RumahAspirasiMahasiswa</span>
    </div>

    <form class="card form-card reveal d1" id="aspirasiForm" novalidate>
      <div class="field">
        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" placeholder="Nama lengkap" required>
        <span class="msg-err">Nama wajib diisi.</span>
      </div>
      <div class="field">
        <label for="kontak">Email / NIM</label>
        <input type="text" id="kontak" name="kontak" placeholder="email@students.uii.ac.id atau NIM" required>
        <span class="msg-err">Email atau NIM wajib diisi.</span>
      </div>
      <div class="field">
        <label for="pesan">Aspirasi</label>
        <textarea id="pesan" name="pesan" placeholder="Tuliskan aspirasimu di sini..." required></textarea>
        <span class="msg-err">Aspirasi wajib diisi.</span>
      </div>
      <button type="submit" class="btn">Kirim Aspirasi
        <svg viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
      </button>
      <div class="success" id="formSuccess" role="status">Terima kasih, aspirasimu telah kami terima.</div>
    </form>
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

  // Tanggal pada top bar
  try {
    document.getElementById('today').textContent =
      new Date().toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
  } catch (e) {}

  // Hero slider
  (function () {
    const slider = document.getElementById('slider');
    const slides = [...slider.querySelectorAll('.slide')];
    const dots = [...slider.querySelectorAll('.dot')];
    const cur = document.getElementById('curNo');
    const tot = document.getElementById('totNo');
    const DUR = 7000;
    const pad = n => String(n).padStart(2, '0');
    let i = 0, timer = null;
    let hold = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    tot.textContent = pad(slides.length);

    // pasang foto bila file tersedia
    slides.forEach(s => {
      const src = s.dataset.img;
      if (!src) return;
      const im = new Image();
      im.onload = () => {
        s.querySelector('.slide-photo').style.backgroundImage = 'url("' + src + '")';
        s.classList.add('has-photo');
      };
      im.src = src;
    });

    function schedule() {
      clearTimeout(timer);
      if (!hold) timer = setTimeout(() => go(i + 1), DUR);
    }
    function go(n) {
      i = (n + slides.length) % slides.length;
      slides.forEach((s, k) => s.classList.toggle('active', k === i));
      dots.forEach((d, k) => {
        d.classList.remove('active');
        if (k === i) { void d.offsetWidth; d.classList.add('active'); }
      });
      cur.textContent = pad(i + 1);
      schedule();
    }

    document.getElementById('prevBtn').addEventListener('click', () => go(i - 1));
    document.getElementById('nextBtn').addEventListener('click', () => go(i + 1));
    dots.forEach((d, k) => d.addEventListener('click', () => go(k)));

    slider.addEventListener('mouseenter', () => { clearTimeout(timer); slider.classList.add('paused'); });
    slider.addEventListener('mouseleave', () => { slider.classList.remove('paused'); go(i); });

    let x0 = null;
    slider.addEventListener('touchstart', e => { x0 = e.touches[0].clientX; }, { passive: true });
    slider.addEventListener('touchend', e => {
      if (x0 === null) return;
      const dx = e.changedTouches[0].clientX - x0;
      if (Math.abs(dx) > 50) go(i + (dx < 0 ? 1 : -1));
      x0 = null;
    });

    schedule();
  })();

  // Form aspirasi (demo: sambungkan ke endpoint sebenarnya)
  const form = document.getElementById('aspirasiForm');
  const ok = document.getElementById('formSuccess');
  form.addEventListener('submit', e => {
    e.preventDefault();
    let valid = true;
    form.querySelectorAll('.field').forEach(f => {
      const input = f.querySelector('input, textarea');
      const bad = !input.value.trim();
      f.classList.toggle('err', bad);
      if (bad) valid = false;
    });
    if (!valid) { ok.classList.remove('show'); return; }
    ok.classList.add('show');
    form.reset();
  });
</script>
@endpush
