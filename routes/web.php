<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WaitlistController;

// Public routes
Route::get('/sitemap.xml', [\App\Http\Controllers\SeoController::class, 'sitemap'])->name('sitemap');
Route::get('/robots.txt', [\App\Http\Controllers\SeoController::class, 'robots'])->name('robots');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/demos', [HomeController::class, 'demos'])->name('demos');
Route::get('/currency/{currency}', [HomeController::class, 'changeCurrency'])->name('currency.change');
Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
Route::get('/ofertas-flash', [ProductController::class, 'flashSales'])->name('products.flash-sales');
Route::get('/search/live', [ProductController::class, 'liveSearch'])->name('products.live-search');
Route::get('/producto/{slug}', [ProductController::class, 'show'])->name('products.show');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Newsletter
Route::post('/newsletter/subscribe', [\App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Cart
Route::get('/carrito', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrito/agregar', [CartController::class, 'add'])->name('cart.add');
Route::post('/carrito/agregar-paquete', [CartController::class, 'addBundle'])->name('cart.addBundle');
Route::post('/carrito/actualizar', [CartController::class, 'update'])->name('cart.update');
Route::post('/carrito/eliminar', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/carrito/cupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');
Route::delete('/carrito/cupon', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');

// Checkout & Payments (Requires Auth)
Route::middleware('auth')->group(function () {
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/procesar', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/checkout/aplicar-puntos', [CheckoutController::class, 'applyPoints'])->name('checkout.apply-points');

    // PayPal
    Route::get('/paypal/crear-orden', [PayPalController::class, 'createOrder'])->name('checkout.paypal');
    Route::get('/paypal/capturar/{order}', [PayPalController::class, 'captureOrder'])->name('paypal.capture');
    Route::get('/paypal/cancelar', [PayPalController::class, 'cancel'])->name('paypal.cancel');

    // Mercado Pago
    Route::get('/mercadopago/pagar/{order}', [MercadoPagoController::class, 'pay'])->name('checkout.mercadopago');
    Route::get('/mercadopago/success', [MercadoPagoController::class, 'success'])->name('mercadopago.success');
    Route::get('/mercadopago/pending', [MercadoPagoController::class, 'pending'])->name('mercadopago.pending');
    Route::get('/mercadopago/failure', [MercadoPagoController::class, 'failure'])->name('mercadopago.failure');

    // Wompi
    Route::get('/wompi/pagar/{order}', [\App\Http\Controllers\WompiController::class, 'pay'])->name('checkout.wompi');
    Route::get('/wompi/callback', [\App\Http\Controllers\WompiController::class, 'callback'])->name('wompi.callback');
});

// Wompi Webhook (outside auth middleware)
Route::post('/webhook/wompi', [\App\Http\Controllers\WompiController::class, 'webhook'])->name('wompi.webhook');
// Socialite Routes
Route::get('/auth/google', [\App\Http\Controllers\SocialAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [\App\Http\Controllers\SocialAuthController::class, 'callback']);

// Blog
Route::get('/blog', [\App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');
// Auth routes
require __DIR__ . '/auth.php';

// Waitlist
Route::post('/waitlist', [WaitlistController::class, 'store'])->name('waitlist.store');

// Customer routes
Route::prefix('mi-cuenta')->name('customer.')->middleware('auth')->group(function () {
    Route::post('/productos/{product}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/', [CustomerController::class, 'dashboard'])->name('dashboard');
    Route::get('/perfil', [CustomerController::class, 'profile'])->name('profile');
    Route::post('/perfil', [CustomerController::class, 'profileUpdate'])->name('profile.update');
    Route::get('/pedidos', [CustomerController::class, 'orders'])->name('orders');
    Route::get('/pedidos/{order}', [CustomerController::class, 'ordersShow'])->name('orders.show');
    Route::get('/licencias', [CustomerController::class, 'licenses'])->name('licenses');
    Route::post('/licencias/{license}/reveal', [CustomerController::class, 'revealLicense'])->name('licenses.reveal');
    Route::get('/tickets', [CustomerController::class, 'tickets'])->name('tickets');
    Route::post('/tickets', [CustomerController::class, 'ticketsStore'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [CustomerController::class, 'ticketsShow'])->name('tickets.show');
    Route::post('/tickets/{ticket}/responder', [CustomerController::class, 'ticketsReply'])->name('tickets.reply');
    Route::get('/mis-puntos', [CustomerController::class, 'points'])->name('points');
    Route::get('/favoritos', [CustomerController::class, 'wishlist'])->name('wishlist');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', \App\Http\Controllers\Admin\AdminProductController::class)->except(['show']);
    Route::post('/products/{product}/import-licenses', [\App\Http\Controllers\Admin\AdminProductController::class, 'importLicenses'])->name('products.import-licenses');
    Route::post('/products/{product}/toggle-featured', [\App\Http\Controllers\Admin\AdminProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
    Route::post('/products/{product}/toggle-bundle', [\App\Http\Controllers\Admin\AdminProductController::class, 'toggleBundle'])->name('products.toggle-bundle');
    Route::post('/products/{product}/toggle-bestseller', [\App\Http\Controllers\Admin\AdminProductController::class, 'toggleBestSeller'])->name('products.toggle-bestseller');
    Route::post('/products/{product}/toggle-topdeal', [\App\Http\Controllers\Admin\AdminProductController::class, 'toggleTopDeal'])->name('products.toggle-topdeal');
    Route::resource('orders', \App\Http\Controllers\Admin\AdminOrderController::class)->only(['index', 'show', 'destroy']);
    Route::post('/orders/{order}/status', [\App\Http\Controllers\Admin\AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::delete('/orders/{order}/items/{item}', [\App\Http\Controllers\Admin\AdminOrderController::class, 'removeItem'])->name('orders.remove-item');

    // Reviews
    Route::resource('reviews', \App\Http\Controllers\Admin\AdminReviewController::class)->only(['index', 'destroy']);
    Route::post('/reviews/{review}/toggle', [\App\Http\Controllers\Admin\AdminReviewController::class, 'toggle'])->name('reviews.toggle');

    // Coupons
    Route::resource('coupons', \App\Http\Controllers\Admin\AdminCouponController::class)->except(['show']);

    // Referrals
    Route::get('/referrals', [\App\Http\Controllers\Admin\AdminReferralController::class, 'index'])->name('referrals.index');

    // Mail Preview
    Route::get('/preview-assigned-email', function () {
        $license = \App\Models\License::with('product')->first();
        if (!$license) {
            return "No hay licencias en la base de datos para mostrar la prueba.";
        }
        return new \App\Mail\LicenseManuallyAssignedMail($license);
    });

    Route::get('/preview-welcome', function () {
        $user = \App\Models\User::first() ?? \App\Models\User::factory()->make(['name' => 'Demo Usuario', 'email' => 'demo@todokeys.com']);
        return new \App\Mail\WelcomeEmail($user);
    });

    Route::get('/preview-reset', function () {
        $user = \App\Models\User::first() ?? \App\Models\User::factory()->make(['name' => 'Demo Usuario', 'email' => 'demo@todokeys.com']);
        return (new \App\Notifications\CustomResetPasswordNotification('fake-token-123'))->toMail($user)->render();
    });

    // Users
    Route::resource('users', \App\Http\Controllers\Admin\AdminUserController::class)->only(['index', 'show']);
    Route::post('/users/{user}/points', [\App\Http\Controllers\Admin\AdminUserController::class, 'addPoints'])->name('users.points');

    // Categories
    Route::resource('categories', \App\Http\Controllers\Admin\AdminCategoryController::class)->except(['show']);

    // Brands
    Route::resource('brands', \App\Http\Controllers\Admin\AdminBrandController::class)->except(['show']);

    // Badges
    Route::resource('badges', \App\Http\Controllers\Admin\AdminBadgeController::class)->except(['show']);

    // Coupons
    Route::resource('coupons', \App\Http\Controllers\Admin\AdminCouponController::class)->except(['show']);

    // Tickets
    Route::get('/tickets', [\App\Http\Controllers\Admin\AdminTicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [\App\Http\Controllers\Admin\AdminTicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/status', [\App\Http\Controllers\Admin\AdminTicketController::class, 'updateStatus'])->name('tickets.update-status');
    Route::post('/tickets/{ticket}/reply', [\App\Http\Controllers\Admin\AdminTicketController::class, 'reply'])->name('tickets.reply');
    Route::delete('/tickets/{ticket}', [\App\Http\Controllers\Admin\AdminTicketController::class, 'destroy'])->name('tickets.destroy');

    // Licenses
    Route::get('/licenses/export', [\App\Http\Controllers\Admin\AdminLicenseController::class, 'export'])->name('licenses.export');
    Route::post('/licenses/{license}/assign', [\App\Http\Controllers\Admin\AdminLicenseController::class, 'assign'])->name('licenses.assign');
    Route::resource('licenses', \App\Http\Controllers\Admin\AdminLicenseController::class)->only(['index', 'create', 'store', 'destroy']);

    // Reviews
    Route::get('/reviews', [\App\Http\Controllers\Admin\AdminReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{review}/status', [\App\Http\Controllers\Admin\AdminReviewController::class, 'updateStatus'])->name('reviews.update-status');
    Route::delete('/reviews/{review}', [\App\Http\Controllers\Admin\AdminReviewController::class, 'destroy'])->name('reviews.destroy');

    // Settings
    Route::get('/configuracion', [\App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::any('/configuracion/guardar', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');
    Route::post('/configuracion/probar-correo', [\App\Http\Controllers\Admin\SettingsController::class, 'testSendMail'])->name('settings.test-email');

    // Blog
    Route::resource('blog', \App\Http\Controllers\Admin\AdminBlogController::class);

    // Marketing
    Route::get('/marketing', [\App\Http\Controllers\Admin\AdminMarketingController::class, 'create'])->name('marketing.create');
    Route::post('/marketing/send', [\App\Http\Controllers\Admin\AdminMarketingController::class, 'send'])->name('marketing.send');

    // IA / Gemini
    Route::post('/ai/generate-product', [\App\Http\Controllers\Admin\AiController::class, 'generateProductSeo'])->name('ai.generate-product');
    Route::post('/ai/generate-blog', [\App\Http\Controllers\Admin\AiController::class, 'generateBlogSeo'])->name('ai.generate-blog');
});
