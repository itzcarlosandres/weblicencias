<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\Setting;

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
                    // Locally, default to USD.
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
                // Fallback to USD on error
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
        return Session::get('currency', 'USD'); // Default USD
    }

    /**
     * Convert USD price to current session currency.
     */
    public static function convert($priceInUsd)
    {
        $currency = self::getCurrency();
        
        if ($currency === 'COP') {
            $rate = (float) Setting::get('exchange_rate_cop', 4000);
            return $priceInUsd * $rate;
        }

        return $priceInUsd; // Default is USD
    }

    /**
     * Format price to string based on currency
     */
    public static function format($priceInUsd)
    {
        $currency = self::getCurrency();
        $converted = self::convert($priceInUsd);

        if ($currency === 'COP') {
            // COP usually doesn't show decimals
            return '$' . number_format($converted, 0, ',', '.');
        }

        return '$' . number_format($converted, 2, '.', ',');
    }

    /**
     * Gets exchange rate
     */
    public static function getExchangeRate()
    {
        return (float) Setting::get('exchange_rate_cop', 4000);
    }
}
