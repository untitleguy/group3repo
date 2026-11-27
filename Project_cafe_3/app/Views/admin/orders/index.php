<?php
/**
 * @var list<array<string,mixed>>             $orders  rows of receipt_totals
 * @var array<int,list<array<string,mixed>>>  $details sale_id => rows of receipt_details
 * @var \CodeIgniter\Pager\Pager              $pager
 */
?>
<?= $this->extend('admin/layout') ?>
<?= $this->section('content') ?>

<?php if ($orders === []): ?>
  <div class="state-message">
    <p class="state-message__title">No orders yet</p>
    <p>Orders placed on the shop page appear here.</p>
  </div>
<?php else: ?>
  <p class="table-caption"><?= $pager->getTotal() ?> orders · newest first</p>

  <div class="order-list">
    <?php foreach ($orders as $order):
        $lines = $details[$order['sale_id']] ?? [];
        $count = array_sum(array_map('intval', array_column($lines, 'quantity')));
    ?>
      <article class="order-card">
        <div class="order-card__head">
          <div>
            <p class="order-card__id">#<?= esc($order['sale_id']) ?> · <?= esc($order['customer_name'] ?: 'Walk-in') ?></p>
            <p class="order-card__meta"><?= esc(date('d M Y, H:i', strtotime($order['sold_at']))) ?></p>
          </div>
        </div>
        <ul class="order-card__items">
          <?php foreach ($lines as $line): ?>
            <li>
              <span><?= (int) $line['quantity'] ?>× <?= esc($line['menu_name']) ?> <span class="text-muted">@ <?= esc(format_baht($line['unit_price'])) ?></span></span>
              <span><?= esc(format_baht($line['line_total'])) ?></span>
            </li>
          <?php endforeach ?>
        </ul>
        <div class="order-card__foot">
          <span class="text-muted"><?= $count ?> item<?= $count === 1 ? '' : 's' ?></span>
          <span class="order-card__total"><?= esc(format_baht($order['total_cost'])) ?></span>
        </div>
      </article>
    <?php endforeach ?>
  </div>

  <div class="pager-wrap"><?= $pager->links('default', 'default_full') ?></div>
<?php endif ?>

<?= $this->endSection() ?>
