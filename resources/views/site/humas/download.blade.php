@extends('layouts.site')

@section('title', 'Unduh Font dan Template — '.($siteSettings['site_name'] ?? 'DPM UII'))
@section('meta_description', 'Aset brand resmi DPM UII untuk keperluan dokumen internal. Gunakan font dan template standar agar identitas visual organisasi tetap konsisten.')

@push('styles')
<style>
  .pg-head { position: relative; overflow: hidden; border-bottom: 1px solid var(--b-default); padding: 56px 0 64px;
    background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%); }
  .pg-head::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 28px); }
  .hero-grid { position: relative; display: grid; grid-template-columns: 1.2fr .8fr; gap: 40px; align-items: center; }
  .crumb { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 28px; font-size: 12.5px; color: var(--t-cap); }
  .crumb a { transition: color .2s; } .crumb a:hover { color: var(--white); }
  .crumb span[aria-hidden] { opacity: .5; }
  .crumb span[aria-current] { color: var(--white); font-weight: 600; }
  .pg-head h1 { font-size: clamp(34px, 5.6vw, 62px); letter-spacing: -1.6px; line-height: 1.06; margin-bottom: 18px; }
  .pg-desc { max-width: 580px; margin-bottom: 28px; font-size: 16px; color: var(--t-sub); }
  .hero-btns { display: flex; gap: 10px; flex-wrap: wrap; }
  .hero-art { display: flex; justify-content: flex-end; }
  .hero-art svg { width: min(100%, 460px); height: auto; }

  .dl-sec { padding: 56px 0 24px; }
  .dl-grid { display: grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap: 24px; }
  .dl-card { display: flex; flex-direction: column; border: 1px solid var(--b-btn); border-radius: 12px; background: var(--navy-card); overflow: hidden; transition: border-color .2s, box-shadow .2s; }
  .dl-card:hover { border-color: var(--b-btn-hover); box-shadow: var(--sh-md); }
  .dl-view { position: relative; height: 240px; display: grid; place-items: center; border-bottom: 1px solid var(--b-default); background: linear-gradient(135deg, #002A5A 0%, #001A3A 75%); overflow: hidden; }
  .dl-view::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, rgba(255,255,255,.035) 0 1px, transparent 1px 26px); }
  .dl-view .cap { position: absolute; left: 16px; bottom: 12px; font-size: 11px; letter-spacing: .8px; color: var(--t-cap); }
  .spec { position: relative; text-align: center; font-family: 'Wix Madefor Display', sans-serif; }
  .spec b { display: block; font-size: 112px; font-weight: 800; line-height: 1; letter-spacing: -4px; color: var(--white); }
  .spec span { display: block; margin-top: 10px; font-size: 13px; letter-spacing: 6px; color: var(--t-sub); }
  .paper { position: relative; width: 170px; height: 208px; margin-top: 32px; padding: 16px 16px; border: 1px solid var(--b-btn-hover); border-radius: 6px 6px 0 0; background: #fff; box-shadow: var(--sh-lg); transform: rotate(-3deg); }
  .paper i { display: block; height: 4px; margin-bottom: 7px; border-radius: 2px; background: #cfd6e0; }
  .paper .hd { display: flex; align-items: center; gap: 8px; padding-bottom: 8px; margin-bottom: 12px; border-bottom: 2px solid var(--navy); }
  .paper .hd u { width: 22px; height: 22px; border-radius: 4px; background: var(--navy); }
  .paper .hd i { flex: 1; margin: 0; background: #98a4b6; }
  .paper .w60 { width: 60%; } .paper .w80 { width: 80%; } .paper .w40 { width: 40%; margin-top: 16px; background: #98a4b6; }
  .dl-b { display: flex; flex-direction: column; flex: 1; padding: 26px 28px 28px; }
  .dl-t { font-size: 11px; font-weight: 600; letter-spacing: 1.8px; text-transform: uppercase; color: var(--t-cap); }
  .dl-b h2 { margin: 6px 0 10px; font-size: 26px; letter-spacing: -.6px; }
  .dl-b > p { font-size: 15px; line-height: 1.8; color: var(--t-body); }
  .chips2 { display: flex; flex-wrap: wrap; gap: 8px; margin: 18px 0 24px; }
  .chips2 span { padding: 4px 12px; border: 1px solid var(--b-btn); border-radius: 100px; font-size: 12.5px; font-weight: 600; color: var(--t-sub); }
  .dl-b .btn { margin-top: auto; width: 100%; height: 48px; gap: 10px; }
  .dl-b .btn svg { width: 18px; height: 18px; transform: none !important; }

  .guide { padding: 48px 0 88px; }
  .guide-h { margin-bottom: 24px; }
  .guide-h h2 { font-size: clamp(26px, 3.2vw, 38px); letter-spacing: -.9px; }
  .guide-h p { margin-top: 8px; font-size: 14.5px; color: var(--t-cap); }
  .gx { display: grid; grid-template-columns: 300px minmax(0,1fr); border: 1px solid var(--b-btn); border-radius: 12px; background: var(--navy-card); overflow: hidden; }
  .gx-tabs { display: grid; align-content: start; border-right: 1px solid var(--b-default); background: var(--navy-footer); }
  .gx-tabs button { text-align: left; padding: 18px 22px; border: 0; border-bottom: 1px solid var(--b-default); background: transparent; color: var(--t-cap); font: inherit; cursor: pointer; transition: background .2s, color .2s; }
  .gx-tabs button:last-child { border-bottom: 0; }
  .gx-tabs button:hover { background: var(--bg-hover); color: var(--white); }
  .gx-tabs button[aria-selected="true"] { background: var(--navy-hover); color: var(--white); box-shadow: inset 3px 0 0 var(--white); }
  .gx-tabs b { display: block; font-family: 'Wix Madefor Display', sans-serif; font-size: 16px; color: inherit; }
  .gx-tabs small { font-size: 12.5px; }
  .gx-p { padding: 30px 34px 34px; }
  .gx-p[hidden] { display: none; }
  .gx-p h3 { margin-bottom: 18px; font-size: 20px; }
  .gx-p ol { list-style: none; padding: 0; display: grid; gap: 16px; counter-reset: g; }
  .gx-p li { position: relative; padding-left: 46px; font-size: 15px; line-height: 1.8; color: var(--t-body); counter-increment: g; }
  .gx-p li::before { content: counter(g); position: absolute; left: 0; top: 0; width: 30px; height: 30px; display: grid; place-items: center; border: 1px solid var(--b-btn); border-radius: 50%; font-family: 'Wix Madefor Display', sans-serif; font-size: 13px; font-weight: 800; color: var(--white); }
  .gx-p code { padding: 2px 8px; border: 1px solid var(--b-default); border-radius: 6px; background: var(--navy); font-size: 13px; color: var(--white); }
  .gx-p strong { color: var(--white); }

  @media (max-width: 1080px) {
    .hero-grid { grid-template-columns: 1fr; }
    .hero-art { display: none; }
    .gx { grid-template-columns: minmax(0,1fr); }
    .gx-tabs { grid-auto-flow: column; grid-auto-columns: minmax(150px,1fr); overflow-x: auto; border-right: 0; border-bottom: 1px solid var(--b-default); }
    .gx-tabs button { border-bottom: 0; border-right: 1px solid var(--b-default); }
    .gx-tabs button[aria-selected="true"] { box-shadow: inset 0 -3px 0 var(--white); }
  }
  @media (max-width: 720px) {
    .pg-head { padding: 36px 0 44px; }
    .dl-grid { grid-template-columns: minmax(0,1fr); }
    .dl-b, .gx-p { padding-left: 20px; padding-right: 20px; }
    .dl-view { height: 210px; }
    .spec b { font-size: 90px; }
  }
</style>
@endpush

@section('content')
<section class="pg-head">
  <div class="container hero-grid">
    <div>
      <nav class="crumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <span aria-hidden="true">/</span>
        <a href="{{ route('humas.sosialisasi') }}">Sosialisasi</a>
        <span aria-hidden="true">/</span>
        <span aria-current="page">Unduh Font dan Template</span>
      </nav>
      <span class="eyebrow">Humas DPM UII</span>
      <h1>Unduh Font dan Template</h1>
      <p class="pg-desc">Aset brand resmi DPM UII untuk keperluan dokumen internal. Gunakan font dan template standar agar identitas visual organisasi tetap konsisten.</p>
      <div class="hero-btns">
        <a class="btn" href="#aset">Lihat Aset</a>
        <a class="btn" href="#panduan">Panduan Penggunaan</a>
      </div>
    </div>
    <div class="hero-art" aria-hidden="true">
      <svg viewBox="0 0 460 300" role="img" aria-label="Berkas unduhan">
        <g fill="none" stroke="#fff" stroke-linejoin="round" stroke-linecap="round">
          <path d="M120 40h130l60 60v160H120z" fill="#002451" stroke-opacity=".9" stroke-width="1.6"/>
          <path d="M250 40v60h60" stroke-opacity=".6"/>
          <path d="M150 190l22-60 22 60M158 170h28" stroke-opacity=".8" stroke-width="2"/>
          <path d="M230 150h50M230 176h50M150 222h130" stroke-opacity=".35"/>
          <circle cx="350" cy="214" r="38" fill="#001A3A" stroke-opacity=".8"/>
          <path d="M350 196v30m-14-12l14 14 14-14" stroke-width="2.2"/>
        </g>
      </svg>
    </div>
  </div>
</section>

<section class="dl-sec" id="aset">
  <div class="container">
    <div class="dl-grid">
      <article class="dl-card">
        <div class="dl-view">
          <div class="spec" aria-hidden="true">
            <b>Aa</b>
            <span>ABCDEFG 0123</span>
          </div>
          <span class="cap">Ilustrasi</span>
        </div>
        <div class="dl-b">
          <span class="dl-t">Font Resmi</span>
          <h2>UII Font</h2>
          <p>Font resmi identitas visual UII untuk dokumen dan publikasi DPM UII.</p>
          <div class="chips2">
            <span>.ttf</span>
            <span>{{ $files[0]['size'] ?? '56 KB' }}</span>
            <span>Windows dan Mac</span>
          </div>
          <a class="btn" href="{{ route('publikasi.download.file', 'UII Font.ttf') }}" download>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 16v1a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            <span>Unduh UII Font</span>
          </a>
        </div>
      </article>

      <article class="dl-card">
        <div class="dl-view">
          <div class="paper" aria-hidden="true">
            <div class="hd"><u></u><i></i></div>
            <i class="w60"></i><i></i><i></i><i class="w80"></i><i></i><i class="w40"></i><i class="w60"></i>
          </div>
          <span class="cap">Ilustrasi</span>
        </div>
        <div class="dl-b">
          <span class="dl-t">Template Dokumen</span>
          <h2>Template Surat</h2>
          <p>Format surat resmi DPM UII yang siap diisi untuk keperluan administrasi internal.</p>
          <div class="chips2">
            <span>.docx</span>
            <span>{{ $files[1]['size'] ?? '6 KB' }}</span>
            <span>Word dan LibreOffice</span>
          </div>
          <a class="btn" href="{{ route('publikasi.download.file', 'template-surat.docx') }}" download>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 16v1a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            <span>Unduh Template Surat</span>
          </a>
        </div>
      </article>
    </div>
  </div>
</section>

<section class="guide" id="panduan">
  <div class="container">
    <div class="guide-h">
      <h2>Panduan penggunaan</h2>
      <p>Pilih topik untuk melihat langkahnya.</p>
    </div>
    <div class="gx">
      <div class="gx-tabs" role="tablist" aria-label="Panduan" aria-orientation="vertical">
        <button role="tab" id="t-win" aria-selected="true" aria-controls="p-win" type="button"><b>Font di Windows</b><small>Pasang UII Font</small></button>
        <button role="tab" id="t-mac" aria-selected="false" aria-controls="p-mac" type="button"><b>Font di Mac</b><small>Pasang UII Font</small></button>
        <button role="tab" id="t-surat" aria-selected="false" aria-controls="p-surat" type="button"><b>Template Surat</b><small>Mengisi dan menyimpan</small></button>
        <button role="tab" id="t-konsis" aria-selected="false" aria-controls="p-konsis" type="button"><b>Konsistensi</b><small>Kapan memakai aset ini</small></button>
      </div>
      <div>
        <div class="gx-p" id="p-win" role="tabpanel" aria-labelledby="t-win">
          <h3>Memasang font di Windows</h3>
          <ol>
            <li>Unduh berkas <code>UII Font.ttf</code> dari kartu di atas.</li>
            <li>Klik kanan berkas tersebut, lalu pilih <strong>Install</strong>.</li>
            <li>Tutup lalu buka kembali Word atau aplikasi lain agar font muncul di daftar.</li>
          </ol>
        </div>
        <div class="gx-p" id="p-mac" role="tabpanel" aria-labelledby="t-mac" hidden>
          <h3>Memasang font di Mac</h3>
          <ol>
            <li>Unduh berkas <code>UII Font.ttf</code>.</li>
            <li>Klik dua kali berkas, lalu pilih <strong>Install Font</strong> pada jendela Font Book.</li>
            <li>Buka ulang aplikasi yang sedang berjalan agar font terbaca.</li>
          </ol>
        </div>
        <div class="gx-p" id="p-surat" role="tabpanel" aria-labelledby="t-surat" hidden>
          <h3>Memakai template surat</h3>
          <ol>
            <li>Buka <code>template-surat.docx</code> dengan Microsoft Word atau LibreOffice.</li>
            <li>Ganti bagian yang diberi tanda kurung <code>[...]</code> dengan data yang sesuai.</li>
            <li>Pastikan UII Font sudah terpasang sebelum mengetik agar tampilan surat sesuai.</li>
            <li>Simpan salinan dengan nama baru, jangan menimpa berkas template.</li>
          </ol>
        </div>
        <div class="gx-p" id="p-konsis" role="tabpanel" aria-labelledby="t-konsis" hidden>
          <h3>Menjaga konsistensi</h3>
          <ol>
            <li>Selalu gunakan font dan template ini untuk <strong>surat resmi, SK, dan dokumen internal</strong> DPM UII.</li>
            <li>Jangan mengubah tata letak kop atau jenis font pada template.</li>
            <li>Butuh aset lain atau ada kendala? Hubungi Humas DPM UII melalui kontak di bagian bawah halaman.</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
  (function () {
    const tabs = [...document.querySelectorAll('.gx-tabs [role=tab]')];
    function show(t) {
      tabs.forEach(b => {
        const on = b === t;
        b.setAttribute('aria-selected', on);
        const panel = document.getElementById(b.getAttribute('aria-controls'));
        if (panel) panel.hidden = !on;
      });
    }
    tabs.forEach((t, i) => {
      t.addEventListener('click', () => show(t));
      t.addEventListener('keydown', e => {
        if (!['ArrowDown','ArrowUp','ArrowLeft','ArrowRight'].includes(e.key)) return;
        e.preventDefault();
        const n = tabs[(i + (['ArrowDown','ArrowRight'].includes(e.key) ? 1 : -1) + tabs.length) % tabs.length];
        n.focus();
        show(n);
      });
    });
  })();
</script>
@endpush
