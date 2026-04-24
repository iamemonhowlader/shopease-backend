<?php

namespace App\Services;

use App\Repositories\Interfaces\SaleRepositoryInterface;
use League\Csv\Reader;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImportService
{
    public function __construct(
        protected SaleRepositoryInterface $saleRepository,
        protected CsvCleaningService $cleaner
    ) {}

    public function handle(string $filePath): array
    {
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0);

        $stats = [
            'total' => 0,
            'inserted' => 0,
            'skipped_duplicate' => 0,
            'skipped_invalid' => 0,
            'error_log_url' => null
        ];

        $chunk = [];
        $errorLog = [];
        $chunkSize = 500;

        foreach ($csv as $record) {
            $stats['total']++;
            
            $cleanRow = $this->cleaner->cleanRow($record);
            
            if ($cleanRow === false) {
                $stats['skipped_invalid']++;
                $errorLog[] = [
                    'row' => $stats['total'] + 1,
                    'data' => $record,
                    'reason' => 'Validation failed (Date, Price, or Quantity invalid)'
                ];
                continue;
            }

            $chunk[] = $cleanRow;

            if (count($chunk) >= $chunkSize) {
                $result = $this->saleRepository->insertChunk($chunk);
                $stats['inserted'] += $result['inserted'];
                $stats['skipped_duplicate'] += $result['skipped_duplicate'];
                $chunk = [];
            }
        }

        // Process remaining rows
        if (!empty($chunk)) {
            $result = $this->saleRepository->insertChunk($chunk);
            $stats['inserted'] += $result['inserted'];
            $stats['skipped_duplicate'] += $result['skipped_duplicate'];
        }

        if (!empty($errorLog)) {
            $fileName = 'import_errors_' . time() . '.json';
            Storage::disk('public')->put('logs/' . $fileName, json_encode($errorLog, JSON_PRETTY_PRINT));
            $stats['error_log_url'] = url('storage/logs/' . $fileName);
        }

        return $stats;
    }
}
