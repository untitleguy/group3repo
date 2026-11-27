<?php
/**
 * @var array<int,array<string,mixed>> $items      menu items with stock_qty
 * @var list<string>                    $categories
 * @var list<array<string,mixed>>       $hero
 * @var int                             $maxQty
 */
?>
<?= $this->extend('layouts/shop') ?>

<?= $this->section('bodyAttributes') ?> data-order-url="<?= esc(site_url('api/orders'), 'attr') ?>" data-max-qty="<?= (int) $maxQty ?>"<?= $this->endSection() ?>

<?= $this->section('content') ?>

  <!-- ================= NAVBAR ================= -->
  <header class="site-header">
    <nav class="container navbar" aria-label="Main">
      <a href="#top" class="brand">Kaffee <span class="brand__amp">&amp;</span> Co.</a>

      <div class="nav-actions">
        <ul class="nav-links">
          <li><a href="#menu" class="nav-link">Menu</a></li>
          <li><a href="#about" class="nav-link">About</a></li>
          <li><a href="#contact" class="nav-link">Contact</a></li>
        </ul>

        <button id="cartButton" type="button" class="btn btn--primary btn--sm" aria-label="Open cart">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.3 2.3c-.6.6-.2 1.7.7 1.7H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
          <span class="cart-btn__label">Cart</span>
          <span id="cartCount" class="count-badge">0</span>
        </button>

        <button id="mobileToggle" type="button" class="icon-btn mobile-toggle" aria-label="Toggle navigation" aria-expanded="false" aria-controls="mobileNav">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
    </nav>

    <ul id="mobileNav" class="mobile-nav" hidden>
      <li><a href="#menu" class="nav-link">Menu</a></li>
      <li><a href="#about" class="nav-link">About</a></li>
      <li><a href="#contact" class="nav-link">Contact</a></li>
    </ul>
  </header>

  <main id="top" class="page">

    <!-- ================= HERO ================= -->
    <section class="container hero">
      <div>
        <p class="eyebrow hero__tag">Freshly brewed · Baked daily</p>
        <h1 class="hero__title">
          Slow mornings,<br />good coffee <span class="text-accent">&amp; warm bakes.</span>
        </h1>
        <p class="hero__lead">
          Hand-crafted coffee, Thai tea, matcha and fresh pastries — order online and pick up in minutes, or have it brought to your door.
        </p>
        <div class="hero__actions">
          <a href="#menu" class="btn btn--accent btn--lg">Order Now</a>
          <a href="#about" class="btn btn--outline btn--lg">Our Story</a>
        </div>
      </div>

      <div class="hero__visual">
        <div class="hero__backdrop" aria-hidden="true"></div>
        <div class="hero__gallery">
          <?php foreach (array_values($hero) as $i => $item): ?>
            <img class="hero__img<?= $i === 0 ? ' hero__img--wide' : '' ?>"
              src="<?= esc(menu_image_url($item['image_path']), 'attr') ?>"
              alt="<?= esc(menu_display_name($item), 'attr') ?>" />
          <?php endforeach ?>
        </div>
      </div>
    </section>

    <!-- ================= MENU ================= -->
    <section id="menu" class="menu-section">
      <div class="container section">
        <div class="menu-header">
          <div>
            <p class="eyebrow">Our Menu</p>
            <h2 class="section-title">Pick your favourites</h2>
          </div>
          <p id="menuCount" class="menu-count" aria-live="polite"><?= count($items) ?> items</p>
        </div>

        <div id="categoryFilters" class="filters" role="toolbar" aria-label="Filter menu by category">
          <button type="button" class="filter-btn is-active" data-category="" aria-pressed="true">All</button>
          <?php foreach ($categories as $category): ?>
            <button type="button" class="filter-btn" data-category="<?= esc($category, 'attr') ?>" aria-pressed="false"><?= esc($category) ?></button>
          <?php endforeach ?>
        </div>

        <div id="menuGrid" class="menu-grid">
          <?php if ($items === []): ?>
            <p class="state-message">The menu is empty right now.</p>
          <?php endif ?>

          <?php foreach ($items as $item):
              $stock   = (int) $item['stock_qty'];
              $name    = menu_display_name($item);
              $soldOut = $stock <= 0;
              $desc    = $item['category'] . (trim((string) $item['style']) !== '' ? ' · ' . $item['style'] : '') . ' · per ' . $item['unit'];
          ?>
            <article class="menu-card<?= $soldOut ? ' is-sold-out' : '' ?>"
              data-category="<?= esc($item['category'], 'attr') ?>"
              data-code="<?= esc($item['menu_code'], 'attr') ?>"
              data-name="<?= esc($name, 'attr') ?>"
              data-price="<?= esc((string) (float) $item['price'], 'attr') ?>"
              data-unit="<?= esc($item['unit'], 'attr') ?>"
              data-image="<?= esc(menu_image_url($item['image_path']), 'attr') ?>"
              data-stock="<?= $stock ?>">
              <div class="menu-card__media">
                <img class="menu-card__img" src="<?= esc(menu_image_url($item['image_path']), 'attr') ?>"
                  alt="<?= esc($name, 'attr') ?>" loading="lazy" />
                <span class="menu-card__badge">Sold out</span>
              </div>
              <div class="menu-card__body">
                <h3 class="menu-card__name"><?= esc($name) ?></h3>
                <p class="menu-card__desc"><?= esc($desc) ?></p>
                <div class="menu-card__footer">
                  <span class="menu-card__price"><?= esc(format_baht($item['price'])) ?></span>
                  <button type="button" class="btn btn--primary btn--sm" data-add <?= $soldOut ? 'disabled' : '' ?>>
                    <?= $soldOut ? 'Sold out' : 'Add to Cart' ?>
                  </button>
                </div>
              </div>
            </article>
          <?php endforeach ?>
        </div>
      </div>
    </section>

    <!-- ================= ABOUT ================= -->
    <section id="about" class="container section about">
      <div class="about__text">
        <p class="eyebrow">About Us</p>
        <h2 class="section-title">A small café with a big heart</h2>
        <p>
          Kaffee &amp; Co. started as a tiny counter with one espresso machine and a love for unhurried mornings.
          Today we still roast in small batches, steep our Thai tea the traditional way, whisk matcha to order,
          and bake our cakes and cookies fresh every morning.
        </p>
        <p>
          Whether you need a quick americano on the way to work or a slow afternoon with cake and friends,
          there's always a seat — and a warm cup — waiting for you.
        </p>
      </div>
      <div class="info-cards">
        <div class="info-card">
          <h3 class="info-card__title">Opening Hours</h3>
          <ul class="hours-list">
            <li><span>Mon – Fri</span><strong>7:00 – 19:00</strong></li>
            <li><span>Saturday</span><strong>8:00 – 20:00</strong></li>
            <li><span>Sunday</span><strong>8:00 – 18:00</strong></li>
          </ul>
        </div>
        <div class="info-card info-card--dark">
          <h3 class="info-card__title">Visit Us</h3>
          <p class="info-card__text">88 Sukhumvit Soi 11<br />Khlong Toei Nuea, Watthana<br />Bangkok 10110</p>
        </div>
      </div>
    </section>
  </main>

  <!-- ================= FOOTER / CONTACT ================= -->
  <footer id="contact" class="site-footer">
    <div class="container footer-grid">
      <div>
        <p class="brand">Kaffee <span class="brand__amp">&amp;</span> Co.</p>
        <p class="footer-tagline">Coffee, tea and fresh bakes — made slowly, served warmly.</p>
      </div>
      <div>
        <h3 class="footer-heading">Contact</h3>
        <ul class="footer-list">
          <li>Phone: <a href="tel:+6621234567">02-123-4567</a></li>
          <li>Email: <a href="mailto:hello@kaffeeandco.com">hello@kaffeeandco.com</a></li>
          <li>LINE: @kaffeeandco</li>
        </ul>
      </div>
      <div>
        <h3 class="footer-heading">Location</h3>
        <ul class="footer-list">
          <li>88 Sukhumvit Soi 11, Bangkok 10110</li>
          <li>Open daily · See hours above</li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p class="container">&copy; <?= date('Y') ?> Kaffee &amp; Co. All rights reserved.</p>
    </div>
  </footer>

  <!-- ================= CART DRAWER ================= -->
  <div id="cartOverlay" class="overlay"></div>
  <aside id="cartDrawer" class="drawer" aria-label="Shopping cart" aria-hidden="true">
    <div class="drawer__header">
      <h2 class="drawer__title">Your Cart</h2>
      <button id="closeCart" type="button" class="icon-btn" aria-label="Close cart">
        <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
      </button>
    </div>

    <div id="cartItems" class="drawer__body"></div>

    <form id="checkoutForm" class="drawer__footer" novalidate>
      <label class="field">
        <span class="field__label">Your name</span>
        <input id="customerName" name="customer_name" class="input" maxlength="150" autocomplete="name" required />
      </label>
      <p id="cartError" class="form-error" role="alert" hidden></p>
      <div class="drawer__row">
        <span class="text-muted">Subtotal</span>
        <strong id="cartSubtotal">฿0</strong>
      </div>
      <button id="placeOrder" type="submit" class="btn btn--accent btn--block">Place Order</button>
    </form>
  </aside>

  <!-- ================= ORDER CONFIRMATION MODAL ================= -->
  <div id="orderModal" class="modal" role="dialog" aria-modal="true" aria-labelledby="orderTitle">
    <div class="modal__dialog">
      <div class="modal__header">
        <div class="modal__icon">
          <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
        </div>
        <h2 id="orderTitle" class="modal__title">Order placed!</h2>
        <p class="modal__subtitle">Order <strong id="orderNumber"></strong> · <span id="orderCustomer"></span></p>
        <p id="orderTime" class="modal__subtitle"></p>
      </div>

      <div class="modal__scroll">
        <ul id="orderSummary" class="order-summary"></ul>
      </div>

      <div class="order-total">
        <span>Total (<span id="orderItemCount"></span>)</span>
        <span id="orderTotal"></span>
      </div>

      <div class="modal__footer">
        <button id="closeOrder" type="button" class="btn btn--primary btn--block">Done</button>
      </div>
    </div>
  </div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
  <script src="<?= base_url('assets/js/shop.js') ?>"></script>
<?= $this->endSection() ?>
