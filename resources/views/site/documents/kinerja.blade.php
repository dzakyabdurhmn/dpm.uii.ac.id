@extends('layouts.site')

@php
    $pageTitle = 'Laporan Kinerja';
    $pageDesc = 'Laporan kinerja DPM UII per periode kepengurusan, termasuk Foraslak, Laporan Akhir, dan dokumen evaluasi kinerja.';
@endphp

@section('title', $pageTitle.' — '.($siteSettings['site_name'] ?? 'DPM UII'))
@section('meta_description', Str::limit($pageDesc, 150))

@push('styles')
<style>
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
    --gold:        #F2B31A;
    --gold-hover:  #FFC13A;
    --container: 1200px;
  }

  .kinerja-page { background: var(--navy); color: var(--t-body); min-height: 80vh; }
  .kinerja-wrap { width: min(1180px, calc(100% - 40px)); margin: 0 auto; }

  /* Hero */
  .kinerja-hero {
    position: relative;
    padding: 56px 0 52px;
    background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%);
    border-bottom: 1px solid var(--b-default);
    overflow: hidden;
  }
  .kinerja-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: repeating-linear-gradient(135deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 28px);
    pointer-events: none;
  }
  .kinerja-hero-inner {
    position: relative;
    display: grid;
    grid-template-columns: 1.4fr .6fr;
    gap: 48px;
    align-items: end;
  }
  .crumb {
    display: flex; flex-wrap: wrap; gap: 10px;
    margin-bottom: 22px; font-size: 12.5px; color: var(--t-cap);
  }
  .crumb a { color: inherit; transition: color .2s; }
  .crumb a:hover { color: var(--white); }
  .crumb span[aria-hidden] { opacity: .5; }
  .crumb span[aria-current] { color: var(--white); font-weight: 600; }

  .kinerja-badge {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 4px 14px; border-radius: 100px;
    background: rgba(242,179,26,0.15);
    border: 1px solid rgba(242,179,26,0.4);
    color: var(--gold); font-size: 11px; font-weight: 700;
    letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 14px;
  }
  .kinerja-badge svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; }

  .kinerja-hero h1 {
    font-family: 'Wix Madefor Display', sans-serif;
    font-size: clamp(30px, 4.6vw, 48px); font-weight: 800;
    letter-spacing: -1px; line-height: 1.15; margin-bottom: 12px; color: var(--white);
  }
  .kinerja-hero-desc {
    max-width: 660px; font-size: 14.5px; color: var(--t-sub); line-height: 1.8;
  }

  /* Stats Box */
  .kinerja-stats {
    border: 1px solid var(--b-btn); border-radius: 8px;
    background: rgba(0,22,51,.55); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px);
  }
  .kinerja-stat {
    display: flex; align-items: baseline; justify-content: space-between; gap: 16px; padding: 13px 18px;
  }
  .kinerja-stat + .kinerja-stat { border-top: 1px solid var(--b-default); }
  .kinerja-stat span { font-size: 11.5px; font-weight: 600; letter-spacing: 1.2px; text-transform: uppercase; color: var(--t-cap); }
  .kinerja-stat strong { font-family: 'Wix Madefor Display', sans-serif; font-size: 22px; font-weight: 800; color: var(--white); letter-spacing: -.5px; }

  /* Period Pills Toolbar */
  .kinerja-bar {
    position: sticky; top: 72px; z-index: 40;
    background: rgba(0,30,67,0.95); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--b-default); padding: 12px 0;
  }
  .kinerja-bar-inner { display: flex; flex-wrap: wrap; align-items: center; gap: 12px; }
  .period-pills { display: flex; flex-wrap: wrap; gap: 8px; }
  .period-pill {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 7px 14px; border-radius: 6px;
    border: 1px solid var(--b-default); background: rgba(255,255,255,0.03);
    color: var(--t-sub); font-size: 12.5px; font-weight: 600; cursor: pointer; transition: all .2s; white-space: nowrap;
  }
  .period-pill:hover { color: var(--white); border-color: var(--b-btn); background: var(--bg-hover); }
  .period-pill.active { color: var(--white); background: var(--navy-hover); border-color: rgba(255,255,255,0.45); }
  .period-pill-count { padding: 1px 6px; border-radius: 100px; font-size: 10px; background: rgba(255,255,255,0.08); color: var(--t-sub); }
  .period-pill.active .period-pill-count { background: rgba(255,255,255,0.2); color: var(--white); }

  .kinerja-search { position: relative; flex: 1 1 280px; max-width: 420px; }
  .kinerja-search svg { position: absolute; left: 14px; top: 50%; width: 16px; height: 16px; margin-top: -8px; stroke: var(--t-cap); fill: none; stroke-width: 2; }
  .kinerja-search input {
    width: 100%; height: 44px; padding: 0 16px 0 40px;
    background: rgba(255,255,255,0.03); border: 1px solid var(--b-default); border-radius: 6px;
    color: var(--white); font-size: 14px; transition: border-color .2s, background .2s;
  }
  .kinerja-search input:focus { outline: none; border-color: var(--b-btn-hover); background: rgba(255,255,255,0.05); }
  .kinerja-search input::placeholder { color: rgba(255,255,255,0.38); }

  /* Document List */
  .kinerja-list-wrap { padding: 44px 0 80px; }
  .period-section { margin-bottom: 48px; }
  .period-section-title {
    display: flex; align-items: center; gap: 14px; margin-bottom: 16px;
    font-size: 13px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: var(--t-cap);
  }
  .period-section-title span.count-badge {
    padding: 2px 8px; border-radius: 100px; font-size: 11px;
    background: rgba(242,179,26,0.2); color: var(--gold);
  }
  .period-section-title::after { content: ''; flex: 1; height: 1px; background: var(--b-default); }

  .docs-grid { display: grid; gap: 14px; }
  .doc-card {
    display: flex; align-items: stretch; justify-content: space-between; gap: 20px;
    padding: 20px 24px; background: var(--navy-card); border: 1px solid var(--b-default); border-radius: 8px; transition: all .2s ease;
  }
  .doc-card:hover { background: var(--navy-hover); border-color: var(--b-btn); box-shadow: var(--sh-sm); }
  .doc-main { display: flex; align-items: flex-start; gap: 18px; flex: 1; min-width: 0; }
  .doc-badge-box {
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    width: 56px; height: 56px; flex-shrink: 0; border-radius: 6px;
    background: rgba(242,179,26,0.1); border: 1px solid rgba(242,179,26,0.3); color: var(--gold); text-align: center;
  }
  .doc-badge-box .b-type { font-size: 9.5px; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; color: var(--gold-hover); }
  .doc-badge-box .b-no { font-family: 'Wix Madefor Display', sans-serif; font-size: 19px; font-weight: 800; line-height: 1; }

  .doc-info { flex: 1; min-width: 0; }
  .doc-title { font-size: 15px; font-weight: 700; line-height: 1.45; color: var(--white); margin-bottom: 6px; }
  .doc-desc { font-size: 13px; color: var(--t-sub); line-height: 1.6; margin-bottom: 8px; }
  .doc-meta { display: flex; align-items: center; gap: 8px; font-size: 11.5px; color: var(--t-cap); flex-wrap: wrap; }
  .doc-meta span + span::before { content: '·'; margin-right: 8px; opacity: .5; }

  .doc-actions { display: flex; align-items: center; gap: 8px; flex-shrink: 0; align-self: center; }
  .btn-download {
    display: inline-flex; align-items: center; gap: 8px; height: 38px; padding: 0 18px;
    border-radius: 6px; background: transparent; border: 1px solid var(--gold); color: var(--gold); font-size: 12.5px; font-weight: 700; text-decoration: none; transition: all .2s;
  }
  .btn-download:hover { border-color: var(--gold-hover); background: rgba(242,179,26,0.1); color: var(--gold-hover); }
  .btn-download svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; }

  .btn-external {
    display: inline-flex; align-items: center; gap: 8px; height: 38px; padding: 0 18px;
    border-radius: 6px; background: transparent; border: 1px solid var(--b-btn); color: var(--white); font-size: 12.5px; font-weight: 700; text-decoration: none; transition: all .2s;
  }
  .btn-external:hover { border-color: var(--b-btn-hover); background: var(--bg-hover); }
  .btn-external svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; }

  .empty-state { text-align: center; padding: 56px 24px; border: 1px dashed var(--gold); border-radius: 8px; color: var(--t-cap); font-size: 14px; }
  .empty-state strong { display: block; font-family: 'Wix Madefor Display', sans-serif; font-size: 16px; color: var(--gold); margin-bottom: 6px; }

  /* Related Links */
  .kinerja-related {
    margin-top: 48px; padding: 32px; background: var(--navy-card); border: 1px solid var(--b-default); border-radius: 12px;
  }
  .kinerja-related h2 { font-family: 'Wix Madefor Display', sans-serif; font-size: 20px; font-weight: 700; margin-bottom: 4px; }
  .kinerja-related p { max-width: 520px; font-size: 14px; color: var(--t-sub); margin-bottom: 20px; }
  .kinerja-related-links { display: flex; flex-wrap: wrap; gap: 12px; }
  .kinerja-related-links a { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 6px; border: 1px solid var(--b-default); background: rgba(255,255,255,0.03); color: var(--t-sub); font-size: 13px; font-weight: 600; transition: all .2s; }
  .kinerja-related-links a:hover { color: var(--white); border-color: var(--b-btn); background: var(--bg-hover); }

  /* Responsive */
  @media (max-width: 980px) {
    .kinerja-hero-inner { grid-template-columns: 1fr; gap: 32px; }
    .doc-card { flex-direction: column; align-items: stretch; }
    .doc-actions { justify-content: flex-end; padding-top: 14px; border-top: 1px solid var(--b-default); }
    .kinerja-bar-inner { flex-direction: column; align-items: stretch; }
    .kinerja-search { max-width: none; }
    .period-pills { justify-content: flex-start; }
  }
  @media (max-width: 640px) {
    .kinerja-hero { padding: 38px 0 34px; }
    .doc-main { flex-direction: column; }
    .doc-badge-box { width: 100%; height: 38px; flex-direction: row; gap: 8px; }
  }
</style>
@endpush

@section('content')
<div class="kinerja-page">
  <section class="kinerja-hero">
    <div class="kinerja-wrap kinerja-hero-inner">
      <div>
        <nav class="crumb" aria-label="Breadcrumb">
          <a href="{{ route('home') }}">Beranda</a><span aria-hidden="true">/</span>
          <span aria-current="page">{{ $pageTitle }}</span>
        </nav>
        <span class="kinerja-badge">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
          Arsip Kinerja
        </span>
        <h1>{{ $pageTitle }}</h1>
        <p class="kinerja-hero-desc">{{ $pageDesc }}</p>
        <div class="kinerja-stats" aria-label="Ringkasan laporan kinerja">
          <div class="kinerja-stat"><span>Total Laporan</span><strong id="stTotal">{{ $totalCount }}</strong></div>
          <div class="kinerja-stat"><span>Periode Terarsip</span><strong id="stPeriods">{{ $periods->count() }}</strong></div>
          <div class="kinerja-stat"><span>Periode Aktif</span><strong id="stActive">{{ $activePeriod->name ?? '–' }}</strong></div>
        </div>
      </div>
      <div class="kinerja-hero-visual" aria-hidden="true">
        <div style="aspect-ratio: 4/3; border-radius: 12px; background: linear-gradient(135deg, #002A5A 0%, #001E43 100%); border: 1px solid var(--b-default); display: grid; place-items: center; overflow: hidden; position: relative;">
          <svg viewBox="0 0 200 150" style="width: 60%; height: 60%; opacity: 0.15;" fill="none" stroke="var(--gold)" stroke-width="1.5">
            <rect x="10" y="10" width="180" height="130" rx="8" stroke="var(--gold)" fill="none"/>
            <line x1="30" y1="100" x2="170" y2="100" stroke="var(--gold)"/>
            <line x1="30" y1="100" x2="30" y2="40" stroke="var(--gold)"/>
            <polyline points="50,90 70,70 90,80 110,60 130,50 150,40" fill="none" stroke="var(--gold)" stroke-width="2"/>
            <circle cx="50" cy="90" r="4" fill="var(--gold)"/>
            <circle cx="70" cy="70" r="4" fill="var(--gold)"/>
            <circle cx="90" cy="80" r="4" fill="var(--gold)"/>
            <circle cx="110" cy="60" r="4" fill="var(--gold)"/>
            <circle cx="130" cy="50" r="4" fill="var(--gold)"/>
            <circle cx="150" cy="40" r="4" fill="var(--gold)"/>
          </svg>
          <div style="position: absolute; bottom: 20px; left: 20px; right: 20px; text-align: center; font-size: 12px; color: var(--t-cap);">Visualisasi Tren Kinerja</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Period Filter Bar -->
  <div class="kinerja-bar" id="kinerjaBar">
    <div class="container kinerja-bar-inner">
      <div class="period-pills" id="periodPills" role="group" aria-label="Filter periode">
        @foreach ($periods as $period)
          <button type="button" class="period-pill {{ $period->id === $selectedPeriod?->id ? 'active' : '' }}"
                  data-period="{{ $period->id }}"
                  aria-pressed="{{ $period->id === $selectedPeriod?->id ? 'true' : 'false' }}"
                  @class(['active' => $period->id === $selectedPeriod?->id])>
            {{ $period->name }}
            <span class="period-pill-count">{{ $periodCounts[$period->id] ?? 0 }}</span>
          </button>
        @endforeach
      </div>
      <div class="kinerja-search" role="search" aria-label="Cari laporan kinerja">
        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
        <input type="search" id="kinerjaSearch" placeholder="Cari judul laporan…" autocomplete="off" value="{{ $filters['q'] ?? '' }}">
      </div>
    </div>
  </div>

  <!-- Document List -->
  <section class="kinerja-list-wrap">
    <div class="kinerja-wrap">
      @if ($documents->isEmpty())
        <div class="empty-state">
          <strong>Belum ada laporan kinerja</strong>
          <p>{{ $selectedPeriod ? 'Tidak ada laporan untuk periode ' . $selectedPeriod->name : 'Belum ada laporan kinerja yang dipublikasikan.' }}</p>
        </div>
      @else
        @php
          $groupedByPeriod = $documents->groupBy('period_id');
        @endphp
        @foreach ($groupedByPeriod as $periodId => $periodDocs)
          @php
            $period = $periods->firstWhere('id', $periodId);
          @endphp
          <div class="period-section" id="period-{{ $periodId }}" data-period="{{ $periodId }}">
            <div class="period-section-title">
              Periode {{ $period->name ?? 'Tanpa Periode' }}
              <span class="count-badge">{{ $periodDocs->count() }} dokumen</span>
            </div>
            <div class="docs-grid">
              @foreach ($periodDocs as $document)
                <article class="doc-card">
                  <div class="doc-main">
                    <div class="doc-badge-box">
                      <span class="b-type">{{ $document->category?->name ?? 'Laporan' }}</span>
                      <span class="b-no">#{{ $document->id }}</span>
                    </div>
                    <div class="doc-info">
                      <h3 class="doc-title">{{ $document->title }}</h3>
                      @if ($document->description)
                        <p class="doc-desc">{{ $document->description }}</p>
                      @endif
                      <div class="doc-meta">
                        @if ($document->year)<span>{{ $document->year }}</span>@endif
                        @if ($document->quarter_label)<span>{{ $document->quarter_label }}</span>@endif
                        @if ($document->size > 0)<span>{{ $document->human_size }}</span>@endif
                        <span>{{ $document->downloads }} unduhan</span>
                        <span>{{ $document->published_at?->translatedFormat('d M Y') }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="doc-actions">
                    @if ($document->isExternal())
                      <a href="{{ route('documents.download', $document) }}" class="btn-external" target="_blank" rel="noopener">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h5"/></svg>
                        Buka Tautan
                      </a>
                    @else
                      <a href="{{ route('documents.download', $document) }}" class="btn-download">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 4v11M7 11l5 5 5-5M5 20h14"/></svg>
                        Unduh
                      </a>
                    @endif
                  </div>
                </article>
              @endforeach
            </div>
          </div>
        @endforeach

        {{ $documents->links() }}
      @endif
    </div>
  </section>

  <!-- Related Links -->
  <div class="kinerja-wrap">
    <div class="kinerja-related">
      <h2>Produk Hukum Terkait</h2>
      <p>Laporan kinerja didasarkan pada peraturan yang berlaku. Telusuri produk hukum yang menjadi dasar pelaksanaan tugas DPM UII.</p>
      <div class="kinerja-related-links">
        <a href="{{ route('legal-products.type', 'pkm') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>PKM UII</a>
        <a href="{{ route('legal-products.type', 'pdpm') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>PDPM UII</a>
        <a href="{{ route('documents.dana') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>Keuangan</a>
        <a href="{{ route('documents.index') }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg>Semua Dokumen</a>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  // Period pill filtering
  const periodPills = document.querySelectorAll('.period-pill');
  const periodSections = document.querySelectorAll('.period-section');
  const kinerjaSearch = document.getElementById('kinerjaSearch');
  const baseUrl = '{{ url()->current() }}';

  // Handle period pill clicks
  periodPills.forEach(pill => {
    pill.addEventListener('click', () => {
      const periodId = pill.dataset.period;
      const url = new URL(baseUrl);
      if (periodId) {
        url.searchParams.set('periode', periodId);
      } else {
        url.searchParams.delete('periode');
      }
      // Clear search when changing period
      url.searchParams.delete('q');
      window.location.href = url.toString();
    });
  });

  // Search with debounce
  let searchDebounce;
  kinerjaSearch?.addEventListener('input', (e) => {
    clearTimeout(searchDebounce);
    searchDebounce = setTimeout(() => {
      const url = new URL(baseUrl);
      const query = e.target.value.trim();
      if (query) {
        url.searchParams.set('q', query);
      } else {
        url.searchParams.delete('q');
      }
      window.location.href = url.toString();
    }, 300);
  });

  // Highlight active period pill based on URL
  const urlParams = new URLSearchParams(window.location.search);
  const currentPeriod = urlParams.get('periode');
  if (currentPeriod) {
    periodPills.forEach(pill => {
      if (pill.dataset.period === currentPeriod) {
        pill.classList.add('active');
        pill.setAttribute('aria-pressed', 'true');
      } else {
        pill.classList.remove('active');
        pill.setAttribute('aria-pressed', 'false');
      }
    });
  }
</script>
@endpush