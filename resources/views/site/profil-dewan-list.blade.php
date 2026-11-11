@extends('layouts.site')

@section('title', 'Profil Dewan '.($periode?->name ?? '').' — '.($siteSettings['site_name'] ?? 'DPM UII'))
@section('meta_description', 'Susunan pimpinan dan komisi Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia pada periode kepengurusan aktif.')

@push('styles')
<style>
  .pf-page { color: rgba(255,255,255,.85); }
  .pf-hero { position: relative; overflow: hidden; padding: 56px 0 48px; border-bottom: 1px solid var(--b-default); background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%); }
  .pf-hero::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 28px); }
  .pf-hero .container { position: relative; }
  .pf-hero h1 { font-size: clamp(38px, 6vw, 68px); letter-spacing: -2px; line-height: 1.03; margin-bottom: 14px; }
  .pf-hero .crumb { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 28px; font-size: 12.5px; color: var(--t-cap); }
  .pf-hero .crumb a { transition: color .2s; } .pf-hero .crumb a:hover { color: var(--white); }
  .pf-hero .crumb span[aria-hidden] { opacity: .5; }
  .pf-hero .crumb span[aria-current] { color: var(--white); font-weight: 600; }
  .pg-desc { max-width: 620px; margin-bottom: 0; font-size: 16px; line-height: 1.7; color: var(--t-sub); }
  .pers { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 22px; }
  .pers a { padding: 7px 16px; border: 1px solid var(--b-btn); border-radius: 100px; font-size: 13px; font-weight: 600; transition: border-color .2s, background .2s; }
  .pers a:hover { border-color: var(--b-btn-hover); background: var(--bg-hover); }
  .pers a[aria-current] { background: var(--bg-hover); border-color: var(--b-btn-hover); }

  .subnav { position: sticky; top: 73px; z-index: 50; background: rgba(0,22,51,.95); border-bottom: 1px solid var(--b-default); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); }
  .subnav-inner { display: flex; align-items: center; justify-content: space-between; gap: 20px; }
  .subnav ol { list-style: none; display: flex; gap: 4px; padding: 10px 0; overflow-x: auto; scrollbar-width: none; }
  .subnav ol::-webkit-scrollbar { display: none; }
  .subnav li a { display: flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 100px; border: 1px solid transparent; white-space: nowrap; font-size: 13.5px; font-weight: 600; color: var(--t-cap); transition: color .2s, background .2s, border-color .2s; }
  .subnav li a em { font-style: normal; font-size: 11px; opacity: .6; }
  .subnav li a:hover { color: var(--white); }

  .pf-sec { padding: 80px 0; border-bottom: 1px solid var(--b-default); }
  .pf-sec.alt { background: var(--navy-footer); }
  .pf-head { display: flex; align-items: flex-end; justify-content: space-between; gap: 20px; flex-wrap: wrap; margin-bottom: 36px; }
  .pf-head .no { display: block; margin-bottom: 4px; font-family: 'Wix Madefor Display', sans-serif; font-size: 72px; font-weight: 800; line-height: .9; letter-spacing: -3px; color: transparent; -webkit-text-stroke: 1px rgba(255,255,255,.3); }
  .pf-head h2 { font-size: clamp(26px, 3.2vw, 38px); letter-spacing: -.9px; }
  .pf-head p { margin-top: 6px; font-size: 14.5px; color: var(--t-cap); }
  .hint { font-size: 12.5px; font-weight: 600; letter-spacing: 1.2px; text-transform: uppercase; color: var(--t-cap); }

  .av { position: relative; display: grid; place-items: center; overflow: hidden; background: linear-gradient(135deg, #002A5A, #001633); }
  .av::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, rgba(255,255,255,0.04) 0 1px, transparent 1px 18px); }
  .av .sil { position: absolute; left: 12%; right: 12%; bottom: 0; width: 76%; height: auto; fill: rgba(255,255,255,.10); stroke: rgba(255,255,255,.28); stroke-width: 1.2; }
  .av b { position: relative; font-family: 'Wix Madefor Display', sans-serif; font-weight: 800; letter-spacing: -1px; color: rgba(255,255,255,.4); }
  .av img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: top; }

  .pc-grid { display: grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap: 20px; }
  .pc { display: block; overflow: hidden; border: 1px solid var(--b-default); border-radius: 12px; background: var(--navy-card); box-shadow: var(--sh-md); transition: border-color .2s, transform .2s; }
  .pc:hover { border-color: var(--b-btn-hover); transform: translateY(-3px); }
  .pc .av { aspect-ratio: 4 / 5; width: 100%; }
  .pc .av b { font-size: 88px; }
  .pc-i { padding: 22px 24px 26px; border-top: 1px solid var(--b-default); }
  .pc-i small { display: block; margin-bottom: 8px; font-size: 11.5px; font-weight: 600; letter-spacing: 1.6px; text-transform: uppercase; color: var(--t-cap); }
  .pc-i h3 { font-size: 24px; letter-spacing: -.6px; line-height: 1.2; }
  .pc-i span { display: block; margin-top: 4px; font-size: 13.5px; line-height: 1.5; color: var(--t-sub); }
  .pc-i em { display: inline-block; margin-top: 16px; font-style: normal; font-size: 13px; font-weight: 600; color: var(--white); }
  .pc-i em::after { content: ' →'; }

  .rail { display: flex; gap: 20px; overflow-x: auto; scroll-snap-type: x mandatory; padding: 2px 2px 22px; scrollbar-width: thin; scrollbar-color: rgba(255,255,255,.35) transparent; }
  .rail::-webkit-scrollbar { height: 6px; } .rail::-webkit-scrollbar-thumb { background: rgba(255,255,255,.3); border-radius: 100px; }
  .rail .pc { flex: 0 0 calc((100% - 40px) / 3); scroll-snap-align: start; }

  .empty { padding: 28px; border: 1px dashed var(--b-default); border-radius: 8px; text-align: center; color: var(--t-cap); font-size: 14px; }

  @media (max-width: 1080px) { .pc-grid { grid-template-columns: repeat(2, minmax(0,1fr)); } .rail .pc { flex-basis: calc((100% - 20px) / 2); } }
  @media (max-width: 720px) { .pf-hero { padding: 36px 0 32px; } .pf-sec { padding: 52px 0; } .pc-grid { grid-template-columns: minmax(0,1fr); } .rail .pc { flex-basis: 78%; } .pc-i h3 { font-size: 21px; } .pf-head .no { font-size: 52px; } }
</style>
@endpush

@section('content')
<div class="pf-page">

  {{-- HERO --}}
  <section class="pf-hero">
    <div class="container">
      <nav class="crumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Beranda</a><span aria-hidden="true">/</span>
        <a href="{{ url('/#fungsi') }}">Tentang</a><span aria-hidden="true">/</span>
        <span aria-current="page">Profil Dewan</span>
      </nav>
      <span class="eyebrow">Tentang DPM UII</span>
      <h1>Profil Dewan</h1>
      <p class="pg-desc">
        Susunan pimpinan dan komisi Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia
        periode <strong style="color:#fff">{{ $periode?->name ?? '—' }}</strong>. Seluruh anggota dewan berkedudukan setara.
      </p>
      @if ($periodePilihan->isNotEmpty())
        <div class="pers" aria-label="Periode kepengurusan">
          @foreach ($periodePilihan as $pilihan)
            <a href="{{ route('profil-dewan.index', ['periode' => $pilihan->name]) }}"
               @if ($pilihan->name === $periode?->name) aria-current="page" @endif>{{ $pilihan->name }}</a>
          @endforeach
        </div>
      @endif
    </div>
  </section>

  {{-- SUBNAV --}}
  <div class="subnav" id="subnav">
    <div class="container subnav-inner">
      <ol id="toc" aria-label="Navigasi Profil Dewan">
        <li><a href="#pimpinan"><em>01</em>Pimpinan</a></li>
        @foreach ($komisi as $seksi)
          <li><a href="#komisi-{{ $seksi['nomor'] }}"><em>{{ $seksi['romawi'] }}</em>{{ $seksi['nama'] }}</a></li>
        @endforeach
      </ol>
    </div>
  </div>

  {{-- PIMPINAN --}}
  <section class="pf-sec" id="pimpinan" aria-labelledby="h-pim">
    <div class="container">
      <div class="pf-head">
        <div>
          <span class="no" aria-hidden="true">01</span>
          <h2 id="h-pim">Pimpinan Dewan</h2>
          <p>Seluruh pimpinan berkedudukan setara; urutan tampil mengikuti susunan jabatan, bukan tingkatan.</p>
        </div>
      </div>
      @if ($pimpinan->isEmpty())
        <p class="empty">Belum ada data pimpinan.</p>
      @else
        <div class="pc-grid">
          @foreach ($pimpinan as $profil)
            @include('site.partials.profil-card', ['profil' => $profil, 'foto' => $fotos[$profil->nama_lengkap] ?? null])
          @endforeach
        </div>
      @endif
    </div>
  </section>

  {{-- KOMISI --}}
  @foreach ($komisi as $seksi)
    <section class="pf-sec{{ $seksi['nomor'] % 2 ? ' alt' : '' }}" id="komisi-{{ $seksi['nomor'] }}" aria-labelledby="h-k{{ $seksi['nomor'] }}">
      <div class="container">
        <div class="pf-head">
          <div>
            <span class="no" aria-hidden="true">{{ $seksi['romawi'] }}</span>
            <h2 id="h-k{{ $seksi['nomor'] }}">{{ $seksi['nama'] }}</h2>
          </div>
          <span class="hint">{{ $seksi['anggota']->count() }} anggota</span>
        </div>
        <div class="rail">
          @foreach ($seksi['anggota'] as $profil)
            @include('site.partials.profil-card', ['profil' => $profil, 'foto' => $fotos[$profil->nama_lengkap] ?? null])
          @endforeach
        </div>
      </div>
    </section>
  @endforeach

</div>
@endsection
