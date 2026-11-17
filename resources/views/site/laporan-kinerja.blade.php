@extends('layouts.site')

@section('title', 'Laporan Kinerja — '.($siteSettings['site_name'] ?? 'DPM UII'))
@section('meta_description', 'Laporan kinerja Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia per periode kepengurusan.')

@push('styles')
<style>
  .lk { --lk-gap: 18px; }
  .lk :focus-visible { outline: 2px solid var(--white); outline-offset: 2px; }

  /* ---------- Hero ---------- */
  .pg-head { position: relative; overflow: hidden; border-bottom: 1px solid var(--b-default); padding: 56px 0 64px;
    background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%); }
  .pg-head::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 28px); }
  .hero-grid { position: relative; display: grid; grid-template-columns: minmax(0, 1fr); gap: 32px; }
  .crumb { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; margin-bottom: 26px; font-size: 12.5px; color: var(--t-cap); }
  .crumb a { transition: color .2s; } .crumb a:hover { color: var(--white); }
  .crumb span[aria-hidden] { opacity: .5; }
  .crumb span[aria-current] { color: var(--white); font-weight: 600; }
  .pg-head h1 { font-size: clamp(34px, 5.6vw, 60px); letter-spacing: -1.6px; line-height: 1.06; margin-bottom: 16px; }
  .pg-desc { max-width: 600px; margin-bottom: 26px; font-size: 16px; color: var(--t-sub); line-height: 1.7; }
  .meta { display: flex; flex-wrap: wrap; gap: 10px; }
  .meta span { display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; border: 1px solid var(--b-btn); border-radius: 100px;
    font-size: 12.5px; font-weight: 600; color: var(--white); background: rgba(0,22,51,.5); }
  .meta span small { font-size: 11px; font-weight: 500; letter-spacing: .8px; text-transform: uppercase; color: var(--t-cap); }

  /* ---------- Body ---------- */
  .lk-body { padding: 56px 0 88px; }
  .lk-head { display: flex; flex-wrap: wrap; align-items: end; justify-content: space-between; gap: 16px; margin-bottom: 26px; }
  .lk-head h2 { font-size: clamp(22px, 3vw, 30px); letter-spacing: -.6px; line-height: 1.2; }
  .lk-head p { margin-top: 6px; font-size: 13.5px; color: var(--t-cap); }

  .lk-period { margin-bottom: 40px; }
  .lk-period-head { display: flex; flex-wrap: wrap; align-items: center; gap: 12px; padding-bottom: 14px; margin-bottom: 16px;
    border-bottom: 1px solid var(--b-default); }
  .lk-period-head h3 { font-size: 17px; letter-spacing: -.2px; }
  .lk-period-head .count { font-size: 12.5px; color: var(--t-cap); }

  .chip { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 100px;
    border: 1px solid var(--b-btn); font-size: 11.5px; font-weight: 600; letter-spacing: .3px; color: var(--t-body); }
  .chip.is-active { border-color: rgba(35, 209, 139, .55); color: #4ade80; background: rgba(35, 209, 139, .08); }
  .chip.is-done { color: var(--t-cap); }

  .ldl { list-style: none; padding: 0; margin: 0; border: 1px solid var(--b-default); border-radius: 12px;
    background: var(--navy-card); overflow: hidden; }
  .ld { display: grid; grid-template-columns: 52px minmax(0, 1fr) auto; gap: 20px; align-items: center;
    padding: 20px 24px; border-top: 1px solid var(--b-default); transition: background .2s; }
  .ld:first-child { border-top: 0; }
  .ld:hover { background: var(--bg-hover); }
  .ld .ic { width: 52px; height: 60px; display: grid; place-items: center; border: 1px solid var(--b-btn); border-radius: 8px;
    background: var(--navy); font-size: 10.5px; font-weight: 700; letter-spacing: 1px; color: var(--t-sub); }
  .ld h4 { font-size: 16px; line-height: 1.45; margin: 0; }
  .ld .ld-meta { display: flex; flex-wrap: wrap; align-items: center; gap: 8px 14px; margin-top: 8px; font-size: 12.5px; color: var(--t-cap); }
  .ld .ld-meta .dot { width: 3px; height: 3px; border-radius: 50%; background: currentColor; opacity: .6; }
  .ld .btn { height: 38px; padding: 0 18px; font-size: 13px; gap: 8px; white-space: nowrap; }
  .ld .btn svg { width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
  .soon { font-size: 12.5px; color: var(--t-cap); }

  .lk-empty { padding: 44px 28px; text-align: center; border: 1px dashed var(--b-btn); border-radius: 12px; background: rgba(255,255,255,.02); }
  .lk-empty svg { width: 34px; height: 34px; margin: 0 auto 14px; stroke: var(--t-cap); fill: none; stroke-width: 1.6; stroke-linecap: round; stroke-linejoin: round; }
  .lk-empty strong { display: block; font-size: 15.5px; margin-bottom: 6px; }
  .lk-empty p { font-size: 13.5px; color: var(--t-cap); line-height: 1.7; max-width: 420px; margin: 0 auto; }

  @media (max-width: 1080px) {
    .pg-head { padding: 44px 0 52px; }
  }
  @media (max-width: 720px) {
    .pg-head { padding: 34px 0 40px; }
    .lk-body { padding: 40px 0 64px; }
    .ld { grid-template-columns: minmax(0, 1fr); gap: 14px; padding: 18px; }
    .ld .ic { display: none; }
    .ld .btn { width: 100%; justify-content: center; }
    .lk-period { margin-bottom: 32px; }
  }
</style>
@endpush

@section('content')
@php
    $bulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $tanggalId = fn ($date) => $date
        ? $date->day.' '.$bulan[(int) $date->month].' '.$date->year
        : null;

    // Kelompokkan per periode kepengurusan bila ada, jika tidak pakai tahun dokumen.
    $groups = $documents
        ->groupBy(fn ($d) => $d->period?->name ?? 'Tahun '.($d->year ?? '—'))
        ->sortKeysDesc();

    $totalDocs = $documents->count();
    $totalPeriods = $groups->count();
@endphp

<section class="pg-head">
  <div class="container hero-grid">
    <div>
      <nav class="crumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Beranda</a><span aria-hidden="true">/</span>
        <span aria-current="page">Laporan Kinerja</span>
      </nav>
      <span class="eyebrow">Akuntabilitas</span>
      <h1>Laporan Kinerja</h1>
      <p class="pg-desc">Dokumen pertanggungjawaban kinerja Dewan Permusyawaratan Mahasiswa UII, disusun per periode kepengurusan.</p>
      <div class="meta">
        <span><small>Dokumen</small> {{ $totalDocs }}</span>
        <span><small>Periode</small> {{ $totalPeriods ?: '—' }}</span>
      </div>
    </div>
  </div>
</section>

<section class="lk-body">
  <div class="container lk">
    @if ($groups->isEmpty())
      <div class="lk-empty">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="M9 14h6M9 17h4"/></svg>
        <strong>Belum ada laporan kinerja</strong>
        <p>Laporan kinerja akan diunggah sesuai dengan periode kepengurusan yang sedang berjalan.</p>
      </div>
    @else
      <div class="lk-head">
        <div>
          <h2>Arsip Laporan</h2>
          <p>Diurutkan dari periode terbaru. Klik unduh untuk menyimpan berkas PDF.</p>
        </div>
      </div>

      @foreach ($groups as $periodLabel => $items)
        @php
          $isActive = $items->contains(fn ($d) => $d->period?->is_active);
        @endphp
        <section class="lk-period">
          <header class="lk-period-head">
            <h3>{{ $periodLabel }}</h3>
            <span class="chip {{ $isActive ? 'is-active' : 'is-done' }}">
              {{ $isActive ? 'Periode berjalan' : 'Selesai' }}
            </span>
            <span class="count">{{ $items->count() }} dokumen</span>
          </header>

          <ul class="ldl">
            @foreach ($items->sortByDesc('published_at') as $doc)
              <li class="ld">
                <span class="ic" aria-hidden="true">{{ $doc->isPublished() ? 'PDF' : 'DOK' }}</span>
                <div>
                  <h4>{{ $doc->title ?? 'Laporan Kinerja' }}</h4>
                  <div class="ld-meta">
                    <span>{{ $doc->category?->name ?? 'Laporan Kinerja' }}</span>
                    @if ($doc->published_at)
                      <span class="dot" aria-hidden="true"></span>
                      <span>{{ $tanggalId($doc->published_at) }}</span>
                    @endif
                    @if ($doc->quarter)
                      <span class="dot" aria-hidden="true"></span>
                      <span>Triwulan {{ $doc->quarter }}</span>
                    @endif
                  </div>
                </div>
                @if ($doc->isPublished())
                  <a class="btn" href="{{ $doc->download_url }}" download>
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 16v1a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Unduh</span>
                  </a>
                @else
                  <span class="soon">Belum tersedia</span>
                @endif
              </li>
            @endforeach
          </ul>
        </section>
      @endforeach
    @endif
  </div>
</section>
@endsection
