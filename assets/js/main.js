/* AshaParth AI Multiservices: site interactions (no dependencies) */
(function () {
  'use strict';

  var doc = document.documentElement;
  doc.classList.add('js');

  var body = document.body;
  var header = document.querySelector('.site-header');
  var navToggle = document.querySelector('.nav-toggle');
  var mobileQuery = window.matchMedia('(max-width: 1180px)');

  // ── Mobile navigation ────────────────────────────────────────────────
  function setNav(open) {
    // The menu starts below the header, wherever the header currently sits.
    if (open && header) {
      doc.style.setProperty('--nav-top', Math.max(0, header.getBoundingClientRect().bottom) + 'px');
    }
    body.classList.toggle('nav-open', open);
    if (navToggle) {
      navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      navToggle.innerHTML = open ? '<i class="bi bi-x-lg" aria-hidden="true"></i>' : '<i class="bi bi-list" aria-hidden="true"></i>';
    }
  }
  if (navToggle) {
    navToggle.addEventListener('click', function () { setNav(!body.classList.contains('nav-open')); });
  }
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      setNav(false);
      document.querySelectorAll('.nav-item.open').forEach(function (i) { i.classList.remove('open'); });
    }
  });
  mobileQuery.addEventListener && mobileQuery.addEventListener('change', function (e) { if (!e.matches) setNav(false); });

  // ── Dropdowns: click to toggle (mobile + keyboard), hover handled by CSS
  document.querySelectorAll('.nav-item.has-dropdown > .nav-link').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      var item = btn.parentElement;
      var willOpen = !item.classList.contains('open');
      document.querySelectorAll('.nav-item.open').forEach(function (i) { if (i !== item) i.classList.remove('open'); });
      item.classList.toggle('open', willOpen);
      btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
      e.stopPropagation();
    });
  });
  document.addEventListener('click', function (e) {
    if (!e.target.closest('.nav-item.has-dropdown')) {
      document.querySelectorAll('.nav-item.open').forEach(function (i) {
        i.classList.remove('open');
        var b = i.querySelector('.nav-link');
        if (b) b.setAttribute('aria-expanded', 'false');
      });
    }
  });

  // ── Header shadow + back-to-top ──────────────────────────────────────
  var toTop = document.querySelector('.to-top');
  function onScroll() {
    var y = window.scrollY || window.pageYOffset;
    if (header) header.classList.toggle('is-scrolled', y > 10);
    if (toTop) toTop.classList.toggle('show', y > 600);
  }
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
  if (toTop) toTop.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: 'smooth' }); });

  // ── Reveal on scroll ─────────────────────────────────────────────────
  var reveals = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) { entry.target.classList.add('in'); io.unobserve(entry.target); }
      });
    }, { rootMargin: '0px 0px -60px 0px', threshold: 0.08 });
    reveals.forEach(function (el) { io.observe(el); });
  } else {
    reveals.forEach(function (el) { el.classList.add('in'); });
  }

  // ── Portfolio filter ─────────────────────────────────────────────────
  var filterBtns = document.querySelectorAll('.filter-btn');
  filterBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      var cat = btn.getAttribute('data-filter');
      filterBtns.forEach(function (b) { b.classList.toggle('active', b === btn); b.setAttribute('aria-pressed', b === btn ? 'true' : 'false'); });
      document.querySelectorAll('[data-category]').forEach(function (card) {
        card.hidden = !(cat === 'all' || card.getAttribute('data-category') === cat);
      });
    });
  });

  // ── File inputs: show chosen file name ───────────────────────────────
  document.querySelectorAll('.file-drop input[type="file"]').forEach(function (input) {
    input.addEventListener('change', function () {
      var wrap = input.closest('.file-drop');
      var label = wrap.querySelector('[data-file-label]');
      if (input.files && input.files[0]) {
        var f = input.files[0];
        label.textContent = f.name + ' (' + (f.size / 1048576).toFixed(2) + ' MB)';
        wrap.classList.add('has-file');
      } else {
        label.textContent = label.getAttribute('data-default');
        wrap.classList.remove('has-file');
      }
    });
  });

  // ── Forms: required checkbox groups + loading state ──────────────────
  document.querySelectorAll('form[data-enhance]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      var groups = form.querySelectorAll('[data-required-group]');
      for (var i = 0; i < groups.length; i++) {
        if (!groups[i].querySelector('input:checked')) {
          e.preventDefault();
          var msg = groups[i].parentElement.querySelector('.group-msg');
          if (msg) { msg.hidden = false; }
          groups[i].scrollIntoView({ behavior: 'smooth', block: 'center' });
          return;
        }
      }
      var btn = form.querySelector('[type="submit"]');
      if (btn) {
        if (!btn.hasAttribute('data-label')) btn.setAttribute('data-label', btn.innerHTML);
        btn.classList.add('is-loading');
        btn.innerHTML = '<i class="bi bi-arrow-repeat" aria-hidden="true"></i> Sending…';
      }
    });
    form.querySelectorAll('[data-required-group] input').forEach(function (cb) {
      cb.addEventListener('change', function () {
        var msg = cb.closest('.field').querySelector('.group-msg');
        if (msg) msg.hidden = true;
      });
    });
  });

  // Re-enable buttons if the page is restored from the back/forward cache
  window.addEventListener('pageshow', function (e) {
    if (e.persisted) {
      document.querySelectorAll('.is-loading').forEach(function (b) {
        b.classList.remove('is-loading');
        if (b.hasAttribute('data-label')) b.innerHTML = b.getAttribute('data-label');
      });
    }
  });
})();
