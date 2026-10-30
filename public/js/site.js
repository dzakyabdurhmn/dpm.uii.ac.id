(function () {
    'use strict';

    var siteHeader = document.getElementById('site-header');
    var mobileMenuToggle = document.querySelector('.dpm-mobile-toggle');
    var footerMain = document.querySelector('.dpm-footer-main');

    if (footerMain && 'IntersectionObserver' in window) {
        if (!window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            var footerObserver = new IntersectionObserver(function (entries, observer) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });
            footerObserver.observe(footerMain);
        } else {
            footerMain.classList.add('is-visible');
        }
    } else if (footerMain) {
        footerMain.classList.add('is-visible');
    }

    if (siteHeader && mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', function () {
            var isExpanded = mobileMenuToggle.getAttribute('aria-expanded') === 'true';
            mobileMenuToggle.setAttribute('aria-expanded', String(!isExpanded));
            siteHeader.classList.toggle('nav-open', !isExpanded);
            var icon = mobileMenuToggle.querySelector('i');
            if (icon) {
                icon.classList.toggle('fa-bars', isExpanded);
                icon.classList.toggle('fa-xmark', !isExpanded);
            }
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 991.98) {
                siteHeader.classList.remove('nav-open');
                mobileMenuToggle.setAttribute('aria-expanded', 'false');
                var icon = mobileMenuToggle.querySelector('i');
                if (icon) {
                    icon.classList.add('fa-bars');
                    icon.classList.remove('fa-xmark');
                }
            }
        });
    }

    document.querySelectorAll('.dpm-mega-sublist a').forEach(function (link) {
        link.addEventListener('mouseenter', function () {
            var menu = link.closest('.dpm-mega-menu');
            if (!menu) return;
            var img = menu.querySelector('.dpm-mega-preview img');
            var title = menu.querySelector('.dpm-mega-preview-card h4');
            var desc = menu.querySelector('.dpm-mega-preview-card p');
            var action = menu.querySelector('.dpm-mega-preview-card a');
            if (link.dataset.img && img) img.src = link.dataset.img;
            if (link.dataset.title && title) title.textContent = link.dataset.title;
            if (link.dataset.desc && desc) desc.textContent = link.dataset.desc;
            if (link.dataset.href && action) action.href = link.dataset.href;
        });
    });

    function toggleHelper(btnId, className) {
        var btn = document.getElementById(btnId);
        if (!btn) return;
        if (localStorage.getItem("acc-" + className) === "on") {
            btn.classList.add("on");
            document.documentElement.classList.add(className);
        }
        btn.addEventListener("click", function() {
            btn.classList.toggle("on");
            document.documentElement.classList.toggle(className);
            if (btn.classList.contains("on")) {
                localStorage.setItem("acc-" + className, "on");
            } else {
                localStorage.removeItem("acc-" + className);
            }
        });
    }

    toggleHelper("toggle-monokrom", "monokrom");
    toggleHelper("toggle-dark", "dark-mode");
    toggleHelper("toggle-high-contrast", "high-contrast");

    var scale = parseFloat(localStorage.getItem("acc-text-scale")) || 1;
    function updateTextScale() {
        var el = document.getElementById("text-scale-display");
        if (el) el.innerText = scale.toFixed(1) + "x";
        document.body.style.fontSize = (15 * scale) + "px";
    }

    var plusBtn = document.getElementById("text-plus");
    var minusBtn = document.getElementById("text-minus");
    if (plusBtn) {
        plusBtn.onclick = function() {
            scale += 0.1;
            localStorage.setItem("acc-text-scale", scale);
            updateTextScale();
        };
    }
    if (minusBtn) {
        minusBtn.onclick = function() {
            if (scale > 0.7) scale -= 0.1;
            localStorage.setItem("acc-text-scale", scale);
            updateTextScale();
        };
    }

    var resetBtn = document.getElementById("acc-reset-btn");
    if (resetBtn) {
        resetBtn.onclick = function() {
            localStorage.clear();
            document.documentElement.className = "";
            scale = 1;
            updateTextScale();
            document.querySelectorAll('.acc-toggle').forEach(function(t) { t.classList.remove('on'); });
        };
    }
})();
