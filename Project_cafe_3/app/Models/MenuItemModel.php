<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Table `menu_items` (primary key `menu_code`, e.g. "MENU-001").
 */
class MenuItemModel extends Model
{
    protected $table            = 'menu_items';
    protected $primaryKey       = 'menu_code';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = ['menu_code', 'category', 'menu_name', 'style', 'price', 'unit', 'image_path'];
    protected $useTimestamps    = false;
    // Input is validated in Controllers/Admin/Menu.php before saving.

    /**
     * Menu items joined with their stock (`inventory.stock_qty`, 0 when missing).
     *
     * @param array{q?: string, category?: string} $filters
     */
    public function withStock(array $filters = []): array
    {
        $builder = $this->db->table('menu_items m')
            ->select('m.*, COALESCE(i.stock_qty, 0) AS stock_qty')
            ->join('inventory i', 'i.menu_code = m.menu_code', 'left');

        if (! empty($filters['category'])) {
            $builder->where('m.category', $filters['category']);
        }
        if (! empty($filters['q'])) {
            $builder->groupStart()
                ->like('m.menu_code', $filters['q'])
                ->orLike('m.menu_name', $filters['q'])
                ->orLike('m.style', $filters['q'])
                ->orLike('m.category', $filters['q'])
                ->groupEnd();
        }

        return $builder->orderBy('m.menu_code', 'ASC')->get()->getResultArray();
    }

    /** One item with its stock, or null. */
    public function findWithStock(string $menuCode): ?array
    {
        $row = $this->db->table('menu_items m')
            ->select('m.*, COALESCE(i.stock_qty, 0) AS stock_qty')
            ->join('inventory i', 'i.menu_code = m.menu_code', 'left')
            ->where('m.menu_code', $menuCode)
            ->get()->getRowArray();

        return $row ?: null;
    }

    /** Distinct categories in first-seen (menu_code) order. */
    public function categories(): array
    {
        $rows = $this->db->table('menu_items')
            ->select('category, MIN(menu_code) AS first_code')
            ->groupBy('category')
            ->orderBy('first_code', 'ASC')
            ->get()->getResultArray();

        return array_column($rows, 'category');
    }

    /** Next free code: highest "MENU-###" number + 1. */
    public function nextMenuCode(): string
    {
        $max = 0;
        foreach ($this->builder()->select('menu_code')->like('menu_code', 'MENU-', 'after')->get()->getResultArray() as $row) {
            $n = (int) preg_replace('/\D/', '', $row['menu_code']);
            $max = max($max, $n);
        }

        return 'MENU-' . str_pad((string) ($max + 1), 3, '0', STR_PAD_LEFT);
    }

    /** True when the item appears in any sale (then it must not be deleted). */
    public function hasSales(string $menuCode): bool
    {
        return $this->db->table('sale_items')->where('menu_code', $menuCode)->countAllResults() > 0;
    }
}
