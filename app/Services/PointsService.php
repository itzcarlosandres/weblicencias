<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use App\Models\PointTransaction;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class PointsService
{
    public function getPointsPerDollar(): int
    {
        return (int) Setting::get('points_per_dollar', 1);
    }

    public function getRedemptionRate(): int
    {
        return (int) Setting::get('points_redemption_rate', 100);
    }

    public function getDiscountPerRedemption(): float
    {
        return (float) Setting::get('points_discount_per_redemption', 1.00);
    }

    public function getMinPointsToRedeem(): int
    {
        return (int) Setting::get('points_min_redeem', 100);
    }

    public function isEnabled(): bool
    {
        return (bool) Setting::get('points_enabled', true);
    }

    public function awardPoints(User $user, int $points, string $description = '', ?Order $order = null): PointTransaction
    {
        $expiresAt = now()->addDays((int) Setting::get('points_expiry_days', 365));

        $transaction = PointTransaction::create([
            'user_id' => $user->id,
            'type' => 'earned',
            'points' => $points,
            'description' => $description,
            'order_id' => $order?->id,
            'expires_at' => $expiresAt,
        ]);

        $user->increment('points', $points);

        return $transaction;
    }

    public function redeemPoints(User $user, int $points, string $description = '', ?Order $order = null): ?PointTransaction
    {
        if ($points <= 0 || $user->points < $points) {
            return null;
        }

        $transaction = PointTransaction::create([
            'user_id' => $user->id,
            'type' => 'redeemed',
            'points' => -$points,
            'description' => $description,
            'order_id' => $order?->id,
        ]);

        $user->decrement('points', $points);

        return $transaction;
    }

    public function calculatePointsForOrder(float $total): int
    {
        if (!$this->isEnabled()) {
            return 0;
        }

        $pointsPerDollar = $this->getPointsPerDollar();
        return (int) floor($total * $pointsPerDollar);
    }

    public function calculateDiscountForPoints(int $points): float
    {
        $redemptionRate = $this->getRedemptionRate();
        $discountPerRedemption = $this->getDiscountPerRedemption();

        $redemptions = floor($points / $redemptionRate);
        return $redemptions * $discountPerRedemption;
    }

    public function getMaxRedeemablePoints(User $user, float $orderTotal = 0): int
    {
        $available = $user->points;
        $minRedeem = $this->getMinPointsToRedeem();

        if ($available < $minRedeem) {
            return 0;
        }

        $maxDiscount = $orderTotal > 0 ? $orderTotal * 0.5 : PHP_FLOAT_MAX;
        $maxPointsByDiscount = (int) floor($maxDiscount / $this->getDiscountPerRedemption() * $this->getRedemptionRate());

        return min($available, $maxPointsByDiscount);
    }

    public function getTransactionHistory(User $user, int $limit = 20)
    {
        return $user->pointTransactions()
            ->with('order')
            ->latest()
            ->limit($limit)
            ->get();
    }
}
