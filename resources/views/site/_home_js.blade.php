<script>
  // Menu & mega menu
  const hamburger = document.getElementById('hamburger');
  const nav = document.getElementById('nav');
  hamburger.addEventListener('click', () => {
    const open = nav.classList.toggle('open');
    hamburger.setAttribute('aria-expanded', open);
  });
  document.querySelectorAll('.nav-item').forEach(item => {
    const link = item.querySelector(':scope > a');
    if (item.querySelector('.mega')) {
      link.addEventListener('click', e => {
        if (window.innerWidth <= 1080) { e.preventDefault(); item.classList.toggle('open'); }
      });
    }
  });
  document.querySelectorAll('.mega a, .nav-item:not(:has(.mega)) > a').forEach(a => {
    a.addEventListener('click', () => nav.classList.remove('open'));
  });
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape' && document.activeElement) document.activeElement.blur();
  });

  // Reveal on scroll
  const io = new IntersectionObserver((entries) => {
    entries.forEach(en => { if (en.isIntersecting) { en.target.classList.add('in'); io.unobserve(en.target); } });
  }, { threshold: 0.12 });
  document.querySelectorAll('.reveal').forEach(el => io.observe(el));

  // Tanggal pada top bar
  try {
    document.getElementById('today').textContent =
      new Date().toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
  } catch (e) {}

  // Hero slider
  (function () {
    const slider = document.getElementById('slider');
    const slides = [...slider.querySelectorAll('.slide')];
    const dots = [...slider.querySelectorAll('.dot')];
    const cur = document.getElementById('curNo');
    const tot = document.getElementById('totNo');
    const DUR = 7000;
    const pad = n => String(n).padStart(2, '0');
    let i = 0, timer = null;
    let hold = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    tot.textContent = pad(slides.length);

    // pasang foto bila file tersedia
    slides.forEach(s => {
      const src = s.dataset.img;
      if (!src) return;
      const im = new Image();
      im.onload = () => {
        s.querySelector('.slide-photo').style.backgroundImage = 'url("' + src + '")';
        s.classList.add('has-photo');
      };
      im.src = src;
    });

    function schedule() {
      clearTimeout(timer);
      if (!hold) timer = setTimeout(() => go(i + 1), DUR);
    }
    function go(n) {
      i = (n + slides.length) % slides.length;
      slides.forEach((s, k) => s.classList.toggle('active', k === i));
      dots.forEach((d, k) => {
        d.classList.remove('active');
        if (k === i) { void d.offsetWidth; d.classList.add('active'); }
      });
      cur.textContent = pad(i + 1);
      schedule();
    }

    document.getElementById('prevBtn').addEventListener('click', () => go(i - 1));
    document.getElementById('nextBtn').addEventListener('click', () => go(i + 1));
    dots.forEach((d, k) => d.addEventListener('click', () => go(k)));

    slider.addEventListener('mouseenter', () => { clearTimeout(timer); slider.classList.add('paused'); });
    slider.addEventListener('mouseleave', () => { slider.classList.remove('paused'); go(i); });

    let x0 = null;
    slider.addEventListener('touchstart', e => { x0 = e.touches[0].clientX; }, { passive: true });
    slider.addEventListener('touchend', e => {
      if (x0 === null) return;
      const dx = e.changedTouches[0].clientX - x0;
      if (Math.abs(dx) > 50) go(i + (dx < 0 ? 1 : -1));
      x0 = null;
    });

    schedule();
  })();

  // Form aspirasi (demo: sambungkan ke endpoint sebenarnya)
  const form = document.getElementById('aspirasiForm');
  const ok = document.getElementById('formSuccess');
  form.addEventListener('submit', e => {
    e.preventDefault();
    let valid = true;
    form.querySelectorAll('.field').forEach(f => {
      const input = f.querySelector('input, textarea');
      const bad = !input.value.trim();
      f.classList.toggle('err', bad);
      if (bad) valid = false;
    });
    if (!valid) { ok.classList.remove('show'); return; }
    ok.classList.add('show');
    form.reset();
  });
</script>
