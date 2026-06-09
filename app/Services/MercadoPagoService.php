<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\Order;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class MercadoPagoService
{
    public function __construct()
    {
        $accessToken = Setting::get('payment_mercadopago_enabled') ? 'YOUR_MP_ACCESS_TOKEN' : ''; // In real app, this should be in Settings or .env
        // Wait, MercadoPago credentials usually go in .env, but the user requested them to be in settings?
        // Let's check if the SettingsController had mercadopago credentials.
        // It only had 'payment_mercadopago_enabled', no keys. So we use .env
        MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN', ''));
    }

    /**
     * Create Preference for MercadoPago
     */
    public function createPreference(Order $order, float $totalInCurrentCurrency): ?string
    {
        try {
            $client = new PreferenceClient();

            $currency = CurrencyService::getCurrency(); // e.g. 'COP' or 'USD'

            $items = [];
            
            // To simplify, we can send a single item with the total amount
            $items[] = [
                "title" => "Orden #" . $order->order_number,
                "quantity" => 1,
                "unit_price" => (float) round($totalInCurrentCurrency, 2),
                "currency_id" => $currency
            ];

            $preference = $client->create([
                "items" => $items,
                "back_urls" => [
                    "success" => route('checkout.success', $order->order_number),
                    "failure" => route('checkout.cancel', $order->order_number),
                    "pending" => route('checkout.cancel', $order->order_number)
                ],
                "auto_return" => "approved",
                "external_reference" => $order->order_number
            ]);

            return $preference->init_point; // URL to redirect
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('MercadoPago Error: ' . $e->getMessage());
            return null;
        }
    }
}
