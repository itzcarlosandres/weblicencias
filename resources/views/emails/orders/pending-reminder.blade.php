<x-mail::message>
# Hola {{ $order->user->name }},

Notamos que tienes un pedido pendiente por pagar en **{{ config('app.name') }}**. 

**Detalles de tu pedido:**
- **Número de Orden:** #{{ $order->order_number }}
- **Fecha:** {{ $order->created_at->format('d/m/Y') }}
- **Total:** {{ currency_format($order->total) }}

No te quedes sin tus productos. Si tuviste algún problema al realizar el pago, no dudes en contactarnos y te ayudaremos con gusto.

<x-mail::button :url="route('customer.orders.show', $order)">
Ver mi pedido
</x-mail::button>

Gracias,<br>
El equipo de {{ config('app.name') }}
</x-mail::message>
