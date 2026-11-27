<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\InventoryModel;
use App\Models\SaleModel;
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;

/**
 * POST api/orders  (JSON, CSRF token in the X-CSRF-TOKEN header)
 *
 * Request:  { "customer_name": "Somchai", "items": [{ "menu_code": "MENU-001", "quantity": 2 }] }
 * 201:      { "order": { sale_id, sold_at, customer_name, total, item_count, items[] },
 *             "stock": { "MENU-001": 8 }, "csrf": "<new token>" }
 * 422:      { "message": "...", "csrf": "<new token>" }
 */
class Orders extends BaseController
{
    public function create(): ResponseInterface
    {
        $body = $this->request->getJSON(true);
        if (! is_array($body)) {
            return $this->fail('Invalid request.');
        }

        $name = trim((string) ($body['customer_name'] ?? ''));
        if ($name === '') {
            return $this->fail('Please enter your name.');
        }
        if (mb_strlen($name) > 150) {
            return $this->fail('Name is too long (150 characters max).');
        }

        $max        = config('Cafe')->maxQuantityPerItem;
        $quantities = [];
        foreach ((array) ($body['items'] ?? []) as $line) {
            $code = trim((string) ($line['menu_code'] ?? ''));
            $qty  = filter_var($line['quantity'] ?? null, FILTER_VALIDATE_INT);
            if ($code === '' || $qty === false || $qty < 1) {
                return $this->fail('Invalid item in cart.');
            }
            $quantities[$code] = ($quantities[$code] ?? 0) + $qty;
            if ($quantities[$code] > $max) {
                return $this->fail("You can order at most {$max} of one item.");
            }
        }
        if ($quantities === []) {
            return $this->fail('Your cart is empty.');
        }

        $sales = model(SaleModel::class);

        try {
            $saleId = $sales->placeOrder($name, $quantities);
        } catch (RuntimeException $e) {
            return $this->fail($e->getMessage());
        }

        return $this->response->setStatusCode(201)->setJSON([
            'order' => $sales->receipt($saleId),
            'stock' => model(InventoryModel::class)->stockFor(array_keys($quantities)),
            'csrf'  => csrf_hash(),
        ]);
    }

    private function fail(string $message): ResponseInterface
    {
        return $this->response->setStatusCode(422)->setJSON([
            'message' => $message,
            'csrf'    => csrf_hash(),
        ]);
    }
}
