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

@section('content')
<style>
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
</style>

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

@push('scripts')
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
@endpush
@endsection
