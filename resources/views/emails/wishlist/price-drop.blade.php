<x-mail::message>
# ¡Excelente noticia! 🎉

El producto **{{ $productName }}** que tienes en tu Lista de Deseos acaba de bajar de precio.

Precio anterior: ~~{{ currency_format($oldPrice) }}~~<br>
**Nuevo Precio: {{ currency_format($newPrice) }}**

Aprovecha esta oferta antes de que se agote o el precio vuelva a subir.

<x-mail::button :url="$url">
Ver Producto
</x-mail::button>

Gracias,<br>
El equipo de {{ config('app.name') }}
</x-mail::message>
