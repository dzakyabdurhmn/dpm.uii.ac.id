@extends('layouts.site')

@section('title', 'Dana & Laporan — DPM UII')

@section('content')
<section class="pg-head">
  <div class="container">
    <nav class="crumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Beranda</a>
      <span aria-hidden="true">/</span>
      <span aria-current="page">Dana</span>
    </nav>
    <span class="eyebrow">Keuangan · Transparansi</span>
    <h1>Dana &amp; Laporan</h1>
    <p class="pg-desc">Pertanggungjawaban, hasil audit, dan distribusi dana KM UII dalam satu tempat.</p>
  </div>
</section>

<section class="dana-section">
  <div class="container">
    <div class="dana-grid">
      <a class="dana-card" href="{{ route('documents.lpj') }}">
        <span class="ic" aria-hidden="true">
          <svg viewBox="0 0 24 24"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h6"/></svg>
        </span>
        <span class="tx">
          <strong>LPJ</strong>
          <small>Laporan pertanggungjawaban penggunaan dana kegiatan KM UII.</small>
        </span>
        <svg class="chev" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
      </a>

      <a class="dana-card" href="{{ route('documents.lha') }}">
        <span class="ic" aria-hidden="true">
          <svg viewBox="0 0 24 24"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="m9 14 2 2 4-4"/></svg>
        </span>
        <span class="tx">
          <strong>LHA</strong>
          <small>Laporan hasil audit atas penggunaan dana lembaga KM UII.</small>
        </span>
        <svg class="chev" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
      </a>

      <a class="dana-card" href="{{ route('dana.distribusi') }}">
        <span class="ic" aria-hidden="true">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v10M9.5 9.5h4a1.5 1.5 0 0 1 0 3h-3a1.5 1.5 0 0 0 0 3H15"/></svg>
        </span>
        <span class="tx">
          <strong>Distribusi Dana</strong>
          <small>Alokasi dana lembaga KM UII per periode dan triwulan.</small>
        </span>
        <svg class="chev" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
      </a>
    </div>
  </div>
</section>

<style>
  .pg-head {
    position: relative;
    overflow: hidden;
    border-bottom: 1px solid var(--b-default);
    padding: 56px 0 64px;
    background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%);
  }
  .pg-head::before {
    content: '';
    position: absolute;
    inset: 0;
    background: repeating-linear-gradient(135deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 28px);
  }
  .pg-head .container { position: relative; }
  .crumb {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 28px;
    font-size: 12.5px;
    color: var(--t-cap);
  }
  .crumb a:hover { color: var(--white); }
  .crumb span[aria-hidden] { opacity: .5; }
  .crumb span[aria-current] { color: var(--white); font-weight: 600; }
  .pg-head h1 {
    font-size: clamp(34px, 5.6vw, 62px);
    letter-spacing: -1.6px;
    line-height: 1.06;
    margin-bottom: 18px;
  }
  .pg-desc {
    max-width: 580px;
    font-size: 16px;
    color: var(--t-sub);
  }
  .eyebrow {
    display: block;
    margin-bottom: 12px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--t-cap);
  }

  .dana-section { padding: 56px 0 88px; }
  .dana-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 20px;
  }
  .dana-card {
    display: grid;
    grid-template-columns: 48px minmax(0, 1fr) 20px;
    gap: 18px;
    align-items: center;
    padding: 28px 26px;
    border: 1px solid var(--b-btn);
    border-radius: 12px;
    background: var(--navy-card);
    transition: background .2s, border-color .2s;
  }
  .dana-card:hover { background: var(--navy-hover); border-color: var(--b-btn-hover); }
  .dana-card .ic {
    display: grid;
    place-items: center;
    width: 48px;
    height: 48px;
    border: 1px solid var(--b-btn);
    border-radius: 8px;
    background: var(--navy);
  }
  .dana-card .ic svg,
  .dana-card .chev {
    width: 22px;
    height: 22px;
    fill: none;
    stroke: var(--white);
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
  }
  .dana-card .chev { width: 18px; height: 18px; opacity: .6; transition: transform .2s, opacity .2s; }
  .dana-card:hover .chev { transform: translateX(4px); opacity: 1; }
  .dana-card .tx strong {
    display: block;
    font-family: 'Wix Madefor Display', sans-serif;
    font-size: 18px;
    font-weight: 700;
    color: var(--white);
  }
  .dana-card .tx small {
    display: block;
    margin-top: 6px;
    font-size: 13px;
    line-height: 1.6;
    color: var(--t-cap);
  }

  @media (max-width: 900px) {
    .dana-grid { grid-template-columns: minmax(0, 1fr); }
  }
  @media (max-width: 720px) {
    .pg-head { padding: 36px 0 44px; }
    .dana-section { padding: 40px 0 64px; }
  }
</style>
@endsection
