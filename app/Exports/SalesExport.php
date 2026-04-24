<?php

namespace App\Exports;

use App\Repositories\Interfaces\SaleRepositoryInterface;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;

class SalesExport implements WithMultipleSheets
{
    public function __construct(
        protected SaleRepositoryInterface $saleRepository,
        protected array $filters
    ) {}

    public function sheets(): array
    {
        return [
            new SalesDataSheet($this->saleRepository, $this->filters),
            new SalesSummarySheet($this->saleRepository)
        ];
    }
}

class SalesDataSheet implements FromQuery, WithHeadings, WithMapping, WithTitle
{
    public function __construct(
        protected SaleRepositoryInterface $saleRepository,
        protected array $filters
    ) {}

    public function query()
    {
        return $this->saleRepository->getFilteredQuery($this->filters);
    }

    public function headings(): array
    {
        return [
            'Sale ID', 'Branch', 'Date', 'Product', 'Category', 
            'Qty', 'Price', 'Discount', 'Payment', 'Salesperson', 'Revenue'
        ];
    }

    public function map($sale): array
    {
        return [
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
        ];
    }

    public function title(): string
    {
        return 'Sales Data';
    }
}

class SalesSummarySheet implements FromCollection, WithHeadings, WithTitle
{
    public function __construct(protected SaleRepositoryInterface $saleRepository) {}

    public function collection()
    {
        $summary = $this->saleRepository->getSummary();
        return collect($summary['branch_breakdown']);
    }

    public function headings(): array
    {
        return ['Branch', 'Orders Count', 'Total Qty', 'Total Revenue'];
    }

    public function title(): string
    {
        return 'Summary';
    }
}
