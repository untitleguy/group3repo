<?php
/**
 * @var array<string,mixed> $item
 * @var bool                $isNew
 * @var list<string>        $categories
 * @var array<string,string> $errors
 * @var string              $title
 */
$action = $isNew
    ? site_url('admin/menu')
    : site_url('admin/menu/' . rawurlencode($item['menu_code']));
$value = static fn (string $key): string => (string) ($item[$key] ?? '');
?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<div class="form-card">
  <h1 class="modal__heading"><?= esc($title) ?></h1>

  <?php if ($errors !== []): ?>
    <div class="form-error" role="alert">
      <ul class="error-list">
        <?php foreach ($errors as $error): ?>
          <li><?= esc($error) ?></li>
        <?php endforeach ?>
      </ul>
    </div>
  <?php endif ?>

  <form action="<?= $action ?>" method="post" novalidate>
    <?= csrf_field() ?>

    <div class="form-grid">
      <div class="field">
        <span class="field__label">Code</span>
        <p class="field__static"><?= esc($item['menu_code']) ?></p>
        <?php if ($isNew): ?><span class="field__hint">Assigned automatically when saved.</span><?php endif ?>
      </div>
      <label class="field">
        <span class="field__label">Name *</span>
        <input name="menu_name" class="input" maxlength="150" value="<?= esc($value('menu_name'), 'attr') ?>" required />
      </label>
      <label class="field">
        <span class="field__label">Style</span>
        <input name="style" class="input" maxlength="50" value="<?= esc($value('style'), 'attr') ?>" placeholder="e.g. ร้อน / เย็น / ปั่น" />
        <span class="field__hint">Leave empty if not applicable.</span>
      </label>
      <label class="field">
        <span class="field__label">Category *</span>
        <input name="category" class="input" maxlength="100" list="categoryOptions" value="<?= esc($value('category'), 'attr') ?>" required />
        <span class="field__hint">Pick an existing one or type a new category.</span>
        <datalist id="categoryOptions">
          <?php foreach ($categories as $category): ?>
            <option value="<?= esc($category, 'attr') ?>"></option>
          <?php endforeach ?>
        </datalist>
      </label>
      <label class="field">
        <span class="field__label">Price (THB) *</span>
        <input name="price" class="input" type="number" min="0" step="0.01" inputmode="decimal" value="<?= esc($value('price'), 'attr') ?>" required />
      </label>
      <label class="field">
        <span class="field__label">Unit *</span>
        <input name="unit" class="input" maxlength="30" value="<?= esc($value('unit'), 'attr') ?>" placeholder="e.g. แก้ว / ชิ้น / ที่" required />
      </label>
      <label class="field">
        <span class="field__label">Stock *</span>
        <input name="stock_qty" class="input" type="number" min="0" step="1" value="<?= esc($value('stock_qty'), 'attr') ?>" required />
        <span class="field__hint">0 shows the item as “Sold out” in the shop.</span>
      </label>
      <label class="field">
        <span class="field__label">Image path</span>
        <input name="image_path" class="input" maxlength="255" value="<?= esc($value('image_path'), 'attr') ?>"
          placeholder="กาแฟ/ลาเต้ เย็น.png" data-image-input
          data-image-base="<?= esc(base_url(config('Cafe')->menuImageFolder), 'attr') ?>" />
        <span class="field__hint">Relative to public/<?= esc(config('Cafe')->menuImageFolder) ?>, or a full URL.</span>
      </label>
      <div class="form-grid__full">
        <img class="form-preview" data-image-preview alt="Image preview"
          src="<?= esc(menu_image_url($value('image_path')), 'attr') ?>" <?= $value('image_path') === '' ? 'hidden' : '' ?> />
      </div>
    </div>

    <div class="form-actions">
      <a href="<?= site_url('admin/menu') ?>" class="btn btn--outline">Cancel</a>
      <button type="submit" class="btn btn--primary"><?= $isNew ? 'Add item' : 'Save changes' ?></button>
    </div>
  </form>
</div>

<?= $this->endSection() ?>
