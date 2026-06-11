<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CurrencyService
{
    /**
     * Initializes currency based on user IP.
     */
    public static function initCurrency()
    {
        if (!Session::has('currency')) {
            try {
                // Determine via IP.
                $ip = request()->ip();
                if ($ip == '127.0.0.1' || $ip == '::1') {
                    $country = 'US';
                } else {
                    $response = Http::timeout(3)->get("https://ipapi.co/{$ip}/country/");
                    $country = $response->successful() ? $response->body() : 'US';
                }

                if ($country === 'CO') {
                    Session::put('currency', 'COP');
                } else {
                    Session::put('currency', 'USD');
                }
            } catch (\Exception $e) {
                Session::put('currency', 'USD');
            }
        }
    }

    /**
     * Set explicit currency
     */
    public static function setCurrency($currency)
    {
        if (in_array($currency, ['USD', 'COP', 'MXN', 'EUR'])) {
            Session::put('currency', $currency);
        }
    }

    /**
     * Get current currency
     */
    public static function getCurrency()
    {
        return Session::get('currency', 'USD');
    }

    /**
     * Convert USD price to current session currency.
     */
    public static function convert($priceInUsd)
    {
        $currency = self::getCurrency();
        return $priceInUsd * self::getExchangeRateFor($currency);
    }

    /**
     * Format price to string based on currency
     */
    public static function format($priceInUsd)
    {
        $currency = self::getCurrency();
        $converted = self::convert($priceInUsd);

        if ($currency === 'COP') {
            return new \Illuminate\Support\HtmlString('<span class="text-[10px] sm:text-xs font-bold text-gray-400 dark:text-gray-500 mr-1 select-none">COP</span>' . number_format($converted, 0, ',', '.'));
        }

        if ($currency === 'MXN') {
            return new \Illuminate\Support\HtmlString('<span class="text-[10px] sm:text-xs font-bold text-gray-400 dark:text-gray-500 mr-1 select-none">MXN</span>' . number_format($converted, 2, '.', ','));
        }

        if ($currency === 'EUR') {
            return new \Illuminate\Support\HtmlString('<span class="text-sm font-bold text-gray-400 dark:text-gray-500 mr-1 select-none">€</span>' . number_format($converted, 2, ',', '.'));
        }

        return '$' . number_format($converted, 2, '.', ',');
    }

    /**
     * Backward compatibility wrapper
     */
    public static function getExchangeRate(): float
    {
        return self::getExchangeRateFor('COP');
    }

    /**
     * Gets live USD→ANY exchange rate.
     * Cached for 6 hours. Tries multiple free APIs; falls back to DB value or default.
     */
    public static function getExchangeRateFor(string $currency): float
    {
        $currency = strtoupper($currency);
        if ($currency === 'USD') {
            return 1.0;
        }

        $cacheKey = strtolower($currency) . '_exchange_rate';
        return Cache::remember($cacheKey, 21600, function () use ($currency) {
            // API 1: open.er-api.com — free tier, no key required
            try {
                $response = Http::withoutVerifying()->timeout(5)->get('https://open.er-api.com/v6/latest/USD');
                if ($response->successful()) {
                    $rate = (float) ($response->json("rates.{$currency}") ?? 0);
                    if ($rate > 0) {
                        self::persistRate($currency, $rate);
                        Log::info("CurrencyService: Tasa USD/{$currency} actualizada via open.er-api.com → {$rate}");
                        return $rate;
                    }
                }
            } catch (\Exception $e) {
                Log::warning("CurrencyService: open.er-api.com falló para {$currency}: " . $e->getMessage());
            }

            // API 2: fawazahmed0 — completamente gratis, sin key
            try {
                $response = Http::withoutVerifying()->timeout(5)
                    ->get('https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/usd.min.json');
                if ($response->successful()) {
                    $rate = (float) ($response->json("usd." . strtolower($currency)) ?? 0);
                    if ($rate > 0) {
                        self::persistRate($currency, $rate);
                        Log::info("CurrencyService: Tasa USD/{$currency} actualizada via fawazahmed0 → {$rate}");
                        return $rate;
                    }
                }
            } catch (\Exception $e) {
                Log::warning("CurrencyService: fawazahmed0 API falló para {$currency}: " . $e->getMessage());
            }

            // Fallback: DB stored value or hardcoded default
            $defaultRates = [
                'COP' => 4200.0,
                'MXN' => 17.5,
                'EUR' => 0.92
            ];
            $dbRate = (float) \App\Models\Setting::get('exchange_rate_' . strtolower($currency), $defaultRates[$currency] ?? 1.0);
            Log::warning("CurrencyService: Todas las APIs fallaron para {$currency}. Usando valor DB: {$dbRate}");
            return $dbRate;
        });
    }

    /**
     * Persists rate to the DB (so admin panel stays in sync).
     */
    private static function persistRate(string $currency, float $rate): void
    {
        try {
            \App\Models\Setting::set('exchange_rate_' . strtolower($currency), round($rate, 4), 'general');
        } catch (\Exception $e) {
            Log::error("CurrencyService: Failed to persist rate for {$currency}: " . $e->getMessage());
        }
    }

    /**
     * Force-refreshes the cached rates.
     */
    public static function refreshRate(): float
    {
        Cache::forget('usd_to_cop_rate');
        Cache::forget('cop_exchange_rate');
        Cache::forget('mxn_exchange_rate');
        Cache::forget('eur_exchange_rate');
        return self::getExchangeRate();
    }
}
