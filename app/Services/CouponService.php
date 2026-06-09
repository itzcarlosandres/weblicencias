<?php

namespace App\Services;

use App\Models\Order;

class CouponService
{
    public function apply(string $code, float $amount): array
    {
        $coupon = \App\Models\Coupon::where('code', $code)->first();

        if (!$coupon) {
            return ['success' => false, 'message' => 'Cupón no encontrado'];
        }

        if (!$coupon->isValid()) {
            return ['success' => false, 'message' => 'Cupón inválido o expirado'];
        }

        if ($coupon->min_amount && $amount < $coupon->min_amount) {
            return [
                'success' => false,
                'message' => 'El monto mínimo para este cupón es $' . number_format($coupon->min_amount, 2)
            ];
        }

        $discount = $coupon->calculateDiscount($amount);

        return [
            'success' => true,
            'message' => 'Cupón aplicado correctamente',
            'discount' => $discount,
            'coupon' => $coupon,
        ];
    }
}
