@extends('layouts.site')

@section('title', 'Dokumen dan Publikasi — '.($siteSettings['site_name'] ?? 'DPM UII'))
@section('meta_description', 'Arsip resmi DPM UII: surat keputusan, ketetapan, laporan kinerja, dan dokumen resmi yang dikelompokkan per periode kepengurusan.')

@push('styles')
<style>
  .pubs-page { background: var(--navy); color: var(--t-body); }

  /* ---------- Hero ---------- */
  .pubs-hero {
    position: relative; overflow: hidden;
    padding: 56px 0 64px;
    border-bottom: 1px solid var(--b-default);
    background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%);
  }
  .pubs-hero::before {
    content: ''; position: absolute; inset: 0; pointer-events: none;
    background: repeating-linear-gradient(135deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 28px);
  }
  .pubs-hero-grid { position: relative; display: grid; grid-template-columns: 1.2fr .8fr; gap: 40px; align-items: center; }
  .pubs-crumb { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 28px; font-size: 12.5px; color: var(--t-cap); }
  .pubs-crumb a { color: inherit; transition: color .2s; }
  .pubs-crumb a:hover { color: var(--white); }
  .pubs-crumb span[aria-hidden] { opacity: .5; }
  .pubs-crumb span[aria-current] { color: var(--white); font-weight: 600; }
  .pubs-hero h1 { margin: 0 0 18px; font-size: clamp(34px, 5.6vw, 62px); line-height: 1.06; letter-spacing: -1.6px; }
  .pubs-hero p { max-width: 580px; margin: 0; font-size: 16px; color: var(--t-sub); }
  .pubs-hero-art { display: flex; justify-content: flex-end; }
  .pubs-hero-art svg { width: min(100%, 460px); height: auto; }

  /* ---------- Ringkasan jenis ---------- */
  .pubs-sum { border-bottom: 1px solid var(--b-default); background: var(--navy-card); }
  .pubs-sum .container { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); }
  .pubs-sm {
    display: block; padding: 26px 24px;
    border-left: 1px solid var(--b-default);
    text-align: left; color: inherit;
    transition: background .2s;
  }
  .pubs-sm:first-child { border-left: 0; padding-left: 0; }
  .pubs-sm:hover { background: var(--bg-hover); }
  .pubs-sm[aria-current="true"] { background: var(--navy-hover); }
  .pubs-sm small { display: block; font-size: 11px; font-weight: 600; letter-spacing: 1.8px; text-transform: uppercase; color: var(--t-cap); }
  .pubs-sm b { display: block; margin-top: 6px; font-family: 'Wix Madefor Display', sans-serif; font-size: 34px; font-weight: 800; letter-spacing: -1px; line-height: 1; color: var(--white); }
  .pubs-sm span { display: block; margin-top: 6px; font-size: 12.5px; color: var(--t-cap); }

  /* ---------- Layout utama ---------- */
  .pubs-main { padding: 56px 0 88px; }
  .pubs-grid { display: grid; grid-template-columns: 280px minmax(0, 1fr); gap: 36px; align-items: start; }

  .pubs-rail { position: sticky; top: 100px; }
  .pubs-rail h2 { margin: 0 0 14px; font-family: 'Inter', sans-serif; font-size: 11.5px; font-weight: 600; letter-spacing: 1.8px; text-transform: uppercase; color: var(--t-cap); }
  .pubs-rail ol { display: grid; gap: 8px; margin: 0; padding: 0; list-style: none; }
  .pubs-rail a {
    display: block; width: 100%; padding: 14px 16px;
    border: 1px solid var(--b-default); border-radius: 8px;
    color: var(--t-cap);
    transition: background .2s, border-color .2s, color .2s;
  }
  .pubs-rail a:hover { background: var(--bg-hover); color: var(--white); }
  .pubs-rail a[aria-current="true"] { background: var(--navy-hover); border-color: var(--b-btn-hover); color: var(--white); box-shadow: var(--sh-md); }
  .pubs-rail b { display: block; font-family: 'Wix Madefor Display', sans-serif; font-size: 18px; font-weight: 700; color: inherit; }
  .pubs-rail small { display: block; margin-top: 2px; font-size: 12px; }
  .pubs-now {
    display: inline-block; margin-left: 8px; padding: 2px 8px;
    border: 1px solid var(--b-btn); border-radius: 100px;
    font-family: 'Inter', sans-serif; font-size: 10px; font-weight: 600;
    letter-spacing: 1px; text-transform: uppercase; vertical-align: middle;
  }
  .pubs-note { margin: 16px 0 0; font-size: 12px; line-height: 1.6; color: var(--t-cap); }

  .pubs-head { display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 16px; margin-bottom: 22px; }
  .pubs-head h2 { margin: 0; font-size: clamp(26px, 3.2vw, 38px); letter-spacing: -.9px; }
  .pubs-head p { margin: 6px 0 0; font-size: 14.5px; color: var(--t-cap); }

  /* ---------- Toolbar ---------- */
  .pubs-tools {
    display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px;
    margin-bottom: 26px; padding: 12px;
    border: 1px solid var(--b-btn); border-radius: 12px; background: var(--navy-card);
  }
  .pubs-cats { display: flex; flex-wrap: wrap; gap: 6px; }
  .pubs-cats a {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 8px 14px; border: 1px solid transparent; border-radius: 100px;
    color: var(--t-sub); font-size: 13.5px; font-weight: 600;
    transition: background .2s, border-color .2s, color .2s;
  }
  .pubs-cats a:hover { background: var(--bg-hover); color: var(--white); }
  .pubs-cats a[aria-current="true"] { border-color: var(--b-btn-hover); background: var(--navy-hover); color: var(--white); }
  .pubs-cats em { font-style: normal; padding: 1px 7px; border-radius: 100px; background: rgba(255,255,255,.10); font-size: 11.5px; }

  .pubs-srch { position: relative; flex: 1 1 220px; max-width: 320px; }
  .pubs-srch input {
    width: 100%; height: 40px; padding: 0 14px 0 38px;
    border: 1px solid var(--b-btn); border-radius: 8px;
    background: var(--navy); color: var(--white);
    font: inherit; font-size: 14px;
  }
  .pubs-srch input::placeholder { color: var(--t-cap); }
  .pubs-srch input:focus { outline: 2px solid var(--b-btn-hover); outline-offset: 1px; }
  .pubs-srch > svg { position: absolute; left: 12px; top: 11px; width: 18px; height: 18px; fill: none; stroke: var(--t-cap); stroke-width: 2; stroke-linecap: round; }

  /* ---------- Daftar dokumen ---------- */
  .pubs-grp { margin-bottom: 26px; }
  .pubs-grp > h3 {
    display: flex; align-items: center; gap: 12px;
    margin: 0 0 10px; font-family: 'Inter', sans-serif;
    font-size: 11.5px; font-weight: 600; letter-spacing: 1.8px;
    text-transform: uppercase; color: var(--t-cap);
  }
  .pubs-grp > h3::after { content: ''; flex: 1; height: 1px; background: var(--b-default); }

  .pubs-rows { margin: 0; padding: 0; list-style: none; overflow: hidden; border: 1px solid var(--b-btn); border-radius: 12px; background: var(--navy-card); }
  .pubs-row {
    display: grid; grid-template-columns: 54px minmax(0, 1fr) auto;
    gap: 18px; align-items: center; padding: 18px 22px;
    border-top: 1px solid var(--b-default);
    transition: background .2s;
  }
  .pubs-row:first-child { border-top: 0; }
  .pubs-row:hover { background: var(--bg-hover); }
  .pubs-row[hidden] { display: none; }
  .pubs-ext {
    display: grid; place-items: center; width: 44px; height: 54px;
    border: 1px solid var(--b-btn); border-radius: 6px;
    background: var(--navy);
    font-size: 10px; font-weight: 700; letter-spacing: 1px;
    color: var(--t-sub); text-align: center;
  }
  .pubs-ext svg { width: 22px; height: 22px; }
  .pubs-row h4 { margin: 0; font-family: 'Wix Madefor Display', sans-serif; font-size: 16.5px; font-weight: 700; line-height: 1.4; }
  .pubs-meta { display: flex; flex-wrap: wrap; gap: 6px 14px; margin-top: 5px; font-size: 12.5px; color: var(--t-cap); }
  .pubs-tag {
    padding: 1px 9px; border: 1px solid var(--b-btn); border-radius: 100px;
    font-size: 10.5px; font-weight: 600; letter-spacing: 1px;
    text-transform: uppercase; color: var(--t-sub);
  }
  .pubs-acts { display: flex; gap: 8px; }
  .pubs-acts .btn { height: 38px; padding: 0 16px; font-size: 13px; }

  .pubs-dempty {
    padding: 48px 24px; text-align: center;
    border: 1px dashed var(--b-btn); border-radius: 12px;
    color: var(--t-cap);
  }
  .pubs-dempty strong { display: block; margin-bottom: 6px; color: var(--white); font-size: 15px; }
  .pubs-dempty a { color: var(--white); border-bottom: 1px solid var(--b-btn); }

  @media (max-width: 1080px) {
    .pubs-hero-grid { grid-template-columns: 1fr; }
    .pubs-hero-art { display: none; }
    .pubs-grid { grid-template-columns: minmax(0, 1fr); }
    .pubs-rail { position: static; }
    .pubs-rail ol { grid-auto-flow: column; grid-auto-columns: minmax(170px, 1fr); overflow-x: auto; padding-bottom: 6px; }
    .pubs-sum .container { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    .pubs-sm:nth-child(3) { border-left: 0; padding-left: 0; }
    .pubs-sm:nth-child(n+3) { border-top: 1px solid var(--b-default); }
  }
  @media (max-width: 720px) {
    .pubs-hero { padding: 36px 0 44px; }
    .pubs-main { padding: 40px 0 64px; }
    .pubs-row { grid-template-columns: minmax(0, 1fr); gap: 12px; padding: 18px; }
    .pubs-ext { display: none; }
    .pubs-acts .btn { flex: 1; justify-content: center; }
    .pubs-srch { max-width: none; }
    .pubs-cats { flex-wrap: nowrap; overflow-x: auto; width: 100%; }
    .pubs-cats a { flex: none; }
  }
</style>
@endpush

@section('content')
    @php
        $documentsUrl = function (array $overrides = []) use ($filters): string {
            $query = array_merge([
                'periode' => $filters['periode'],
                'jenis' => $filters['jenis'] === 'semua' ? null : $filters['jenis'],
                'q' => $filters['q'],
            ], $overrides);

            return route('documents.index', array_filter(
                $query,
                fn ($value): bool => $value !== null && $value !== '',
            ));
        };
    @endphp

    <div class="pubs-page">
        <section class="pubs-hero">
            <div class="container pubs-hero-grid">
                <div>
                    <nav class="pubs-crumb" aria-label="Breadcrumb">
                        <a href="{{ route('home') }}">Beranda</a>
                        <span aria-hidden="true">/</span>
                        <span aria-current="page">Dokumen dan Publikasi</span>
                    </nav>
                    <span class="eyebrow">Arsip Resmi</span>
                    <h1>Dokumen dan Publikasi</h1>
                    <p>Keputusan, ketetapan, laporan kinerja, dan dokumen resmi DPM UII yang dikelompokkan per periode kepengurusan.</p>
                </div>
                <div class="pubs-hero-art" aria-hidden="true">
                    <svg viewBox="0 0 460 320" role="img" aria-label="Tumpukan dokumen">
                        <g fill="none" stroke="#fff" stroke-linejoin="round" stroke-linecap="round">
                            <rect x="150" y="40" width="190" height="240" rx="8" fill="#001A3A" stroke-opacity=".3" transform="rotate(-8 245 160)"/>
                            <rect x="150" y="40" width="190" height="240" rx="8" fill="#001A3A" stroke-opacity=".5" transform="rotate(5 245 160)"/>
                            <rect x="150" y="40" width="190" height="240" rx="8" fill="#002451" stroke-opacity=".9" stroke-width="1.6"/>
                            <path d="M180 84h80M180 112h130M180 134h130M180 156h130M180 178h90" stroke-opacity=".55"/>
                            <rect x="180" y="214" width="56" height="32" rx="6" stroke-opacity=".8"/>
                            <path d="M250 230h60" stroke-opacity=".4"/>
                        </g>
                    </svg>
                </div>
            </div>
        </section>

        <section class="pubs-sum" aria-label="Ringkasan dokumen">
            <div class="container">
                @foreach ($types as $key => $label)
                    <a class="pubs-sm" href="{{ $documentsUrl(['jenis' => $key]) }}" @if ($filters['jenis'] === $key) aria-current="true" @endif>
                        <small>{{ $label }}</small>
                        <b>{{ $typeCounts[$key] }}</b>
                        <span>di semua periode</span>
                    </a>
                @endforeach
            </div>
        </section>

        <section class="pubs-main">
            <div class="container pubs-grid">
                <aside class="pubs-rail" aria-label="Filter periode">
                    <h2>Periode kepengurusan</h2>
                    <ol>
                        <li>
                            <a href="{{ $documentsUrl(['periode' => 'all']) }}" @if ($selectedPeriod === null) aria-current="true" @endif>
                                <b>Semua periode</b>
                                <small>{{ $periodDocCounts->sum() }} dokumen</small>
                            </a>
                        </li>
                        @foreach ($periods as $period)
                            <li>
                                <a href="{{ $documentsUrl(['periode' => $period->id]) }}" @if ($selectedPeriod?->id === $period->id) aria-current="true" @endif>
                                    <b>
                                        {{ $period->name }}
                                        @if ($period->is_active)
                                            <span class="pubs-now">Berjalan</span>
                                        @endif
                                    </b>
                                    <small>{{ $periodDocCounts[$period->id] ?? 0 }} dokumen</small>
                                </a>
                            </li>
                        @endforeach
                    </ol>
                    <p class="pubs-note">Arsip ini diperbarui dari panel admin DPM UII. Gunakan periode dan jenis dokumen untuk mempersempit hasil.</p>
                </aside>

                <div>
                    <div class="pubs-head">
                        <div>
                            <h2>{{ $selectedPeriod ? 'Periode '.$selectedPeriod->name : 'Semua periode' }}</h2>
                            <p>
                                @if ($filters['q'])
                                    {{ $totalCount }} dokumen cocok dengan “{{ $filters['q'] }}”
                                @else
                                    {{ $totalCount }} dokumen {{ $selectedPeriod ? 'dalam periode ini' : 'di seluruh arsip' }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="pubs-tools">
                        <div class="pubs-cats" role="group" aria-label="Jenis dokumen">
                            <a href="{{ $documentsUrl(['jenis' => null]) }}" @if ($filters['jenis'] === 'semua') aria-current="true" @endif>
                                Semua <em>{{ $periodTypeCounts->sum() }}</em>
                            </a>
                            @foreach ($types as $key => $label)
                                <a href="{{ $documentsUrl(['jenis' => $key]) }}" @if ($filters['jenis'] === $key) aria-current="true" @endif>
                                    {{ $label }} <em>{{ $periodTypeCounts[$key] }}</em>
                                </a>
                            @endforeach
                        </div>

                        <form class="pubs-srch" method="GET" action="{{ route('documents.index') }}" role="search" aria-label="Cari dokumen">
                            <input type="hidden" name="periode" value="{{ $filters['periode'] }}">
                            @if ($filters['jenis'] !== 'semua')
                                <input type="hidden" name="jenis" value="{{ $filters['jenis'] }}">
                            @endif
                            <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4"/></svg>
                            <input type="search" name="q" value="{{ $filters['q'] }}" placeholder="Cari judul atau deskripsi" aria-label="Cari dokumen">
                        </form>
                    </div>

                    @if ($groups->isEmpty())
                        <div class="pubs-dempty">
                            <strong>Tidak ada dokumen yang cocok.</strong>
                            <p>Coba ubah periode, jenis dokumen, atau kata kunci pencarian.</p>
                            <p><a href="{{ route('documents.index') }}">Tampilkan semua dokumen</a></p>
                        </div>
                    @else
                        @foreach ($groups as $group)
                            <section class="pubs-grp" data-group>
                                <h3>{{ $group['label'] }}</h3>
                                <ul class="pubs-rows">
                                    @foreach ($group['documents'] as $document)
                                        <li class="pubs-row" data-search="{{ mb_strtolower($document->title.' '.($document->category?->name ?? '').' '.($document->category?->parent?->name ?? '').' '.$document->year) }}">
                                            <span class="pubs-ext" aria-hidden="true">{!! $document->extension !!}</span>
                                            <div>
                                                <h4>{{ $document->title }}</h4>
                                                <div class="pubs-meta">
                                                    @if ($document->category)
                                                        <span class="pubs-tag">{{ $document->category->name }}</span>
                                                    @endif
                                                    @if ($document->category?->parent)
                                                        <span>{{ $document->category->parent->name }}</span>
                                                    @endif
                                                    @if ($document->published_at)
                                                        <span>{{ $document->published_at->translatedFormat('j F Y') }}</span>
                                                    @endif
                                                    @if ($document->year)
                                                        <span>Tahun {{ $document->year }}</span>
                                                    @endif
                                                    @if ($document->quarter_label)
                                                        <span>{{ $document->quarter_label }}</span>
                                                    @endif
                                                    @if ($document->size > 0)
                                                        <span>{{ $document->human_size }}</span>
                                                    @endif
                                                    <span>{{ $document->downloads }} unduhan</span>
                                                </div>
                                            </div>
                                            <div class="pubs-acts">
                                                <a class="btn" href="{{ route('documents.download', $document) }}" @if ($document->isExternal()) target="_blank" rel="noopener" @endif>
                                                    {{ $document->isExternal() ? 'Buka tautan' : 'Unduh' }}
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </section>
                        @endforeach

                        <div class="pubs-dempty" data-empty hidden>
                            <strong>Tidak ada dokumen yang cocok.</strong>
                            <p>Hapus kata kunci atau tekan Enter untuk mencari di seluruh arsip.</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>

    @if ($groups->isNotEmpty())
        <script>
            (() => {
                const form = document.querySelector('.pubs-srch');
                const input = form?.querySelector('input[name="q"]');
                const groups = [...document.querySelectorAll('[data-group]')];
                const empty = document.querySelector('[data-empty]');

                if (!input || !groups.length) {
                    return;
                }

                let timer;

                const filter = () => {
                    const query = input.value.trim().toLowerCase();
                    let visible = 0;

                    groups.forEach((group) => {
                        let matches = 0;

                        group.querySelectorAll('.pubs-row').forEach((row) => {
                            const isMatch = !query || (row.dataset.search || '').includes(query);
                            row.hidden = !isMatch;
                            matches += isMatch ? 1 : 0;
                        });

                        group.hidden = matches === 0;
                        visible += matches;
                    });

                    if (empty) {
                        empty.hidden = visible > 0;
                    }
                };

                input.addEventListener('input', () => {
                    clearTimeout(timer);
                    timer = setTimeout(filter, 150);
                });
            })();
        </script>
    @endif
@endsection
