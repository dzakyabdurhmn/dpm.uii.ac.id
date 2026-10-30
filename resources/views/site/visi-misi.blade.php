@extends('layouts.site')

@section('title', 'Visi Misi — '.($siteSettings['site_name'] ?? 'DPM UII'))
@section('meta_description', 'Visi dan Misi Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia.')

@section('content')
<style>
    .visi-misi-page { color: rgba(255,255,255,.85); }
    .visi-misi-hero { background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%); }
    .visi-misi-wrap { width: min(1180px, calc(100% - 40px)); margin: 0 auto; }
    .visi-misi-hero-inner { padding: 68px 0 64px; position: relative; overflow: hidden; }
    .visi-misi-hero-inner::before {
        content: '';
        position: absolute; inset: 0;
        background: repeating-linear-gradient(135deg, rgba(255,255,255,.035) 0 1px, transparent 1px 26px);
        pointer-events: none;
    }
    .visi-misi-eyebrow { margin: 0 0 10px; color: rgba(255,255,255,.72); font-size: 12px; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; }
    .visi-misi-hero h1 { margin: 0; color: #fff; font-size: clamp(30px, 4.6vw, 44px); font-weight: 800; letter-spacing: -.03em; }
    .visi-misi-hero-copy { max-width: 720px; margin: 14px 0 0; color: rgba(255,255,255,.82); font-size: 15px; line-height: 1.85; }

    .visi-misi-section { padding: 56px 0 70px; background: #001E43; }
    .visi-misi-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 32px; }
    .visi-misi-card { 
        border: 1px solid rgba(255,255,255,.1); 
        border-radius: 12px; 
        background: linear-gradient(145deg, #001A3A 0%, #001633 100%);
        overflow: hidden;
        transition: border-color .2s, box-shadow .2s, transform .2s;
    }
    .visi-misi-card:hover {
        border-color: rgba(255,255,255,.25);
        box-shadow: 0 12px 40px rgba(0,0,0,.35);
        transform: translateY(-2px);
    }
    .visi-misi-card-header { 
        padding: 24px 28px; 
        border-bottom: 1px solid rgba(255,255,255,.1);
        background: rgba(255,255,255,.03);
    }
    .visi-misi-icon { 
        width: 56px; height: 56px; 
        border-radius: 12px; 
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 12px;
    }
    .visi-misi-icon svg { width: 28px; height: 28px; stroke: currentColor; fill: none; stroke-width: 2; }
    .visi-misi-card-header h2 { 
        margin: 0; color: #fff; font-size: 20px; font-weight: 800; letter-spacing: -.01em; 
    }
    .visi-misi-card-body { padding: 28px; }
    .visi-misi-prose { color: rgba(255,255,255,.84); font-size: 15px; line-height: 1.95; }
    .visi-misi-prose p { margin: 16px 0; }
    .visi-misi-prose h3 { margin: 28px 0 12px; color: #fff; font-weight: 800; font-size: 16px; }
    .visi-misi-prose ul { margin: 16px 0; padding-left: 0; list-style: none; }
    .visi-misi-prose li { 
        margin: 12px 0; padding-left: 28px; position: relative; 
        font-size: 14.5px; line-height: 1.8;
        color: rgba(255,255,255,.88);
    }
    .visi-misi-prose li::before {
        content: '';
        position: absolute; left: 0; top: 7px;
        width: 8px; height: 8px;
        border-radius: 50%;
        background: currentColor;
        opacity: .6;
    }
    .visi-misi-prose strong { color: #fff; font-weight: 700; }

    .visi-misi-card.visi { border-color: rgba(34,197,94,.3); }
    .visi-misi-card.visi .visi-misi-icon { background: rgba(34,197,94,.15); color: #4ade80; }
    .visi-misi-card.visi li::before { background: #4ade80; }
    .visi-misi-card.misi { border-color: rgba(250,204,21,.3); }
    .visi-misi-card.misi .visi-misi-icon { background: rgba(250,204,21,.15); color: #fbbf24; }
    .visi-misi-card.misi li::before { background: #fbbf24; }

    .visi-misi-values { margin-top: 48px; }
    .visi-misi-values-title { 
        margin: 0 0 24px; color: #fff; font-size: 20px; font-weight: 800; letter-spacing: -.01em; 
        text-align: center;
    }
    .visi-misi-values-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
    .visi-misi-value-card {
        padding: 22px 20px;
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 10px;
        background: #001A3A;
        text-align: center;
        transition: border-color .2s, background .2s, transform .2s;
    }
    .visi-misi-value-card:hover {
        border-color: rgba(255,255,255,.25);
        background: #002451;
        transform: translateY(-2px);
    }
    .visi-misi-value-icon {
        width: 48px; height: 48px;
        margin: 0 auto 12px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 10px;
        background: rgba(255,255,255,.05);
        color: rgba(255,255,255,.7);
    }
    .visi-misi-value-icon svg { width: 24px; height: 24px; stroke: currentColor; fill: none; stroke-width: 2; }
    .visi-misi-value-card h3 { margin: 0 0 6px; color: #fff; font-size: 14px; font-weight: 800; letter-spacing: .02em; }
    .visi-misi-value-card p { margin: 0; color: rgba(255,255,255,.62); font-size: 12px; line-height: 1.6; }

    @media (max-width: 980px) {
        .visi-misi-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 720px) {
        .visi-misi-wrap { width: min(100% - 28px, 1180px); }
        .visi-misi-hero-inner { padding: 48px 0 46px; }
        .visi-misi-section { padding: 40px 0 52px; }
        .visi-misi-values-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="visi-misi-page">
    <section class="visi-misi-hero">
        <div class="visi-misi-wrap visi-misi-hero-inner">
            <p class="visi-misi-eyebrow">Profil Lembaga</p>
            <h1>Visi dan Misi</h1>
            <p class="visi-misi-hero-copy">
                Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia — lembaga legislatif tertinggi dalam sistem student government KM UII.
            </p>
        </div>
    </section>

    <section class="visi-misi-section">
        <div class="visi-misi-wrap">
            <div class="visi-misi-grid">
                {{-- VISI CARD --}}
                <article class="visi-misi-card visi">
                    <div class="visi-misi-card-header">
                        <div class="visi-misi-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-12h2v6h-2zm0 8h2v2h-2z"/></svg>
                        </div>
                        <h2>Visi</h2>
                    </div>
                    <div class="visi-misi-card-body">
                        <div class="visi-misi-prose">
                            <p><strong>Terbinanya mahasiswa Universitas Islam Indonesia menjadi Insan Ulil Albab, yang turut bertanggung jawab atas terwujudnya tatanan masyarakat yang diridhoi Allah SWT.</strong></p>
                        </div>
                    </div>
                </article>

                {{-- MISI CARD --}}
                <article class="visi-misi-card misi">
                    <div class="visi-misi-card-header">
                        <div class="visi-misi-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="M4 6h16v2H4zm0 4h16v2H4zm0 4h16v2H4z"/></svg>
                        </div>
                        <h2>Misi</h2>
                    </div>
                    <div class="visi-misi-card-body">
                        <div class="visi-misi-prose">
                            <ol>
                                <li>Mewujudkan peran fungsi lembaga aspirasi mahasiswa yang responsif, progresif, adaptif, inovatif serta kolaboratif.</li>
                                <li>Optimalisasi fungsi lembaga mahasiswa yang amar ma'ruf nahi munkar.</li>
                                <li>Memperkuat Ukhuwah Islamiyah, persaudaraan Islam dan persaudaraan sebangsa di dalam kelembagaan Keluarga Mahasiswa UII.</li>
                                <li>Mewujudkan kelembagaan mahasiswa sebagai pembaharu dengan menghidupkan tradisi intelektual yang responsif terhadap permasalahan keumatan.</li>
                                <li>Membangun kehidupan kampus yang berorientasi pada pembentukan mahasiswa menjadi Insan Ulil Albab.</li>
                                <li>Menanamkan nilai-nilai keislaman dan kebangsaan yang kafah pada diri mahasiswa UII berlandaskan semangat rahmatan lil alamin guna mewujudkan Indonesia yang adil dan madani.</li>
                                <li>Menguatkan tradisi intelektual dengan dasar studi ilmiah dalam kehidupan kampus sebagai basis pencerahan dan pembentukan karakter mahasiswa UII guna mewujudkan perubahan sosial transformatif.</li>
                                <li>Optimalisasi bargaining position KM UII terhadap birokrat kampus.</li>
                                <li>Optimalisasi pengawasan KM UII terhadap kebijakan birokrat kampus dan pemerintah.</li>
                                <li>Mengembangkan jaringan kemahasiswaan di tingkat regional, nasional dan internasional.</li>
                                <li>Mewujudkan kemandirian dan independensi "Student Government" Keluarga Mahasiswa Universitas Islam Indonesia.</li>
                                <li>Optimalisasi sistem kelembagaan kemahasiswaan yang demokratis dan transparan dalam lingkungan KM UII.</li>
                                <li>Optimalisasi peran dan fungsi mahasiswa Universitas Islam Indonesia sebagai katalisator pergerakan dalam membersamai perjuangan rakyat.</li>
                            </ol>
                        </div>
                    </div>
                </article>
            </div>

            {{-- NILAI INTI --}}
            <div class="visi-misi-values">
                <h2 class="visi-misi-values-title">Nilai Inti</h2>
                <div class="visi-misi-values-grid">
                    <article class="visi-misi-value-card">
                        <div class="visi-misi-value-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <h3>Insan Ulil Albab</h3>
                        <p>Mahasiswa berilmu, berbudi luhur, dan bertanggung jawab</p>
                    </article>
                    <article class="visi-misi-value-card">
                        <div class="visi-misi-value-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                        <h3>Student Government</h3>
                        <p>Mahasiswa mengelola mahasiswa secara mandiri & demokratis</p>
                    </article>
                    <article class="visi-misi-value-card">
                        <div class="visi-misi-value-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                        </div>
                        <h3>Amar Ma'ruf Nahi Munkar</h3>
                        <p>Menyuruh kebaikan, mencegah keburukan sebagai landasan</p>
                    </article>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection