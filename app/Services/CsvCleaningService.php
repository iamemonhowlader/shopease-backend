<?php

namespace App\Services;

use Carbon\Carbon;

class CsvCleaningService
{
    public function cleanBranch(string $value): string
    {
        return ucfirst(strtolower(trim($value)));
    }

    public function cleanDate(string $value): ?string
    {
        $value = trim($value);
        $formats = ['d/m/Y', 'Y-m-d', 'm-d-Y'];

        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, $value)->format('Y-m-d');
            } catch (\Exception $e) {
                continue;
            }
        }

        return null;
    }

    public function cleanPrice(string $value): ?float
    {
        $cleanValue = preg_replace('/[৳,\s]/u', '', $value);
        return is_numeric($cleanValue) ? (float) $cleanValue : null;
    }

    public function cleanDiscount(string $value): float
    {
        $value = trim($value);
        $value = str_replace('%', '', $value);
        
        if (!is_numeric($value)) {
            return 0.0000;
        }

        $val = (float) $value;

        // If "10%" was "10" or "10.0", it becomes 0.10
        // If "0.10" was "0.10", it stays 0.10
        if ($val > 1) {
            return $val / 100;
        }

        return $val;
    }

    public function cleanCategory(?string $value): ?string
    {
        if (is_null($value)) return null;
        
        $val = trim($value);
        $nullVariants = ['', 'N/A', 'n/a', '-', 'null', 'NULL'];
        
        return in_array($val, $nullVariants) ? null : $val;
    }

    public function cleanPaymentMethod(string $value): string
    {
        $val = strtolower(trim($value));
        
        return match ($val) {
            'cash' => 'Cash',
            'bkash' => 'bKash',
            'nagad' => 'Nagad',
            'card' => 'Card',
            default => ucfirst($val),
        };
    }

    public function cleanRow(array $row): array|false
    {
        // Expected headers: sale_id, branch, sale_date, product_name, category, quantity, unit_price, discount_pct, payment_method, salesperson
        
        $saleId = trim($row['sale_id'] ?? '');
        if (empty($saleId)) return false;

        $date = $this->cleanDate($row['sale_date'] ?? '');
        if (!$date) return false;

        $price = $this->cleanPrice($row['unit_price'] ?? '');
        if (is_null($price)) return false;

        $quantity = (int) ($row['quantity'] ?? 0);
        if ($quantity <= 0) return false;

        return [
            'sale_id'        => $saleId,
            'branch'         => $this->cleanBranch($row['branch'] ?? 'Unknown'),
            'sale_date'      => $date,
            'product_name'   => trim($row['product_name'] ?? 'Unknown'),
            'category'       => $this->cleanCategory($row['category'] ?? null),
            'quantity'       => $quantity,
            'unit_price'     => $price,
            'discount_pct'   => $this->cleanDiscount($row['discount_pct'] ?? '0'),
            'payment_method' => $this->cleanPaymentMethod($row['payment_method'] ?? 'Cash'),
            'salesperson'    => trim($row['salesperson'] ?? '') ?: 'Unknown',
            'created_at'     => now(),
            'updated_at'     => now(),
        ];
    }
}
