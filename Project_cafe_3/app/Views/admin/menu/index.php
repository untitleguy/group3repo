<?php
/**
 * @var list<array<string,mixed>> $items
 * @var int                       $total
 * @var list<string>              $categories
 * @var array{q:string,category:string} $filters
 */
?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<form class="toolbar" method="get" action="<?= site_url('admin/menu') ?>">
  <div class="toolbar__group">
    <label class="visually-hidden" for="menuSearch">Search menu</label>
    <input id="menuSearch" name="q" type="search" class="input" placeholder="Search name, code, category…" value="<?= esc($filters['q'], 'attr') ?>" />
    <label class="visually-hidden" for="menuCategory">Filter by category</label>
    <select id="menuCategory" name="category" class="select" data-autosubmit>
      <option value="">All categories</option>
      <?php foreach ($categories as $category): ?>
        <option value="<?= esc($category, 'attr') ?>" <?= $filters['category'] === $category ? 'selected' : '' ?>><?= esc($category) ?></option>
      <?php endforeach ?>
    </select>
    <button type="submit" class="btn btn--outline btn--sm">Search</button>
    <?php if ($filters['q'] !== '' || $filters['category'] !== ''): ?>
      <a href="<?= site_url('admin/menu') ?>" class="btn btn--outline btn--sm">Clear</a>
    <?php endif ?>
  </div>
  <a href="<?= site_url('admin/menu/new') ?>" class="btn btn--accent btn--sm">+ Add item</a>
</form>

<p class="table-caption"><?= count($items) ?> of <?= $total ?> items</p>

<div class="table-wrap">
  <table class="data-table">
    <thead>
      <tr>
        <th scope="col"><span class="visually-hidden">Image</span></th>
        <th scope="col">Code</th>
        <th scope="col">Name</th>
        <th scope="col">Style</th>
        <th scope="col">Category</th>
        <th scope="col" class="is-numeric">Price</th>
        <th scope="col">Unit</th>
        <th scope="col" class="is-numeric">Stock</th>
        <th scope="col"><span class="visually-hidden">Actions</span></th>
      </tr>
    </thead>
    <tbody>
      <?php if ($items === []): ?>
        <tr><td colspan="9" class="state-message">No menu items match.</td></tr>
      <?php endif ?>
      <?php foreach ($items as $item): $stock = (int) $item['stock_qty']; ?>
        <tr>
          <td><img class="thumb" src="<?= esc(menu_image_url($item['image_path']), 'attr') ?>" alt="" loading="lazy" /></td>
          <td class="cell-id"><?= esc($item['menu_code']) ?></td>
          <td class="cell-name"><?= esc($item['menu_name']) ?></td>
          <td><?= esc($item['style'] ?: '—') ?></td>
          <td><?= esc($item['category']) ?></td>
          <td class="is-numeric"><?= esc(format_baht($item['price'])) ?></td>
          <td><?= esc($item['unit']) ?></td>
          <td class="is-numeric"><span class="stock<?= $stock <= 0 ? ' stock--out' : '' ?>"><?= $stock <= 0 ? 'Sold out' : $stock ?></span></td>
          <td>
            <div class="row-actions">
              <a href="<?= site_url('admin/menu/' . rawurlencode($item['menu_code']) . '/edit') ?>" class="btn btn--outline btn--sm">Edit</a>
              <form action="<?= site_url('admin/menu/' . rawurlencode($item['menu_code']) . '/delete') ?>" method="post"
                data-confirm="Delete <?= esc(menu_display_name($item), 'attr') ?> (<?= esc($item['menu_code'], 'attr') ?>)? This cannot be undone.">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn--danger btn--sm">Delete</button>
              </form>
            </div>
          </td>
        </tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
