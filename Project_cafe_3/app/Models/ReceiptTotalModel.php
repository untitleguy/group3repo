<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Read-only model over the `receipt_totals` view
 * (sale_id, sold_at, customer_name, total_cost). Used for the admin order list.
 */
class ReceiptTotalModel extends Model
{
    protected $table         = 'receipt_totals';
    protected $primaryKey    = 'sale_id';
    protected $returnType    = 'array';
    protected $allowedFields = [];

    /** Line items for a set of sales, grouped by sale_id (from `receipt_details`). */
    public function detailsFor(array $saleIds): array
    {
        if ($saleIds === []) {
            return [];
        }

        $rows = $this->db->table('receipt_details')
            ->whereIn('sale_id', $saleIds)
            ->get()->getResultArray();

        $grouped = [];
        foreach ($rows as $row) {
            $grouped[$row['sale_id']][] = $row;
        }

        return $grouped;
    }
}
