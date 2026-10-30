@extends('layouts.site')

@section('title', 'Sejarah — '.($siteSettings['site_name'] ?? 'DPM UII'))
@section('meta_description', 'Sejarah Student Government dan Sejarah Keluarga Mahasiswa Universitas Islam Indonesia.')

@section('content')
<style>
    .sejarah-page { color: rgba(255,255,255,.85); }
    .sejarah-hero { background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%); }
    .sejarah-wrap { width: min(1180px, calc(100% - 40px)); margin: 0 auto; }
    .sejarah-hero-inner { padding: 68px 0 64px; position: relative; overflow: hidden; }
    .sejarah-hero-inner::before {
        content: '';
        position: absolute; inset: 0;
        background: repeating-linear-gradient(135deg, rgba(255,255,255,.035) 0 1px, transparent 1px 26px);
        pointer-events: none;
    }
    .sejarah-eyebrow { margin: 0 0 10px; color: rgba(255,255,255,.72); font-size: 12px; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; }
    .sejarah-hero h1 { margin: 0; color: #fff; font-size: clamp(30px, 4.6vw, 44px); font-weight: 800; letter-spacing: -.03em; }
    .sejarah-hero-copy { max-width: 720px; margin: 14px 0 0; color: rgba(255,255,255,.82); font-size: 15px; line-height: 1.85; }

    .sejarah-section { padding: 56px 0 70px; background: #001E43; }

    /* TABS */
    .sejarah-tabs { 
        display: flex; gap: 8px; margin-bottom: 40px; 
        border-bottom: 1px solid rgba(255,255,255,.1);
        padding-bottom: 8px;
    }
    .sejarah-tab {
        padding: 14px 28px;
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 8px 8px 0 0;
        background: rgba(255,255,255,.03);
        color: rgba(255,255,255,.7);
        font-size: 14px; font-weight: 700; letter-spacing: .05em;
        cursor: pointer;
        transition: all .2s;
        border-bottom: none;
        margin-bottom: -1px;
    }
    .sejarah-tab:hover { color: #fff; background: rgba(255,255,255,.06); }
    .sejarah-tab.active {
        background: #001A3A; color: #fff;
        border-color: rgba(255,255,255,.2);
        box-shadow: 0 -4px 20px rgba(0,0,0,.2);
    }

    /* TIMELINE */
    .sejarah-timeline { position: relative; padding-left: 40px; }
    .sejarah-timeline::before {
        content: '';
        position: absolute; left: 15px; top: 0; bottom: 0;
        width: 2px; background: linear-gradient(180deg, rgba(255,255,255,.05), rgba(255,255,255,.15));
    }
    .timeline-item { position: relative; padding: 0 0 48px 48px; }
    .timeline-item:last-child { padding-bottom: 0; }
    .timeline-marker {
        position: absolute; left: -40px; top: 4px;
        width: 32px; height: 32px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        background: #001A3A;
        border: 3px solid;
        box-shadow: 0 0 0 4px #001E43;
        z-index: 2;
    }
    .timeline-marker svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2.5; }
    .timeline-item.sg .timeline-marker { border-color: #4ade80; color: #4ade80; }
    .timeline-item.kmui .timeline-marker { border-color: #fbbf24; color: #fbbf24; }
    .timeline-year {
        font-size: 12px; font-weight: 800; letter-spacing: .15em; text-transform: uppercase;
        color: rgba(255,255,255,.5); margin-bottom: 8px;
    }
    .timeline-content {
        background: #001A3A;
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 12px;
        padding: 28px;
        transition: border-color .2s, box-shadow .2s, transform .2s;
    }
    .timeline-content:hover {
        border-color: rgba(255,255,255,.2);
        box-shadow: 0 8px 32px rgba(0,0,0,.3);
        transform: translateX(4px);
    }
    .timeline-content h3 { margin: 0 0 14px; color: #fff; font-size: 18px; font-weight: 800; }
    .timeline-content p { margin: 12px 0; color: rgba(255,255,255,.82); line-height: 1.9; }
    .timeline-content ul { margin: 16px 0; padding-left: 22px; }
    .timeline-content li { margin: 8px 0; color: rgba(255,255,255,.85); line-height: 1.8; }
    .timeline-content strong { color: #fff; font-weight: 700; }

    /* PANELS for detailed text */
    .sejarah-panel {
        background: linear-gradient(145deg, #001A3A 0%, #001633 100%);
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 12px;
        padding: 32px;
        margin-bottom: 28px;
    }
    .sejarah-panel h3 { margin: 0 0 16px; color: #fff; font-size: 20px; font-weight: 800; }
    .sejarah-panel p { margin: 14px 0; color: rgba(255,255,255,.82); line-height: 1.95; }
    .sejarah-panel ul { margin: 16px 0; padding-left: 22px; }
    .sejarah-panel li { margin: 10px 0; color: rgba(255,255,255,.85); line-height: 1.85; }
    .sejarah-panel strong { color: #fff; font-weight: 700; }
    .sejarah-panel .highlight-box {
        background: rgba(255,255,255,.03);
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 8px;
        padding: 20px;
        margin: 20px 0;
        font-style: italic;
        color: rgba(255,255,255,.88);
        border-left: 3px solid #4ade80;
    }

    /* PILAR GRID */
    .pilar-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 20px;
        margin: 24px 0 8px;
    }
    .pilar-item {
        display: flex;
        gap: 16px;
        padding: 20px;
        background: rgba(255,255,255,.02);
        border: 1px solid rgba(255,255,255,.06);
        border-radius: 10px;
        transition: border-color .2s, background .2s, transform .2s;
    }
    .pilar-item:hover {
        border-color: rgba(255,255,255,.15);
        background: rgba(255,255,255,.05);
        transform: translateY(-2px);
    }
    .pilar-icon {
        flex-shrink: 0;
        width: 48px; height: 48px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        background: rgba(34,197,94,.12);
        color: #4ade80;
    }
    .pilar-icon svg { width: 24px; height: 24px; stroke: currentColor; fill: none; stroke-width: 2; }
    .pilar-content strong { display: block; color: #fff; font-size: 14.5px; font-weight: 800; margin-bottom: 6px; }
    .pilar-content p { margin: 0; color: rgba(255,255,255,.72); font-size: 13.5px; line-height: 1.7; }

    /* TAB BUTTONS - fix icon alignment */
    .sejarah-tabs { 
        display: flex; gap: 8px; margin-bottom: 40px; 
        border-bottom: 1px solid rgba(255,255,255,.1);
        padding-bottom: 8px;
    }
    .sejarah-tab {
        display: inline-flex; align-items: center; gap: 10px;
        padding: 14px 28px;
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 8px 8px 0 0;
        background: rgba(255,255,255,.03);
        color: rgba(255,255,255,.7);
        font-size: 14px; font-weight: 700; letter-spacing: .05em;
        cursor: pointer;
        transition: all .2s;
        border-bottom: none;
        margin-bottom: -1px;
    }
    .sejarah-tab:hover { color: #fff; background: rgba(255,255,255,.06); }
    .sejarah-tab.active {
        background: #001A3A; color: #fff;
        border-color: rgba(255,255,255,.2);
        box-shadow: 0 -4px 20px rgba(0,0,0,.2);
    }
    .sejarah-tab svg { 
        width: 18px; height: 18px; 
        flex-shrink: 0; 
        stroke: currentColor; 
        stroke-width: 2; 
        fill: none; 
        stroke-linecap: round; 
        stroke-linejoin: round;
    }

    .tab-pane { display: none; }
    .tab-pane.active { display: block; animation: fadeIn .3s ease; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: none; } }

    @media (max-width: 720px) {
        .sejarah-wrap { width: min(100% - 28px, 1180px); }
        .sejarah-hero-inner { padding: 48px 0 46px; }
        .sejarah-section { padding: 40px 0 52px; }
        .sejarah-tabs { flex-wrap: wrap; }
        .sejarah-tab { flex: 1; text-align: center; padding: 12px 16px; font-size: 13px; }
        .sejarah-timeline { padding-left: 28px; }
        .timeline-item { padding-left: 36px; }
        .timeline-marker { left: -34px; width: 28px; height: 28px; }
        .timeline-content { padding: 20px; }
        .sejarah-panel { padding: 24px; }
    }
</style>

<div class="sejarah-page">
    <section class="sejarah-hero">
        <div class="sejarah-wrap sejarah-hero-inner">
            <p class="sejarah-eyebrow">Profil Lembaga</p>
            <h1>Sejarah</h1>
            <p class="sejarah-hero-copy">
                Menelusuri perjalanan Keluarga Mahasiswa Universitas Islam Indonesia dari lahirnya Student Government hingga perjuangan mahasiswa UII dalam membangun peradaban.
            </p>
        </div>
    </section>

    <section class="sejarah-section">
        <div class="sejarah-wrap">
            {{-- TABS --}}
            <nav class="sejarah-tabs" role="tablist" aria-label="Sejarah tabs">
                <button class="sejarah-tab active" role="tab" aria-selected="true" data-tab="student-government">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Sejarah Student Government
                </button>
                <button class="sejarah-tab" role="tab" aria-selected="false" data-tab="km-uii">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    Sejarah KM UII
                </button>
            </nav>

            {{-- STUDENT GOVERNMENT TAB --}}
            <div class="tab-pane active" id="student-government" role="tabpanel">
                <article class="sejarah-panel">
                    <h3>Pengertian Student Government</h3>
                    <p>
                        Keluarga Mahasiswa Universitas Islam Indonesia (KM UII) secara resmi berdiri pada tanggal <strong>21 September 1950</strong>. Ciri khas utama yang melekat pada KM UII adalah dikenalnya istilah <strong>"student government"</strong> sebagai dasar pelaksanaan sistem kelembagaan di KM UII.
                    </p>
                    <p>
                        Secara umum, <strong>student government bermakna pemerintahan dari, untuk dan oleh mahasiswa</strong>. Dengan demikian maka pelaksanaan atau sistem kelembagaan di KM UII dilakukan oleh mahasiswa UII, dari mahasiswa UII untuk mahasiswa UII itu sendiri.
                    </p>
                    <p>
                        Pelaksanaan sistem kelembagaan yang demikian itu mensyaratkan adanya dua aspek fundamental, yakni <strong>kemandirian</strong> dan <strong>independensi</strong> dalam berlembaga.
                    </p>

                    <div class="highlight-box">
                        <strong>Kemandirian</strong> dimaknai sebagai sesuatu yang berdiri sendiri dan tidak bergantung kepada pihak manapun.<br>
                        <strong>Independensi</strong> bermakna bebas dan merdeka.<br>
                        Dengan demikian, maka pemerintahan mahasiswa yang dikehendaki oleh KM UII adalah pemerintahan yang tidak bergantung, berdiri sendiri, bebas dan merdeka.
                    </div>

                    <p>
                        Hal ini sejalan dengan spirit atau nilai juang yang melatar belakangi lahirnya student government. Mahasiswa UII menempatkan lembaga mahasiswa sebagai <strong>"kawah candradimuka"</strong> untuk meningkatkan potensi dan kualitas diri, baik dalam kualitas spiritual, moral dan intelektual. Hal ini tidak lepas dari tujuan KM UII itu sendiri, yakni <strong>"Terbinanya mahasiswa UII menjadi Insan Ulil Albab yang turut bertanggungjawab atas terwujudnya tatanan masyarakat yang diridhoi Allah SWT"</strong>.
                    </p>
                </article>

                <article class="sejarah-panel">
                    <h3>Lima Pilar Wujud Student Government</h3>
                    <p>Nilai-nilai yang termuat dalam student government (kemandirian dan independensi) dapat diwujudkan melalui lima hal:</p>
                    <div class="pilar-grid">
                        <div class="pilar-item">
                            <div class="pilar-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </div>
                            <div class="pilar-content">
                                <strong>Regenerasi Fungsionaris</strong>
                                <p>Segala proses regenerasi dilaksanakan oleh mahasiswa secara mandiri dan independen, tanpa ada pengaruh dari pihak manapun.</p>
                            </div>
                        </div>
                        <div class="pilar-item">
                            <div class="pilar-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            </div>
                            <div class="pilar-content">
                                <strong>Kegiatan</strong>
                                <p>Seluruh proses perencanaan, pelaksanaan hingga pertanggungjawaban dilaksanakan mandiri oleh lembaga mahasiswa. Bebas intervensi, "pesanan", dan tekanan pihak manapun.</p>
                            </div>
                        </div>
                        <div class="pilar-item">
                            <div class="pilar-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                            </div>
                            <div class="pilar-content">
                                <strong>Keuangan</strong>
                                <p>Seluruh proses penerimaan, pengelolaan, pendistribusian hingga pertanggungjawaban dana kemahasiswaan dilaksanakan mandiri oleh lembaga mahasiswa.</p>
                            </div>
                        </div>
                        <div class="pilar-item">
                            <div class="pilar-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                            </div>
                            <div class="pilar-content">
                                <strong>Organisasi</strong>
                                <p>KM UII tidak terikat struktural dengan UII, tidak di bawah Rektorat/Dekanat. Tetap bagian UII yang tak terpisahkan — hubungan koordinatif, sinergis, harmonis.</p>
                            </div>
                        </div>
                        <div class="pilar-item">
                            <div class="pilar-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 0 9.27 6.91 8.26 12 2"/></svg>
                            </div>
                            <div class="pilar-content">
                                <strong>Sikap Politik</strong>
                                <p>KM UII memiliki sikap politik bebas dan merdeka. Tidak ada pihak yang dapat mengintervensi atau mempengaruhi penentuan sikap politik.</p>
                            </div>
                        </div>
                    </div>
                    <div class="highlight-box" style="border-left-color: #fbbf24;">
                        <strong>Responsibility:</strong> Bersamaan dengan datangnya kekuatan yang besar, maka datang pula pertanggungjawaban yang besar. Sistem kelembagaan yang menganut student government ini menuntut tanggung jawab besar. Seluruh fungsionaris wajib menjaga integritas dan tanggung jawab. Seluruh civitas akademika wajib melakukan pengawasan terukur. Inilah <strong>check and balance</strong> dalam student government.
                    </div>
                </article>
            </div>

            {{-- KM UII TAB --}}
            <div class="tab-pane" id="km-uii" role="tabpanel">
                <article class="sejarah-panel">
                    <h3>Sejarah Lembaga Kemahasiswaan</h3>
                    <p>
                        Sekolah Tinggi Islam yang berdiri pada hari ahad tanggal 27 Rajab 1364 bertepatan dengan tanggal <strong>8 Juli 1945</strong> dan kini bernama Universitas Islam Indonesia, tidak terlepas dari kiprah mahasiswa untuk senantiasa memberikan peran positif yang maksimal untuk bangsanya.
                    </p>
                    <p>
                        Sejak berdirinya STI, mahasiswa yang waktu itu hanya diterima 14 orang dari 78 pendaftar telah membulatkan tekadnya dalam membangun bangsa, dengan ikrar menyerahkan segenap tenaga dalam menuntut ilmu serta menjunjung tinggi akhlak dan budi pekerti Islam.
                    </p>
                    <p>
                        Seiring berjalannya waktu dan seiring pula kepindahannya STI ke Yogyakarta (<strong>10 April 1946</strong>), mahasiswa STI terus berkarya dan menjadikan momentum kepindahan tersebut sebagai kebangkitan mahasiswa STI dengan mendirikan dua lembaga kemahasiswaan:
                    </p>
                    <ul>
                        <li><strong>Senat Mahasiswa STI</strong> — dipimpin oleh Ketua I Djanamar Adjam, Ketua II Amin Syahri, Ketua III Lafran Pane</li>
                        <li><strong>Himpunan Mahasiswa Islam</strong> — inisiatif Lafran Pane dengan cita-cita keseimbangan dunia-akhirat, akal-qalbu, iman-ilmu pengetahuan</li>
                    </ul>
                    <p>
                        Perkembangan senat mahasiswa di tingkat fakultas dinamakan komisariat senat mahasiswa (fakultas: ekonomi, hukum, pendidikan, agama, dan kelas pendahuluan). Karena tata kerja dan struktur yang sempit, maka pada <strong>21 September 1950</strong> diadakan Sidang Umum yang menghasilkan keputusan dibentuknya <strong>Majelis Permusyawaratan Mahasiswa (MPM)</strong> dan <strong>Dewan Mahasiswa (DEMA)</strong> dengan merujuk pada konsep negara — MPM sebagai legislatif, DEMA sebagai eksekutif. <strong>Inilah yang dinamakan Student Government dan tanggal 21 September 1950 diperingati sebagai hari kelahiran Keluarga Mahasiswa Universitas Islam Indonesia.</strong>
                    </p>
                </article>

                <article class="sejarah-panel">
                    <h3>Era BKK-KUA (1978–1993)</h3>
                    <p>
                        Sudah 20 tahun lebih lembaga kemahasiswaan UII menggunakan konsep student government dengan nama MPM dan DEMA. Akan tetapi rintangan menghadang seluruh organisasi kemahasiswaan di Indonesia tepatnya dengan dikeluarkannya SK Menteri Pendidikan dan Kebudayaan Syarif Tayep tanggal <strong>23 Januari 1974</strong> (SK 029-74) mengenai dibekukannya seluruh kegiatan Dewan Mahasiswa.
                    </p>
                    <p>
                        Menjelang Sidang Umum MPR Tahun 1978, suhu politik Indonesia naik. Di Yogyakarta seluruh DEMA bersatu, menuntut pemerintah yang sudah berjalan menyimpang. Akibatnya sebagian mahasiswa ditangkap — salah satunya <strong>Maqdir Ismail</strong> (ketua departemen ekstern DEMA UII, kini Dr. Maqdir Ismail, SH., L.LM).
                    </p>
                    <p>
                        Pemerintah mengeluarkan <strong>Normalisasi Kehidupan Kampus (NKK)</strong> via SK No. 0156/U/1978 (19 April 1978) dan Instruksi Dirjen Dikti No. 002/DJ/Inst/1978 (17 Mei 1978). Konsep ini ditolak mahasiswa. Di internal UII, Rektor mengeluarkan SK No. 718/B.VI/1978 yang berisi:
                    </p>
                    <ul>
                        <li>Likuidasi seluruh lembaga kemahasiswaan (dilaksanakan MPM, selesai minggu III Desember 1978)</li>
                        <li>Mengadakan pemilu mahasiswa sesuai instruksi Dirjen Dikti</li>
                    </ul>
                    <p>
                        Berdasarkan hal tersebut dibentuklah <strong>Badan Koordinasi Kemahasiswaan (BKK)</strong> dan <strong>Koordinator Unit Aktivitas (KUA)</strong>, masing-masing sebagai pemegang legislatif dan eksekutif. BKK diketuai oleh Pembantu Rektor III dengan anggota Pembantu Dekan dan wakil mahasiswa terpilih.
                    </p>
                </article>

                <article class="sejarah-panel">
                    <h3>Era DPM-LEM (1993–Sekarang)</h3>
                    <p>
                        Pada <strong>15 Mei 1993</strong>, Sidang Umum XXII menghasilkan keputusan dibentuknya <strong>Dewan Permusyawaratan Mahasiswa (DPM)</strong> dan <strong>Lembaga Eksekutif Mahasiswa (LEM)</strong> tingkat Universitas, serta <strong>Badan Perwakilan Mahasiswa (BPM)</strong> dan <strong>Senat Mahasiswa Fakultas (SMF)</strong> tingkat Fakultas.
                    </p>
                    <p>
                        Pada Sidang Umum XXV tahun <strong>1998</strong> terjadi perubahan nama di tingkat fakultas: eksekutif menjadi <strong>Lembaga Eksekutif Mahasiswa Fakultas (LEMF)</strong> dan legislatif menjadi <strong>Dewan Perwakilan Mahasiswa Fakultas (DPMF)</strong>. Konsep inilah yang bertahan sampai sekarang. Pada tahun 1998 KM UII juga ikut berperan dalam menggulingkan rezim Soeharto, dan melahirkan orde reformasi.
                    </p>
                </article>

                <article class="sejarah-panel">
                    <h3>Realita Kemahasiswaan & Tantangan</h3>
                    <p>
                        Kebijakan pasca-NKK yang dipengaruhi era globalisasi berdampak pada pendidikan Perguruan Tinggi yang semakin kental dengan sistem kurikulum feodalistik: materi pembelajaran lebih diperkental daripada pengembangan pikiran, mementingkan formalisasi materi, tidak menempatkan peserta didik sebagai mitra belajar, tidak menghormati nilai pilihan pribadi pelajar.
                    </p>
                    <p>
                        Mahasiswa sebagai <strong>agent of change, guardian of value, social control, moral force, dan iron stock</strong> seharusnya mengemban amanah besar. Namun realitasnya: disorientasi fungsi nilai luhur terganggu pragmatisme praktis, penurunan keterlibatan mahasiswa atas isu sosial dan keumatan akibat perkembangan teknologi, pengaruh global, dan komersialisasi pendidikan.
                    </p>
                    <p>
                        Menjadi evaluasi periode <strong>2021/2022</strong> untuk terus meningkatkan dan mengembalikan marwah agar lembaga mahasiswa memiliki daya tawar dan daya serap aspirasi mahasiswa yang komprehensif guna memperjuangkan hak-hak mahasiswa.
                    </p>
                </article>
            </div>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tabs = document.querySelectorAll('.sejarah-tab');
    const panes = document.querySelectorAll('.tab-pane');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => { t.classList.remove('active'); t.setAttribute('aria-selected', 'false'); });
            panes.forEach(p => p.classList.remove('active'));

            tab.classList.add('active');
            tab.setAttribute('aria-selected', 'true');
            document.getElementById(tab.dataset.tab).classList.add('active');
        });
    });
});
</script>
@endsection