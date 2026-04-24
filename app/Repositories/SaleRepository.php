<?php

namespace App\Repositories;

use App\Models\Sale;
use App\Repositories\Interfaces\SaleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class SaleRepository implements SaleRepositoryInterface
{
    public function getAllFiltered(array $filters): LengthAwarePaginator
    {
        return $this->getFilteredQuery($filters)->paginate(100);
    }

    public function getSummary(): array
    {
        $summary = Sale::query()
            ->selectRaw('
                COALESCE(SUM(revenue), 0) as total_revenue,
                COALESCE(SUM(quantity), 0) as total_quantity,
                COUNT(*) as total_orders,
                COALESCE(AVG(revenue), 0) as avg_order_value
            ')
            ->first();

        $topProducts = Sale::query()
            ->select('product_name', DB::raw('SUM(revenue) as total_revenue'))
            ->groupBy('product_name')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        $branchBreakdown = Sale::query()
            ->select('branch', 
                DB::raw('COUNT(*) as orders_count'),
                DB::raw('SUM(quantity) as total_qty'),
                DB::raw('SUM(revenue) as total_revenue')
            )
            ->groupBy('branch')
            ->get();

        return [
            'total_revenue' => round($summary->total_revenue, 2),
            'total_quantity' => (int) $summary->total_quantity,
            'total_orders' => (int) $summary->total_orders,
            'avg_order_value' => round($summary->avg_order_value, 2),
            'top_products' => $topProducts,
            'branch_breakdown' => $branchBreakdown
        ];
    }

    public function findBySaleId(string $saleId): bool
    {
        return Sale::where('sale_id', $saleId)->exists();
    }

    public function insertChunk(array $rows): array
    {
        $existingIds = Sale::whereIn('sale_id', array_column($rows, 'sale_id'))
            ->pluck('sale_id')
            ->toArray();

        $toInsert = [];
        $skippedDuplicate = 0;

        foreach ($rows as $row) {
            if (in_array($row['sale_id'], $existingIds)) {
                $skippedDuplicate++;
                continue;
            }
            $toInsert[] = $row;
            // Prevent duplicate sale_ids within the same chunk
            $existingIds[] = $row['sale_id'];
        }

        if (!empty($toInsert)) {
            Sale::insert($toInsert);
        }

        return [
            'inserted' => count($toInsert),
            'skipped_duplicate' => $skippedDuplicate
        ];
    }

    public function getFilteredQuery(array $filters)
    {
        $query = Sale::query();

        if (!empty($filters['branch'])) {
            $query->where('branch', $filters['branch']);
        }

        if (!empty($filters['from'])) {
            $query->where('sale_date', '>=', $filters['from']);
        }

        if (!empty($filters['to'])) {
            $query->where('sale_date', '<=', $filters['to']);
        }

        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (!empty($filters['payment_method'])) {
            $query->where('payment_method', $filters['payment_method']);
        }

        return $query->orderBy('sale_date', 'desc');
    }
}
