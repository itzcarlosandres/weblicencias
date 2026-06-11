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
        if (in_array($currency, ['USD', 'COP'])) {
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
        
        if ($currency === 'COP') {
            return $priceInUsd * self::getExchangeRate();
        }

        return $priceInUsd;
    }

    /**
     * Format price to string based on currency
     */
    public static function format($priceInUsd)
    {
        $currency = self::getCurrency();
        $converted = self::convert($priceInUsd);

        if ($currency === 'COP') {
            return '$' . number_format($converted, 0, ',', '.');
        }

        return '$' . number_format($converted, 2, '.', ',');
    }

    /**
     * Gets live USD→COP exchange rate.
     * Cached for 6 hours. Tries multiple free APIs; falls back to DB value or 4200.
     */
    public static function getExchangeRate(): float
    {
        return Cache::remember('usd_to_cop_rate', 21600, function () {
            // API 1: open.er-api.com — free tier, no key required, soporta COP
            try {
                $response = Http::withoutVerifying()->timeout(5)->get('https://open.er-api.com/v6/latest/USD');
                if ($response->successful()) {
                    $rate = (float) ($response->json('rates.COP') ?? 0);
                    if ($rate > 0) {
                        self::persistRate($rate);
                        Log::info("CurrencyService: Tasa USD/COP actualizada via open.er-api.com → {$rate}");
                        return $rate;
                    }
                }
            } catch (\Exception $e) {
                Log::warning('CurrencyService: open.er-api.com falló: ' . $e->getMessage());
            }

            // API 2: fawazahmed0 — completamente gratis, sin key
            try {
                $response = Http::withoutVerifying()->timeout(5)
                    ->get('https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/usd.min.json');
                if ($response->successful()) {
                    $rate = (float) ($response->json('usd.cop') ?? 0);
                    if ($rate > 0) {
                        self::persistRate($rate);
                        Log::info("CurrencyService: Tasa USD/COP actualizada via fawazahmed0 → {$rate}");
                        return $rate;
                    }
                }
            } catch (\Exception $e) {
                Log::warning('CurrencyService: fawazahmed0 API falló: ' . $e->getMessage());
            }

            // API 3: file_get_contents fallback (ignores SSL by default)
            try {
                $raw = @file_get_contents('https://open.er-api.com/v6/latest/USD');
                if ($raw) {
                    $data = json_decode($raw, true);
                    $rate = (float) ($data['rates']['COP'] ?? 0);
                    if ($rate > 0) {
                        self::persistRate($rate);
                        Log::info("CurrencyService: Tasa USD/COP actualizada via file_get_contents → {$rate}");
                        return $rate;
                    }
                }
            } catch (\Exception $e) {
                Log::warning('CurrencyService: file_get_contents falló: ' . $e->getMessage());
            }

            // Fallback: DB stored value or hardcoded default
            $dbRate = (float) \App\Models\Setting::get('exchange_rate_cop', 4200);
            Log::warning("CurrencyService: Todas las APIs fallaron. Usando valor DB: {$dbRate}");
            return $dbRate;
        });
    }

    /**
     * Persists rate to the DB (so admin panel stays in sync).
     */
    private static function persistRate(float $rate): void
    {
        try {
            \App\Models\Setting::set('exchange_rate_cop', round($rate), 'general');
        } catch (\Exception $e) {
            Log::error('CurrencyService: Failed to persist rate: ' . $e->getMessage());
        }
    }

    /**
     * Force-refreshes the cached rate (useful from Artisan command / cron).
     */
    public static function refreshRate(): float
    {
        Cache::forget('usd_to_cop_rate');
        return self::getExchangeRate();
    }
}
