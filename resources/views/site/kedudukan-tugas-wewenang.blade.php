@extends('layouts.site')

@section('title', 'Kedudukan, Tugas dan Wewenang — '.($siteSettings['site_name'] ?? 'DPM UII'))
@section('meta_description', 'Kedudukan, fungsi, tugas, dan wewenang Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia berdasarkan Peraturan Dasar Keluarga Mahasiswa UII.')

@section('content')
<style>
    .ktw-page { color: rgba(255,255,255,.85); }

    /* --- Page Header --- */
    .ktw-head {
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid var(--b-default);
        padding: 56px 0 64px;
        background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%);
    }
    .ktw-head::before {
        content: '';
        position: absolute; inset: 0;
        background: repeating-linear-gradient(135deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 28px);
    }
    .ktw-hero-grid {
        position: relative;
        display: grid;
        grid-template-columns: 1.2fr .8fr;
        gap: 40px;
        align-items: center;
    }
    .crumb {
        display: flex; flex-wrap: wrap; gap: 10px;
        margin-bottom: 28px;
        font-size: 12.5px; color: var(--t-cap);
    }
    .crumb a { transition: color .2s; }
    .crumb a:hover { color: var(--white); }
    .crumb span[aria-hidden] { opacity: .5; }
    .crumb span[aria-current] { color: var(--white); font-weight: 600; }
    .ktw-head h1 {
        font-size: clamp(34px, 5.6vw, 62px);
        letter-spacing: -1.6px;
        line-height: 1.06;
        margin-bottom: 18px;
    }
    .pg-desc {
        max-width: 580px;
        margin-bottom: 28px;
        font-size: 16px;
        color: var(--t-sub);
    }
    .meta {
        display: flex; flex-wrap: wrap; gap: 10px;
    }
    .meta span {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 8px 16px;
        border: 1px solid var(--b-btn);
        border-radius: 100px;
        font-size: 12.5px; font-weight: 600; color: var(--white);
        background: rgba(0,22,51,.5);
    }
    .meta span small {
        font-size: 11px; font-weight: 500;
        letter-spacing: .8px; text-transform: uppercase; color: var(--t-cap);
    }
    .hero-art { display: flex; justify-content: flex-end; }
    .hero-art svg { width: min(100%, 460px); height: auto; }

    /* --- Statement / Quote --- */
    .statement {
        position: relative;
        padding: 64px 0;
        text-align: center;
        border-bottom: 1px solid var(--b-default);
        background: var(--navy-card);
        overflow: hidden;
    }
    .statement::before {
        content: '“';
        position: absolute; left: 50%; top: -30px;
        transform: translateX(-50%);
        font-family: 'Wix Madefor Display', serif;
        font-size: 260px; line-height: 1;
        color: rgba(255,255,255,.05);
        pointer-events: none;
    }
    .statement .eyebrow {
        position: relative; display: block;
        margin-bottom: 18px;
        font-size: 11.5px; font-weight: 600;
        letter-spacing: 2px; text-transform: uppercase;
        color: var(--t-cap);
    }
    .statement blockquote {
        position: relative;
        max-width: 860px; margin: 0 auto 22px;
        font-family: 'Wix Madefor Display', sans-serif;
        font-size: clamp(24px, 3.6vw, 40px);
        font-weight: 700; line-height: 1.3;
        letter-spacing: -.8px; color: var(--white);
    }

    /* --- Subnav / TOC --- */
    .subnav {
        position: sticky; top: 73px; z-index: 50;
        background: rgba(0,22,51,.95);
        border-bottom: 1px solid var(--b-default);
        backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
    }
    .subnav::after {
        content: '';
        position: absolute; left: 0; bottom: -1px;
        height: 2px; width: calc(var(--p, 0) * 100%);
        background: var(--white);
        transition: width .1s linear;
    }
    .subnav-inner {
        display: flex; align-items: center; justify-content: space-between; gap: 20px;
    }
    .subnav ol {
        list-style: none; display: flex; gap: 4px;
        padding: 10px 0; overflow-x: auto; scrollbar-width: none;
    }
    .subnav ol::-webkit-scrollbar { display: none; }
    .subnav li a {
        display: flex; align-items: center; gap: 8px;
        padding: 8px 16px;
        border-radius: 100px;
        border: 1px solid transparent;
        white-space: nowrap;
        font-size: 13.5px; font-weight: 600;
        color: var(--t-cap);
        transition: color .2s, background .2s, border-color .2s;
    }
    .subnav li a em { font-style: normal; font-size: 11px; opacity: .6; }
    .subnav li a:hover { color: var(--white); }
    .subnav li a[aria-current="true"] {
        color: var(--white);
        background: rgba(255,255,255,.10);
        border-color: rgba(255,255,255,.35);
    }
    .subnav .btn { flex-shrink: 0; }

    /* --- Band sections --- */
    .band { padding: 96px 0; border-bottom: 1px solid var(--b-default); }
    .band.alt { background: var(--navy-footer); }
    .band-grid {
        display: grid;
        grid-template-columns: 300px minmax(0, 1fr);
        gap: 72px; align-items: start;
    }
    .band-head { position: sticky; top: 150px; }
    .big-no {
        display: block; margin-bottom: 8px;
        font-family: 'Wix Madefor Display', sans-serif;
        font-size: 88px; font-weight: 800; line-height: 1;
        letter-spacing: -4px;
        color: transparent;
        -webkit-text-stroke: 1px rgba(255,255,255,.28);
    }
    .band-head h2 { margin-bottom: 14px; font-size: clamp(28px, 3.2vw, 38px); letter-spacing: -.9px; line-height: 1.15; }
    .band-head p { font-size: 14.5px; color: var(--t-cap); line-height: 1.75; }

    .pasals { display: flex; flex-wrap: wrap; gap: 6px; }
    .pasal {
        display: inline-block;
        padding: 2px 10px;
        border: 1px solid var(--b-btn);
        border-radius: 100px;
        font-size: 11.5px; font-weight: 600; letter-spacing: .3px;
        color: var(--white); white-space: nowrap; vertical-align: middle;
    }
    .ic {
        width: 44px; height: 44px;
        display: grid; place-items: center;
        border: 1px solid var(--b-btn); border-radius: 8px; color: var(--white);
    }
    .ic svg { width: 20px; height: 20px; stroke: currentColor; fill: none; stroke-width: 1.7; stroke-linecap: round; stroke-linejoin: round; }

    /* --- Facts grid --- */
    .facts { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .fact {
        display: flex; flex-direction: column;
        padding: 24px;
        background: var(--navy-card);
        border: 1px solid var(--b-default); border-radius: 8px;
        transition: border-color .2s, background .2s;
    }
    .fact:hover { border-color: var(--b-btn); background: var(--navy-hover); }
    .fact .ic { margin-bottom: 18px; }
    .fact h3 { margin-bottom: 8px; font-size: 18px; letter-spacing: -.2px; }
    .fact p { flex: 1; margin-bottom: 16px; font-size: 14px; color: var(--t-sub); line-height: 1.7; }
    .fine { margin-top: 14px; font-size: 13.5px; color: var(--t-cap); }
    .fine .pasal { margin-left: 6px; }

    /* --- Horizontal flow diagram --- */
    .hflow {
        margin-top: 24px; padding: 30px 26px 26px;
        border: 1px solid var(--b-default); border-radius: 8px;
        background: var(--navy-footer);
    }
    .hflow-title { margin-bottom: 24px; font-size: 11.5px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--t-cap); }
    .hflow-row {
        display: grid;
        grid-template-columns: 1fr auto 1.15fr auto 1.3fr;
        align-items: center; gap: 0;
    }
    .nd {
        padding: 16px 16px; text-align: center;
        border: 1px solid var(--b-btn); border-radius: 8px; background: var(--navy-card);
    }
    .nd small {
        display: block; font-size: 10.5px; font-weight: 600;
        letter-spacing: 1.3px; text-transform: uppercase; color: var(--t-cap);
    }
    .nd b {
        display: block; margin: 3px 0;
        font-family: 'Wix Madefor Display', sans-serif;
        font-size: 16px; color: var(--white); line-height: 1.3;
    }
    .nd i {
        display: block; font-style: normal;
        font-size: 11.5px; color: var(--t-cap); line-height: 1.4;
    }
    .nd.main {
        border-color: var(--b-btn-hover); background: var(--navy-hover); box-shadow: var(--sh-md);
        padding: 24px 16px;
    }
    .nd.main b { font-size: 24px; }
    .nd-stack { display: grid; gap: 10px; }
    .lk {
        position: relative; width: 96px; padding: 0 8px; text-align: center;
    }
    .lk span {
        display: block; margin-bottom: 6px;
        font-size: 11px; line-height: 1.35; color: var(--t-sub);
    }
    .lk span em { display: block; font-style: normal; color: var(--t-cap); font-size: 10.5px; }
    .lk::after {
        content: ''; display: block; height: 2px; background: var(--b-btn); position: relative;
    }
    .lk::before {
        content: ''; position: absolute; right: 8px; bottom: -3px;
        width: 8px; height: 8px;
        border-top: 2px solid var(--b-btn); border-right: 2px solid var(--b-btn);
        transform: rotate(45deg);
    }

    /* --- Function cards --- */
    .fgrid { display: grid; grid-template-columns: 1fr; gap: 14px; }
    .fcard {
        display: grid; grid-template-columns: auto 1fr; column-gap: 24px;
        padding: 26px 28px;
        background: var(--navy-card);
        border: 1px solid var(--b-default); border-radius: 8px;
        transition: border-color .2s, background .2s;
    }
    .fcard:hover { border-color: var(--b-btn); background: var(--navy-hover); }
    .fc-top { grid-row: 1 / span 4; display: flex; flex-direction: column; align-items: center; gap: 12px; }
    .fc-no {
        font-family: 'Wix Madefor Display', sans-serif;
        font-size: 13px; font-weight: 800; letter-spacing: 1px; color: var(--t-cap);
    }
    .fcard h3 { margin-bottom: 8px; font-size: 22px; letter-spacing: -.4px; }
    .fcard .pasals { margin-bottom: 12px; }
    .fcard p { margin-bottom: 16px; font-size: 14.5px; color: var(--t-sub); line-height: 1.7; }
    .tags { display: flex; flex-wrap: wrap; gap: 8px; }
    .tags span {
        padding: 5px 12px;
        border: 1px solid var(--b-default); border-radius: 6px;
        background: rgba(255,255,255,.04);
        font-size: 12.5px; font-weight: 500; color: var(--t-body);
    }
    .asp {
        margin-top: 14px;
        display: grid; grid-template-columns: auto 1fr; gap: 18px;
        align-items: center;
        padding: 20px 24px;
        border: 1px dashed var(--b-btn); border-radius: 8px;
        font-size: 14px; color: var(--t-sub); line-height: 1.7;
    }
    .asp strong { color: var(--white); font-size: 15px; }

    /* --- Timeline --- */
    .tl-scroll { overflow-x: auto; border: 1px solid var(--b-default); border-radius: 8px; background: var(--navy-card); }
    .tl { min-width: 760px; padding: 8px 0; }
    .tl-head, .tl-row { display: grid; grid-template-columns: 250px repeat(12, 1fr); align-items: center; }
    .tl-head { padding: 12px 0; border-bottom: 1px solid var(--b-default); }
    .tl-head b {
        text-align: center;
        font-family: 'Wix Madefor Display', sans-serif;
        font-size: 12px; font-weight: 700; color: var(--t-cap);
    }
    .tl-row { padding: 16px 0; }
    .tl-row + .tl-row { border-top: 1px solid var(--b-default); }
    .tl-label { grid-column: 1; grid-row: 1; padding: 0 20px; }
    .tl-label strong { display: block; font-size: 14.5px; }
    .tl-label small { display: block; margin: 1px 0 6px; font-size: 12px; color: var(--t-cap); line-height: 1.4; }
    .tl-label .pasal { font-size: 10.5px; padding: 1px 8px; }
    .track { grid-column: 2 / 14; grid-row: 1; height: 1px; background: var(--b-btn); }
    .dot {
        grid-row: 1; justify-self: center;
        width: 16px; height: 16px; border-radius: 50%;
        background: var(--white);
        box-shadow: 0 0 0 4px rgba(255,255,255,.12);
    }
    .dot.ring { background: var(--navy-card); border: 2px solid var(--white); box-shadow: none; }
    .tl-note { margin-top: 14px; font-size: 12.5px; color: var(--t-cap); }
    .tl-note .dot { display: inline-block; width: 10px; height: 10px; vertical-align: middle; box-shadow: none; margin-right: 4px; }
    .tl-note .dot.ring { border-width: 2px; }
    .sub-h { margin: 36px 0 14px; font-size: 11.5px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--t-cap); font-family: 'Inter', sans-serif; }

    .rows { list-style: none; border: 1px solid var(--b-default); border-radius: 8px; background: var(--navy-card); margin: 0; padding: 0; }
    .rows li {
        display: grid; grid-template-columns: 1fr auto; gap: 20px;
        align-items: start; padding: 16px 20px;
        font-size: 14.5px; color: var(--t-body); line-height: 1.65;
    }
    .rows li + li { border-top: 1px solid var(--b-default); }

    /* --- Wewenang tabs --- */
    .wew {
        display: grid; grid-template-columns: 240px minmax(0, 1fr);
        border: 1px solid var(--b-default); border-radius: 8px;
        background: var(--navy-card); overflow: hidden;
    }
    .wtabs {
        display: flex; flex-direction: column;
        border-right: 1px solid var(--b-default);
        background: rgba(255,255,255,.02);
    }
    .wtab {
        display: flex; align-items: center; gap: 14px;
        padding: 18px 20px; text-align: left;
        background: transparent; border: 0; border-left: 2px solid transparent;
        color: var(--t-cap); cursor: pointer;
        transition: background .2s, color .2s, border-color .2s;
    }
    .wtab + .wtab { border-top: 1px solid var(--b-default); }
    .wtab:hover { background: var(--bg-hover); color: var(--white); }
    .wtab[aria-selected="true"] {
        background: var(--navy-hover); border-left-color: var(--white); color: var(--white);
    }
    .wtab i {
        width: 30px; height: 30px; flex-shrink: 0;
        display: grid; place-items: center;
        border: 1px solid var(--b-btn); border-radius: 6px;
        font-style: normal; font-family: 'Wix Madefor Display', sans-serif;
        font-size: 13px; font-weight: 800; color: var(--white);
    }
    .wtab strong { display: block; font-size: 14.5px; line-height: 1.3; }
    .wtab small { display: block; font-size: 12px; font-weight: 400; color: var(--t-cap); }
    .wpanel { padding: 28px; animation: fadeIn .3s ease; }
    .wpanel[hidden] { display: none; }
    .wpanel h3 { margin-bottom: 18px; font-size: 20px; letter-spacing: -.3px; }
    .wpanel .rows { border: 0; background: transparent; }
    .wpanel .rows li { padding-left: 0; padding-right: 0; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: none; } }

    /* --- Dasar Hukum --- */
    .law-main {
        display: grid; grid-template-columns: auto 1fr auto; gap: 22px; align-items: center;
        padding: 26px; margin-bottom: 14px;
        border: 1px solid var(--b-btn); border-radius: 8px;
        background: var(--navy-card); box-shadow: var(--sh-md);
    }
    .law-main .abbr {
        width: 72px; height: 72px; display: grid; place-items: center;
        border: 1px solid var(--b-btn); border-radius: 8px;
        font-family: 'Wix Madefor Display', sans-serif; font-size: 17px; font-weight: 800; color: var(--white);
    }
    .law-main h3 { margin-bottom: 3px; font-size: 20px; letter-spacing: -.3px; }
    .law-main p { font-size: 14px; color: var(--t-cap); line-height: 1.6; max-width: 520px; }
    .law-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .law {
        display: flex; flex-direction: column; justify-content: space-between; gap: 16px;
        padding: 18px 20px;
        border: 1px solid var(--b-default); border-radius: 8px;
        background: var(--navy-card);
        transition: border-color .2s, background .2s;
    }
    .law:hover { border-color: var(--b-btn); background: var(--navy-hover); }
    .law small { display: block; margin-bottom: 4px; font-size: 11.5px; font-weight: 600; letter-spacing: .6px; text-transform: uppercase; color: var(--t-cap); }
    .law strong { display: block; font-size: 15px; line-height: 1.45; }
    .law-actions { display: flex; gap: 8px; }
    .btn.sm { padding: 9px 16px; font-size: 13px; }
    .btn.sm svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 1.9; stroke-linecap: round; stroke-linejoin: round; }
    .btn.sm:hover svg { transform: none; }
    .disclaimer { margin-top: 24px; padding: 18px 22px; border-left: 2px solid var(--b-btn-hover); background: rgba(255,255,255,.03); font-size: 13.5px; color: var(--t-sub); line-height: 1.7; }
    .disclaimer strong { color: var(--white); }

    /* --- Reveal --- */
    .reveal { opacity: 0; transform: translateY(24px); transition: opacity .7s ease, transform .7s ease; }
    .reveal.in { opacity: 1; transform: none; }
    .d1 { transition-delay: .08s; } .d2 { transition-delay: .16s; } .d3 { transition-delay: .24s; } .d4 { transition-delay: .32s; }

    /* --- Responsive --- */
    @media (max-width: 1080px) {
        .ktw-hero-grid { grid-template-columns: 1fr; }
        .hero-art { display: none; }
        .band { padding: 72px 0; }
        .band-grid { grid-template-columns: minmax(0, 1fr); gap: 32px; }
        .band-head { position: static; }
        .big-no { font-size: 64px; }
        .subnav .btn { display: none; }
        .hflow-row { grid-template-columns: 1fr; gap: 0; }
        .lk { width: auto; padding: 14px 0; display: flex; align-items: center; justify-content: center; gap: 12px; }
        .lk span { margin: 0; text-align: left; }
        .lk::after { width: 2px; height: 28px; order: -1; }
        .lk::before { right: auto; left: calc(50% - 11px); bottom: 12px; border: 0; border-bottom: 2px solid var(--b-btn); border-right: 2px solid var(--b-btn); transform: rotate(45deg); }
        .facts { grid-template-columns: 1fr; }
        .fcard { grid-template-columns: 1fr; padding: 22px 20px; }
        .fc-top { grid-row: auto; flex-direction: row; justify-content: space-between; margin-bottom: 14px; }
        .asp { grid-template-columns: 1fr; gap: 6px; }
        .wew { grid-template-columns: 1fr; }
        .wtabs { flex-direction: row; overflow-x: auto; border-right: 0; border-bottom: 1px solid var(--b-default); }
        .wtab { flex-shrink: 0; border-left: 0; border-bottom: 2px solid transparent; padding: 14px 16px; }
        .wtab + .wtab { border-top: 0; border-left: 1px solid var(--b-default); }
        .wtab[aria-selected="true"] { border-left-color: var(--b-default); border-bottom-color: var(--white); }
        .wtab small { display: none; }
        .wpanel { padding: 22px 18px; }
        .rows li { grid-template-columns: 1fr; gap: 8px; padding: 14px 16px; }
        .law-main { grid-template-columns: 1fr; }
        .law-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 720px) {
        .ktw-head { padding: 36px 0 44px; }
        .statement { padding: 48px 0; }
        .band { padding: 56px 0; }
        .subnav { top: 88px; }
    }
    @media (prefers-reduced-motion: reduce) {
        .wpanel, .subnav::after { animation: none; transition: none; }
        .reveal { opacity: 1; transform: none; }
    }
</style>

<div class="ktw-page">
    <!-- ================= PAGE HEADER ================= -->
    <section class="ktw-head">
        <div class="container ktw-hero-grid">
            <div>
                <nav class="crumb" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}">Beranda</a><span aria-hidden="true">/</span>
                    <a href="{{ url('/#fungsi') }}">Tentang</a><span aria-hidden="true">/</span>
                    <span aria-current="page">Kedudukan, Tugas dan Wewenang</span>
                </nav>
                <span class="eyebrow">Tentang DPM UII</span>
                <h1>Kedudukan, Tugas dan Wewenang</h1>
                <p class="pg-desc">Ketentuan mengenai kedudukan, fungsi, tugas, dan wewenang Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia berdasarkan Peraturan Dasar Keluarga Mahasiswa UII.</p>
                <div class="meta">
                    <span><small>Dasar</small> PDKM</span>
                    <span><small>Fungsi</small> 3</span>
                    <span><small>Periode</small> 12 bulan</span>
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
            <span class="eyebrow">Peraturan Dasar KM UII</span>
            <blockquote>Kekuasaan tertinggi dilaksanakan oleh Dewan Permusyawaratan Mahasiswa.</blockquote>
            <span class="pasal">Pasal 9 ayat (1)</span>
        </div>
    </section>

    <!-- ================= SUBNAV ================= -->
    <div class="subnav" id="subnav">
        <div class="container subnav-inner">
            <ol id="toc">
                <li><a href="#kedudukan"><em>01</em>Kedudukan</a></li>
                <li><a href="#fungsi"><em>02</em>Fungsi</a></li>
                <li><a href="#tugas"><em>03</em>Tugas</a></li>
                <li><a href="#wewenang"><em>04</em>Wewenang</a></li>
                <li><a href="#dasar-hukum"><em>05</em>Dasar Hukum</a></li>
            </ol>
            <a class="btn sm" href="https://dpm.uii.ac.id/produk-hukum/peraturan-dasar-km-uii-ke-38-1-pdkm-single-2024/unduh" rel="noopener">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v11M7 11l5 5 5-5M5 20h14"/></svg>
                Unduh PDKM
            </a>
        </div>
    </div>

    <!-- ================= 01 KEDUDUKAN ================= -->
    <section class="band" id="kedudukan" aria-labelledby="h-ked">
        <div class="container band-grid">
            <header class="band-head">
                <span class="big-no" aria-hidden="true">01</span>
                <h2 id="h-ked">Kedudukan</h2>
                <p>Posisi DPM dalam sistem pemerintahan mahasiswa Keluarga Mahasiswa UII.</p>
            </header>
            <div>
                <div class="facts">
                    <article class="fact reveal d1">
                        <span class="ic"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 21h18M5 21V10M10 21V10M14 21V10M19 21V10M2 10 12 3l10 7z"/></svg></span>
                        <h3>Tingkat Universitas</h3>
                        <p>Lembaga permusyawaratan mahasiswa yang berkedudukan di tingkat universitas.</p>
                        <div class="pasals"><span class="pasal">Pasal 10 ayat (1)</span></div>
                    </article>
                    <article class="fact reveal d2">
                        <span class="ic"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c0-3.6 2.9-6 6.5-6s6.5 2.4 6.5 6M16 5a3.5 3.5 0 0 1 0 6.5M18 14.5c2.2.6 3.5 2.4 3.5 5.5"/></svg></span>
                        <h3>Perwakilan Seluruh Mahasiswa</h3>
                        <p>Bentuk perwakilan dari seluruh mahasiswa Universitas Islam Indonesia.</p>
                        <div class="pasals"><span class="pasal">Pasal 10 ayat (1)</span></div>
                    </article>
                    <article class="fact reveal d3">
                        <span class="ic"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="18" cy="5" r="2.5"/><circle cx="6" cy="12" r="2.5"/><circle cx="18" cy="19" r="2.5"/><path d="m8.2 10.8 7.6-4.4M8.2 13.2l7.6 4.4"/></svg></span>
                        <h3>Kekuasaan Bersama</h3>
                        <p>Kekuasaan di tingkat universitas dijalankan bersama LEM Universitas dan Lembaga Khusus Universitas.</p>
                        <div class="pasals"><span class="pasal">Pasal 9 ayat (2)</span></div>
                    </article>
                    <article class="fact reveal d4">
                        <span class="ic"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg></span>
                        <h3>Anggota dan Periode</h3>
                        <p>Anggota berasal dari legislatif mahasiswa hasil Pemilihan Wakil Mahasiswa, ditetapkan pada Sidang Umum KM UII, dengan periode 12 bulan.</p>
                        <div class="pasals"><span class="pasal">Pasal 11 ayat (1)</span><span class="pasal">Pasal 35 ayat (1)</span></div>
                    </article>
                </div>
                <p class="fine">Susunan, kedudukan, tugas, fungsi, dan keanggotaan DPM diatur lebih lanjut dalam Peraturan DPM. <span class="pasal">Pasal 11 ayat (3)</span></p>

                <div class="hflow" role="img" aria-label="Bagan: seluruh mahasiswa memilih anggota DPM UII, DPM UII mengawasi LEM Universitas dan Lembaga Khusus Universitas">
                    <div class="hflow-title">Bagan Kedudukan</div>
                    <div class="hflow-row">
                        <div class="nd"><small>Pemilih</small><b>Seluruh Mahasiswa UII</b></div>
                        <div class="lk"><span>Pemilihan Wakil Mahasiswa<em>Pasal 36</em></span></div>
                        <div class="nd main"><small>Kekuasaan tertinggi</small><b>DPM UII</b><i>Legislatif tingkat universitas</i></div>
                        <div class="lk"><span>Memantau, verifikasi, dan menerima laporan<em>Pasal 14, 24, 25, 32</em></span></div>
                        <div class="nd-stack">
                            <div class="nd"><small>Eksekutif</small><b>LEM Universitas</b><i>Ketua LEM adalah mandataris DPM</i></div>
                            <div class="nd"><small>Lembaga Khusus</small><b>Lembaga Khusus Universitas</b><i>Wajib mengikuti RDP dan menyerahkan LPJ</i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= 02 FUNGSI ================= -->
    <section class="band alt" id="fungsi" aria-labelledby="h-fg">
        <div class="container band-grid">
            <header class="band-head">
                <span class="big-no" aria-hidden="true">02</span>
                <h2 id="h-fg">Fungsi</h2>
                <p>DPM menjalankan tiga fungsi utama. <span class="pasal">Pasal 10 ayat (2)</span></p>
            </header>
            <div>
                <div class="fgrid">
                    <article class="fcard reveal d1">
                        <div class="fc-top">
                            <span class="ic"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3v18M5 21h14M5 7h14M5 7l-3 8a3.5 3.5 0 0 0 6 0zM19 7l-3 8a3.5 3.5 0 0 0 6 0z"/></svg></span>
                            <span class="fc-no">01</span>
                        </div>
                        <h3>Legislasi</h3>
                        <div class="pasals"><span class="pasal">Pasal 12 ayat (1)</span></div>
                        <p>Membahas dan menetapkan produk hukum Keluarga Mahasiswa UII.</p>
                        <div class="tags"><span>Peraturan Dasar</span><span>Garis-garis besar haluan</span><span>Peraturan KM UII</span><span>Peraturan DPM</span><span>Keputusan DPM</span></div>
                    </article>
                    <article class="fcard reveal d2">
                        <div class="fc-top">
                            <span class="ic"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v10M9.5 9.5h4a1.5 1.5 0 0 1 0 3h-3a1.5 1.5 0 0 0 0 3H15"/></svg></span>
                            <span class="fc-no">02</span>
                        </div>
                        <h3>Anggaran</h3>
                        <div class="pasals"><span class="pasal">Pasal 13</span></div>
                        <p>Membahas dan menetapkan sumber serta anggaran dana KM UII.</p>
                        <div class="tags"><span>Sumber dana</span><span>Anggaran legislatif</span><span>Anggaran eksekutif</span><span>Anggaran lembaga khusus</span></div>
                    </article>
                    <article class="fcard reveal d3">
                        <div class="fc-top">
                            <span class="ic"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg></span>
                            <span class="fc-no">03</span>
                        </div>
                        <h3>Pengawasan</h3>
                        <div class="pasals"><span class="pasal">Pasal 14 ayat (1)–(6)</span></div>
                        <p>Mengawasi lembaga eksekutif dan lembaga khusus tingkat universitas.</p>
                        <div class="tags"><span>Memantau</span><span>Verifikasi program kerja</span><span>Kontrol laporan keuangan</span><span>Terima atau tolak laporan</span></div>
                    </article>
                </div>
                <div class="asp reveal d4">
                    <strong>Penyaluran aspirasi</strong>
                    <span>Sebagai perwakilan seluruh mahasiswa UII, DPM menampung dan menyalurkan aspirasi mahasiswa. Mekanismenya diatur dalam PKM UII No. 3 Tahun 2018 tentang Pengelolaan Aspirasi UII.</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= 03 TUGAS ================= -->
    <section class="band" id="tugas" aria-labelledby="h-tg">
        <div class="container band-grid">
            <header class="band-head">
                <span class="big-no" aria-hidden="true">03</span>
                <h2 id="h-tg">Tugas</h2>
                <p>Kewajiban berkala DPM dalam satu periode kepengurusan 12 bulan, beserta tugas lainnya.</p>
            </header>
            <div>
                <div class="tl-scroll reveal d1"><div class="tl" role="img" aria-label="Ilustrasi jadwal kewajiban DPM dalam satu periode 12 bulan">
                    <div class="tl-head"><span></span><b>1</b><b>2</b><b>3</b><b>4</b><b>5</b><b>6</b><b>7</b><b>8</b><b>9</b><b>10</b><b>11</b><b>12</b></div>
                    <div class="tl-row"><div class="tl-label"><strong>Laporan kinerja</strong><small>FORASLAK, setiap 3 bulan</small><span class="pasal">Pasal 15 ayat (2)–(3)</span></div><span class="track"></span><span class="dot" style="grid-column:4" title="Bulan ke-3"></span><span class="dot" style="grid-column:7" title="Bulan ke-6"></span><span class="dot" style="grid-column:10" title="Bulan ke-9"></span><span class="dot" style="grid-column:13" title="Bulan ke-12"></span></div>
                    <div class="tl-row"><div class="tl-label"><strong>Kontrol laporan keuangan</strong><small>LEM dan Lembaga Khusus, triwulan</small><span class="pasal">Pasal 14, 25</span></div><span class="track"></span><span class="dot" style="grid-column:4" title="Bulan ke-3"></span><span class="dot" style="grid-column:7" title="Bulan ke-6"></span><span class="dot" style="grid-column:10" title="Bulan ke-9"></span><span class="dot" style="grid-column:13" title="Bulan ke-12"></span></div>
                    <div class="tl-row"><div class="tl-label"><strong>Rapat Koordinasi KM UII</strong><small>Minimal sekali per 4 bulan</small><span class="pasal">Pasal 15 ayat (1)</span></div><span class="track"></span><span class="dot ring" style="grid-column:5" title="Bulan ke-4"></span><span class="dot ring" style="grid-column:9" title="Bulan ke-8"></span><span class="dot ring" style="grid-column:13" title="Bulan ke-12"></span></div>
                    <div class="tl-row"><div class="tl-label"><strong>Sidang Umum KM UII</strong><small>Dua kali per periode; periode dihitung sejak Sidang Umum</small><span class="pasal">Pasal 11 ayat (2), 35</span></div><span class="track"></span><span class="dot" style="grid-column:2" title="Bulan ke-1"></span></div>
                </div></div>
                <p class="tl-note"><span class="dot"></span> Kewajiban pada interval tertentu &nbsp; <span class="dot ring"></span> Batas minimal &nbsp;·&nbsp; Ilustrasi berdasarkan ketentuan interval pada PDKM.</p>

                <h3 class="sub-h">Tugas lainnya</h3>
                <ul class="rows reveal d2">
                    <li><span>Memverifikasi program kerja yang diajukan LEM Universitas dan Lembaga Khusus Universitas.</span><span class="pasal">Pasal 14, 25 ayat (1)</span></li>
                    <li><span>Menerima atau menolak laporan keuangan dan laporan akhir jabatan lembaga yang diawasi.</span><span class="pasal">Pasal 14</span></li>
                    <li><span>Memfasilitasi musyawarah pembentukan KPU dan Panwas Pemilwa serta mengesahkan hasilnya.</span><span class="pasal">Pasal 38 ayat (1)–(2)</span></li>
                    <li><span>Menyelenggarakan Rapat Dengar Pendapat (RDP) bagi Lembaga Khusus dan menerima laporan pertanggungjawabannya.</span><span class="pasal">Pasal 32 ayat (3)–(4)</span></li>
                </ul>
            </div>
        </div>
    </section>

    <!-- ================= 04 WEWENANG ================= -->
    <section class="band alt" id="wewenang" aria-labelledby="h-wn">
        <div class="container band-grid">
            <header class="band-head">
                <span class="big-no" aria-hidden="true">04</span>
                <h2 id="h-wn">Wewenang</h2>
                <p>Kewenangan DPM dikelompokkan menurut bidangnya. Pilih kelompok untuk melihat rinciannya.</p>
            </header>
            <div class="wew reveal d1">
                <div class="wtabs" role="tablist" aria-label="Kelompok wewenang" aria-orientation="vertical">
                    <button class="wtab" role="tab" id="wt-A" aria-controls="wp-A" aria-selected="true" tabindex="0"><i>A</i><span><strong>Peraturan</strong><small>4 wewenang</small></span></button>
                    <button class="wtab" role="tab" id="wt-B" aria-controls="wp-B" aria-selected="false" tabindex="-1"><i>B</i><span><strong>LEM Universitas</strong><small>4 wewenang</small></span></button>
                    <button class="wtab" role="tab" id="wt-C" aria-controls="wp-C" aria-selected="false" tabindex="-1"><i>C</i><span><strong>Kelembagaan</strong><small>4 wewenang</small></span></button>
                </div>
                <div>
                    <div class="wpanel" role="tabpanel" id="wp-A" aria-labelledby="wt-A">
                        <h3>Pembentukan dan perubahan peraturan</h3>
                        <ul class="rows">
                            <li><span>Mengubah Peraturan Dasar atas kesepakatan anggota DPM Universitas. Usul perubahan diajukan sekurang-kurangnya ½ + 1 anggota DPM dan sidang perubahan dihadiri ¾ anggota DPM.</span><span class="pasal">Pasal 45 ayat (2), 56</span></li>
                            <li><span>Menyusun dan mengesahkan garis-garis besar haluan melalui Sidang Umum atau Sidang Istimewa.</span><span class="pasal">Pasal 46 ayat (2)</span></li>
                            <li><span>Menyusun dan mengesahkan Peraturan KM UII.</span><span class="pasal">Pasal 47 ayat (1), (4)</span></li>
                            <li><span>Membuat dan mengesahkan Peraturan DPM.</span><span class="pasal">Pasal 48 ayat (1)</span></li>
                        </ul>
                    </div>
                    <div class="wpanel" role="tabpanel" id="wp-B" aria-labelledby="wt-B" hidden>
                        <h3>Hubungan dengan LEM Universitas</h3>
                        <ul class="rows">
                            <li><span>Menyetujui nota pengantar kepengurusan LEM; Ketua LEM Universitas adalah mandataris DPM.</span><span class="pasal">Pasal 24 ayat (1)–(2)</span></li>
                            <li><span>Ketua DPM melantik dan mengambil sumpah Ketua serta fungsionaris LEM.</span><span class="pasal">Pasal 24 ayat (4)</span></li>
                            <li><span>Menetapkan pengganti Ketua LEM dari anggota DPM melalui Sidang Pleno bila Ketua LEM berhenti atau bermasalah.</span><span class="pasal">Pasal 24 ayat (6)</span></li>
                            <li><span>Menerima program kerja dan laporan tiga bulanan LEM, serta mengesahkan laporan keuangan triwulan.</span><span class="pasal">Pasal 25 ayat (1), (3), (4)</span></li>
                        </ul>
                    </div>
                    <div class="wpanel" role="tabpanel" id="wp-C" aria-labelledby="wt-C" hidden>
                        <h3>Lembaga Khusus dan kelembagaan</h3>
                        <ul class="rows">
                            <li><span>Melantik dan mengambil sumpah struktur kepengurusan Lembaga Khusus.</span><span class="pasal">Pasal 31 ayat (2)</span></li>
                            <li><span>Memberi izin pembentukan Lembaga Khusus baru tingkat universitas.</span><span class="pasal">Pasal 41 ayat (2)</span></li>
                            <li><span>Memberi izin dan pengesahan pembubaran lembaga kemahasiswaan.</span><span class="pasal">Pasal 42 ayat (1)</span></li>
                            <li><span>Mengesahkan Presidium fakultas melalui Keputusan DPM Universitas.</span><span class="pasal">Pasal 40 ayat (3)</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= 05 DASAR HUKUM ================= -->
    <section class="band" id="dasar-hukum" aria-labelledby="h-dh">
        <div class="container band-grid">
            <header class="band-head">
                <span class="big-no" aria-hidden="true">05</span>
                <h2 id="h-dh">Dasar Hukum</h2>
                <p>Peraturan yang menjadi rujukan ketentuan pada halaman ini.</p>
            </header>
            <div>
                <div class="law-main reveal d1">
                    <span class="abbr">PDKM</span>
                    <div>
                        <h3>Peraturan Dasar Keluarga Mahasiswa UII</h3>
                        <p>Konstitusi tertinggi KM UII yang mengatur asas, tujuan, kelembagaan, dan sistem pemerintahan mahasiswa.</p>
                    </div>
                    <a class="btn sm" href="{{ asset('uploads/produk-hukum/PDKM UII/PERATURAN DASAR KM UII KE-38 (1).pdf') }}" target="_blank" rel="noopener">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v11M7 11l5 5 5-5M5 20h14"/></svg>Unduh
                    </a>
                </div>
                <div class="law-grid">
                    <div class="law reveal d2">
                        <div class="law-t">
                            <small>Peraturan DPM</small>
                            <strong>Tata Tertib dan peraturan internal DPM UII (PDPM)</strong>
                        </div>
                        <div class="law-actions">
                            <a class="btn sm" href="{{ route('legal-products.type', 'pdpm') }}">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h5"/></svg>Buka arsip
                            </a>
                        </div>
                    </div>
                    <div class="law reveal d3">
                        <div class="law-t">
                            <small>PKM UII No. 3 Tahun 2019</small>
                            <strong>Tentang DPM U & DPM F</strong>
                        </div>
                        <div class="law-actions">
                            <a class="btn sm" href="{{ asset('uploads/produk-hukum/PKM UII/PKM UII NOMOR 3 TAHUN 2019 TENTANG DPM U & DPM F.pdf') }}" target="_blank" rel="noopener">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>Pratinjau
                            </a>
                            <a class="btn sm" href="{{ asset('uploads/produk-hukum/PKM UII/PKM UII NOMOR 3 TAHUN 2019 TENTANG DPM U & DPM F.pdf') }}" download rel="noopener">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v11M7 11l5 5 5-5M5 20h14"/></svg>Unduh
                            </a>
                        </div>
                    </div>
                    <div class="law reveal d4">
                        <div class="law-t">
                            <small>PKM UII No. 4 Tahun 2019</small>
                            <strong>Tentang Pedoman Pelaksanaan Foraslak Lembaga Legislatif KM UII</strong>
                        </div>
                        <div class="law-actions">
                            <a class="btn sm" href="{{ asset('uploads/produk-hukum/PKM UII/PKM UII NOMOR 4 TAHUN 2019 TENTANG PEDOMAN PELAKSANAAN FORASLAK LEMBAGA LEGISLATIF KM UII.pdf') }}" target="_blank" rel="noopener">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>Pratinjau
                            </a>
                            <a class="btn sm" href="{{ asset('uploads/produk-hukum/PKM UII/PKM UII NOMOR 4 TAHUN 2019 TENTANG PEDOMAN PELAKSANAAN FORASLAK LEMBAGA LEGISLATIF KM UII.pdf') }}" download rel="noopener">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v11M7 11l5 5 5-5M5 20h14"/></svg>Unduh
                            </a>
                        </div>
                    </div>
                    <div class="law reveal d1">
                        <div class="law-t">
                            <small>PKM UII No. 1 Tahun 2019</small>
                            <strong>Tentang Kode Etik Lembaga Legislatif UII</strong>
                        </div>
                        <div class="law-actions">
                            <a class="btn sm" href="{{ asset('uploads/produk-hukum/PKM UII/PKM UII NOMOR 1 TAHUN 2019 TENTANG KODE ETIK LEMBAGA LEGISLATIF UII.pdf') }}" target="_blank" rel="noopener">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>Pratinjau
                            </a>
                            <a class="btn sm" href="{{ asset('uploads/produk-hukum/PKM UII/PKM UII NOMOR 1 TAHUN 2019 TENTANG KODE ETIK LEMBAGA LEGISLATIF UII.pdf') }}" download rel="noopener">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v11M7 11l5 5 5-5M5 20h14"/></svg>Unduh
                            </a>
                        </div>
                    </div>
                    <div class="law reveal d2">
                        <div class="law-t">
                            <small>PKM UII No. 3 Tahun 2018</small>
                            <strong>Tentang Pengelolaan Aspirasi UII</strong>
                        </div>
                        <div class="law-actions">
                            <a class="btn sm" href="{{ asset('uploads/produk-hukum/PKM UII/PKM UII NOMOR 3 TAHUN 2018 TENTANG PENGELOLAAN ASPIRASI MAHASISWA UII.pdf') }}" target="_blank" rel="noopener">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>Pratinjau
                            </a>
                            <a class="btn sm" href="{{ asset('uploads/produk-hukum/PKM UII/PKM UII NOMOR 3 TAHUN 2018 TENTANG PENGELOLAAN ASPIRASI MAHASISWA UII.pdf') }}" download rel="noopener">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v11M7 11l5 5 5-5M5 20h14"/></svg>Unduh
                            </a>
                        </div>
                    </div>
                </div>
                <p class="disclaimer"><strong>Catatan.</strong> Halaman ini merupakan ringkasan untuk memudahkan pembaca. Untuk rumusan yang mengikat, rujuklah teks resmi Peraturan Dasar KM UII dan peraturan terkait pada halaman Produk Hukum.</p>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
function initKedudukanPage() {
    // --- Subnav active link highlighting ---
    const subnav = document.getElementById('subnav');
    const tocLinks = document.querySelectorAll('#toc a');
    const sections = document.querySelectorAll('.band[id]');

    if (subnav && tocLinks.length && sections.length) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.getAttribute('id');
                    tocLinks.forEach(link => {
                        const isActive = link.getAttribute('href') === '#' + id;
                        link.toggleAttribute('aria-current', isActive);
                        if (isActive) link.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                    });
                    // Progress bar
                    const index = Array.from(sections).indexOf(entry.target);
                    subnav.style.setProperty('--p', (index + 1) / sections.length);
                }
            });
        }, { rootMargin: '-120px 0px -60% 0px', threshold: 0.01 });
        sections.forEach(s => observer.observe(s));
    }

    // --- Wewenang tabs ---
    const wtabs = document.querySelectorAll('.wtab');
    const wpanels = document.querySelectorAll('.wpanel');
    console.log('[kedudukan] wtab count:', wtabs.length);
    console.log('[kedudukan] wpanel count:', wpanels.length);
    wtabs.forEach((tab, i) => {
        console.log('[kedudukan] tab', i, tab.getAttribute('aria-controls'));
        tab.addEventListener('click', () => {
            console.log('[kedudukan] click', tab.getAttribute('aria-controls'));
            const target = tab.getAttribute('aria-controls');
            wtabs.forEach(t => {
                t.setAttribute('aria-selected', 'false');
                t.setAttribute('tabindex', '-1');
            });
            wpanels.forEach(p => p.hidden = true);
            tab.setAttribute('aria-selected', 'true');
            tab.setAttribute('tabindex', '0');
            document.getElementById(target)?.hidden = false;
        });
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initKedudukanPage);
} else {
    initKedudukanPage();
}
</script>
@endpush
@endsection