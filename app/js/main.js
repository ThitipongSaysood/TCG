/* CARD ZONE — shared interactions */
(function () {
  'use strict';

  /* ----- Mobile drawer ----- */
  function toggleDrawer(open) {
    var d = document.getElementById('drawer');
    var b = document.getElementById('drawerBackdrop');
    if (!d || !b) return;
    d.classList.toggle('open', open);
    b.classList.toggle('open', open);
    document.body.style.overflow = open ? 'hidden' : '';
  }
  document.addEventListener('click', function (e) {
    if (e.target.closest('[data-drawer-open]')) toggleDrawer(true);
    if (e.target.closest('[data-drawer-close]') || e.target.id === 'drawerBackdrop') toggleDrawer(false);
  });

  /* ----- Tabs (filter rows) ----- */
  document.querySelectorAll('[data-tabs]').forEach(function (group) {
    group.addEventListener('click', function (e) {
      var btn = e.target.closest('button');
      if (!btn) return;
      group.querySelectorAll('button').forEach(function (b) { b.classList.remove('active'); });
      btn.classList.add('active');
    });
  });

  /* ----- Radio option cards ----- */
  document.querySelectorAll('[data-opt-group]').forEach(function (group) {
    group.addEventListener('click', function (e) {
      var opt = e.target.closest('.opt');
      if (!opt) return;
      group.querySelectorAll('.opt').forEach(function (o) { o.classList.remove('selected'); });
      opt.classList.add('selected');
      var r = opt.querySelector('input[type=radio]');
      if (r) r.checked = true;
    });
  });

  /* ----- Quantity stepper ----- */
  document.querySelectorAll('.qty').forEach(function (q) {
    var span = q.querySelector('span');
    q.addEventListener('click', function (e) {
      if (e.target.tagName !== 'BUTTON') return;
      var v = parseInt(span.textContent, 10) || 1;
      v += e.target.dataset.step === '-' ? -1 : 1;
      if (v < 1) v = 1;
      span.textContent = v;
    });
  });

  /* ----- Gallery thumbnails ----- */
  document.querySelectorAll('[data-gallery]').forEach(function (g) {
    g.addEventListener('click', function (e) {
      var t = e.target.closest('.gallery-thumb');
      if (!t) return;
      g.querySelectorAll('.gallery-thumb').forEach(function (x) { x.classList.remove('active'); });
      t.classList.add('active');
      var main = document.getElementById('galleryMain');
      if (main) {
        var mImg = main.querySelector('img');
        if (mImg && t.dataset.img) { mImg.src = t.dataset.img; mImg.alt = t.dataset.label || ''; }
        else { main.textContent = t.dataset.label || t.textContent; }
      }
    });
  });

  /* ----- Countdown timers (data-countdown="HH:MM:SS") ----- */
  document.querySelectorAll('[data-countdown]').forEach(function (el) {
    var parts = el.dataset.countdown.split(':').map(Number);
    var total = parts[0] * 3600 + parts[1] * 60 + (parts[2] || 0);
    function tick() {
      if (total <= 0) { el.textContent = 'หมดเวลา'; return; }
      total--;
      var h = String(Math.floor(total / 3600)).padStart(2, '0');
      var m = String(Math.floor((total % 3600) / 60)).padStart(2, '0');
      var s = String(total % 60).padStart(2, '0');
      el.textContent = h + ':' + m + ':' + s;
    }
    tick();
    setInterval(tick, 1000);
  });

  /* ----- Toast on demo buttons ----- */
  document.addEventListener('click', function (e) {
    var t = e.target.closest('[data-toast]');
    if (!t) return;
    e.preventDefault();
    showToast(t.dataset.toast);
  });
  function showToast(msg) {
    var el = document.createElement('div');
    el.textContent = msg;
    el.style.cssText =
      'position:fixed;left:50%;bottom:90px;transform:translateX(-50%);z-index:200;' +
      'background:linear-gradient(135deg,#4F74E8,#3FC6E8);color:#fff;padding:12px 22px;' +
      'border-radius:999px;font-size:14px;box-shadow:0 8px 30px rgba(63,198,232,.5);' +
      'opacity:0;transition:.3s';
    document.body.appendChild(el);
    requestAnimationFrame(function () { el.style.opacity = '1'; });
    setTimeout(function () {
      el.style.opacity = '0';
      setTimeout(function () { el.remove(); }, 300);
    }, 2200);
  }
  window.showToast = showToast;
})();
