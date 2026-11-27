<?php

namespace App\Models;

use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Model;
use RuntimeException;
use Throwable;

/**
 * Table `sales` (one row per order) + `sale_items` (order lines).
 *
 * The `sale_items` triggers in the database fill in menu_name/unit_price
 * from `menu_items` and subtract stock from `inventory`, refusing the
 * insert when stock is too low. placeOrder() relies on that.
 */
class SaleModel extends Model
{
    protected $table            = 'sales';
    protected $primaryKey       = 'sale_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['customer_name'];

    /**
     * Saves an order in one transaction.
     *
     * @param array<string,int> $quantities menu_code => quantity (already validated)
     *
     * @return int the new sale_id
     *
     * @throws RuntimeException with a customer-friendly message
     */
    public function placeOrder(string $customerName, array $quantities): int
    {
        helper('cafe');

        $db    = $this->db;
        $menu  = model(MenuItemModel::class)->whereIn('menu_code', array_keys($quantities))->findAll();
        $menu  = array_column($menu, null, 'menu_code');
        $stock = model(InventoryModel::class)->stockFor(array_keys($quantities));

        // Friendly checks first; the triggers enforce the same rules as a safety net.
        foreach ($quantities as $code => $qty) {
            if (! isset($menu[$code])) {
                throw new RuntimeException('An item in your cart is no longer on the menu. Please refresh the page.');
            }
            if (($stock[$code] ?? 0) < $qty) {
                $left = $stock[$code] ?? 0;

                throw new RuntimeException(sprintf(
                    'Sorry, only %d left of %s.',
                    $left,
                    menu_display_name($menu[$code])
                ));
            }
        }

        $db->transBegin();

        try {
            $db->table('sales')->insert(['customer_name' => $customerName]);
            $saleId = (int) $db->insertID();

            foreach ($quantities as $code => $qty) {
                $db->table('sale_items')->insert([
                    'sale_id'    => $saleId,
                    'menu_code'  => $code,
                    'menu_name'  => $menu[$code]['menu_name'], // trigger also sets these
                    'unit_price' => $menu[$code]['price'],
                    'quantity'   => $qty,
                ]);
            }

            $db->transCommit();
        } catch (Throwable $e) {
            $db->transRollback();

            if ($e instanceof DatabaseException && str_contains($e->getMessage(), 'Insufficient stock')) {
                throw new RuntimeException('Sorry, one of the items just sold out. Please check your cart.', 0, $e);
            }
            log_message('error', 'Order failed: {message}', ['message' => $e->getMessage()]);

            throw new RuntimeException('We could not place your order. Please try again.', 0, $e);
        }

        return $saleId;
    }

    /**
     * Receipt for one sale, using the `receipt_details` / `receipt_totals` views.
     */
    public function receipt(int $saleId): ?array
    {
        $total = $this->db->table('receipt_totals')->where('sale_id', $saleId)->get()->getRowArray();
        if (! $total) {
            return null;
        }

        $items = $this->db->table('receipt_details')
            ->select('menu_name, quantity, unit_price, line_total')
            ->where('sale_id', $saleId)
            ->get()->getResultArray();

        return [
            'sale_id'       => (int) $total['sale_id'],
            'sold_at'       => $total['sold_at'],
            'customer_name' => $total['customer_name'],
            'total'         => (float) $total['total_cost'],
            'item_count'    => array_sum(array_map('intval', array_column($items, 'quantity'))),
            'items'         => array_map(static fn (array $i): array => [
                'menu_name'  => $i['menu_name'],
                'quantity'   => (int) $i['quantity'],
                'unit_price' => (float) $i['unit_price'],
                'line_total' => (float) $i['line_total'],
            ], $items),
        ];
    }
}
