<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'order_id', 'buyer_id', 'key', 'status',
        'sold_at', 'used_at', 'revealed_at'
    ];

    protected $casts = [
        'sold_at' => 'datetime',
        'used_at' => 'datetime',
        'revealed_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeSold($query)
    {
        return $query->where('status', 'sold');
    }

    public function markAsSold(Order $order, User $buyer): void
    {
        $this->update([
            'order_id' => $order->id,
            'buyer_id' => $buyer->id,
            'status' => 'sold',
            'sold_at' => now(),
        ]);
    }

    public function getIsRevealedAttribute(): bool
    {
        return !is_null($this->revealed_at);
    }
}
