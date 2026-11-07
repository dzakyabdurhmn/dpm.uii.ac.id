@extends('layouts.site')

@php
    $active = $entries[$defaultIndex] ?? $entries->first();
@endphp

@section('title', 'GBHKM — Garis-Garis Besar Haluan Keluarga Mahasiswa UII | DPM UII')
@section('meta_description', $types['gbhkm']['description'])

@push('styles')
<style>
  /* ---------- GBHKM per periode ---------- */
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
  .sheet .sh-mid b { display: block; font-family: 'Wix Madefor Display', sans-serif; font-size: 54px; font-weight: 800; letter-spacing: -2px; line-height: 1; }
  .sheet .sh-mid span { display: block; margin-top: 12px; font-size: 13px; line-height: 1.5; color: var(--t-sub); }
  .sheet .sh-line { height: 1px; margin: 0 auto 14px; width: 60%; background: var(--b-btn); }
  .sheet .sh-bot { display: flex; justify-content: space-between; align-items: flex-end; gap: 10px; }
  .sheet .sh-bot strong { font-family: 'Wix Madefor Display', sans-serif; font-size: 20px; text-align: right; }
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
  .edcards { display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 12px; }
  .edc { position: relative; display: flex; flex-direction: column; gap: 14px; padding: 20px 22px 18px; text-align: left; font: inherit; color: var(--t-cap); background: var(--navy-card); border: 1px solid var(--b-default); border-radius: 8px; cursor: pointer; overflow: hidden; transition: border-color .2s, background .2s, color .2s, transform .2s; }
  .edc::before { content: ''; position: absolute; left: 0; right: 0; top: 0; height: 3px; background: var(--white); transform: scaleX(0); opacity: 0; transform-origin: left; transition: transform .3s, opacity .3s; }
  .edc:hover { border-color: var(--b-btn); background: var(--navy-hover); color: var(--white); }
  .edc[aria-selected="true"] { color: var(--white); border-color: var(--b-btn-hover); background: var(--navy-hover); box-shadow: var(--sh-md); }
  .edc[aria-selected="true"]::before { transform: scaleX(1); opacity: 1; }
  .edc .e-top { display: flex; align-items: center; justify-content: space-between; gap: 8px; }
  .edc .e-lbl { font-size: 10.5px; font-weight: 600; letter-spacing: 1.6px; text-transform: uppercase; }
  .edc .e-badge { padding: 3px 10px; border: 1px solid var(--b-btn); border-radius: 100px; font-size: 10.5px; font-weight: 600; letter-spacing: .6px; text-transform: uppercase; color: var(--white); white-space: nowrap; }
  .edc .e-badge.run { border-color: rgba(126,217,167,.55); color: #9FE3C0; }
  .edc .e-badge.off { border-style: dashed; color: var(--t-cap); }
  .edc .e-no { font-family: 'Wix Madefor Display', sans-serif; font-size: 30px; font-weight: 800; line-height: 1.1; letter-spacing: -1px; color: inherit; }
  .edc .e-meta { font-size: 12.5px; color: var(--t-cap); }
  .edc[aria-selected="true"] .e-meta { color: var(--t-sub); }
  @media (max-width: 480px) { .edc { padding: 16px; } .edc .e-no { font-size: 26px; } }
  .ednote { margin-top: 14px; padding: 14px 18px; border-left: 2px solid var(--b-btn-hover); background: rgba(255,255,255,.03); font-size: 13.5px; color: var(--t-sub); line-height: 1.7; }
  .ednote[hidden] { display: none; }
  .is-off { opacity: .45; pointer-events: none; }

  .rule { display: flex; gap: 16px; align-items: flex-start; margin-top: 28px; padding: 20px 22px; border: 1px solid var(--b-btn); border-radius: 8px; background: linear-gradient(135deg, rgba(255,255,255,.05), rgba(255,255,255,.015)); }
  .rule svg { flex-shrink: 0; width: 22px; height: 22px; margin-top: 2px; stroke: var(--white); fill: none; stroke-width: 1.7; stroke-linecap: round; stroke-linejoin: round; }
  .rule strong { display: block; margin-bottom: 4px; font-family: 'Wix Madefor Display', sans-serif; font-size: 16px; }
  .rule p { font-size: 13.5px; color: var(--t-sub); line-height: 1.7; }

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

  /* alur penetapan */
  .flow { display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; list-style: none; counter-reset: f; padding: 0; }
  .flow li { position: relative; counter-increment: f; padding: 22px 20px 20px; border: 1px solid var(--b-default); border-radius: 8px; background: var(--navy-card); }
  .flow li::before { content: counter(f, decimal-leading-zero); display: block; margin-bottom: 12px; font-family: 'Wix Madefor Display', sans-serif; font-size: 26px; font-weight: 800; letter-spacing: -1px; color: var(--t-cap); }
  .flow li::after { content: '\2192'; position: absolute; right: -13px; top: 26px; z-index: 1; font-size: 15px; color: var(--t-cap); }
  .flow li:last-child::after { content: none; }
  .flow strong { display: block; margin-bottom: 6px; font-size: 15px; }
  .flow span { font-size: 12.5px; color: var(--t-cap); line-height: 1.65; }

  /* tabel arsip */
  .tbl-wrap { overflow-x: auto; border: 1px solid var(--b-default); border-radius: 8px; background: var(--navy-card); }
  .tbl { width: 100%; border-collapse: collapse; font-size: 13.5px; min-width: 640px; }
  .tbl th { padding: 13px 18px; text-align: left; font-size: 11px; font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; color: var(--t-cap); border-bottom: 1px solid var(--b-btn); white-space: nowrap; }
  .tbl td { padding: 15px 18px; border-bottom: 1px solid var(--b-default); color: var(--t-sub); vertical-align: middle; }
  .tbl tr:last-child td { border-bottom: 0; }
  .tbl tr:hover td { background: rgba(255,255,255,.02); }
  .tbl td b { font-family: 'Wix Madefor Display', sans-serif; font-size: 15px; color: var(--white); }
  .tbl .st { display: inline-block; padding: 3px 10px; border: 1px solid var(--b-btn); border-radius: 100px; font-size: 10.5px; font-weight: 600; letter-spacing: .6px; text-transform: uppercase; color: var(--white); white-space: nowrap; }
  .tbl .st.run { border-color: rgba(126,217,167,.55); color: #9FE3C0; }
  .tbl .st.off { border-style: dashed; color: var(--t-cap); }
  .tbl a { font-weight: 600; color: var(--white); white-space: nowrap; }
  .tbl a:hover { text-decoration: underline; }
  .tbl .muted { color: var(--t-cap); font-size: 12.5px; }

  .links { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
  .links a { display: flex; flex-direction: column; gap: 6px; padding: 22px; border: 1px solid var(--b-default); border-radius: 8px; background: var(--navy-card); transition: border-color .2s, background .2s; }
  .links a:hover { border-color: var(--b-btn); background: var(--navy-hover); }
  .links strong { font-size: 16px; } .links span { font-size: 13.5px; color: var(--t-cap); line-height: 1.6; }
  .links em { margin-top: 6px; font-style: normal; font-size: 13px; font-weight: 600; color: var(--white); }

  @media (max-width: 1080px) {
    .doc-hero { grid-template-columns: 1fr; }
    .sheet { display: none; }
    .links { grid-template-columns: 1fr 1fr; }
    .facts-row { grid-template-columns: 1fr 1fr; }
    .facts-row div:nth-child(3) { border-left: 0; }
    .facts-row div:nth-child(n+3) { border-top: 1px solid var(--b-default); }
    .flow { grid-template-columns: 1fr 1fr; }
    .flow li::after { content: none; }
  }
  @media (max-width: 720px) {
    .links { grid-template-columns: 1fr; }
    .band-wide { padding: 56px 0; }
    .pg-head h1.big { letter-spacing: -3px; }
    .reader.open .reader-body { height: 70vh; }
    .facts-row div { padding: 16px 18px; }
    .flow { grid-template-columns: 1fr; }
    .rule { padding: 16px; }
  }
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
        <span aria-current="page">Garis-Garis Besar Haluan Keluarga Mahasiswa (GBHKM)</span>
      </nav>
      <span class="eyebrow2">Produk Hukum &middot; Haluan Periode</span>
      <h1 class="big">GBHKM</h1>
      <p class="pg-sub">Garis-Garis Besar Haluan Keluarga Mahasiswa UII</p>
      <p class="pg-desc">Manifestasi arah gerak dan cita-cita mahasiswa UII yang disusun dan disahkan DPM UII melalui Sidang Umum atau Sidang Istimewa. Satu naskah ditetapkan untuk satu periode kepengurusan.</p>
      <div class="hero-btns">
        <a class="btn lg" href="#baca" data-read id="readBtn">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
          Baca Dokumen
        </a>
        <a class="btn lg dl" href="{{ $active['download'] ?? '#' }}" rel="noopener" target="_blank">
          <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v11M7 11l5 5 5-5M5 20h14"/></svg>
          Unduh GBHKM
        </a>
      </div>
    </div>
    <div class="sheet" aria-hidden="true">
      <span class="seal"><svg viewBox="0 0 24 24"><path d="M3 21h18M5 21V10M10 21V10M14 21V10M19 21V10M2 10 12 3l10 7z"/></svg></span>
      <small>Keluarga Mahasiswa UII</small>
      <div class="sh-mid">
        <b>GBHKM</b>
        <span>Garis-Garis Besar Haluan<br>Keluarga Mahasiswa<br>Universitas Islam Indonesia</span>
      </div>
      <div class="sh-line"></div>
      <div class="sh-bot"><small>Periode</small><strong id="shEd">{{ $active['label'] }}</strong></div>
    </div>
  </div>
</section>

<div class="edbar-wrap">
  <div class="container">
    <div class="edhead"><span id="edLbl">Periode Kepengurusan</span><i></i></div>
    <div class="edcards" role="tablist" aria-labelledby="edLbl" id="edsw">
      @foreach ($entries as $i => $entry)
        <button type="button" class="edc" role="tab" data-index="{{ $i }}" aria-selected="{{ $i === $defaultIndex ? 'true' : 'false' }}" tabindex="{{ $i === $defaultIndex ? '0' : '-1' }}">
          <span class="e-top">
            <span class="e-lbl">Periode</span>
            <span class="e-badge {{ $entry['status'] === 'Berjalan' ? 'run' : 'off' }}">{{ $entry['status'] }}</span>
          </span>
          <span class="e-no">{{ $entry['label'] }}</span>
          <span class="e-meta">{{ $entry['hasDoc'] ? ($entry['enacted'] ? 'Ditetapkan '.$entry['enacted'] : 'Naskah tersedia') : 'Belum ada naskah' }}</span>
        </button>
      @endforeach
    </div>
    <p class="ednote" id="ednote" hidden></p>

    <div class="rule">
      <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3l8 4v5c0 5-3.5 8-8 9-4.5-1-8-4-8-9V7z"/><path d="M9 12l2 2 4-4"/></svg>
      <div>
        <strong>Satu GBHKM untuk satu periode</strong>
        <p>GBHKM ditetapkan sekali pada awal periode kepengurusan melalui Sidang Umum atau Sidang Istimewa, lalu menjadi haluan seluruh lembaga KM UII selama periode tersebut berjalan. Sistem arsip ini menolak entri kedua untuk periode yang sama.</p>
      </div>
    </div>
  </div>
</div>

<div class="facts-wrap">
  <div class="container">
    <div class="facts-row">
      <div><small>Periode</small><b id="fEd">{{ $active['label'] }}</b></div>
      <div><small>Ditetapkan</small><b id="fYr">{{ $active['enacted'] ?? '—' }}</b></div>
      <div><small>Forum Penetapan</small><b id="fFo">{{ $active['forum'] ?? '—' }}</b></div>
      <div><small>Status</small><b id="fSt">{{ $active['status'] }}</b></div>
    </div>
  </div>
</div>

<section class="band-wide alt" id="baca">
  <div class="container">
    <div class="sec-h">
      <span class="eyebrow2">Naskah</span>
      <h2>Baca Naskah GBHKM</h2>
      <p>Buka naskah periode terpilih di halaman ini atau unduh untuk dibaca secara luring.</p>
    </div>
    <div class="reader" id="reader">
      <div class="reader-bar">
        <strong id="rTitle">GBHKM Periode {{ $active['label'] }}{{ $active['enacted'] ? ' · '.$active['enacted'] : '' }}</strong>
        <div>
          <a class="btn sm dl" href="{{ $active['download'] ?? '#' }}" rel="noopener" target="_blank">
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
      <span class="eyebrow2">Siklus</span>
      <h2>Dari Penyusunan hingga Evaluasi</h2>
      <p>Perjalanan GBHKM dalam satu periode kepengurusan.</p>
    </div>
    <ol class="flow">
      <li><strong>Disusun</strong><span>Draf haluan dirumuskan dari aspirasi mahasiswa dan evaluasi periode sebelumnya.</span></li>
      <li><strong>Dibahas</strong><span>Draf dibahas bersama lembaga kemahasiswaan dan komisi terkait di DPM UII.</span></li>
      <li><strong>Disahkan</strong><span>Disahkan melalui Sidang Umum atau Sidang Istimewa sebagai naskah resmi periode.</span></li>
      <li><strong>Dijalankan</strong><span>Menjadi landasan rencana kerja seluruh lembaga KM UII selama periode berjalan.</span></li>
      <li><strong>Dievaluasi</strong><span>Capaian haluan dievaluasi dan menjadi bahan penyusunan GBHKM periode berikutnya.</span></li>
    </ol>
  </div>
</section>

<section class="band-wide alt">
  <div class="container">
    <div class="sec-h">
      <span class="eyebrow2">Arsip</span>
      <h2>Arsip GBHKM per Periode</h2>
      <p>Seluruh periode kepengurusan beserta status naskah GBHKM-nya.</p>
    </div>
    <div class="tbl-wrap">
      <table class="tbl" id="tbl">
        <thead>
          <tr><th>Periode</th><th>Ditetapkan</th><th>Forum Penetapan</th><th>Status</th><th>Dokumen</th></tr>
        </thead>
        <tbody>
          @foreach ($entries as $entry)
            <tr>
              <td><b>{{ $entry['label'] }}</b></td>
              <td>{{ $entry['enacted'] ?? '—' }}</td>
              <td>{{ $entry['forum'] ?? '—' }}</td>
              <td><span class="st {{ $entry['status'] === 'Berjalan' ? 'run' : 'off' }}">{{ $entry['status'] }}</span></td>
              <td>
                @if ($entry['hasDoc'])
                  <a href="{{ $entry['download'] }}" rel="noopener" target="_blank">Unduh {{ $entry['extension'] }}</a>
                  @if ($entry['size'] && $entry['size'] !== '-')
                    <span class="muted">&middot; {{ $entry['size'] }}</span>
                  @endif
                @else
                  <span class="muted">Belum tersedia</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>

<section class="band-wide">
  <div class="container">
    <div class="sec-h">
      <span class="eyebrow2">Peraturan Terkait</span>
      <h2>Produk Hukum Lainnya</h2>
      <p>GBHKM menjabarkan PDKM dan menjadi dasar penyusunan peraturan di bawahnya.</p>
    </div>
    <div class="links">
      <a href="{{ route('legal-products.type', 'pdkm') }}">
        <strong>Peraturan Dasar (PDKM)</strong>
        <span>Konstitusi tertinggi KM UII yang menjadi sumber bagi GBHKM.</span>
        <em>Buka halaman &rarr;</em>
      </a>
      <a href="{{ route('legal-products.type', 'pkm') }}">
        <strong>Peraturan KM UII (PKM)</strong>
        <span>Peraturan teknis yang menjabarkan PDKM dan GBHKM.</span>
        <em>Buka arsip &rarr;</em>
      </a>
      <a href="{{ route('legal-products.type', 'pdpm') }}">
        <strong>Peraturan DPM (PDPM)</strong>
        <span>Tata tertib, mekanisme kerja, dan persidangan DPM UII.</span>
        <em>Buka arsip &rarr;</em>
      </a>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
  // Data periode & naskah GBHKM langsung dari database.
  const ENTRIES = @json($entries);
  const DEFAULT_INDEX = @json($defaultIndex);

  (function () {
    const $ = id => document.getElementById(id);
    const sw = $('edsw'), reader = $('reader');
    const cards = Array.from(sw.querySelectorAll('.edc'));
    let cur = DEFAULT_INDEX;

    function resetReader() {
      const f = reader.querySelector('iframe');
      if (f) f.remove();
      reader.classList.remove('open');
    }

    function load() {
      const e = ENTRIES[cur];
      if (!e || !e.hasDoc || !e.url || reader.classList.contains('open')) return;
      const f = document.createElement('iframe');
      f.src = e.url;
      f.title = 'Naskah GBHKM periode ' + e.label;
      reader.querySelector('.reader-body').appendChild(f);
      reader.classList.add('open');
    }

    function show(i) {
      cur = i;
      const e = ENTRIES[i];
      if (!e) return;
      cards.forEach((b, n) => {
        b.setAttribute('aria-selected', n === i ? 'true' : 'false');
        b.tabIndex = n === i ? 0 : -1;
      });
      $('fEd').textContent = e.label;
      $('fYr').textContent = e.enacted || '\u2014';
      $('fFo').textContent = e.forum || '\u2014';
      $('fSt').textContent = e.status;
      $('shEd').textContent = e.label;
      $('rTitle').textContent = 'GBHKM Periode ' + e.label + (e.enacted ? ' \u00b7 ' + e.enacted : '');

      document.querySelectorAll('.dl').forEach(a => {
        if (e.hasDoc && e.download) {
          a.href = e.download;
          a.classList.remove('is-off');
          a.removeAttribute('aria-disabled');
        } else {
          a.removeAttribute('href');
          a.classList.add('is-off');
          a.setAttribute('aria-disabled', 'true');
        }
      });

      $('readBtn').classList.toggle('is-off', !e.hasDoc);
      $('loadDoc').disabled = !e.hasDoc;
      $('loadDoc').classList.toggle('is-off', !e.hasDoc);

      const n = $('ednote');
      if (!e.hasDoc) {
        n.hidden = false;
        n.textContent = e.status === 'Belum ditetapkan'
          ? 'GBHKM periode ' + e.label + ' belum ditetapkan atau naskahnya belum diunggah ke situs ini.'
          : 'Naskah GBHKM periode ' + e.label + ' belum diunggah ke situs ini. Hubungi Badan Legislasi atau Sekretariat DPM UII untuk memperolehnya.';
      } else if (e.status === 'Arsip') {
        n.hidden = false;
        n.textContent = 'Anda melihat arsip GBHKM periode ' + e.label + '. Periode ini sudah tidak berjalan; naskah tetap tersedia sebagai rujukan.';
      } else {
        n.hidden = true;
      }
      resetReader();
    }

    cards.forEach((b, i) => {
      b.addEventListener('click', () => show(i));
      b.addEventListener('keydown', ev => {
        if (!['ArrowLeft', 'ArrowRight'].includes(ev.key)) return;
        ev.preventDefault();
        const n = (i + (ev.key === 'ArrowRight' ? 1 : -1) + cards.length) % cards.length;
        cards[n].focus();
        show(n);
      });
    });

    $('loadDoc').addEventListener('click', load);
    document.querySelector('[data-read]').addEventListener('click', () => setTimeout(load, 350));
    if (ENTRIES.length) show(DEFAULT_INDEX);
  })();
</script>
@endpush