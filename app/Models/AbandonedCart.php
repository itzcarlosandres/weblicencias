<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbandonedCart extends Model
{
    protected $fillable = [
        'user_id',
        'cart_data',
        'last_active_at',
        'recovered',
        'email_sent',
    ];

    protected $casts = [
        'cart_data' => 'array',
        'last_active_at' => 'datetime',
        'recovered' => 'boolean',
        'email_sent' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
