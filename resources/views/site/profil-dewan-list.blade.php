@extends('layouts.site')

@section('title', 'Profil Dewan — DPM UII')

@section('content')
<style>
  .pf-page { color: rgba(255,255,255,.85); }
  .pf-hero { position: relative; overflow: hidden; padding: 56px 0 48px; border-bottom: 1px solid var(--b-default); background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%); }
  .pf-hero::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 28px); }
  .pf-hero .container { position: relative; }
  .pf-hero h1 { font-size: clamp(38px, 6vw, 68px); letter-spacing: -2px; line-height: 1.03; margin-bottom: 14px; }
  .pf-hero .crumb { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 18px; font-size: 12.5px; color: var(--t-cap); }
  .pf-hero .crumb a { transition: color .2s; } .pf-hero .crumb a:hover { color: var(--white); }
  .pf-hero .crumb span[aria-hidden] { opacity: .5; }
  .pf-hero .crumb span[aria-current] { color: var(--white); font-weight: 600; }
  .sample { display: flex; gap: 14px; align-items: flex-start; margin-top: 24px; padding: 14px 18px; max-width: 760px; border: 1px dashed var(--b-btn-hover); border-radius: 8px; background: rgba(0,22,51,.55); font-size: 13.5px; line-height: 1.7; color: var(--t-sub); }
  .sample b { flex-shrink: 0; padding: 2px 10px; border: 1px solid var(--b-btn); border-radius: 100px; font-size: 11px; letter-spacing: 1.2px; text-transform: uppercase; color: var(--white); }

  .subnav { position: sticky; top: 73px; z-index: 50; background: rgba(0,22,51,.95); border-bottom: 1px solid var(--b-default); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); }
  .subnav::after { content: ''; position: absolute; left: 0; bottom: -1px; height: 2px; width: calc(var(--p, 0) * 100%); background: var(--white); transition: width .1s linear; }
  .subnav-inner { display: flex; align-items: center; justify-content: space-between; gap: 20px; }
  .subnav ol { list-style: none; display: flex; gap: 4px; padding: 10px 0; overflow-x: auto; scrollbar-width: none; }
  .subnav ol::-webkit-scrollbar { display: none; }
  .subnav li a { display: flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 100px; border: 1px solid transparent; white-space: nowrap; font-size: 13.5px; font-weight: 600; color: var(--t-cap); transition: color .2s, background .2s, border-color .2s; }
  .subnav li a em { font-style: normal; font-size: 11px; opacity: .6; }
  .subnav li a:hover { color: var(--white); }
  .subnav li a[aria-current="true"] { color: var(--white); background: rgba(255,255,255,.10); border-color: rgba(255,255,255,.35); }
  .subnav .ctrls { display: flex; gap: 8px; align-items: center; flex-shrink: 0; }
  .sel { position: relative; }
  .sel select { appearance: none; -webkit-appearance: none; padding: 8px 36px 8px 14px; border: 1px solid var(--b-btn); border-radius: 6px; background: var(--navy-card); font: inherit; font-size: 13px; font-weight: 600; color: var(--white); cursor: pointer; }
  .sel::after { content: ''; position: absolute; right: 13px; top: 50%; width: 7px; height: 7px; margin-top: -6px; border-right: 2px solid var(--white); border-bottom: 2px solid var(--white); transform: rotate(45deg); pointer-events: none; }
  .sel select option { background: #001A3A; color: #fff; }
  @media (max-width: 1080px) { .subnav .ctrls { display: none; } }

  .pf-sec { padding: 80px 0; border-bottom: 1px solid var(--b-default); }
  .pf-sec.alt { background: var(--navy-footer); }
  .pf-head { display: flex; align-items: flex-end; justify-content: space-between; gap: 20px; flex-wrap: wrap; margin-bottom: 36px; }
  .pf-head .no { display: block; margin-bottom: 4px; font-family: 'Wix Madefor Display', sans-serif; font-size: 72px; font-weight: 800; line-height: .9; letter-spacing: -3px; color: transparent; -webkit-text-stroke: 1px rgba(255,255,255,.3); }
  .pf-head h2 { font-size: clamp(26px, 3.2vw, 38px); letter-spacing: -.9px; }
  .pf-head p { margin-top: 6px; font-size: 14.5px; color: var(--t-cap); }
  .pf-head .cnt { font-size: 12.5px; font-weight: 600; letter-spacing: 1.2px; text-transform: uppercase; color: var(--t-cap); }

  .av { position: relative; display: grid; place-items: center; overflow: hidden; background: linear-gradient(135deg, #002A5A, #001633); }
  .av::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, rgba(255,255,255,0.04) 0 1px, transparent 1px 18px); }
  .av .sil { position: absolute; left: 12%; right: 12%; bottom: 0; width: 76%; height: auto; fill: rgba(255,255,255,.10); stroke: rgba(255,255,255,.28); stroke-width: 1.2; }
  .av b { position: relative; font-family: 'Wix Madefor Display', sans-serif; font-weight: 800; letter-spacing: -1px; color: rgba(255,255,255,.4); }
  .av img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: top; }

  .chief { display: grid; grid-template-columns: 360px 1fr; border: 1px solid var(--b-btn); border-radius: 12px; background: var(--navy-card); overflow: hidden; box-shadow: var(--sh-md); cursor: pointer; transition: border-color .2s; }
  .chief:hover { border-color: var(--b-btn-hover); }
  .chief .av { min-height: 420px; } .chief .av b { font-size: 96px; }
  .chief-info { display: flex; flex-direction: column; justify-content: center; padding: 44px 48px; }
  .role { display: inline-block; align-self: flex-start; margin-bottom: 16px; padding: 4px 14px; border: 1px solid var(--b-btn); border-radius: 100px; font-size: 11.5px; font-weight: 600; letter-spacing: 1.6px; text-transform: uppercase; color: var(--white); }
  .chief-info h3 { font-size: clamp(30px, 4vw, 48px); letter-spacing: -1.4px; line-height: 1.08; margin-bottom: 14px; }
  .chief-info p { font-size: 15px; line-height: 1.8; color: var(--t-sub); max-width: 520px; }
  .facts-l { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 22px; }
  .facts-l span { padding: 6px 14px; border: 1px solid var(--b-default); border-radius: 6px; background: rgba(255,255,255,.04); font-size: 13px; color: var(--t-body); }
  .more { margin-top: 24px; font-size: 13px; font-weight: 600; color: var(--white); }
  .more::after { content: ' →'; }

  .g2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; margin-top: 14px; }
  .g3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
  .mc { display: grid; grid-template-columns: 88px 1fr; gap: 18px; align-items: center; padding: 16px; width: 100%; text-align: left; font: inherit; color: inherit; background: var(--navy-card); border: 1px solid var(--b-default); border-radius: 8px; cursor: pointer; transition: border-color .2s, background .2s, transform .2s; }
  .mc:hover { border-color: var(--b-btn); background: var(--navy-hover); transform: translateY(-2px); }
  .mc .av { width: 88px; height: 88px; border-radius: 8px; } .mc .av b { font-size: 28px; }
  .mc.big { grid-template-columns: 112px 1fr; padding: 20px; } .mc.big .av { width: 112px; height: 112px; } .mc.big .av b { font-size: 34px; }
  .mc small { display: block; margin-bottom: 4px; font-size: 11px; font-weight: 600; letter-spacing: 1.4px; text-transform: uppercase; color: var(--t-cap); }
  .mc h3 { font-size: 17px; letter-spacing: -.2px; line-height: 1.3; margin-bottom: 4px; }
  .mc span.m { display: block; font-size: 12.5px; line-height: 1.5; color: var(--t-cap); }
  .kom-lead { margin-bottom: 14px; }
  .empty { padding: 28px; border: 1px dashed var(--b-default); border-radius: 8px; text-align: center; color: var(--t-cap); font-size: 14px; }

  @media (max-width: 1080px) { .g3 { grid-template-columns: 1fr 1fr; } .chief { grid-template-columns: 280px 1fr; } .chief-info { padding: 32px; } }
  @media (max-width: 720px) { .pf-hero { padding: 36px 0 32px; } .pf-sec { padding: 52px 0; } .chief { grid-template-columns: 1fr; } .chief .av { min-height: 320px; } .chief-info { padding: 24px 22px 28px; } .g2, .g3 { grid-template-columns: 1fr; } .pf-head .no { font-size: 52px; } }
</style>

<!-- ================= HERO ================= -->
<section class="pf-hero"><div class="container">
  <nav class="crumb" aria-label="Breadcrumb">
    <a href="{{ route('home') }}">Beranda</a><span aria-hidden="true">/</span>
    <a href="/#fungsi">Tentang</a><span aria-hidden="true">/</span>
    <span aria-current="page">Profil Dewan</span>
  </nav>
  <span class="eyebrow">Tentang DPM UII</span>
  <h1>Profil Dewan</h1>
  <p class="pg-desc">Susunan pimpinan dan komisi Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia pada periode kepengurusan <strong style="color:#fff">{{ $periode ?? '—' }}</strong>.</p>
</div></section>

@php
    $komisiConfig = [
        'komisi1' => ['no' => 'I', 'key' => 'komisi-1', 'title' => 'Komisi I', 'desc' => 'Menangani penyusunan, pembahasan, dan pengawasan produk hukum KM UII.'],
        'komisi2' => ['no' => 'II', 'key' => 'komisi-2', 'title' => 'Komisi II', 'desc' => 'Mengawasi kinerja lembaga dan alat kelengkapan KM UII serta audit pertanggungjawaban.'],
        'komisi3' => ['no' => 'III', 'key' => 'komisi-3', 'title' => 'Komisi III', 'desc' => 'Menampung aspirasi dan memperjuangkan kesejahteraan mahasiswa UII.'],
        'komisi4' => ['no' => 'IV', 'key' => 'komisi-4', 'title' => 'Komisi IV', 'desc' => 'Membangun relasi dan kerjasama strategis antar lembaga kemahasiswaan.'],
    ];
    $komisiSections = [];
    foreach ($komisiConfig as $var => $komisi) {
        if ($$var->isNotEmpty()) {
            $komisiSections[$var] = $komisi;
        }
    }
@endphp

<!-- ================= SUBNAV ================= -->
<div class="subnav" id="subnav"><div class="container subnav-inner">
  <ol id="toc">
    <li><a href="#pimpinan"><em>01</em>Pimpinan</a></li>
    @foreach ($komisiSections as $komisi)
      <li><a href="#{{ $komisi['key'] }}"><em>{{ $komisi['no'] }}</em>{{ $komisi['title'] }}</a></li>
    @endforeach
  </ol>
  <div class="ctrls">
    <label class="sel">
      <select id="periode" aria-label="Periode kepengurusan">
        <option value="{{ $periode }}" selected>Periode {{ $periode ?? '—' }}</option>
      </select>
    </label>
  </div>
</div></div>

<!-- ================= PIMPINAN DEWAN ================= -->
<section class="pf-sec" id="pimpinan" aria-labelledby="h-pim">
  <div class="container">
    <div class="pf-head">
      <div>
        <span class="no" aria-hidden="true">01</span>
        <h2 id="h-pim">Pimpinan Dewan</h2>
        <p>Ketua Umum dan jajaran pimpinan harian.</p>
      </div>
      <span class="cnt">{{ $pimpinan->count() }} pimpinan</span>
    </div>

    {{-- Ketua Umum (chief / large card) --}}
    @php
        $ketuaUmum = $pimpinan->firstWhere('jabatan', 'Ketua Umum');
        $wakilKetuaUmum = $pimpinan->firstWhere('jabatan', 'Wakil Ketua Umum');
        $sekjen = $pimpinan->first(fn ($p) => str_contains($p->jabatan, 'Sekretaris'));
    @endphp

    @if($ketuaUmum)
    <a class="chief" href="{{ route('profil-dewan.detail', $ketuaUmum->nim) }}">
      <div class="av">
        <svg class="sil" viewBox="0 0 100 120" aria-hidden="true"><circle cx="50" cy="40" r="20"/><path d="M12 120c0-26 17-42 38-42s38 16 38 42z"/></svg>
        {{-- Foto placeholder - replace with actual image path --}}
        {{-- <img src="{{ asset('images/dewan/' . Str::slug($ketuaUmum->nama_lengkap) . '.jpg') }}" alt="Foto {{ $ketuaUmum->nama_lengkap }}" loading="lazy" onerror="this.remove()"> --}}
      </div>
      <div class="chief-info">
        <span class="role">{{ $ketuaUmum->jabatan }}</span>
        <h3>{{ $ketuaUmum->nama_lengkap }}</h3>
        <p>{{ $ketuaUmum->bio ?? 'Memimpin Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia periode ' . $ketuaUmum->periode . '.' }}</p>
        <div class="facts-l">
          <span>{{ $ketuaUmum->fakultas }}</span>
          <span>{{ $ketuaUmum->program_studi }}</span>
          <span>Angkatan {{ $ketuaUmum->angkatan }}</span>
        </div>
        <span class="more">Lihat profil</span>
      </div>
    </a>
    @endif

    {{-- Wakil Ketua Umum & Sekjen (g2) --}}
    <div class="g2">
      @if($wakilKetuaUmum)
      <a class="mc big" href="{{ route('profil-dewan.detail', $wakilKetuaUmum->nim) }}">
        <div class="av">
          <svg class="sil" viewBox="0 0 100 120" aria-hidden="true"><circle cx="50" cy="40" r="20"/><path d="M12 120c0-26 17-42 38-42s38 16 38 42z"/></svg>
        </div>
        <span>
          <small>{{ $wakilKetuaUmum->jabatan }}</small>
          <h3>{{ $wakilKetuaUmum->nama_lengkap }}</h3>
          <span class="m">{{ $wakilKetuaUmum->fakultas }} · {{ $wakilKetuaUmum->program_studi }}</span>
        </span>
      </a>
      @endif

      @if($sekjen)
      <a class="mc big" href="{{ route('profil-dewan.detail', $sekjen->nim) }}">
        <div class="av">
          <svg class="sil" viewBox="0 0 100 120" aria-hidden="true"><circle cx="50" cy="40" r="20"/><path d="M12 120c0-26 17-42 38-42s38 16 38 42z"/></svg>
        </div>
        <span>
          <small>{{ $sekjen->jabatan }}</small>
          <h3>{{ $sekjen->nama_lengkap }}</h3>
          <span class="m">{{ $sekjen->fakultas }} · {{ $sekjen->program_studi }}</span>
        </span>
      </a>
      @endif
    </div>
    @php
        $pimpinanIds = [$ketuaUmum?->id, $wakilKetuaUmum?->id, $sekjen?->id];
        $pimpinanLain = $pimpinan->reject(fn ($p) => in_array($p->id, $pimpinanIds, true));
    @endphp

    @if ($pimpinanLain->isNotEmpty())
    <div class="g3" style="margin-top:14px">
      @foreach ($pimpinanLain as $p)
      <a class="mc" href="{{ route('profil-dewan.detail', $p->nim) }}">
        <div class="av">
          <svg class="sil" viewBox="0 0 100 120" aria-hidden="true"><circle cx="50" cy="40" r="20"/><path d="M12 120c0-26 17-42 38-42s38 16 38 42z"/></svg>
        </div>
        <span>
          <small>{{ $p->jabatan }}</small>
          <h3>{{ $p->nama_lengkap }}</h3>
          <span class="m">{{ $p->fakultas }} · {{ $p->program_studi }}</span>
        </span>
      </a>
      @endforeach
    </div>
    @endif
  </div>
</section>

@foreach ($komisiSections as $var => $komisi)
    {{-- Get komisi members (exclude Ketua) --}}
    @php
        $komisiMembers = $$var->filter(fn ($p) => !str_contains($p->jabatan, 'Ketua Komisi'));
        $ketuaKomisi = $$var->firstWhere('jabatan', 'Ketua Komisi ' . $komisi['no']);
    @endphp

    <section class="pf-sec {{ $loop->odd ? 'alt' : '' }}" id="{{ $komisi['key'] }}" aria-labelledby="{{ $komisi['key'] }}">
      <div class="container">
        <div class="pf-head">
          <div>
            <span class="no" aria-hidden="true">{{ $komisi['no'] }}</span>
            <h2 id="{{ $komisi['key'] }}">{{ $komisi['title'] }}</h2>
            <p>{{ $komisi['desc'] }}</p>
          </div>
          <span class="cnt">{{ $komisiMembers->count() }} anggota</span>
        </div>

        {{-- Ketua Komisi (kom-lead / big mc) --}}
        @if($ketuaKomisi)
        <div class="kom-lead">
          <a class="mc big" href="{{ route('profil-dewan.detail', $ketuaKomisi->nim) }}">
            <div class="av">
              <svg class="sil" viewBox="0 0 100 120" aria-hidden="true"><circle cx="50" cy="40" r="20"/><path d="M12 120c0-26 17-42 38-42s38 16 38 42z"/></svg>
            </div>
            <span>
              <small>{{ $ketuaKomisi->jabatan }}</small>
              <h3>{{ $ketuaKomisi->nama_lengkap }}</h3>
              <span class="m">{{ $ketuaKomisi->fakultas }} · {{ $ketuaKomisi->program_studi }}</span>
            </span>
          </a>
        </div>
        @endif

        {{-- Anggota Komisi (g3) --}}
        <div class="g3">
          @foreach($komisiMembers as $member)
          <a class="mc" href="{{ route('profil-dewan.detail', $member->nim) }}">
            <div class="av">
              <svg class="sil" viewBox="0 0 100 120" aria-hidden="true"><circle cx="50" cy="40" r="20"/><path d="M12 120c0-26 17-42 38-42s38 16 38 42z"/></svg>
            </div>
            <span>
              <small>{{ $member->jabatan }}</small>
              <h3>{{ $member->nama_lengkap }}</h3>
              <span class="m">{{ $member->fakultas }} · {{ $member->program_studi }}</span>
            </span>
          </a>
          @endforeach
        </div>
      </div>
    </section>
@endforeach

@endsection