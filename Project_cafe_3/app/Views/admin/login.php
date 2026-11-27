<?php /** @var bool $disabled */ ?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="login-card">
  <h1 class="modal__heading">Admin login</h1>

  <?php if ($disabled): ?>
    <p class="form-error">Admin login is disabled. Set <code>cafe.adminPassword</code> in the project's <code>.env</code> file, then reload this page.</p>
  <?php else: ?>
    <form action="<?= site_url('admin/login') ?>" method="post" class="login-form">
      <?= csrf_field() ?>
      <label class="field">
        <span class="field__label">Username</span>
        <input name="username" class="input" value="<?= esc(old('username'), 'attr') ?>" autocomplete="username" required autofocus />
      </label>
      <label class="field">
        <span class="field__label">Password</span>
        <input name="password" type="password" class="input" autocomplete="current-password" required />
      </label>
      <button type="submit" class="btn btn--primary btn--block">Log in</button>
    </form>
  <?php endif ?>
</div>

<?= $this->endSection() ?>
