<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use App\Services\CartService;

class MercadoPagoController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function pay(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Obtener el Access Token
        $accessToken = env('MERCADOPAGO_ACCESS_TOKEN');
        if (!$accessToken) {
            return redirect()->route('checkout.index')->with('error', 'La pasarela de Mercado Pago no está configurada.');
        }

        $currency = session('currency', 'USD');

        // Construir los items para Mercado Pago
        $items = [];
        foreach ($order->items as $item) {
            $items[] = [
                'title' => $item->product_name,
                'quantity' => $item->quantity,
                'unit_price' => currency_convert((float) $item->price),
                'currency_id' => $currency
            ];
        }

        // Si hay descuento, lo restamos como un item con precio negativo (o ajustamos los items si es % pero MP no soporta negativo)
        // En Mercado Pago, si hay descuento total, debemos enviar un item negativo si la API lo permite, pero es más seguro ajustar el unit_price o enviar el total correcto.
        // Como la orden ya tiene un 'total', usaremos un solo item con el total para evitar problemas de centavos si el descuento no cuadra por item.
        if ($order->discount > 0 || $order->tax > 0) {
            $items = [
                [
                    'title' => 'Pedido #' . $order->order_number . ' en TodoKeys',
                    'quantity' => 1,
                    'unit_price' => currency_convert((float) $order->total),
                    'currency_id' => $currency
                ]
            ];
        }

        $preferenceData = [
            'items' => $items,
            'external_reference' => (string) $order->id,
            'back_urls' => [
                'success' => route('mercadopago.success'),
                'pending' => route('mercadopago.pending'),
                'failure' => route('mercadopago.failure'),
            ],
            'auto_return' => 'approved',
        ];

        // Crear la preferencia usando Http Facade de Laravel
        $response = Http::withToken($accessToken)
            ->post('https://api.mercadopago.com/checkout/preferences', $preferenceData);

        if ($response->successful()) {
            $initPoint = $response->json('init_point');
            return redirect($initPoint);
        }

        return redirect()->route('checkout.index')->with('error', 'Error al crear la preferencia de Mercado Pago. Inténtalo más tarde.');
    }

    public function success(Request $request)
    {
        $paymentId = $request->get('payment_id');
        $status = $request->get('status');
        $orderId = $request->get('external_reference');

        if ($status === 'approved' && $orderId) {
            $order = Order::find($orderId);
            if ($order && !in_array($order->status, ['paid', 'delivered'])) {
                $order->update([
                    'status' => 'paid',
                    'payment_id' => $paymentId,
                ]);

                // Auto-deliver
                $deliveryService = app(\App\Services\DeliveryService::class);
                $deliveryService->processOrder($order);

                $this->cartService->clear();

                return redirect()->route('customer.orders.show', $order->id)
                    ->with('success', 'Pago procesado y licencia entregada exitosamente por Mercado Pago.');
            }
        }

        return redirect()->route('home')->with('error', 'Hubo un problema validando el pago.');
    }

    public function pending(Request $request)
    {
        $orderId = $request->get('external_reference');
        if ($orderId) {
            return redirect()->route('customer.orders.show', $orderId)
                ->with('warning', 'Tu pago está pendiente de aprobación por Mercado Pago.');
        }
        return redirect()->route('home');
    }

    public function failure(Request $request)
    {
        return redirect()->route('checkout.index')
            ->with('error', 'El pago fue rechazado o cancelado. Intenta con otro método de pago.');
    }
}
