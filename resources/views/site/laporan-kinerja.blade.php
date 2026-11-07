@extends('layouts.site')

@section('title', 'Laporan Kinerja — '.($siteSettings['site_name'] ?? 'DPM UII'))

@push('styles')
<style>
    .ldl { list-style: none; padding: 0; border: 1px solid var(--b-btn); border-radius: 12px; background: var(--navy-card); overflow: hidden; }
    .ld { display: grid; grid-template-columns: 48px minmax(0,1fr) auto; gap: 18px; align-items: center; padding: 18px 24px; border-top: 1px solid var(--b-default); transition: background .2s; }
    .ld:first-child { border-top: 0; } .ld:hover { background: var(--bg-hover); }
    .ld .ic { width: 40px; height: 48px; display: grid; place-items: center; border: 1px solid var(--b-btn); border-radius: 6px; background: var(--navy); font-size: 10px; font-weight: 700; letter-spacing: 1px; color: var(--t-sub); }
    .ld h3 { font-size: 16.5px; line-height: 1.4; margin: 0; } .ld p { margin: 4px 0 0; font-size: 13px; color: var(--t-cap); }
    .ld .btn { height: 38px; padding: 0 16px; font-size: 13px; gap: 8px; } .ld .btn svg { width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    .soon { font-size: 12.5px; color: var(--t-cap); }
    @media (max-width: 720px) { .ld { grid-template-columns: minmax(0,1fr); gap: 12px; padding: 16px 18px; } .ld .ic { display: none; } .ld .btn { width: 100%; justify-content: center; } }
</style>
@endpush

@section('content')
<!-- Breadcrumb & Hero -->
<section class="pg-head">
  <div class="container hero-grid">
    <nav class="crumb" aria-label="Breadcrumb"><a href="{{ route('home') }}">Beranda</a><span aria-hidden="true">/</span><span aria-current="page">Laporan Kinerja</span></nav>
    <span class="eyebrow">Akuntabilitas</span>
    <h1>Laporan Kinerja</h1>
    <p class="pg-desc">Dokumen laporan kinerja DPM UII per periode kepengurusan.</p>
  </div>
</section>

<!-- Laporan List -->
<section style="padding:48px 0 88px">
  <div class="container">
    {{-- Group data berdasarkan tahun --}}
    @php
        $years = [$grouped->keys()->first() ?? date('Y')];
        // Ambil kunci unik dari grouped dan gabungkan dengan rentang yang mungkin
        $allYears = $grouped->keys()->toArray();
        if (empty($allYears)) {
            // Fallback: ambil year dari documents
            $allYears = $documents->pluck('year')->unique()->toArray();
        }
    @endphp

    {{-- Tampilkan periode 2025/2026 dan 2024/2025 yang ada --}}
    @foreach ($allYears as $yearIndex => $year)
        {{-- Hitung total laporan di tahun ini --}}
        $yearDocs = $grouped[$year] ?? collect();
        $totalThisYear = $yearDocs->count();
        $isCurrent = $year >= 2025; -- logika sederhana: 2025 ke atas dianggap "berjalan"

        {{-- Section header --}}
        <section class="lg">
            {{-- Label periode: jika 2025/2026 tampil "Periode berjalan", 2024/2025 "Selesai" --}}
            <h2>{{ $year }}/{{ $year + 1 }}<small>
                @if($isCurrent)
                    Periode berjalan
                @else
                    Selesai
                @endif
            </small></h2>

            {{-- List laporan --}}
            @if($yearDocs->isNotEmpty())
                <ul class="ldl">
                    {{-- Urutkan berdasarkan quarter (Triwulan I-IV) dan flag is_featured --}}
                    @foreach ($yearDocs->sortByDesc('quarter')->sortByDesc(function ($d) { return $d->is_featured ? 1 : 0; }) as $doc)
                        <li class="ld">
                            {{-- Ikon: PDF untuk published, DOK untuk unpublished --}}
                            <span class="ic" aria-hidden="true">{{ $doc->isPublished() ? 'PDF' : 'DOK' }}</span>

                            {{-- Detail laporan --}}
                            <div>
                                <h3>{{ $doc->title ?? 'Laporan Kinerja' }}</h3>
                                <p>{{ $doc->published_at?->format('d F Y') ?? 'Belum tersedia' }}</p>
                            </div>

                            {{-- Tombol unduh jika sudah dipublikasikan --}}
                            @if($doc->isPublished())
                            <a class="btn" href="{{ $doc->download_url }}" download>
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M4 16v1a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                <span>Unduh</span>
                            </a>
                            @else
                            {{-- Jika belum dipublikasikan, tampilSoon --}}
                            <span class="soon">Belum tersedia</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                {{-- Jika tahun ini belum ada laporan --}}
                <p class="text-center text-slate-600 py-8">
                    Belum ada laporan kinerja untuk tahun {{ $year }}.
                </p>
            @endif
        </section>
    @endforeach
    {{-- Jika tidak ada data sama sekali --}}
    @if($allYears->isEmpty())
        <section class="lg">
            <h2>Tidak Ada Laporan</h2>
            <p class="text-slate-500">Laporan kinerja akan diunggah sesuai dengan periode kepengurusan aktif.</p>
        </section>
    @endif
  </div>
</section>
@endsection