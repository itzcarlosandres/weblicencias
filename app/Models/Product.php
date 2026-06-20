<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'brand_id', 'name', 'slug', 'sku', 'type',
        'description', 'important_note', 'content', 'image', 'gallery',
        'price', 'compare_price', 'discount', 'stock', 'sold_count',
        'is_featured', 'is_bundle', 'is_bestseller', 'is_top_deal', 'is_flash_sale', 'flash_sale_end', 'is_active', 'min_price', 'max_price',
        'meta_title', 'meta_description', 'platform', 'region',
        'activation_method', 'delivery_time', 'warranty_days',
        'badge_id'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'discount' => 'decimal:2',
        'gallery' => 'array',
        'is_featured' => 'boolean',
        'is_bundle' => 'boolean',
        'is_bestseller' => 'boolean',
        'is_top_deal' => 'boolean',
        'is_flash_sale' => 'boolean',
        'flash_sale_end' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = strtoupper(substr(uniqid(), -8));
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function licenses(): HasMany
    {
        return $this->hasMany(License::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlistUsers(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function badge(): BelongsTo
    {
        return $this->belongsTo(Badge::class);
    }

    public function getAvailableStockAttribute(): int
    {
        return $this->licenses()->where('status', 'available')->count();
    }

    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->where('is_approved', true)->avg('rating') ?? 0, 1);
    }

    public function getDiscountedPriceAttribute(): float
    {
        $discount = $this->discount;
        if ($this->is_top_deal && $discount < 15) {
            $discount = 15;
        }

        if ($discount > 0) {
            return round($this->price - ($this->price * $discount / 100), 2);
        }

        // Si no hay % de descuento pero compare_price > price, el precio de venta ES el price
        return (float) $this->price;
    }

    public function getHasDiscountAttribute(): bool
    {
        // Hay descuento si:
        // 1. Tiene un % de descuento configurado, O
        // 2. El compare_price (precio tachado) es mayor que el price (precio de venta)
        $hasPercentDiscount = ($this->discount > 0 || $this->is_top_deal);
        $hasComparePrice    = ($this->compare_price && $this->compare_price > $this->price);
        return $hasPercentDiscount || $hasComparePrice;
    }

    public function getEffectiveDiscountAttribute(): float
    {
        if ($this->discount > 0 || $this->is_top_deal) {
            return $this->is_top_deal && $this->discount < 15 ? 15 : (float) $this->discount;
        }
        // Calcular % desde compare_price si aplica
        if ($this->compare_price > $this->price) {
            return round((($this->compare_price - $this->price) / $this->compare_price) * 100);
        }
        return 0;
    }

    public function getFormattedPriceAttribute(): string
    {
        return \App\Services\CurrencyService::format($this->price);
    }

    public function getFormattedDiscountedPriceAttribute(): string
    {
        return \App\Services\CurrencyService::format($this->discounted_price);
    }

    public function getFormattedComparePriceAttribute(): string
    {
        return \App\Services\CurrencyService::format($this->compare_price);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeTopDeals($query)
    {
        return $query->where('is_top_deal', true);
    }
}
