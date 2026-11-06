@extends('layouts.site')

@section('title', 'Sosialisasi Peraturan — '.($siteSettings['site_name'] ?? 'DPM UII'))
@section('meta_description', 'Panduan mudah memahami peraturan KM UII: PDKM, GBHKM, PKM, dan PDPM untuk mahasiswa UII.')

@push('styles')
<style>
  /* ============ SOSIALISASI PERATURAN ============ */
  .sos-page [id] { scroll-margin-top: 110px; }
  .sos-page :focus-visible { outline: 2px solid var(--white); outline-offset: 2px; }

  /* hero */
  .sos-page .pg-head { position: relative; overflow: hidden; border-bottom: 1px solid var(--b-default); padding: 56px 0 64px;
    background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%); }
  .sos-page .pg-head::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 28px); }
  .sos-page .hero-grid { position: relative; display: grid; grid-template-columns: 1.2fr .8fr; gap: 40px; align-items: center; }
  .sos-page .crumb { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 28px; font-size: 12.5px; color: var(--t-cap); }
  .sos-page .crumb a { transition: color .2s; }
  .sos-page .crumb a:hover { color: var(--white); }
  .sos-page .crumb span[aria-hidden] { opacity: .5; }
  .sos-page .crumb span[aria-current] { color: var(--white); font-weight: 600; }
  .sos-page .pg-head h1 { font-size: clamp(34px, 5.6vw, 62px); letter-spacing: -1.6px; line-height: 1.06; margin-bottom: 18px; }
  .sos-page .pg-desc { max-width: 620px; margin-bottom: 0; font-size: 16px; color: var(--t-sub); }
  .sos-page .hero-art { display: flex; justify-content: flex-end; }
  .sos-page .hero-art svg { width: min(100%, 420px); height: auto; }

  /* intro */
  .sos-page .intro { padding: 64px 0; border-bottom: 1px solid var(--b-default); background: var(--navy-card); }
  .sos-page .intro .container { display: grid; grid-template-columns: 1fr 1.2fr; gap: 48px; align-items: start; }
  .sos-page .intro h2 { font-size: clamp(26px, 3.4vw, 38px); letter-spacing: -1px; line-height: 1.2; }
  .sos-page .intro p { font-size: 16px; line-height: 1.9; color: var(--t-sub); }
  .sos-page .intro p + p { margin-top: 14px; }
  .sos-page .intro strong { color: var(--white); }
  .sos-page .chips { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 22px; }
  .sos-page .chips a { padding: 7px 14px; border: 1px solid var(--b-btn); border-radius: 100px; font-size: 13px; font-weight: 600; transition: background .2s, border-color .2s; }
  .sos-page .chips a:hover { background: var(--navy-hover); border-color: var(--b-btn-hover); }

  /* sections */
  .sos-page .sec { padding: 72px 0; border-bottom: 1px solid var(--b-default); }
  .sos-page .sec-h { margin-bottom: 32px; }
  .sos-page .sec-h h2 { font-size: clamp(26px, 3.2vw, 38px); letter-spacing: -.9px; }
  .sos-page .sec-h p { margin-top: 8px; font-size: 14.5px; color: var(--t-cap); }

  /* kartu peraturan */
  .sos-page .rgrid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px; }
  .sos-page .rc { display: flex; flex-direction: column; border: 1px solid var(--b-btn); border-radius: 12px; background: var(--navy-card); overflow: hidden; transition: border-color .2s, box-shadow .2s; }
  .sos-page .rc:hover, .sos-page .rc:target { border-color: var(--b-btn-hover); box-shadow: var(--sh-md); }
  .sos-page .rc-h { position: relative; display: flex; gap: 18px; align-items: center; padding: 26px 28px; border-bottom: 1px solid var(--b-default); background: linear-gradient(135deg, #002A5A 0%, #001A3A 75%); }
  .sos-page .rc-no { flex: none; width: 48px; height: 48px; display: grid; place-items: center; border: 1px solid var(--b-btn); border-radius: 8px; font-family: 'Wix Madefor Display', sans-serif; font-size: 20px; font-weight: 800; }
  .sos-page .rc-t { display: block; margin-bottom: 4px; font-size: 11px; font-weight: 600; letter-spacing: 1.6px; text-transform: uppercase; color: var(--t-cap); }
  .sos-page .rc-h h3 { font-size: 28px; letter-spacing: -.8px; line-height: 1.1; }
  .sos-page .rc-h p { margin-top: 4px; font-size: 13.5px; color: var(--t-sub); }
  .sos-page .rc-b { display: flex; flex-direction: column; flex: 1; padding: 24px 28px 28px; }
  .sos-page .rc-d { font-size: 15px; line-height: 1.8; color: var(--t-body); }
  .sos-page .rc-a { margin: 18px 0 22px; padding: 16px 20px; border-left: 2px solid var(--b-btn-hover); border-radius: 0 8px 8px 0; background: rgba(255,255,255,.04); font-size: 14.5px; line-height: 1.75; }
  .sos-page .rc-b h4 { margin-bottom: 10px; font-size: 11.5px; font-weight: 600; letter-spacing: 1.8px; text-transform: uppercase; color: var(--t-cap); }
  .sos-page .rc-b ul { list-style: none; padding: 0; margin: 0 0 26px; display: grid; gap: 10px; }
  .sos-page .rc-b li { position: relative; padding-left: 22px; font-size: 14px; line-height: 1.7; color: var(--t-body); }
  .sos-page .rc-b li::before { content: ''; position: absolute; left: 2px; top: 10px; width: 6px; height: 6px; border-radius: 50%; background: var(--white); opacity: .7; }
  .sos-page .rc-l { margin-top: auto; width: 100%; justify-content: center; gap: 10px; }
  .sos-page .rc-l svg { width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

  /* hierarki */
  .sos-page .hier { background: var(--navy-card); }
  .sos-page .steps { list-style: none; padding: 0; margin: 0 auto; max-width: 900px; display: grid; gap: 14px; }
  .sos-page .hs { display: grid; grid-template-columns: 110px 1fr; gap: 20px; align-items: center; padding: 20px 24px; margin-left: calc(var(--i) * 36px); border: 1px solid var(--b-btn); border-radius: 12px; background: var(--navy); position: relative; }
  .sos-page .hs:not(:last-child)::after { content: ''; position: absolute; left: 54px; bottom: -15px; width: 1px; height: 15px; background: var(--b-btn-hover); }
  .sos-page .hs-lv { font-size: 11px; font-weight: 600; letter-spacing: 1.6px; text-transform: uppercase; color: var(--t-cap); }
  .sos-page .hs h3 { font-size: 19px; }
  .sos-page .hs h3 small { margin-left: 8px; font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500; color: var(--t-cap); }
  .sos-page .hs p { margin-top: 4px; font-size: 14px; line-height: 1.7; color: var(--t-sub); }
  .sos-page .golden { max-width: 900px; margin: 28px auto 0; padding: 22px 26px; text-align: center; border: 1px solid var(--b-btn); border-radius: 12px; }
  .sos-page .golden b { font-family: 'Wix Madefor Display', sans-serif; font-size: 17px; }
  .sos-page .golden p { margin-top: 6px; font-size: 14.5px; color: var(--t-sub); }
  .sos-page .golden code { display: block; margin-top: 12px; font-size: 13px; letter-spacing: 1px; color: var(--t-cap); }

  /* faq */
  .sos-page .faq { max-width: 900px; display: grid; gap: 10px; }
  .sos-page .faq details { border: 1px solid var(--b-btn); border-radius: 8px; background: var(--navy-card); }
  .sos-page .faq summary { list-style: none; cursor: pointer; display: flex; justify-content: space-between; align-items: center; gap: 16px; padding: 18px 22px; font-family: 'Wix Madefor Display', sans-serif; font-size: 16px; font-weight: 700; }
  .sos-page .faq summary::-webkit-details-marker { display: none; }
  .sos-page .faq summary:hover { background: var(--bg-hover); }
  .sos-page .faq summary i { flex: none; width: 10px; height: 10px; border-right: 2px solid currentColor; border-bottom: 2px solid currentColor; transform: rotate(45deg); transition: transform .2s; }
  .sos-page .faq details[open] summary i { transform: rotate(225deg); }
  .sos-page .faq details > div { padding: 0 22px 20px; font-size: 15px; line-height: 1.8; color: var(--t-body); }

  @media (max-width: 1080px) {
    .sos-page .hero-grid { grid-template-columns: 1fr; }
    .sos-page .hero-art { display: none; }
    .sos-page .intro .container { grid-template-columns: minmax(0, 1fr); gap: 20px; }
    .sos-page .rgrid { grid-template-columns: minmax(0, 1fr); }
  }
  @media (max-width: 720px) {
    .sos-page .pg-head { padding: 36px 0 44px; }
    .sos-page .sec, .sos-page .intro { padding: 48px 0; }
    .sos-page .rc-h, .sos-page .rc-b { padding-left: 20px; padding-right: 20px; }
    .sos-page .hs { grid-template-columns: minmax(0, 1fr); gap: 6px; margin-left: calc(var(--i) * 12px); }
    .sos-page .hs:not(:last-child)::after { left: 30px; }
  }
  @media (prefers-reduced-motion: reduce) { .sos-page * { transition: none !important; } }
</style>
@endpush

@section('content')
<div class="sos-page">
  <!-- ================= PAGE HEADER ================= -->
  <section class="pg-head">
    <div class="container hero-grid">
      <div>
        <nav class="crumb" aria-label="Breadcrumb">
          <a href="{{ route('home') }}">Beranda</a><span aria-hidden="true">/</span>
          <span aria-current="page">Sosialisasi Peraturan</span>
        </nav>
        <span class="eyebrow">Humas DPM UII</span>
        <h1>Sosialisasi Peraturan</h1>
        <p class="pg-desc">Memahami peraturan KM UII tidak harus rumit. Di sini kami jelaskan PDKM, GBHKM, PKM, dan PDPM dengan bahasa yang ringan dan mudah dicerna untuk semua mahasiswa UII.</p>
      </div>
      <div class="hero-art">
        <svg viewBox="0 0 460 340" role="img" aria-label="Empat tingkat peraturan KM UII">
          <g fill="none" stroke="#fff" stroke-linejoin="round">
            <g stroke-opacity=".9"><path d="M230 28 L330 62 L230 96 L130 62 Z" fill="#002451" stroke-width="1.6"/></g>
            <path d="M130 62 V84 L230 118 L330 84 V62" fill="#001A3A" stroke-opacity=".7" stroke-width="1.4"/>
            <path d="M230 96 V118" stroke-opacity=".4"/>
            <path d="M230 112 L350 152 L230 192 L110 152 Z" fill="#001A3A" stroke-opacity=".7" stroke-width="1.4"/>
            <path d="M110 152 V172 L230 212 L350 172 V152" fill="#001633" stroke-opacity=".5" stroke-width="1.2"/>
            <path d="M230 206 L370 250 L230 294 L90 250 Z" fill="#001633" stroke-opacity=".5" stroke-width="1.2"/>
            <path d="M90 250 V268 L230 312 L370 268 V250" fill="#001E43" stroke-opacity=".35" stroke-width="1.1"/>
            <path d="M410 40 V300" stroke-opacity=".25" stroke-dasharray="3 6"/>
            <path d="M404 290 L410 300 L416 290" stroke-opacity=".4"/>
          </g>
          <g fill="#fff" font-family="Wix Madefor Display, Inter, sans-serif" font-weight="800" text-anchor="middle" font-size="13" letter-spacing="1.5">
            <text x="230" y="66" fill-opacity=".95">PDKM</text>
            <text x="230" y="157" fill-opacity=".8">GBHKM</text>
            <text x="230" y="254" fill-opacity=".62" font-size="13">PKM · PDPM</text>
          </g>
        </svg>
      </div>
    </div>
  </section>

  <!-- ================= PENGANTAR ================= -->
  <section class="intro" id="pengantar">
    <div class="container">
      <div>
        <h2>Kenapa perlu tahu peraturan?</h2>
        <div class="chips">
          <a href="#pdkm">PDKM</a><a href="#gbhkm">GBHKM</a><a href="#pkm">PKM</a><a href="#pdpm">PDPM</a><a href="#hierarki">Hierarki</a><a href="#faq">Tanya jawab</a>
        </div>
      </div>
      <div>
        <p>Peraturan bukan sekadar “buku aturan kaku”, tetapi <strong>pedoman hidup bersama</strong> di KM UII. Tahu peraturan berarti kamu tahu <strong>hak</strong>, <strong>kewajiban</strong>, dan <strong>cara berorganisasi</strong> yang benar.</p>
        <p>Di halaman ini kami pecah empat peraturan utama KM UII dengan bahasa sehari-hari, lengkap dengan analogi dan poin penting yang perlu diketahui mahasiswa UII.</p>
      </div>
    </div>
  </section>

  <!-- ================= EMPAT PERATURAN ================= -->
  <section class="sec" id="peraturan">
    <div class="container">
      <div class="sec-h">
        <h2>Empat peraturan utama</h2>
        <p>Urut dari tingkat tertinggi. Tiap kartu menuju arsip lengkapnya.</p>
      </div>
      <div class="rgrid">
        @foreach ($regulations as $reg)
          <article class="rc" id="{{ $reg['slug'] }}">
            <header class="rc-h">
              <span class="rc-no" aria-hidden="true">{{ $loop->iteration }}</span>
              <div>
                <span class="rc-t">{{ $reg['type'] ?? 'Peraturan' }}</span>
                <h3>{{ $reg['title'] }}</h3>
                <p>{{ $reg['full'] }}</p>
              </div>
            </header>
            <div class="rc-b">
              <p class="rc-d">{{ $reg['description'] }}</p>
              <p class="rc-a">{{ $reg['simpleExplanation'] }}</p>
              <h4>Poin penting</h4>
              <ul>
                @foreach ((array) $reg['keyPoints'] as $point)
                  <li>{{ $point }}</li>
                @endforeach
              </ul>
              <a class="btn rc-l" href="{{ route('legal-products.type', $reg['slug']) }}">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h6"/></svg>
                <span>Lihat arsip lengkap</span>
              </a>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </section>

  <!-- ================= HIERARKI ================= -->
  <section class="sec hier" id="hierarki">
    <div class="container">
      <div class="sec-h">
        <h2>Hierarki peraturan KM UII</h2>
        <p>Semakin ke bawah, semakin teknis.</p>
      </div>
      <ol class="steps">
        <li class="hs" style="--i:0">
          <span class="hs-lv">Tingkat 1</span>
          <div><h3>PDKM <small>Konstitusi</small></h3><p>Dasar hukum tertinggi. Mengatur asas dan struktur fundamental KM UII.</p></div>
        </li>
        <li class="hs" style="--i:1">
          <span class="hs-lv">Tingkat 2</span>
          <div><h3>GBHKM <small>Arah kebijakan</small></h3><p>Peta jalan gerak organisasi dan acuan penyusunan program kerja.</p></div>
        </li>
        <li class="hs" style="--i:2">
          <span class="hs-lv">Tingkat 3</span>
          <div><h3>PKM <small>Peraturan teknis</small></h3><p>Mengatur detail teknis yang mengikat anggota dan lembaga: dana, kegiatan, pemilu, organisasi.</p></div>
        </li>
        <li class="hs" style="--i:3">
          <span class="hs-lv">Tingkat 4</span>
          <div><h3>PDPM <small>Aturan internal DPM</small></h3><p>Tata tertib sidang dan pelaksanaan fungsi legislasi, anggaran, dan pengawasan DPM UII.</p></div>
        </li>
      </ol>
      <div class="golden">
        <b>Aturan emas</b>
        <p>Peraturan di tingkat bawah tidak boleh bertentangan dengan tingkat di atasnya.</p>
        <code>PDKM &gt; GBHKM &gt; PKM &gt; PDPM</code>
      </div>
    </div>
  </section>

  <!-- ================= FAQ ================= -->
  <section class="sec" id="faq">
    <div class="container">
      <div class="sec-h">
        <h2>Tanya jawab cepat</h2>
      </div>
      <div class="faq">
        <details>
          <summary>Mana yang paling atas?<i aria-hidden="true"></i></summary>
          <div><strong>PDKM.</strong> Ia konstitusi KM UII, dan semua peraturan lain harus turun dari PDKM.</div>
        </details>
        <details>
          <summary>PKM dan PDPM bedanya apa?<i aria-hidden="true"></i></summary>
          <div><strong>PKM</strong> mengikat seluruh KM UII dan dibentuk DPM UII bersama Ketua LEM UII. <strong>PDPM</strong> dibuat dan disahkan DPM UII sendiri, untuk mengatur urusan internal DPM.</div>
        </details>
        <details>
          <summary>Apakah GBHKM berubah tiap periode?<i aria-hidden="true"></i></summary>
          <div>GBHKM disusun dan disahkan DPM UII lewat Sidang Umum atau Sidang Istimewa KM UII. Periodesasi kepengurusan DPM dan LEM sendiri 12 bulan sejak Sidang Umum.</div>
        </details>
        <details>
          <summary>Peraturan mana yang paling sering dibuka mahasiswa?<i aria-hidden="true"></i></summary>
          <div><strong>PKM.</strong> Ia mengatur hal teknis yang dekat dengan mahasiswa, seperti dana, kegiatan, dan pemilu.</div>
        </details>
        <details>
          <summary>Bagaimana jika sebuah PKM diduga bertentangan dengan PDKM?<i aria-hidden="true"></i></summary>
          <div>Dapat diajukan uji materi (<em>legislative review</em>) ke DPM UII, diusulkan sekurang-kurangnya 50%+1 DPM Fakultas.</div>
        </details>
      </div>
    </div>
  </section>
</div>
@endsection
