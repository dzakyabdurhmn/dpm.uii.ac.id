@extends('layouts.site')

@section('title')
    {{ $unit->name }} — {{ $siteSettings['site_name'] ?? 'DPM UII' }}
@endsection

@section('meta_description')
    Susunan pengurus {{ $unit->name }} DPM UII pada periode kepengurusan aktif.
@endsection

@push('styles')
<style>
  .unit-page { color: rgba(255,255,255,.85); }
  .unit-hero { position: relative; overflow: hidden; padding: 56px 0 48px; border-bottom: 1px solid var(--b-default); background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%); }
  .unit-hero::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 28px); }
  .unit-hero .container { position: relative; }
  .unit-hero h1 { font-size: clamp(38px, 6vw, 68px); letter-spacing: -2px; line-height: 1.03; margin-bottom: 14px; }
  .unit-hero .crumb { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 18px; font-size: 12.5px; color: var(--t-cap); }
  .unit-hero .crumb a { transition: color .2s; } .unit-hero .crumb a:hover { color: var(--white); }
  .unit-hero .crumb span[aria-hidden] { opacity: .5; }
  .unit-hero .crumb span[aria-current] { color: var(--white); font-weight: 600; }
  .unit-hero .unit-desc { max-width: 640px; font-size: 15.5px; line-height: 1.7; color: var(--t-sub); margin-bottom: 18px; }
  .unit-hero .meta { display: flex; flex-wrap: wrap; gap: 10px; }
  .unit-hero .meta span { display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; border: 1px solid var(--b-btn); border-radius: 100px; font-size: 12.5px; font-weight: 600; color: var(--white); background: rgba(0,22,51,.5); }
  .unit-hero .meta span small { font-size: 11px; font-weight: 500; letter-spacing: .8px; text-transform: uppercase; color: var(--t-cap); }

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

  .unit-sec { padding: 80px 0; border-bottom: 1px solid var(--b-default); }
  .unit-sec.alt { background: var(--navy-footer); }
  .unit-head { display: flex; align-items: flex-end; justify-content: space-between; gap: 20px; flex-wrap: wrap; margin-bottom: 36px; }
  .unit-head .no { display: block; margin-bottom: 4px; font-family: 'Wix Madefor Display', sans-serif; font-size: 72px; font-weight: 800; line-height: .9; letter-spacing: -3px; color: transparent; -webkit-text-stroke: 1px rgba(255,255,255,.3); }
  .unit-head h2 { font-size: clamp(26px, 3.2vw, 38px); letter-spacing: -.9px; }
  .unit-head p { margin-top: 6px; font-size: 14.5px; color: var(--t-cap); }
  .unit-head .cnt { font-size: 12.5px; font-weight: 600; letter-spacing: 1.2px; text-transform: uppercase; color: var(--t-cap); }

  .av { position: relative; display: grid; place-items: center; overflow: hidden; background: linear-gradient(135deg, #002A5A, #001633); }
  .av::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, rgba(255,255,255,0.04) 0 1px, transparent 1px 18px); }
  .av .sil { position: absolute; left: 12%; right: 12%; bottom: 0; width: 76%; height: auto; fill: rgba(255,255,255,.10); stroke: rgba(255,255,255,.28); stroke-width: 1.2; }
  .av b { position: relative; font-family: 'Wix Madefor Display', sans-serif; font-weight: 800; letter-spacing: -1px; color: rgba(255,255,255,.4); }
  .av img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: top; }

  .lead { display: grid; grid-template-columns: 360px 1fr; border: 1px solid var(--b-btn); border-radius: 12px; background: var(--navy-card); overflow: hidden; box-shadow: var(--sh-md); cursor: pointer; transition: border-color .2s; }
  .lead:hover { border-color: var(--b-btn-hover); }
  .lead .av { min-height: 420px; } .lead .av b { font-size: 96px; }
  .lead-info { display: flex; flex-direction: column; justify-content: center; padding: 44px 48px; }
  .role { display: inline-block; align-self: flex-start; margin-bottom: 16px; padding: 4px 14px; border: 1px solid var(--b-btn); border-radius: 100px; font-size: 11.5px; font-weight: 600; letter-spacing: 1.6px; text-transform: uppercase; color: var(--white); }
  .lead-info h3 { font-size: clamp(30px, 4vw, 48px); letter-spacing: -1.4px; line-height: 1.08; margin-bottom: 14px; }
  .lead-info p { font-size: 15px; line-height: 1.8; color: var(--t-sub); max-width: 520px; }
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
  .empty { padding: 28px; border: 1px dashed var(--b-default); border-radius: 8px; text-align: center; color: var(--t-cap); font-size: 14px; }

  .pdlg2 { margin: auto; width: min(520px, calc(100vw - 32px)); padding: 0; border: 1px solid var(--b-btn); border-radius: 12px; background: var(--navy-card); color: var(--t-body); box-shadow: var(--sh-lg); }
  .pdlg2::backdrop { background: rgba(0,10,25,.72); backdrop-filter: blur(3px); }
  .pdlg2 .av { height: 240px; } .pdlg2 .av b { font-size: 72px; }
  .pd-body { padding: 26px 28px 28px; }
  .pd-body h3 { font-size: 26px; letter-spacing: -.6px; margin-bottom: 4px; }
  .pd-body .rl { margin-bottom: 18px; font-size: 13px; font-weight: 600; letter-spacing: 1.2px; text-transform: uppercase; color: var(--t-cap); }
  .pd-body dl { display: grid; grid-template-columns: 110px 1fr; gap: 10px 14px; padding: 16px 0; border-top: 1px solid var(--b-default); border-bottom: 1px solid var(--b-default); font-size: 14px; }
  .pd-body dt { color: var(--t-cap); } .pd-body dd { color: var(--white); }
  .pd-body p { margin-top: 16px; font-size: 14px; line-height: 1.8; color: var(--t-sub); }
  .pd-x { position: absolute; top: 12px; right: 12px; width: 36px; height: 36px; display: grid; place-items: center; border: 1px solid var(--b-btn); border-radius: 50%; background: rgba(0,22,51,.8); color: var(--white); font-size: 20px; line-height: 1; cursor: pointer; z-index: 2; }
  .pd-x:hover { border-color: var(--b-btn-hover); }

  @media (max-width: 1080px) { .g3 { grid-template-columns: 1fr 1fr; } .lead { grid-template-columns: 280px 1fr; } .lead-info { padding: 32px; } .subnav .ctrls { display: none; } }
  @media (max-width: 720px) { .unit-hero { padding: 36px 0 32px; } .unit-sec { padding: 52px 0; } .lead { grid-template-columns: 1fr; } .lead .av { min-height: 320px; } .lead-info { padding: 24px 22px 28px; } .g2, .g3 { grid-template-columns: 1fr; } .unit-head .no { font-size: 52px; } }
</style>
@endpush

@push('scripts')
<script>
  window.UNIT_DATA = @json($unitData ?? []);
  const $ = id => document.getElementById(id);
  const esc = s => String(s ?? '').replace(/[&<>"]/g, c => '&#' + c.charCodeAt(0) + ';');
  const ini = n => n.split(/\s+/).slice(0, 2).map(w => w[0]).join('').toUpperCase();
  const SIL = '<svg class="sil" viewBox="0 0 100 120" aria-hidden="true"><circle cx="50" cy="40" r="20"/><path d="M12 120c0-26 17-42 38-42s38 16 38 42z"/></svg>';

  function avatarHtml(a, size = 'default') {
    const cls = size === 'lead' ? 'av' : (size === 'big' ? 'av' : 'av');
    const hasPhoto = a.photo_path && a.photo_path.trim() !== '';
    const photoUrl = hasPhoto ? asset(a.photo_path) : '';
    const initials = ini(a.name);
    return '<div class="' + cls + '">' + SIL +
      (hasPhoto ? '<img src="' + esc(photoUrl) + '" alt="Foto ' + esc(a.name) + '" loading="lazy" onerror="this.remove()">' : '') +
      '<b>' + esc(initials) + '</b></div>';
  }

  function metaHtml(a) {
    const parts = [a.fakultas, a.prodi, a.angkatan ? 'Angkatan ' + a.angkatan : null].filter(Boolean);
    return parts.length ? '<span class="m">' + esc(parts.slice(0, 2).join(' · ')) + '</span>' : '';
  }

  let registry = [];
  function reg(a) { registry.push(a); return registry.length - 1; }

  function card(a, big = false) {
    return '<button type="button" class="mc' + (big ? ' big' : '') + '" data-i="' + reg(a) + '">' +
      avatarHtml(a, big ? 'big' : 'default') +
      '<span><small>' + esc(a.position) + '</small><h3>' + esc(a.name) + '</h3>' + metaHtml(a) + '</span></button>';
  }

  function lead(a, period) {
    const parts = [a.fakultas, a.prodi, a.angkatan ? 'Angkatan ' + a.angkatan : null].filter(Boolean);
    return '<div class="lead" role="button" tabindex="0" data-i="' + reg(a) + '">' +
      avatarHtml(a, 'lead') +
      '<div class="lead-info"><span class="role">' + esc(a.position) + '</span><h3>' + esc(a.name) + '</h3>' +
      '<p>Memimpin ' + esc(a.unit_name || '') + ' Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia periode ' + esc(period) + '.</p>' +
      (parts.length ? '<div class="facts-l">' + parts.map(x => '<span>' + esc(x) + '</span>').join('') + '</div>' : '') +
      '<span class="more">Lihat profil</span></div></div>';
  }

  function render() {
    const per = $('periode').value;
    const d = window.UNIT_DATA[per];
    if (!d) return;
    registry = [];

    // Lead
    const leadMember = d.lead;
    const leadBox = $('leadBox');
    if (leadBox) {
      leadBox.innerHTML = leadMember ? lead({...leadMember, unit_name: d.unit_name}, per) : '';
    }

    // Regular members
    const membersBox = $('membersBox');
    if (membersBox) {
      membersBox.innerHTML = d.members.length
        ? '<div class="g3">' + d.members.map(a => card(a)).join('') + '</div>'
        : '<p class="empty">Belum ada data anggota.</p>';
    }

    // Unassigned
    if (d.unassigned && d.unassigned.length) {
      const unBox = $('unassignedBox');
      if (unBox) {
        unBox.innerHTML = '<div class="g3">' + d.unassigned.map(a => card(a)).join('') + '</div>';
        $('unassignedSec')?.classList.remove('hidden');
      }
    } else {
      $('unassignedSec')?.classList.add('hidden');
    }

    buildToc(d);
    observe();
  }

  function buildToc(d) {
    const toc = $('toc');
    if (!toc) return;
    let html = '<li><a href="#lead"><em>01</em>Pimpinan</a></li>';
    if (d.members?.length) {
      html += '<li><a href="#anggota"><em>02</em>Anggota</a></li>';
    }
    if (d.unassigned?.length) {
      html += '<li><a href="#unassigned"><em>03</em>Tanpa Periode</a></li>';
    }
    toc.innerHTML = html;
  }

  const dlg = $('dlg');
  function openDialog(i) {
    const a = registry[i]; if (!a) return;
    const parts = [['Fakultas', a.fakultas], ['Program Studi', a.prodi], ['Angkatan', a.angkatan], ['NIM', a.nim]].filter(x => x[1]);
    $('dlgBody').innerHTML = avatarHtml(a, 'lead') +
      '<div class="pd-body"><h3>' + esc(a.name) + '</h3>' +
      '<div class="rl">' + esc(a.position) + ' · Periode ' + esc($('periode').value) + '</div>' +
      (parts.length ? '<dl>' + parts.map(x => '<dt>' + x[0] + '</dt><dd>' + esc(x[1]) + '</dd>').join('') + '</dl>' : '') +
      '<p>' + esc(a.name) + ' menjabat sebagai ' + esc(a.position) + ' ' + esc(a.unit_name || '') + ' Dewan Permusyawaratan Mahasiswa Universitas Islam Indonesia periode ' + esc($('periode').value) + '.</p></div>';
    dlg.showModal();
  }

  document.addEventListener('click', e => {
    const t = e.target.closest('[data-i]');
    if (t) openDialog(+t.dataset.i);
  });
  document.addEventListener('keydown', e => {
    if ((e.key === 'Enter' || e.key === ' ') && e.target.matches('.lead')) {
      e.preventDefault(); openDialog(+e.target.dataset.i);
    }
  });
  $('dlgX').addEventListener('click', () => dlg.close());
  dlg.addEventListener('click', e => { if (e.target === dlg) dlg.close(); });

  // Scrollspy + progress bar
  const links = [];
  let io;
  function observe() {
    if (io) io.disconnect();
    links.length = 0;
    document.querySelectorAll('#toc a').forEach(a => links.push(a));
    io = new IntersectionObserver(es => es.forEach(en => {
      if (en.isIntersecting) {
        links.forEach(a => a.removeAttribute('aria-current'));
        const a = links.find(l => l.getAttribute('href') === '#' + en.target.id);
        if (a) {
          a.setAttribute('aria-current', 'true');
          a.scrollIntoView({ block: 'nearest', inline: 'center' });
        }
      }
    }), { rootMargin: '-30% 0px -60% 0px' });
    links.forEach(l => { const s = document.querySelector(l.getAttribute('href')); if (s) io.observe(s); });
  }

  const bar = $('subnav');
  function prog() {
    const f = $('leadSec');
    if (!f) return;
    const s = f.offsetTop - 200;
    const e = document.documentElement.scrollHeight - innerHeight;
    bar.style.setProperty('--p', Math.min(1, Math.max(0, (scrollY - s) / Math.max(1, e - s))).toFixed(3));
  }
  addEventListener('scroll', prog, { passive: true });

  const sel = $('periode');
  sel.addEventListener('change', render);

  render(); prog();
</script>
@endpush

@section('content')
<div class="unit-page">

  <!-- HERO -->
  <section class="unit-hero">
    <div class="container">
      <nav class="crumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Beranda</a>
        <span aria-hidden="true">/</span>
        <a href="{{ route('units.index') }}">Alat Kelengkapan</a>
        <span aria-hidden="true">/</span>
        <span aria-current="page">{{ $unit->short_name }}</span>
      </nav>
      <span class="eyebrow">Alat Kelengkapan</span>
      <h1>{{ $unit->name }}</h1>
      @if ($unit->abbreviation && $unit->abbreviation !== $unit->name)
        <p class="unit-desc">{{ $unit->short_name }}</p>
      @endif
      @if ($unit->description)
        <p class="unit-desc">{{ $unit->description }}</p>
      @endif
      <div class="meta">
        <span>Total Anggota <small>{{ $totalMembers ?? 0 }}</small></span>
        <span>Jabatan Unik <small>{{ $uniquePositions ?? 0 }}</small></span>
      </div>
    </div>
  </section>

  <!-- SUBNAV + PERIODE -->
  <div class="subnav" id="subnav">
    <div class="container subnav-inner">
      <ol id="toc" aria-label="Navigasi {{ $unit->short_name }}"></ol>
      <div class="ctrls">
        <label class="sel">
          <select id="periode" aria-label="Periode kepengurusan">
            @foreach (array_keys($unitData ?? []) as $periodName)
              <option value="{{ $periodName }}" @selected($loop->first)>Periode {{ $periodName }}</option>
            @endforeach
          </select>
        </label>
      </div>
    </div>
  </div>

  <!-- PIMPIMAN / LEAD -->
  <section class="unit-sec" id="leadSec" aria-labelledby="h-lead">
    <div class="container">
      <div class="unit-head">
        <div>
          <span class="no" aria-hidden="true">01</span>
          <h2 id="h-lead">Pimpinan {{ $unit->short_name }}</h2>
          <p>Ketua, Sekretaris, Bendahara, dan jajaran pimpinan.</p>
        </div>
      </div>
      <div id="leadBox"></div>
    </div>
  </section>

  <!-- ANGGOTA -->
  <section class="unit-sec alt" id="anggotaSec" aria-labelledby="h-anggota">
    <div class="container">
      <div class="unit-head">
        <div>
          <span class="no" aria-hidden="true">02</span>
          <h2 id="h-anggota">Anggota</h2>
          <p>Daftar anggota aktif pada periode terpilih.</p>
        </div>
      </div>
      <div id="membersBox"></div>
    </div>
  </section>

  <!-- TANPA PERIODE -->
  <section class="unit-sec" id="unassignedSec" aria-labelledby="h-unassigned" hidden>
    <div class="container">
      <div class="unit-head">
        <div>
          <span class="no" aria-hidden="true">03</span>
          <h2 id="h-unassigned">Anggota (Tanpa Periode)</h2>
          <p>Data anggota yang belum terikat periode kepengurusan.</p>
        </div>
      </div>
      <div id="unassignedBox"></div>
    </div>
  </section>

  <!-- DIALOG PROFIL -->
  <dialog class="pdlg2" id="dlg" aria-label="Profil anggota">
    <button class="pd-x" type="button" id="dlgX" aria-label="Tutup">&times;</button>
    <div id="dlgBody"></div>
  </dialog>

</div>
@endsection