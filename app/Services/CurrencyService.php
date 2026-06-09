<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CurrencyService
{
    /**
     * Get the conversion rate from USD to COP.
     * Tries the manual setting first, then cached API rate, then falls back.
     */
    public function getRateUSDToCOP(): float
    {
        // 1. Check if there's a manual rate defined in settings
        $manualRate = Setting::get('exchange_rate_cop');
        if ($manualRate && is_numeric($manualRate) && $manualRate > 0) {
            return (float) $manualRate;
        }

        // 2. Fetch from cache or API
        return Cache::remember('exchange_rate_usd_cop', 3600 * 24, function () {
            try {
                // Using a free API. For production, consider currencylayer or fixer.io
                $response = Http::timeout(5)->get('https://api.exchangerate-api.com/v4/latest/USD');
                if ($response->successful()) {
                    $rates = $response->json('rates');
                    if (isset($rates['COP'])) {
                        return (float) $rates['COP'];
                    }
                }
            } catch (\Exception $e) {
                Log::error('Error fetching exchange rate: ' . $e->getMessage());
            }

            // Fallback rate if API fails and no manual setting exists
            return 4000.00; 
        });
    }

    /**
     * Detect user's country code based on their IP address.
     */
    public function detectUserCountry(string $ip): string
    {
        // For local development, simulate a country or return default
        if ($ip === '127.0.0.1' || $ip === '::1') {
            return 'US'; // Default to US. Change to 'CO' to test Colombia locally
        }

        return Cache::remember("user_country_{$ip}", 3600 * 24, function () use ($ip) {
            try {
                $response = Http::timeout(3)->get("http://ip-api.com/json/{$ip}?fields=countryCode");
                if ($response->successful()) {
                    return $response->json('countryCode', 'US');
                }
            } catch (\Exception $e) {
                Log::error('Error detecting IP country: ' . $e->getMessage());
            }
            return 'US';
        });
    }

    public function getRateUSDToEUR(): float
    {
        // 1. Check if there's a manual rate defined in settings
        $manualRate = Setting::get('exchange_rate_eur');
        if ($manualRate && is_numeric($manualRate) && $manualRate > 0) {
            return (float) $manualRate;
        }

        // 2. Fetch from cache or API
        return Cache::remember('exchange_rate_usd_eur', 3600 * 24, function () {
            try {
                $response = Http::timeout(5)->get('https://api.exchangerate-api.com/v4/latest/USD');
                if ($response->successful()) {
                    $rates = $response->json('rates');
                    if (isset($rates['EUR'])) {
                        return (float) $rates['EUR'];
                    }
                }
            } catch (\Exception $e) {
                Log::error('Error fetching exchange rate: ' . $e->getMessage());
            }

            // Fallback rate if API fails and no manual setting exists
            return 0.92; 
        });
    }

    /**
     * Format a price based on the user's selected/detected currency.
     */
    public function formatPrice(float $priceInUSD, ?string $currency = null): string
    {
        $currency = $currency ?? session('currency', 'USD');

        if ($currency === 'COP') {
            $rate = $this->getRateUSDToCOP();
            $converted = $priceInUSD * $rate;
            // Round to nearest hundred for cleaner COP prices (e.g. 40,500 instead of 40,523)
            $rounded = round($converted / 100) * 100;
            return '$' . number_format($rounded, 0, ',', '.') . ' COP';
        }

        if ($currency === 'EUR') {
            $rate = $this->getRateUSDToEUR();
            $converted = $priceInUSD * $rate;
            return '€' . number_format($converted, 2, ',', '.') . ' EUR';
        }

        // Default USD
        return '$' . number_format($priceInUSD, 2, '.', ',') . ' USD';
    }

    /**
     * Get the raw converted amount
     */
    public function convertAmount(float $priceInUSD, ?string $currency = null): float
    {
        $currency = $currency ?? session('currency', 'USD');

        if ($currency === 'COP') {
            $rate = $this->getRateUSDToCOP();
            $converted = $priceInUSD * $rate;
            return round($converted / 100) * 100; // Return rounded to hundreds
        }

        if ($currency === 'EUR') {
            $rate = $this->getRateUSDToEUR();
            return round($priceInUSD * $rate, 2);
        }

        return $priceInUSD;
    }
}
