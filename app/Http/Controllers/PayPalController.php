<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\DeliveryService;
use App\Services\CartService;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Log;

class PayPalController extends Controller
{
    private function getPayPalConfig()
    {
        $config = config('paypal');
        $mode = \App\Models\Setting::get('paypal_mode', 'sandbox');
        $clientId = \App\Models\Setting::get('paypal_client_id', '');
        $clientSecret = \App\Models\Setting::get('paypal_client_secret', '');

        $config['mode'] = $mode;
        if (!empty($clientId) && !empty($clientSecret)) {
            $config[$mode]['client_id'] = $clientId;
            $config[$mode]['client_secret'] = $clientSecret;
            if ($mode === 'sandbox') {
                $config['sandbox']['app_id'] = 'APP-80W284485P519543T';
            }
        }

        return $config;
    }

    public function createOrder(Request $request)
    {
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$order) {
            return redirect()->route('checkout.index')->with('error', 'No se encontró la orden');
        }

        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials($this->getPayPalConfig());
            $token = $provider->getAccessToken();
            $provider->setAccessToken($token);

            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('paypal.capture', $order->id),
                    "cancel_url" => route('paypal.cancel'),
                    "brand_name" => config('app.name'),
                    "user_action" => "PAY_NOW",
                ],
                "purchase_units" => [
                    0 => [
                        "reference_id" => (string)$order->id,
                        "description" => "Pedido #" . $order->order_number,
                        "amount" => [
                            "currency_code" => session('currency', 'USD'),
                            "value" => number_format(currency_convert($order->total), 2, '.', '')
                        ]
                    ]
                ]
            ]);

            if (isset($response['id']) && $response['id'] != null) {
                // Find approve link
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        return redirect()->away($links['href']);
                    }
                }
                return redirect()->route('checkout.index')->with('error', 'Algo salió mal al crear el enlace de pago de PayPal.');
            } else {
                return redirect()->route('checkout.index')->with('error', $response['message'] ?? 'Algo salió mal.');
            }
            
        } catch (\Exception $e) {
            Log::error('PayPal create error: ' . $e->getMessage());
            return redirect()->route('checkout.index')->with('error', 'Excepción de PayPal: ' . $e->getMessage());
        }
    }

    public function captureOrder(Request $request, Order $order, CartService $cartService)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials($this->getPayPalConfig());
        $provider->getAccessToken();
        
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $order->update([
                'status' => 'paid',
                'payment_status' => 'completed',
                'payment_id' => $response['id'] ?? ('PAYPAL-' . strtoupper(uniqid())),
            ]);

            // Auto-deliver
            $deliveryService = app(DeliveryService::class);
            $deliveryService->processOrder($order);

            // Clear cart
            $cartService->clear();
            session()->forget('coupon_id');
            session()->forget('coupon_discount');
            session()->forget('coupon_code');

            return redirect()->route('customer.orders.show', $order->id)
                ->with('success', 'Pago procesado y licencia entregada correctamente');
        } else {
            return redirect()->route('checkout.index')->with('error', 'El pago no se pudo completar o fue rechazado.');
        }
    }

    public function cancel(Request $request)
    {
        return redirect()->route('checkout.index')
            ->with('error', 'El pago fue cancelado por el usuario.');
    }

    public function webhook(Request $request)
    {
        // For future implementation
        return response()->json(['status' => 'ok']);
    }
}
