@extends('layouts.site')

@section('title', ($heading ?? 'Dokumen & laporan').' — '.($siteSettings['site_name'] ?? 'DPM UII'))

@section('content')
<!-- ============ KEUANGAN / LAUNCH ============ -->
<section class="keuangan-hero">
  <div class="container">
    <div class="keuangan-hero-inner">
      <p class="eyebrow">Arsip Resmi</p>
      <h1 class="keuangan-h1">{{ $heading ?? 'Dana & Laporan' }}</h1>
      <p class="keuangan-desc">{{ $description ?? 'Distribusi dana, laporan pertanggungjawaban (LPJ), dan laporan hasil audit (LHA) KM UII.' }}</p>
    </div>
  </div>
</section>

<!-- ============ STATS QUICK ACCESS ============ -->
<section class="quick-access">
  <div class="container">
    <div class="quick">
      <span class="t">Distribusi Dana</span>
      <small>Alokasi dana lembaga KM UII</small>
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
    </div>
    <div class="quick">
      <span class="t">LPJ</span>
      <small>Laporan pertanggungjawaban</small>
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
    </div>
    <div class="quick">
      <span class="t">LHA</span>
      <small>Laporan hasil audit</small>
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
    </div>
  </div>
</section>

<!-- ============ FILTER TOOLBAR ============ -->
<section class="docs-section" style="background: #001E43;">
  <div class="container">
    <div class="docs-wrap">
      <div x-data="documentSearch('{{ url()->current() }}', {{ json_encode($filters) }})" class="docs-search-wrapper">
        <div class="docs-toolbar" role="search" aria-label="Filter dan cari dokumen">
          <div class="docs-search">
            <label for="doc-search" class="sr-only">Cari dokumen</label>
            <input type="search"
                   id="doc-search"
                   name="q"
                   :value="query"
                   @input="debounceSearch($event.target.value)"
                   placeholder="{{ $heading ? 'Cari ' . strtolower($heading) . '…' : 'Cari judul dokumen…' }}"
                   class="docs-search-input"
                   autocomplete="off"
                   aria-describedby="search-hint">
            <button type="button"
                    @click="performSearch()"
                    class="docs-search-btn"
                    aria-label="Cari">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/></svg>
              <span class="btn-text">Cari</span>
            </button>
          </div>

          <div class="docs-filter" x-data="{ initFilters: @json($filters), periods: @json($periods ?? []), years: @json($years ?? []) }" x-init="
                            const urlParams = new URLSearchParams(window.location.search);
                            this.filters.periode = urlParams.get('periode') || '';
                            this.filters.tahun = urlParams.get('tahun') || '';
                            this.filters.triwulan = urlParams.get('triwulan') || '';
                        ">
                            @if ($periods && $periods->count() > 0)
                                <select name="periode" @change="applyFilters()" x-model="filters.periode" aria-label="Filter periode">
                                    <option value="">Semua Periode</option>
                                    @foreach ($periods as $period)
                                        <option value="{{ $period->id }}" {{ $filters['periode'] == $period->id ? 'selected' : '' }}>{{ $period->name }}</option>
                                    @endforeach
                                </select>
                            @endif

                            @if ($years && $years->count() > 0)
                                <select name="tahun" @change="applyFilters()" x-model="filters.tahun" aria-label="Filter tahun">
                                    <option value="">Semua Tahun</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}" {{ $filters['tahun'] == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endforeach
                                </select>
                            @endif

                            <select name="triwulan" @change="applyFilters()" x-model="filters.triwulan" aria-label="Filter triwulan">
                                <option value="">Semua Triwulan</option>
                                <option value="1" {{ $filters['triwulan'] == '1' ? 'selected' : '' }}>Triwulan I</option>
                                <option value="2" {{ $filters['triwulan'] == '2' ? 'selected' : '' }}>Triwulan II</option>
                                <option value="3" {{ $filters['triwulan'] == '3' ? 'selected' : '' }}>Triwulan III</option>
                                <option value="4" {{ $filters['triwulan'] == '4' ? 'selected' : '' }}>Triwulan IV</option>
                            </select>
                        </div>
          </div>

          <div x-show="isSearching" class="sr-only" aria-live="polite" id="search-hint">Sedang mencari…</div>

          <div class="docs-list" x-ref="listContainer">
            @if ($documents->isEmpty())
              <div class="docs-empty">Belum ada dokumen.</div>
            @else
              @foreach ($documents as $document)
                <article class="docs-list-item">
                  <div class="docs-list-ext">{!! $document->extension !!}</div>
                  <div class="docs-list-info">
                    <div class="docs-list-title">{{ $document->title }}</div>
                    <div class="docs-list-meta">
                      @if ($document->category)<span>{{ $document->category->name }}</span>@endif
                      @if ($document->year)<span>{{ $document->year }}</span>@endif
                      @if ($document->quarter_label)<span>{{ $document->quarter_label }}</span>@endif
                      @if ($document->size > 0)<span>{{ $document->human_size }}</span>@endif
                    </div>
                    @if ($document->description)
                      <p class="docs-list-desc">{{ $document->description }}</p>
                    @endif
                  </div>
                  <div class="docs-list-actions">
                    <span class="docs-list-count">{{ $document->downloads }} unduhan</span>
                    <a href="{{ route('documents.download', $document) }}" class="docs-list-btn">{{ $document->isExternal() ? 'Buka tautan' : 'Unduh' }}</a>
                  </div>
                </article>
              @endforeach
            @endif
          </div>

          <div class="docs-pagination" x-ref="paginationContainer">
            {{ $documents->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ DOCUMENT LIST STYLES ============ -->
<style>
  :root {
    --navy:        #001E43;
    --navy-footer: #001633;
    --navy-card:   #001A3A;
    --navy-hover:  #002451;
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
  }

  .keuangan-hero {
    position: relative;
    background: var(--navy-footer);
    padding: 64px 0 48px;
  }
  .keuangan-hero-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
  }
  .keuangan-h1 {
    font-size: clamp(30px, 4.6vw, 44px);
    font-weight: 800;
    letter-spacing: -.03em;
    color: #fff;
    margin: 0;
  }
  .keuangan-desc {
    color: rgba(255,255,255,.82);
    font-size: 15px;
    line-height: 1.85;
    max-width: 720px;
    margin: 14px 0 0;
  }

  .quick-access {
    background: var(--navy-card);
    border-bottom: 1px solid var(--b-default);
    padding: 32px 0;
  }
  .quick-access .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
  }
  .quick {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
    padding: 22px 24px;
    background: rgba(255,255,255,0.03);
    border-radius: 8px;
    transition: background .2s;
  }
  .quick:hover { background: rgba(255,255,255,0.05); }
  .quick .t {
    font-family: 'Wix Madefor Display', sans-serif;
    font-size: 16px;
    font-weight: 600;
    color: #fff;
  }
  .quick small {
    display: block;
    margin-top: 2px;
    font-family: 'Inter', sans-serif;
    font-size: 12.5px;
    font-weight: 500;
    color: var(--t-cap);
  }
  .quick svg {
    width: 18px;
    height: 18px;
    flex-shrink: 0;
    stroke: #fff;
    fill: none;
    stroke-width: 2;
    stroke-linecap: round;
    stroke-linejoin: round;
    opacity: .7;
    transition: transform .2s, opacity .2s;
  }
  .quick:hover svg { transform: translateX(4px); opacity: 1; }

  /* Document list items */
  .docs-list-item {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 16px;
    padding: 16px 22px;
    background: #001A3A;
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,.1);
    transition: background .15s;
  }
  .docs-list-item:hover { background: rgba(255,255,255,.03); }
  .docs-list-item + .docs-list-item { border-top: 1px solid rgba(255,255,255,.1); }
  .docs-list-ext {
    display: grid;
    place-items: center;
    width: 48px;
    height: 48px;
    border-radius: 6px;
    background: rgba(255,255,255,.06);
    color: rgba(255,255,255,.8);
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .12em;
  }
  .docs-list-ext svg { width: 24px; height: 24px; }
  .docs-list-info { flex: 1; min-width: 0; }
  .docs-list-title { color: #fff; font-size: 14px; font-weight: 800; }
  .docs-list-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 8px 14px;
    margin-top: 6px;
    color: rgba(255,255,255,.62);
    font-size: 11px;
  }
  .docs-list-meta span + span::before { content: '·'; margin-right: 14px; color: rgba(255,255,255,.38); }
  .docs-list-desc { margin-top: 6px; color: rgba(255,255,255,.72); font-size: 12px; line-height: 1.7; }
  .docs-list-actions {
    display: flex;
    align-items: center;
    gap: 14px;
  }
  .docs-list-count { color: rgba(255,255,255,.56); font-size: 11px; }
  .docs-list-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    height: 38px;
    padding: 0 16px;
    border-radius: 6px;
    border: 1px solid rgba(255,255,255,.3);
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    transition: all .15s;
  }
  .docs-list-btn:hover { background: rgba(255,255,255,.1); border-color: rgba(255,255,255,.5); }

  .docs-empty { padding: 28px; text-align: center; color: rgba(255,255,255,.72); font-size: 13px; }
  .docs-pagination { margin-top: 32px; display: flex; justify-content: center; }
  .docs-pagination nav { display: flex; gap: 8px; }
  .docs-pagination .page-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 38px;
    height: 38px;
    padding: 0 12px;
    border-radius: 6px;
    border: 1px solid rgba(255,255,255,.18);
    color: rgba(255,255,255,.8);
    font-size: 12px;
  }
  .docs-pagination .page-item.active .page-link { border-color: rgba(255,255,255,.52); color: #fff; }

  @media (max-width: 640px) {
    .keuangan-hero { padding: 48px 0 40px; }
    .quick-access { padding: 24px 0; }
    .quick { padding: 18px 14px; gap: 10px; }
    .quick .t { font-size: 14px; }
    .quick small { display: none; }
    .docs-list-item { padding: 16px; }
    .docs-pagination { margin-top: 24px; }
  }
</style>
@endsection