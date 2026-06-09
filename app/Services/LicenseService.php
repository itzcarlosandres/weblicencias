<?php

namespace App\Services;

use App\Models\License;
use App\Models\Product;
use Illuminate\Support\Collection;

class LicenseService
{
    public function getAvailableLicense(Product $product): ?License
    {
        return License::where('product_id', $product->id)
            ->where('status', 'available')
            ->first();
    }

    public function getAvailableCount(Product $product): int
    {
        return License::where('product_id', $product->id)
            ->where('status', 'available')
            ->count();
    }

    public function importLicenses(Product $product, array $keys): int
    {
        $imported = 0;

        foreach ($keys as $key) {
            $key = trim($key);
            if (empty($key)) continue;

            // Check for duplicates
            $exists = License::where('product_id', $product->id)
                ->where('key', $key)
                ->exists();

            if (!$exists) {
                License::create([
                    'product_id' => $product->id,
                    'key' => $key,
                    'status' => 'available',
                ]);
                $imported++;
            }
        }

        // Update product stock
        $product->update([
            'stock' => $this->getAvailableCount($product),
        ]);

        return $imported;
    }

    public function importFromCsv(Product $product, string $csvContent): int
    {
        $lines = explode("\n", $csvContent);
        $keys = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if (!empty($line)) {
                // Handle CSV with or without headers
                $parts = str_getcsv($line);
                if (count($parts) > 0) {
                    $keys[] = $parts[0]; // First column is the key
                }
            }
        }

        return $this->importLicenses($product, $keys);
    }

    public function getLicensesStats(Product $product): array
    {
        $available = License::where('product_id', $product->id)
            ->where('status', 'available')
            ->count();

        $sold = License::where('product_id', $product->id)
            ->where('status', 'sold')
            ->count();

        $used = License::where('product_id', $product->id)
            ->where('status', 'used')
            ->count();

        return [
            'available' => $available,
            'sold' => $sold,
            'used' => $used,
            'total' => $available + $sold + $used,
        ];
    }
}
