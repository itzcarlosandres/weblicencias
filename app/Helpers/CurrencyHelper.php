<?php

use App\Services\CurrencyService;

if (!function_exists('currency_format')) {
    function currency_format($priceInUsd)
    {
        return CurrencyService::format($priceInUsd);
    }
}

if (!function_exists('currency_convert')) {
    function currency_convert($priceInUsd)
    {
        return CurrencyService::convert($priceInUsd);
    }
}

if (!function_exists('current_currency')) {
    function current_currency()
    {
        return CurrencyService::getCurrency();
    }
}
