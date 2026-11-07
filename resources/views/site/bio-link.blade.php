<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#001E43">
<title>Tautan Resmi | DPM UII</title>
<meta name="description" content="Tautan resmi Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia: produk hukum, surat keputusan, laporan, dana, dan aspirasi mahasiswa.">
<meta property="og:title" content="Tautan Resmi | DPM UII">
<meta property="og:description" content="Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia, lembaga legislatif Keluarga Mahasiswa UII.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Wix+Madefor+Display:wght@500;600;700;800&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
  :root {
    --navy: #001E43; --navy-footer: #001633; --navy-card: #001A3A; --navy-hover: #002451;
    --white: #FFFFFF;
    --t-body: rgba(255,255,255,0.85); --t-sub: rgba(255,255,255,0.75); --t-cap: rgba(255,255,255,0.62);
    --b-default: rgba(255,255,255,0.10); --b-btn: rgba(255,255,255,0.30); --b-btn-hover: rgba(255,255,255,0.55);
    --bg-hover: rgba(255,255,255,0.06);
    --sh-md: 0 8px 24px rgba(0,0,0,0.40); --sh-lg: 0 16px 48px rgba(0,0,0,0.55);
  }
  html { background: var(--navy); }
  body {
    min-height: 100vh; font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', sans-serif;
    color: var(--t-body); line-height: 1.6; -webkit-font-smoothing: antialiased;
    background:
      radial-gradient(ellipse 80% 50% at 50% -10%, rgba(0, 70, 150, 0.45), transparent 70%),
      repeating-linear-gradient(135deg, rgba(255,255,255,0.03) 0 1px, transparent 1px 30px),
      var(--navy);
    background-attachment: fixed;
  }
  a { color: inherit; text-decoration: none; }
  h1, h2, strong { font-family: 'Wix Madefor Display', 'Inter', sans-serif; color: var(--white); }
  :focus-visible { outline: 2px solid var(--white); outline-offset: 3px; }
  .sr-only { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); white-space: nowrap; }

  .wrap { width: 100%; max-width: 520px; margin: 0 auto; padding: 28px 20px 40px; position: relative; }

  /* share */
  .share { position: absolute; top: 20px; right: 20px; width: 40px; height: 40px; display: grid; place-items: center;
    background: transparent; border: 1px solid var(--b-btn); border-radius: 6px; color: var(--white); cursor: pointer;
    transition: border-color .2s, background .2s; }
  .share:hover { border-color: var(--b-btn-hover); background: var(--bg-hover); }
  .share svg { width: 17px; height: 17px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
  .toast { position: fixed; left: 50%; bottom: 28px; transform: translate(-50%, 20px); padding: 10px 18px; border: 1px solid var(--b-btn);
    border-radius: 6px; background: var(--navy-card); color: var(--white); font-size: 13px; font-weight: 500; box-shadow: var(--sh-md);
    opacity: 0; pointer-events: none; transition: opacity .25s, transform .25s; z-index: 10; }
  .toast.show { opacity: 1; transform: translate(-50%, 0); }

  /* identitas */
  .identity { text-align: center; padding: 44px 0 30px; }
  .logo { display: block; width: min(300px, 78vw); height: auto; margin: 0 auto 26px; }
  .tag { display: flex; align-items: center; justify-content: center; gap: 14px; font-size: 11.5px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--t-sub); }
  .tag::before, .tag::after { content: ''; width: 28px; height: 1px; background: var(--b-btn); }
  .handle { margin-top: 10px; font-size: 14px; color: var(--t-cap); }

  .social { display: flex; justify-content: center; gap: 10px; margin-top: 24px; }
  .social a { width: 44px; height: 44px; display: grid; place-items: center; border: 1px solid var(--b-btn); border-radius: 50%; color: var(--white); transition: border-color .2s, background .2s; }
  .social a:hover { border-color: var(--b-btn-hover); background: var(--bg-hover); }
  .social svg { width: 18px; height: 18px; }
  .social svg.fill { fill: currentColor; }
  .social svg.line { stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }

  /* sorotan */
  .feature { display: block; position: relative; margin: 6px 0 34px; padding: 24px 24px 22px; overflow: hidden;
    background: var(--navy-card); border: 1px solid var(--b-btn); border-radius: 8px; box-shadow: var(--sh-md);
    transition: border-color .25s, background .25s, transform .25s; }
  .feature::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 24px); }
  .feature:hover { border-color: var(--b-btn-hover); background: var(--navy-hover); transform: translateY(-2px); }
  .feature > * { position: relative; }
  .feature .eyebrow { display: block; margin-bottom: 8px; font-size: 11px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--t-cap); }
  .feature h2 { font-size: 22px; letter-spacing: -.4px; line-height: 1.25; margin-bottom: 8px; }
  .feature p { font-size: 13.5px; color: var(--t-sub); margin-bottom: 18px; }
  .btn { display: inline-flex; align-items: center; gap: 10px; padding: 11px 20px; border: 1px solid var(--b-btn); border-radius: 6px; font-size: 13.5px; font-weight: 600; color: var(--white); transition: border-color .2s, background .2s; }
  .feature:hover .btn { border-color: var(--b-btn-hover); background: var(--bg-hover); }

  /* daftar tautan */
  .group { margin-bottom: 30px; }
  .group h2 { display: flex; align-items: center; gap: 14px; margin-bottom: 14px; font-family: 'Inter', sans-serif; font-size: 11.5px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--t-cap); }
  .group h2::after { content: ''; flex: 1; height: 1px; background: var(--b-default); }
  .group ul { list-style: none; display: grid; gap: 10px; }
  .lnk { display: flex; align-items: center; gap: 14px; padding: 14px 16px; background: transparent; border: 1px solid var(--b-btn); border-radius: 6px;
    transition: border-color .2s, background .2s, transform .2s; }
  .lnk:hover { border-color: var(--b-btn-hover); background: var(--bg-hover); transform: translateX(2px); }
  .ic { width: 40px; height: 40px; flex-shrink: 0; display: grid; place-items: center; border: 1px solid var(--b-default); border-radius: 8px; background: rgba(255,255,255,0.03); color: var(--white); }
  .ic svg { width: 19px; height: 19px; stroke: currentColor; fill: none; stroke-width: 1.7; stroke-linecap: round; stroke-linejoin: round; }
  .ic svg.fill { fill: currentColor; stroke: none; }
  .tx { flex: 1; min-width: 0; }
  .tx strong { display: block; font-size: 14.5px; font-weight: 600; line-height: 1.35; }
  .tx small { display: block; margin-top: 1px; font-size: 12.5px; color: var(--t-cap); line-height: 1.4; }
  .go { flex-shrink: 0; color: var(--white); opacity: .45; transition: transform .2s, opacity .2s; }
  .lnk:hover .go { transform: translateX(4px); opacity: 1; }

  footer { margin-top: 8px; padding-top: 24px; border-top: 1px solid var(--b-default); text-align: center; font-size: 12.5px; color: var(--t-cap); line-height: 1.7; }
  footer strong { font-size: 12.5px; font-weight: 700; }
  footer .addr { max-width: 360px; margin: 0 auto 10px; }

  /* animasi masuk */
  .rise { animation: rise .7s ease both; animation-delay: calc(var(--i, 0) * 70ms); }
  @keyframes rise { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: none; } }
  @media (prefers-reduced-motion: reduce) { *, *::before, *::after { animation: none !important; transition: none !important; } }

  @media (min-width: 640px) { .wrap { padding-top: 48px; } .identity { padding-top: 52px; } }
</style>
</head>
<body>
<main class="wrap">
  <button class="share" id="shareBtn" type="button" aria-label="Bagikan halaman ini"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="18" cy="5" r="2.5"/><circle cx="6" cy="12" r="2.5"/><circle cx="18" cy="19" r="2.5"/><path d="m8.2 10.8 7.6-4.4M8.2 13.2l7.6 4.4"/></svg></button>

  <header class="identity">
    <h1 class="sr-only">Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia</h1>
    <img class="logo rise" src="{{ asset('images/logo-dpm.svg') }}" alt="Logo DPM UII" onerror="if(!this.dataset.fb){this.dataset.fb=1;this.src='https://dpm.uii.ac.id/wp-content/uploads/2023/12/LOGO.svg'}">
    <p class="tag rise" style="--i:1">Lembaga Legislatif KM UII</p>
    <p class="handle rise" style="--i:2">@dpmuii</p>

    <div class="social rise" style="--i:3">
      <a href="https://www.instagram.com/dpmuii/" target="_blank" rel="noopener" aria-label="Instagram @dpmuii">
        <svg class="line" viewBox="0 0 24 24" aria-hidden="true"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
      </a>
      <a href="https://wa.me/6281511092004" target="_blank" rel="noopener" aria-label="WhatsApp DPM UII">
        <svg class="fill" viewBox="0 0 448 512" aria-hidden="true"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
      </a>
      <a href="https://tiktok.com/@dpmuii" target="_blank" rel="noopener" aria-label="TikTok @dpmuii">
        <svg class="fill" viewBox="0 0 448 512" aria-hidden="true"><path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122.18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z"/></svg>
      </a>
      <a href="https://youtube.com/@dpmuii" target="_blank" rel="noopener" aria-label="YouTube DPM UII">
        <svg class="fill" viewBox="0 0 576 512" aria-hidden="true"><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.583V174.334l142.739 81.666-142.739 81.666z"/></svg>
      </a>
      <a href="mailto:dpm@uii.ac.id" aria-label="Kirim Email">
        <svg class="line" viewBox="0 0 24 24" aria-hidden="true"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
      </a>
    </div>
  </header>

  <!-- Sorotan -->
  <a class="feature rise" style="--i:4" href="{{ route('home') }}">
    <span class="eyebrow">Sorotan</span>
    <h2>Portal Resmi DPM UII</h2>
    <p>Akses informasi terlengkap, produk hukum resmi, transparansi dana, dan publikasi DPM UII dalam satu pintu.</p>
    <span class="btn">Kunjungi Website <span aria-hidden="true">→</span></span>
  </a>

  <!-- Grup: Layanan & Informasi -->
  <section class="group rise" style="--i:5" aria-labelledby="g-layanan">
    <h2 id="g-layanan">Layanan &amp; Informasi</h2>
    <ul>
      <li>
        <a class="lnk" href="{{ route('legal-products.index') }}">
          <span class="ic"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg></span>
          <span class="tx">
            <strong>Produk Hukum KM UII</strong>
            <small>PDKM, GBHKM, PKM, dan PDPM UII</small>
          </span>
          <span class="go" aria-hidden="true">→</span>
        </a>
      </li>
      <li>
        <a class="lnk" href="{{ route('documents.index') }}">
          <span class="ic"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg></span>
          <span class="tx">
            <strong>Dokumen dan Publikasi</strong>
            <small>Keputusan, ketetapan, laporan kinerja, berita &amp; pengumuman</small>
          </span>
          <span class="go" aria-hidden="true">→</span>
        </a>
      </li>
      <li>
        <a class="lnk" href="{{ route('documents.dana') }}">
          <span class="ic"><svg viewBox="0 0 24 24" aria-hidden="true"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></span>
          <span class="tx">
            <strong>Transparansi Keuangan</strong>
            <small>Distribusi dana, alokasi, LPJ, dan laporan audit</small>
          </span>
          <span class="go" aria-hidden="true">→</span>
        </a>
      </li>
      <li>
        <a class="lnk" href="{{ url('/#aspirasi') }}">
          <span class="ic"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></span>
          <span class="tx">
            <strong>Kanal Aspirasi Mahasiswa</strong>
            <small>Sampaikan aspirasi, kritik, dan masukan Anda</small>
          </span>
          <span class="go" aria-hidden="true">→</span>
        </a>
      </li>
    </ul>
  </section>

  <!-- Grup: Publikasi & Profil -->
  <section class="group rise" style="--i:6" aria-labelledby="g-publikasi">
    <h2 id="g-publikasi">Publikasi &amp; Profil</h2>
    <ul>
      <li>
        <a class="lnk" href="{{ route('news.index') }}">
          <span class="ic"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/><path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/></svg></span>
          <span class="tx">
            <strong>Berita &amp; Siaran Pers</strong>
            <small>Kabar terbaru kegiatan legislatif mahasiswa</small>
          </span>
          <span class="go" aria-hidden="true">→</span>
        </a>
      </li>
      <li>
        <a class="lnk" href="{{ url('/tentang/struktur') }}">
          <span class="ic"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="2" y="3" width="6" height="6" rx="1"/><rect x="16" y="3" width="6" height="6" rx="1"/><rect x="9" y="15" width="6" height="6" rx="1"/><path d="M5 9v3a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V9"/><path d="M12 14v1"/></svg></span>
          <span class="tx">
            <strong>Struktur Organisasi</strong>
            <small>Pimpinan, komisi, dan alat kelengkapan dewan</small>
          </span>
          <span class="go" aria-hidden="true">→</span>
        </a>
      </li>
      <li>
        <a class="lnk" href="{{ route('humas.download') }}">
          <span class="ic"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg></span>
          <span class="tx">
            <strong>Unduh Template &amp; Font Resmi</strong>
            <small>Aset humas dan format dokumen resmi DPM</small>
          </span>
          <span class="go" aria-hidden="true">→</span>
        </a>
      </li>
    </ul>
  </section>

  <footer class="rise" style="--i:7">
    <p class="addr">Kampus Terpadu UII, Jl. Kaliurang KM 14.5, Sleman, D.I. Yogyakarta 55584</p>
    <p>Hak Cipta &copy; {{ date('Y') }} <strong>Sekretariat Jenderal DPM UII</strong></p>
  </footer>
</main>

<div class="toast" id="toast" role="status" aria-live="polite">Tautan berhasil disalin!</div>

<script>
  const shareBtn = document.getElementById('shareBtn');
  const toast = document.getElementById('toast');
  let tId;
  const showToast = (msg) => {
    toast.textContent = msg;
    toast.classList.add('show');
    clearTimeout(tId);
    tId = setTimeout(() => toast.classList.remove('show'), 2200);
  };
  shareBtn?.addEventListener('click', async () => {
    const data = { title: document.title, url: window.location.href };
    if (navigator.share) {
      try { await navigator.share(data); return; } catch (e) {}
    }
    try {
      await navigator.clipboard.writeText(window.location.href);
      showToast('Tautan berhasil disalin!');
    } catch (e) {
      showToast('Gagal menyalin tautan');
    }
  });
</script>
</body>
</html>
