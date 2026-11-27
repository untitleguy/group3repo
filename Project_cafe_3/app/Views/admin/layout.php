<?php
/** @var string $title */
$current = uri_string();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= esc($title ?? 'Admin') ?> — Kaffee &amp; Co. Admin</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700&display=swap" />

  <link rel="stylesheet" href="<?= base_url('assets/css/theme.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/base.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/components.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>" />
</head>
<body>

  <header class="admin-header">
    <div class="container admin-header__inner">
      <p class="brand">Kaffee <span class="brand__amp">&amp;</span> Co. <span class="admin-badge">Admin</span></p>
      <?php if (session()->get('isAdmin') === true): ?>
        <div class="admin-header__actions">
          <a href="<?= site_url('/') ?>" class="btn btn--outline btn--sm">View shop</a>
          <form action="<?= site_url('admin/logout') ?>" method="post">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn--outline btn--sm">Log out</button>
          </form>
        </div>
      <?php endif ?>
    </div>
  </header>

  <main class="container admin-main">
    <?php if (session()->get('isAdmin') === true): ?>
      <nav class="tabs" aria-label="Admin sections">
        <a href="<?= site_url('admin/menu') ?>" class="tab<?= str_starts_with($current, 'admin/orders') ? '' : ' is-active' ?>">Menu</a>
        <a href="<?= site_url('admin/orders') ?>" class="tab<?= str_starts_with($current, 'admin/orders') ? ' is-active' : '' ?>">Orders</a>
      </nav>
    <?php endif ?>

    <?php if ($msg = session()->getFlashdata('message')): ?>
      <p class="flash flash--success" role="status"><?= esc($msg) ?></p>
    <?php endif ?>
    <?php if ($err = session()->getFlashdata('error')): ?>
      <p class="flash flash--error" role="alert"><?= esc($err) ?></p>
    <?php endif ?>

    <?= $this->renderSection('content') ?>
  </main>

  <script src="<?= base_url('assets/js/admin.js') ?>"></script>
</body>
</html>
