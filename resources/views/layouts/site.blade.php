@php
    $siteName = $siteSettings['site_name'] ?? 'DPM UII';
    $tagline = $siteSettings['site_tagline'] ?? 'Dewan Permusyawaratan Mahasiswa UII';
    $contactEmail = $siteSettings['contact_email'] ?? 'dpm@uii.ac.id';
    $contactPhone = $siteSettings['contact_phone'] ?? '0815 1109 2004';
    $contactAddress = $siteSettings['contact_address'] ?? 'Kampus Terpadu UII, Jl. Kaliurang KM 14,5, Sleman, Yogyakarta';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#001E43">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="@yield('meta_description', $siteSettings['meta_description'] ?? 'Portal resmi Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia: produk hukum, laporan, dana, berita, pengumuman, dan aspirasi mahasiswa.')">
<title>@yield('title', $siteName.' – '.$tagline)</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Wix+Madefor+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
  *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

  :root {
    --navy:        #001E43;
    --navy-footer: #001633;
    --navy-card:   #001A3A;
    --navy-hover:  #002451;
    --navy-active: #002A5A;
    --white:       #FFFFFF;
    --t-body:      rgba(255,255,255,0.85);
    --t-sub:       rgba(255,255,255,0.75);
    --t-cap:       rgba(255,255,255,0.62);
    --b-default:   rgba(255,255,255,0.10);
    --b-btn:       rgba(255,255,255,0.30);
    --b-btn-hover: rgba(255,255,255,0.55);
    --bg-hover:    rgba(255,255,255,0.06);
    --sh-sm: 0 4px 12px rgba(0,0,0,0.25);
    --sh-md: 0 8px 24px rgba(0,0,0,0.40);
    --sh-lg: 0 16px 48px rgba(0,0,0,0.55);
    --container: 1200px;
  }

  html { scroll-behavior: smooth; scroll-padding-top: 90px; }

  body {
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    background: var(--navy);
    color: var(--t-body);
    line-height: 1.7;
    -webkit-font-smoothing: antialiased;
    overflow-x: hidden;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }

  main#konten {
    flex: 1;
  }

  a { color: inherit; text-decoration: none; }
  button, input, textarea { font-family: inherit; }
  button { cursor: pointer; }
  img { max-width: 100%; display: block; }
  svg { display: block; }

  h1, h2, h3, h4 { font-family: 'Wix Madefor Display', 'Inter', sans-serif; color: var(--white); }
  h1 { font-weight: 800; }
  h2 { font-weight: 700; }
  h3 { font-weight: 600; }

  .container { width: 100%; max-width: var(--container); margin: 0 auto; padding: 0 24px; }

  /* ---------- Buttons: always outline ---------- */
  .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 13px 26px;
    background: transparent;
    border: 1px solid var(--b-btn);
    border-radius: 6px;
    color: var(--white);
    font-size: 14px;
    font-weight: 600;
    transition: border-color .2s, background .2s;
  }
  .btn:hover { border-color: var(--b-btn-hover); background: var(--bg-hover); }
  .btn svg { width: 14px; height: 14px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; transition: transform .2s; }
  .btn:hover svg { transform: translateX(3px); }

  .link-more {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: 13px; font-weight: 600; color: var(--white);
    border-bottom: 1px solid var(--b-btn);
    padding-bottom: 2px;
    transition: border-color .2s;
  }
  .link-more:hover { border-color: var(--b-btn-hover); }

  /* ---------- Header + Mega menu ---------- */
  .header {
    position: sticky; top: 0; z-index: 100;
    background: rgba(0,30,67,0.92);
    backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--b-default);
  }
  .header-inner { display: flex; align-items: stretch; justify-content: space-between; gap: 24px; height: 72px; }

  .logo { display: flex; align-items: center; flex-shrink: 0; }
  .logo img { max-height: 42px; width: auto; object-fit: contain; }
  .logo-fallback { display: none; align-items: center; gap: 8px; font-family: 'Wix Madefor Display', sans-serif; font-weight: 800; font-size: 18px; letter-spacing: 1px; color: var(--white); }
  .logo-fallback span { border: 2px solid var(--white); border-radius: 4px; padding: 3px 10px; }

  .nav { display: flex; height: 100%; }
  .nav-menu { display: flex; align-items: stretch; list-style: none; height: 100%; margin: 0; padding: 0; }
  .nav-item { display: flex; }
  .nav-item > a {
    position: relative;
    display: inline-flex; align-items: center; gap: 6px;
    padding: 0 11px;
    font-size: 12px; font-weight: 600; letter-spacing: .5px; text-transform: uppercase;
    color: var(--white); white-space: nowrap;
    transition: background .2s;
  }
  .nav-item > a::after {
    content: ''; position: absolute; left: 11px; right: 11px; bottom: 0; height: 2px;
    background: var(--white); transform: scaleX(0); transform-origin: left; transition: transform .25s;
  }
  .nav-item:hover > a, .nav-item:focus-within > a { background: var(--bg-hover); }
  .nav-item:hover > a::after, .nav-item:focus-within > a::after { transform: scaleX(1); }
  .nav-item .chev { width: 9px; height: 9px; fill: currentColor; opacity: .65; transition: transform .25s; }
  .nav-item:hover .chev, .nav-item:focus-within .chev { transform: rotate(180deg); }

  .mega {
    position: absolute; left: 0; right: 0; top: 100%;
    background: var(--navy-card);
    border-top: 1px solid var(--b-default); border-bottom: 1px solid var(--b-default);
    box-shadow: var(--sh-lg);
    opacity: 0; visibility: hidden; pointer-events: none; transform: translateY(8px);
    transition: opacity .2s ease, transform .2s ease, visibility .2s;
    /* Limit height to viewport */
    max-height: calc(100vh - 100px);
    overflow: hidden;
  }
  .nav-item:hover .mega, .nav-item:focus-within .mega { opacity: 1; visibility: visible; pointer-events: auto; transform: none; }

  .mega-inner { max-width: var(--container); margin: 0 auto; display: grid; grid-template-columns: 27% 31% 42%; min-height: 290px; height: 100%; }

  .mega-info { padding: 38px 28px 28px 24px; }
  .mega-info .eyebrow { margin-bottom: 10px; }
  .mega-info h2 { font-size: 24px; letter-spacing: -.4px; line-height: 1.2; margin-bottom: 14px; }
  .mega-info > p { font-size: 13.5px; color: var(--t-cap); line-height: 1.65; }
  .mega-docs { display: grid; gap: 16px; margin-top: 22px; padding-top: 20px; border-top: 1px solid var(--b-default); }
  .mega-docs a { display: block; font-size: 13px; line-height: 1.5; color: var(--t-body); transition: color .2s; }
  .mega-docs a:hover { color: var(--white); text-decoration: underline; text-underline-offset: 3px; }
  .mega-docs small { display: block; margin-top: 3px; font-size: 11.5px; font-weight: 500; letter-spacing: .3px; color: var(--t-cap); }

  .mega-links { display: flex; flex-direction: column; padding: 22px 24px; background: var(--navy-footer); border-left: 1px solid var(--b-default); border-right: 1px solid var(--b-default); 
    /* Add scrolling for many items */
    max-height: 100%; overflow-y: auto; 
  }
  .mega-links a { display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 12px 0; border-bottom: 1px solid var(--b-default); font-size: 13.5px; font-weight: 600; line-height: 1.4; color: var(--white); }
  .mega-links a:last-child { border-bottom: 0; }
  .mega-links a small { display: block; margin-top: 2px; font-size: 11.5px; font-weight: 400; color: var(--t-cap); }
  .mega-links a::after { content: '→'; flex-shrink: 0; opacity: .4; transition: transform .2s, opacity .2s; }
  .mega-links a:hover::after { transform: translateX(4px); opacity: 1; }
  .mega-links a:hover { background: var(--bg-hover); margin: 0 -12px; padding-left: 12px; padding-right: 12px; }

  /* Custom scrollbar for mega menu */
  .mega-links::-webkit-scrollbar { width: 6px; }
  .mega-links::-webkit-scrollbar-track { background: transparent; }
  .mega-links::-webkit-scrollbar-thumb { background: var(--b-btn); border-radius: 3px; }
  .mega-links::-webkit-scrollbar-thumb:hover { background: var(--b-btn-hover); }

  .mega-feature { position: relative; display: block; min-height: 290px; overflow: hidden; background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%); }
  .mega-feature::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 26px); }
  .mf-art { position: absolute; inset: 0 0 64px; display: grid; place-items: center; overflow: hidden; }
  .mf-art img { width: 100%; height: 100%; object-fit: cover; }
  .mega-feature img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; transition: transform .6s ease; }
  .mega-feature:hover img { transform: scale(1.04); }
  .mf-cap { position: absolute; left: 0; right: 0; bottom: 0; z-index: 2; padding: 14px 68px 14px 20px; background: rgba(0,22,51,.93); border-top: 1px solid var(--b-btn); }
  .mf-cap strong { display: block; margin-bottom: 2px; font-family: 'Wix Madefor Display', sans-serif; font-size: 15px; font-weight: 700; color: var(--white); }
  .mf-cap span { display: block; font-size: 12.5px; line-height: 1.45; color: var(--t-sub); }
  .mf-arrow { position: absolute; right: 16px; bottom: 16px; z-index: 3; width: 32px; height: 32px; display: grid; place-items: center; border: 1px solid var(--b-btn); border-radius: 6px; color: var(--white); font-size: 15px; transition: border-color .2s, background .2s; }
  .mega-feature:hover .mf-arrow { border-color: var(--b-btn-hover); background: var(--bg-hover); }

  .hamburger { display: none; align-self: center; width: 42px; height: 42px; border-radius: 6px; border: 1px solid var(--b-btn); background: transparent; color: var(--white); place-items: center; }
  .hamburger svg { width: 18px; height: 18px; stroke: currentColor; stroke-width: 2; fill: none; stroke-linecap: round; }

  /* ---------- Footer ---------- */
  .footer { background: var(--navy-footer); border-top: 1px solid var(--b-default); padding: 64px 0 0; }
  .footer-grid { display: grid; grid-template-columns: 1.5fr 1fr 1fr; gap: 48px; padding-bottom: 48px; }
  .footer-logo { margin-bottom: 20px; min-height: 42px; }
  .footer-logo img { max-height: 42px; width: auto; }
  .footer-brand p { font-size: 13.5px; color: var(--t-cap); max-width: 340px; }
  .footer h4 { font-size: 13px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 18px; }
  .footer ul { list-style: none; display: flex; flex-direction: column; gap: 10px; margin: 0; padding: 0; }
  .footer ul a, .footer ul li { font-size: 13.5px; color: var(--t-cap); transition: color .2s; }
  .footer ul a:hover { color: var(--white); }
  .social { display: flex; gap: 8px; margin-top: 22px; }
  .social a { width: 38px; height: 38px; display: grid; place-items: center; border: 1px solid var(--b-btn); border-radius: 50%; color: var(--white); transition: background .2s, border-color .2s; }
  .social a:hover { background: var(--bg-hover); border-color: var(--b-btn-hover); }
  .social svg { width: 16px; height: 16px; fill: currentColor; }
  .footer-bottom { border-top: 1px solid var(--b-default); padding: 22px 0; text-align: center; font-size: 12.5px; color: var(--t-cap); }
  .footer-bottom strong { color: var(--white); font-weight: 700; }

  /* ---------- Common Eyebrow ---------- */
  .eyebrow { display: block; margin-bottom: 12px; font-size: 12px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--t-cap); }

  /* ---------- Reveal Animation ---------- */
  .reveal { opacity: 0; transform: translateY(24px); transition: opacity .7s ease, transform .7s ease; }
  .reveal.in { opacity: 1; transform: none; }
  .d1 { transition-delay: .08s; } .d2 { transition-delay: .16s; } .d3 { transition-delay: .24s; } .d4 { transition-delay: .32s; }
  @media (prefers-reduced-motion: reduce) {
    .reveal { opacity: 1 !important; transform: none !important; transition: none !important; }
  }

  /* ---------- Responsive ---------- */
  @media (max-width: 1240px) {
    .nav-item > a { padding: 0 9px; font-size: 11.5px; letter-spacing: .3px; }
    .nav-item > a::after { left: 9px; right: 9px; }
  }
  @media (max-width: 1080px) {
    .header-inner { height: 88px !important; }
    .hamburger { display: grid; width: 48px; height: 48px; }
    .nav {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      width: 100% !important;
      height: calc(100vh - 88px) !important;
      height: calc(100dvh - 88px) !important;
      min-height: calc(100vh - 88px) !important;
      min-height: calc(100dvh - 88px) !important;
      box-sizing: border-box !important;
      background: var(--navy-card);
      border-bottom: 1px solid var(--b-default);
      box-shadow: var(--sh-lg);
      overflow-y: auto;
      -webkit-overflow-scrolling: touch;
      padding: 12px 24px 48px !important;
      z-index: 999;
    }
    .nav.open {
      display: block !important;
    }
    .nav-inner {
      display: block !important;
      width: 100% !important;
      box-sizing: border-box !important;
      padding: 0 !important;
      border: none !important;
    }
    .nav .nav-menu,
    .nav.open .nav-menu {
      display: flex !important;
      flex-direction: column !important;
      width: 100% !important;
      height: auto !important;
      margin: 0 !important;
      padding: 0 !important;
      list-style: none !important;
    }
    .nav .nav-item,
    .nav.open .nav-item {
      display: flex !important;
      flex-direction: column !important;
      width: 100% !important;
      height: auto !important;
      box-sizing: border-box !important;
    }
    .nav .nav-item > a,
    .nav.open .nav-item > a {
      display: flex !important;
      width: 100% !important;
      box-sizing: border-box !important;
      padding: 15px 0 !important;
      justify-content: space-between !important;
      align-items: center !important;
      border-bottom: 1px solid var(--b-default) !important;
      font-size: 13px !important;
      font-weight: 600 !important;
      letter-spacing: .5px !important;
      text-transform: uppercase !important;
      color: var(--white) !important;
      white-space: normal !important;
    }
    .nav .nav-item > a::after,
    .nav.open .nav-item > a::after {
      display: none !important;
    }
    .nav .nav-item:hover > a,
    .nav .nav-item:focus-within > a,
    .nav.open .nav-item:hover > a,
    .nav.open .nav-item:focus-within > a {
      background: transparent !important;
    }
    .nav-item .chev,
    .nav.open .nav-item .chev {
      margin-left: auto !important;
      flex-shrink: 0 !important;
      width: 10px !important;
      height: 10px !important;
      opacity: .75 !important;
      transition: transform .25s ease !important;
    }
    .nav-item.open .chev,
    .nav.open .nav-item.open .chev {
      transform: rotate(180deg) !important;
    }
    .mega {
      position: static !important;
      width: 100% !important;
      box-sizing: border-box !important;
      opacity: 1 !important;
      visibility: visible !important;
      pointer-events: auto !important;
      transform: none !important;
      box-shadow: none !important;
      background: transparent !important;
      border: 0 !important;
      max-height: 0;
      overflow: hidden;
      transition: max-height .3s ease !important;
    }
    .nav-item.open .mega,
    .nav.open .nav-item.open .mega {
      max-height: 800px !important;
    }
    .mega-inner {
      display: block !important;
      width: 100% !important;
      min-height: 0 !important;
      padding: 0 !important;
      box-sizing: border-box !important;
    }
    .mega-info,
    .mega-feature {
      display: none !important;
    }
    .mega-feature img {
      display: none !important;
    }
    .mega-links {
      display: flex !important;
      flex-direction: column !important;
      width: 100% !important;
      height: auto !important;
      box-sizing: border-box !important;
      background: transparent !important;
      border: 0 !important;
      padding: 4px 0 10px 14px !important;
      max-height: none !important;
      overflow: visible !important;
    }
    .mega-links a {
      display: flex !important;
      width: 100% !important;
      box-sizing: border-box !important;
      align-items: center !important;
      justify-content: space-between !important;
      gap: 14px !important;
      padding: 12px 0 !important;
      border-bottom: 1px solid var(--b-default) !important;
      font-size: 13.5px !important;
      font-weight: 600 !important;
      line-height: 1.4 !important;
      color: var(--white) !important;
      white-space: normal !important;
    }
    .mega-links a:last-child {
      border-bottom: 0 !important;
    }
    .mega-links a:hover {
      margin: 0 !important;
      padding-left: 0 !important;
      padding-right: 0 !important;
      background: transparent !important;
    }
    .mega-links a::after {
      content: '→' !important;
      flex-shrink: 0 !important;
      margin-left: auto !important;
      opacity: .4 !important;
      transition: transform .2s, opacity .2s !important;
    }
    .mega-links a:hover::after {
      transform: translateX(4px) !important;
      opacity: 1 !important;
    }
    .mega-links::-webkit-scrollbar { width: 4px; }
    .mega-links::-webkit-scrollbar-track { background: transparent; }
    .mega-links::-webkit-scrollbar-thumb { background: var(--b-btn); border-radius: 2px; }
    .footer-grid { grid-template-columns: 1fr 1fr; }
    .footer-brand { grid-column: 1 / -1; }
  }
  @media (max-width: 720px) {
    .footer-grid { grid-template-columns: 1fr; gap: 32px; }
  }
  @media (prefers-reduced-motion: reduce) {
    *, *::before, *::after { animation: none !important; transition: none !important; }
    .reveal { opacity: 1; transform: none; }
  }

  /* Sub-sub menu: Publikasi > Sosialisasi */
  .mega-links .sub-group { border-bottom: 0; }
  .mega-links .sub-parent { border-bottom: 0 !important; padding-bottom: 6px; font-weight: 600; }
  .mega-links .sub-links { margin: 0 0 8px 6px; padding-left: 14px; border-left: 1px solid var(--b-btn); display: flex; flex-direction: column; }
  .mega-links .sub-links a { position: relative; padding: 9px 0 9px 6px; font-size: 13px; font-weight: 500; color: var(--t-sub); border-bottom: 0; }
  .mega-links .sub-links a::before { content: ''; position: absolute; left: -14px; top: 50%; width: 10px; height: 1px; background: var(--b-btn); }
  .mega-links .sub-links a:hover { color: var(--white); }
  @media (max-width: 1080px) {
    .mega-links .sub-links { margin-left: 4px !important; padding-left: 12px !important; border-left: 1px solid var(--b-btn) !important; }
    .mega-links .sub-links a { padding: 10px 0 10px 4px !important; font-size: 13px !important; font-weight: 500 !important; color: var(--t-sub) !important; border-bottom: 0 !important; }
    .mega-links .sub-links a::after { display: none !important; }
    .mega-links .sub-parent { border-bottom: 0 !important; }
  }
</style>

<link rel="stylesheet" href="/build/assets/app-DVB7LGv8.css">
<link rel="stylesheet" href="/build/assets/app-TkRHIDj2.css">

@stack('styles')
</head>
<body>

<!-- ================= HEADER ================= -->
<header class="header">
  <div class="container header-inner">
    <a href="{{ route('home') }}" class="logo" aria-label="DPM UII — Beranda">
      <img src="{{ asset('images/logo-dpm.svg') }}" alt="Logo DPM UII"
           onerror="if(!this.dataset.fb){this.dataset.fb=1;this.src='https://dpm.uii.ac.id/wp-content/uploads/2023/12/LOGO.svg'}else{this.style.display='none';this.nextElementSibling.style.display='inline-flex'}">
      <div class="logo-fallback"><span>DPM</span><span>UII</span></div>
    </a>

    <nav class="nav" id="nav" aria-label="Navigasi utama">
      <ul class="nav-menu">
        <li class="nav-item">
          <a href="{{ route('profil-dewan.index') }}">Profil Dewan</a>
        </li>
        <li class="nav-item">
          <a href="{{ url('/#fungsi') }}">Tentang <svg class="chev" viewBox="0 0 320 512" aria-hidden="true"><path d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"/></svg></a>
          <div class="mega">
            <div class="mega-inner">
              <div class="mega-info">
                <span class="eyebrow">Profil Lembaga</span>
                <h2>Tentang DPM UII</h2>
                <p>Lembaga Legislatif Keluarga Mahasiswa UII yang Menjalankan Fungsi Legislasi, Anggaran, dan Pengawasan.</p>
              </div>
              <div class="mega-links">
                <a href="{{ url('/tentang/sambutan') }}"><span>Sambutan Ketua</span></a>
                <a href="{{ url('/tentang/sejarah') }}"><span>Sejarah KM</span></a>
                <a href="{{ url('/tentang/visi-misi') }}"><span>Visi Misi</span></a>
                <a href="{{ url('/tentang/struktur') }}"><span>Struktur</span></a>
                <a href="{{ url('/tentang/kedudukan-tugas-wewenang') }}"><span>Kedudukan, Tugas dan Wewenang</span></a>
                <a href="{{ url('/tentang/profil-dewan') }}"><span>Profil Dewan</span></a>
              </div>
              <a class="mega-feature" href="{{ url('/tentang/struktur') }}">
                <div class="mf-art" aria-hidden="true"><img src="{{ asset('images/unit-embung.webp') }}" alt="" loading="lazy" style="width: 100%; height: 100%; object-fit: cover;"></div>
                <img src="{{ asset('images/dana-perpus.jpg') }}" alt="" loading="lazy" onerror="this.remove()">
                <div class="mf-cap"><strong>Struktur Organisasi</strong><span>Lihat susunan dan hubungan kerja seluruh alat kelengkapan.</span></div>
                <span class="mf-arrow" aria-hidden="true">↗</span>
              </a>
            </div>
          </div>
        </li>
        <li class="nav-item">
          <a href="{{ url('/#unit') }}">Alat Kelengkapan <svg class="chev" viewBox="0 0 320 512" aria-hidden="true"><path d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"/></svg></a>
          <div class="mega">
            <div class="mega-inner">
              <div class="mega-info">
                <span class="eyebrow">Badan dan Unit Kerja</span>
                <h2>Alat Kelengkapan</h2>
                <p>Alat Kelengkapan merupakan organ pekerja yang dibentuk oleh DPM UII untuk mengoptimalkan kinerja internal dewan selama periode kepengurusan. Alat kelengkapan ini dapat diusulkan oleh setiap perangkat DPM UII dan terdiri dari dua komponen utama, yaitu Badan yang bertugas mengoptimalkan tugas-tugas melekat DPM UII, serta Tim yang dibentuk khusus untuk menangani tugas-tugas tertentu yang bersifat insidental.</p>
              </div>
              <div class="mega-links">
                <a href="{{ url('/unit/mentari') }}"><span>Mentari<small>Media &amp; Kesekretariatan</small></span></a>
                <a href="{{ url('/unit/badan-legislasi') }}"><span>Baleg<small>Badan Legislasi</small></span></a>
                <a href="{{ url('/unit/badan-pengawasan') }}"><span>Bawas<small>Badan Pengawasan</small></span></a>
                <a href="{{ url('/unit/badan-kerjasama-advokasi-dan-jaringan') }}"><span>Bksaj<small>Badan Kerjasama, Advokasi &amp; Jaringan</small></span></a>
                <a href="{{ url('/unit/badan-audit-kemahasiswaan') }}"><span>BAK<small>Badan Audit Kemahasiswaan</small></span></a>
                <a href="{{ url('/unit/badan-pengelola-aset') }}"><span>BPA<small>Badan Pengelola Aset</small></span></a>
              </div>
              <a class="mega-feature" href="{{ url('/tentang/struktur') }}">
                <div class="mf-art" aria-hidden="true"><img src="{{ asset('uploads/assets/embung_compressed.webp') }}" alt="" loading="lazy" style="width: 100%; height: 100%; object-fit: cover;"></div>
                <img src="{{ asset('uploads/assets/faculty_law.jpg') }}" alt="" loading="lazy" onerror="this.remove()">
                <div class="mf-cap"><strong>Struktur Organisasi</strong><span>Lihat susunan dan hubungan kerja seluruh alat kelengkapan.</span></div>
                <span class="mf-arrow" aria-hidden="true">↗</span>
              </a>
            </div>
          </div>
        </li>
        <li class="nav-item">
          <a href="{{ route('legal-products.index') }}">Produk Hukum <svg class="chev" viewBox="0 0 320 512" aria-hidden="true"><path d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"/></svg></a>
          <div class="mega">
            <div class="mega-inner">
              <div class="mega-info">
                <span class="eyebrow">Arsip Resmi</span>
                <h2>Produk Hukum</h2>
                <p>Peraturan resmi Keluarga Mahasiswa UII yang dapat diakses oleh seluruh civitas kemahasiswaan.</p>
                <div class="mega-docs">
                  <a href="{{ route('legal-products.type', 'pkm') }}">PKM UII No. 3 Tahun 2024: Tentang Distribusi dan Alokasi Dana KM UII<small>Peraturan Keluarga Mahasiswa · 2024</small></a>
                  <a href="{{ route('legal-products.type', 'pkm') }}">PKM UII No. 2 Tahun 2024: Tentang Pedoman Kegiatan Kepanitiaan KM UII<small>Peraturan Keluarga Mahasiswa · 2024</small></a>
                </div>
              </div>
              <div class="mega-links">
                <a href="{{ route('legal-products.type', 'pdkm') }}"><span>PDKM<small>Peraturan Dasar Keluarga Mahasiswa</small></span></a>
                <a href="{{ route('legal-products.type', 'gbhkm') }}"><span>GBHKM<small>Garis-Garis Besar Haluan Keluarga Mahasiswa</small></span></a>
                <a href="{{ route('legal-products.type', 'pkm') }}"><span>PKM<small>Peraturan Keluarga Mahasiswa</small></span></a>
                <a href="{{ route('legal-products.type', 'pdpm') }}"><span>PDPM UII<small>Peraturan Dewan Permusyawaratan Mahasiswa</small></span></a>
                <a href="{{ route('legal-products.index') }}"><span>Semua Produk Hukum</span></a>
              </div>
              <a class="mega-feature" href="{{ route('legal-products.index') }}">
                <div class="mf-art" aria-hidden="true"><img src="{{ asset('images/hero-2.jpg') }}" alt="" loading="lazy" style="width: 100%; height: 100%; object-fit: cover;"></div>
                <img src="{{ asset('images/sosialisasi-masjid.webp') }}" alt="" loading="lazy" onerror="this.remove()">
                <div class="mf-cap"><strong>Arsip Produk Hukum</strong><span>Telusuri dan unduh peraturan berdasarkan jenis dan tahun.</span></div>
                <span class="mf-arrow" aria-hidden="true">↗</span>
              </a>
            </div>
          </div>
        </li>
        <li class="nav-item">
          <a href="{{ route('documents.dana') }}">Keuangan <svg class="chev" viewBox="0 0 320 512" aria-hidden="true"><path d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"/></svg></a>
          <div class="mega">
            <div class="mega-inner">
              <div class="mega-info">
                <span class="eyebrow">Transparansi</span>
                <h2>Keuangan</h2>
                <p>Informasi distribusi dan pertanggungjawaban keuangan lembaga Keluarga Mahasiswa UII.</p>
                <div class="mega-docs">
                  <a href="{{ route('legal-products.type', 'pkm') }}">PKM UII No. 3 Tahun 2024: Tentang Distribusi dan Alokasi Dana KM UII<small>Dasar pengaturan distribusi dana</small></a>
                </div>
              </div>
              <div class="mega-links">
                <a href="{{ url('/dana/distribusi-dana') }}"><span>Distribusi Dana<small>Alokasi dana lembaga</small></span></a>
                <a href="{{ url('/dana/lpj') }}"><span>LPJ<small>Laporan pertanggungjawaban keuangan</small></span></a>
                <a href="{{ url('/dana/lha') }}"><span>LHA<small>Laporan hasil audit</small></span></a>
              </div>
              <a class="mega-feature" href="{{ route('documents.dana') }}">
                <div class="mf-art" aria-hidden="true"><img src="{{ asset('images/hero-3.jpg') }}" alt="" loading="lazy" style="width: 100%; height: 100%; object-fit: cover;"></div>
                <img src="{{ asset('uploads/assets/ftsp_compressed.webp') }}" alt="" loading="lazy" onerror="this.remove()">
                <div class="mf-cap"><strong>Transparansi Keuangan</strong><span>Akses laporan pertanggungjawaban dan hasil audit lembaga.</span></div>
                <span class="mf-arrow" aria-hidden="true">↗</span>
              </a>
            </div>
          </div>
        </li>
        <li class="nav-item">
          <a href="{{ url('/laporan-kinerja') }}">LAPORAN KINERJA <svg class="chev" viewBox="0 0 320 512" aria-hidden="true"><path d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"/></svg></a>
        </li>
        <li class="nav-item">
          <a href="{{ route('documents.index') }}">PUBLIKASI <svg class="chev" viewBox="0 0 320 512" aria-hidden="true"><path d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"/></svg></a>
          <div class="mega">
            <div class="mega-inner">
              <div class="mega-info">
                <span class="eyebrow">Publikasi Resmi</span>
                <h2>PUBLIKASI</h2>
                <p>Arsip keputusan, ketetapan, laporan kinerja, berita, dan pengumuman resmi DPM UII dalam satu tempat.</p>
                <div class="mega-docs">
                  <a href="{{ route('documents.index') }}">Arsip Dokumen DPM UII<small>Keputusan, ketetapan, dan laporan per periode</small></a>
                </div>
              </div>
              <div class="mega-links">
                <a href="{{ route('documents.index') }}"><span>Surat Keputusan<small>Keputusan dan ketetapan resmi per periode</small></span></a>
                <a href="{{ route('news.index') }}"><span>Berita Kegiatan<small>Kabar dan dokumentasi kegiatan DPM UII</small></span></a>
                <a href="{{ route('news.announcements') }}"><span>Pengumuman<small>Informasi resmi untuk mahasiswa</small></span></a>
                <div class="sub-group">
                  <a class="sub-parent">Sosialisasi</a>
                  <div class="sub-links">
                    <a href="{{ route('humas.download') }}">Template Dokumen dan Font</a>
                    <a href="{{ route('humas.sosialisasi') }}">Penjelasan Umum Peraturan KM UII</a>
                  </div>
                </div>
              </div>
              <a class="mega-feature" href="{{ route('documents.index') }}">
                <div class="mf-art" aria-hidden="true"><img src="{{ asset('images/hero-4-dokumen.webp') }}" alt="" loading="lazy" style="width: 100%; height: 100%; object-fit: cover;"></div>
                <img src="{{ asset('images/hero-overlay-dokumen.jpg') }}" alt="" loading="lazy" onerror="this.remove()">
                <div class="mf-cap"><strong>Arsip Dokumen</strong><span>Telusuri dokumen resmi DPM UII berdasarkan periode dan jenis.</span></div>
                <span class="mf-arrow" aria-hidden="true">↗</span>
              </a>
            </div>
          </div>
        </li>
      </ul>
    </nav>

    <button class="hamburger" id="hamburger" aria-label="Buka menu" aria-expanded="false">
      <svg viewBox="0 0 24 24"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
    </button>
  </div>
</header>

<main id="konten">
    @yield('content')
</main>

<!-- ================= FOOTER ================= -->
<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <div class="footer-logo">
          <img src="{{ asset('images/logo-dpm.svg') }}" alt="DPM UII" onerror="if(!this.dataset.fb){this.dataset.fb=1;this.src='https://dpm.uii.ac.id/wp-content/uploads/2023/12/LOGO.svg'}else{this.style.display='none'}">
        </div>
        <p>Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia</p>
        <p style="font-size: 13px; color: var(--t-cap); margin-top: 8px;">{{ $contactAddress }}</p>
      </div>

      <div>
        <h4>Produk Hukum</h4>
        <ul>
          <li><a href="{{ route('legal-products.type', 'pdkm') }}">Peraturan Dasar KM UII</a></li>
          <li><a href="{{ route('legal-products.type', 'gbhkm') }}">Garis-Garis Besar Haluan KM UII</a></li>
          <li><a href="{{ route('legal-products.type', 'pkm') }}">Peraturan KM UII</a></li>
          <li><a href="{{ route('legal-products.type', 'pdpm') }}">PDPM UII</a></li>
        </ul>
      </div>

      <div>
        <h4>Sosial Media</h4>
        <div class="social" style="margin-top: 0;">
          <a href="https://www.linkedin.com/company/dpm-uii/" target="_blank" rel="noopener" aria-label="LinkedIn">
            <svg viewBox="0 0 448 512"><path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"/></svg>
          </a>
          <a href="https://www.instagram.com/dpmuii/" target="_blank" rel="noopener" aria-label="Instagram">
            <svg viewBox="0 0 448 512"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
          </a>
          <a href="mailto:{{ $contactEmail }}" aria-label="Email">
            <svg viewBox="0 0 512 512"><path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176v208c0 35.3 28.7 64 64 64h384c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg>
          </a>
          <a href="https://wa.me/6281511092004" target="_blank" rel="noopener" aria-label="WhatsApp">
            <svg viewBox="0 0 448 512"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
          </a>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      Hak Cipta &copy; {{ date('Y') }} <strong>Sekretariat Jenderal DPM UII</strong>
    </div>
  </div>
</footer>

<script>
  // Menu & mega menu
  const hamburger = document.getElementById('hamburger');
  const nav = document.getElementById('nav');
  if (hamburger && nav) {
    hamburger.addEventListener('click', () => {
      const open = nav.classList.toggle('open');
      hamburger.setAttribute('aria-expanded', open);
    });
    document.querySelectorAll('.nav-item').forEach(item => {
      const link = item.querySelector(':scope > a');
      if (item.querySelector('.mega')) {
        link.addEventListener('click', e => {
          if (window.innerWidth <= 1080) { e.preventDefault(); item.classList.toggle('open'); }
        });
      }
    });
    document.querySelectorAll('.mega a, .nav-item:not(:has(.mega)) > a').forEach(a => {
      a.addEventListener('click', () => nav.classList.remove('open'));
    });
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape' && document.activeElement) document.activeElement.blur();
    });
  }

  // Scroll reveal animation for all pages
  const initReveal = () => {
    const reveals = document.querySelectorAll('.reveal');
    if (!reveals.length) return;
    if ('IntersectionObserver' in window) {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('in');
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.02, rootMargin: '0px 0px 50px 0px' });
      reveals.forEach(el => observer.observe(el));
    } else {
      reveals.forEach(el => el.classList.add('in'));
    }
  };
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initReveal);
  } else {
    initReveal();
  }
</script>

@stack('scripts')
</body>
</html>
