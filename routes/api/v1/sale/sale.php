<?php

use App\Http\Controllers\Api\V1\ImportController;
use App\Http\Controllers\Api\V1\SalesController;
use App\Http\Controllers\Api\V1\ExportController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/sales')->name('api.v1.sales.')->group(function () {
    Route::post('/import', [ImportController::class, 'import']);
    Route::get('/sales', [SalesController::class, 'index']);
    Route::get('/sales/summary', [SalesController::class, 'summary']);
    Route::get('/export/csv', [ExportController::class, 'exportCsv']);
    Route::get('/export/excel', [ExportController::class, 'exportExcel']);
});
