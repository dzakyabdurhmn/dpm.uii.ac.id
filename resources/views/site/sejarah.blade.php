@extends('layouts.site')

@section('title', 'Sejarah Keluarga Mahasiswa UII | DPM UII')
@section('meta_description', 'Sejarah Keluarga Mahasiswa Universitas Islam Indonesia: dari Senat Mahasiswa STI hingga sistem Student Government saat ini.')

@push('styles')
<style>
  /* ============ SEJARAH ============ */
  .nav-item.current > a::after { transform: scaleX(1); }
  .mega-links a[aria-current] { background: var(--bg-hover); }
  :focus-visible { outline: 2px solid var(--white); outline-offset: 2px; }
  html { scroll-padding-top: 150px; }

  /* hero */
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
  .meta { display: flex; flex-wrap: wrap; gap: 10px; }
  .meta span { display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; border: 1px solid var(--b-btn); border-radius: 100px; font-size: 12.5px; font-weight: 600; color: var(--white); background: rgba(0,22,51,.5); }
  .meta span small { font-size: 11px; font-weight: 500; letter-spacing: .8px; text-transform: uppercase; color: var(--t-cap); }
  .hero-art { display: flex; justify-content: flex-end; }
  .hero-art svg { width: min(100%, 460px); height: auto; }

  /* timeline header */
  .tlh-wrap { padding: 40px 0; border-bottom: 1px solid var(--b-default); background: var(--navy-footer); }
  .tlh-scroll { overflow-x: auto; }
  .tlh { list-style: none; display: grid; grid-template-columns: repeat(6, minmax(150px, 1fr)); min-width: 900px; position: relative; }
  .tlh::before { content: ''; position: absolute; left: 0; right: 0; top: 8px; height: 1px; background: var(--b-btn); }
  .tlh li { position: relative; padding-top: 28px; padding-right: 16px; }
  .tlh i { position: absolute; left: 0; top: 0; width: 17px; height: 17px; border-radius: 50%; background: var(--navy-footer); border: 2px solid var(--white); }
  .tlh li:nth-child(3) i { background: var(--white); box-shadow: 0 0 0 5px rgba(255,255,255,.15); }
  .tlh b { display: block; margin-bottom: 4px; font-family: 'Wix Madefor Display', sans-serif; font-size: 15px; }
  .tlh span { font-size: 13px; line-height: 1.5; color: var(--t-cap); }
  .tl-hint { display: none; margin-top: 10px; font-size: 12.5px; color: var(--t-cap); }
  .prose { max-width: 740px; }
  .prose > p { margin-bottom: 20px; font-size: 16px; line-height: 1.9; color: var(--t-body); }
  .prose em { font-style: italic; color: var(--white); } .prose strong { color: var(--white); }
  .ph { margin: 40px 0 16px; font-size: 22px; letter-spacing: -.4px; }
  .bq { margin: 28px 0; padding: 24px 28px; border-left: 2px solid var(--b-btn-hover); background: var(--navy-card); border-radius: 0 8px 8px 0; font-family: 'Wix Madefor Display', sans-serif; font-size: 17px; line-height: 1.75; color: var(--white); font-weight: 500; }
  .bq cite { display: block; margin-top: 14px; font-family: 'Inter', sans-serif; font-style: normal; font-size: 12px; font-weight: 600; letter-spacing: 1.4px; text-transform: uppercase; color: var(--t-cap); }
  .dg { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px; margin: 28px 0; }
  .dg div { padding: 18px 20px; border: 1px solid var(--b-btn); border-radius: 8px; background: var(--navy-card); }
  .dg b { display: block; margin-bottom: 4px; font-family: 'Wix Madefor Display', sans-serif; font-size: 18px; }
  .dg span { font-size: 13.5px; line-height: 1.55; color: var(--t-sub); }
  .pl { margin: 0 0 22px; padding-left: 0; list-style: none; counter-reset: n; }
  .pl li { position: relative; padding: 10px 0 10px 28px; font-size: 15.5px; line-height: 1.75; color: var(--t-body); border-bottom: 1px solid var(--b-default); }
  .pl li:last-child { border-bottom: 0; }
  .pl li::before { content: ''; position: absolute; left: 4px; top: 21px; width: 7px; height: 7px; border-radius: 50%; background: var(--white); }
  .pl.num li { counter-increment: n; } .pl.num li::before { content: counter(n); top: 10px; left: 0; width: auto; height: auto; background: none; font-weight: 700; color: var(--t-cap); font-size: 14px; }
  .two { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin: 0 0 24px; }
  .two > div { padding: 22px; border: 1px solid var(--b-default); border-radius: 8px; background: var(--navy-card); }
  .two h4 { margin-bottom: 8px; font-size: 12px; font-weight: 600; letter-spacing: 1.8px; text-transform: uppercase; color: var(--t-cap); font-family: 'Inter', sans-serif; }
  .five { display: grid; gap: 12px; margin-bottom: 28px; }
  .five article { display: grid; grid-template-columns: auto 1fr; column-gap: 20px; padding: 22px 24px; border: 1px solid var(--b-default); border-radius: 8px; background: var(--navy-card); transition: border-color .2s, background .2s; }
  .five article:hover { border-color: var(--b-btn); background: var(--navy-hover); }
  .five b { grid-row: 1 / span 2; font-family: 'Wix Madefor Display', sans-serif; font-size: 30px; font-weight: 800; line-height: 1; color: transparent; -webkit-text-stroke: 1px rgba(255,255,255,.42); }
  .five h4 { margin-bottom: 6px; font-size: 16px; font-family: 'Wix Madefor Display', sans-serif; }
  .five p { font-size: 14.5px; line-height: 1.75; color: var(--t-sub); }

  /* subnav */
  .subnav { position: sticky; top: 73px; z-index: 50; background: rgba(0,22,51,.95); border-bottom: 1px solid var(--b-default); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); }
  .subnav::after { content: ''; position: absolute; left: 0; bottom: -1px; height: 2px; width: calc(var(--p, 0) * 100%); background: var(--white); transition: width .1s linear; }
  .subnav-inner { display: flex; align-items: center; justify-content: space-between; gap: 20px; }
  .subnav ol { list-style: none; display: flex; gap: 4px; padding: 10px 0; overflow-x: auto; scrollbar-width: none; }
  .subnav ol::-webkit-scrollbar { display: none; }
  .subnav li a { display: flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 100px; border: 1px solid transparent; white-space: nowrap; font-size: 13.5px; font-weight: 600; color: var(--t-cap); transition: color .2s, background .2s, border-color .2s; }
  .subnav li a em { font-style: normal; font-size: 11px; opacity: .6; }
  .subnav li a:hover { color: var(--white); }
  .subnav li a[aria-current="true"] { color: var(--white); background: rgba(255,255,255,.10); border-color: rgba(255,255,255,.35); }
  .subnav .btn { flex-shrink: 0; }

  /* band */
  .band { padding: 96px 0; border-bottom: 1px solid var(--b-default); }
  .band.alt { background: var(--navy-footer); }
  .band-grid { display: grid; grid-template-columns: 300px minmax(0, 1fr); gap: 72px; align-items: start; }
  .band-head { position: sticky; top: 150px; }
  .big-no { display: block; margin-bottom: 8px; font-family: 'Wix Madefor Display', sans-serif; font-size: 88px; font-weight: 800; line-height: 1; letter-spacing: -4px; color: transparent; -webkit-text-stroke: 1px rgba(255,255,255,.28); }
  .band-head h2 { margin-bottom: 14px; font-size: clamp(28px, 3.2vw, 38px); letter-spacing: -.9px; line-height: 1.15; }
  .band-head p { font-size: 14.5px; color: var(--t-cap); line-height: 1.75; }

  @media (max-width: 1080px) {
    .hero-grid { grid-template-columns: 1fr; }
    .hero-art { display: none; }
    .band { padding: 72px 0; }
    .band-grid { grid-template-columns: minmax(0, 1fr); gap: 32px; }
    .band-head { position: static; }
    .big-no { font-size: 64px; }
    .subnav .btn { display: none; }
  }
  @media (max-width: 720px) {
    .pg-head { padding: 36px 0 44px; }
    .band { padding: 56px 0; }
    .tlh-wrap { padding: 28px 0; }
    .tl-hint { display: block; }
    .bq { padding: 18px 20px; font-size: 15.5px; }
    .two { grid-template-columns: 1fr; }
    .prose > p { font-size: 15.5px; }
    .five article { grid-template-columns: 1fr; }
    .five b { grid-row: auto; margin-bottom: 8px; }
  }
  @media (prefers-reduced-motion: reduce) { .reveal { opacity: 1; transform: none; } }
</style>
@endpush

@section('content')
<!-- ================= PAGE HEADER ================= -->
<section class="pg-head">
  <div class="container hero-grid">
    <div>
      <nav class="crumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Beranda</a><span aria-hidden="true">/</span>
        <a href="{{ url('/#fungsi') }}">Tentang</a><span aria-hidden="true">/</span>
        <span aria-current="page">Sejarah</span>
      </nav>
      <span class="eyebrow">Tentang DPM UII</span>
      <h1>Sejarah Keluarga Mahasiswa UII</h1>
      <p class="pg-desc">Perjalanan lembaga kemahasiswaan Universitas Islam Indonesia, dari Senat Mahasiswa STI hingga sistem student government yang berjalan hari ini.</p>
      <div class="meta">
        <span><small>STI berdiri</small> 1945</span>
        <span><small>KM UII lahir</small> 21 Sep 1950</span>
      </div>
    </div>
    <div class="hero-art">
      <svg viewBox="0 0 640 520" fill="none" stroke="rgba(255,255,255,0.42)" stroke-width="1.6" stroke-linejoin="round" aria-hidden="true">
        <defs><g id="col"><rect x="0" y="0" width="28" height="170"/><path d="M9 6V164M19 6V164" stroke="rgba(255,255,255,0.18)"/><rect x="-6" y="-8" width="40" height="8" fill="rgba(255,255,255,0.09)"/><rect x="-6" y="170" width="40" height="8" fill="rgba(255,255,255,0.09)"/></g></defs>
        <path d="M50 205 L320 62 L590 205 Z" fill="rgba(255,255,255,0.07)"/>
        <path d="M92 195 L320 76 L548 195"/>
        <circle cx="320" cy="150" r="30" fill="rgba(255,255,255,0.09)"/><circle cx="320" cy="150" r="20"/>
        <path d="M320 134 L324 146 L336 146 L326 154 L330 166 L320 159 L310 166 L314 154 L304 146 L316 146 Z" fill="rgba(255,255,255,0.3)" stroke="none"/>
        <rect x="50" y="205" width="540" height="22" fill="rgba(255,255,255,0.09)"/>
        <use href="#col" x="96" y="235"/><use href="#col" x="176" y="235"/><use href="#col" x="256" y="235"/>
        <use href="#col" x="336" y="235"/><use href="#col" x="416" y="235"/><use href="#col" x="496" y="235"/>
        <path d="M70 413 H570M50 433 H590M30 453 H610M10 473 H630"/>
      </svg>
    </div>
  </div>
</section>

<!-- ================= TIMELINE HEADER ================= -->
<section class="tlh-wrap" aria-label="Garis waktu singkat">
  <div class="container">
    <div class="tlh-scroll">
      <ol class="tlh">
        <li><i></i><b>8 Jul 1945</b><span>STI berdiri</span></li>
        <li><i></i><b>10 Apr 1946</b><span>STI pindah ke Yogyakarta</span></li>
        <li><i></i><b>21 Sep 1950</b><span>MPM dan DEMA; lahir KM UII</span></li>
        <li><i></i><b>1978</b><span>NKK; era BKK-KUA</span></li>
        <li><i></i><b>15 Mei 1993</b><span>DPM dan LEM dibentuk</span></li>
        <li><i></i><b>1998</b><span>LEMF dan DPMF</span></li>
      </ol>
    </div>
    <p class="tl-hint">Geser ke samping untuk melihat seluruhnya.</p>
  </div>
</section>

<!-- ================= SUBNAV ================= -->
<div class="subnav" id="subnav">
  <div class="container subnav-inner">
    <ol id="toc">
      <li><a href="#awal"><em>01</em>Awal Mula</a></li>
      <li><a href="#mpm"><em>02</em>MPM dan DEMA</a></li>
      <li><a href="#bkk"><em>03</em>BKK-KUA</a></li>
      <li><a href="#dpm-lem"><em>04</em>DPM-LEM</a></li>
      <li><a href="#realita"><em>05</em>Realita</a></li>
      <li><a href="#sg"><em>06</em>Student Government</a></li>
    </ol>
  </div>
</div>

<!-- ================= 01 AWAL MULA ================= -->
<section class="band" id="awal" aria-labelledby="h-awal">
  <div class="container band-grid">
    <header class="band-head">
      <span class="big-no" aria-hidden="true">01</span>
      <h2 id="h-awal">Awal Mula</h2>
      <p>Sekolah Tinggi Islam dan lahirnya lembaga kemahasiswaan pertama.</p>
    </header>
    <div class="prose">
      <p>Sekolah Tinggi Islam (STI) berdiri pada hari Ahad, 27 Rajab 1364 H, bertepatan dengan 8 Juli 1945, dan kini bernama Universitas Islam Indonesia. Sejak awal, mahasiswa senantiasa memberikan peran positif yang maksimal bagi bangsanya. Pada saat STI berdiri, mahasiswa yang diterima hanya 14 orang dari 78 pendaftar, dan mereka telah membulatkan tekad membangun bangsa dengan ikrar berikut:</p>
      <blockquote class="bq">Kami pelajar-pelajar Sekolah Tinggi Islam di Jakarta, mengikrarkan janji dan membulatkan niat akan menyerahkan segenap tenaga kami dalam menuntut ilmu-ilmu yang diajarkan pada Sekolah Tinggi Islam serta menjunjung tinggi akan akhlak dan budi pekerti Islam, agar kami dengan pertolongan Allah SWT., menjadi muslim Indonesia yang utama dan anggota yang berguna bagi masyarakat Indonesia, sejajar dengan lain-lain bangsa Asia Timur Raya, serta dapatlah menunaikan kewajiban kami sebagai pemimpin Islam Indonesia pada masa yang akan datang sesuai dengan amanat P.J.M. Gunseikan dan tuan Rektor kami.<cite>Ikrar pelajar Sekolah Tinggi Islam</cite></blockquote>
      <p>Seiring kepindahan STI ke Yogyakarta (10 April 1946), mahasiswa terus berkarya dan menjadikan momentum tersebut sebagai kebangkitan mahasiswa STI dengan mendirikan dua lembaga kemahasiswaan: pertama, Senat Mahasiswa STI; kedua, Himpunan Mahasiswa Islam. Senat STI dipimpin oleh Ketua I (Penanggung Jawab Umum) Djanamar Adjam, Ketua II (aktivitas kemasyarakatan dan agama) Amin Syahri, dan Ketua III (kemahasiswaan) Lafran Pane.</p>
      <p>Karena posisinya sebagai ketua yang membidangi kemahasiswaan, Lafran Pane berinisiatif mendirikan Himpunan Mahasiswa Islam, mengingat yang berstudi di STI tidak hanya mahasiswa Islam. Cita-cita Lafran Pane adalah:</p>
      <blockquote class="bq">Sebagai alat mengajak mahasiswa-mahasiswa mempelajari, mendalami ajaran Islam agar mereka kelak sebagai calon sarjana, tokoh masyarakat maupun negarawan, terdapat keseimbangan dunia, akhirat, akal dan qalbu, iman dan ilmu pengetahuan, yang sekarang ini keadaan mahasiswa kemahasiswaan di Indonesia diancam krisis keseimbangan yang sangat membahayakan, karena sistem pendidikan barat.<cite>Lafran Pane</cite></blockquote>
    </div>
  </div>
</section>

<!-- ================= 02 MPM dan DEMA ================= -->
<section class="band alt" id="mpm" aria-labelledby="h-mpm">
  <div class="container band-grid">
    <header class="band-head">
      <span class="big-no" aria-hidden="true">02</span>
      <h2 id="h-mpm">Era MPM dan DEMA</h2>
      <p>Lahirnya student government pada 1950.</p>
    </header>
    <div class="prose">
      <p>Perkembangan senat mahasiswa di tingkat fakultas dinamakan komisariat senat mahasiswa. Selain empat fakultas, yaitu ekonomi, hukum, pendidikan, dan agama, komisariat di fakultas juga ada pada kelas pendahuluan. Karena tata kerja dan struktur yang sempit, pada <strong>21 September 1950</strong> diadakan Sidang Umum yang menghasilkan keputusan membentuk Majelis Permusyawaratan Mahasiswa (MPM) dan Dewan Mahasiswa (DEMA), dengan merujuk pada konsep negara: MPM sebagai lembaga legislatif dan DEMA sebagai lembaga eksekutif.</p>
      <p>Inilah yang dinamakan Student Government, dan tanggal 21 September 1950 diperingati sebagai hari kelahiran Keluarga Mahasiswa Universitas Islam Indonesia.</p>
      <div class="dg">
        <div><b>21 September 1950</b><span>Sidang Umum membentuk MPM dan DEMA; hari lahir KM UII</span></div>
      </div>
      <h3 class="ph">Tugas pokok Dewan Mahasiswa</h3>
      <p>Dewan Mahasiswa mempunyai dua tugas pokok, yaitu ke dalam dan ke luar.</p>
      <div class="two">
        <div>
          <h4>Ke dalam</h4>
          <ul class="pl">
            <li>Memelihara dan mempertinggi mutu mahasiswa dan siswa UII lahir batin;</li>
            <li>Menyalurkan segala tenaga mahasiswa ke arah yang dicita-citakan.</li>
          </ul>
        </div>
        <div>
          <h4>Ke luar</h4>
          <ul class="pl">
            <li>Memberikan bantuan yang sebesar-besarnya kepada instansi-instansi di universitas dalam usahanya menyempurnakan bentuk dan isi universitas;</li>
            <li>Mengadakan hubungan yang erat dengan organisasi-organisasi mahasiswa lain, baik di dalam maupun di luar negeri;</li>
            <li>Mengadakan kerja sama yang erat dengan masyarakat di luar universitas untuk mencapai kesejahteraan dan kebahagiaan lahir dan batin.</li>
          </ul>
        </div>
      </div>
      <p>Pada periode ini peran mahasiswa untuk universitas sangat besar, terlebih dalam mencarikan dosen-dosen yang diperlukan, ikut menggali dana untuk realisasi pembangunan gedung UII, bahkan lembaga mahasiswa juga berperan dalam proses perolehan status disamakan bagi fakultas-fakultas di lingkungan UII. Era ini juga memiliki sejarah penting pada tahun 1960-an, ketika gerakan mahasiswa melahirkan satu angkatan muda terkemuka, yaitu Angkatan 1966, yang bersama militer turut menumbangkan Orde Lama dan membubarkan PKI.</p>
    </div>
  </div>
</section>

<!-- ================= 03 BKK-KUA ================= -->
<section class="band" id="bkk" aria-labelledby="h-bkk">
  <div class="container band-grid">
    <header class="band-head">
      <span class="big-no" aria-hidden="true">03</span>
      <h2 id="h-bkk">Era BKK-KUA</h2>
      <p>Pembekuan Dewan Mahasiswa dan kebijakan NKK.</p>
    </header>
    <div class="prose">
      <p>Sudah lebih dari 20 tahun lembaga kemahasiswaan UII menggunakan konsep student government dengan nama MPM dan DEMA. Namun rintangan menghadang seluruh organisasi kemahasiswaan di Indonesia dengan dikeluarkannya SK Menteri Pendidikan dan Kebudayaan Syarif Thayeb tanggal <strong>23 Januari 1974</strong>, atau dikenal dengan SK 029-74, yang membekukan seluruh kegiatan Dewan Mahasiswa di universitas, perguruan tinggi, dan institut, karena banyaknya gerakan mahasiswa di kampus-kampus di bawah bendera masing-masing Dewan Mahasiswa.</p>
      <p>Menjelang Sidang Umum MPR 1978, suhu politik Indonesia naik dan kampus-kampus di Indonesia (Jakarta, Bandung, Yogyakarta, Surabaya, dan lainnya) dipenuhi aksi demonstrasi di bawah bendera Dewan Mahasiswa masing-masing. Hal ini menyebabkan dikeluarkannya SK Kepala Staf PANGKOPKAMTIB (Panglima Komando Pemulihan Keamanan dan Ketertiban) No. SKEP-02/KOPKAM/I/1978 pada 21 Januari 1978, yang memerintahkan pembekuan kegiatan Dewan Mahasiswa dari semua universitas, perguruan tinggi, dan institut.</p>
      <p>Di Yogyakarta seluruh DEMA bersatu menuntut pemerintah yang dinilai berjalan menyimpang. Akibatnya sebagian mahasiswa ditangkap dan diajukan ke pengadilan. Salah satu mahasiswa UII yang ditahan adalah Maqdir Ismail, mantan ketua departemen ekstern DEMA UII (kini advokat di Jakarta, DR. Maqdir Ismail, S.H., LL.M.).</p>
      <p>Upaya pemerintah menghadapi gejolak tersebut adalah kebijakan Normalisasi Kehidupan Kampus (NKK) melalui SK No. 0156/U/1978 tanggal 19 April 1978, disusul instruksi Direktur Jenderal Pendidikan Tinggi tanggal 17 Mei 1978 Nomor 002/DJ/Inst/1978, yang pada intinya memerintahkan “untuk menata kembali lembaga-lembaga kemahasiswaan di perguruan tinggi sesuai dengan pedoman NKK”. Konsep ini ditolak mahasiswa. Di Daerah Istimewa Yogyakarta, mahasiswa yang diwakili UII, UGM, dan IKIP (UNY) mendatangi DPR RI untuk menolak konsep NKK.</p>
      <p>Di internal UII pun terjadi gerakan penolakan terhadap NKK, namun tidak membuahkan hasil yang diinginkan. Akhirnya, dengan desakan pemerintah dan Koordinator Perguruan Tinggi Swasta (KOPERTIS), Rektor UII mengeluarkan SK No. 718/B.VI/1978 tentang pedoman pelaksanaan NKK di UII yang berisi:</p>
      <ol class="pl num">
        <li>Likuidasi seluruh lembaga kemahasiswaan yang ada di UII;</li>
        <li>Likuidasi dilakukan oleh Majelis Permusyawaratan Mahasiswa (MPM) dan harus selesai paling lambat minggu ketiga bulan Desember 1978;</li>
        <li>Mengadakan pemilu mahasiswa sesuai dengan instruksi Dirjen Perguruan Tinggi.</li>
      </ol>
      <p>Berdasarkan hal tersebut dibentuklah Badan Koordinasi Kemahasiswaan (BKK) dan Koordinator Unit Aktivitas (KUA), masing-masing sebagai pemegang legislatif dan eksekutif. BKK diketuai oleh Pembantu Rektor III dengan anggota Pembantu Dekan di lingkungan UII serta wakil mahasiswa yang terpilih melalui pemilu mahasiswa.</p>
      <div class="dg">
        <div><b>23 Jan 1974</b><span>SK 029-74 membekukan Dewan Mahasiswa</span></div>
        <div><b>21 Jan 1978</b><span>SK PANGKOPKAMTIB SKEP-02/KOPKAM/I/1978</span></div>
        <div><b>19 Apr 1978</b><span>SK No. 0156/U/1978 tentang NKK</span></div>
        <div><b>Des 1978</b><span>Batas likuidasi lembaga kemahasiswaan UII</span></div>
      </div>
    </div>
  </div>
</section>

<!-- ================= 04 DPM-LEM ================= -->
<section class="band alt" id="dpm-lem" aria-labelledby="h-dpm-lem">
  <div class="container band-grid">
    <header class="band-head">
      <span class="big-no" aria-hidden="true">04</span>
      <h2 id="h-dpm-lem">Era DPM-LEM</h2>
      <p>Berdirinya DPM dan LEM sejak 1993.</p>
    </header>
    <div class="prose">
      <p>Pada <strong>15 Mei 1993</strong>, Sidang Umum XXII menghasilkan keputusan dibentuknya <strong>Dewan Permusyawaratan Mahasiswa (DPM)</strong> dan <strong>Lembaga Eksekutif Mahasiswa (LEM)</strong> untuk tingkat universitas, serta <strong>Badan Perwakilan Mahasiswa (BPM)</strong> dan <strong>Senat Mahasiswa Fakultas (SMF)</strong> di tingkat fakultas.</p>
      <p>Pada Sidang Umum XXV tahun <strong>1998</strong> terjadi perubahan nama lembaga mahasiswa pada tingkat fakultas: eksekutif bernama <strong>Lembaga Eksekutif Mahasiswa Fakultas (LEMF)</strong> dan legislatif bernama <strong>Dewan Perwakilan Mahasiswa Fakultas (DPMF)</strong>. Konsep inilah yang bertahan sampai sekarang. Pada tahun 1998 KM UII juga ikut berperan dalam menggulingkan rezim Soeharto dan melahirkan orde reformasi.</p>
      <div class="dg">
        <div><b>15 Mei 1993</b><span>Sidang Umum XXII membentuk DPM dan LEM</span></div>
        <div><b>1998</b><span>Sidang Umum XXV: LEMF dan DPMF; peran dalam Reformasi</span></div>
      </div>
    </div>
  </div>
</section>

<!-- ================= 05 REALITA ================= -->
<section class="band" id="realita" aria-labelledby="h-realita">
  <div class="container band-grid">
    <header class="band-head">
      <span class="big-no" aria-hidden="true">05</span>
      <h2 id="h-realita">Realita Kemahasiswaan</h2>
      <p>Sistem perwakilan dan tantangan yang dihadapi lembaga mahasiswa.</p>
    </header>
    <div class="prose">
      <p>Sejak kebijakan setelah NKK yang dipengaruhi era globalisasi, pendidikan di perguruan tinggi semakin kental dengan sistem kurikulum yang feodalistik. Pertama, materi pembelajaran lebih diperkental daripada aspek pengembangan pikiran. Kedua, lebih mementingkan formalisasi materi daripada substansi materi yang berujung pada pengembangan kepribadian dan identitas individual. Ketiga, tidak menempatkan peserta didik sebagai mitra belajar. Keempat, tidak menghormati nilai-nilai pilihan pribadi pelajar.</p>
      <p>Student Government merupakan konsep pemerintahan dari mahasiswa, oleh mahasiswa, dan untuk mahasiswa. Dari konsep tersebut, Lembaga Legislatif merupakan lembaga mahasiswa tertinggi yang memegang kedaulatan mahasiswa dalam Student Government KM UII, yang disebut Dewan Permusyawaratan Mahasiswa (DPM) pada tingkat universitas dan Dewan Perwakilan Mahasiswa Fakultas (DPMF) pada tingkat fakultas. Dengan lembaga-lembaga tersebut, Keluarga Mahasiswa UII memakai sistem demokrasi tidak langsung atau demokrasi perwakilan, sehingga mahasiswa tidak lagi secara langsung memilih dan meminta pertanggungjawaban Ketua Umum Lembaga Eksekutif Mahasiswa, baik di tingkat universitas maupun fakultas.</p>
      <p>Kehendak mahasiswa untuk menentukan haluan Keluarga Mahasiswa disalurkan kepada wakil-wakilnya yang duduk di DPM UII dan DPMF. Anggota Lembaga Legislatif ini dipilih secara langsung oleh mahasiswa UII melalui Pemilu Mahasiswa. Anggota terpilih kemudian bersidang untuk membentuk pengurus DPM UII/DPMF serta memilih mandataris DPM (Ketua Lembaga Eksekutif Mahasiswa) pada tingkat universitas dan mandataris DPMF (Ketua Lembaga Eksekutif Mahasiswa Fakultas) pada tingkat fakultas.</p>
      <h3 class="ph">Tantangan</h3>
      <p>Pelaksanaan sistem Student Government di KM UII dewasa ini masih jauh dari sempurna atau ideal, dan banyak hal yang perlu dilakukan. Beberapa permasalahan umum adalah belum maksimalnya penerapan prinsip transparansi dan koordinasi antarlembaga di KM UII dalam penyelenggaraan sistem Student Government, yang berakibat pada rendahnya tingkat kepercayaan mahasiswa terhadap lembaga di KM UII.</p>
      <p>Selain itu, mahasiswa yang dikenal dengan semangat juang dan idealismenya semestinya mengemban amanah dan tugas besar sebagai <em>agent of change, guardian of value, social control, moral force,</em> dan <em>iron stock</em>, yang perlu dibandingkan dengan realitas keterlibatan mahasiswa dalam kerja-kerja sosialnya. Realitas dewasa ini, disorientasi mahasiswa akan fungsi dan nilai luhurnya terganggu oleh pragmatisme praktis yang menjamur di tengah mahasiswa, sehingga menghambat aktualisasi peran yang seharusnya. Perkembangan teknologi, pengaruh situasi global, serta komersialisasi pendidikan memberikan efek domino terhadap mahasiswa, yang pada kenyataannya menurunkan keterlibatan mahasiswa atas isu sosial dan keumatan.</p>
      <p>Dengan demikian, hal ini menjadi evaluasi pada periode <strong>2021/2022</strong> untuk terus meningkatkan dan mengembalikan marwah agar lembaga mahasiswa memiliki daya tawar dan daya serap aspirasi mahasiswa yang komprehensif guna memperjuangkan hak-hak mahasiswa.</p>
    </div>
  </div>
</section>

<!-- ================= 06 STUDENT GOVERNMENT ================= -->
<section class="band alt" id="sg" aria-labelledby="h-sg">
  <div class="container band-grid">
    <header class="band-head">
      <span class="big-no" aria-hidden="true">06</span>
      <h2 id="h-sg">Student Government</h2>
      <p>Kemandirian, independensi, dan tanggung jawab.</p>
    </header>
    <div class="prose">
      <p>Keluarga Mahasiswa Universitas Islam Indonesia (KM UII) secara resmi berdiri pada 21 September 1950. Ciri khas utama yang melekat pada KM UII adalah dikenalnya istilah "student government" sebagai dasar pelaksanaan sistem kelembagaan. Secara umum, student government bermakna pemerintahan dari, untuk, dan oleh mahasiswa. Dengan demikian, sistem kelembagaan di KM UII dilakukan oleh mahasiswa UII, dari mahasiswa UII, untuk mahasiswa UII itu sendiri.</p>
      <p>Sistem kelembagaan yang demikian mensyaratkan dua aspek, yakni <strong>kemandirian</strong> dan <strong>independensi</strong> dalam berlembaga. Kemandirian dimaknai sebagai sesuatu yang berdiri sendiri dan tidak bergantung kepada pihak mana pun. Independensi bermakna bebas dan merdeka. Pemerintahan mahasiswa yang dikehendaki KM UII adalah pemerintahan yang tidak bergantung, berdiri sendiri, bebas, dan merdeka.</p>
      <p>Hal ini sejalan dengan spirit atau nilai juang yang melatarbelakangi lahirnya student government. Mahasiswa UII menempatkan lembaga mahasiswa sebagai "kawah candradimuka" untuk meningkatkan potensi dan kualitas diri, baik spiritual, moral, maupun intelektual. Hal ini tidak lepas dari tujuan KM UII itu sendiri:</p>
      <blockquote class="bq">Terbinanya mahasiswa UII menjadi Insan Ulil Albab yang turut bertanggung jawab atas terwujudnya tatanan masyarakat yang diridhoi Allah SWT.<cite>Tujuan KM UII</cite></blockquote>
      <p>Oleh UII, Insan Ulil Albab diterjemahkan sebagai Cendekiawan Muslim dan Pemimpin Bangsa sebagaimana tertera dalam Visi UII.</p>
      <h3 class="ph">Lima perwujudan kemandirian dan independensi</h3>
      <div class="five">
        <article>
          <b>01</b>
          <h4>Regenerasi</h4>
          <p>Segala proses regenerasi fungsionaris lembaga dilaksanakan oleh mahasiswa secara mandiri dan independen, tanpa pengaruh pihak mana pun.</p>
        </article>
        <article>
          <b>02</b>
          <h4>Kegiatan</h4>
          <p>Seluruh proses perencanaan, pelaksanaan, hingga pertanggungjawaban dilaksanakan secara mandiri oleh lembaga mahasiswa. Hal ini memungkinkan lembaga mahasiswa berkreasi leluasa, tanpa intervensi, "pesanan", dan tekanan dari pihak mana pun.</p>
        </article>
        <article>
          <b>03</b>
          <h4>Keuangan</h4>
          <p>Seluruh proses penerimaan, pengelolaan, dan pendistribusian hingga pertanggungjawaban dana kemahasiswaan dilaksanakan secara mandiri oleh lembaga mahasiswa.</p>
        </article>
        <article>
          <b>04</b>
          <h4>Struktur dan hubungan dengan UII</h4>
          <p>Organisasi KM UII tidak terikat struktural dengan UII, tidak berada di bawah Rektorat maupun Dekanat. Namun KM UII merupakan bagian dari UII yang tidak dapat dipisahkan. Hubungan keduanya dijalankan secara koordinatif, dengan mengedepankan hubungan yang sinergis dan harmonis, baik di lingkup universitas maupun fakultas.</p>
        </article>
        <article>
          <b>05</b>
          <h4>Sikap politik</h4>
          <p>KM UII memiliki sikap politik yang bebas dan merdeka. Dalam menentukan sikap politik, tidak ada pihak mana pun yang dapat mengintervensi atau memengaruhinya.</p>
        </article>
      </div>
      <h3 class="ph">Responsibility dan check and balance</h3>
      <p>Satu aspek yang sangat fundamental dalam student government adalah <em>responsibility</em>. Bersamaan dengan datangnya kekuatan yang besar, datang pula pertanggungjawaban yang besar. Sistem kelembagaan student government menuntut tanggung jawab besar. Karena itu, seluruh fungsionaris lembaga di KM UII wajib menjaga integritas dan tanggung jawabnya. Sebaliknya, seluruh civitas akademika UII, baik mahasiswa maupun pimpinan UII, wajib melakukan pengawasan yang terukur. Proses inilah yang dimaknai sebagai <em>check and balance</em> dalam student government.</p>
    </div>
  </div>
</section>

<!-- ================= PRATINJAU DIALOG ================= -->
<dialog class="pdlg" id="pdlg" aria-labelledby="pdTitle">
  <div class="pdlg-head">
    <div class="t"><small id="pdLabel"></small><strong id="pdTitle"></strong></div>
    <a class="btn sm" id="pdOpen" href="#" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h5"/></svg><span>Buka di Drive</span></a>
    <a class="btn sm" id="pdDl" href="#" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 4v11M7 11l5 5 5-5M5 20h14"/></svg><span>Unduh</span></a>
    <button class="pdlg-x" id="pdClose" type="button" aria-label="Tutup pratinjau"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg></button>
  </div>
  <div class="pdlg-body"><div class="pdlg-load">Memuat dokumen...</div><iframe id="pdFrame" title="Pratinjau dokumen" loading="lazy"></iframe></div>
</dialog>
@endsection

@push('scripts')
<script>
  // ---------- Sub-navigasi, progres baca ----------
  (function () {
    const links = [...document.querySelectorAll('#toc a')];
    const map = new Map(links.map(a => [a.getAttribute('href').slice(1), a]));
    const io = new IntersectionObserver(es => {
      es.forEach(en => {
        if (en.isIntersecting) {
          links.forEach(a => a.removeAttribute('aria-current'));
          const a = map.get(en.target.id);
          if (a) a.setAttribute('aria-current', 'true');
        }
      });
    }, { rootMargin: '-30% 0px -60% 0px' });
    map.forEach((a, id) => { const s = document.getElementById(id); if (s) io.observe(s); });

    const bar = document.getElementById('subnav');
    const first = document.getElementById('awal');
    let ticking = false;
    function prog() {
      const start = first.offsetTop - 200;
      const end = document.documentElement.scrollHeight - window.innerHeight;
      const p = Math.min(1, Math.max(0, (window.scrollY - start) / Math.max(1, end - start)));
      bar.style.setProperty('--p', p.toFixed(3));
      ticking = false;
    }
    function onScroll() {
      if (!ticking) {
        requestAnimationFrame(prog);
        ticking = true;
      }
    }
    window.addEventListener('scroll', onScroll, { passive: true }); prog();
  })();
</script>
@endpush