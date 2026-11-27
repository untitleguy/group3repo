/* ============================================================
   Kaffee & Co. — SHOP (app/Views/shop/index.php)
   Menu cards are rendered by PHP. This script handles the
   category filter, the cart drawer and placing the order
   (POST api/orders → app/Controllers/Api/Orders.php).
   ============================================================ */
(function () {
  'use strict';

  const $ = (selector, root = document) => root.querySelector(selector);
  const $$ = (selector, root = document) => [...root.querySelectorAll(selector)];

  const ORDER_URL = document.body.dataset.orderUrl;
  const MAX_QTY = parseInt(document.body.dataset.maxQty, 10) || 99;
  const csrfHeader = $('meta[name="csrf-header"]').content;
  const csrfMeta = $('meta[name="csrf-token"]');

  const ICON_CLOSE = '<svg class="icon icon--sm" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>';

  // ---------- Helpers ----------
  const formatPrice = (n) => '฿' + Number(n).toLocaleString('th-TH', { minimumFractionDigits: 0, maximumFractionDigits: 2 });
  const plural = (n, word) => `${n} ${word}${n === 1 ? '' : 's'}`;
  const escapeHTML = (s) => String(s ?? '').replace(/[&<>"']/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

  let toastTimer;
  function toast(message, isError) {
    const el = $('#toast');
    el.textContent = message;
    el.classList.toggle('toast--error', Boolean(isError));
    el.classList.add('is-visible');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => el.classList.remove('is-visible'), 2800);
  }

  function lockScroll(locked) {
    document.body.classList.toggle('is-locked', locked);
  }

  // ---------- Menu items (read from the PHP-rendered cards) ----------
  const cards = $$('.menu-card[data-code]');
  const menu = new Map(cards.map((card) => [card.dataset.code, {
    code: card.dataset.code,
    name: card.dataset.name,
    price: parseFloat(card.dataset.price),
    unit: card.dataset.unit,
    image: card.dataset.image,
    card,
  }]));

  const stockOf = (code) => parseInt(menu.get(code)?.card.dataset.stock, 10) || 0;
  const limitOf = (code) => Math.min(stockOf(code), MAX_QTY);

  function setStock(code, qty) {
    const item = menu.get(code);
    if (!item) return;
    item.card.dataset.stock = String(qty);
    const soldOut = qty <= 0;
    item.card.classList.toggle('is-sold-out', soldOut);
    const btn = $('[data-add]', item.card);
    btn.disabled = soldOut;
    btn.textContent = soldOut ? 'Sold out' : 'Add to Cart';
  }

  // ---------- Category filter ----------
  const filtersEl = $('#categoryFilters');
  const menuCount = $('#menuCount');

  filtersEl.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-category]');
    if (!btn) return;
    const category = btn.dataset.category;
    $$('.filter-btn', filtersEl).forEach((b) => {
      const active = b === btn;
      b.classList.toggle('is-active', active);
      b.setAttribute('aria-pressed', String(active));
    });
    let shown = 0;
    cards.forEach((card) => {
      const visible = category === '' || card.dataset.category === category;
      card.hidden = !visible;
      if (visible) shown += 1;
    });
    menuCount.textContent = plural(shown, 'item');
  });

  // ---------- Cart state ----------
  const cart = new Map(); // code -> quantity

  const cartCount = () => [...cart.values()].reduce((a, b) => a + b, 0);
  const cartSubtotal = () => [...cart.entries()].reduce((sum, [code, qty]) => sum + menu.get(code).price * qty, 0);

  function addToCart(code) {
    const next = (cart.get(code) || 0) + 1;
    if (next > limitOf(code)) {
      toast(`Only ${limitOf(code)} available.`, true);
      return false;
    }
    cart.set(code, next);
    renderCart();
    return true;
  }

  function changeQty(code, delta) {
    const next = (cart.get(code) || 0) + delta;
    if (next <= 0) cart.delete(code);
    else if (next <= limitOf(code)) cart.set(code, next);
    renderCart();
  }

  // ---------- Cart rendering ----------
  const el = {
    cartButton: $('#cartButton'),
    cartCount: $('#cartCount'),
    overlay: $('#cartOverlay'),
    drawer: $('#cartDrawer'),
    closeCart: $('#closeCart'),
    cartItems: $('#cartItems'),
    cartSubtotal: $('#cartSubtotal'),
    cartError: $('#cartError'),
    checkoutForm: $('#checkoutForm'),
    customerName: $('#customerName'),
    placeOrder: $('#placeOrder'),
  };

  function renderCart() {
    el.cartCount.textContent = cartCount();
    el.cartSubtotal.textContent = formatPrice(cartSubtotal());
    el.placeOrder.disabled = cart.size === 0;

    if (cart.size === 0) {
      el.cartItems.innerHTML = `
        <div class="state-message">
          <p class="state-message__title">Your cart is empty</p>
          <p>Add something delicious from the menu.</p>
        </div>`;
      return;
    }

    el.cartItems.innerHTML = [...cart.entries()].map(([code, qty]) => {
      const item = menu.get(code);
      const c = escapeHTML(code);
      const atLimit = qty >= limitOf(code);
      return `
        <div class="cart-item">
          <img class="cart-item__img" src="${escapeHTML(item.image)}" alt="" />
          <div class="cart-item__info">
            <div class="cart-item__top">
              <p class="cart-item__name">${escapeHTML(item.name)}</p>
              <button type="button" class="cart-item__remove" data-remove="${c}" aria-label="Remove ${escapeHTML(item.name)}">${ICON_CLOSE}</button>
            </div>
            <p class="cart-item__unit">${formatPrice(item.price)} / ${escapeHTML(item.unit)}</p>
            <div class="cart-item__bottom">
              <div class="qty-control">
                <button type="button" class="qty-control__btn" data-dec="${c}" aria-label="Decrease quantity">−</button>
                <span class="qty-control__value">${qty}</span>
                <button type="button" class="qty-control__btn" data-inc="${c}" aria-label="Increase quantity"${atLimit ? ' disabled' : ''}>+</button>
              </div>
              <span class="cart-item__total">${formatPrice(item.price * qty)}</span>
            </div>
            ${atLimit && stockOf(code) <= MAX_QTY ? `<p class="cart-item__note">Only ${stockOf(code)} in stock</p>` : ''}
          </div>
        </div>`;
    }).join('');
  }

  $('#menuGrid').addEventListener('click', (e) => {
    const btn = e.target.closest('[data-add]');
    if (!btn || btn.disabled) return;
    const code = btn.closest('.menu-card').dataset.code;
    if (!addToCart(code)) return;
    btn.textContent = 'Added ✓';
    clearTimeout(btn._resetTimer);
    btn._resetTimer = setTimeout(() => { if (!btn.disabled) btn.textContent = 'Add to Cart'; }, 800);
  });

  el.cartItems.addEventListener('click', (e) => {
    const btn = e.target.closest('button');
    if (!btn) return;
    if (btn.dataset.inc) changeQty(btn.dataset.inc, 1);
    else if (btn.dataset.dec) changeQty(btn.dataset.dec, -1);
    else if (btn.dataset.remove) { cart.delete(btn.dataset.remove); renderCart(); }
  });

  // ---------- Drawer open / close ----------
  function openCart() {
    el.cartError.hidden = true;
    el.drawer.classList.add('is-open');
    el.overlay.classList.add('is-open');
    el.drawer.setAttribute('aria-hidden', 'false');
    lockScroll(true);
  }

  function closeCart() {
    el.drawer.classList.remove('is-open');
    el.overlay.classList.remove('is-open');
    el.drawer.setAttribute('aria-hidden', 'true');
    lockScroll(false);
  }

  el.cartButton.addEventListener('click', openCart);
  el.closeCart.addEventListener('click', closeCart);
  el.overlay.addEventListener('click', closeCart);

  // ---------- Place order ----------
  function showCartError(message) {
    el.cartError.textContent = message;
    el.cartError.hidden = false;
  }

  el.checkoutForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    if (cart.size === 0) return;

    const name = el.customerName.value.trim();
    if (!name) {
      showCartError('Please enter your name.');
      el.customerName.focus();
      return;
    }

    el.cartError.hidden = true;
    el.placeOrder.disabled = true;
    el.placeOrder.textContent = 'Placing order…';

    try {
      const res = await fetch(ORDER_URL, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
          [csrfHeader]: csrfMeta.content,
        },
        body: JSON.stringify({
          customer_name: name,
          items: [...cart.entries()].map(([code, quantity]) => ({ menu_code: code, quantity })),
        }),
      });

      let data = null;
      try { data = await res.json(); } catch (_) { /* not JSON */ }
      if (data && data.csrf) csrfMeta.content = data.csrf;

      if (!res.ok) {
        const message = data && data.message
          ? data.message
          : (res.status === 403 ? 'Your session expired. Please refresh the page and try again.' : `Order failed (HTTP ${res.status}).`);
        throw new Error(message);
      }

      Object.entries(data.stock || {}).forEach(([code, qty]) => setStock(code, qty));
      cart.clear();
      renderCart();
      closeCart();
      showOrder(data.order);
    } catch (err) {
      showCartError(err.message || 'Could not reach the server. Please try again.');
    } finally {
      el.placeOrder.textContent = 'Place Order';
      el.placeOrder.disabled = cart.size === 0;
    }
  });

  // ---------- Order confirmation modal ----------
  const modal = $('#orderModal');

  function showOrder(order) {
    $('#orderNumber').textContent = '#' + order.sale_id;
    $('#orderCustomer').textContent = order.customer_name || '';
    $('#orderTime').textContent = order.sold_at || '';
    $('#orderSummary').innerHTML = order.items.map((line) => `
      <li class="order-summary__row">
        <span><span class="order-summary__qty">${line.quantity}×</span> ${escapeHTML(line.menu_name)}</span>
        <span class="order-summary__price">${formatPrice(line.line_total)}</span>
      </li>`).join('');
    $('#orderItemCount').textContent = plural(order.item_count, 'item');
    $('#orderTotal').textContent = formatPrice(order.total);
    modal.classList.add('is-open');
    lockScroll(true);
  }

  function closeOrder() {
    modal.classList.remove('is-open');
    lockScroll(false);
  }

  $('#closeOrder').addEventListener('click', closeOrder);
  modal.addEventListener('click', (e) => { if (e.target === modal) closeOrder(); });

  document.addEventListener('keydown', (e) => {
    if (e.key !== 'Escape') return;
    if (modal.classList.contains('is-open')) closeOrder();
    else if (el.drawer.classList.contains('is-open')) closeCart();
  });

  // ---------- Mobile nav ----------
  const mobileToggle = $('#mobileToggle');
  const mobileNav = $('#mobileNav');
  mobileToggle.addEventListener('click', () => {
    const open = mobileNav.hidden;
    mobileNav.hidden = !open;
    mobileToggle.setAttribute('aria-expanded', String(open));
  });
  mobileNav.addEventListener('click', (e) => {
    if (!e.target.closest('a')) return;
    mobileNav.hidden = true;
    mobileToggle.setAttribute('aria-expanded', 'false');
  });

  // ---------- Broken images: hide instead of showing a broken icon ----------
  document.addEventListener('error', (e) => {
    if (e.target.tagName === 'IMG') e.target.style.visibility = 'hidden';
  }, true);

  renderCart();
})();
