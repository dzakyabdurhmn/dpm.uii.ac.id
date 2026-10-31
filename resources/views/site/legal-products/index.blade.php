@extends('layouts.site')

@php
    $typeMeta = $currentType ? ($types[$currentType] ?? null) : null;
    $pageTitle = $typeMeta ? $typeMeta['name'].' ('.$typeMeta['label'].')' : 'Produk Hukum & Peraturan';
    $pageDesc = $typeMeta
        ? $typeMeta['description']
        : 'Koleksi resmi perundang-undangan Keluarga Mahasiswa Universitas Islam Indonesia: Konstitusi Pokok (PDKM & GBHKM), Peraturan Mahasiswa (PKM), dan Peraturan Dewan (PDPM).';
    $numberedProducts = $products->filter(fn ($p) => $p->isNumbered());
    $groupedByYear = $numberedProducts->groupBy(fn ($p) => $p->year ?? 'Tanpa tahun');
@endphp

@section('title', $pageTitle.' — '.($siteSettings['site_name'] ?? 'DPM UII'))
@section('meta_description', Str::limit($pageDesc, 150))

@push('styles')
<style>
  /* ============ SHARED STYLES ============ */
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

  /* ============ TYPE PAGE STYLES (when $currentType is set) ============ */
  @if ($currentType)
  .nav-item.current > a::after { transform: scaleX(1); }
  :focus-visible { outline: 2px solid var(--white); outline-offset: 2px; }
  select option { background: var(--navy-card); color: var(--white); }

  .pg-head { position: relative; border-bottom: 1px solid var(--b-default); padding: 52px 0 56px; overflow: hidden;
    background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%); }
  .pg-head::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 28px); }
  .pg-head-inner { position: relative; display: grid; grid-template-columns: 1.35fr .65fr; gap: 56px; align-items: end; }
  .crumb { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 26px; font-size: 12.5px; color: var(--t-cap); }
  .crumb a { transition: color .2s; } .crumb a:hover { color: var(--white); }
  .crumb span[aria-hidden] { opacity: .5; }
  .crumb span[aria-current] { color: var(--white); font-weight: 600; }
  .pg-head h1 { font-size: clamp(40px, 7vw, 72px); letter-spacing: -2px; line-height: 1.02; margin-bottom: 10px; }
  .pg-sub { font-family: 'Wix Madefor Display', sans-serif; font-size: clamp(16px, 2vw, 20px); font-weight: 600; color: var(--t-body); margin-bottom: 14px; }
  .pg-desc { max-width: 600px; font-size: 15px; color: var(--t-sub); }

  .pg-stats { border: 1px solid var(--b-btn); border-radius: 8px; background: rgba(0,22,51,.55); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); }
  .pg-stat { display: flex; align-items: baseline; justify-content: space-between; gap: 16px; padding: 16px 22px; }
  .pg-stat + .pg-stat { border-top: 1px solid var(--b-default); }
  .pg-stat span { font-size: 12px; font-weight: 600; letter-spacing: 1.2px; text-transform: uppercase; color: var(--t-cap); }
  .pg-stat strong { font-family: 'Wix Madefor Display', sans-serif; font-size: 24px; font-weight: 800; color: var(--white); letter-spacing: -.5px; text-align: right; }

  /* toolbar sticky */
  .pkm-bar { position: sticky; top: 73px; z-index: 50; background: rgba(0,22,51,.95); border-bottom: 1px solid var(--b-default); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); }
  .pkm-bar-inner { padding-top: 14px; padding-bottom: 12px; }
  .bar-row { display: flex; flex-wrap: wrap; align-items: center; gap: 12px; }
  .tb-field { position: relative; flex: 1 1 280px; max-width: 420px; }
  .tb-field svg { position: absolute; left: 14px; top: 50%; width: 16px; height: 16px; margin-top: -8px; stroke: var(--t-cap); fill: none; stroke-width: 2; stroke-linecap: round; pointer-events: none; }
  .tb-input, .tb-select { height: 44px; padding: 0 16px; background: rgba(255,255,255,0.03); border: 1px solid var(--b-default); border-radius: 6px; color: var(--white); font-size: 14px; transition: border-color .2s, background .2s; }
  .tb-input { width: 100%; padding-left: 40px; padding-right: 40px; }
  .tb-input::placeholder { color: rgba(255,255,255,0.38); }
  .tb-input:focus, .tb-select:focus { outline: none; border-color: var(--b-btn-hover); background: rgba(255,255,255,0.05); }
  .tb-clear { position: absolute; right: 6px; top: 50%; width: 30px; height: 30px; margin-top: -15px; display: none; place-items: center; background: transparent; border: 0; border-radius: 6px; color: var(--t-cap); cursor: pointer; }
  .tb-clear:hover { color: var(--white); background: var(--bg-hover); }
  .tb-clear svg { position: static; margin: 0; width: 14px; height: 14px; stroke: currentColor; }
  .tb-field.has .tb-clear { display: grid; }
  .tb-count { margin-left: auto; font-size: 13px; color: var(--t-cap); }
  .tb-count b { color: var(--white); }
  .years { display: flex; gap: 8px; margin-top: 12px; overflow-x: auto; scrollbar-width: none; padding-bottom: 2px; }
  .years::-webkit-scrollbar { display: none; }
  .ypill { flex-shrink: 0; padding: 7px 16px; border-radius: 100px; border: 1px solid var(--b-default); background: transparent; color: var(--t-cap); font-size: 13px; font-weight: 600; cursor: pointer; transition: color .2s, border-color .2s, background .2s; }
  .ypill:hover { color: var(--white); border-color: var(--b-btn); }
  .ypill[aria-pressed="true"] { color: var(--white); background: rgba(255,255,255,.10); border-color: rgba(255,255,255,.4); }
  .ypill small { margin-left: 6px; font-size: 11.5px; font-weight: 500; opacity: .65; }

  /* daftar dokumen */
  .list-wrap { padding: 44px 0 80px; min-height: 420px; }
  .yr { display: flex; align-items: baseline; gap: 14px; margin: 38px 0 16px; font-size: 30px; letter-spacing: -.8px; }
  .yr:first-child { margin-top: 0; }
  .yr span { font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 600; letter-spacing: 1.6px; text-transform: uppercase; color: var(--t-cap); }
  .yr::after { content: ''; flex: 1; height: 1px; background: var(--b-default); align-self: center; }
  .docs { display: grid; gap: 10px; }
  .doc { display: grid; grid-template-columns: 64px 1fr auto; gap: 20px; align-items: center; padding: 18px 20px; background: var(--navy-card); border: 1px solid var(--b-default); border-radius: 8px; transition: border-color .2s, background .2s; }
  .doc:hover { border-color: var(--b-btn); background: var(--navy-hover); }
  .doc-no { height: 64px; display: flex; flex-direction: column; align-items: center; justify-content: center; border: 1px solid var(--b-btn); border-radius: 8px; }
  .doc-no small { font-size: 10px; font-weight: 600; letter-spacing: 1.2px; text-transform: uppercase; color: var(--t-cap); line-height: 1; margin-bottom: 4px; }
  .doc-no b { font-family: 'Wix Madefor Display', sans-serif; font-size: 22px; font-weight: 800; color: var(--white); line-height: 1; }
  .doc-label { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; margin-bottom: 4px; font-size: 12px; font-weight: 600; letter-spacing: .6px; text-transform: uppercase; color: var(--t-cap); }
  .badge { padding: 2px 9px; border: 1px solid var(--b-btn); border-radius: 100px; font-size: 10.5px; letter-spacing: 1px; color: var(--white); }
  .doc h3 { font-size: 17px; line-height: 1.45; letter-spacing: -.1px; }
  .doc mark { background: rgba(255,255,255,.18); color: var(--white); border-radius: 2px; padding: 0 2px; }
  .doc-actions { display: flex; gap: 8px; }
  .btn.sm { padding: 9px 16px; font-size: 13px; }
  .btn.sm svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 1.9; stroke-linecap: round; stroke-linejoin: round; }
  .btn.sm:hover svg { transform: none; }

  .empty { padding: 64px 24px; text-align: center; border: 1px dashed var(--b-btn); border-radius: 8px; color: var(--t-cap); font-size: 14.5px; }
  .empty strong { display: block; margin-bottom: 6px; font-family: 'Wix Madefor Display', sans-serif; font-size: 18px; color: var(--white); }
  .empty .btn { margin-top: 18px; }

  .note { display: flex; align-items: center; justify-content: space-between; gap: 24px; flex-wrap: wrap; margin-top: 48px; padding: 28px 30px; background: var(--navy-card); border: 1px solid var(--b-btn); border-radius: 12px; }
  .note h2 { font-size: 20px; letter-spacing: -.3px; margin-bottom: 4px; }
  .note p { max-width: 520px; font-size: 14px; color: var(--t-sub); }

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

  .totop { position: fixed; right: 20px; bottom: 20px; z-index: 60; width: 44px; height: 44px; display: grid; place-items: center; background: var(--navy-card); border: 1px solid var(--b-btn); border-radius: 50%; color: var(--white); cursor: pointer; box-shadow: var(--sh-md); opacity: 0; visibility: hidden; transform: translateY(8px); transition: opacity .25s, transform .25s, visibility .25s, border-color .2s; }
  .totop.show { opacity: 1; visibility: visible; transform: none; }
  .totop:hover { border-color: var(--b-btn-hover); }
  .totop svg { width: 18px; height: 18px; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; fill: none; }

  @media (max-width: 1080px) {
    .pg-head-inner { grid-template-columns: 1fr; gap: 36px; }
    .pg-stats { display: grid; grid-template-columns: repeat(3, 1fr); }
    .pg-stat { flex-direction: column; align-items: flex-start; gap: 4px; }
    .pg-stat strong { text-align: left; }
    .pg-stat + .pg-stat { border-top: 0; border-left: 1px solid var(--b-default); }
  }
  @media (max-width: 720px) {
    .pg-head { padding: 36px 0 40px; }
    .pg-stat { padding: 14px 14px; } .pg-stat strong { font-size: 16px; white-space: nowrap; }
    .pkm-bar { position: static; }
    .tb-field { max-width: none; }
    .tb-count { margin-left: 0; width: 100%; }
    .doc { grid-template-columns: 52px 1fr; gap: 14px; padding: 16px; }
    .doc-no { height: 52px; } .doc-no b { font-size: 18px; }
    .doc h3 { font-size: 15.5px; }
    .doc-actions { grid-column: 1 / -1; }
    .doc-actions .btn { flex: 1; }
    .yr { font-size: 24px; }
    .note { padding: 22px 20px; }
    .pdlg { width: 100vw; height: 100vh; max-height: 100vh; border-radius: 0; border: 0; }
    .pdlg-head .btn span { display: none; }
  }
  @endif

  /* ============ MAIN INDEX STYLES (when $currentType is null) ============ */
  @if (empty($currentType))
  /* ============ PRODUK HUKUM PAGE - DARK NAVY THEME ============ */
  .law-page {
      background: var(--navy, #001E43);
      color: var(--t-body, rgba(255,255,255,0.85));
      min-height: 80vh;
  }

  .law-wrap {
      width: min(1180px, calc(100% - 40px));
      margin: 0 auto;
  }

  /* ---------- Hero Section ---------- */
  .law-hero {
      position: relative;
      padding: 56px 0 52px;
      background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%);
      border-bottom: 1px solid var(--b-default, rgba(255,255,255,0.10));
      overflow: hidden;
  }
  .law-hero::before {
      content: '';
      position: absolute;
      inset: 0;
      background: repeating-linear-gradient(135deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 28px);
      pointer-events: none;
  }
  .law-hero-inner {
      position: relative;
      display: grid;
      grid-template-columns: 1.4fr .6fr;
      gap: 48px;
      align-items: end;
  }

  .crumb {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 22px;
      font-size: 12.5px;
      color: var(--t-cap, rgba(255,255,255,0.62));
  }
  .crumb a {
      color: inherit;
      transition: color .2s;
  }
  .crumb a:hover {
      color: var(--white, #fff);
  }
  .crumb span[aria-hidden] {
      opacity: .5;
  }
  .crumb span[aria-current] {
      color: var(--white, #fff);
      font-weight: 600;
  }

  .law-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 4px 14px;
      border-radius: 100px;
      background: rgba(255,255,255,0.06);
      border: 1px solid var(--b-btn, rgba(255,255,255,0.30));
      color: var(--white, #fff);
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      margin-bottom: 14px;
  }
  .law-badge svg {
      width: 14px;
      height: 14px;
      stroke: currentColor;
      fill: none;
      stroke-width: 2;
  }

  .law-hero h1 {
      font-family: 'Wix Madefor Display', sans-serif;
      font-size: clamp(30px, 4.6vw, 48px);
      font-weight: 800;
      letter-spacing: -1px;
      line-height: 1.15;
      margin-bottom: 12px;
      color: var(--white, #fff);
  }
  .law-hero-desc {
      max-width: 660px;
      font-size: 14.5px;
      color: var(--t-sub, rgba(255,255,255,0.75));
      line-height: 1.8;
  }

  /* Stats Box */
  .law-stats {
      border: 1px solid var(--b-btn, rgba(255,255,255,0.30));
      border-radius: 8px;
      background: rgba(0, 22, 51, 0.65);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
  }
  .law-stat {
      display: flex;
      align-items: baseline;
      justify-content: space-between;
      gap: 16px;
      padding: 13px 18px;
  }
  .law-stat + .law-stat {
      border-top: 1px solid var(--b-default, rgba(255,255,255,0.10));
  }
  .law-stat span {
      font-size: 11.5px;
      font-weight: 600;
      letter-spacing: 1.2px;
      text-transform: uppercase;
      color: var(--t-cap, rgba(255,255,255,0.62));
  }
  .law-stat strong {
      font-family: 'Wix Madefor Display', sans-serif;
      font-size: 22px;
      font-weight: 800;
      color: var(--white, #fff);
      letter-spacing: -.5px;
  }

  /* ---------- Sticky Nav Bar (Pills/Tabs) ---------- */
  .law-nav-bar {
      position: sticky;
      top: 72px;
      z-index: 40;
      background: rgba(0, 30, 67, 0.95);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-bottom: 1px solid var(--b-default, rgba(255,255,255,0.10));
      padding: 12px 0;
  }
  .law-tabs {
      display: flex;
      align-items: center;
      gap: 8px;
      overflow-x: auto;
      scrollbar-width: none;
  }
  .law-tabs::-webkit-scrollbar { display: none; }
  .law-tab {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 8px 18px;
      border-radius: 6px;
      border: 1px solid var(--b-default, rgba(255,255,255,0.10));
      background: rgba(255,255,255,0.03);
      color: var(--t-sub, rgba(255,255,255,0.75));
      font-size: 13px;
      font-weight: 600;
      text-decoration: none;
      transition: all .2s;
      white-space: nowrap;
  }
  .law-tab:hover {
      color: var(--white, #fff);
      border-color: var(--b-btn, rgba(255,255,255,0.30));
      background: var(--bg-hover, rgba(255,255,255,0.06));
  }
  .law-tab.active {
      color: var(--white, #fff);
      background: var(--navy-hover, #002451);
      border-color: rgba(255,255,255,0.45);
      box-shadow: 0 2px 8px rgba(0,0,0,0.3);
  }
  .law-tab-badge {
      padding: 2px 7px;
      border-radius: 100px;
      font-size: 10.5px;
      font-weight: 700;
      background: rgba(255,255,255,0.08);
      color: var(--t-sub, rgba(255,255,255,0.75));
  }
  .law-tab.active .law-tab-badge {
      background: rgba(255,255,255,0.2);
      color: var(--white, #fff);
  }

  /* ---------- Section Layouts ---------- */
  .law-section {
      padding: 44px 0 72px;
  }
  .sec-title-wrap {
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      gap: 20px;
      margin-bottom: 24px;
      padding-bottom: 16px;
      border-bottom: 1px solid var(--b-default, rgba(255,255,255,0.10));
  }
  .sec-title-wrap h2 {
      font-family: 'Wix Madefor Display', sans-serif;
      font-size: clamp(20px, 3vw, 24px);
      font-weight: 800;
      letter-spacing: -.5px;
      color: var(--white, #fff);
  }
  .sec-title-wrap p {
      font-size: 13px;
      color: var(--t-cap, rgba(255,255,255,0.62));
      margin-top: 4px;
  }

  /* ---------- Singles Grid (PDKM / GBHKM) ---------- */
  .singles-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 20px;
      margin-bottom: 48px;
  }
  .singles-grid.single-col {
      grid-template-columns: 1fr;
      max-width: 820px;
  }
  .single-card {
      display: flex;
      flex-direction: column;
      padding: 28px;
      background: var(--navy-card, #001A3A);
      border: 1px solid var(--b-default, rgba(255,255,255,0.10));
      border-radius: 10px;
      transition: all .25s ease;
      box-shadow: var(--sh-sm, 0 4px 12px rgba(0,0,0,0.25));
  }
  .single-card:hover {
      background: var(--navy-hover, #002451);
      border-color: var(--b-btn, rgba(255,255,255,0.30));
      transform: translateY(-2px);
      box-shadow: var(--sh-md, 0 8px 24px rgba(0,0,0,0.40));
  }
  .single-card-head {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 16px;
      margin-bottom: 16px;
  }
  .tag-type {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 4px;
      background: rgba(255,255,255,0.08);
      border: 1px solid var(--b-btn, rgba(255,255,255,0.30));
      color: var(--white, #fff);
      font-family: 'Wix Madefor Display', sans-serif;
      font-size: 11px;
      font-weight: 800;
      letter-spacing: 1px;
      text-transform: uppercase;
  }
  .status-pill {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 3px 10px;
      border-radius: 100px;
      background: rgba(34, 197, 94, 0.12);
      border: 1px solid rgba(34, 197, 94, 0.35);
      color: #4ade80;
      font-size: 11px;
      font-weight: 600;
  }
  .status-pill svg {
      width: 12px;
      height: 12px;
      stroke: currentColor;
      fill: none;
      stroke-width: 2.5;
  }
  .single-card h3 {
      font-size: 18px;
      font-weight: 700;
      line-height: 1.4;
      margin-bottom: 10px;
      color: var(--white, #fff);
  }
  .single-card p {
      font-size: 13.5px;
      color: var(--t-sub, rgba(255,255,255,0.75));
      line-height: 1.7;
      margin-bottom: 22px;
      flex: 1;
  }
  .single-card-foot {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 14px;
      padding-top: 18px;
      border-top: 1px solid var(--b-default, rgba(255,255,255,0.10));
  }
  .single-card-meta {
      font-size: 12px;
      color: var(--t-cap, rgba(255,255,255,0.62));
  }

  /* ---------- Toolbar (Year Pills + Search) ---------- */
  .law-toolbar {
      display: flex;
      flex-direction: column;
      gap: 16px;
      margin-bottom: 32px;
      background: rgba(0, 26, 58, 0.6);
      border: 1px solid var(--b-default, rgba(255,255,255,0.10));
      border-radius: 10px;
      padding: 18px 22px;
  }
  .law-toolbar-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      flex-wrap: wrap;
  }
  .year-pills {
      display: flex;
      align-items: center;
      gap: 6px;
      overflow-x: auto;
      scrollbar-width: none;
      padding-bottom: 2px;
  }
  .year-pills::-webkit-scrollbar { display: none; }
  .year-pill {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 7px 14px;
      border-radius: 6px;
      border: 1px solid var(--b-default, rgba(255,255,255,0.10));
      background: rgba(255,255,255,0.03);
      color: var(--t-sub, rgba(255,255,255,0.75));
      font-size: 12.5px;
      font-weight: 600;
      cursor: pointer;
      transition: all .2s;
      white-space: nowrap;
  }
  .year-pill:hover {
      color: var(--white, #fff);
      border-color: var(--b-btn, rgba(255,255,255,0.30));
      background: var(--bg-hover, rgba(255,255,255,0.06));
  }
  .year-pill.active {
      color: var(--white, #fff);
      background: var(--navy-hover, #002451);
      border-color: rgba(255,255,255,0.45);
  }
  .year-pill-count {
      padding: 1px 6px;
      border-radius: 100px;
      font-size: 10px;
      background: rgba(255,255,255,0.08);
      color: var(--t-sub, rgba(255,255,255,0.75));
  }
  .year-pill.active .year-pill-count {
      background: rgba(255,255,255,0.2);
      color: var(--white, #fff);
  }

  .law-search {
      position: relative;
      width: 100%;
      max-width: 320px;
  }
  .law-search svg {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      width: 15px;
      height: 15px;
      stroke: var(--t-cap, rgba(255,255,255,0.62));
      fill: none;
      stroke-width: 2;
      pointer-events: none;
  }
  .law-search input {
      width: 100%;
      height: 40px;
      padding: 0 16px 0 38px;
      background: rgba(255,255,255,0.03);
      border: 1px solid var(--b-default, rgba(255,255,255,0.10));
      border-radius: 6px;
      color: var(--white, #fff);
      font-size: 13px;
      transition: all .2s;
  }
  .law-search input:focus {
      outline: none;
      border-color: var(--b-btn-hover, rgba(255,255,255,0.55));
      background: rgba(255,255,255,0.06);
  }
  .law-search input::placeholder {
      color: var(--t-cap, rgba(255,255,255,0.62));
  }

  .law-status-bar {
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-size: 12px;
      color: var(--t-cap, rgba(255,255,255,0.62));
      padding-top: 8px;
      border-top: 1px solid var(--b-default, rgba(255,255,255,0.10));
  }
  .reset-btn {
      color: var(--white, #fff);
      text-decoration: underline;
      text-underline-offset: 3px;
      cursor: pointer;
      background: none;
      border: none;
      font-size: 12px;
      font-weight: 600;
  }

  /* ---------- Numbered Document Cards ---------- */
  .year-group {
      margin-bottom: 38px;
  }
  .year-group-title {
      display: flex;
      align-items: center;
      gap: 14px;
      margin-bottom: 16px;
      font-size: 13px;
      font-weight: 700;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      color: var(--t-cap, rgba(255,255,255,0.62));
  }
  .year-group-title span.count-badge {
      padding: 2px 8px;
      border-radius: 100px;
      font-size: 11px;
      background: rgba(255,255,255,0.08);
      color: var(--white, #fff);
  }
  .year-group-title::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--b-default, rgba(255,255,255,0.10));
  }

  .doc-list {
      display: grid;
      gap: 14px;
  }
  .doc-card {
      display: flex;
      align-items: stretch;
      justify-content: space-between;
      gap: 20px;
      padding: 20px 24px;
      background: var(--navy-card, #001A3A);
      border: 1px solid var(--b-default, rgba(255,255,255,0.10));
      border-radius: 8px;
      transition: all .2s ease;
  }
  .doc-card:hover {
      background: var(--navy-hover, #002451);
      border-color: var(--b-btn, rgba(255,255,255,0.30));
      box-shadow: var(--sh-sm, 0 4px 12px rgba(0,0,0,0.25));
  }
  .doc-main {
      display: flex;
      align-items: flex-start;
      gap: 18px;
      flex: 1;
      min-width: 0;
  }
  .doc-badge-box {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      width: 56px;
      height: 56px;
      flex-shrink: 0;
      border-radius: 6px;
      background: rgba(255,255,255,0.06);
      border: 1px solid var(--b-default, rgba(255,255,255,0.10));
      color: var(--white, #fff);
      text-align: center;
  }
  .doc-badge-box .b-type {
      font-size: 9.5px;
      font-weight: 800;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: var(--t-sub, rgba(255,255,255,0.75));
  }
  .doc-badge-box .b-no {
      font-family: 'Wix Madefor Display', sans-serif;
      font-size: 19px;
      font-weight: 800;
      line-height: 1;
  }

  .doc-info {
      flex: 1;
      min-width: 0;
  }
  .doc-reg-row {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 4px;
      flex-wrap: wrap;
  }
  .doc-reg-no {
      font-size: 12px;
      font-weight: 700;
      color: var(--white, #fff);
      letter-spacing: .3px;
  }
  .amend-pill {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 2px 8px;
      border-radius: 100px;
      background: rgba(245, 158, 11, 0.12);
      border: 1px solid rgba(245, 158, 11, 0.35);
      color: #fbbf24;
      font-size: 10.5px;
      font-weight: 600;
  }
  .amend-pill svg {
      width: 11px;
      height: 11px;
      stroke: currentColor;
      fill: none;
      stroke-width: 2;
  }

  .doc-title {
      font-size: 15px;
      font-weight: 700;
      line-height: 1.45;
      color: var(--white, #fff);
      margin-bottom: 6px;
  }
  .doc-desc {
      font-size: 13px;
      color: var(--t-sub, rgba(255,255,255,0.75));
      line-height: 1.6;
      margin-bottom: 8px;
  }
  .doc-meta {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 11.5px;
      color: var(--t-cap, rgba(255,255,255,0.62));
      flex-wrap: wrap;
  }
  .doc-meta span + span::before {
      content: '·';
      margin-right: 8px;
      opacity: .5;
  }

  .doc-actions {
      display: flex;
      align-items: center;
      gap: 8px;
      flex-shrink: 0;
      align-self: center;
  }
  .btn-copy {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      height: 38px;
      padding: 0 13px;
      border-radius: 6px;
      background: transparent;
      border: 1px solid var(--b-default, rgba(255,255,255,0.10));
      color: var(--t-sub, rgba(255,255,255,0.75));
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      transition: all .2s;
  }
  .btn-copy:hover {
      color: var(--white, #fff);
      border-color: var(--b-btn, rgba(255,255,255,0.30));
      background: var(--bg-hover, rgba(255,255,255,0.06));
  }
  .btn-copy svg {
      width: 13px;
      height: 13px;
      stroke: currentColor;
      fill: none;
      stroke-width: 2;
  }

  .btn-download {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      height: 38px;
      padding: 0 18px;
      border-radius: 6px;
      background: transparent;
      border: 1px solid var(--b-btn, rgba(255,255,255,0.30));
      color: var(--white, #fff);
      font-size: 12.5px;
      font-weight: 700;
      text-decoration: none;
      transition: all .2s;
  }
  .btn-download:hover {
      border-color: var(--b-btn-hover, rgba(255,255,255,0.55));
      background: var(--bg-hover, rgba(255,255,255,0.06));
  }
  .btn-download svg {
      width: 13px;
      height: 13px;
      stroke: currentColor;
      fill: none;
      stroke-width: 2;
  }
  .btn-disabled {
      display: inline-flex;
      align-items: center;
      height: 38px;
      padding: 0 14px;
      border-radius: 6px;
      border: 1px dashed var(--b-default, rgba(255,255,255,0.10));
      color: var(--t-cap, rgba(255,255,255,0.62));
      font-size: 11.5px;
  }

  .empty-state {
      text-align: center;
      padding: 56px 24px;
      border: 1px dashed var(--b-btn, rgba(255,255,255,0.30));
      border-radius: 8px;
      color: var(--t-cap, rgba(255,255,255,0.62));
      font-size: 14px;
  }
  .empty-state strong {
      display: block;
      font-family: 'Wix Madefor Display', sans-serif;
      font-size: 16px;
      color: var(--white, #fff);
      margin-bottom: 6px;
  }

  /* Responsive */
  @media (max-width: 980px) {
      .law-hero-inner { grid-template-columns: 1fr; gap: 32px; }
      .singles-grid { grid-template-columns: 1fr; }
      .doc-card { flex-direction: column; align-items: stretch; }
      .doc-actions { justify-content: flex-end; padding-top: 14px; border-top: 1px solid var(--b-default, rgba(255,255,255,0.10)); }
  }
  @media (max-width: 640px) {
      .law-hero { padding: 38px 0 34px; }
      .law-toolbar-row { flex-direction: column; align-items: stretch; }
      .law-search { max-width: none; }
      .doc-main { flex-direction: column; }
      .doc-badge-box { width: 100%; height: 38px; flex-direction: row; gap: 8px; }
  }
  @endif
</style>
@endpush

@section('content')
@if ($currentType)
  {{-- ============ TYPE PAGE (PKM, GBHKM, PDKM, PDPM) ============ --}}
  @php
    $typeMeta = $types[$currentType] ?? null;
    $abbr = $typeMeta['label'] ?? Str::upper($currentType);
    $name = $typeMeta['name'] ?? Str::upper($currentType);
    $desc = $typeMeta['description'] ?? '';
    
    $typeProducts = $products->where('type', $currentType)->sortByDesc(fn($p) => [$p->year ?? 0, $p->number ?? 0])->values();
    $totalCount = $typeProducts->count();
    
    $yearsWithData = $typeProducts->whereNotNull('year')->pluck('year')->unique()->sort()->values();
    $yearRange = $yearsWithData->isNotEmpty() ? "{$yearsWithData->first()}–{$yearsWithData->last()}" : '-';
    
    $latest = $typeProducts->first();
    $latestLabel = $latest ? "No. {$latest->number}/{$latest->year}" : '-';
    
    $groupedByYear = [];
    foreach ($typeProducts as $product) {
        $year = $product->year ?? 'Tanpa tahun';
        if (!isset($groupedByYear[$year])) {
            $groupedByYear[$year] = [];
        }
        $groupedByYear[$year][] = [
            'id' => $product->id,
            'year' => $product->year,
            'number' => $product->number,
            'title' => $product->title,
            'regulation_number' => $product->regulation_number,
            'description' => $product->description,
            'extension' => $product->extension,
            'size' => $product->size,
            'human_size' => $product->human_size,
            'downloads' => $product->downloads,
            'download_url' => $product->download_url,
            'has_file' => $product->hasFile(),
            'amends' => $product->amends ? [
                'regulation_number' => $product->amends->regulation_number,
                'heading' => $product->amends->heading,
            ] : null,
            'amend' => (bool)$product->amends,
        ];
    }
    
    $availableYears = array_keys($groupedByYear);
    sort($availableYears, SORT_NUMERIC);
    $availableYears = array_reverse($availableYears);
  @endphp

  <!-- ================= HEAD ================= -->
  <section class="pg-head">
    <div class="container pg-head-inner">
      <div>
        <nav class="crumb" aria-label="Breadcrumb">
          <a href="{{ route('home') }}">Beranda</a><span aria-hidden="true">/</span>
          <a href="{{ route('legal-products.index') }}">Produk Hukum</a><span aria-hidden="true">/</span>
          <span aria-current="page">{{ $name }} ({{ $abbr }})</span>
        </nav>
        <span class="eyebrow">Produk Hukum</span>
        <h1>{{ $abbr }}</h1>
        <p class="pg-sub">{{ $name }}</p>
        <p class="pg-desc">{{ $desc }}</p>
      </div>
      <div class="pg-stats" aria-label="Ringkasan arsip">
        <div class="pg-stat"><span>Peraturan</span><strong id="stTotal">{{ $totalCount }}</strong></div>
        <div class="pg-stat"><span>Rentang</span><strong id="stRange">{{ $yearRange }}</strong></div>
        <div class="pg-stat"><span>Terbaru</span><strong id="stLatest">{{ $latestLabel }}</strong></div>
      </div>
    </div>
  </section>

  <!-- ================= TOOLBAR ================= -->
  <div class="pkm-bar" id="bar">
    <div class="container pkm-bar-inner">
      <div class="bar-row">
        <div class="tb-field" id="qWrap">
          <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
          <input class="tb-input" id="q" type="search" placeholder="Cari judul atau nomor peraturan" aria-label="Cari peraturan" autocomplete="off">
          <button class="tb-clear" id="qClear" type="button" aria-label="Hapus pencarian"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg></button>
        </div>
        <select class="tb-select" id="sortSel" aria-label="Urutkan">
          <option value="desc">Terbaru lebih dulu</option>
          <option value="asc">Terlama lebih dulu</option>
        </select>
        <div class="tb-count" id="count" aria-live="polite"></div>
      </div>
      <div class="years" id="years" role="group" aria-label="Filter tahun"></div>
    </div>
  </div>

  <!-- ================= LIST ================= -->
  <section class="list-wrap">
    <div class="container">
      <div id="list"></div>

      <div class="note">
        <div>
          <h2>Tidak menemukan peraturan yang dicari?</h2>
          <p>Hubungi Badan Legislasi atau Sekretariat DPM UII untuk bantuan pencarian dokumen peraturan.</p>
        </div>
        <a class="btn" href="https://wa.me/6281511092004" target="_blank" rel="noopener">Hubungi via WhatsApp</a>
      </div>
    </div>
  </section>

  <!-- ================= PRATINJAU ================= -->
  <dialog class="pdlg" id="pdlg" aria-labelledby="pdTitle">
    <div class="pdlg-head">
      <div class="t"><small id="pdLabel"></small><strong id="pdTitle"></strong></div>
      <a class="btn sm" id="pdOpen" href="#" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h5"/></svg><span>Buka di Tab Baru</span></a>
      <a class="btn sm" id="pdDl" href="#" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v11M7 11l5 5 5-5M5 20h14"/></svg><span>Unduh</span></a>
      <button class="pdlg-x" id="pdClose" type="button" aria-label="Tutup pratinjau"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg></button>
    </div>
    <div class="pdlg-body"><div class="pdlg-load">Memuat dokumen...</div><iframe id="pdFrame" title="Pratinjau dokumen" loading="lazy"></iframe></div>
  </dialog>

  <button class="totop" id="totop" type="button" aria-label="Kembali ke atas"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 19V5M5 12l7-7 7 7"/></svg></button>

@else
  {{-- ============ MAIN INDEX PAGE ============ --}}
  <div class="law-page">
      <!-- ============ HERO ============ -->
      <section class="law-hero">
          <div class="law-wrap law-hero-inner">
              <div>
                  <nav class="crumb" aria-label="Breadcrumb">
                      <a href="{{ route('home') }}">Beranda</a>
                      <span aria-hidden="true">/</span>
                      <a href="{{ route('legal-products.index') }}">Produk Hukum</a>
                      @if ($currentType)
                          <span aria-hidden="true">/</span>
                          <span aria-current="page">{{ $types[$currentType]['label'] ?? Str::upper($currentType) }}</span>
                      @endif
                  </nav>

                  <div class="law-badge">
                      <svg viewBox="0 0 24 24"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                      JDIH KM UII &middot; Produk Hukum
                  </div>

                  <h1>{{ $pageTitle }}</h1>
                  <p class="law-hero-desc">{{ $pageDesc }}</p>
              </div>

              <aside class="law-stats" aria-label="Statistik regulasi">
                  <div class="law-stat">
                      <span>Total Regulasi</span>
                      <strong>{{ $total }}</strong>
                  </div>
                  <div class="law-stat">
                      <span>Tahun Terarsip</span>
                      <strong>{{ $years->count() }}</strong>
                  </div>
                  <div class="law-stat">
                      <span>Status Regulasi</span>
                      <strong style="color: #4ade80; font-size: 15px;">Semua Berlaku</strong>
                  </div>
              </aside>
          </div>
      </section>

      <!-- ============ CATEGORY NAVIGATION TABS ============ -->
      <nav class="law-nav-bar" aria-label="Kategori Produk Hukum">
          <div class="law-wrap">
              <div class="law-tabs">
                  <a href="{{ route('legal-products.index') }}"
                     class="law-tab {{ empty($currentType) ? 'active' : '' }}">
                      <span>Semua Regulasi</span>
                      <span class="law-tab-badge">{{ $total }}</span>
                  </a>
                  @foreach ($types as $key => $meta)
                      @php $count = $typeCounts[$key] ?? 0; @endphp
                      <a href="{{ route('legal-products.type', $key) }}"
                         class="law-tab {{ ($currentType === $key) ? 'active' : '' }}">
                          <span>{{ $meta['label'] }}</span>
                          <span class="law-tab-badge">{{ $count }}</span>
                      </a>
                  @endforeach
              </div>
          </div>
      </nav>

      <!-- ============ MAIN CONTENT ============ -->
      <main class="law-wrap law-section">
          {{-- BAGIAN 1: KONSTITUSI MAHASISWA (Dokumen Tunggal: PDKM & GBHKM) --}}
          @if (empty($currentType) || in_array($currentType, ['pdkm', 'gbhkm']))
              @php
                  $showTypes = $currentType ? [$currentType] : ['pdkm', 'gbhkm'];
              @endphp
              <section class="singles-section reveal" aria-labelledby="konstitusi-heading">
                  @if (empty($currentType))
                      <div class="sec-title-wrap">
                          <div>
                              <h2 id="konstitusi-heading">Konstitusi Pokok Mahasiswa</h2>
                              <p>Peraturan dasar dan garis-garis besar haluan yang menjadi landasan tata kelola KM UII.</p>
                          </div>
                      </div>
                  @endif

                  <div class="singles-grid {{ count($showTypes) === 1 ? 'single-col' : '' }}">
                      @foreach ($showTypes as $type)
                          @php
                              $meta = $types[$type] ?? null;
                              $product = $singles[$type] ?? null;
                          @endphp
                          @if ($meta)
                              <article class="single-card" id="{{ $type }}">
                                  <div class="single-card-head">
                                      <span class="tag-type">{{ $meta['label'] }}</span>
                                      <span class="status-pill">
                                          <svg viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                                          Berlaku
                                      </span>
                                  </div>

                                  <h3>{{ $meta['name'] }}</h3>
                                  <p>{{ $product?->description ?: $meta['description'] }}</p>

                                  <div class="single-card-foot">
                                      <span class="single-card-meta">
                                          @if ($product && $product->size > 0)
                                              {{ $product->extension }} &middot; {{ $product->human_size }}
                                          @else
                                              Dokumen Konstitusi Resmi KM UII
                                          @endif
                                      </span>

                                      @if ($product && $product->hasFile())
                                          <a href="{{ route('legal-products.download', $product) }}"
                                             class="btn-download"
                                             title="Unduh dokumen {{ $meta['label'] }}">
                                              <svg viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                              <span>Unduh Dokumen</span>
                                          </a>
                                      @else
                                          <span class="btn-disabled">Arsip sedang dimutakhirkan</span>
                                      @endif
                                  </div>
                              </article>
                          @endif
                      @endforeach
                  </div>
              </section>
          @endif

          {{-- BAGIAN 2: PERATURAN BERNOMOR (PKM & PDPM) --}}
          @if (empty($currentType) || in_array($currentType, ['pkm', 'pdpm']))
              <section class="numbered-section reveal" aria-labelledby="numbered-heading">
                  @if (empty($currentType))
                      <div class="sec-title-wrap">
                          <div>
                              <h2 id="numbered-heading">Arsip Peraturan Bernomor</h2>
                              <p>Peraturan teknis tahunan Keluarga Mahasiswa (PKM) dan Peraturan Dewan (PDPM).</p>
                          </div>
                      </div>
                  @endif

                  <!-- TOOLBAR (FILTER TAHUN & LIVE SEARCH) -->
                  <div class="law-toolbar">
                      <div class="law-toolbar-row">
                          <!-- YEAR PILLS -->
                          <div class="year-pills" role="tablist" aria-label="Filter tahun regulasi">
                              <button type="button"
                                      onclick="setYearFilter('all')"
                                      id="pill-year-all"
                                      data-year="all"
                                      class="year-pill {{ empty($selectedYear) ? 'active' : '' }}">
                                  <span>Semua Tahun</span>
                              </button>
                              @foreach ($years as $year)
                                  @php $yCount = $yearCounts[$year] ?? 0; @endphp
                                  <button type="button"
                                          onclick="setYearFilter('{{ $year }}')"
                                          id="pill-year-{{ $year }}"
                                          data-year="{{ $year }}"
                                          class="year-pill {{ ($selectedYear == $year) ? 'active' : '' }}">
                                      <span>{{ $year }}</span>
                                      <span class="year-pill-count">{{ $yCount }}</span>
                                  </button>
                              @endforeach
                          </div>

                          <!-- LIVE SEARCH INPUT -->
                          <div class="law-search">
                              <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                              <input type="search"
                                     id="lawSearchInput"
                                     placeholder="Cari nomor, judul, kata kunci..."
                                     aria-label="Cari regulasi">
                          </div>
                      </div>

                      <!-- STATUS & RESET -->
                      <div class="law-status-bar">
                          <span id="resultCountLabel">Menampilkan seluruh peraturan ({{ $numberedProducts->count() }} dokumen)</span>
                          <button type="button" onclick="resetFilters()" id="resetBtn" class="reset-btn" style="display:none;">
                              Reset Filter
                          </button>
                      </div>
                  </div>

                  <!-- DOCUMENTS CONTAINER -->
                  <div id="documentsContainer">
                      @if ($groupedByYear->isEmpty())
                          <div class="empty-state">
                              <strong>Belum ada peraturan bernomor</strong>
                              Dokumen PKM dan PDPM sedang dalam proses pengarsipan digital.
                          </div>
                      @else
                          @foreach ($groupedByYear as $year => $items)
                              <div class="year-group" data-year="{{ $year }}" id="group-year-{{ $year }}">
                                  <div class="year-group-title">
                                      <span>Tahun {{ $year }}</span>
                                      <span class="count-badge">{{ $items->count() }} dokumen</span>
                                  </div>

                                  <div class="doc-list">
                                      @foreach ($items as $item)
                                          @php $parent = $item->amends; @endphp
                                          <article class="doc-card"
                                                   data-year="{{ $year }}"
                                                   data-type="{{ $item->type }}"
                                                   data-title="{{ strtolower($item->title) }} {{ strtolower($item->regulation_number) }}">
                                              <div class="doc-main">
                                                  <div class="doc-badge-box">
                                                      <span class="b-type">{{ strtoupper($item->type) }}</span>
                                                      <span class="b-no">{{ $item->number ?: '—' }}</span>
                                                  </div>

                                                  <div class="doc-info">
                                                      <div class="doc-reg-row">
                                                          <span class="doc-reg-no">{{ $item->regulation_number ?: $item->heading }}</span>
                                                          @if ($parent)
                                                              <span class="amend-pill">
                                                                  <svg viewBox="0 0 24 24"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                                                  Perubahan atas {{ $parent->regulation_number ?? $parent->heading }}
                                                              </span>
                                                          @else
                                                              <span class="status-pill">
                                                                  <svg viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                                                                  Berlaku
                                                              </span>
                                                          @endif
                                                      </div>

                                                      <h3 class="doc-title">{{ $item->title }}</h3>

                                                      @if ($item->description)
                                                          <p class="doc-desc">{{ $item->description }}</p>
                                                      @endif

                                                      <div class="doc-meta">
                                                          <span>{{ $item->extension }} Dokumen Resmi</span>
                                                          @if ($item->size > 0)
                                                              <span>{{ $item->human_size }}</span>
                                                          @endif
                                                          <span>{{ $item->downloads }} kali diunduh</span>
                                                      </div>
                                                  </div>
                                              </div>

                                              <div class="doc-actions">
                                                  @if ($item->download_url)
                                                      <button type="button"
                                                              onclick="copyDocLink('{{ $item->download_url }}', this)"
                                                              class="btn-copy"
                                                              title="Salin tautan dokumen">
                                                          <svg viewBox="0 0 24 24"><path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                                          <span>Salin</span>
                                                      </button>
                                                  @endif

                                                  @if ($item->hasFile())
                                                      <a href="{{ route('legal-products.download', $item) }}"
                                                         class="btn-download"
                                                         title="Unduh berkas {{ $item->regulation_number }}">
                                                          <svg viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                                          <span>Unduh</span>
                                                      </a>
                                                  @else
                                                      <span class="btn-disabled">Belum ada berkas</span>
                                                  @endif
                                              </div>
                                          </article>
                                      @endforeach
                                  </div>
                              </div>
                          @endforeach
                      @endif

                      <div id="noResultsMsg" class="empty-state" style="display:none;">
                          <strong>Tidak ada peraturan yang sesuai</strong>
                          Coba gunakan kata kunci pencarian lain atau pilih tahun berbeda.
                      </div>
                  </div>
              </section>
          @endif
      </main>
  </div>
@endif
@endsection

@push('scripts')
@if ($currentType)
<script>
  // Data dari server
  const DOCS_BY_YEAR = @json($groupedByYear);
  const YEARS = @json($availableYears);
  const TYPE_LABEL = @json($abbr);
  const TYPE_NAME = @json($name);

  const $ = id => document.getElementById(id);
  const esc = s => { const d = document.createElement('div'); d.textContent = s == null ? '' : s; return d.innerHTML; };
  const dec = s => s.replace(/&/g, '&');

  // Pakai download_url dari database (file lokal di uploads/), BUKAN Google Drive
  const dlUrl = d => d.download_url;
  const viewUrl = d => d.download_url; // PDF bisa dibuka langsung di browser via iframe

  const state = { year: 'all', q: '', sort: 'desc' };
  let shownDocs = [];

  // ringkasan
  (function () {
    const withDocs = [...new Set(Object.values(DOCS_BY_YEAR).flat().map(d => d.year))].filter(Boolean).sort((a, b) => a - b);
    const latest = Object.values(DOCS_BY_YEAR).flat().sort((a, b) => (b.year || 0) - (a.year || 0) || (b.number || 0) - (a.number || 0))[0];
    $('stTotal').textContent = Object.values(DOCS_BY_YEAR).flat().length;
    $('stRange').textContent = withDocs.length ? withDocs[0] + '–' + withDocs[withDocs.length - 1] : '-';
    $('stLatest').textContent = latest ? 'No. ' + latest.number + '/' + latest.year : '-';
  })();

  const hl = s => {
    const q = state.q.trim().toLowerCase();
    if (!q) return esc(s);
    const i = s.toLowerCase().indexOf(q);
    if (i < 0) return esc(s);
    return esc(s.slice(0, i)) + '<mark>' + esc(s.slice(i, i + q.length)) + '</mark>' + esc(s.slice(i + q.length));
  };

  function matches(d) {
    const q = state.q.trim().toLowerCase();
    return !q || (d.title + ' ' + d.regulation_number).toLowerCase().includes(q);
  }

  function renderYears() {
    const ys = YEARS.slice().sort((a, b) => state.sort === 'desc' ? b - a : a - b);
    const total = Object.values(DOCS_BY_YEAR).flat().filter(matches).length;
    $('years').innerHTML =
      '<button class="ypill" type="button" data-y="all" aria-pressed="' + (state.year === 'all') + '">Semua<small>' + total + '</small></button>' +
      ys.map(y => {
        const n = (DOCS_BY_YEAR[y] || []).filter(matches).length;
        return '<button class="ypill" type="button" data-y="' + y + '" aria-pressed="' + (state.year == y) + '">' + y + '<small>' + n + '</small></button>';
      }).join('');
  }

  function render() {
    renderYears();
    const ys = YEARS.slice().sort((a, b) => state.sort === 'desc' ? b - a : a - b);
    shownDocs = [];
    let html = '';
    ys.forEach(y => {
      if (state.year !== 'all' && state.year != y) return;
      const docs = (DOCS_BY_YEAR[y] || []).filter(matches).sort((a, b) => state.sort === 'desc' ? (b.number || 0) - (a.number || 0) : (a.number || 0) - (b.number || 0));
      if (!docs.length) return;
      html += '<h2 class="yr">' + y + '<span>' + docs.length + ' dokumen</span></h2><div class="docs">';
      docs.forEach(d => {
        const k = shownDocs.push(d) - 1;
        html += '<article class="doc">' +
          '<div class="doc-no" aria-hidden="true"><small>No.</small><b>' + (d.number || '—') + '</b></div>' +
          '<div class="doc-main"><div class="doc-label"><span>' + hl(d.regulation_number || d.title) + '</span>' + (d.amend ? '<span class="badge">Perubahan</span>' : '') + '</div>' +
          '<h3>' + hl(d.title) + '</h3></div>' +
          '<div class="doc-actions">' +
            '<button class="btn sm" type="button" data-k="' + k + '" aria-label="Pratinjau ' + esc(d.regulation_number || d.title) + '"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>Pratinjau</button>' +
            (d.has_file
              ? '<a class="btn sm" href="' + dlUrl(d) + '" rel="noopener" aria-label="Unduh ' + esc(d.regulation_number || d.title) + '"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v11M7 11l5 5 5-5M5 20h14"/></svg>Unduh</a>'
              : '<span class="btn sm" style="border-style:dashed;border-color:var(--b-default);color:var(--t-cap);">Belum ada berkas</span>') +
          '</div></article>';
      });
      html += '</div>';
    });

    if (!shownDocs.length) {
      const q = state.q.trim();
      html = q
        ? '<div class="empty"><strong>Tidak ada hasil</strong>Tidak ada peraturan yang cocok dengan “' + esc(q) + '”.<br><button class="btn" type="button" id="resetBtn">Hapus pencarian</button></div>'
        : (state.year !== 'all'
            ? '<div class="empty"><strong>Belum ada dokumen</strong>Dokumen untuk tahun ' + esc(String(state.year)) + ' belum tersedia.</div>'
            : '<div class="empty"><strong>Belum ada peraturan</strong>Arsip ' + TYPE_NAME + ' sedang dalam proses pengarsipan digital.</div>');
    }
    $('list').innerHTML = html;
    $('count').innerHTML = 'Menampilkan <b>' + shownDocs.length + '</b> dari ' + Object.values(DOCS_BY_YEAR).flat().length + ' peraturan';
    $('qWrap').classList.toggle('has', !!state.q);
  }

  // interaksi
  $('q').addEventListener('input', e => { state.q = e.target.value; render(); });
  $('qClear').addEventListener('click', () => { state.q = ''; $('q').value = ''; $('q').focus(); render(); });
  $('sortSel').addEventListener('change', e => { state.sort = e.target.value; render(); });
  $('years').addEventListener('click', e => {
    const b = e.target.closest('.ypill');
    if (!b) return;
    state.year = b.dataset.y === 'all' ? 'all' : +b.dataset.y;
    try { history.replaceState(null, '', state.year === 'all' ? location.pathname + location.search : '#' + state.year); } catch (err) {}
    render();
  });
  $('list').addEventListener('click', e => {
    if (e.target.closest('#resetBtn')) { state.q = ''; $('q').value = ''; render(); return; }
    const b = e.target.closest('button[data-k]');
    if (b) openPreview(shownDocs[+b.dataset.k]);
  });
  { const y = +location.hash.slice(1); if (YEARS.map(Number).includes(y)) state.year = y; }

  // pratinjau
  const dlg = $('pdlg');
  function openPreview(d) {
    $('pdLabel').textContent = d.regulation_number || TYPE_LABEL;
    $('pdTitle').textContent = d.title;
    // Pakai download_url dari database (file lokal), bukan Google Drive
    $('pdOpen').href = viewUrl(d);
    $('pdDl').href = dlUrl(d);
    $('pdFrame').src = d.download_url; // Preview PDF langsung via file lokal
    dlg.showModal();
  }
  function closePreview() { dlg.close(); }
  dlg.addEventListener('close', () => { $('pdFrame').src = 'about:blank'; });
  $('pdClose').addEventListener('click', closePreview);
  dlg.addEventListener('click', e => { if (e.target === dlg) closePreview(); });

  // kembali ke atas
  const totop = $('totop');
  window.addEventListener('scroll', () => totop.classList.toggle('show', window.scrollY > 700), { passive: true });
  totop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

  render();
</script>
@else
<script>
    let currentYear = '{{ $selectedYear ?: "all" }}';
    let searchQuery = '';

    function setYearFilter(year) {
        currentYear = year;
        updatePillsUI();
        filterDocuments();

        if (history.pushState) {
            const url = new URL(window.location);
            if (year === 'all') {
                url.searchParams.delete('tahun');
            } else {
                url.searchParams.set('tahun', year);
            }
            window.history.pushState({}, '', url);
        }
    }

    function updatePillsUI() {
        document.querySelectorAll('.year-pill').forEach(pill => {
            pill.classList.toggle('active', pill.dataset.year === currentYear);
        });
    }

    function filterDocuments() {
        let visibleCount = 0;
        const yearGroups = document.querySelectorAll('.year-group');
        const noResults = document.getElementById('noResultsMsg');
        const resetBtn = document.getElementById('resetBtn');
        const countLabel = document.getElementById('resultCountLabel');

        yearGroups.forEach(group => {
            const groupYear = group.dataset.year;
            const yearMatch = (currentYear === 'all' || groupYear === currentYear);
            let visibleInGroup = 0;

            const cards = group.querySelectorAll('.doc-card');
            cards.forEach(card => {
                const cardTitle = card.dataset.title || '';
                const searchMatch = !searchQuery || cardTitle.includes(searchQuery);

                if (yearMatch && searchMatch) {
                    card.style.display = 'flex';
                    visibleInGroup++;
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            group.style.display = visibleInGroup > 0 ? '' : 'none';
        });

        if (noResults) {
            noResults.style.display = (visibleCount === 0 && yearGroups.length > 0) ? 'block' : 'none';
        }

        const isFiltered = currentYear !== 'all' || searchQuery !== '';
        if (resetBtn) resetBtn.style.display = isFiltered ? 'inline-block' : 'none';

        if (countLabel) {
            if (isFiltered) {
                let text = `Menampilkan ${visibleCount} peraturan`;
                if (currentYear !== 'all') text += ` (Tahun ${currentYear})`;
                if (searchQuery) text += ` dengan kata kunci "${searchQuery}"`;
                countLabel.textContent = text;
            } else {
                countLabel.textContent = `Menampilkan seluruh peraturan (${visibleCount} dokumen)`;
            }
        }
    }

    function resetFilters() {
        currentYear = 'all';
        searchQuery = '';
        const input = document.getElementById('lawSearchInput');
        if (input) input.value = '';
        updatePillsUI();
        filterDocuments();
    }

    function copyDocLink(url, btn) {
        if (!url) return;
        navigator.clipboard.writeText(url).then(() => {
            const label = btn.querySelector('span');
            const orig = label.textContent;
            label.textContent = 'Tersalin!';
            btn.style.borderColor = '#4ade80';
            btn.style.color = '#4ade80';
            setTimeout(() => {
                label.textContent = orig;
                btn.style.borderColor = '';
                btn.style.color = '';
            }, 2000);
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('lawSearchInput');
        if (input) {
            input.addEventListener('input', (e) => {
                searchQuery = e.target.value.trim().toLowerCase();
                filterDocuments();
            });
        }

        const urlParams = new URLSearchParams(window.location.search);
        const urlYear = urlParams.get('tahun');
        if (urlYear) {
            setYearFilter(urlYear);
        } else {
            filterDocuments();
        }
    });
</script>
@endif
@endpush