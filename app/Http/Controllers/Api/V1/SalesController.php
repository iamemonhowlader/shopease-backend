<?php

namespace App\Http\Controllers\Api\V1;

use App\Repositories\Interfaces\SaleRepositoryInterface;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function __construct(protected SaleRepositoryInterface $saleRepository) {}

    public function index(Request $request)
    {
        $filters = $request->only(['branch', 'from', 'to', 'category', 'payment_method']);
        $sales = $this->saleRepository->getAllFiltered($filters);

        return response()->json($sales);
    }

    public function summary()
    {
        $summary = $this->saleRepository->getSummary();
        return response()->json($summary);
    }
}
