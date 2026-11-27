<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Table `inventory` (primary key `menu_code`, column `stock_qty`).
 * Stock is reduced/restored by the database triggers on `sale_items`.
 */
class InventoryModel extends Model
{
    protected $table            = 'inventory';
    protected $primaryKey       = 'menu_code';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = ['menu_code', 'stock_qty'];

    /** Insert or update the stock for one menu item. */
    public function setStock(string $menuCode, int $qty): void
    {
        $qty = max(0, $qty);

        if ($this->find($menuCode) === null) {
            $this->insert(['menu_code' => $menuCode, 'stock_qty' => $qty]);
        } else {
            $this->update($menuCode, ['stock_qty' => $qty]);
        }
    }

    /** @return array<string,int> menu_code => stock_qty for the given codes */
    public function stockFor(array $menuCodes): array
    {
        if ($menuCodes === []) {
            return [];
        }
        $rows = $this->whereIn('menu_code', $menuCodes)->findAll();

        return array_map('intval', array_column($rows, 'stock_qty', 'menu_code'));
    }
}
