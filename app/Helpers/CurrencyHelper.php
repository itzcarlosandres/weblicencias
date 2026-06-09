<?php

use App\Services\CurrencyService;

if (!function_exists('currency_format')) {
    function currency_format(float $priceInUSD): string
    {
        return app(CurrencyService::class)->formatPrice($priceInUSD);
    }
}

if (!function_exists('currency_convert')) {
    function currency_convert(float $priceInUSD): float
    {
        return app(CurrencyService::class)->convertAmount($priceInUSD);
    }
}
