<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'logo', 'icon', 'is_active', 'show_on_home'];

    protected static function booted(): void
    {
        static::creating(function (Brand $brand) {
            if (empty($brand->slug)) {
                $brand->slug = Str::slug($brand->name);
            }
        });

        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('active_brands');
            \Illuminate\Support\Facades\Cache::forget('home_brands');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('active_brands');
            \Illuminate\Support\Facades\Cache::forget('home_brands');
        });
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
