@extends('layouts.site')

@section('title', $unit->name.' — '.($siteSettings['site_name'] ?? 'DPM UII'))

@push('styles')
<style>
    /* ============ UNIT SHOW PAGE - Dark Navy Theme ============ */
    .unit-show-page { background: var(--navy, #001E43); color: var(--t-body, rgba(255,255,255,0.85)); }

    /* CSS Variables (matching anggota.html) */
    :root {
        --navy: #001E43;
        --navy-footer: #001633;
        --navy-card: #001A3A;
        --navy-hover: #002451;
        --navy-active: #002A5A;
        --white: #FFFFFF;
        --t-body: rgba(255,255,255,0.85);
        --t-sub: rgba(255,255,255,0.75);
        --t-cap: rgba(255,255,255,0.62);
        --b-default: rgba(255,255,255,0.10);
        --b-btn: rgba(255,255,255,0.30);
        --b-btn-hover: rgba(255,255,255,0.55);
        --bg-hover: rgba(255,255,255,0.06);
        --sh-sm: 0 4px 12px rgba(0,0,0,0.25);
        --sh-md: 0 8px 24px rgba(0,0,0,0.40);
        --sh-lg: 0 16px 48px rgba(0,0,0,0.55);
        --container: 1200px;
    }

    * { box-sizing: border-box; }
    body { font-family: 'Inter', system-ui, -apple-system, sans-serif; -webkit-font-smoothing: antialiased; }
    h1, h2, h3, h4 { font-family: 'Wix Madefor Display', 'Inter', sans-serif; color: var(--white); }
    a { color: inherit; text-decoration: none; }

    .container { width: 100%; max-width: var(--container); margin: 0 auto; padding: 0 24px; }

    /* ---------- Buttons ---------- */
    .btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 10px;
        padding: 13px 26px; background: transparent; border: 1px solid var(--b-btn);
        border-radius: 6px; color: var(--white); font-size: 14px; font-weight: 600;
        transition: border-color .2s, background .2s;
    }
    .btn:hover { border-color: var(--b-btn-hover); background: var(--bg-hover); }
    .btn svg { width: 14px; height: 14px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; transition: transform .2s; }
    .btn:hover svg { transform: translateX(3px); }

    .link-more {
        display: inline-flex; align-items: center; gap: 8px;
        font-size: 13px; font-weight: 600; color: var(--white);
        border-bottom: 1px solid var(--b-btn); padding-bottom: 2px;
        transition: border-color .2s;
    }
    .link-more:hover { border-color: var(--b-btn-hover); }

    /* ---------- Page Head ---------- */
    .pg-head {
        position: relative; border-bottom: 1px solid var(--b-default);
        padding: 52px 0 56px;
        background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%);
        overflow: hidden;
    }
    .pg-head::before {
        content: ''; position: absolute; inset: 0;
        background: repeating-linear-gradient(135deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 28px);
    }
    .pg-head-inner { position: relative; display: grid; grid-template-columns: 1.35fr .65fr; gap: 56px; align-items: end; }
    .crumb { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 26px; font-size: 12.5px; color: var(--t-cap); }
    .crumb a { transition: color .2s; }
    .crumb a:hover { color: var(--white); }
    .crumb span[aria-hidden] { opacity: .5; }
    .crumb span[aria-current] { color: var(--white); font-weight: 600; }
    .pg-head h1 { font-size: clamp(36px, 6vw, 64px); letter-spacing: -1.5px; line-height: 1.05; margin-bottom: 10px; }
    .pg-sub { font-family: 'Wix Madefor Display', sans-serif; font-size: clamp(16px, 2vw, 20px); font-weight: 600; color: var(--t-body); margin-bottom: 14px; }
    .pg-desc { max-width: 600px; font-size: 15px; color: var(--t-sub); }

    .pg-stats { border: 1px solid var(--b-btn); border-radius: 8px; background: rgba(0,22,51,.55); backdrop-filter: blur(6px); -webkit-backdrop-filter: blur(6px); }
    .pg-stat { display: flex; align-items: baseline; justify-content: space-between; gap: 16px; padding: 16px 22px; }
    .pg-stat + .pg-stat { border-top: 1px solid var(--b-default); }
    .pg-stat span { font-size: 12px; font-weight: 600; letter-spacing: 1.2px; text-transform: uppercase; color: var(--t-cap); }
    .pg-stat strong { font-family: 'Wix Madefor Display', sans-serif; font-size: 26px; font-weight: 800; color: var(--white); letter-spacing: -.5px; }

    /* ---------- About Unit ---------- */
    .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 28px; }
    .about-grid .card { padding: 36px; }
    .about-grid h3 { font-size: 18px; margin-bottom: 22px; }
    .tugas { list-style: none; counter-reset: t; display: grid; gap: 14px; }
    .tugas li { counter-increment: t; display: grid; grid-template-columns: 34px 1fr; gap: 14px; font-size: 14px; color: var(--t-sub); line-height: 1.6; }
    .tugas li::before { content: counter(t, decimal-leading-zero); font-family: 'Wix Madefor Display', sans-serif; font-size: 13px; font-weight: 700; color: var(--white); padding-top: 1px; }
    .proker { list-style: none; display: grid; gap: 0; }
    .proker li { padding: 14px 0; border-bottom: 1px solid var(--b-default); }
    .proker li:first-child { padding-top: 0; }
    .proker li:last-child { border-bottom: 0; padding-bottom: 0; }
    .proker strong { display: block; font-size: 14.5px; font-weight: 600; color: var(--white); margin-bottom: 3px; }
    .proker span { font-size: 13px; color: var(--t-cap); line-height: 1.55; }

    /* ---------- Toolbar ---------- */
    .toolbar { display: flex; flex-wrap: wrap; align-items: center; gap: 16px; margin-bottom: 52px; }
    .tb-field { position: relative; }
    .tb-field svg { position: absolute; left: 14px; top: 50%; width: 16px; height: 16px; margin-top: -8px; stroke: var(--t-cap); fill: none; stroke-width: 2; stroke-linecap: round; pointer-events: none; }
    .tb-input {
        height: 44px; padding: 0 16px; padding-left: 40px; background: rgba(255,255,255,0.03);
        border: 1px solid var(--b-default); border-radius: 6px; color: var(--white); font-size: 14px;
        transition: border-color .2s, background .2s;
        width: 360px;
    }
    .tb-input::placeholder { color: rgba(255,255,255,0.38); }
    .tb-input:focus { outline: none; border-color: var(--b-btn-hover); background: rgba(255,255,255,0.05); }

    /* Period Dropdown (shadcn/ui style) */
    .period-dropdown { position: relative; }
    .tb-select-trigger {
        display: inline-flex; align-items: center; justify-content: space-between; gap: 12px;
        height: 44px; padding: 0 16px; padding-right: 44px; background: rgba(255,255,255,0.03);
        border: 1px solid var(--b-default); border-radius: 6px; color: var(--white); font-size: 14px;
        transition: border-color .2s, background .2s; cursor: pointer;
        min-width: 220px;
    }
    .tb-select-trigger:hover { border-color: var(--b-btn); background: var(--bg-hover); }
    .tb-select-trigger:focus { outline: none; border-color: var(--b-btn-hover); background: rgba(255,255,255,0.05); }
    .tb-select-trigger .chevron { width: 16px; height: 16px; flex-shrink: 0; stroke: var(--t-sub); transition: transform .2s; }
    .period-dropdown.open .tb-select-trigger .chevron { transform: rotate(180deg); }
    .tb-select-trigger:focus { outline: none; border-color: var(--b-btn-hover); background: rgba(255,255,255,0.05); }

    .tb-select-content {
        position: absolute; top: calc(100% + 8px); left: 0; right: 0; z-index: 50;
        background: var(--navy-card); border: 1px solid var(--b-default); border-radius: 8px;
        box-shadow: var(--sh-lg); padding: 8px; max-height: 280px; overflow-y: auto;
    }
    .tb-select-item {
        display: flex; align-items: center; padding: 10px 14px; border-radius: 6px;
        font-size: 14px; color: var(--t-body); cursor: pointer; transition: background .15s, color .15s;
    }
    .tb-select-item:hover, .tb-select-item[aria-selected="true"] {
        background: var(--bg-hover); color: var(--white);
    }
    .tb-select-item[aria-selected="true"] { font-weight: 600; }

    .tb-count { margin-left: auto; font-size: 13px; color: var(--t-cap); }
    .tb-count b { color: var(--white); }

    .group-title { display: flex; align-items: center; gap: 16px; margin-bottom: 28px; font-size: 12px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--t-cap); }
    .group-title::after { content: ''; flex: 1; height: 1px; background: var(--b-default); }
    .group { margin-bottom: 60px; }

    .lead-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 28px; }
    .member-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 24px; }

    /* ---------- Member Cards ---------- */
    .mcard {
        width: 100%; padding: 0; text-align: left; color: inherit; display: flex; flex-direction: column; cursor: pointer; overflow: hidden;
        background: var(--navy-card); border: 1px solid var(--b-default); border-radius: 8px;
        transition: border-color .25s, background .25s, transform .25s, box-shadow .25s;
    }
    .mcard:hover { background: var(--navy-hover); border-color: var(--b-btn); transform: translateY(-2px); box-shadow: var(--sh-md); }
    .mphoto { position: relative; aspect-ratio: 4 / 3.3; display: grid; place-items: center; overflow: hidden; background: linear-gradient(135deg, #002A5A 0%, #001E43 60%, #001633 100%); }
    .mphoto::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, rgba(255,255,255,0.04) 0 1px, transparent 1px 22px); }
    .mphoto img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: top center; transition: transform .5s ease; }
    .mcard:hover .mphoto img { transform: scale(1.04); }
    .initials { position: relative; width: 84px; height: 84px; display: grid; place-items: center; border: 1px solid var(--b-btn); border-radius: 50%; background: rgba(255,255,255,.05); font-family: 'Wix Madefor Display', sans-serif; font-size: 30px; font-weight: 800; letter-spacing: 1px; color: var(--white); }
    .ptag { position: absolute; top: 12px; left: 12px; z-index: 2; padding: 3px 10px; border: 1px solid var(--b-btn); border-radius: 100px; background: rgba(0,22,51,.82); font-size: 10.5px; font-weight: 600; letter-spacing: 1px; color: var(--white); }
    .mbody { padding: 16px 18px 4px; flex: 1; }
    .mbody h3 { font-size: 16.5px; letter-spacing: -.2px; line-height: 1.3; margin-bottom: 4px; }
    .mrole { font-size: 13px; font-weight: 600; color: var(--t-sub); }
    .mmeta { margin-top: 8px; font-size: 12px; color: var(--t-cap); line-height: 1.5; }
    .mmore { display: flex; align-items: center; justify-content: space-between; margin: 12px 18px 16px; padding-top: 12px; border-top: 1px solid var(--b-default); font-size: 12.5px; font-weight: 600; color: var(--white); }
    .mmore i { font-style: normal; transition: transform .2s; }
    .mcard:hover .mmore i { transform: translateX(4px); }

    .mcard.lead { flex-direction: row; }
    .mcard.lead .mphoto { flex: 0 0 38%; aspect-ratio: auto; min-height: 210px; }
    .mcard.lead .mbody { padding: 22px 22px 4px; }
    .mcard.lead .mbody h3 { font-size: 20px; }
    .mcard.lead .col { display: flex; flex-direction: column; flex: 1; min-width: 0; }
    .mcard.lead .mmore { margin: 14px 22px 20px; }

    .empty { padding: 56px 24px; text-align: center; border: 1px dashed var(--b-btn); border-radius: 8px; color: var(--t-cap); font-size: 14.5px; }
    .empty strong { display: block; margin-bottom: 6px; font-family: 'Wix Madefor Display', sans-serif; font-size: 17px; color: var(--white); }

    /* ---------- Profile Modal ---------- */
    .mdlg {
        margin: auto; padding: 0; width: min(780px, calc(100vw - 32px)); max-height: calc(100vh - 48px); overflow: auto;
        background: var(--navy-card); color: var(--t-body); border: 1px solid var(--b-btn); border-radius: 12px; box-shadow: var(--sh-lg);
    }
    .mdlg::backdrop { background: rgba(0,0,0,.6); }
    .mdlg-grid { display: grid; grid-template-columns: 260px 1fr; min-height: 340px; }
    .mdlg-photo { position: relative; display: grid; place-items: center; overflow: hidden; background: linear-gradient(135deg, #002A5A 0%, #001E43 60%, #001633 100%); }
    .mdlg-photo::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, rgba(255,255,255,0.04) 0 1px, transparent 1px 22px); }
    .mdlg-photo img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: top center; }
    .mdlg-photo .initials { width: 110px; height: 110px; font-size: 40px; }
    .mdlg-body { position: relative; padding: 34px 34px 30px; }
    .mdlg-close { position: absolute; top: 14px; right: 14px; width: 36px; height: 36px; display: grid; place-items: center; background: transparent; border: 1px solid var(--b-btn); border-radius: 6px; color: var(--white); transition: border-color .2s, background .2s; }
    .mdlg-close:hover { border-color: var(--b-btn-hover); background: var(--bg-hover); }
    .mdlg-close svg { width: 16px; height: 16px; stroke: currentColor; stroke-width: 2; stroke-linecap: round; fill: none; }
    .mdlg-body h2 { font-size: 26px; letter-spacing: -.5px; line-height: 1.2; margin: 4px 40px 4px 0; }
    .mdlg-role { font-size: 14.5px; font-weight: 600; color: var(--t-sub); margin-bottom: 22px; }
    .mdlg dl { display: grid; grid-template-columns: 1fr 1fr; gap: 16px 20px; padding: 20px 0; margin-bottom: 18px; border-top: 1px solid var(--b-default); border-bottom: 1px solid var(--b-default); }
    .mdlg dt { font-size: 11px; font-weight: 600; letter-spacing: 1.4px; text-transform: uppercase; color: var(--t-cap); margin-bottom: 3px; }
    .mdlg dd { font-size: 14px; font-weight: 500; color: var(--white); }
    .mdlg dd.muted { color: var(--t-cap); font-weight: 400; }
    .mdlg-bio { font-size: 14px; color: var(--t-sub); line-height: 1.7; }

    /* ---------- CTA ---------- */
    .cta { display: flex; align-items: center; justify-content: space-between; gap: 32px; flex-wrap: wrap; padding: 40px; border: 1px solid var(--b-btn); border-radius: 12px; background: var(--navy-card); }
    .cta h2 { font-size: clamp(22px, 3vw, 30px); letter-spacing: -.5px; margin-bottom: 8px; }
    .cta p { max-width: 520px; font-size: 14.5px; color: var(--t-sub); }
    .cta-actions { display: flex; flex-wrap: wrap; gap: 12px; }

    /* ---------- Responsive ---------- */
    @media (max-width: 1080px) {
        .pg-head-inner { grid-template-columns: 1fr; gap: 36px; }
        .pg-stats { display: grid; grid-template-columns: repeat(3, 1fr); }
        .pg-stat { flex-direction: column; align-items: flex-start; gap: 4px; }
        .pg-stat + .pg-stat { border-top: 0; border-left: 1px solid var(--b-default); }
        .about-grid, .lead-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 720px) {
        .pg-head { padding: 36px 0 40px; }
        .pg-stat { padding: 14px 16px; }
        .pg-stat strong { font-size: 21px; }
        .tb-field, .tb-input { width: 100%; }
        .tb-count { margin-left: 0; width: 100%; }
        .mcard.lead { flex-direction: column; }
        .mcard.lead .mphoto { flex: none; min-height: 0; aspect-ratio: 4 / 2.6; }
        .member-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
        .mbody { padding: 12px 12px 2px; }
        .mbody h3 { font-size: 14.5px; }
        .mmore { margin: 10px 12px 12px; }
        .initials { width: 64px; height: 64px; font-size: 22px; }
        .mdlg-grid { grid-template-columns: 1fr; }
        .mdlg-photo { height: 200px; }
        .mdlg-body { padding: 26px 22px 24px; }
        .cta { padding: 28px 22px; }
    }
    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after { animation: none !important; transition: none !important; }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Custom Period Dropdown (shadcn/ui style)
    const periodDropdown = document.getElementById('periodDropdown');
    const periodTrigger = document.getElementById('periodTrigger');
    const periodValue = document.getElementById('periodValue');
    const periodContent = document.getElementById('periodContent');
    const periodItems = periodContent ? periodContent.querySelectorAll('.tb-select-item') : [];

    let selectedPeriod = 'all';

    function toggleDropdown(open) {
        if (!periodDropdown) return;
        if (open === undefined) open = !periodDropdown.classList.contains('open');
        if (open) {
            periodDropdown.classList.add('open');
            periodTrigger.setAttribute('aria-expanded', 'true');
            periodContent.hidden = false;
        } else {
            periodDropdown.classList.remove('open');
            periodTrigger.setAttribute('aria-expanded', 'false');
            periodContent.hidden = true;
        }
    }

    function selectPeriod(value, label) {
        selectedPeriod = value;
        if (periodValue) periodValue.textContent = label;
        periodItems.forEach(item => {
            item.setAttribute('aria-selected', item.dataset.value === value);
        });
        toggleDropdown(false);
        filterMembers();
    }

    if (periodTrigger) {
        periodTrigger.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleDropdown();
        });
    }

    periodItems.forEach(item => {
        item.addEventListener('click', () => {
            selectPeriod(item.dataset.value, item.textContent);
        });
        item.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                selectPeriod(item.dataset.value, item.textContent);
            }
        });
    });

    document.addEventListener('click', (e) => {
        if (periodDropdown && !periodDropdown.contains(e.target)) {
            toggleDropdown(false);
        }
    });

    // Search and period filter
    const searchInput = document.getElementById('searchInput');
    const countEl = document.getElementById('visibleCount');

    function filterMembers() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        let visibleCount = 0;

        document.querySelectorAll('.group').forEach(group => {
            const groupPeriod = group.dataset.period;
            const periodMatch = selectedPeriod === 'all' || selectedPeriod === groupPeriod;

            let groupVisibleCards = 0;
            group.querySelectorAll('.mcard').forEach(card => {
                const name = card.querySelector('h3')?.textContent?.toLowerCase() || '';
                const role = card.querySelector('.mrole')?.textContent?.toLowerCase() || '';
                const searchMatch = !query || name.includes(query) || role.includes(query);

                if (periodMatch && searchMatch) {
                    card.style.display = '';
                    groupVisibleCards++;
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (periodMatch && (groupVisibleCards > 0 || !query)) {
                group.style.display = '';
            } else {
                group.style.display = 'none';
            }
        });

        if (countEl) countEl.textContent = visibleCount;
    }

    if (searchInput) searchInput.addEventListener('input', filterMembers);

    // Profile modal
    const modal = document.getElementById('profileModal');
    const modalClose = document.getElementById('modalClose');
    const modalTriggers = document.querySelectorAll('[data-modal-trigger]');

    function openModal(official) {
        if (!modal) return;
        document.getElementById('modalPhoto').style.display = official.photo_path ? 'block' : 'none';
        document.getElementById('modalInitials').style.display = official.photo_path ? 'none' : 'grid';
        if (official.photo_path) {
            document.getElementById('modalPhoto').src = official.photo_path;
        } else {
            document.getElementById('modalInitials').textContent = official.initials;
        }
        document.getElementById('modalName').textContent = official.name;
        document.getElementById('modalPosition').textContent = official.position;
        document.getElementById('modalPeriod').textContent = official.period_name || '—';
        document.getElementById('modalEmail').textContent = official.email || '—';
        document.getElementById('modalInstagram').textContent = official.instagram ? '@' + official.instagram : '—';
        document.getElementById('modalLinkedin').textContent = official.linkedin || '—';
        document.getElementById('modalBio').textContent = official.description || '—';
        modal.showModal();
    }

    function closeModal() {
        if (modal) modal.close();
    }

    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            const data = JSON.parse(this.dataset.modalTrigger);
            openModal(data);
        });
    });

    if (modalClose) modalClose.addEventListener('click', closeModal);
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeModal();
        });
    }
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
    });
});
</script>
@endpush

@section('content')
<div class="unit-show-page">
    <!-- ============ PAGE HEAD ============ -->
    <section class="pg-head">
        <div class="container pg-head-inner">
            <div>
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
                    <p class="pg-sub">{{ $unit->short_name }}</p>
                @endif
                @if ($unit->description)
                    <p class="pg-desc">{{ $unit->description }}</p>
                @endif
            </div>
            <aside class="pg-stats" aria-label="Statistik unit">
                <div class="pg-stat">
                    <span>Total Anggota</span>
                    <strong>{{ $officials->count() }}</strong>
                </div>
                <div class="pg-stat">
                    <span>Periode Aktif</span>
                    <strong>{{ $periods->where('is_active', true)->count() }}</strong>
                </div>
                <div class="pg-stat">
                    <span>Jabatan Unik</span>
                    <strong>{{ $officials->pluck('position')->unique()->count() }}</strong>
                </div>
            </aside>
        </div>
    </section>

    <main class="container" style="padding-top: 48px; padding-bottom: 96px;">
        <!-- ============ ABOUT UNIT ============ -->
        @if ($unit->tasks || $unit->work_programs)
        <section class="about-grid reveal" aria-labelledby="about-heading">
            <div class="card">
                <h3>Tugas & Fungsi</h3>
                @if ($unit->tasks)
                    <ul class="tugas">
                        @foreach (explode("\n", $unit->tasks) as $task)
                            @if (trim($task))
                                <li>{{ trim($task) }}</li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <p style="color: var(--t-cap);">Belum ada data tugas.</p>
                @endif
            </div>
            <div class="card">
                <h3>Program Kerja</h3>
                @if ($unit->work_programs)
                    <ul class="proker">
                        @foreach (explode("\n", $unit->work_programs) as $program)
                            @if (trim($program))
                                <li><strong>{{ trim($program) }}</strong><span>Detail program kerja akan diisi.</span></li>
                            @endif
                        @endforeach
                    </ul>
                @else
                    <p style="color: var(--t-cap);">Belum ada data program kerja.</p>
                @endif
            </div>
        </section>
        @endif

        <!-- ============ TOOLBAR ============ -->
        <div class="toolbar">
            <div class="tb-field">
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.3-4.3"/></svg>
                <input type="search" id="searchInput" class="tb-input" placeholder="Cari nama, jabatan..." aria-label="Cari anggota">
            </div>
            <!-- Custom Period Dropdown (shadcn/ui style) -->
            <div class="period-dropdown" id="periodDropdown">
                <button type="button" class="tb-select-trigger" id="periodTrigger" aria-haspopup="listbox" aria-expanded="false" aria-label="Filter periode">
                    <span id="periodValue">Semua Periode</span>
                    <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
                </button>
                <div class="tb-select-content" id="periodContent" role="listbox" aria-label="Filter periode" hidden>
                    <div class="tb-select-item" role="option" data-value="all" aria-selected="true">Semua Periode</div>
                    @foreach ($periods as $period)
                        <div class="tb-select-item" role="option" data-value="{{ $period->id }}">{{ $period->name }}</div>
                    @endforeach
                    <div class="tb-select-item" role="option" data-value="unassigned">Tanpa Periode</div>
                </div>
            </div>
            <div class="tb-count">Menampilkan <b id="visibleCount">{{ $officials->count() }}</b> dari {{ $officials->count() }} anggota</div>
        </div>

        <!-- ============ MEMBERS BY PERIOD ============ -->
        @if ($officials->isEmpty())
            <div class="empty reveal">
                <strong>Data anggota belum tersedia</strong>
                Belum ada pengurus yang terdaftar untuk unit ini.
            </div>
        @else
            @foreach ($periods as $period)
                @php
                    $members = $officials->where('period_id', $period->id);
                    $leadMembers = $members->whereIn('position', ['Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara']);
                    $regularMembers = $members->whereNotIn('position', ['Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara']);
                @endphp

                @if ($members->isNotEmpty())
                <section class="group reveal" data-period="{{ $period->id }}">
                    <div class="group-title">Periode {{ $period->name }}</div>

                    @if ($leadMembers->isNotEmpty())
                    <div class="lead-grid">
                        @foreach ($leadMembers as $official)
                            <article class="mcard lead" data-modal-trigger='{
                                "name": "{{ addslashes($official->name) }}",
                                "position": "{{ addslashes($official->position) }}",
                                "period_name": "{{ addslashes($period->name) }}",
                                "email": "{{ addslashes($official->email ?? '') }}",
                                "instagram": "{{ addslashes($official->instagram ?? '') }}",
                                "linkedin": "{{ addslashes($official->linkedin ?? '') }}",
                                "description": "{{ addslashes($official->description ?? '') }}",
                                "photo_path": "{{ $official->photo_path ? asset($official->photo_path) : '' }}",
                                "initials": "{{ strtoupper(Str::substr($official->name, 0, 1)) }}"
                            }'>
                                <div class="mphoto">
                                    @if ($official->photo_path)
                                        <img src="{{ asset($official->photo_path) }}" alt="{{ $official->name }}" loading="lazy">
                                    @else
                                        <div class="initials">{{ Str::substr($official->name, 0, 1) }}</div>
                                    @endif
                                    <span class="ptag">{{ $official->position }}</span>
                                </div>
                                <div class="col">
                                    <div class="mbody">
                                        <h3>{{ $official->name }}</h3>
                                        <p class="mrole">{{ $official->position }}</p>
                                        <p class="mmeta">Periode {{ $period->name }}</p>
                                    </div>
                                    <div class="mmore">
                                        <span>Lihat profil</span>
                                        <i aria-hidden="true">→</i>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    @endif

                    @if ($regularMembers->isNotEmpty())
                    <div class="member-grid">
                        @foreach ($regularMembers as $official)
                            <article class="mcard" data-modal-trigger='{
                                "name": "{{ addslashes($official->name) }}",
                                "position": "{{ addslashes($official->position) }}",
                                "period_name": "{{ addslashes($period->name) }}",
                                "email": "{{ addslashes($official->email ?? '') }}",
                                "instagram": "{{ addslashes($official->instagram ?? '') }}",
                                "linkedin": "{{ addslashes($official->linkedin ?? '') }}",
                                "description": "{{ addslashes($official->description ?? '') }}",
                                "photo_path": "{{ $official->photo_path ? asset($official->photo_path) : '' }}",
                                "initials": "{{ strtoupper(Str::substr($official->name, 0, 1)) }}"
                            }'>
                                <div class="mphoto">
                                    @if ($official->photo_path)
                                        <img src="{{ asset($official->photo_path) }}" alt="{{ $official->name }}" loading="lazy">
                                    @else
                                        <div class="initials">{{ Str::substr($official->name, 0, 1) }}</div>
                                    @endif
                                    <span class="ptag">{{ $official->position }}</span>
                                </div>
                                <div class="mbody">
                                    <h3>{{ $official->name }}</h3>
                                    <p class="mrole">{{ $official->position }}</p>
                                    <p class="mmeta">Periode {{ $period->name }}</p>
                                </div>
                                <div class="mmore">
                                    <span>Lihat profil</span>
                                    <i aria-hidden="true">→</i>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    @endif
                </section>
                @endif
            @endforeach

            @if ($unassigned->isNotEmpty())
            <section class="group reveal" data-period="unassigned">
                <div class="group-title">Anggota (Tanpa Periode)</div>

                @php
                    $leadUnassigned = $unassigned->whereIn('position', ['Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara']);
                    $regularUnassigned = $unassigned->whereNotIn('position', ['Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara']);
                @endphp

                @if ($leadUnassigned->isNotEmpty())
                <div class="lead-grid">
                    @foreach ($leadUnassigned as $official)
                        <article class="mcard lead" data-modal-trigger='{
                            "name": "{{ addslashes($official->name) }}",
                            "position": "{{ addslashes($official->position) }}",
                            "period_name": "—",
                            "email": "{{ addslashes($official->email ?? '') }}",
                            "instagram": "{{ addslashes($official->instagram ?? '') }}",
                            "linkedin": "{{ addslashes($official->linkedin ?? '') }}",
                            "description": "{{ addslashes($official->description ?? '') }}",
                            "photo_path": "{{ $official->photo_path ? asset($official->photo_path) : '' }}",
                            "initials": "{{ strtoupper(Str::substr($official->name, 0, 1)) }}"
                        }'>
                            <div class="mphoto">
                                @if ($official->photo_path)
                                    <img src="{{ asset($official->photo_path) }}" alt="{{ $official->name }}" loading="lazy">
                                @else
                                    <div class="initials">{{ Str::substr($official->name, 0, 1) }}</div>
                                @endif
                                <span class="ptag">{{ $official->position }}</span>
                            </div>
                            <div class="col">
                                <div class="mbody">
                                    <h3>{{ $official->name }}</h3>
                                    <p class="mrole">{{ $official->position }}</p>
                                </div>
                                <div class="mmore">
                                    <span>Lihat profil</span>
                                    <i aria-hidden="true">→</i>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                @endif

                @if ($regularUnassigned->isNotEmpty())
                <div class="member-grid">
                    @foreach ($regularUnassigned as $official)
                        <article class="mcard" data-modal-trigger='{
                            "name": "{{ addslashes($official->name) }}",
                            "position": "{{ addslashes($official->position) }}",
                            "period_name": "—",
                            "email": "{{ addslashes($official->email ?? '') }}",
                            "instagram": "{{ addslashes($official->instagram ?? '') }}",
                            "linkedin": "{{ addslashes($official->linkedin ?? '') }}",
                            "description": "{{ addslashes($official->description ?? '') }}",
                            "photo_path": "{{ $official->photo_path ? asset($official->photo_path) : '' }}",
                            "initials": "{{ strtoupper(Str::substr($official->name, 0, 1)) }}"
                        }'>
                            <div class="mphoto">
                                @if ($official->photo_path)
                                    <img src="{{ asset($official->photo_path) }}" alt="{{ $official->name }}" loading="lazy">
                                @else
                                    <div class="initials">{{ Str::substr($official->name, 0, 1) }}</div>
                                @endif
                                <span class="ptag">{{ $official->position }}</span>
                            </div>
                            <div class="mbody">
                                <h3>{{ $official->name }}</h3>
                                <p class="mrole">{{ $official->position }}</p>
                            </div>
                            <div class="mmore">
                                <span>Lihat profil</span>
                                <i aria-hidden="true">→</i>
                            </div>
                        </article>
                    @endforeach
                </div>
                @endif
            </section>
            @endif
        @endif

        <!-- ============ CTA ============ -->
        @if ($unit->description)
        <section class="cta reveal" style="margin-top: 64px;">
            <div>
                <h2>Bergabung dengan {{ $unit->short_name }}</h2>
                <p>{{ Str::limit($unit->description, 160) }}</p>
            </div>
            <div class="cta-actions">
                <a href="/aspirasi" class="btn">
                    <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    Kirim Aspirasi
                </a>
                <a href="mailto:{{ $unit->email ?? 'dpm@uii.ac.id' }}" class="btn">
                    <svg viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    Hubungi Kami
                </a>
            </div>
        </section>
        @endif
    </main>

    <!-- ============ PROFILE MODAL ============ -->
    <dialog id="profileModal" class="mdlg" role="dialog" aria-modal="true" aria-labelledby="modalName">
        <div class="mdlg-grid">
            <div class="mdlg-photo">
                <img id="modalPhoto" src="" alt="" style="display:none;" loading="lazy">
                <div id="modalInitials" class="initials" style="display:grid;"></div>
            </div>
            <div class="mdlg-body">
                <button class="mdlg-close" id="modalClose" aria-label="Tutup profil">
                    <svg viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
                <h2 id="modalName"></h2>
                <p class="mdlg-role" id="modalPosition"></p>
                <dl>
                    <div>
                        <dt>Periode</dt>
                        <dd id="modalPeriod"></dd>
                    </div>
                    <div>
                        <dt>Email</dt>
                        <dd id="modalEmail" class="muted"></dd>
                    </div>
                    <div>
                        <dt>Instagram</dt>
                        <dd id="modalInstagram" class="muted"></dd>
                    </div>
                    <div>
                        <dt>LinkedIn</dt>
                        <dd id="modalLinkedin" class="muted"></dd>
                    </div>
                </dl>
                <p class="mdlg-bio" id="modalBio"></p>
            </div>
        </div>
    </dialog>
</div>
@endsection