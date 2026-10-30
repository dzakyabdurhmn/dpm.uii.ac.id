@extends('layouts.site')

@section('title', 'Sosialisasi Peraturan — '.($siteSettings['site_name'] ?? 'DPM UII'))
@section('meta_description', 'Panduan mudah memahami peraturan KM UII: PDKM, GBHKM, PKM, dan PDPM untuk mahasiswa UII.')

@section('content')
<style>
    .sosialisasi-page { color: rgba(255,255,255,.85); }
    .sosialisasi-hero { background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%); }
    .sosialisasi-wrap { width: min(1180px, calc(100% - 40px)); margin: 0 auto; }
    .sosialisasi-hero-inner { padding: 68px 0 64px; position: relative; overflow: hidden; }
    .sosialisasi-hero-inner::before {
        content: '';
        position: absolute; inset: 0;
        background: repeating-linear-gradient(135deg, rgba(255,255,255,.035) 0 1px, transparent 1px 26px);
        pointer-events: none;
    }
    .sosialisasi-eyebrow { margin: 0 0 10px; color: rgba(255,255,255,.72); font-size: 12px; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; }
    .sosialisasi-hero h1 { margin: 0; color: #fff; font-size: clamp(30px, 4.6vw, 44px); font-weight: 800; letter-spacing: -.03em; }
    .sosialisasi-hero-copy { max-width: 720px; margin: 14px 0 0; color: rgba(255,255,255,.82); font-size: 15px; line-height: 1.85; }

    .sosialisasi-section { padding: 56px 0 70px; background: #001E43; }

    /* INTRO CARD */
    .intro-card {
        background: linear-gradient(145deg, #001A3A 0%, #001633 100%);
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 16px;
        padding: 40px;
        margin-bottom: 48px;
    }
    .intro-card h2 { margin: 0 0 16px; color: #fff; font-size: 24px; font-weight: 800; }
    .intro-card p { margin: 0; color: rgba(255,255,255,.78); line-height: 1.9; font-size: 15.5px; }
    .intro-card .highlight { color: #4ade80; font-weight: 700; }

    /* REGULATION CARDS */
    .regs-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 28px; }
    .reg-card {
        background: linear-gradient(145deg, #001A3A 0%, #001633 100%);
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 16px;
        overflow: hidden;
        transition: border-color .2s, box-shadow .2s, transform .2s;
        display: flex; flex-direction: column;
    }
    .reg-card:hover {
        border-color: rgba(255,255,255,.2);
        box-shadow: 0 16px 48px rgba(0,0,0,.35);
        transform: translateY(-4px);
    }
    .reg-card-header {
        padding: 28px 32px 20px;
        border-bottom: 1px solid rgba(255,255,255,.08);
        background: rgba(255,255,255,.02);
        position: relative;
    }
    .reg-card-header::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 4px;
        background: var(--reg-color);
    }
    .reg-type {
        display: inline-block;
        font-size: 11px; font-weight: 800; letter-spacing: .1em; text-transform: uppercase;
        color: rgba(255,255,255,.5); margin-bottom: 6px;
    }
    .reg-card-header h2 { margin: 0; color: #fff; font-size: 22px; font-weight: 800; letter-spacing: -.01em; }
    .reg-card-header .full-name { margin: 4px 0 0; color: rgba(255,255,255,.6); font-size: 13px; font-weight: 500; }

    .reg-card-body { padding: 24px 32px 32px; flex: 1; display: flex; flex-direction: column; }
    .reg-desc { color: rgba(255,255,255,.78); font-size: 14.5px; line-height: 1.85; margin-bottom: 20px; }
    .reg-simple {
        background: rgba(255,255,255,.03);
        border: 1px solid rgba(255,255,255,.08);
        border-left: 3px solid var(--reg-color);
        border-radius: 8px;
        padding: 18px 20px;
        margin-bottom: 24px;
        font-size: 14px; line-height: 1.8;
        color: rgba(255,255,255,.85);
    }
    .reg-simple strong { color: var(--reg-color); }

    .reg-points { margin-bottom: 24px; }
    .reg-points h3 { margin: 0 0 12px; color: #fff; font-size: 14px; font-weight: 800; text-transform: uppercase; letter-spacing: .08em; }
    .reg-points ul { margin: 0; padding-left: 0; list-style: none; }
    .reg-points li {
        position: relative; padding-left: 24px; margin: 10px 0;
        color: rgba(255,255,255,.82); line-height: 1.75; font-size: 13.5px;
    }
    .reg-points li::before {
        content: ''; position: absolute; left: 0; top: 8px;
        width: 7px; height: 7px; border-radius: 50%;
        background: var(--reg-color); opacity: .8;
    }

    .reg-link {
        display: inline-flex; align-items: center; justify-content: center; gap: 10px;
        width: 100%; height: 44px;
        border-radius: 10px; background: transparent; border: 2px solid var(--reg-color); color: var(--reg-color);
        font-size: 13.5px; font-weight: 700; letter-spacing: .02em; text-decoration: none;
        transition: all .2s;
    }
    .reg-link:hover { background: var(--reg-bg); transform: translateY(-2px); box-shadow: 0 8px 24px var(--reg-shadow); }
    .reg-link svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2.5; }

    /* HIERARCHY VISUAL */
    .hierarchy-section { margin-top: 56px; }
    .hierarchy-title { margin: 0 0 28px; color: #fff; font-size: 24px; font-weight: 800; text-align: center; }
    .hierarchy-flow {
        display: flex; flex-direction: column; gap: 16px; align-items: center;
    }
    .hierarchy-item {
        display: flex; align-items: center; gap: 16px; width: 100%; max-width: 800px;
        padding: 20px 24px;
        background: linear-gradient(145deg, #001A3A 0%, #001633 100%);
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 12px;
        transition: border-color .2s, transform .2s;
    }
    .hierarchy-item:hover { border-color: rgba(255,255,255,.15); transform: translateX(4px); }
    .hierarchy-level {
        width: 48px; height: 48px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        font-size: 11px; font-weight: 800; letter-spacing: .05em; text-transform: uppercase;
        color: #fff;
    }
    .hierarchy-content { flex: 1; }
    .hierarchy-content h3 { margin: 0 0 6px; color: #fff; font-size: 16px; font-weight: 800; }
    .hierarchy-content p { margin: 0; color: rgba(255,255,255,.65); font-size: 13.5px; line-height: 1.7; }
    .hierarchy-arrow { width: 32px; height: 32px; border-radius: 50%; background: rgba(255,255,255,.05); display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,.4); margin: 0 0 8px; }
    .hierarchy-arrow svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2.5; }

    @media (max-width: 720px) {
        .sosialisasi-wrap { width: min(100% - 28px, 1180px); }
        .sosialisasi-hero-inner { padding: 48px 0 46px; }
        .sosialisasi-section { padding: 40px 0 52px; }
        .intro-card { padding: 28px; }
        .reg-card-header { padding: 24px; }
        .reg-card-body { padding: 20px 24px 28px; }
        .hierarchy-item { flex-direction: column; text-align: center; gap: 12px; }
        .hierarchy-arrow { transform: rotate(90deg); }
    }
</style>

<div class="sosialisasi-page">
    <section class="sosialisasi-hero">
        <div class="sosialisasi-wrap sosialisasi-hero-inner">
            <p class="sosialisasi-eyebrow">Humas DPM UII</p>
            <h1>Sosialisasi Peraturan</h1>
            <p class="sosialisasi-hero-copy">
                Memahami peraturan KM UII tidak harus rumit. Di sini kami jelaskan PDKM, GBHKM, PKM, dan PDPM dengan bahasa yang ringan & mudah dicerna untuk semua mahasiswa UII.
            </p>
        </div>
    </section>

    <section class="sosialisasi-section">
        <div class="sosialisasi-wrap">
            {{-- INTRO --}}
            <article class="intro-card">
                <h2>Kenapa Perlu Tahu Peraturan?</h2>
                <p>
                    Peraturan bukan cuma "buku aturan kaku" — tapi <span class="highlight">pedoman hidup bersama</span> di KM UII. 
                    Tahu peraturan berarti kamu tahu <strong>hak</strong> kamu, <strong>kewajiban</strong> kamu, dan <strong>cara</strong> berorganisasi yang benar.
                </p>
                <p style="margin-top: 16px;">
                    Di halaman ini kami pecah 4 peraturan utama KM UII dengan bahasa sehari-hari, 
                    lengkap analogi & poin-poin penting yang <em>wajib</em> diketahui mahasiswa UII.
                </p>
            </article>

            {{-- REGULATION CARDS --}}
            <div class="regs-grid">
                @foreach ($regulations as $reg)
                    <article class="reg-card" style="--reg-color: {{ $reg['color'] }}; --reg-bg: {{ $reg['color'] }}20; --reg-shadow: {{ $reg['color'] }}40;">
                        <header class="reg-card-header">
                            <span class="reg-type">{{ $reg['type'] ?? 'Peraturan' }}</span>
                            <h2>{{ $reg['title'] }}</h2>
                            <p class="full-name">{{ $reg['full'] }}</p>
                        </header>
                        <div class="reg-card-body">
                            <p class="reg-desc">{{ $reg['description'] }}</p>

                            <div class="reg-simple">
                                {{ $reg['simpleExplanation'] }}
                            </div>

                            <div class="reg-points">
                                <h3>Poin Penting</h3>
                                @if (is_array($reg['keyPoints']))
                                    <ul>
                                        @foreach ($reg['keyPoints'] as $point)
                                            <li>{{ $point }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <ul><li>{{ $reg['keyPoints'] }}</li></ul>
                                @endif
                            </div>

                            <a href="{{ route('legal-products.type', $reg['slug']) }}" class="reg-link">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5M9 13h6M9 17h6"/></svg>
                                <span>Lihat Arsip Lengkap</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- HIERARCHY --}}
            <section class="hierarchy-section">
                <h2 class="hierarchy-title">Hierarki Peraturan KM UII</h2>
                <div class="hierarchy-flow">
                    <article class="hierarchy-item" style="border-left: 4px solid #4ade80;">
                        <div class="hierarchy-level" style="background: linear-gradient(135deg, #4ade80, #22c55e);">LEVEL 1</div>
                        <div class="hierarchy-content">
                            <h3>PDKM — Konstitusi</h3>
                            <p>Dasar hukum tertinggi, mengatur asas & struktur fundamental KM UII. Sulit diubah (butuh 2/3 DPM).</p>
                        </div>
                    </article>
                    <div class="hierarchy-arrow" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M19 12l-7 7-7-7"/></svg></div>
                    <article class="hierarchy-item" style="border-left: 4px solid #fbbf24;">
                        <div class="hierarchy-level" style="background: linear-gradient(135deg, #fbbf24, #f59e0b);">LEVEL 2</div>
                        <div class="hierarchy-content">
                            <h3>GBHKM — Arah Kebijakan</h3>
                            <p>Roadmap periode kepengurusan: visi, misi, strategi 5 tahun. Ditetapkan awal periode.</p>
                        </div>
                    </article>
                    <div class="hierarchy-arrow" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M19 12l-7 7-7-7"/></svg></div>
                    <article class="hierarchy-item" style="border-left: 4px solid #60a5fa;">
                        <div class="hierarchy-level" style="background: linear-gradient(135deg, #60a5fa, #3b82f6);">LEVEL 3</div>
                        <div class="hierarchy-content">
                            <h3>PKM — Peraturan Teknis Tahunan</h3>
                            <p>Mengatur detail teknis: dana, kegiatan, pemilu, organisasi. Bernomor & bertahun, bisa diubah setiap tahun.</p>
                        </div>
                    </article>
                    <div class="hierarchy-arrow" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M19 12l-7 7-7-7"/></svg></div>
                    <article class="hierarchy-item" style="border-left: 4px solid #f472b6;">
                        <div class="hierarchy-level" style="background: linear-gradient(135deg, #f472b6, #ec4899);">LEVEL 4</div>
                        <div class="hierarchy-content">
                            <h3>PDPM — Aturan Internal DPM</h3>
                            <p>Tata tertib sidang, mekanisme legislasi, komisus, pengawasan. Khusus internal DPM.</p>
                        </div>
                    </article>
                </div>

                <div style="margin-top: 32px; padding: 24px; background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.08); border-radius: 12px; text-align: center;">
                    <p style="margin: 0 0 12px; color: rgba(255,255,255,.8); font-size: 14px;">
                        <strong style="color: #fff;">Aturan emas:</strong> Peraturan level bawah <em>tidak boleh bertentangan</em> dengan level atasnya.
                    </p>
                    <p style="margin: 0; color: rgba(255,255,255,.6); font-size: 13px;">
                        PDKM > GBHKM > PKM > PDPM
                    </p>
                </div>
            </section>

            {{-- FAQ QUICK --}}
            <section style="margin-top: 48px;">
                <h2 style="margin: 0 0 24px; color: #fff; font-size: 22px; font-weight: 800; text-align: center;">Tanya Jawab Cepat</h2>
                <div class="regs-grid">
                    @foreach ([
                        ['q' => 'Mana yang paling atas?', 'a' => '<strong>PDKM.</strong> Dia konstitusi KM UII. Semua peraturan lain harus turun dari PDKM.'],
                        ['q' => 'PKM sama PDPM bedanya apa?', 'a' => '<strong>PKM</strong> = untuk seluruh KM UII (universitas + fakultas). <strong>PDPM</strong> = khusus internal DPM Pusat (tata tertib sidang, mekanisme legislasi, dll).'],
                        ['q' => 'GBHKM berubah tiap periode?', 'a' => '<strong>Iya.</strong> GBHKM dibuat baru tiap periode kepengurusan DPM (5 tahun). Isinya visi-misi & strategi periode itu.'],
                        ['q' => 'Peraturan mana yang paling sering dibuka mahasiswa?', 'a' => '<strong>PKM.</strong> Karena PKM yang ngatur hal teknis dekat mahasiswa: dana, kegiatan, pemilu, UKM, dll.'],
                    ] as $faq)
                        <div style="background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.08); border-radius: 10px; padding: 20px;">
                            <p style="margin: 0 0 8px; color: #4ade80; font-weight: 700; font-size: 14px;">Q: {{ $faq['q'] }}</p>
                            <p style="margin: 0; color: rgba(255,255,255,.8); line-height: 1.8;">{{ $faq['a'] }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </section>
</div>
@endsection