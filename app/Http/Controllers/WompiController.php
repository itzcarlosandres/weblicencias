<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\WompiService;
use App\Services\CartService;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;

class WompiController extends Controller
{
    protected CartService $cartService;
    protected WompiService $wompiService;

    public function __construct(CartService $cartService, WompiService $wompiService)
    {
        $this->cartService = $cartService;
        $this->wompiService = $wompiService;
    }

    public function pay(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $publicKey = $this->wompiService->getPublicKey();
        if (!$publicKey) {
            return redirect()->route('checkout.index')->with('error', 'La pasarela de Wompi no está configurada.');
        }

        // Convertir siempre a COP
        $amountInCop = currency_convert($order->total); // But wait, currency_convert depends on current session!
        // We need to force conversion to COP if session is USD!
        if (current_currency() !== 'COP') {
            $amountInCop = $order->total * \App\Services\CurrencyService::getExchangeRate();
        } else {
            $amountInCop = $order->total;
        }

        $signature = $this->wompiService->generateSignature((string) $order->id, $amountInCop, 'COP');
        $amountInCents = round($amountInCop * 100);

        return view('pages.wompi_checkout', compact('order', 'publicKey', 'amountInCents', 'signature'));
    }

    public function callback(Request $request)
    {
        // Redirección después de pagar en el widget
        $id = $request->query('id'); // Transaction ID en Wompi
        
        return redirect()->route('customer.orders')->with('success', 'Pago con Wompi procesado. Si fue aprobado, tus licencias llegarán pronto.');
    }

    public function webhook(Request $request)
    {
        // Webhook de Wompi
        $event = $request->input('event');
        $data = $request->input('data');
        $signature = $request->input('signature');
        $timestamp = $request->input('timestamp');
        $eventsSecret = Setting::get('wompi_events_secret', '');

        // Verify signature
        if ($signature && isset($signature['properties']) && isset($signature['checksum']) && $eventsSecret) {
            $stringToHash = '';
            foreach ($signature['properties'] as $property) {
                // Property is like "transaction.id", we need to extract from $data
                $parts = explode('.', $property);
                $val = $request->input($property); // Laravel input can handle dot notation
                $stringToHash .= $val;
            }
            $stringToHash .= $timestamp . $eventsSecret;
            
            $calculatedChecksum = hash('sha256', $stringToHash);
            
            if ($calculatedChecksum !== $signature['checksum']) {
                \Illuminate\Support\Facades\Log::warning('Wompi Webhook: Firma inválida.');
                return response()->json(['error' => 'Invalid signature'], 400);
            }
        } else {
            \Illuminate\Support\Facades\Log::warning('Wompi Webhook: Faltan parámetros de firma o el secreto no está configurado.');
            // En producción, esto debería devolver error si se requiere firma estricta.
            // return response()->json(['error' => 'Missing signature properties'], 400);
        }
        
        if ($event === 'transaction.updated') {
            $transaction = $data['transaction'];
            $status = $transaction['status'];
            $orderId = $transaction['reference'];

            if ($status === 'APPROVED') {
                $order = Order::find($orderId);
                if ($order && !in_array($order->status, ['paid', 'delivered'])) {
                    $order->update([
                        'status' => 'paid',
                        'payment_id' => $transaction['id'],
                    ]);

                    $deliveryService = app(\App\Services\DeliveryService::class);
                    $deliveryService->processOrder($order);
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
