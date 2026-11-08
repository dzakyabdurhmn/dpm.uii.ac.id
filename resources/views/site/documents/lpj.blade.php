@extends('layouts.site')

@section('title', 'Laporan Pertanggungjawaban — Keuangan · DPM UII')

@section('content')
<!-- ================= KEUANGAN LPJ ================= -->
<section class="pg-head">
  <div class="container hero-grid">
    <div>
      <nav class="crumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <span aria-hidden="true">/</span>
        <a href="{{ route('documents.dana') }}">Keuangan</a>
        <span aria-hidden="true">/</span>
        <span aria-current="page">LPJ</span>
      </nav>
      <span class="eyebrow">Keuangan · LPJ</span>
      <h1>Laporan Pertanggungjawaban</h1>
      <p class="pg-desc">Laporan pertanggungjawaban penggunaan dana kegiatan KM UII.</p>
    </div>
  </div>
</section>

<section style="padding:44px 0 88px">
  <div class="container">
    <nav class="seg" aria-label="Jenis laporan keuangan">
      <a href="{{ route('documents.lpj') }}" aria-current="page">LPJ</a>
      <a href="{{ route('documents.lha') }}">LHA</a>
    </nav>
    <p class="nb">Setiap lembaga penerima dana KM UII wajib mempertanggungjawabkan penggunaan dananya. Dokumen berikut diarsipkan per periode kepengurusan.</p>

    @foreach ($groups as $group)
      <section class="lg">
        <h2>{{ $group['label'] }}@if ($group['note'])<small>{{ $group['note'] }}</small>@endif</h2>
        <ul class="ldl">
          @forelse ($group['documents'] as $doc)
            <li class="ld">
              <span class="ic" aria-hidden="true">PDF</span>
              <div>
                <h3>{{ $doc->title }}</h3>
                <p>{{ $doc->published_at?->format('d F Y') ?? 'Tanggal tidak tersedia' }}</p>
              </div>
              @if($doc->isPublished())
                <a class="btn" href="{{ $doc->download_url }}" download>
                  <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 16v1a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                  <span>Unduh</span>
                </a>
              @else
                <span class="soon">Belum tersedia</span>
              @endif
            </li>
          @empty
            <li class="ld">
              <span class="ic" aria-hidden="true">PDF</span>
              <div>
                <h3>Belum ada {{ strtoupper($type) }} untuk periode {{ $group['label'] }}</h3>
                <p>Data akan tersedia segera.</p>
              </div>
              <span class="soon">Belum tersedia</span>
            </li>
          @endforelse
        </ul>
      </section>
    @endforeach
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
  .hero-grid {
    position: relative;
    display: grid;
    grid-template-columns: 1.2fr .8fr;
    gap: 40px;
    align-items: center;
  }
  .crumb {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 28px;
    font-size: 12.5px;
    color: var(--t-cap);
  }
  .crumb a {
    transition: color .2s;
  }
  .crumb a:hover {
    color: var(--white);
  }
  .crumb span[aria-hidden] {
    opacity: .5;
  }
  .crumb span[aria-current] {
    color: var(--white);
    font-weight: 600;
  }
  .pg-head h1 {
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
  .eyebrow {
    display: block;
    margin-bottom: 12px;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: var(--t-cap);
  }

  .seg {
    display: inline-flex;
    gap: 4px;
    margin: 0 0 32px;
    padding: 4px;
    border: 1px solid var(--b-btn);
    border-radius: 100px;
    background: var(--navy-card);
  }
  .seg a {
    padding: 9px 20px;
    border-radius: 100px;
    font-size: 13.5px;
    font-weight: 600;
    color: var(--t-sub);
    transition: background .2s, color .2s;
  }
  .seg a:hover {
    background: var(--bg-hover);
    color: var(--white);
  }
  .seg a[aria-current="page"] {
    background: var(--navy-hover);
    color: var(--white);
    box-shadow: inset 0 0 0 1px var(--b-btn-hover);
  }

  .nb {
    margin: 0 0 32px;
    padding: 16px 20px;
    border-left: 2px solid var(--b-btn-hover);
    border-radius: 0 8px 8px 0;
    background: rgba(255,255,255,.04);
    font-size: 14.5px;
    line-height: 1.75;
    color: var(--t-body);
    max-width: 760px;
  }

  .lg {
    margin-bottom: 40px;
  }
  .lg h2 {
    display: flex;
    align-items: baseline;
    gap: 14px;
    margin-bottom: 14px;
    font-size: 28px;
    letter-spacing: -.8px;
  }
  .lg h2 small {
    font-family: 'Inter', sans-serif;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 1.4px;
    text-transform: uppercase;
    color: var(--t-cap);
  }

  .ldl {
    list-style: none;
    padding: 0;
    border: 1px solid var(--b-btn);
    border-radius: 12px;
    background: var(--navy-card);
    overflow: hidden;
  }
  .ld {
    display: grid;
    grid-template-columns: 48px minmax(0,1fr) auto;
    gap: 18px;
    align-items: center;
    padding: 18px 24px;
    border-top: 1px solid var(--b-default);
    transition: background .2s;
  }
  .ld:first-child {
    border-top: 0;
  }
  .ld:hover {
    background: var(--bg-hover);
  }
  .ld .ic {
    width: 40px;
    height: 48px;
    display: grid;
    place-items: center;
    border: 1px solid var(--b-btn);
    border-radius: 6px;
    background: var(--navy);
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1px;
    color: var(--t-sub);
  }
  .ld h3 {
    font-size: 16.5px;
    line-height: 1.4;
    margin: 0;
  }
  .ld p {
    margin-top: 2px;
    font-size: 13px;
    color: var(--t-cap);
  }
  .ld .btn {
    height: 38px;
    padding: 0 16px;
    font-size: 13px;
    gap: 8px;
  }
  .ld .btn svg {
    width: 16px;
    height: 16px;
    fill: none;
    stroke: currentColor;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    transform: none !important;
  }
  .soon {
    font-size: 12.5px;
    color: var(--t-cap);
  }

  @media (max-width: 720px) {
    .hero-grid {
      grid-template-columns: 1fr;
    }
    .ld {
      grid-template-columns: minmax(0,1fr);
      gap: 12px;
      padding: 16px 18px;
    }
    .ld .ic {
      display: none;
    }
    .ld .btn {
      width: 100%;
      justify-content: center;
    }
    .pg-head {
      padding: 36px 0 44px;
    }
  }
</style>
@endsection