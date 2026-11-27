<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-header" content="<?= esc(csrf_header(), 'attr') ?>" />
  <meta name="csrf-token" content="<?= esc(csrf_hash(), 'attr') ?>" />
  <title><?= esc($pageTitle ?? 'Kaffee & Co. — Online Café') ?></title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Noto+Sans+Thai:wght@400;500;600;700&display=swap" />

  <link rel="stylesheet" href="<?= base_url('assets/css/theme.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/base.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/components.css') ?>" />
  <?= $this->renderSection('styles') ?>
</head>
<body<?= $this->renderSection('bodyAttributes') ?>>
  <?= $this->renderSection('content') ?>

  <div id="toast" class="toast" role="status" aria-live="polite"></div>
  <?= $this->renderSection('scripts') ?>
</body>
</html>
