@extends('layouts.site')

@section('title')
    {{ $profil?->nama_lengkap }} — Profil Dewan — DPM UII
@endsection
@section('meta_description')
    Profil {{ $profil?->nama_lengkap }}, {{ $profil?->jabatan }} DPM UII periode {{ $profil?->periode }}.
@endsection

@section('content')
@php
    $name = $profil?->nama_lengkap ?? '';
    $parts = array_slice(explode(' ', trim($name)), 0, 2);
    $initials = strtoupper(implode('', array_map(fn($w) => mb_substr($w, 0, 1), $parts)));
@endphp

<style>
  .av { position: relative; display: grid; place-items: center; overflow: hidden; background: linear-gradient(135deg, #002A5A, #001633); }
  .av::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, rgba(255,255,255,0.04) 0 1px, transparent 1px 18px); }
  .av .sil { position: absolute; left: 12%; width: 76%; bottom: 0; height: auto; fill: rgba(255,255,255,.10); stroke: rgba(255,255,255,.28); stroke-width: 1.2; }
  .av img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: top; }
  .av b { position: relative; font-family: 'Wix Madefor Display', sans-serif; font-weight: 800; letter-spacing: -1px; color: rgba(255,255,255,.4); }

  .role { display: inline-block; margin-bottom: 12px; padding: 4px 14px; border: 1px solid var(--b-btn); border-radius: 100px; font-size: 11.5px; font-weight: 600; letter-spacing: 1.6px; text-transform: uppercase; color: var(--white); }

  .soc { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 18px; }
  .soc a { width: 42px; height: 42px; display: grid; place-items: center; border: 1px solid var(--b-btn); border-radius: 50%; color: var(--white); transition: background .2s, border-color .2s; }
  .soc a:hover { background: var(--bg-hover); border-color: var(--b-btn-hover); }
  .soc svg { width: 17px; height: 17px; fill: currentColor; }

  .ph-hero { padding: 28px 0 44px; border-bottom: 1px solid var(--b-default); background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%); position: relative; }
  .ph-hero::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, rgba(255,255,255,.035) 0 1px, transparent 1px 26px); pointer-events: none; }
  .ph-hero .container { position: relative; }
  .ph-hero .crumb { margin-bottom: 28px; }
  .ph-row { display: flex; align-items: center; gap: 32px; }
  .ph-row .av { flex: none; width: 150px; height: 188px; border: 1px solid var(--b-btn); border-radius: 8px; }
  .ph-row .av b { font-size: 40px; }
  .ph-t .role { margin-bottom: 14px; }
  .ph-t h1 { font-size: clamp(30px, 4.6vw, 48px); letter-spacing: -1.2px; line-height: 1.1; margin-bottom: 10px; }
  .ph-t p { font-size: 15px; color: var(--t-sub); line-height: 1.7; }
  .ph-t .soc { margin-top: 18px; }

  .dt-wrap { padding-top: 40px; } .dt-wrap .main { max-width: 900px; }

  .main > section { padding: 0 0 44px; margin-bottom: 44px; border-bottom: 1px solid var(--b-default); }
  .main > section:last-of-type { border-bottom: 0; margin-bottom: 0; }

  .sh { display: flex; align-items: baseline; gap: 14px; margin-bottom: 20px; }
  .sh span { font-family: 'Wix Madefor Display', sans-serif; font-size: 13px; font-weight: 800; color: transparent; -webkit-text-stroke: 1px rgba(255,255,255,.5); }
  .sh h2 { font-size: clamp(22px, 2.6vw, 30px); letter-spacing: -.6px; }

  .bio { max-width: 720px; font-size: 16px; line-height: 1.9; color: var(--t-body); }

  .dl { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-top: 24px; }
  .dl div { padding: 16px 20px; border: 1px solid var(--b-default); border-radius: 8px; background: var(--navy-card); }
  .dl small { display: block; margin-bottom: 4px; font-size: 11px; font-weight: 600; letter-spacing: 1.4px; text-transform: uppercase; color: var(--t-cap); }
  .dl b { font-size: 15px; font-weight: 600; color: var(--white); }
  .dl.idl { margin-top: 0; } .dl b.mono { font-variant-numeric: tabular-nums; letter-spacing: 1.5px; }

  .tg { list-style: none; display: grid; gap: 10px; }
  .tg li { display: grid; grid-template-columns: auto 1fr; gap: 18px; padding: 18px 22px; border: 1px solid var(--b-default); border-radius: 8px; background: var(--navy-card); font-size: 15px; line-height: 1.75; color: var(--t-body); transition: border-color .2s, background .2s; }
  .tg li:hover { border-color: var(--b-btn); background: var(--navy-hover); }
  .tg li b { font-family: 'Wix Madefor Display', sans-serif; font-size: 22px; font-weight: 800; line-height: 1.2; color: transparent; -webkit-text-stroke: 1px rgba(255,255,255,.42); }

  .ct { display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
  .ct a { display: flex; align-items: center; gap: 14px; padding: 16px 20px; border: 1px solid var(--b-default); border-radius: 8px; background: var(--navy-card); transition: border-color .2s, background .2s; }
  .ct a:hover { border-color: var(--b-btn); background: var(--navy-hover); }
  .ct svg { width: 20px; height: 20px; flex-shrink: 0; fill: currentColor; }
  .ct small { display: block; font-size: 11px; font-weight: 600; letter-spacing: 1.4px; text-transform: uppercase; color: var(--t-cap); }
  .ct b { font-size: 14.5px; font-weight: 600; color: var(--white); word-break: break-all; }

  @media (max-width: 720px) {
    .ph-row { flex-direction: column; align-items: flex-start; gap: 20px; }
    .ph-row .av { width: 112px; height: 140px; }
    .dl, .ct { grid-template-columns: 1fr; }
    .tg li { padding: 16px; gap: 14px; }
  }
</style>

<section class="ph-hero">
  <div class="container">
    <nav class="crumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Beranda</a>
      <span aria-hidden="true">/</span>
      <a href="/#fungsi">Tentang</a>
      <span aria-hidden="true">/</span>
      <a href="{{ route('profil-dewan.index') }}">Profil Dewan</a>
      <span aria-hidden="true">/</span>
      <span aria-current="page">{{ $profil?->nama_lengkap }}</span>
    </nav>
    <div class="ph-row">
      <div class="av">
        <svg class="sil" viewBox="0 0 100 120" aria-hidden="true"><circle cx="50" cy="40" r="20"/><path d="M12 120c0-26 17-42 38-42s38 16 38 42z"/></svg>
        <b>{{ $initials }}</b>
      </div>
      <div class="ph-t">
        <span class="role">{{ $profil?->jabatan }}</span>
        <h1>{{ $profil?->nama_lengkap }}</h1>
        <p>{{ $profil?->jabatan }} Dewan Permusyawaratan Mahasiswa<br>Universitas Islam Indonesia · Periode {{ $profil?->periode }}</p>
        <div class="soc" aria-label="Sosial media">
          @if($profil?->instagram)
          <a href="{{ $profil->instagram }}" target="_blank" rel="noopener" aria-label="Instagram {{ $profil->nama_lengkap }}">
            <svg viewBox="0 0 448 512"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></path></svg>
          </a>
          @endif
          @if($profil?->email)
          <a href="mailto:{{ $profil->email }}" target="_blank" rel="noopener" aria-label="Email {{ $profil->nama_lengkap }}">
            <svg viewBox="0 0 512 512"><path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176v208c0 35.3 28.7 64 64 64h384c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg>
          </a>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>

<section class="dt-wrap">
  <div class="container">
    <div class="main">
      <section aria-labelledby="s1">
        <div class="sh"><span>01</span><h2 id="s1">Identitas</h2></div>
        <div class="dl idl">
          <div><small>Nama lengkap</small><b>{{ $profil?->nama_lengkap }}</b></div>
          <div><small>NIM</small><b class="mono">{{ $profil?->nim }}</b></div>
          <div><small>Fakultas</small><b>{{ $profil?->fakultas }}</b></div>
          <div><small>Program studi</small><b>{{ $profil?->program_studi }}</b></div>
          <div><small>Angkatan</small><b>{{ $profil?->angkatan }}</b></div>
          <div><small>Email kampus</small><b>{{ $profil?->email_kampus }}</b></div>
        </div>
      </section>

      <section aria-labelledby="s1b">
        <div class="sh"><span>02</span><h2 id="s1b">Keanggotaan</h2></div>
        <p class="bio">{{ $profil?->nama_lengkap }} menjabat sebagai {{ $profil?->jabatan }} Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia periode {{ $profil?->periode }}.</p>
        <div class="dl">
          <div><small>Jabatan</small><b>{{ $profil?->jabatan }}</b></div>
          <div><small>Unit kerja</small><b>{{ $profil?->unit_kerja }}</b></div>
          <div><small>Periode</small><b>{{ $profil?->periode }}</b></div>
          <div><small>Masa jabatan</small><b>{{ $profil?->masa_jabatan }}</b></div>
          <div><small>Status</small><b>{{ $profil?->status }}</b></div>
        </div>
      </section>

      <section aria-labelledby="s2">
        <div class="sh"><span>03</span><h2 id="s2">Tugas dan Tanggung Jawab</h2></div>
        <ol class="tg">
          <li><b>01</b><span>{{ $profil?->tugas_tanggung_jawab ?: 'Memimpin dan mengoordinasikan kerja komisi sesuai pembagian tugas.' }}</span></li>
          <li><b>02</b><span>Melaporkan hasil kerja komisi pada Sidang Pleno DPM UII.</span></li>
          <li><b>03</b><span>Berkoordinasi dengan pimpinan dan alat kelengkapan dewan terkait.</span></li>
        </ol>
      </section>

      <section aria-labelledby="s3">
        <div class="sh"><span>04</span><h2 id="s3">Sosial Media dan Kontak</h2></div>
        <div class="ct">
          @if($profil?->instagram)
          <a href="{{ $profil->instagram }}" target="_blank" rel="noopener">
            <svg viewBox="0 0 448 512"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></path></svg>
            <small>Instagram</small><b>{{ '@' . \Illuminate\Support\Str::afterLast(rtrim($profil->instagram, '/'), '/') }}</b>
          </a>
          @endif
          @if($profil?->email)
          <a href="mailto:{{ $profil->email }}" target="_blank" rel="noopener">
            <svg viewBox="0 0 512 512"><path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176v208c0 35.3 28.7 64 64 64h384c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg>
            <small>Email</small><b>{{ $profil->email }}</b>
          </a>
          @endif
        </div>
      </section>
    </div>
  </div>
</section>
@endsection



