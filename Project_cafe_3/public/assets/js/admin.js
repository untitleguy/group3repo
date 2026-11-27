/* ============================================================
   Kaffee & Co. — ADMIN helpers (app/Views/admin/*)
   Pages are server-rendered; this only adds small conveniences.
   ============================================================ */
(function () {
  'use strict';

  // Ask before submitting forms marked with data-confirm (e.g. Delete).
  document.addEventListener('submit', (e) => {
    const message = e.target.dataset.confirm;
    if (message && !window.confirm(message)) e.preventDefault();
  });

  // Category dropdown in the menu toolbar submits on change.
  document.querySelectorAll('select[data-autosubmit]').forEach((select) => {
    select.addEventListener('change', () => select.form.submit());
  });

  // Live image preview in the menu item form.
  const input = document.querySelector('[data-image-input]');
  const preview = document.querySelector('[data-image-preview]');
  if (input && preview) {
    const base = input.dataset.imageBase;
    const toUrl = (path) => (/^https?:\/\//i.test(path)
      ? path
      : base + path.replace(/^\/+/, '').split('/').map(encodeURIComponent).join('/'));

    input.addEventListener('input', () => {
      const path = input.value.trim();
      preview.hidden = !path;
      preview.style.visibility = 'visible';
      if (path) preview.src = toUrl(path);
    });
    preview.addEventListener('error', () => { preview.style.visibility = 'hidden'; });
  }

  // Hide broken thumbnails.
  document.addEventListener('error', (e) => {
    if (e.target.tagName === 'IMG' && !e.target.hasAttribute('data-image-preview')) {
      e.target.style.visibility = 'hidden';
    }
  }, true);
})();
