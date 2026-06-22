<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $activeTab = $request->query('tab', 'general');
        $saved = $request->session()->get('_settings_saved', false);

        return view('admin.settings.index', [
            'settings' => $settings,
            'activeTab' => $activeTab,
            'saved' => $saved,
        ]);
    }

    public function update(Request $request)
    {
        $activeTab = $request->input('tab', 'general');

        // Always fetch current COP rate from API when currency is COP
        if ($request->input('currency') === 'COP') {
            \App\Services\CurrencyService::refreshRate();
        }

        // Logo upload
        if ($request->hasFile('logo')) {
            $old = Setting::get('logo');
            if ($old) Storage::disk('public')->delete('settings/' . $old);
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('settings', $filename, 'public');
            Setting::set('logo', $filename, 'appearance');
        }

        // Favicon upload
        if ($request->hasFile('favicon')) {
            $old = Setting::get('favicon');
            if ($old) Storage::disk('public')->delete('settings/' . $old);
            $file = $request->file('favicon');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('settings', $filename, 'public');
            Setting::set('favicon', $filename, 'appearance');
        }

        // Save all text fields
        $fields = [
            // General
            'site_name', 'site_tagline', 'site_description', 'contact_email', 'contact_phone', 'contact_whatsapp',
            'currency', 'currency_symbol', 'exchange_rate_cop',
            'home_grid_columns', 'home_featured_count', 'catalog_grid_columns',
            'product_page_max_width', 'product_description_collapse_height', 'home_brands_count',
            // SEO
            'meta_title', 'meta_description', 'meta_keywords', 'header_code', 'footer_text', 'faq_content', 'help_center_content',
            // Appearance
            'primary_color', 'hero_badge', 'hero_title', 'hero_subtitle',
            'hero_description', 'hero_feature_1', 'hero_feature_2', 'hero_feature_3',
            // Announcements
            'announcement_enabled', 'announcement_mode', 'announcement_text',
            'announcement_link', 'announcement_color',
            // Exit Intent
            'exit_intent_enabled', 'exit_intent_title', 'exit_intent_text',
            'exit_intent_coupon', 'exit_intent_timer',
            // Points & Cashback
            'points_enabled', 'points_per_dollar', 'points_redemption_rate',
            'points_discount_per_redemption', 'points_min_redeem', 'points_expiry_days',
            'cashback_percentage',
            // Referrals
            'referral_welcome_points', 'referral_reward_points',
            // Payment
            'payment_paypal_enabled', 'payment_mercadopago_enabled', 
            'mercadopago_access_token', 'mercadopago_public_key',
            'payment_wompi_enabled',
            'wompi_public_key', 'wompi_private_key', 'wompi_events_secret', 'wompi_sandbox_mode',
            // AI
            'gemini_api_key',
            // Mail
            'mail_host', 'mail_port', 'mail_username', 'mail_password',
            'mail_encryption', 'mail_from_address',
        ];

        foreach ($fields as $field) {
            $value = $request->input($field);
            // Skip exchange_rate_cop when currency is COP - we already fetched fresh rate above
            if ($field === 'exchange_rate_cop' && $request->input('currency') === 'COP') {
                continue;
            }
            if ($request->has($field)) {
                Setting::set($field, $value, $this->groupFor($field));
            }
        }

        return redirect()
            ->to('/admin/configuracion?tab=' . $activeTab . '&saved=1#top')
            ->with('_settings_saved', true);
    }

    public function testSendMail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'type' => 'required|string',
        ]);

        $targetEmail = $request->input('email');
        $type = $request->input('type');

        try {
            // Obtener o crear un usuario de prueba
            $user = \App\Models\User::where('email', $targetEmail)->first();
            if (!$user) {
                $user = \App\Models\User::first();
                if ($user) {
                    $user = clone $user;
                    $user->email = $targetEmail;
                } else {
                    $user = new \App\Models\User([
                        'name' => 'Usuario de Prueba',
                        'email' => $targetEmail,
                    ]);
                }
            }

            // Obtener o crear un producto de prueba
            $product = \App\Models\Product::first();
            if (!$product) {
                $product = new \App\Models\Product([
                    'name' => 'Windows 11 Professional Key',
                    'price' => 19.99,
                    'compare_price' => 24.99,
                    'discount' => 20.00,
                    'sku' => 'WIN11PRO-TEST',
                    'is_active' => true,
                    'slug' => 'windows-11-pro-test',
                ]);
            }

            switch ($type) {
                case 'welcome':
                    \Illuminate\Support\Facades\Mail::to($targetEmail)->send(new \App\Mail\WelcomeEmail($user));
                    $msg = 'Correo de Bienvenida enviado con éxito.';
                    break;

                case 'order':
                    $order = \App\Models\Order::where('user_id', $user->id)->first() ?? \App\Models\Order::first();
                    if (!$order) {
                        $order = new \App\Models\Order([
                            'user_id' => $user->id,
                            'order_number' => 'ORD-TEST1234',
                            'total' => 19.99,
                            'status' => 'completed',
                        ]);
                        $order->setRelation('user', $user);
                    }
                    if ($order->items()->count() === 0) {
                        $order->setRelation('items', collect([
                            new \App\Models\OrderItem([
                                'product_id' => $product->id,
                                'quantity' => 1,
                                'price' => 19.99,
                            ])
                        ]));
                    }
                    \Illuminate\Support\Facades\Mail::to($targetEmail)->send(new \App\Mail\OrderDelivered($order));
                    $msg = 'Correo de Orden Entregada enviado con éxito.';
                    break;

                case 'license':
                    $license = \App\Models\License::where('product_id', $product->id)->first();
                    if (!$license) {
                        $license = new \App\Models\License([
                            'product_id' => $product->id,
                            'key' => 'AAAAA-BBBBB-CCCCC-DDDDD-EEEEE',
                            'status' => 'available',
                        ]);
                        $license->setRelation('product', $product);
                    }
                    \Illuminate\Support\Facades\Mail::to($targetEmail)->send(new \App\Mail\LicenseManuallyAssignedMail($license));
                    $msg = 'Correo de Licencia Asignada enviado con éxito.';
                    break;

                case 'marketing':
                    \Illuminate\Support\Facades\Mail::to($targetEmail)->send(new \App\Mail\MarketingEmail(
                        '¡Oferta Especial de Fin de Semana!',
                        'Ahorra un 15% adicional',
                        'Usa el cupón FINDE15 en tu próxima compra y obtén un descuento instantáneo en cualquier licencia de nuestro catálogo.',
                        'Ir a la Tienda',
                        url('/')
                    ));
                    $msg = 'Correo de Marketing enviado con éxito.';
                    break;

                case 'abandoned_cart':
                    $abandonedCart = new \App\Models\AbandonedCart();
                    $abandonedCart->user_id = $user->id;
                    $abandonedCart->cart_data = [
                        [
                            'name' => $product->name,
                            'quantity' => 1,
                            'price' => $product->price
                        ]
                    ];
                    $abandonedCart->setRelation('user', $user);
                    \Illuminate\Support\Facades\Mail::to($targetEmail)->send(new \App\Mail\AbandonedCartMail($abandonedCart));
                    $msg = 'Correo de Carrito Abandonado enviado con éxito.';
                    break;

                case 'stock':
                    \Illuminate\Support\Facades\Mail::to($targetEmail)->send(new \App\Mail\ProductInStockMail($product));
                    $msg = 'Correo de Notificación de Stock enviado con éxito.';
                    break;

                case 'referral':
                    $referredDummy = new \App\Models\User(['name' => 'Amigo Referido']);
                    \Illuminate\Support\Facades\Mail::to($targetEmail)->send(new \App\Mail\ReferralRewardMail($user, $referredDummy, 1000));
                    $msg = 'Correo de Recompensa por Referido enviado con éxito.';
                    break;

                case 'price_drop':
                    \Illuminate\Support\Facades\Mail::to($targetEmail)->send(new \App\Mail\WishlistPriceDropMail($product, 24.99, 19.99));
                    $msg = 'Correo de Baja de Precio enviado con éxito.';
                    break;

                default:
                    throw new \Exception('Tipo de correo no válido.');
            }

            return response()->json([
                'success' => true,
                'message' => $msg
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar el correo: ' . $e->getMessage()
            ], 500);
        }
    }

    private function groupFor(string $field): string
    {
        $map = [
            'site_name' => 'general', 'site_tagline' => 'general', 'site_description' => 'general',
            'contact_email' => 'general', 'contact_phone' => 'general', 'contact_whatsapp' => 'general', 'currency' => 'general',
            'currency_symbol' => 'general', 'exchange_rate_cop' => 'general',
            'home_grid_columns' => 'general', 'home_featured_count' => 'general', 'home_brands_count' => 'general', 'catalog_grid_columns' => 'general',
            'product_page_max_width' => 'general', 'product_description_collapse_height' => 'general',
            'meta_title' => 'seo', 'meta_description' => 'seo', 'meta_keywords' => 'seo', 'header_code' => 'seo', 'footer_text' => 'seo', 'faq_content' => 'general', 'help_center_content' => 'general',
            'primary_color' => 'appearance', 'hero_badge' => 'appearance', 'hero_title' => 'appearance',
            'hero_subtitle' => 'appearance', 'hero_description' => 'appearance',
            'hero_feature_1' => 'appearance', 'hero_feature_2' => 'appearance', 'hero_feature_3' => 'appearance',
            'logo' => 'appearance', 'favicon' => 'appearance',
            'announcement_enabled' => 'appearance', 'announcement_mode' => 'appearance',
            'announcement_text' => 'appearance', 'announcement_link' => 'appearance', 'announcement_color' => 'appearance',
            'exit_intent_enabled' => 'appearance', 'exit_intent_title' => 'appearance',
            'exit_intent_text' => 'appearance', 'exit_intent_coupon' => 'appearance', 'exit_intent_timer' => 'appearance',
            'points_enabled' => 'points', 'points_per_dollar' => 'points', 'points_redemption_rate' => 'points',
            'points_discount_per_redemption' => 'points', 'points_min_redeem' => 'points', 'points_expiry_days' => 'points',
            'cashback_percentage' => 'points',
            'referral_welcome_points' => 'points', 'referral_reward_points' => 'points',
            'payment_paypal_enabled' => 'payment', 'payment_mercadopago_enabled' => 'payment',
            'mercadopago_access_token' => 'payment', 'mercadopago_public_key' => 'payment',
            'payment_wompi_enabled' => 'payment', 'wompi_public_key' => 'payment',
            'wompi_private_key' => 'payment', 'wompi_events_secret' => 'payment', 'wompi_sandbox_mode' => 'payment',
            'gemini_api_key' => 'ai',
            'mail_host' => 'emails', 'mail_port' => 'emails', 'mail_username' => 'emails',
            'mail_password' => 'emails', 'mail_encryption' => 'emails', 'mail_from_address' => 'emails',
        ];
        return $map[$field] ?? 'general';
    }
}