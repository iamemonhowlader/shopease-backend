<?php

namespace App\Http\Controllers\Api\V1;

use App\Exports\SalesExport;
use App\Repositories\Interfaces\SaleRepositoryInterface;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function __construct(protected SaleRepositoryInterface $saleRepository) {}

    public function exportCsv(Request $request)
    {
        $filters = $request->only(['branch', 'from', 'to', 'category', 'payment_method']);
        $query = $this->saleRepository->getFilteredQuery($filters);
        
        $count = (clone $query)->count();

        if ($count > 10000) {
            return response()->json([
                'job_id' => 'csv_export_' . uniqid(),
                'status' => 'processing',
                'message' => 'Large file detected. Processing in background.'
            ]);
        }

        return new StreamedResponse(function() use ($query) {
            $handle = fopen('php://output', 'w');
            
            // UTF-8 BOM for Excel Bengali support
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Headers
            fputcsv($handle, [
                'Sale ID', 'Branch', 'Date', 'Product', 'Category', 
                'Qty', 'Price', 'Discount', 'Payment', 'Salesperson', 'Revenue'
            ]);

            foreach ($query->cursor() as $sale) {
                fputcsv($handle, [
                    $sale->sale_id,
                    $sale->branch,
                    $sale->sale_date->format('Y-m-d'),
                    $sale->product_name,
                    $sale->category ?? 'N/A',
                    $sale->quantity,
                    $sale->unit_price,
                    $sale->discount_pct,
                    $sale->payment_method,
                    $sale->salesperson,
                    $sale->revenue
                ]);
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="sales_export_' . now()->format('YmdHis') . '.csv"',
        ]);
    }

    public function exportExcel(Request $request)
    {
        $filters = $request->only(['branch', 'from', 'to', 'category', 'payment_method']);
        $query = $this->saleRepository->getFilteredQuery($filters);
        
        $count = (clone $query)->count();

        if ($count > 10000) {
            return response()->json([
                'job_id' => 'excel_export_' . uniqid(),
                'status' => 'processing'
            ]);
        }

        return Excel::download(new SalesExport($this->saleRepository, $filters), 'sales_report.xlsx');
    }
}
