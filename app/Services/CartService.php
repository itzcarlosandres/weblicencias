<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\AbandonedCart;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public function getCart(): array
    {
        return Session::get('cart', []);
    }

    public function addItem(Product $product, int $quantity = 1): array
    {
        $cart = $this->getCart();
        $productId = $product->id;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'image' => $product->image,
                'price' => $product->discounted_price,
                'original_price' => $product->price,
                'quantity' => $quantity,
                'type' => $product->type,
            ];
        }

        Session::put('cart', $cart);
        $this->syncAbandonedCart($cart);
        return $cart;
    }

    public function addDiscountedItem(Product $product, int $quantity, float $discountPercentage): array
    {
        $cart = $this->getCart();
        $productId = $product->id;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'image' => $product->image,
                'price' => round($product->discounted_price * (1 - ($discountPercentage / 100)), 2),
                'original_price' => $product->price,
                'quantity' => $quantity,
                'type' => $product->type,
                'is_bundle' => true,
            ];
        }

        Session::put('cart', $cart);
        $this->syncAbandonedCart($cart);
        return $cart;
    }

    public function updateQuantity(int $productId, int $quantity): array
    {
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            if ($quantity <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] = $quantity;
            }
        }

        Session::put('cart', $cart);
        $this->syncAbandonedCart($cart);
        return $cart;
    }

    public function removeItem(int $productId): array
    {
        $cart = $this->getCart();
        unset($cart[$productId]);
        Session::put('cart', $cart);
        $this->syncAbandonedCart($cart);
        return $cart;
    }

    public function clear(): void
    {
        Session::forget('cart');
        $this->syncAbandonedCart([]);
    }

    public function getCount(): int
    {
        return array_sum(array_column($this->getCart(), 'quantity'));
    }

    public function getSubtotal(): float
    {
        return array_reduce($this->getCart(), fn($sum, $item) => $sum + ($item['price'] * $item['quantity']), 0);
    }

    public function getTotal(): float
    {
        $subtotal = $this->getSubtotal();
        $discount = $this->getDiscount();
        $tax = $this->getTax();

        return $subtotal - $discount + $tax;
    }

    public function getDiscount(): float
    {
        return (float) Session::get('coupon_discount', 0);
    }

    public function getTax(): float
    {
        $taxRate = (float) \App\Models\Setting::get('tax_rate', 0);
        $subtotal = $this->getSubtotal();
        return $subtotal * ($taxRate / 100);
    }

    public function applyCoupon(string $code): array
    {
        $coupon = \App\Models\Coupon::where('code', $code)->first();

        if (!$coupon || !$coupon->isValid()) {
            return ['success' => false, 'message' => 'Cupón inválido o expirado'];
        }

        $subtotal = $this->getSubtotal();
        if ($coupon->min_amount && $subtotal < $coupon->min_amount) {
            return ['success' => false, 'message' => 'Monto mínimo no alcanzado: $' . $coupon->min_amount];
        }

        $discount = $coupon->calculateDiscount($subtotal);
        Session::put('coupon_id', $coupon->id);
        Session::put('coupon_discount', $discount);
        Session::put('coupon_code', $coupon->code);

        return ['success' => true, 'message' => 'Cupón aplicado', 'discount' => $discount];
    }

    public function removeCoupon(): void
    {
        Session::forget(['coupon_id', 'coupon_discount', 'coupon_code']);
    }

    public function getCouponCode(): ?string
    {
        return Session::get('coupon_code');
    }

    private function syncAbandonedCart(array $cart): void
    {
        if (Auth::check()) {
            if (empty($cart)) {
                AbandonedCart::where('user_id', Auth::id())->delete();
            } else {
                AbandonedCart::updateOrCreate(
                    ['user_id' => Auth::id()],
                    [
                        'cart_data' => $cart,
                        'last_active_at' => now(),
                        'recovered' => false,
                        'email_sent' => false,
                    ]
                );
            }
        }
    }
}
