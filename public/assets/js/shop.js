/* ==========================================================================
   ShopHub — Storefront UI behavior (vanilla JS, no jQuery)
   ========================================================================== */
(function () {
    'use strict';

    /* ---------- 1. Auto-dismiss flash toasts ---------- */
    document.querySelectorAll('[data-shop-toast]').forEach(function (toast) {
        var timer = setTimeout(function () { dismiss(toast); }, 5000);
        var closeBtn = toast.querySelector('[data-shop-toast-close]');
        if (closeBtn) {
            closeBtn.addEventListener('click', function (e) {
                e.preventDefault();
                clearTimeout(timer);
                dismiss(toast);
            });
        }
        function dismiss(el) {
            if (!el || el.getAttribute('data-shop-toast-hidden')) return;
            el.setAttribute('data-shop-toast-hidden', '1');
            el.style.transition = 'opacity .25s ease, transform .25s ease';
            el.style.opacity = '0';
            el.style.transform = 'translateY(-8px)';
            setTimeout(function () { el.remove(); }, 250);
        }
    });

    /* ---------- 2. Submit button loading state ---------- */
    document.addEventListener('submit', function (e) {
        var form = e.target;
        var btn = form.querySelector('button[type="submit"]');
        if (!btn || btn.hasAttribute('data-no-spinner')) return;
        if (form.classList.contains('no-loading')) return;
        btn.setAttribute('disabled', 'disabled');
        btn.style.pointerEvents = 'none';
        var spinner = document.createElement('span');
        spinner.className = 'spinner-border spinner-border-sm me-2';
        spinner.setAttribute('role', 'status');
        spinner.setAttribute('aria-hidden', 'true');
        btn.prepend(spinner);
    });
/* ---------- 3. Search autocomplete (/search/suggest) ---------- */
    var searchDebounce = null;
    document.querySelectorAll('[data-shop-search]').forEach(function (wrapper) {
        var input = wrapper.querySelector('[data-shop-search-input]');
        var box = wrapper.querySelector('[data-shop-suggest]');
        if (!input || !box) return;

        function close() { box.classList.remove('show'); box.innerHTML = ''; }

        input.addEventListener('input', function () {
            var q = input.value.trim();
            clearTimeout(searchDebounce);
            if (q.length < 2) { close(); return; }
            searchDebounce = setTimeout(function () { fetchSuggestions(q); }, 220);
        });

        input.addEventListener('focus', function () {
            if (input.value.trim().length >= 2) fetchSuggestions(input.value.trim());
        });

        document.addEventListener('click', function (e) {
            if (!wrapper.contains(e.target)) close();
        });

        input.addEventListener('keydown', function (e) {
            var items = box.querySelectorAll('a');
            if (!items.length) return;
            var idx = Array.prototype.indexOf.call(items, document.activeElement);
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                var next = (idx + 1) % items.length;
                items[next].focus();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                var prev = (idx - 1 + items.length) % items.length;
                items[prev].focus();
            } else if (e.key === 'Escape') {
                close();
            }
        });

        function fetchSuggestions(q) {
            var url = '/search/suggest?q=' + encodeURIComponent(q);
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(function (r) { return r.ok ? r.json() : null; })
                .then(function (data) { if (data) render(data, q); })
                .catch(function () { /* silent fail -> normal search */ });
        }

        function render(data, q) {
            var html = '';
            if (data.products.length) {
                html += '<div class="sg-head">Products</div>';
                html += data.products.map(function (p) {
                    return '<a href="' + p.url + '" role="option" tabindex="-1">' +
                        (p.image ? '<img src="' + p.image + '" alt="" loading="lazy">' : '') +
                        '<span><span class="sg-title">' + escapeHtml(p.name) + '</span>' +
                        '<span class="sg-price">' + p.price + '</span></span></a>';
                }).join('');
            }
            if (data.categories.length) {
                html += '<div class="sg-head">Categories</div>';
                html += data.categories.map(function (c) {
                    return '<a href="' + c.url + '" role="option" tabindex="-1">' +
                        '<i class="bi bi-tag"></i><span><span class="sg-title">' + escapeHtml(c.name) + '</span></span></a>';
                }).join('');
            }
            if (!html) {
                html = '<div class="sg-head">No matches for &ldquo;' + escapeHtml(q) + '&rdquo;</div>';
            }
            html += '<a class="is-active" href="/search?q=' + encodeURIComponent(q) + '" role="option" tabindex="-1">' +
                '<i class="bi bi-search"></i><span><span class="sg-title">See all results</span></span></a>';
            box.innerHTML = html;
            box.classList.add('show');
        }
    });

/* ---------- 4. Product gallery (thumbs + lightbox) ---------- */
    document.querySelectorAll('[data-gallery]').forEach(function (gallery) {
        var main = gallery.querySelector('[data-gallery-main]');
        var thumbs = gallery.querySelectorAll('[data-thumb]');
        thumbs.forEach(function (thumb) {
            thumb.addEventListener('click', function (e) {
                e.preventDefault();
                gallery.querySelectorAll('[data-thumb]').forEach(function (t) { t.classList.remove('is-active'); });
                thumb.classList.add('is-active');
                if (main) main.src = thumb.getAttribute('data-full');
                var lightbox = document.getElementById('productLightbox');
                if (lightbox) {
                    var lbImg = lightbox.querySelector('img');
                    if (lbImg) lbImg.src = thumb.getAttribute('data-full');
                }
            });
        });
    });

    /* ---------- 5. Quantity steppers ---------- */
    document.querySelectorAll('.qty-stepper').forEach(function (stepper) {
        var input = stepper.querySelector('input.qty-input');
        if (!input) return;
        var min = parseInt(input.min, 10) || 1;
        var max = parseInt(input.max, 10) || 9999;
        var minus = stepper.querySelector('.qty-minus');
        var plus = stepper.querySelector('.qty-plus');
        if (minus) minus.addEventListener('click', function () {
            var v = parseInt(input.value, 10) || min;
            input.value = Math.max(min, v - 1);
            input.dispatchEvent(new Event('change'));
        });
        if (plus) plus.addEventListener('click', function () {
            var v = parseInt(input.value, 10) || 0;
            input.value = Math.min(max, v + 1);
            input.dispatchEvent(new Event('change'));
        });
    });

        /* ---------- 6. Destructive confirmations ---------- */
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (!window.confirm(form.getAttribute('data-confirm'))) {
                e.preventDefault();
                e.stopImmediatePropagation();
                return false;
            }
        });
    });

    /* ---------- 6b. Auto-submit forms on select change (sort/filter) ---------- */
    document.querySelectorAll('select[data-shop-autosubmit]').forEach(function (select) {
        select.addEventListener('change', function () {
            var form = this.closest('form');
            if (form) { form.submit(); }
        });
    });

    /* ---------- 6c. Filter form auto-submit on radio/button change ---------- */
    document.addEventListener('change', function (e) {
        if (e.target.matches('[data-shop-filters] input[type="radio"], [data-shop-filters] input[type="checkbox"]')) {
            var form = e.target.closest('form');
            if (form && form.hasAttribute('data-shop-autosubmit')) {
                form.submit();
            }
        }
    });

    /* ---------- 7. Lazy-load images without native support ---------- */
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    var img = entry.target;
                    var src = img.getAttribute('data-src');
                    if (src) { img.src = src; img.removeAttribute('data-src'); }
                    io.unobserve(img);
                }
            });
        }, { rootMargin: '200px' });
        document.querySelectorAll('img[data-src]').forEach(function (img) { io.observe(img); });
    }

    /* ---------- 8. Sticky mobile buy bar (product detail) ---------- */
    var buyBar = document.querySelector('.shop-buy-bar');
    if (buyBar) {
        function syncBuyBar() {
            if (window.innerWidth >= 992) { buyBar.style.display = 'none'; return; }
            buyBar.style.display = 'block';
        }
        window.addEventListener('resize', syncBuyBar);
        syncBuyBar();
    }

    /* ---------- 10. Scroll-reveal (progressive, motion-safe) ---------- */
    var revealTargets = document.querySelectorAll('[data-reveal], [data-reveal-group]');
    var revealOk = revealTargets.length
        && 'IntersectionObserver' in window
        && !(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);
    if (revealOk) {
        document.documentElement.classList.add('reveal-init');
        var revealObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });
        revealTargets.forEach(function (el) { revealObserver.observe(el); });
    }
    function escapeHtml(str) {
        var d = document.createElement('div');
        d.textContent = String(str || '');
        return d.innerHTML;
    }

})();