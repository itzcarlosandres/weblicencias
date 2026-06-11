<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\License;
use App\Models\AbandonedCart;
use App\Mail\WelcomeEmail;
use App\Mail\OrderDelivered;
use App\Mail\LicenseManuallyAssignedMail;
use App\Mail\MarketingEmail;
use App\Mail\AbandonedCartMail;
use App\Mail\ProductInStockMail;
use App\Mail\ReferralRewardMail;
use App\Mail\WishlistPriceDropMail;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$targetEmail = isset($argv[1]) ? $argv[1] : null;

if (!$targetEmail) {
    echo "=========================================================\n";
    echo "ERROR: Debes proporcionar un correo destinatario.\n";
    echo "Uso: php test_emails.php tu-correo@ejemplo.com\n";
    echo "=========================================================\n";
    exit(1);
}

echo "=========================================================\n";
echo "Iniciando script de prueba para los correos SMTP\n";
echo "Destinatario: $targetEmail\n";
echo "=========================================================\n\n";

// 1. Obtener o crear un usuario de prueba
echo "[-] Preparando datos de prueba...\n";
$user = User::where('email', $targetEmail)->first();
if (!$user) {
    $user = User::first();
    if ($user) {
        // Clonamos o usamos este usuario pero le cambiamos temporalmente el email
        $user->email = $targetEmail;
    } else {
        $user = User::create([
            'name' => 'Usuario de Prueba',
            'email' => $targetEmail,
            'password' => bcrypt('password123'),
        ]);
    }
}
echo "    > Usuario: {$user->name} ({$user->email})\n";

// 2. Obtener o crear un producto de prueba
$product = Product::first();
if (!$product) {
    $product = Product::create([
        'name' => 'Windows 11 Professional Key',
        'price' => 19.99,
        'compare_price' => 24.99,
        'discount' => 20.00,
        'sku' => 'WIN11PRO-TEST',
        'is_active' => true,
    ]);
}
echo "    > Producto: {$product->name}\n";

// 3. Obtener o crear una licencia de prueba
$license = License::where('product_id', $product->id)->first();
if (!$license) {
    $license = License::create([
        'product_id' => $product->id,
        'key' => 'AAAAA-BBBBB-CCCCC-DDDDD-EEEEE',
        'status' => 'available',
    ]);
}
echo "    > Licencia Key: {$license->key}\n";

// 4. Obtener o crear una orden de prueba
$order = Order::where('user_id', $user->id)->first() ?? Order::first();
if (!$order) {
    $order = Order::create([
        'user_id' => $user->id,
        'order_number' => 'ORD-' . strtoupper(substr(uniqid(), -6)),
        'total' => 19.99,
        'status' => 'completed',
    ]);
}
// Aseguramos que la relación tenga items para OrderDelivered
if ($order->items()->count() === 0) {
    $order->items()->create([
        'product_id' => $product->id,
        'quantity' => 1,
        'price' => 19.99,
    ]);
}
echo "    > Orden: {$order->order_number}\n";

// 5. Preparar un carrito abandonado de prueba
$abandonedCart = new AbandonedCart();
$abandonedCart->user_id = $user->id;
$abandonedCart->cart_data = [
    [
        'name' => $product->name,
        'quantity' => 1,
        'price' => $product->price
    ]
];
$abandonedCart->setRelation('user', $user);

echo "\n[-] Enviando correos...\n";

try {
    // Correo 1: Bienvenido (WelcomeEmail)
    echo "    1. Enviando WelcomeEmail... ";
    Mail::to($targetEmail)->send(new WelcomeEmail($user));
    echo "¡ENVIADO!\n";
} catch (\Exception $e) {
    echo "FALLÓ: " . $e->getMessage() . "\n";
}

try {
    // Correo 2: Orden Entregada (OrderDelivered)
    echo "    2. Enviando OrderDelivered... ";
    Mail::to($targetEmail)->send(new OrderDelivered($order));
    echo "¡ENVIADO!\n";
} catch (\Exception $e) {
    echo "FALLÓ: " . $e->getMessage() . "\n";
}

try {
    // Correo 3: Licencia Asignada Manualmente (LicenseManuallyAssignedMail)
    echo "    3. Enviando LicenseManuallyAssignedMail... ";
    Mail::to($targetEmail)->send(new LicenseManuallyAssignedMail($license));
    echo "¡ENVIADO!\n";
} catch (\Exception $e) {
    echo "FALLÓ: " . $e->getMessage() . "\n";
}

try {
    // Correo 4: Marketing (MarketingEmail)
    echo "    4. Enviando MarketingEmail... ";
    Mail::to($targetEmail)->send(new MarketingEmail(
        '¡Oferta Especial de Fin de Semana!',
        'Ahorra un 15% adicional',
        'Usa el cupón FINDE15 en tu próxima compra y obtén un descuento instantáneo en cualquier licencia de nuestro catálogo.',
        'Ir a la Tienda',
        url('/')
    ));
    echo "¡ENVIADO!\n";
} catch (\Exception $e) {
    echo "FALLÓ: " . $e->getMessage() . "\n";
}

try {
    // Correo 5: Carrito Abandonado (AbandonedCartMail)
    echo "    5. Enviando AbandonedCartMail... ";
    Mail::to($targetEmail)->send(new AbandonedCartMail($abandonedCart));
    echo "¡ENVIADO!\n";
} catch (\Exception $e) {
    echo "FALLÓ: " . $e->getMessage() . "\n";
}

try {
    // Correo 6: Producto de Nuevo en Stock (ProductInStockMail)
    echo "    6. Enviando ProductInStockMail... ";
    Mail::to($targetEmail)->send(new ProductInStockMail($product));
    echo "¡ENVIADO!\n";
} catch (\Exception $e) {
    echo "FALLÓ: " . $e->getMessage() . "\n";
}

try {
    // Correo 7: Recompensa por Referido (ReferralRewardMail)
    echo "    7. Enviando ReferralRewardMail... ";
    $referredDummy = new User(['name' => 'Amigo Referido']);
    Mail::to($targetEmail)->send(new ReferralRewardMail($user, $referredDummy, 1000));
    echo "¡ENVIADO!\n";
} catch (\Exception $e) {
    echo "FALLÓ: " . $e->getMessage() . "\n";
}

try {
    // Correo 8: Baja de Precio en Lista de Deseos (WishlistPriceDropMail)
    echo "    8. Enviando WishlistPriceDropMail... ";
    Mail::to($targetEmail)->send(new WishlistPriceDropMail($product, 24.99, 19.99));
    echo "¡ENVIADO!\n";
} catch (\Exception $e) {
    echo "FALLÓ: " . $e->getMessage() . "\n";
}

echo "\n=========================================================\n";
echo "Prueba de envío finalizada. Revisa la bandeja de entrada\n";
echo "(y carpeta de spam) de: $targetEmail\n";
echo "=========================================================\n";
