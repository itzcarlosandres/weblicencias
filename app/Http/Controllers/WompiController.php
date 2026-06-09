<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\Setting;
use App\Services\CartService;
use App\Services\CurrencyService;

class WompiController extends Controller
{
    protected CartService $cartService;
    protected CurrencyService $currencyService;

    public function __construct(CartService $cartService, CurrencyService $currencyService)
    {
        $this->cartService = $cartService;
        $this->currencyService = $currencyService;
    }

    public function pay(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $wompiEnabled = Setting::get('payment_wompi_enabled', '0') == '1';
        if (!$wompiEnabled) {
            return redirect()->route('checkout.index')->with('error', 'La pasarela de Wompi no está activa.');
        }

        $publicKey = Setting::get('wompi_public_key');
        if (empty($publicKey)) {
            return redirect()->route('checkout.index')->with('error', 'La pasarela de Wompi no está configurada (Falta Llave Pública).');
        }

        // Wompi requires amount in cents and in COP
        $amountInCop = $this->currencyService->convertAmount($order->total, 'COP');
        $amountInCents = (int) ($amountInCop * 100);

        // Reference
        $reference = $order->id . '_' . time();

        // Guardamos la referencia que enviamos a Wompi en el payment_id temporalmente, 
        // o si prefieres, el external_reference. Para Wompi, el ID interno lo obtenemos en el callback.
        $order->update(['payment_id' => $reference]);

        // Secret Integridad (Optional, we won't strictly enforce it unless configured, but let's see if we have it)
        $integritySignature = null;
        $privateKey = Setting::get('wompi_private_key'); // Sometimes used to generate signature if we know the secret
        // Currently Wompi Widget allows working without signature if we just don't pass it, assuming basic configuration.
        // It's recommended to just use the widget without it if we haven't configured the integrity secret explicitly.

        $environment = Setting::get('wompi_sandbox_mode', '0') == '1' ? 'test' : 'prod';

        return view('pages.wompi_pay', compact('order', 'publicKey', 'amountInCents', 'reference', 'environment'));
    }

    public function callback(Request $request)
    {
        // Wompi redirects here with ?id=123-123-123 (Transaction ID)
        $transactionId = $request->query('id');

        if (!$transactionId) {
            return redirect()->route('checkout.index')->with('error', 'No se recibió el ID de transacción de Wompi.');
        }

        // We need to verify the transaction status
        $environment = Setting::get('wompi_sandbox_mode', '0') == '1' ? 'sandbox' : 'production';
        $baseUrl = $environment === 'sandbox' ? 'https://sandbox.wompi.co/v1' : 'https://production.wompi.co/v1';

        $response = Http::get("{$baseUrl}/transactions/{$transactionId}");

        if ($response->successful()) {
            $data = $response->json('data');
            $status = $data['status'] ?? 'UNKNOWN';
            $reference = $data['reference'] ?? '';

            // Extract order ID from reference (e.g. "5_1734912000")
            $orderId = explode('_', $reference)[0];
            $order = Order::find($orderId);

            if ($order && !in_array($order->status, ['paid', 'delivered'])) {
                if ($status === 'APPROVED') {
                    $order->update([
                        'status' => 'paid',
                        'payment_id' => $transactionId,
                    ]);

                    // Auto-deliver
                    $deliveryService = app(\App\Services\DeliveryService::class);
                    $deliveryService->processOrder($order);

                    $this->cartService->clear();

                    return redirect()->route('customer.orders.show', $order->id)->with('success', '¡Pago procesado exitosamente con Wompi!');
                } elseif ($status === 'DECLINED') {
                    return redirect()->route('checkout.index')->with('error', 'El pago fue declinado por Wompi.');
                } elseif ($status === 'ERROR') {
                    return redirect()->route('checkout.index')->with('error', 'Ocurrió un error al procesar el pago.');
                } else {
                    // PENDING or others
                    return redirect()->route('checkout.index')->with('warning', 'Tu pago está en estado: ' . $status . '. Procesaremos tu orden una vez sea aprobado.');
                }
            } elseif ($order && in_array($order->status, ['paid', 'delivered'])) {
                 // Already processed
                 return redirect()->route('customer.orders.show', $order->id)->with('success', 'Tu orden ya se encuentra pagada.');
            }
        }

        return redirect()->route('checkout.index')->with('error', 'No se pudo verificar el estado del pago con Wompi.');
    }

    public function webhook(Request $request)
    {
        Log::info('Wompi Webhook received', $request->all());

        $data = $request->input('data.transaction');
        if (!$data) {
            return response()->json(['status' => 'ignored'], 200);
        }

        // Validate Signature
        $eventsSecret = Setting::get('wompi_events_secret');
        if (!empty($eventsSecret)) {
            $signature = $request->input('signature');
            $timestamp = $request->input('timestamp');
            
            if ($signature && isset($signature['properties']) && isset($signature['checksum'])) {
                $concat = '';
                foreach ($signature['properties'] as $property) {
                    $concat .= $request->input("data.{$property}");
                }
                $concat .= $timestamp . $eventsSecret;
                
                $expectedChecksum = hash('sha256', $concat);
                if ($expectedChecksum !== $signature['checksum']) {
                    Log::warning('Wompi Webhook signature mismatch', ['expected' => $expectedChecksum, 'received' => $signature['checksum']]);
                    return response()->json(['error' => 'Invalid signature'], 400);
                }
            } else {
                Log::warning('Wompi Webhook missing signature but secret is configured');
                return response()->json(['error' => 'Missing signature'], 400);
            }
        }

        $transactionId = $data['id'];
        $status = $data['status'];
        $reference = $data['reference'];

        $orderId = explode('_', $reference)[0];
        $order = Order::find($orderId);

        if ($order && !in_array($order->status, ['paid', 'delivered'])) {
            if ($status === 'APPROVED') {
                $order->update([
                    'status' => 'paid',
                    'payment_id' => $transactionId,
                ]);

                // Auto-deliver
                $deliveryService = app(\App\Services\DeliveryService::class);
                $deliveryService->processOrder($order);
            } elseif ($status === 'DECLINED' || $status === 'ERROR') {
                $order->update(['status' => 'cancelled']);
            }
        }

        return response()->json(['status' => 'ok'], 200);
    }
}
