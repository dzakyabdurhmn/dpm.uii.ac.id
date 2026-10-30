<style>
  *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

  :root {
    --navy:        #001E43;
    --navy-footer: #001633;
    --navy-card:   #001A3A;
    --navy-hover:  #002451;
    --navy-active: #002A5A;
    --white:       #FFFFFF;
    --t-body:      rgba(255,255,255,0.85);
    --t-sub:       rgba(255,255,255,0.75);
    --t-cap:       rgba(255,255,255,0.62);
    --b-default:   rgba(255,255,255,0.10);
    --b-btn:       rgba(255,255,255,0.30);
    --b-btn-hover: rgba(255,255,255,0.55);
    --bg-hover:    rgba(255,255,255,0.06);
    --sh-sm: 0 4px 12px rgba(0,0,0,0.25);
    --sh-md: 0 8px 24px rgba(0,0,0,0.40);
    --sh-lg: 0 16px 48px rgba(0,0,0,0.55);
    --container: 1200px;
  }

  html { scroll-behavior: smooth; scroll-padding-top: 90px; }

  body {
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
    background: var(--navy);
    color: var(--t-body);
    line-height: 1.7;
    -webkit-font-smoothing: antialiased;
    overflow-x: hidden;
  }

  a { color: inherit; text-decoration: none; }
  button, input, textarea { font-family: inherit; }
  button { cursor: pointer; }
  img { max-width: 100%; display: block; }
  svg { display: block; }

  h1, h2, h3, h4 { font-family: 'Wix Madefor Display', 'Inter', sans-serif; color: var(--white); }
  h1 { font-weight: 800; }
  h2 { font-weight: 700; }
  h3 { font-weight: 600; }

  .container { width: 100%; max-width: var(--container); margin: 0 auto; padding: 0 24px; }

  /* ---------- Buttons: always outline ---------- */
  .btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 13px 26px;
    background: transparent;
    border: 1px solid var(--b-btn);
    border-radius: 6px;
    color: var(--white);
    font-size: 14px;
    font-weight: 600;
    transition: border-color .2s, background .2s;
  }
  .btn:hover { border-color: var(--b-btn-hover); background: var(--bg-hover); }
  .btn svg { width: 14px; height: 14px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; transition: transform .2s; }
  .btn:hover svg { transform: translateX(3px); }

  .link-more {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: 13px; font-weight: 600; color: var(--white);
    border-bottom: 1px solid var(--b-btn);
    padding-bottom: 2px;
    transition: border-color .2s;
  }
  .link-more:hover { border-color: var(--b-btn-hover); }

  /* ---------- Header + Mega menu ---------- */
  .header {
    position: sticky; top: 0; z-index: 100;
    background: rgba(0,30,67,0.92);
    backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--b-default);
  }
  .header-inner { display: flex; align-items: stretch; justify-content: space-between; gap: 24px; height: 72px; }

  .logo { display: flex; align-items: center; flex-shrink: 0; }
  .logo img { max-height: 42px; width: auto; object-fit: contain; }
  .logo-fallback { display: none; align-items: center; gap: 8px; font-family: 'Wix Madefor Display', sans-serif; font-weight: 800; font-size: 18px; letter-spacing: 1px; color: var(--white); }
  .logo-fallback span { border: 2px solid var(--white); border-radius: 4px; padding: 3px 10px; }

  .nav { display: flex; height: 100%; }
  .nav-menu { display: flex; align-items: stretch; list-style: none; height: 100%; }
  .nav-item { display: flex; }
  .nav-item > a {
    position: relative;
    display: inline-flex; align-items: center; gap: 6px;
    padding: 0 11px;
    font-size: 12px; font-weight: 600; letter-spacing: .5px; text-transform: uppercase;
    color: var(--white); white-space: nowrap;
    transition: background .2s;
  }
  .nav-item > a::after {
    content: ''; position: absolute; left: 11px; right: 11px; bottom: 0; height: 2px;
    background: var(--white); transform: scaleX(0); transform-origin: left; transition: transform .25s;
  }
  .nav-item:hover > a, .nav-item:focus-within > a { background: var(--bg-hover); }
  .nav-item:hover > a::after, .nav-item:focus-within > a::after { transform: scaleX(1); }
  .nav-item .chev { width: 9px; height: 9px; fill: currentColor; opacity: .65; transition: transform .25s; }
  .nav-item:hover .chev, .nav-item:focus-within .chev { transform: rotate(180deg); }

  .mega {
    position: absolute; left: 0; right: 0; top: 100%;
    background: var(--navy-card);
    border-top: 1px solid var(--b-default); border-bottom: 1px solid var(--b-default);
    box-shadow: var(--sh-lg);
    opacity: 0; visibility: hidden; pointer-events: none; transform: translateY(8px);
    transition: opacity .2s ease, transform .2s ease, visibility .2s;
  }
  .nav-item:hover .mega, .nav-item:focus-within .mega { opacity: 1; visibility: visible; pointer-events: auto; transform: none; }

  .mega-inner { max-width: var(--container); margin: 0 auto; display: grid; grid-template-columns: 27% 31% 42%; min-height: 290px; }

  .mega-info { padding: 38px 28px 28px 24px; }
  .mega-info .eyebrow { margin-bottom: 10px; }
  .mega-info h2 { font-size: 24px; letter-spacing: -.4px; line-height: 1.2; margin-bottom: 14px; }
  .mega-info > p { font-size: 13.5px; color: var(--t-cap); line-height: 1.65; }
  .mega-docs { display: grid; gap: 16px; margin-top: 22px; padding-top: 20px; border-top: 1px solid var(--b-default); }
  .mega-docs a { display: block; font-size: 13px; line-height: 1.5; color: var(--t-body); transition: color .2s; }
  .mega-docs a:hover { color: var(--white); text-decoration: underline; text-underline-offset: 3px; }
  .mega-docs small { display: block; margin-top: 3px; font-size: 11.5px; font-weight: 500; letter-spacing: .3px; color: var(--t-cap); }

  .mega-links { display: flex; flex-direction: column; padding: 22px 24px; background: var(--navy-footer); border-left: 1px solid var(--b-default); border-right: 1px solid var(--b-default); }
  .mega-links a { display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 12px 0; border-bottom: 1px solid var(--b-default); font-size: 13.5px; font-weight: 600; line-height: 1.4; color: var(--white); }
  .mega-links a:last-child { border-bottom: 0; }
  .mega-links a small { display: block; margin-top: 2px; font-size: 11.5px; font-weight: 400; color: var(--t-cap); }
  .mega-links a::after { content: 'â†’'; flex-shrink: 0; opacity: .4; transition: transform .2s, opacity .2s; }
  .mega-links a:hover::after { transform: translateX(4px); opacity: 1; }
  .mega-links a:hover { background: var(--bg-hover); margin: 0 -12px; padding-left: 12px; padding-right: 12px; }

  .mega-feature { position: relative; display: block; min-height: 290px; overflow: hidden; background: linear-gradient(135deg, #002A5A 0%, #001E43 55%, #001633 100%); }
  .mega-feature::before { content: ''; position: absolute; inset: 0; background: repeating-linear-gradient(135deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 26px); }
  .mf-art { position: absolute; inset: 0 0 64px; display: grid; place-items: center; }
  .mf-art svg { width: 38%; max-width: 150px; stroke: rgba(255,255,255,0.4); fill: none; stroke-width: .8; stroke-linecap: round; stroke-linejoin: round; }
  .mega-feature img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; transition: transform .6s ease; }
  .mega-feature:hover img { transform: scale(1.04); }
  .mf-cap { position: absolute; left: 0; right: 0; bottom: 0; z-index: 2; padding: 14px 68px 14px 20px; background: rgba(0,22,51,.93); border-top: 1px solid var(--b-btn); }
  .mf-cap strong { display: block; margin-bottom: 2px; font-family: 'Wix Madefor Display', sans-serif; font-size: 15px; font-weight: 700; color: var(--white); }
  .mf-cap span { display: block; font-size: 12.5px; line-height: 1.45; color: var(--t-sub); }
  .mf-arrow { position: absolute; right: 16px; bottom: 16px; z-index: 3; width: 32px; height: 32px; display: grid; place-items: center; border: 1px solid var(--b-btn); border-radius: 6px; color: var(--white); font-size: 15px; transition: border-color .2s, background .2s; }
  .mega-feature:hover .mf-arrow { border-color: var(--b-btn-hover); background: var(--bg-hover); }

  .hamburger { display: none; align-self: center; width: 42px; height: 42px; border-radius: 6px; border: 1px solid var(--b-btn); background: transparent; color: var(--white); place-items: center; }
  .hamburger svg { width: 18px; height: 18px; stroke: currentColor; stroke-width: 2; fill: none; stroke-linecap: round; }

  @media (max-width: 1240px) {
    .nav-item > a { padding: 0 9px; font-size: 11.5px; letter-spacing: .3px; }
    .nav-item > a::after { left: 9px; right: 9px; }
  }
  @media (max-width: 1080px) {
    .hamburger { display: grid; }
    .nav { display: none; height: auto; }
    .nav.open {
      display: block; position: absolute; top: 100%; left: 0; right: 0;
      background: var(--navy-card); border-bottom: 1px solid var(--b-default);
      max-height: calc(100vh - 110px); overflow-y: auto; padding: 4px 24px 20px;
    }
    .nav.open .nav-menu { flex-direction: column; height: auto; }
    .nav.open .nav-item { flex-direction: column; }
    .nav.open .nav-item > a { padding: 15px 0; justify-content: space-between; border-bottom: 1px solid var(--b-default); font-size: 13px; }
    .nav.open .nav-item > a::after { display: none; }
    .nav.open .nav-item:hover > a, .nav.open .nav-item:focus-within > a { background: transparent; }
    .mega { position: static; opacity: 1; visibility: visible; pointer-events: auto; transform: none; box-shadow: none; background: transparent; border: 0; max-height: 0; overflow: hidden; transition: max-height .3s ease; }
    .nav.open .nav-item.open .mega { max-height: 640px; }
    .nav.open .nav-item.open .chev { transform: rotate(180deg); }
    .mega-inner { display: block; min-height: 0; padding: 0; }
    .mega-info, .mega-feature { display: none; }
    .mega-links { background: transparent; border: 0; padding: 4px 0 10px 14px; }
    .mega-links a:hover { margin: 0; padding-left: 0; padding-right: 0; background: transparent; }
  }

  /* ---------- Top bar (instansi) ---------- */
  .topbar { background: var(--navy-footer); border-bottom: 1px solid var(--b-default); font-size: 12.5px; color: var(--t-cap); }
  .topbar-inner { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding-top: 8px; padding-bottom: 8px; }
  .topbar a { transition: color .2s; }
  .topbar a:hover { color: var(--white); }
  .tb-right { display: flex; align-items: center; gap: 22px; }
  .tb-right span.sep { width: 1px; height: 12px; background: var(--b-btn); }

  /* ---------- Hero banner ---------- */
  .hero { position: relative; background: var(--navy-footer); }
  .slider { position: relative; height: clamp(480px, 76vh, 660px); overflow: hidden; }

  .slide { position: absolute; inset: 0; opacity: 0; visibility: hidden; transition: opacity .9s ease, visibility .9s; }
  .slide.active { opacity: 1; visibility: visible; z-index: 1; }

  .slide-bg { position: absolute; inset: 0; background: linear-gradient(135deg, #002A5A 0%, #001E43 52%, #001633 100%); }
  .slide-bg::after {
    content: ''; position: absolute; inset: 0; opacity: .5;
    background-image:
      repeating-linear-gradient(135deg, rgba(255,255,255,0.035) 0 1px, transparent 1px 28px);
  }
  .slide-art { position: absolute; right: 2%; bottom: 0; width: min(58%, 780px); height: 100%; display: flex; align-items: flex-end; justify-content: flex-end; }
  .slide-art svg { width: 100%; height: auto; max-height: 100%; }
  .slide-photo { position: absolute; inset: 0; background-size: cover; background-position: center; opacity: 0; transition: opacity .8s; }
  .slide.has-photo .slide-photo { opacity: 1; }
  .slide.has-photo .slide-art, .slide.has-photo .slide-bg::after { display: none; }
  .slide.active.has-photo .slide-photo { animation: kenburns 16s ease-out forwards; }
  @keyframes kenburns { from { transform: scale(1); } to { transform: scale(1.07); } }

  .slide-overlay {
    position: absolute; inset: 0;
    background:
      linear-gradient(90deg, rgba(0,30,67,.97) 0%, rgba(0,30,67,.86) 40%, rgba(0,30,67,.30) 100%),
      linear-gradient(0deg, rgba(0,22,51,.9) 0%, transparent 34%);
  }

  .slide-content { position: relative; z-index: 2; height: 100%; display: flex; align-items: center; }
  .slide-text { max-width: 660px; padding: 0 0 76px; }
  .hero-label { display: flex; align-items: center; gap: 14px; margin-bottom: 22px; font-size: 12.5px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--t-sub); }
  .hero-label::before { content: ''; width: 40px; height: 2px; background: var(--white); flex-shrink: 0; }
  .slide h1 { font-size: clamp(28px, 4.4vw, 52px); letter-spacing: -1px; line-height: 1.14; margin-bottom: 20px; }
  .slide p.lead { font-size: clamp(15px, 1.5vw, 17px); color: var(--t-sub); max-width: 560px; margin-bottom: 32px; }
  .hero-actions { display: flex; flex-wrap: wrap; gap: 12px; }

  .slide.active .slide-text > * { animation: rise .8s ease both; }
  .slide.active .slide-text > *:nth-child(2) { animation-delay: .1s; }
  .slide.active .slide-text > *:nth-child(3) { animation-delay: .2s; }
  .slide.active .slide-text > *:nth-child(4) { animation-delay: .3s; }
  @keyframes rise { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }

  /* control bar */
  .slider-bar { position: absolute; left: 0; right: 0; bottom: 0; z-index: 5; background: rgba(0,22,51,.78); border-top: 1px solid var(--b-default); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); }
  .slider-bar-inner { display: flex; align-items: center; justify-content: space-between; gap: 20px; padding-top: 14px; padding-bottom: 14px; }
  .counter { font-family: 'Wix Madefor Display', sans-serif; font-weight: 700; font-size: 14px; letter-spacing: 1px; color: var(--white); min-width: 64px; }
  .counter span { color: var(--t-cap); font-weight: 500; }
  .dots { display: flex; gap: 10px; flex: 1; max-width: 360px; }
  .dot { position: relative; flex: 1; height: 3px; padding: 0; border: 0; background: rgba(255,255,255,.25); overflow: hidden; cursor: pointer; }
  .dot::before { content: ''; position: absolute; inset: -10px 0; }
  .dot.active::after { content: ''; position: absolute; inset: 0; background: var(--white); transform-origin: left; animation: progress 7s linear forwards; }
  .slider.paused .dot.active::after { animation-play-state: paused; }
  @keyframes progress { from { transform: scaleX(0); } to { transform: scaleX(1); } }
  .arrows { display: flex; gap: 8px; }
  .arrow { width: 38px; height: 38px; display: grid; place-items: center; background: transparent; border: 1px solid var(--b-btn); border-radius: 6px; color: var(--white); transition: border-color .2s, background .2s; }
  .arrow:hover { border-color: var(--b-btn-hover); background: var(--bg-hover); }
  .arrow svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

  /* ---------- Akses cepat ---------- */
  .quick-access { background: var(--navy-card); border-bottom: 1px solid var(--b-default); }
  .qa-grid { display: grid; grid-template-columns: repeat(5, 1fr); }
  .qa-item { display: flex; align-items: center; gap: 14px; padding: 22px 20px; transition: background .2s; }
  .qa-item + .qa-item { border-left: 1px solid var(--b-default); }
  .qa-item:hover { background: var(--navy-hover); }
  .qa-item .ic { width: 42px; height: 42px; flex-shrink: 0; display: grid; place-items: center; border: 1px solid var(--b-btn); border-radius: 8px; color: var(--white); }
  .qa-item .ic svg { width: 20px; height: 20px; stroke: currentColor; fill: none; stroke-width: 1.7; stroke-linecap: round; stroke-linejoin: round; }
  .qa-item strong { display: block; font-family: 'Wix Madefor Display', sans-serif; font-size: 14.5px; font-weight: 600; color: var(--white); line-height: 1.3; }
  .qa-item small { display: block; font-size: 12px; color: var(--t-cap); font-weight: 500; line-height: 1.4; }

  @media (max-width: 900px) {
    .qa-grid { grid-template-columns: 1fr 1fr; }
    .qa-item + .qa-item { border-left: 0; }
    .qa-item { border-top: 1px solid var(--b-default); }
    .qa-item:nth-child(-n+2) { border-top: 0; }
    .qa-item:nth-child(even) { border-left: 1px solid var(--b-default); }
    .qa-item:last-child { grid-column: 1 / -1; border-left: 0; }
  }
  @media (max-width: 720px) {
    .slider { height: clamp(520px, 86vh, 640px); }
    .slide-art { width: 100%; right: 0; opacity: .32; }
    .slide-overlay { background: linear-gradient(0deg, rgba(0,22,51,.96) 0%, rgba(0,30,67,.78) 55%, rgba(0,30,67,.55) 100%); }
    .slide-text { padding-bottom: 84px; }
    .tb-right .tb-contact, #today { display: none; }
    .counter { display: none; }
    .qa-item { padding: 18px 14px; gap: 10px; }
    .qa-item small { display: none; }
  }

  /* ---------- Sections ---------- */
  section.block { padding: 96px 0; }
  .sec-head { display: flex; align-items: flex-end; justify-content: space-between; gap: 24px; margin-bottom: 44px; flex-wrap: wrap; }
  .eyebrow { display: block; margin-bottom: 12px; font-size: 12px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase; color: var(--t-cap); }
  .sec-head h2 { font-size: clamp(28px, 4vw, 42px); letter-spacing: -1px; line-height: 1.15; max-width: 640px; }
  .sec-head p { margin-top: 12px; max-width: 560px; color: var(--t-sub); font-size: 15px; }

  .alt { background: var(--navy-footer); border-top: 1px solid var(--b-default); border-bottom: 1px solid var(--b-default); }

  .grid { display: grid; gap: 18px; }
  .g3 { grid-template-columns: repeat(3, 1fr); }
  .g4 { grid-template-columns: repeat(4, 1fr); }

  .card {
    position: relative; display: block;
    background: var(--navy-card);
    border: 1px solid var(--b-default); border-radius: 8px;
    padding: 28px;
    transition: border-color .25s, background .25s, transform .25s, box-shadow .25s;
  }
  a.card:hover, .card.hov:hover { background: var(--navy-hover); border-color: var(--b-btn); transform: translateY(-2px); box-shadow: var(--sh-md); }

  .icon-box { width: 48px; height: 48px; display: grid; place-items: center; margin-bottom: 22px; border: 1px solid var(--b-btn); border-radius: 8px; color: var(--white); }
  .icon-box svg { width: 22px; height: 22px; stroke: currentColor; fill: none; stroke-width: 1.7; stroke-linecap: round; stroke-linejoin: round; }

  .card h3 { font-size: 19px; margin-bottom: 10px; letter-spacing: -.2px; }
  .card p { font-size: 14px; color: var(--t-sub); }

  /* Fungsi cards: number */
  .num { position: absolute; top: 22px; right: 26px; font-family: 'Wix Madefor Display', sans-serif; font-size: 44px; font-weight: 800; color: rgba(255,255,255,0.06); line-height: 1; }

  /* Produk hukum */
  .law .abbr { font-family: 'Wix Madefor Display', sans-serif; font-size: 40px; font-weight: 800; letter-spacing: -1px; color: var(--white); line-height: 1; margin-bottom: 14px; }
  .law .tag { display: block; margin-bottom: 18px; font-size: 11px; font-weight: 600; letter-spacing: 1.6px; text-transform: uppercase; color: var(--t-cap); }
  .law .go { margin-top: 22px; display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; color: var(--white); }
  .law .go svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; transition: transform .2s; }
  .law:hover .go svg { transform: translateX(4px); }

  /* Alat kelengkapan */
  .unit { display: flex; gap: 18px; align-items: flex-start; padding: 24px; }
  .unit .code { flex: 0 0 auto; min-width: 64px; height: 64px; padding: 0 10px; display: grid; place-items: center; border: 1px solid var(--b-btn); border-radius: 8px; font-family: 'Wix Madefor Display', sans-serif; font-weight: 800; font-size: 15px; letter-spacing: .5px; color: var(--white); }
  .unit h3 { font-size: 16px; margin-bottom: 4px; }
  .unit p { font-size: 13px; color: var(--t-cap); font-weight: 500; }

  /* Berita & pengumuman */
  .two { display: grid; grid-template-columns: 1.4fr 1fr; gap: 24px; }
  .news-list, .notice-list { display: flex; flex-direction: column; gap: 14px; }
  .news-item { display: grid; grid-template-columns: 120px 1fr; gap: 20px; padding: 18px; align-items: center; }
  .news-thumb { aspect-ratio: 4/3; border-radius: 6px; border: 1px solid var(--b-default); background:
      linear-gradient(135deg, rgba(255,255,255,0.08), rgba(255,255,255,0.02)); display: grid; place-items: center; color: var(--t-cap); }
  .news-thumb svg { width: 28px; height: 28px; stroke: currentColor; fill: none; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; }
  .meta { font-size: 12px; font-weight: 500; color: var(--t-cap); letter-spacing: .3px; margin-bottom: 6px; }
  .news-item h3 { font-size: 16.5px; line-height: 1.4; margin-bottom: 6px; }
  .news-item p { font-size: 13.5px; color: var(--t-sub); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

  .panel-title { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
  .panel-title h3 { font-size: 18px; }

  .notice { display: grid; grid-template-columns: 56px 1fr; gap: 16px; padding: 18px; align-items: center; }
  .date-box { text-align: center; padding: 8px 0; border: 1px solid var(--b-btn); border-radius: 6px; }
  .date-box strong { display: block; font-family: 'Wix Madefor Display', sans-serif; font-size: 20px; font-weight: 800; color: var(--white); line-height: 1.1; }
  .date-box span { display: block; font-size: 10px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--t-cap); }
  .notice h3 { font-size: 14.5px; line-height: 1.45; }

  /* Dana & Laporan */
  .quick { display: flex; align-items: center; justify-content: space-between; gap: 14px; padding: 22px 24px; }
  .quick span.t { font-family: 'Wix Madefor Display', sans-serif; font-size: 16px; font-weight: 600; color: var(--white); }
  .quick small { display: block; margin-top: 2px; font-family: 'Inter', sans-serif; font-size: 12.5px; font-weight: 500; color: var(--t-cap); }
  .quick svg { width: 18px; height: 18px; flex-shrink: 0; stroke: var(--white); fill: none; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; opacity: .7; transition: transform .2s, opacity .2s; }
  .quick:hover svg { transform: translateX(4px); opacity: 1; }

  /* Aspirasi */
  .aspirasi { display: grid; grid-template-columns: 1fr 1fr; gap: 56px; align-items: start; }
  .aspirasi h2 { font-size: clamp(30px, 4.4vw, 48px); letter-spacing: -1.2px; line-height: 1.12; margin-bottom: 18px; }
  .aspirasi .hash { display: inline-block; margin-top: 26px; padding: 8px 18px; border: 1px solid var(--b-btn); border-radius: 100px; font-size: 13px; font-weight: 600; color: var(--white); letter-spacing: .4px; }
  .form-card { padding: 32px; box-shadow: var(--sh-lg); }
  .field { margin-bottom: 18px; }
  .field label { display: block; margin-bottom: 8px; font-size: 12.5px; font-weight: 600; letter-spacing: .6px; text-transform: uppercase; color: var(--t-sub); }
  .field input, .field textarea {
    width: 100%; padding: 13px 16px;
    background: rgba(255,255,255,0.03);
    border: 1px solid var(--b-default); border-radius: 6px;
    color: var(--white); font-size: 14.5px;
    transition: border-color .2s, background .2s;
  }
  .field input::placeholder, .field textarea::placeholder { color: rgba(255,255,255,0.38); }
  .field input:focus, .field textarea:focus { outline: none; border-color: var(--b-btn-hover); background: rgba(255,255,255,0.05); }
  .field textarea { min-height: 130px; resize: vertical; }
  .field.err input, .field.err textarea { border-color: #DC2626; }
  .field .msg-err { display: none; margin-top: 6px; font-size: 12.5px; color: #DC2626; }
  .field.err .msg-err { display: block; }
  .form-card .btn { width: 100%; }
  .success { display: none; margin-top: 16px; padding: 13px 16px; border: 1px solid #16A34A; border-radius: 6px; font-size: 13.5px; color: #16A34A; }
  .success.show { display: block; }

  /* ---------- Footer ---------- */
  .footer { background: var(--navy-footer); border-top: 1px solid var(--b-default); padding: 64px 0 0; }
  .footer-grid { display: grid; grid-template-columns: 1.5fr 1fr 1fr; gap: 48px; padding-bottom: 48px; }
  .footer-logo { margin-bottom: 20px; min-height: 42px; }
  .footer-logo img { max-height: 42px; width: auto; }
  .footer-brand p { font-size: 13.5px; color: var(--t-cap); max-width: 340px; }
  .footer h4 { font-size: 13px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 18px; }
  .footer ul { list-style: none; display: flex; flex-direction: column; gap: 10px; }
  .footer ul a, .footer ul li { font-size: 13.5px; color: var(--t-cap); transition: color .2s; }
  .footer ul a:hover { color: var(--white); }
  .social { display: flex; gap: 8px; margin-top: 22px; }
  .social a { width: 38px; height: 38px; display: grid; place-items: center; border: 1px solid var(--b-btn); border-radius: 50%; color: var(--white); transition: background .2s, border-color .2s; }
  .social a:hover { background: var(--bg-hover); border-color: var(--b-btn-hover); }
  .social svg { width: 16px; height: 16px; fill: currentColor; }
  .footer-bottom { border-top: 1px solid var(--b-default); padding: 22px 0; text-align: center; font-size: 12.5px; color: var(--t-cap); }
  .footer-bottom strong { color: var(--white); font-weight: 700; }

  /* ---------- Reveal ---------- */
  .reveal { opacity: 0; transform: translateY(24px); transition: opacity .7s ease, transform .7s ease; }
  .reveal.in { opacity: 1; transform: none; }
  .d1 { transition-delay: .08s; } .d2 { transition-delay: .16s; } .d3 { transition-delay: .24s; } .d4 { transition-delay: .32s; }

  /* ---------- Responsive ---------- */
  @media (max-width: 1080px) {
    .g4 { grid-template-columns: repeat(2, 1fr); }
    .two, .aspirasi { grid-template-columns: 1fr; }
    .footer-grid { grid-template-columns: 1fr 1fr; }
    .footer-brand { grid-column: 1 / -1; }
  }
  @media (max-width: 720px) {
    section.block { padding: 68px 0; }
    .g3, .g4 { grid-template-columns: 1fr; }
    .news-item { grid-template-columns: 92px 1fr; gap: 14px; padding: 14px; }
    .footer-grid { grid-template-columns: 1fr; gap: 32px; }
    .form-card { padding: 24px; }
  }
  @media (prefers-reduced-motion: reduce) {
    *, *::before, *::after { animation: none !important; transition: none !important; }
    .reveal { opacity: 1; transform: none; }
  }
</style>
