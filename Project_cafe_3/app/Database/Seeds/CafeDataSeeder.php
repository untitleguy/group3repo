<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * One-time clean-up of the imported dump (sql_group3_shaoransoft_com.sql).
 *
 *   php spark db:seed CafeDataSeeder
 *
 * 1. Removes the stray CSV header row (menu_code = 'รหัสเมนู') from
 *    inventory and menu_items, unless it was ever sold.
 * 2. Gives every menu item without an inventory row a stock of
 *    Config\Cafe::$defaultStock (10). Existing stock rows are not changed.
 *
 * Safe to run more than once.
 */
class CafeDataSeeder extends Seeder
{
    private const JUNK_CODE = 'รหัสเมนู';

    public function run(): void
    {
        $db = $this->db;

        $db->transException(true)->transStart();

        // 1. Stray header row
        $junkSold = $db->table('sale_items')->where('menu_code', self::JUNK_CODE)->countAllResults();
        if ($junkSold === 0) {
            $db->table('inventory')->where('menu_code', self::JUNK_CODE)->delete();
            $db->table('menu_items')->where('menu_code', self::JUNK_CODE)->delete();
            $removed = $db->affectedRows();
        } else {
            $removed = 0;
        }

        // 2. Missing stock rows
        $missing = $db->table('menu_items m')
            ->select('m.menu_code')
            ->join('inventory i', 'i.menu_code = m.menu_code', 'left')
            ->where('i.menu_code', null)
            ->get()->getResultArray();

        $stock = config('Cafe')->defaultStock;
        foreach ($missing as $row) {
            $db->table('inventory')->insert(['menu_code' => $row['menu_code'], 'stock_qty' => $stock]);
        }

        $db->transComplete();

        if (is_cli()) {
            echo "Removed header row: {$removed}" . ($junkSold ? ' (skipped: it has sales)' : '') . PHP_EOL;
            echo 'Inventory rows added: ' . count($missing) . " (stock {$stock} each)" . PHP_EOL;
        }
    }
}
