<?php

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SaleRepositoryInterface
{
    public function getAllFiltered(array $filters): LengthAwarePaginator;

    public function getSummary(): array;

    public function findBySaleId(string $saleId): bool;

    public function insertChunk(array $rows): array;

    public function getFilteredQuery(array $filters);
}
