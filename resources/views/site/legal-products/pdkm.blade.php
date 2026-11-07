@extends('layouts.site')

@php
    $editions = $products->map(function ($p, $idx) {
        $editionLabel = $p->edition ?: ($p->regulation_number ?: 'Ke-'.($p->number ?: ($idx + 1)));
        $shortEdition = preg_replace('/\s*\(.*?\)/', '', $editionLabel);

        return [
            'id' => $p->id,
            'no' => $p->number ?: ($idx + 1),
            'label' => $editionLabel,
            'short' => $shortEdition,
            'year' => (string) ($p->year ?? ''),
            'status' => $p->status === 'aktif' ? 'Berlaku' : 'Tidak Berlaku',
            'url' => $p->download_url,
            'title' => $p->title,
        ];
    })->values();

    $activeProduct = $products->firstWhere('status', 'aktif') ?? $products->first();
@endphp

@section('title', 'PDKM — Peraturan Dasar Keluarga Mahasiswa UII | DPM UII')
@section('meta_description', 'Konstitusi tertinggi KM UII yang mengatur asas, tujuan, kelembagaan, dan sistem pemerintahan mahasiswa. Berlaku sebagai satu naskah tunggal yang jarang diubah.')

@push('styles')
<style>
  /* ---------- PDKM v2 Styles ---------- */
  .nav-item.current > a::after { transform: scaleX(1); }
  .mega-links a[aria-current] { background: var(--bg-hover); }
  :focus-visible { outline: 2px solid var(--white); outline-offset: 2px; }
  html { scroll-padding-top: 150px; }

  /* hero */
  .pg-head { position: relative; overflow: hidden; border-bottom: 1px solid var(--b-default); padding: 56px 0 64px;
    background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%); }
  .pg-head::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 28px); }
  .doc-hero { display: grid; grid-template-columns: 1.3fr .7fr; gap: 48px; align-items: center; }
  .crumb { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 28px; font-size: 12.5px; color: var(--t-cap); }
  .crumb a { transition: color .2s; } .crumb a:hover { color: var(--white); }
  .crumb span[aria-hidden] { opacity: .5; }
  .crumb span[aria-current] { color: var(--white); font-weight: 600; }
  .pg-head h1.big { font-size: clamp(64px, 11vw, 132px); letter-spacing: -5px; line-height: .95; margin-bottom: 12px; }
  .pg-sub { margin-bottom: 14px; font-family: 'Wix Madefor Display', sans-serif; font-size: clamp(20px, 2.4vw, 28px); font-weight: 600; color: var(--white); }
  .pg-desc { max-width: 580px; margin-bottom: 28px; font-size: 16px; color: var(--t-sub); }
  .hero-btns { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 26px; }
  .btn.lg { padding: 13px 24px; font-size: 14px; }
  .btn svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 1.9; stroke-linecap: round; stroke-linejoin: round; }

  .sheet { position: relative; max-width: 330px; margin-left: auto; aspect-ratio: 3/4; padding: 30px 28px; display: flex; flex-direction: column; border: 1px solid var(--b-btn-hover); border-radius: 8px; background: linear-gradient(160deg, #002451, #001A3A); box-shadow: 0 30px 60px rgba(0,0,0,.45), 14px 14px 0 -1px rgba(255,255,255,.05), 14px 14px 0 0 var(--b-default); }
  .sheet::before { content: ''; position: absolute; inset: 10px; border: 1px solid var(--b-default); border-radius: 4px; pointer-events: none; }
  .sheet small { font-size: 10.5px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--t-cap); }
  .sheet > small:first-of-type { max-width: calc(100% - 64px); line-height: 1.6; }
  .sheet .sh-mid { flex: 1; display: flex; flex-direction: column; justify-content: center; text-align: center; }
  .sheet .sh-mid b { display: block; font-family: 'Wix Madefor Display', sans-serif; font-size: 58px; font-weight: 800; letter-spacing: -2px; line-height: 1; }
  .sheet .sh-mid span { display: block; margin-top: 12px; font-size: 13px; line-height: 1.5; color: var(--t-sub); }
  .sheet .sh-line { height: 1px; margin: 0 auto 14px; width: 60%; background: var(--b-btn); }
  .sheet .sh-bot { display: flex; justify-content: space-between; align-items: flex-end; }
  .sheet .sh-bot strong { font-family: 'Wix Madefor Display', sans-serif; font-size: 20px; }
  .sheet .seal { position: absolute; right: 26px; top: 26px; width: 44px; height: 44px; border: 1px solid var(--b-btn); border-radius: 50%; display: grid; place-items: center; }
  .sheet .seal svg { width: 20px; height: 20px; stroke: rgba(255,255,255,.7); fill: none; stroke-width: 1.6; }

  .facts-wrap { padding-top: 14px; }
  .facts-row { display: grid; grid-template-columns: repeat(4, 1fr); border: 1px solid var(--b-default); border-radius: 8px; background: var(--navy-card); margin-top: -1px; }
  .facts-row div { padding: 22px 24px; }
  .facts-row div + div { border-left: 1px solid var(--b-default); }
  .facts-row small { display: block; margin-bottom: 6px; font-size: 11px; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; color: var(--t-cap); }
  .facts-row b { font-family: 'Wix Madefor Display', sans-serif; font-size: 18px; }

  .edbar-wrap { padding: 36px 0 0; }
  .edhead { display: flex; align-items: center; gap: 16px; margin-bottom: 14px; }
  .edhead span { font-size: 11.5px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--t-cap); white-space: nowrap; }
  .edhead i { flex: 1; height: 1px; background: var(--b-default); }
  .edcards { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; }
  .edc { position: relative; display: flex; flex-direction: column; gap: 14px; padding: 20px 22px 18px; text-align: left; font: inherit; color: var(--t-cap); background: var(--navy-card); border: 1px solid var(--b-default); border-radius: 8px; cursor: pointer; overflow: hidden; transition: border-color .2s, background .2s, color .2s, transform .2s; }
  .edc::before { content: ''; position: absolute; left: 0; right: 0; top: 0; height: 3px; background: var(--white); transform: scaleX(0); opacity: 0; transform-origin: left; transition: transform .3s, opacity .3s; }
  .edc:hover { border-color: var(--b-btn); background: var(--navy-hover); color: var(--white); }
  .edc[aria-selected="true"] { color: var(--white); border-color: var(--b-btn-hover); background: var(--navy-hover); box-shadow: var(--sh-md); }
  .edc[aria-selected="true"]::before { transform: scaleX(1); opacity: 1; }
  .edc .e-top { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
  .edc .e-lbl { font-size: 10.5px; font-weight: 600; letter-spacing: 1.6px; text-transform: uppercase; }
  .edc .e-badge { padding: 3px 10px; border: 1px solid var(--b-btn); border-radius: 100px; font-size: 10.5px; font-weight: 600; letter-spacing: .6px; text-transform: uppercase; color: var(--white); }
  .edc .e-badge.off { border-style: dashed; color: var(--t-cap); }
  .edc .e-no { font-family: 'Wix Madefor Display', sans-serif; font-size: 40px; font-weight: 800; line-height: 1; letter-spacing: -1.5px; color: inherit; }
  .edc .e-no small { font-size: 18px; font-weight: 600; letter-spacing: 0; margin-right: 4px; opacity: .6; }
  .edc .e-meta { font-size: 12.5px; color: var(--t-cap); }
  .edc[aria-selected="true"] .e-meta { color: var(--t-sub); }
  @media (max-width: 1080px) { .edcards { grid-template-columns: 1fr 1fr; } }
  @media (max-width: 480px) { .edc { padding: 16px; } .edc .e-no { font-size: 32px; } }
  .ednote { margin-top: 14px; padding: 14px 18px; border-left: 2px solid var(--b-btn-hover); background: rgba(255,255,255,.03); font-size: 13.5px; color: var(--t-sub); line-height: 1.7; }
  .ednote[hidden] { display: none; }
  .is-off { opacity: .45; pointer-events: none; }

  .band-wide { padding: 80px 0; border-bottom: 1px solid var(--b-default); }
  .band-wide.alt { background: var(--navy-footer); }
  .sec-h { max-width: 640px; margin-bottom: 36px; }
  .sec-h h2 { margin-bottom: 10px; font-size: clamp(26px, 3vw, 36px); letter-spacing: -.8px; }
  .sec-h p { font-size: 15px; color: var(--t-cap); }
  .eyebrow2 { display: block; margin-bottom: 10px; font-size: 11.5px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--t-cap); }

  .reader { border: 1px solid var(--b-btn); border-radius: 12px; overflow: hidden; background: var(--navy-card); }
  .reader-bar { display: flex; flex-wrap: wrap; gap: 12px; align-items: center; justify-content: space-between; padding: 14px 20px; border-bottom: 1px solid var(--b-default); }
  .reader-bar strong { font-size: 14.5px; }
  .reader-bar div { display: flex; gap: 8px; }
  .reader-body { position: relative; min-height: 320px; display: grid; place-items: center; text-align: center; padding: 48px 24px; }
  .reader-body p { max-width: 440px; margin: 0 auto 20px; font-size: 14.5px; color: var(--t-sub); line-height: 1.7; }
  .reader-body iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; background: #fff; }
  .reader.open .reader-body { padding: 0; height: 78vh; min-height: 520px; }
  .reader.open .reader-ph { display: none; }

  .links { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
  .links a { display: flex; flex-direction: column; gap: 6px; padding: 22px; border: 1px solid var(--b-default); border-radius: 8px; background: var(--navy-card); transition: border-color .2s, background .2s; }
  .links a:hover { border-color: var(--b-btn); background: var(--navy-hover); }
  .links strong { font-size: 16px; } .links span { font-size: 13.5px; color: var(--t-cap); line-height: 1.6; }
  .links em { margin-top: 6px; font-style: normal; font-size: 13px; font-weight: 600; color: var(--white); }

  .note { margin-top: 24px; padding: 18px 22px; border-left: 2px solid var(--b-btn-hover); background: rgba(255,255,255,.03); font-size: 13.5px; color: var(--t-sub); line-height: 1.7; }
  .note strong { color: var(--white); }

  @media (max-width: 1080px) { 
    .doc-hero { grid-template-columns: 1fr; } 
    .sheet { display: none; } 
    .links { grid-template-columns: 1fr 1fr; } 
    .facts-row { grid-template-columns: 1fr 1fr; } 
    .facts-row div:nth-child(3) { border-left: 0; } 
    .facts-row div:nth-child(n+3) { border-top: 1px solid var(--b-default); } 
  }
  @media (max-width: 720px) { 
    .links { grid-template-columns: 1fr; } 
    .band-wide { padding: 56px 0; } 
    .pg-head h1.big { letter-spacing: -3px; } 
    .reader.open .reader-body { height: 70vh; } 
    .facts-row div { padding: 16px 18px; } 
  }

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
</style>
@endpush

@section('content')
<!-- ================= HERO ================= -->
<section class="pg-head">
  <div class="container doc-hero">
    <div>
      <nav class="crumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <span aria-hidden="true">/</span>
        <a href="{{ route('legal-products.index') }}">Produk Hukum</a>
        <span aria-hidden="true">/</span>
        <span aria-current="page">Peraturan Dasar Keluarga Mahasiswa (PDKM)</span>
      </nav>
      <span class="eyebrow2">Produk Hukum &middot; Konstitusi KM UII</span>
      <h1 class="big">PDKM</h1>
      <p class="pg-sub">Peraturan Dasar Keluarga Mahasiswa UII</p>
      <p class="pg-desc">Konstitusi tertinggi KM UII yang mengatur asas, tujuan, kelembagaan, dan sistem pemerintahan mahasiswa. Berlaku sebagai satu naskah tunggal yang jarang diubah.</p>
      <div class="hero-btns">
        <a class="btn lg" href="#baca" data-read id="readBtn">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
          Baca Dokumen
        </a>
        <a class="btn lg dl" href="{{ $activeProduct->download_url }}" rel="noopener" target="_blank">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v11M7 11l5 5 5-5M5 20h14"/></svg>
          Unduh PDKM
        </a>
      </div>
    </div>
    <div class="sheet" aria-hidden="true">
      <span class="seal"><svg viewBox="0 0 24 24"><path d="M3 21h18M5 21V10M10 21V10M14 21V10M19 21V10M2 10 12 3l10 7z"/></svg></span>
      <small>Keluarga Mahasiswa UII</small>
      <div class="sh-mid">
        <b>PDKM</b>
        <span>Peraturan Dasar<br>Keluarga Mahasiswa<br>Universitas Islam Indonesia</span>
      </div>
      <div class="sh-line"></div>
      <div class="sh-bot"><small>Edisi</small><strong id="shEd">{{ $activeProduct->edition ?: ($activeProduct->regulation_number ?: 'Ke-38 (1)') }}</strong></div>
    </div>
  </div>
</section>

<div class="edbar-wrap">
  <div class="container">
    <div class="edhead"><span id="edLbl">Edisi PDKM</span><i></i></div>
    <div class="edcards" role="tablist" aria-labelledby="edLbl" id="edsw"></div>
    <p class="ednote" id="ednote" hidden></p>
  </div>
</div>

<div class="facts-wrap">
  <div class="container">
    <div class="facts-row">
      <div><small>Edisi</small><b id="fEd">{{ $activeProduct->edition ?: ($activeProduct->regulation_number ?: 'Ke-38 (1)') }}</b></div>
      <div><small>Tahun</small><b id="fYr">{{ $activeProduct->year ?? '2024' }}</b></div>
      <div><small>Status</small><b id="fSt">{{ $activeProduct->status === 'aktif' ? 'Berlaku' : 'Tidak Berlaku' }}</b></div>
      <div><small>Perubahan</small><b>Melalui Pasal 56</b></div>
    </div>
  </div>
</div>

<section class="band-wide alt" id="baca">
  <div class="container">
    <div class="sec-h">
      <span class="eyebrow2">Naskah</span>
      <h2>Baca Naskah PDKM</h2>
      <p>Buka naskah di halaman ini atau unduh untuk dibaca secara luring.</p>
    </div>
    <div class="reader" id="reader">
      <div class="reader-bar">
        <strong id="rTitle">Peraturan Dasar KM UII {{ $activeProduct->edition ?: ($activeProduct->regulation_number ?: 'Ke-38 (1)') }} &middot; {{ $activeProduct->year ?? '2024' }}</strong>
        <div>
          <a class="btn sm dl" href="{{ $activeProduct->download_url }}" rel="noopener" target="_blank">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v11M7 11l5 5 5-5M5 20h14"/></svg>Unduh
          </a>
        </div>
      </div>
      <div class="reader-body">
        <div class="reader-ph">
          <p>Naskah dimuat hanya saat diminta agar halaman tetap ringan.</p>
          <button class="btn lg" type="button" id="loadDoc">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
            Muat naskah di halaman ini
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="band-wide">
  <div class="container">
    <div class="sec-h">
      <span class="eyebrow2">Peraturan Terkait</span>
      <h2>Peraturan Turunan</h2>
      <p>PDKM menjadi dasar bagi peraturan lain yang lebih rinci.</p>
    </div>
    <div class="links">
      <a href="{{ route('legal-products.type', 'pdpm') }}">
        <strong>Peraturan DPM (PDPM)</strong>
        <span>Peraturan DPM UII yang menjabarkan ketentuan PDKM.</span>
        <em>Buka arsip &rarr;</em>
      </a>
      <a href="{{ route('legal-products.type', 'pkm') }}">
        <strong>Peraturan KM UII (PKM)</strong>
        <span>Peraturan di tingkat Keluarga Mahasiswa yang disahkan DPM.</span>
        <em>Buka arsip &rarr;</em>
      </a>
      <a href="{{ route('about.show', 'kedudukan-tugas-wewenang') }}">
        <strong>Kedudukan, Tugas dan Wewenang</strong>
        <span>Posisi serta kewenangan DPM UII.</span>
        <em>Baca halaman &rarr;</em>
      </a>
    </div>
  </div>
</section>

<!-- ================= PRATINJAU ================= -->
<dialog class="pdlg" id="pdlg" aria-labelledby="pdTitle">
  <div class="pdlg-head">
    <div class="t"><small id="pdLabel"></small><strong id="pdTitle"></strong></div>
    <a class="btn sm" id="pdOpen" href="#" target="_blank" rel="noopener">
      <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h5"/></svg>
      <span>Buka di Drive</span>
    </a>
    <a class="btn sm" id="pdDl" href="#" rel="noopener">
      <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v11M7 11l5 5 5-5M5 20h14"/></svg>
      <span>Unduh</span>
    </a>
    <button class="pdlg-x" id="pdClose" type="button" aria-label="Tutup pratinjau">
      <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
    </button>
  </div>
  <div class="pdlg-body"><div class="pdlg-load">Memuat dokumen...</div><iframe id="pdFrame" title="Pratinjau dokumen" loading="lazy"></iframe></div>
</dialog>
@endsection

@push('scripts')
<script>
  // Daftar edisi PDKM dinamis dari database
  const EDITIONS = @json($editions);

  (function () {
    const $ = id => document.getElementById(id);
    const sw = $('edsw'), reader = $('reader');
    let cur = 0;

    function resetReader() { 
      const f = reader.querySelector('iframe'); 
      if (f) f.remove(); 
      reader.classList.remove('open'); 
    }

    function load() {
      const e = EDITIONS[cur]; 
      if (!e || !e.url || reader.classList.contains('open')) return;
      const f = document.createElement('iframe'); 
      f.src = e.url; 
      f.title = 'Naskah PDKM ' + e.label;
      reader.querySelector('.reader-body').appendChild(f); 
      reader.classList.add('open');
    }

    function show(i) {
      cur = i; 
      const e = EDITIONS[i];
      if (!e) return;
      const ok = !!e.url;
      sw.querySelectorAll('.edc').forEach((b, n) => { 
        b.setAttribute('aria-selected', n === i); 
        b.tabIndex = n === i ? 0 : -1; 
      });
      $('fEd').textContent = e.label; 
      $('fYr').textContent = e.year || '&ndash;'; 
      $('fSt').textContent = e.status;
      $('shEd').textContent = e.short;
      $('rTitle').textContent = 'Peraturan Dasar KM UII ' + e.label + (e.year ? ' &middot; ' + e.year : '');
      
      document.querySelectorAll('.dl').forEach(a => { 
        if (ok) { 
          a.href = e.url; 
          a.classList.remove('is-off'); 
          a.removeAttribute('aria-disabled'); 
        } else { 
          a.removeAttribute('href'); 
          a.classList.add('is-off'); 
          a.setAttribute('aria-disabled', 'true'); 
        } 
      });
      
      $('readBtn').classList.toggle('is-off', !ok); 
      $('loadDoc').disabled = !ok; 
      $('loadDoc').classList.toggle('is-off', !ok);
      
      const n = $('ednote');
      if (!ok) { 
        n.hidden = false; 
        n.textContent = 'Naskah ' + e.label + ' belum diunggah ke situs ini. Hubungi Badan Legislasi atau Sekretariat DPM UII untuk memperolehnya.'; 
      } else if (e.status !== 'Berlaku' && EDITIONS.length > 1) { 
        n.hidden = false; 
        n.textContent = 'Anda melihat edisi terdahulu (' + e.label + ').'; 
      } else { 
        n.hidden = true; 
      }
      resetReader();
    }

    EDITIONS.forEach((e, i) => {
      const b = document.createElement('button'); 
      b.type = 'button'; 
      b.className = 'edc'; 
      b.setAttribute('role', 'tab');
      const isAktif = e.status === 'Berlaku';
      b.innerHTML = '<span class="e-top"><span class="e-lbl">Edisi</span><span class="e-badge' + (isAktif ? '' : ' off') + '">' + esc(e.status) + '</span></span>'
        + '<span class="e-no">' + esc(e.label) + '</span>'
        + '<span class="e-meta">' + (e.year ? 'Tahun ' + esc(e.year) : (e.url ? 'Tersedia' : 'Belum diunggah')) + '</span>';
      b.addEventListener('click', () => show(i));
      b.addEventListener('keydown', ev => {
        if (!['ArrowLeft', 'ArrowRight'].includes(ev.key)) return; 
        ev.preventDefault();
        const n = (i + (ev.key === 'ArrowRight' ? 1 : -1) + EDITIONS.length) % EDITIONS.length; 
        sw.children[n].focus(); 
        show(n);
      });
      sw.appendChild(b);
    });

    function esc(s) {
      const d = document.createElement('div');
      d.textContent = s == null ? '' : s;
      return d.innerHTML;
    }

    $('loadDoc').addEventListener('click', load);
    document.querySelector('[data-read]').addEventListener('click', () => setTimeout(load, 350));
    if (EDITIONS.length) {
      show(0);
    }
  })();
</script>
@endpush