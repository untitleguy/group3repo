<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ReceiptTotalModel;

/**
 * Read-only list of orders (`sales`), newest first, using the receipt views.
 */
class Orders extends BaseController
{
    public function index(): string
    {
        $model  = model(ReceiptTotalModel::class);
        $orders = $model->orderBy('sale_id', 'DESC')->paginate(config('Cafe')->ordersPerPage);

        return view('admin/orders/index', [
            'title'   => 'Orders',
            'orders'  => $orders,
            'details' => $model->detailsFor(array_column($orders, 'sale_id')),
            'pager'   => $model->pager,
        ]);
    }
}
